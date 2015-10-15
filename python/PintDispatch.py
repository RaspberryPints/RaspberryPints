#!/usr/bin/python

import threading
import time
import signal
import sys
import os
import struct
import socket
import RPi.GPIO as GPIO
import MySQLdb as mdb
from FlowMonitor import FlowMonitor
from threading import Timer
import SocketServer
import pprint
import serial
from sys import stdin
from mod_pywebsocket.standalone import WebSocketServer
from mod_pywebsocket.standalone import _parse_args_and_config
from mod_pywebsocket.standalone import _configure_logging

from Config import config

PINTS_DIR               = config['pints.dir' ]
INCLUDES_DIR            = PINTS_DIR + "/includes"
PYTHON_DIR              = PINTS_DIR + "/python"
PYTHON_WSH_DIR          = PYTHON_DIR + "/ws"
ADMIN_DIR               = PINTS_DIR + "/admin"
ADMIN_INCLUDES_DIR      = ADMIN_DIR + "/includes"

# mcast group and port to send flow and valve updates to
MCAST_GRP = '224.1.1.1'
MCAST_PORT = 0xBEE2

OPTION_RESTART_FANTIMER_AFTER_POUR = config['dispatch.restart_fan_after_pour']

def debug(msg):
    if(config['dispatch.debug']):
        print "RPINTS: " + msg
        sys.stdout.flush()
                 
def log(msg):
    print "RPINTS: " + msg
    sys.stdout.flush() 
    
class CommandTCPHandler(SocketServer.StreamRequestHandler):

    def handle(self):
        self.data = self.rfile.readline().strip()
        
        if not self.data:
            self.wfile.write("RPNAK\n")
            return
        
        reading = self.data.split(":")
        if ( len(reading) < 2 ):
            log( "Unknown message: "+ self.data)
            self.wfile.write("RPNAK\n")
            return
        if(reading[0] == "RPC"): # reconfigure
            debug("reconfigure trigger: " + reading[1])
            if ( reading[1] == "valve" ):
                debug("updating valve status from db")
                self.server.pintdispatch.updateValvePins()
            if ( reading[1] == "fan" ):
                debug("updating fan status from db")
                self.server.pintdispatch.resetFanConfig()
            if ( reading[1] == "config" ):
                debug("triggering config update refresh")
                self.server.pintdispatch.sendconfigupdate()
            if ( reading[1] == "flow" ):
                debug("updating flow meter config from db")
                self.server.pintdispatch.updateFlowmeterConfig()
            if ( reading[1] == "alamode" ):
                debug("resetting alamode config from db")
                self.server.pintdispatch.triggerAlaModeReset()
        
        self.wfile.write("RPACK\n")

# override server_bind method to ensure that the tcp port can be reconnected to when server is killed 
class CommandTCPServer(SocketServer.TCPServer):
    def server_bind(self):
        self.socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.socket.bind(self.server_address)
        
