import threading
import time
import sys
import struct
import socket
import RPi.GPIO as GPIO
import MySQLdb as mdb
from FlowMonitor import FlowMonitor
import SocketServer

# change as necessary if installed elsewhere
PINTS_DIR               = "/var/www"
INCLUDES_DIR            = PINTS_DIR + "/includes"
PYTHON_DIR              = PINTS_DIR + "/python"
PYTHON_WSH_DIR          = PYTHON_DIR + "/ws"
ADMIN_DIR               = PINTS_DIR + "/admin"
ADMIN_INCLUDES_DIR      = ADMIN_DIR + "/includes"

# mcast group and port to send flow and valve updates to
MCAST_GRP = '224.1.1.1'
MCAST_PORT = 0xBEE2

class CommandTCPHandler(SocketServer.StreamRequestHandler):

    def handle(self):
        self.data = self.rfile.readline().strip()

        #DEBUG
#        print "{} wrote:".format(self.client_address[0])
#        print self.data
        
        if not self.data:
            self.wfile.write("RPNAK\n")
            return
        
        reading = self.data.split(":")
        if ( len(reading) < 2 ):
            print "Unknown message: "+ self.data
            self.wfile.write("RPNAK\n")
            return
        
        if ( reading[0] == "RPV" ):
            valvecommand = reading[1].split("=")
            if ( len(valvecommand) < 2 ):
                print "Unknown valvecommand: "+ self.data
                self.wfile.write("RPNAK\n")
                return
            
            pin = int(valvecommand[0])
            value = int(valvecommand[1])
            self.server.pintdispatch.updatepin(pin, value)
        
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

        self.flowmonitor = FlowMonitor(self)
        #multicast socket
        self.mcast = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_LOOP, 1)

        mreq = struct.pack("4sl", socket.inet_aton(MCAST_GRP), socket.INADDR_ANY)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)
        
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
        cursor.execute("SELECT tapNumber,flowPin,valvePin,valveOn from tapconfig")
        rows = cursor.fetchall()
        con.close()
        return rows
            
    # send a mcast flow update
    def sendflowupdate(self, pin, count):
        self.mcast.sendto("RPU:FLOW:%s=%s\n" % (pin, count), (MCAST_GRP, MCAST_PORT))
        
    # send a mcast valve/pin update
    def sendvalveupdate(self, pin, value):
        self.mcast.sendto("RPU:VALVE:%s=%s\n" % (pin, value), (MCAST_GRP, MCAST_PORT))
        
    # start running the flow monitor in it's own thread
    def spawn_monitor(self):
        self.flowmonitor.fakemonitor()

    # main start method
    def start(self):
        t = threading.Thread(target=self.spawn_monitor)
        t.setDaemon(True)
        t.start()
        print("RPINTS: flow monitor thread started, starting command server\n")
        self.commandserver.serve_forever()

    # update PI gpio pin (either turn on or off), this requires that this is run as root 
    def updatepin(self, pin, value):

        GPIO.setup(int(pin), GPIO.OUT)
        oldValue = GPIO.input(pin)
        if(oldValue != value):
            print "update pin %s from %s to %s" %(pin, oldValue, value)
            if int(value) == 0 :
                GPIO.output(int(pin), GPIO.LOW)
            else:
                GPIO.output(int(pin), GPIO.HIGH)
            self.sendvalveupdate(pin, value)

    def updatePins(self):
        taps = self.getTapConfig()
        for tap in taps:
            if(tap["valveOn"] is None):
                tap["valveOn"] = 0
                
            pin = int(tap["valvePin"])
            pinNewValue = int(tap["valveOn"])
            self.updatepin(pin, pinNewValue)
    
    def getConfigItem(self, itemName):
        config = self.getConfig()
        for item in config:
            if (item["configName"] == itemName):
                return item
        return None
           
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
            return int(fanItem["configValue"])
        return -1

        
dispatch = PintDispatch()
pd = dispatch.getFanPin()
print pd
#dispatch.start()