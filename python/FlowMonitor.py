import threading
import time
import sys
import serial
import syslog
import time
import MySQLdb as mdb
import subprocess
import os
import os.path

from Config import config

def debug(msg):
    if(config['flowmon.debug']):
        print "RPINTS: " + msg.rstrip()
        sys.stdout.flush()
                 
def log(msg):
    print "RPINTS: " + msg.rstrip()
    sys.stdout.flush() 
    

class FlowMonitor(object):
    
    def __init__(self, dispatcher):
        self.port = config['flowmon.port']
        self.dispatch = dispatcher
        self.poursdir = config['pints.dir'] + '/includes/pours.php'
        self.resetAlamode = True
        self.alaKeepAlive = False

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
    
    def setup(self):
        hexfile = config['pints.dir'] + "/arduino/raspberrypints/raspberrypints.cpp.hex"
        cmdline = "/usr/share/arduino/hardware/tools/avrdude -C/usr/share/arduino/hardware/tools/avrdude.conf -patmega328p -calamode -P/dev/ttyS0 -b115200 -D -Uflash:w:"
        cmdline = cmdline + hexfile
        cmdline = cmdline + ":i"
        
        output = ""
        if os.path.isfile(hexfile) and os.access(hexfile, os.R_OK):
            debug("resetting alamode to try to force it to listen to us...")
            self.dispatch.resetAlaMode()
            debug("giving it a short break to wake up again...")
            time.sleep(2)

            try: 
                debug("reflashing alamode via:\n" + cmdline)
                output = subprocess.check_output(cmdline, shell=True, stderr=subprocess.STDOUT,)
                debug( output )
            except Exception as ex:
                print 'RPINTS: reflashing alamode failed, moving on anyways, error was: ', ex
                debug (output)
        else:
            self.resetAlamode = False
            debug("no hexfile to flash alamode (or not readable), moving on")

    def assembleConfigMessage(self):
        debug(  "getting config data for alamode" )

        config = self.dispatch.getConfig()
        taps = self.dispatch.getTapConfig()
        
        for item in config:
            if (item["configName"] == 'alamodePourMessageDelay'):
                    alamodePourMessageDelay = item["configValue"]
            if (item["configName"] == 'alamodePourTriggerCount'):
                    alamodePourTriggerCount = item["configValue"]
            if (item["configName"] == 'alamodeKickTriggerCount'):
                    alamodeKickTriggerCount = item["configValue"]
            if (item["configName"] == 'alamodeUpdateTriggerCount'):
                    alamodeUpdateTriggerCount = item["configValue"]
        
        numberOfTaps = len(taps)
        pins = []
        for tap in taps:
            pins.append(tap["flowPin"])
        pins.sort();
        
        #'C:<numSensors>:<sensor pin>:<...>:<pourMsgDelay>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'|
        cfgmsg = "C:" + str(numberOfTaps) + ":"
        for pin in pins:
            cfgmsg = cfgmsg + str(pin) + ":"
        cfgmsg = cfgmsg + alamodePourMessageDelay + ":"
        cfgmsg = cfgmsg + alamodePourTriggerCount + ":"
        cfgmsg = cfgmsg + alamodeKickTriggerCount + ":"
        cfgmsg = cfgmsg + alamodeUpdateTriggerCount + "|"
        return cfgmsg
                            
    def reconfigAlaMode(self):

        debug( "waiting for alamode to come alive" )
        commEst = 0
        # wait for arduiono to come alive, it sens out a stream of 'a' once it's ready
        while (commEst < 4):
            somechar = self.arduino.read()
            if( somechar == 'a'):
                commEst += 1
        
        debug( "alamode alive..." )
        cfgmsg = self.assembleConfigMessage()

        debug( "alamode config, about to sent: " + cfgmsg )
        self.arduino.write(cfgmsg) # send config message, this will make it send pulses
        reply = self.arduino.readline()
        debug( "alamode says: " + reply )
        
    # 'C:<numSensors>:<sensor pin>:<...>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'    
    def monitor(self):
        running = True
        
        if self.alaKeepAlive is False:
            debug( "resetting alamode" )
            self.dispatch.resetAlaMode()
            self.arduino = serial.Serial(self.port,9600,timeout=1)
        else:
            self.alaKeepAlive = False

        self.reconfigAlaMode()
        debug( "listening to alamode" )
        
        try:
            while running:    
                msg = self.arduino.readline()
                
                if not msg:
                    # check if we need to reconfigure alamode
                    if(self.dispatch.needAlaModeReconfig()):
                        return; # get out and let the caller restart us
                    continue
                
                if msg.count('a') > 2 :
                    debug( "alamode was restarted, restart flowmonitor")
                    self.alaKeepAlive = True
                    return # arduino was restarted, get out and let the caller restart us
                
                reading = msg.split(";")
                if ( len(reading) < 2 ):
                    debug( "alamode - Unknown message (length too short): "+ msg )
                    continue
                
                if ( reading[0] == "P" ):
                    debug( "got a pour: "+ msg )
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
  
                    POUR_COUNT = str(reading[3])
                    PULSES_PERL = 5600
                    
                    #The following 2 lines passes the PIN and PULSE COUNT to the php script
                    subprocess.call(["php", self.poursdir, MCP_PIN, POUR_COUNT])
                    self.dispatch.sendflowcount(MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "U" ):
                    debug( "got a update: "+ msg )
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    POUR_COUNT = str(reading[3])
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "K" ):
                    debug( "got a kick: "+ msg )
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = int(reading[2])
                    self.dispatch.sendkickupdate(MCP_PIN)
                else:
                    debug( "unknown message: "+ msg )
        finally:
            if self.alaKeepAlive is False :
                debug( "closing serial connection to alamode..." )
                self.arduino.close()

    def fakemonitor(self):
        running = True
        debug( "listening to alamode" )
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
                    debug( "alamode - Unknown message (length too short): "+ msg )
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
                    debug( "Unknown message: "+ msg )
        finally:
            debug( "Closing serial connection to alamode..." )
            debug( "Exiting" )