# main class, handles comm between flow mon, multicast connection, tcp command server and GPIO
class PintDispatch(object):
    
    def __init__(self):
        GPIO.setwarnings(False)
        GPIO.setmode(GPIO.BCM) # Broadcom pin-numbering scheme
        self.alaModeReconfig = False;

        #multicast socket
        self.mcast = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_LOOP, 1)

        mreq = struct.pack("4sl", socket.inet_aton(MCAST_GRP), socket.INADDR_ANY)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)
        
        self.flowmonitor = FlowMonitor(self)
        self.fanTimer = None
        self.updateFlowmeterConfig()
        self.updateValvePins()
        
        self.commandserver = CommandTCPServer(('localhost', MCAST_PORT), CommandTCPHandler)
        self.commandserver.pintdispatch = self
    
    def parseConnFile(self):
        connFileName = ADMIN_INCLUDES_DIR + "/conn.php"
        connDict = dict()
        with open(connFileName) as connFile:
            for line in connFile:
                instructions = line.split(";")
                if(len(instructions) < 1):
                    continue
                php = instructions[0].strip()
                php = php.strip("$")
                keyValue = php.split("=")
                if(len(keyValue) != 2):
                    continue
                connDict[keyValue[0]] = keyValue[1].strip("\"")
        return connDict
    
    def connectDB(self):
        cp = self.parseConnFile()
        con = mdb.connect(cp['host'],cp['username'],cp['password'],cp['db_name'])
        return con
    
    def getConfig(self):
        con = self.connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT * from config")
        rows = cursor.fetchall()
        con.close()
        return rows

    def getTapConfig(self):
        con = self.connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT tapNumber,flowPin,valvePin,valveOn FROM tapconfig ORDER BY tapNumber")
        rows = cursor.fetchall()
        con.close()
        return rows
    
    def getFanConfig(self):
        pin = self.getFanPin()
        if (pin < 0):
            return
        fanOnTimeItem = self.getConfigItem("fanOnTime")
        if(fanOnTimeItem is None):
            return None
        fanIntervalItem = self.getConfigItem("fanInterval")
        if(fanIntervalItem is None):
            return None
        interval = int(fanIntervalItem["configValue"])
        onTime = int(fanOnTimeItem["configValue"])
        return pin, interval, onTime
    
    def fanStart(self):
        pin = self.getFanPin()
        if pin < 1:
            return
        if self.updatepin(pin, 1):
            self.sendfanupdate(pin, 1)
        
    def fanStartTimer(self):
        debug( "starting fan timer" )
        
        fanConfig = self.getFanConfig()
        if fanConfig is None:
            debug( "starting fan timer - no config?" )
            return
        
        if self.fanTimer is not None:
            debug( "starting fan timer - cancelling running timer" )
            self.fanTimer.cancel()
        
        #all times are in minutes
        time = fanConfig[2]
        #don't turn on if no time set (set to 0 or less)
        if (time < 1):
            return
        pin = fanConfig[0]
        self.fanTimer = Timer(time * 60, self.fanStopTimer)
        self.fanTimer.daemon=True
        self.fanTimer.start()
        debug( "starting fan timer - updating pin" )
        self.fanStart()
        
    def fanStop(self):
        pin = self.getFanPin()
        if pin < 1:
            return
        if self.updatepin(pin, 0):
            self.sendfanupdate(pin, 0)
                
    def fanStopTimer(self):
        debug( "stopping fan timer" )
        fanConfig = self.getFanConfig()
        if fanConfig is None:
            debug( "stopping fan timer - no config?" )
            return
        
        #all times are in minutes
        pin = fanConfig[0]
        interval = fanConfig[1]
        time = fanConfig[2]
        
        # don't turn off 
        if(interval <= time):
            debug( "stopping fan timer - interval less than time, exiting" )
            return
        
        if self.fanTimer is not None:
            debug( "stopping fan timer - cancelling running timer" )
            self.fanTimer.cancel()
        self.fanTimer = Timer((interval - time) * 60, self.fanStartTimer)
        self.fanTimer.daemon=True
        self.fanTimer.start()
        debug( "stopping fan timer - updating pin" )
        self.fanStop()
    
    def resetFanConfig(self):
        self.fanStartTimer()
            
    # check if we're exceeding the pour threshold
    def sendflowupdate(self, pin, count):
        if( self.pourShutOffCount > 10 ) and ( int(count) > self.pourShutOffCount ):
            if self.useOption("useTapValves"):
                debug( "too long a pour, shutting down tap with flow pin " + str(pin) + ", count: " + str(count) + ", shut off: " + str(self.pourShutOffCount) )
                self.shutDownTap(pin)
        
    # check if we're exceeding the pour threshold
    def sendkickupdate(self, pin):
        if self.useOption("useTapValves"):
            debug( "keg kicked, shutting down tap with flow pin " + str(pin) )
            self.kickTap(pin)
            
    # send a mcast flow update
    def sendflowcount(self, pin, count):
        if OPTION_RESTART_FANTIMER_AFTER_POUR:
            debug( "restarting fan timer after pour" )
            self.fanStartTimer()
        msg = "RPU:FLOW:" + str(pin) + "=" + str(count)
        debug("broadcast update: "  + msg.rstrip())
        self.mcast.sendto(msg + "\n", (MCAST_GRP, MCAST_PORT))
        
    # send a mcast valve/pin update
    def sendvalveupdate(self, pin, value):
        msg = "RPU:VALVE:" + str(pin) + "=" + str(value)
        debug("broadcast update: "  + msg.rstrip())
        self.mcast.sendto(msg + "\n", (MCAST_GRP, MCAST_PORT))
        
    # send a mcast fan update
    def sendfanupdate(self, pin, value):
        msg = "RPU:FAN:" + str(pin) + "=" + str(value)
        debug("broadcast update: "  + msg.rstrip())
        self.mcast.sendto(msg + "\n", (MCAST_GRP, MCAST_PORT))
        
    # send a mcast fan update
    def sendconfigupdate(self,):
        debug("broadcast update: "  +  "RPU:CONFIG")
        self.mcast.sendto("RPU:CONFIG\n", (MCAST_GRP, MCAST_PORT))
        
    # start running the flow monitor in it's own thread
    def spawn_flowmonitor(self):
        while True:
            try:
                self.flowmonitor.monitor()
            except Exception, e:
                log("serial connection stopped...")
                debug( str(e) )
            finally:
                time.sleep(1)
                log("flowmonitor aborted, restarting...")
                

    def spawnWebSocketServer(self):
        args = ["-p", "8081", "-d", "/var/www/python/ws"]
        options, args = _parse_args_and_config(args=args)
        options.cgi_directories = []
        options.is_executable_method = None
        os.chdir(options.document_root)
        _configure_logging(options)        
        server = WebSocketServer(options)
        server.serve_forever()

    # main setup
    def setup(self):
        # need small delay to get logging going, otherwise first log entries are missing
        time.sleep(2)
        debug("starting setup...")
        self.flowmonitor.setup()
        
    # main start method
    def start(self):

        log("starting WS server")
        t = threading.Thread(target=self.spawnWebSocketServer)
        t.setDaemon(True)
        t.start()

        if self.useOption("useFlowMeter"):
            log("starting tap flow meters...")
            t = threading.Thread(target=self.spawn_flowmonitor)
            t.setDaemon(True)
            t.start()
        else:
            log("tap flow meters not enabled")
            
        if self.useOption("useFanControl"):
            log("starting kegerator fan control...")
            self.fanStartTimer()
        else:
            log("kegerator fan control not enabled")

        log("starting command server")
        t = threading.Thread(target=self.commandserver.serve_forever)
        t.setDaemon(True)
        t.start()

        signal.pause()
        debug( "exiting...")
