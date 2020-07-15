#!/usr/bin/python
# ----------------------------------------------------------------------------
# "THE BEER-WARE LICENSE" (Revision 42 3/4):
# <thomas@hentschel.net> wrote this file. As long as you retain this notice you
#  can do whatever you want with this stuff. If we meet some day, and you think
#  this stuff is worth it, you can buy me a beer in return 
# -Th
#  ----------------------------------------------------------------------------
  
import threading
import time
import signal
import sys
import os
import struct
import socket
import MySQLdb as mdb
from FlowMonitor import FlowMonitor
from threading import Timer
from threading import Lock
import SocketServer
import pprint
import serial
import datetime
from sys import stdin
from mod_pywebsocket.standalone import WebSocketServer
from mod_pywebsocket.standalone import _parse_args_and_config
from mod_pywebsocket.standalone import _configure_logging
import subprocess

from Config import config

GPIO_IMPORT_SUCCESSFUL = True
try:
    import RPi.GPIO as GPIO
except:
    GPIO_IMPORT_SUCCESSFUL = False


PINTS_DIR               = config['pints.dir' ]
INCLUDES_DIR            = PINTS_DIR + "/includes"
PYTHON_DIR              = PINTS_DIR + "/python"
PYTHON_WSH_DIR          = PYTHON_DIR + "/ws"
ADMIN_DIR               = PINTS_DIR + "/admin"
ADMIN_INCLUDES_DIR      = ADMIN_DIR + "/includes"

# mcast group and port to send flow and valve updates to
MCAST_GRP = '224.1.1.1'
MCAST_PORT = 0xBEE2
MCAST_RETRY_ATTEMPTS = 10
MCAST_RETRY_SLEEP_SEC=5

def debug(msg, process="PintDispatch", logDB=True):
    logger = Logger()
    logger.debug(msg, process, logDB)
                 
def log(msg, process="PintDispatch", isDebug=False, logDB=True):
    logger = Logger()
    logger.log(msg, process, isDebug, logDB)
   
def parseConnFile():
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
dbArgs=parseConnFile()
def connectDB():
    while True:
        try:
            con = mdb.connect(dbArgs['host'],dbArgs['username'],dbArgs['password'],dbArgs['db_name'])
            break
        except:
            debug(msg="Database Connection Lost, retrying", process="PintDispatch", logDB=False)
            time.sleep(1)
        
    return con

loggerLastClean = None
class Logger ():
    def debug(self, msg, process="PintDispatch", logDB=True):
        if(config['dispatch.debug']):
            self.log(msg, process, True, logDB)
                     
    def log(self, msg, process="PintDispatch", isDebug=False, logDB=True):
        print datetime.datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S') + " RPINTS: " + msg 
        sys.stdout.flush() 
        if logDB:
            self.logDB(msg, process, isDebug)
        
    def logDB(self, msg, process="PintDispatch", isDebug=False):
        max_row_check = 2
        category = ("I" if not isDebug else "D")
        selectLastSql = "SELECT id, category, text, occurances FROM log WHERE process = '"+process+"' ORDER BY id DESC LIMIT "+str(max_row_check)
        updateLastSql = "UPDATE log SET occurances = occurances + 1, modifiedDate = NOW() WHERE id = "
        insertLogSql = " "
        insertLogSql += ""
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute(selectLastSql)
        rows = cursor.fetchall()
        ii = 0
        while( ii < len(rows) ):
            if( str(rows[ii]['text']) == msg and str(rows[ii]['category']) == category):
                if( rows[ii]['occurances'] < 999999999 ):
                    result = cursor.execute(updateLastSql + str(rows[ii]['id']))   
                    break;
            ii = ii + 1   
        #if we exited the loop normally then we didnt find a record to update occurences add this to the database
        if ii >= len(rows):
            result = cursor.execute("INSERT INTO log (process, category, text, createdDate, modifiedDate) VALUES(%s, %s, %s ,NOW(),NOW());", (process, category, msg,))
        self.cleanLog(cursor)     
        con.commit()
        con.close()
        
    def cleanLog(self, cursor):
        global loggerLastClean
        if loggerLastClean is None or loggerLastClean != datetime.date.today():
            cursor.execute("DELETE FROM log WHERE modifiedDate <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)")
            loggerLastClean = datetime.date.today()
    
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
            if ( reading[1] == "alamode" or reading[1] == "all" ):
                debug("resetting alamode config from db")
                self.server.pintdispatch.triggerAlaModeReset()
            if ( reading[1] == "tare" ):
                debug("Requesting Load Cells to check tare")
                self.server.pintdispatch.flowmonitor.tareRequest()
            if ( reading[1] == "tempProbe" ):
                debug("Requesting Reset of Temp Probes")
                self.server.pintdispatch.flowmonitor.reconfigTempProbes()
            if ( reading[1] == "shutdown" ):
                log("Requesting Pi ShutDown")
                self.server.pintdispatch.shutdown()
            if ( reading[1] == "restart" ):
                log("Requesting Pi Restart")
                self.server.pintdispatch.restart()
            if ( reading[1] == "restartservice" ):
                debug("Requesting Reset of Service")
                self.server.pintdispatch.restartService()
            if ( reading[1] == "upgrade" ):
                debug("Upgrading Rpints")
                self.server.pintdispatch.upgrade("")
            if ( reading[1] == "upgradeForce" ):
                debug("Upgrading Rpints")
                self.server.pintdispatch.upgrade("force")
        
        self.wfile.write("RPACK\n")

