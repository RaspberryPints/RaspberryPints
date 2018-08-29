# ----------------------------------------------------------------------------
# "THE BEER-WARE LICENSE" (Revision 42 3/4):
# <thomas@hentschel.net> wrote this file. As long as you retain this notice you
#  can do whatever you want with this stuff. If we meet some day, and you think
#  this stuff is worth it, you can buy me a beer in return 
# -Th
#  ----------------------------------------------------------------------------
import threading
import time
import datetime
import sys
import serial
import syslog
import time
import MySQLdb as mdb
import subprocess
import os
import os.path
import MFRC522
import traceback

from Config import config

alamodeRelayTrigger = 0
rfidSPISSPin = 24
                    
def debug(msg):
    if(config['flowmon.debug']):
        log(msg)
                 
def log(msg):
    if msg != "RFIDCheck" or log.lastMsg != msg:
        print datetime.datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S') + " RPINTS: " + msg.rstrip()
        sys.stdout.flush()
        log.lastMsg = msg
log.lastMsg = ""

class FlowMonitor(object):
    
    def __init__(self, dispatcher):
        self.port = config['flowmon.port']
        self.dispatch = dispatcher
        self.poursdir = config['pints.dir'] + '/includes/pours.php'
        self.rfiddir = config['pints.dir'] + '/includes/rfidCheck.php'
        self.resetAlamode = True
        self.alaKeepAlive = False
        
    def readline_notimeout(self):
        eol = b'\r\n'
        leneol = len(eol)
        line = bytearray()
        while True:
            c = self.arduino.read(1)
            #debug(c)
            if c:
                line += c
                if line[-leneol:] == eol:
                    break
        return bytes(line[:-leneol])
    
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
            if (item["configName"] == 'useTapValves'):
                    alamodeUseTapValves = item["configValue"]
            if (item["configName"] == 'relayTrigger'):
                    alamodeRelayTrigger = item["configValue"]
            if (item["configName"] == 'alamodePourMessageDelay'):
                    alamodePourMessageDelay = item["configValue"]
            if (item["configName"] == 'alamodePourTriggerCount'):
                    alamodePourTriggerCount = item["configValue"]
            if (item["configName"] == 'alamodeKickTriggerCount'):
                    alamodeKickTriggerCount = item["configValue"]
            if (item["configName"] == 'pourShutOffCount'):
                    alamodePourShutOffCount = item["configValue"]
            if (item["configName"] == 'alamodeUpdateTriggerCount'):
                    alamodeUpdateTriggerCount = item["configValue"]
            if (item["configName"] == 'useRFID'):
                    alamodeUseRFID = item["configValue"]
            if (item["configName"] == 'rfidSSPin'):
                    rfidSPISSPin = item["configValue"]
        
        numberOfTaps = len(taps)
        pins = []
        valvePins = []
        for tap in taps:
            pins.append(tap["flowPin"])
            valvePins.append(tap["valvePin"])
        
        #'C:<numSensors>:<sensor pin>:<...>:<pourMsgDelay>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>':<useRFID>|
        cfgmsg = "C:" 
        cfgmsg = cfgmsg + str(numberOfTaps) + ":"
        for pin in pins:
            cfgmsg = cfgmsg + str(pin) + ":"
        if len(cfgmsg) > 50:
            cfgmsg = cfgmsg + "~"
        cfgmsg = cfgmsg + str(alamodeUseTapValves) + ":"            
        if int(alamodeUseTapValves) > 0:
            cfgmsg = cfgmsg + str(alamodeRelayTrigger) + ":"
            for pin in valvePins:
               cfgmsg = cfgmsg + str(pin) + ":"
        if len(cfgmsg) > 50:
            cfgmsg = cfgmsg + "~"
        cfgmsg = cfgmsg + alamodePourMessageDelay + ":"
        cfgmsg = cfgmsg + alamodePourTriggerCount + ":"
        if len(cfgmsg) > 50:
            cfgmsg = cfgmsg + "~"
        cfgmsg = cfgmsg + alamodeKickTriggerCount + ":"
        cfgmsg = cfgmsg + alamodeUpdateTriggerCount + ":"
        cfgmsg = cfgmsg + alamodePourShutOffCount + ":"
        cfgmsg = cfgmsg + alamodeUseRFID + "|"
        return cfgmsg
                            
    def reconfigAlaMode(self):

        debug( "waiting for alamode to come alive" )
        
        # wait for arduiono to come alive, it sens out a stream of 'a' once it's ready
        msg = self.readline_notimeout()
        while (b"alive" != msg):
            #debug("["+str(msg)+"]")
            msg = self.readline_notimeout()
        self.arduino.reset_input_buffer()
        
        debug( "alamode alive..." )
        cfgmsg = self.assembleConfigMessage()

        debug( "alamode config, about to send: " + cfgmsg )
        ii = 0
        while(ii < len(cfgmsg)):
            self.arduino.write(cfgmsg[ii:ii+1]) # send config message, this will make it send pulses
            if cfgmsg[ii:ii+1] == "~":
                while self.arduino.in_waiting == 0:
                    time.sleep(.005)
                reply = self.arduino.readline()
            ii += 1
        debug("Waiting for Config Response")
        while self.arduino.in_waiting == 0:
                time.sleep(.005)
        reply = self.arduino.readline()
        debug( "alamode says: " + reply )
        
    # 'C:<numSensors>:<sensor pin>:<...>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'    
    def monitor(self):
        running = True
        
        if self.alaKeepAlive is False:
            debug( "resetting alamode" )
            self.dispatch.resetAlaMode()
            self.arduino = serial.Serial(self.port,9600,timeout=.5)
        else:
            self.alaKeepAlive = False

        self.reconfigAlaMode()
        debug( "listening to alamode" )
        
        try:
            while running:   
                #msg = self.arduino.readline()
                msg = self.readline_notimeout()
                if not msg:
                    # check if we need to reconfigure alamode
                    if(self.dispatch.needAlaModeReconfig()):
                        debug( "alamode reconfig in progress..." )
                        return; # get out and let the caller restart us
                    continue
                
                reading = msg.split(";")
                if reading[0] == "alive" :
                    debug(msg)
                    debug( "alamode was restarted, restart flowmonitor")
                    self.alaKeepAlive = True
                    return # arduino was restarted, get out and let the caller restart us
                
                if ( len(reading) < 2 ):
                    debug( "alamode - Unknown message (length too short): "+ msg )
                    continue
                #debug(str(reading))
                if ( reading[0] == "P" ):
                    debug( "got a pour: "+ msg )
                    MCP_RFID = str(reading[1])
                    MCP_PIN = str(reading[2])  
                    POUR_COUNT = str(reading[3])                    
                    #The following 2 lines passes the PIN and PULSE COUNT to the php script
                    subprocess.call(["php", self.poursdir, "Pour", MCP_RFID, MCP_PIN, POUR_COUNT])
                    self.dispatch.sendflowcount(MCP_RFID, MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "U" ):
                    debug( "got a update: "+ msg )
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    POUR_COUNT = str(reading[3])
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                    
                elif ( reading[0] == "K" ):
                    debug( "got a kick: "+ msg )
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    subprocess.call(["php", self.poursdir, "Kick", MCP_PIN])
                    self.dispatch.sendkickupdate(MCP_PIN)
                elif ( reading[0] == "SM" and len(reading) >= 3 ):
                    #debug( "got a Pin Mode Request: "+ msg )
                    part = 1
                    MODE = int(reading[part])
                    part += 1
                    COUNT = int(reading[part])
                    part += 1
                    while ( part-2 <= COUNT ):
                        self.dispatch.setpinmode(int(reading[part]), MODE)
                        part += 1
                    msg = "DONE;%d;%d|" % (COUNT, MODE)
                    #debug( "Sending "+ msg )
                    self.arduino.write(msg)
                elif ( reading[0] == "RP" and len(reading) >= 2 ):
                    #debug( "got a Read Pin Request: "+ msg )
                    MCP_PIN = int(reading[1])
                    pinState = self.dispatch.readpin(MCP_PIN) 
                    msg = "PINREAD;%s;%s|" % (MCP_PIN, pinState)
                    #debug( "Sending "+ msg )
                    self.arduino.write(msg)
                elif ( reading[0] == "WP" and len(reading) >= 3 ):
                    #debug( "got a Write Pins Request: "+ msg )
                    part = 1
                    MODE = int(reading[part])
                    part += 1
                    COUNT = int(reading[part])
                    part += 1
                    while ( part-2 <= COUNT ):
                        self.dispatch.updatepin(int(reading[part]), MODE)
                        part += 1
                        time.sleep(.005)  
                    msg = "DONE;%d;%d|" % (COUNT, MODE)
                    #debug( "Sending "+ msg )
                    self.arduino.write(msg)
                elif ( reading[0] == "RFIDCheck" ):
                    #debug("RFIDCheck")
                    RFIDState = "NOTOK"
                    proc = -1
                    
                    MIFAREReader = MFRC522.MFRC522(pin=rfidSPISSPin)
                    # Scan for cards    
                    (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)
                    #debug("status %s; tagtype %d;" % (status, TagType ))
                    
                    # If a card is found
                    if status == MIFAREReader.MI_OK:
                        #debug("Card detected")
                        (status,uid) = MIFAREReader.MFRC522_Anticoll()
                        #debug(str(status))
                        if status == MIFAREReader.MI_OK:
                            #debug(str(uid))
                            rfidTag = ""
                            i = 0
                            while i<len(uid):
                                rfidTag = rfidTag + str(uid[i])
                                i = i + 1
                            #debug(rfidTag)
                            proc = subprocess.check_output(["php", self.rfiddir, rfidTag])
                            if int(proc) > -1:
                                debug("RFID "+rfidTag+" User Id "+ proc)
                                RFIDState = "OK"

                            # This is the default key for authentication
                            #key = [0xFF,0xFF,0xFF,0xFF,0xFF,0xFF]
                            
                            # Select the scanned tag
                            #MIFAREReader.MFRC522_SelectTag(uid)

                            # Authenticate
                            #status = MIFAREReader.MFRC522_Auth(MIFAREReader.PICC_AUTHENT1A, 8, key, uid)

                            # Check if authenticated                           
                            #if status == MIFAREReader.MI_OK:
                            #    MIFAREReader.MFRC522_Read(8)
                            #    MIFAREReader.MFRC522_StopCrypto1()
	   
                    msg = "RFID;%s;%s;" % (RFIDState, proc)
                    #debug( "Sending "+ msg )
                    self.arduino.write(msg)
                else:
                    debug( "unknown message: "+ msg )
        except:
            print("Unexpected error:", sys.exc_info()[0])
            traceback.print_exc(file=sys.stdout)
        finally:            
            if self.alaKeepAlive is False :
                debug( "closing serial connection to alamode..." )
                self.arduino.close()

    def fakemonitor(self):
        running = True
        debug( "listening to alamode" )
        updatecount = 0;
        pin = 10;
        
        try:
            while running:  
                time.sleep(25)  
                updatecount = updatecount + 500
                msg = "P;0;%s;%s" % (pin, updatecount)
                
                if not msg:
                    continue
                reading = msg.split(";")
                if ( len(reading) < 2 ):
                    debug( "alamode - Unknown message (length too short): "+ msg )
                    continue
                if ( reading[0] == "P" ):
                    MCP_RFID = str(0)
                    MCP_PIN = str(reading[1])
                    POUR_COUNT = str(reading[2])
                    subprocess.call(["php", self.poursdir, "Pour", MCP_RFID, MCP_PIN, POUR_COUNT])
                    self.dispatch.sendflowcount(MCP_RFID, MCP_PIN, POUR_COUNT)
                elif ( reading[0] == "U" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = str(reading[2])
                    POUR_COUNT = str(reading[3])
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                    updatecount = 0;
                elif ( reading[0] == "K" ):
                    MCP_ADDR = str(reading[1])
                    MCP_PIN = str(reading[2])
                    subprocess.call(["php", self.poursdir, "Kick", MCP_PIN])
                    self.dispatch.sendkickupdate(MCP_PIN)
                else:
                    debug( "Unknown message: "+ msg )
        finally:
            debug( "Closing serial connection to alamode..." )
            debug( "Exiting" )