#        stdin.readline()

    def shutDownTap(self, flowPin):
        
        taps = self.getTapConfig();
        for tap in taps:
            if(int(tap["flowPin"]) == int(flowPin)):
                
                if self.useOption("useTapValves"):
                    valvePin = int(tap["valvePin"])
                    self.updatepin(valvePin, 0) 
                
                sql = "UPDATE tapconfig SET valveOn=0 WHERE tapNumber=" +  str(tap["tapNumber"])
                # update db
                con = self.connectDB()
                cursor = con.cursor(mdb.cursors.DictCursor)
                result = cursor.execute(sql)
                con.commit()
                con.close()
                # update browsers
                self.sendvalveupdate(valvePin, 0)

    # 
    def triggerAlaModeReset(self):
        self.alaModeReconfig = True;
        
    # check if something got changed which requires reset/reconfigure of alamode
    def needAlaModeReconfig(self):
        return self.alaModeReconfig
                    
    # reset the alamode by tripping it's reset line
    def resetAlaMode(self):
        self.alaModeReconfig = False;
        resetpin = 18

        GPIO.setup(int(resetpin), GPIO.OUT)
        oldValue = GPIO.input(resetpin)
        if (oldValue == 1):
            value1 = 0
        else:
            value1 = 1
            
        self.updatepin(resetpin, value1)
        time.sleep(1)
        self.updatepin(resetpin, oldValue)
    
    def kickTap(self, flowPin):
        
        taps = self.getTapConfig();
        for tap in taps:
            if(int(tap["flowPin"]) == int(flowPin)):
                
                if self.useOption("useTapValves"):
                    valvePin = int(tap["valvePin"])
                    self.updatepin(valvePin, 0) 

                tapNumber = int(tap["tapNumber"])
                
                
                con = self.connectDB()
                cursor = con.cursor(mdb.cursors.DictCursor)
                
                sql = "SELECT id from taps WHERE tapNumber=" +  str(tapNumber) + " AND active=1"
                cursor.execute(sql)
                id = int(cursor.fetchall()[0]["id"])

                sql = "UPDATE tapconfig SET valveOn=0 WHERE tapNumber=" +  str(tapNumber)
                result = cursor.execute(sql)
                con.commit()
                
                sql="UPDATE taps SET active=0 WHERE id=" + str(id)
                debug(sql)
                result = cursor.execute(sql)
                con.commit()
                
                sql="UPDATE kegs k, taps t SET k.kegStatusCode = 'NEEDS_CLEANING' WHERE t.kegId = k.id AND t.Id = " + str(id) 
                result = cursor.execute(sql)
                con.commit()
                
                con.close()
                # update browsers
                # give it a small break, most likely a pour refresh is still going on, and this update will be missed
                time.sleep(1)
                self.sendvalveupdate(valvePin, 0)
    
    # update PI gpio pin (either turn on or off), this requires that this is run as root 
    def updatepin(self, pin, value):
        if (pin < 1):
            debug("invalid pin " + str(pin))
            return False
        
        GPIO.setup(int(pin), GPIO.OUT)
        oldValue = GPIO.input(pin)
        if(oldValue != value):
            debug( "update pin %s from %s to %s" %(pin, oldValue, value))
            if int(value) == 0 :
                GPIO.output(int(pin), GPIO.LOW)
            else:
                GPIO.output(int(pin), GPIO.HIGH)
            return True
        return False

    def updateValvePins(self):
        taps = self.getTapConfig()
        for tap in taps:
            if(tap["valveOn"] is None):
                tap["valveOn"] = 0
                
            pin = int(tap["valvePin"])
            pinNewValue = int(tap["valveOn"])
            if self.updatepin(pin, pinNewValue):
                self.sendvalveupdate(pin, pinNewValue)
    
    def getConfigItem(self, itemName):
        config = self.getConfig()
        for item in config:
            if (item["configName"] == itemName):
                return item
        return None
           
    def updateFlowmeterConfig(self):
        pourCountConversionItem = self.getConfigItem("pourCountConversion")
        if(pourCountConversionItem is None):
            self.pourCountConversion = 0;
        else:
            self.pourCountConversion = int(pourCountConversionItem["configValue"])
            
        pourShutOffCountItem = self.getConfigItem("pourShutOffCount")
        if(pourShutOffCountItem is None):
            self.pourShutOffCount = 0;
        else:
            self.pourShutOffCount = int(pourShutOffCountItem["configValue"])

    
    def useOption(self, option):
        cfItem = self.getConfigItem(option)
        if cfItem is None:
            return False
        cfUse = cfItem["configValue"]
        if(int(cfUse) == 1):
            return True
        return False
    
    def getFanPin(self):
        if self.useOption("useFanControl"):
            fanItem = self.getConfigItem("useFanPin")
            if fanItem is not None:
                return int(fanItem["configValue"])
        return -1

        
dispatch = PintDispatch()
dispatch.setup()
dispatch.start()
debug( "Exiting...")
