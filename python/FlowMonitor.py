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

        print "RPINTS: getting config data for alamode"

        config = self.dispatch.getConfig()
        taps = self.dispatch.getTapConfig()
        
        for item in config:
            if (item["configName"] == 'numberOfTaps'):
                    numberOFTaps = item["configValue"]
            if (item["configName"] == 'alamodePourMessageDelay'):
                    alamodePourMessageDelay = item["configValue"]
            if (item["configName"] == 'alamodePourTriggerCount'):
                    alamodePourTriggerCount = item["configValue"]
            if (item["configName"] == 'alamodeKickTriggerCount'):
                    alamodeKickTriggerCount = item["configValue"]
            if (item["configName"] == 'alamodeUpdateTriggerCount'):
                    alamodeUpdateTriggerCount = item["configValue"]
        
        pins = []
        for tap in taps:
            pins.append(tap["flowPin"])
        pins.sort();
        
        #'C:<numSensors>:<sensor pin>:<...>:<pourMsgDelay>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'|
        cfgmsg = "C:" + numberOFTaps + ":"
        for pin in pins:
            cfgmsg = cfgmsg + str(pin) + ":"
        cfgmsg = cfgmsg + alamodePourMessageDelay + ":"
        cfgmsg = cfgmsg + alamodePourTriggerCount + ":"
        cfgmsg = cfgmsg + alamodeKickTriggerCount + ":"
        cfgmsg = cfgmsg + alamodeUpdateTriggerCount + "|"

        print "RPINTS: waiting for alamode to come alive"
        
        commEst = 0
        # wait for arduiono to come alive, it sens out a stream of 'a' once it's ready
        while (commEst < 4):
            somechar = self.arduino.read()
            if( somechar == 'a'):
                commEst += 1

        print "RPINTS: alamode alive, about to sent: " + cfgmsg
        
        self.arduino.write(cfgmsg) # send config message, this will make it send pulses
        reply = self.arduino.readline()
        print "RPINTS: alamode says: " + reply
        
    # 'C:<numSensors>:<sensor pin>:<...>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'    
    def monitor(self):
        running = True
        
        print "RPINTS: resetting alamode"
        self.dispatch.resetAlaMode()
        self.arduino = serial.Serial(self.port,9600,timeout=1)
        self.reconfigAlaMode()
        print "RPINTS: listening to alamode"
        
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
                    print "RPINTS: alamode - Unknown message (length too short): "+ msg
                    continue
                
                if ( reading[0] == "P" ):
                    print "RPINTS: got a pour: "+ msg
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
  
                    POUR_COUNT = str(reading[3])
                    PULSES_PERL = 5600
                    
                    #The following 2 lines passes the PIN and PULSE COUNT to the php script
                    path = '/var/www/includes/pours.php'
                    subprocess.call(["php", path, MCP_PIN, POUR_COUNT])
                    self.dispatch.sendflowcount(MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "U" ):
                    print "RPINTS: got a update: "+ msg
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    POUR_COUNT = str(reading[3])
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "K" ):
                    print "RPINTS: got a kick: "+ msg
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = int(reading[2])
                    self.dispatch.sendkickupdate(MCP_PIN)
                else:
                    print "RPINTS: unknown message: "+ msg
        finally:
            print "RPINTS: closing serial connection to alamode..."
            self.arduino.close()

    def fakemonitor(self):
        running = True
        print "RPINTS: listening to alamode"
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
                    print "RPINTS: alamode - Unknown message (length too short): "+ msg
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
            print "Closing serial connection to alamode..."
            print "Exiting"