# override server_bind method to ensure that the tcp port can be reconnected to when server is killed 
class CommandTCPServer(SocketServer.TCPServer):
    def server_bind(self):
        self.socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.socket.bind(self.server_address)
        
# main class, handles comm between flow mon, multicast connection, tcp command server and GPIO
class PintDispatch(object):
    
    def __init__(self):
        self.OPTION_USE_3_WIRE_VALVES = self.getConfigValueByName("use3WireValves")
        self.OPTION_RESTART_FANTIMER_AFTER_POUR = self.getConfigValueByName("restartFanAfterPour")
        setupSocket = MCAST_RETRY_ATTEMPTS
        if GPIO_IMPORT_SUCCESSFUL:
            GPIO.setwarnings(False)
            GPIO.setmode(GPIO.BOARD) # Broadcom pin-numbering scheme
        self.alaModeReconfig = False;

        while setupSocket > 0:
            try:
                #multicast socket
                self.mcast = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
                self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_LOOP, 1)

                mreq = struct.pack("4sl", socket.inet_aton(MCAST_GRP), socket.INADDR_ANY)    
                self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)
                
                setupSocket = 0
            except socket.error as msg:
                setupSocket = setupSocket - 1
                log(msg.strerror + " - Sleeping to try again")
                time.sleep(MCAST_RETRY_SLEEP_SEC)
                        
        if setupSocket == MCAST_RETRY_ATTEMPTS:
            log(str(setupSocket))
            log("FATAL: Unable to setup socket")
            quit()
            
        self.valvesState = []
        self.fanTimer = None
        self.valvePowerTimer = None
        if int(self.OPTION_USE_3_WIRE_VALVES) == 1:
            self.valvePowerTimer = Timer(OPTION_VALVEPOWERON, self.valveStopPower)
    
        self.updateFlowmeterConfig()
        self.updateValvePins()
        
        self.commandserver = CommandTCPServer(('localhost', MCAST_PORT), CommandTCPHandler)
        self.commandserver.pintdispatch = self
        self.fanControl = FanControlThread("fanControl1", self)
        self.flowmonitor = FlowMonitor(self, Logger())
        
    def getConfig(self):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT * from config")
        rows = cursor.fetchall()
        con.close()
        return rows
    
    def getConfigValueByName(self, name):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT configValue from config WHERE configName='"+name+"'")
        rows = cursor.fetchall()
        con.close()
        if len(rows) == 0:
            return None
        return rows[0]['configValue']

    def getTapConfig(self):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT tc.tapId,tc.flowPin,tc.valvePin,tc.valveOn FROM tapconfig tc LEFT JOIN taps t ON tc.tapId = t.id WHERE t.active = 1 ORDER BY tc.tapId")
        rows = cursor.fetchall()
        con.close()
        return rows
    
    def getRFIDReaders(self):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT * from rfidReaders ORDER BY priority")
        rows = cursor.fetchall()
        con.close()
        return rows
    
    def getMotionDetectors(self):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT * from motionDetectors ORDER BY priority")
        rows = cursor.fetchall()
        con.close()
        return rows
    
    def getLoadCellConfig(self):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT tapId,loadCellCmdPin,loadCellRspPin,loadCellUnit,loadCellScaleRatio,loadCellTareOffset FROM tapconfig WHERE loadCellCmdPin IS NOT NULL ORDER BY tapId")
        rows = cursor.fetchall()
        con.close()
        return rows
    
    def getTareRequest(self, tapId):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        cursor.execute("SELECT tapId,loadCellTareReq FROM tapconfig WHERE tapId = " + str(tapId))
        rows = cursor.fetchall()
        con.close()
        if len(rows) == 0:
            return False
        return rows[0]['loadCellTareReq'] == 1
    
    def setTareRequest(self, tapId, tareRequested):
        tareReq = "0"
        if tareRequested:
            tareReq = "1"
        sql = "UPDATE tapconfig SET loadCellTareReq="+tareReq
        if not tareRequested:
            sql = sql + ",loadCellTareDate=NOW()"
        sql = sql + " WHERE tapId = " + str(tapId)
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        result = cursor.execute(sql)
        con.commit()
        con.close()
        
    def setLoadCellTareOffset(self, tapId, offset):
        sql = "UPDATE tapconfig SET loadCellTareOffset="+str(offset)
        sql = sql + " WHERE tapId = " + str(tapId)
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        result = cursor.execute(sql)
        con.commit()
        con.close()
        
    def addTempProbeAsNeeded(self, probe):
        sql = "SELECT * FROM tempProbes WHERE name='"+probe+"';"
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        result = cursor.execute(sql)
        if(cursor.rowcount <= 0):
            cursor.execute("INSERT INTO tempProbes (name, type) VALUES('"+probe+"', 0)")
        con.commit()
        con.close()        
    def saveTemp(self, probe, temp, tempUnit, takenDate):
        insertLogSql = "INSERT INTO tempLog (probe, temp, tempUnit, takenDate) "
        insertLogSql += "VALUES('"+probe+"',"+str(temp)+"+ COALESCE((SELECT manualAdj FROM tempProbes WHERE name = '"+probe+"'), 0), '"+str(tempUnit)+"', '"+takenDate+"');"
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        result = cursor.execute(insertLogSql)
        con.commit()
        con.close()
        self.archiveTemp()
        
    def saveTemps(self, temps):
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        for temp in temps:
            insertLogSql = "INSERT INTO tempLog (probe, temp, tempUnit, takenDate) "
            insertLogSql += "VALUES('"+temp[0]+"',"+str(temp[1])+"+ COALESCE((SELECT manualAdj FROM tempProbes WHERE name = '"+temp[0]+"'), 0), '"+str(temp[2])+"', '"+temp[3]+"');"
            result = cursor.execute(insertLogSql)
        con.commit()
        con.close()
        self.archiveTemp()
        
    def getTempProbeConfig(self):
        useTempProbes = self.getConfigValueByName("useTempProbes")
        if(useTempProbes is not None and int(useTempProbes) == 1):
            return True
        return False  
    #set to -1 so on startup archive is checked
    lastArchiveCheck = -1
    #Combine all readings older than 2 months into 1 average for the month to reduce rows in the table
    def archiveTemp(self):
        #only archive if the month has changed
        if self.lastArchiveCheck == datetime.datetime.now().month:
            return
        insertLogSql = """INSERT INTO tempLog (takenDate, probe, temp, humidity) 
            (SELECT CAST(DATE_FORMAT(takenDate,'%Y-%m-01') as DATE), 'History', TRUNCATE(AVG(temp), 2), TRUNCATE(hl.humidity, 2) 
                FROM tempLog tl
                    LEFT JOIN (SELECT CAST(DATE_FORMAT(takenDate,'%Y-%m-01') AS DATE) as takenMonth, AVG(humidity) AS humidity
                                        FROM tempLog
                                        WHERE probe != 'History' AND humidity IS NOT NULL AND
                                                takenDate < CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE) 
                                        GROUP BY MONTH(takenDate)) hl    ON CAST(DATE_FORMAT(tl.takenDate,'%Y-%m-01') as DATE) = hl.takenMonth
                WHERE probe != 'History' AND
                        takenDate < CAST(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH) ,'%Y-%m-01') as DATE) 
                GROUP BY MONTH(takenDate));"""
        deleteSQL = """DELETE FROM tempLog 
                WHERE probe != 'History' AND
                        takenDate < CAST(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH) ,'%Y-%m-01') as DATE) ;"""
        con = connectDB()
        cursor = con.cursor(mdb.cursors.DictCursor)
        result = cursor.execute(insertLogSql)
        result = cursor.execute(deleteSQL)
        con.commit()
        con.close()
        self.lastArchiveCheck = datetime.datetime.now().month
    
    def useFanControl(self):
        useFanControl = self.getConfigValueByName("useFanControl")
        if(useFanControl is None or int(useFanControl) == 0):
            return False
        return True    
            
    def getFanPin(self):
        fanPin = self.getConfigValueByName("useFanPin")
        if fanPin is not None:
            return int(fanPin)
        return -1
    def getFanOnTime(self):
        fanPin = self.getConfigValueByName("fanOnTime")
        if fanPin is not None:
            return int(fanPin)
        return 0
    def getFanOffTime(self):
        fanPin = self.getConfigValueByName("fanInterval")
        if fanPin is not None:
            return int(fanPin)
        return 0
    
    # check if we're exceeding the pour threshold
    def sendflowupdate(self, pin, count):
        return
        
    # check if we're exceeding the pour threshold
    def sendkickupdate(self, pin):
        msg = "RPU:KICK:" + str(pin)
        debug("Kicking Keg: "  + msg.rstrip())
        self.mcast.sendto(msg + "\n", (MCAST_GRP, MCAST_PORT))
            
    # send a mcast flow update
    def sendflowcount(self, rfid, pin, count):
        if self.OPTION_RESTART_FANTIMER_AFTER_POUR:
            self.fanControl.restartNeeded(True)
        msg = "RPU:FLOW:" + str(pin) + "=" + str(count) +":" + rfid
        debug("count update: "  + msg.rstrip())
        self.mcast.sendto(msg + "\n", (MCAST_GRP, MCAST_PORT))
        
    # send a mcast valve/pin update
    def sendvalveupdate(self, pin, value):
        msg = "RPU:VALVE:" + str(pin) + "=" + str(value)
        debug("valve update: "  + msg.rstrip())
        self.mcast.sendto(msg + "\n", (MCAST_GRP, MCAST_PORT))
        
    # send a mcast fan update
    def sendfanupdate(self, pin, value):
        msg = "RPU:FAN:" + str(pin) + "=" + str(value)
        debug("fan update: "  + msg.rstrip())
        self.mcast.sendto(msg + "\n", (MCAST_GRP, MCAST_PORT))
      
    # send a mcast fan update
    def sendconfigupdate(self,):
        debug("config update: "  +  "RPU:CONFIG")
        self.mcast.sendto("RPU:CONFIG\n", (MCAST_GRP, MCAST_PORT))
        
    # start running the flow monitor in it's own thread
    def spawn_flowmonitor(self):
        while True:
            try:
                if(config['dispatch.debugMonitoring']):
                    self.flowmonitor.fakemonitor()
                else:
                    self.flowmonitor.monitor(self.useOption("useFlowMeter"))
            except Exception, e:
                log("serial connection stopped...")
                debug( str(e) )
            finally:
                time.sleep(1)
                log("flowmonitor aborted, restarting...")
                

    def spawnWebSocketServer(self):
        args = ["-p", "8081", "-d", "/var/www/html/python/ws"]
        #only log all errors in the webservice if we are debuging, turn level to critical
        if(not config['dispatch.debug']):
            args.append("--log-level")
            args.append("critical")
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

        log("starting device monitors...")
        t = threading.Thread(target=self.spawn_flowmonitor)
        t.setDaemon(True)
        t.start()
            
        log("starting command server")
        t = threading.Thread(target=self.commandserver.serve_forever)
        t.setDaemon(True)
        t.start()
        
        log("starting fan control")
        self.fanControl.start()
        
        signal.pause()
        debug( "exiting...")
        
    # 
    def triggerAlaModeReset(self):
        self.alaModeReconfig = True;
        
    # check if something got changed which requires reset/reconfigure of alamode
    def needAlaModeReconfig(self):
        return 1 if self.alaModeReconfig else 0
                    
    # reset the alamode by tripping it's reset line
    def resetAlaMode(self):
        self.alaModeReconfig = False;
        resetpin = 12

        if GPIO_IMPORT_SUCCESSFUL:
            GPIO.setup(int(resetpin), GPIO.OUT)
            oldValue = GPIO.input(resetpin)
            if (oldValue == 1):
                value1 = 0
            else:
                value1 = 1
                
            self.updatepin(resetpin, value1)
            time.sleep(1)
            self.updatepin(resetpin, oldValue)
            
            self.OPTION_RESTART_FANTIMER_AFTER_POUR = self.getConfigValueByName("restartFanAfterPour")
        
    # update PI gpio pin mode (either input or output), this requires that this is run as root 
    def setpinmode(self, pin, value):
        if not GPIO_IMPORT_SUCCESSFUL:
            return False
        
        if (pin < 1):
            debug("invalid pin " + str(pin))
            return False
        
            debug( "update pin MODE %s to %s" %(pin, value))
            if int(value) == 0 :
                    GPIO.setup(int(pin), GPIO.IN)
            else:
                    GPIO.setup(int(pin), GPIO.OUT)
            return True
        
    # update PI gpio pin (either turn on or off), this requires that this is run as root 
    def updatepin(self, pin, value):
        if not GPIO_IMPORT_SUCCESSFUL:
            return False
        
        pin = int(pin)
        value = int(value)
        if (pin < 1):
            debug("invalid pin " + str(pin))
            return False
        
        GPIO.setup(pin, GPIO.OUT)
        oldValue = GPIO.input(pin)
        if(oldValue != value):
            #debug( "update pin %s from %s to %s" %(pin, oldValue, value))
            if value == 0 :
                GPIO.output(pin, GPIO.LOW)
            else:
                GPIO.output(pin, GPIO.HIGH)
                
            sql = "UPDATE tapconfig SET valvePinState=" + str(value) + " WHERE valvePin =" +  str(-1*pin)
            con = connectDB()
            cursor = con.cursor(mdb.cursors.DictCursor)
            result = cursor.execute(sql)
            con.commit()
            con.close()
            
            return True
        return False

    # update PI gpio pin (either turn on or off), this requires that this is run as root 
    def readpin(self, pin):
        if not GPIO_IMPORT_SUCCESSFUL:
            return 0
        pin = int(pin)
        if (pin < 1):
            debug("invalid pin " + str(pin))
            return 0
        value = GPIO.input(pin)
        debug( "read pin %s value %s" %(pin, value))
        return value;
                
    def valveStopPower(self):
        debug( "stopping valve power on pin %s" %(OPTION_VALVEPOWERPIN))
        self.updatepin(self.getValvesPowerPin(), 0)
        
    def updateValvePins(self):            
        taps = self.getTapConfig()
        ii = 0
        for tap in taps:
            if( len(self.valvesState) < ii + 1):
                self.valvesState.append(-1)
                
            if(tap["valveOn"] is None):
                tap["valveOn"] = 0
                
            if self.valvesState[ii] != int(tap["valveOn"]):
                self.sendvalveupdate(ii, tap["valveOn"])
                
            self.valvesState[ii] = int(tap["valveOn"])
            ii = ii + 1
            
    def getValvesState(self):
        return self.valvesState      
    
    def getConfigItem(self, itemName):
        config = self.getConfig()
        for item in config:
            if (item["configName"] == itemName):
                return item
        return None
           
    def updateFlowmeterConfig(self):            
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
            
    def getValvesPowerPin(self):
        if self.useOption("useTapValves"):
            valveItem = self.getConfigItem("valvesPowerPin")
            if valveItem is not None:
                return int(valveItem["configValue"])
        return -1
        
    def getValvesPowerTime(self):
        if self.useOption("useTapValves"):
            valveItem = self.getConfigItem("valvesOnTime")
            if valveItem is not None:
                return int(valveItem["configValue"])
        return -1
        
    def shutdown(self,):
        log("Shuting Down System")
        os.system('sudo shutdown -P now')
    
    def restart(self,):
        log("Rebooting System")
        os.system('sudo reboot')
        
    def restartService(self,):
        log("Restarting Service")
        os.system('sudo /etc/init.d/flowmon restart')
        
    def upgrade(self,varient="", branch_to_use="", tag=""):
        log("Upgrading RPints Service")
        
        cmds = {}
        if varient == "":
            subprocess.call(""+PINTS_DIR+"/util/installRaspberryPints --u --i "+PINTS_DIR, shell=True)

        elif varient == "force":
            subprocess.call(""+PINTS_DIR+"/util/installRaspberryPints --u --f --i "+PINTS_DIR, shell=True)

