import threading
import time
import sys
import serial
import syslog
import time
import MySQLdb as mdb
import subprocess

class FlowMonitor(object):
    
    def __init__(self, dispatcher):
        #The following line is for serial over GPIO
        self.port = '/dev/ttyS0'
        #The following line is for serial over USB
        #port = '/dev/ttyACM0'
        self.dispatch = dispatcher
        
        # Edit this line to point to where your rpints install is
        self.poursdir = '/var/www'

    def readline_notimeout(self):
        eol = b'\r'
        leneol = len(eol)
        line = bytearray()
        while True:
            c = self.arduino.read(1)
            if c:
                line += c
                if line[-leneol:] == eol:
                    break
        return bytes(line)
    
    def reconfigAlaMode(self):
        taps = self.dispatch.getTapConfig();
        commEst = 0
        # wait for arduiono to come alive, it sens out 'a\n' once it's ready
        while (commEst < 4):
            msg = self.arduino.read()
            if( msg == 'a'):
                commEst += 1
        
        self.arduino.write("C:5:5:6:7:9:10:20:30:400|") # send config message, this will make it send pulses
        msg = self.arduino.readline()
        print "RPINTS: arduino says: " + msg
        
    # 'C:<numSensors>:<sensor pin>:<...>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'    
    def monitor(self):
        running = True
        
        self.dispatch.resetAlaMode()
        self.arduino = serial.Serial(self.port,9600,timeout=1)
        print "RPINTS: config arduino"
        self.reconfigAlaMode();
        print "RPINTS: listening to arduino"
        
        try:
            while running:    
                msg = self.arduino.readline()
                if not msg:
                    # check if we need to reconfigure alamode
                    if(self.dispatch.needAlaModeReconfig()):
                        return; # get out and let the caller restart us
                    continue
                reading = msg.split(";")
                if ( len(reading) < 2 ):
                    print "RPINTS: arduino - Unknown message (length too short): "+ msg
                    continue
                
                if ( reading[0] == "P" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
  
                    POUR_COUNT = str(reading[3])
                    PULSES_PERL = 5600
                    
                    #The following 2 lines passes the PIN and PULSE COUNT to the php script
                    path = '/var/www/includes/pours.php'
                    subprocess.call(["php", path, MCP_PIN, POUR_COUNT])
                    self.dispatch.sendflowcount(MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "U" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    POUR_COUNT = str(reading[3])
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "K" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = int(reading[2])
                    self.dispatch.sendkickupdate(MCP_PIN)
                else:
                    print "RPINTS: unknown message: "+ msg
        finally:
            print "RPINTS: closing serial connection to arduino..."
            self.arduino.close()

    def fakemonitor(self):
        running = True
        print "RPINTS: listening to arduino"
        updatecount = 0;
        pin = 9;
        
        try:
            while running:  
                time.sleep(25)  
                updatecount = updatecount + 500
                msg = "K;0;%s;%s" % (pin, updatecount)
                
                if not msg:
                    continue
                reading = msg.split(";")
                if ( len(reading) < 2 ):
                    print "RPINTS: Arduino - Unknown message (length too short): "+ msg
                    continue
                if ( reading[0] == "P" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    POUR_COUNT = str(reading[3])
                    PULSES_PERL = 5600
                    self.dispatch.sendflowcount(MCP_PIN, POUR_COUNT)
                elif ( reading[0] == "U" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    POUR_COUNT = str(reading[3])
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                    updatecount = 0;
                elif ( reading[0] == "K" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = int(reading[2])
                    self.dispatch.sendkickupdate(MCP_PIN)
                else:
                    print "RPINTS: Unknown message: "+ msg
        finally:
            print "Closing serial connection to arduino..."
            print "Exiting"