class FanControlThread (threading.Thread):
    restart = False
    def __init__(self, threadID, dispatch):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.dispatch = dispatch
        self.shutdown_required = False
        self.restartLock = Lock()
        self.restartNeeded(False)
      
    def exit(self):
        self.shutdown_required = True
        
    def restartNeeded(self, restart=None):
        self.restartLock.acquire()
        if not restart is None:
            if not self.restart and restart:
                debug( "restarting fan timer after pour" )
            self.restart = restart
        ret = self.restart
        self.restartLock.release()
        
        return ret
    
    def updatePinAndWait(self, pin, value, waitTimeMins):
        waitTimeSecs = waitTimeMins*60
        #if check restart is false then apply fan update
        if not self.restartNeeded() and waitTimeSecs > 0:
            if self.dispatch.updatepin(pin, value):
                self.dispatch.sendfanupdate(pin, value)
            intervalStart = time.time()
            #Check if restart was requested then seconds till on time is up
            while not self.restartNeeded() and int(time.time() - intervalStart) < waitTimeSecs:
                #wait min of what is left of on  time or 5 seconds 
                time.sleep(min(5, waitTimeSecs - int(time.time() - intervalStart)))
                
    def run(self):
        log("Fan Control " + self.threadID + " is Running")
        logNotEnable = True
        try:
            while not self.shutdown_required:
                fanConfig = self.dispatch.useFanControl()
                if not fanConfig:
                    if logNotEnable:
                        #only log this once during the disabled period, if enabled then disabled log again
                        log("Not Configured to run Fan")
                        logNotEnable = False
                    #wait 60 seconds then check if fan config changed
                    time.sleep(60)
                    continue
                logNotEnable = True
                pin = self.dispatch.getFanPin()
                if pin < 1:
                    log("Fan pin not configured correctly (currently "+str(pin)+")")
                    time.sleep(60)
                    continue
                
                self.restartNeeded(False)
                self.updatePinAndWait(pin, 1, self.dispatch.getFanOnTime() )
                self.updatePinAndWait(pin, 0, self.dispatch.getFanOffTime())
        except:
            log("Unable to run Fan Control Thread")
            return
        
dispatch = PintDispatch()
dispatch.setup()
dispatch.start()
debug( "Exiting...")
