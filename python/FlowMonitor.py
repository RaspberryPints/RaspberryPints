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
import traceback
import glob
from hx711 import HX711

GPIO_IMPORT_SUCCESSFUL = True
try:
    import RPi.GPIO as GPIO
except:
    GPIO_IMPORT_SUCCESSFUL = False

RFID_IMPORT_SUCCESSFUL = True
try:
    import MFRC522
except:
    RFID_IMPORT_SUCCESSFUL = False
    
from Config import config

def debug(msg, process="FlowMonitor"):
    if(config['dispatch.debug']):
        log(msg, process, True)
                 
def log(msg, process="FlowMonitor", isDebug=False):
    if ("RFIDCheck" not in msg and "Status" not in msg) or log.lastMsg != msg:
        log.logger.log(msg, process, isDebug)
        log.lastMsg = msg
    else:
        log.logger.logDB(msg, process, isDebug)
log.lastMsg = "" 

class FlowMonitor(object):
    
    def __init__(self, dispatcher, logger):
        log.logger = logger    
        if not RFID_IMPORT_SUCCESSFUL:
            log("Could not import RFID Reader, RFID disabled. Assuming SPI not installed/configured")
            
        self.port = config['flowmon.port']
        self.dispatch = dispatcher
        self.poursdir = config['pints.dir'] + '/includes/pours.php'
        self.rfiddir = config['pints.dir'] + '/includes/rfidCheck.php'
        self.resetAlamode = True
        self.alaIsAlive = False
        self.alamodeUseRFID = False
        
        self.motionDetectors = []
        self.loadCellThreads = []
        self.readers = []
        self.tempProbeThread = None
        
    def readline_notimeout(self):
        eol = b'\r\n'
        leneol = len(eol)
        line = bytearray()
        while True:
            c = self.arduino.read(1)
            #debug(repr(c))
            if c:
                line += c
                if line[-leneol:] == eol:
                    break
        return bytes(line[:-leneol])
    
    def setup(self):
        hexfile = config['pints.dir'] + "/arduino/raspberrypints/raspberrypints.cpp.hex"
        inofile = config['pints.dir'] + "/arduino/raspberrypints/raspberrypints.ino"
        if os.path.isfile(inofile) and os.access(inofile, os.R_OK) and os.path.getmtime(inofile) > os.path.getmtime(hexfile) :
            log("Ino new than Hex. manual upload assumed")
        else:
            cmdline = "/usr/share/arduino/hardware/tools/avrdude -C/usr/share/arduino/hardware/tools/avrdude.conf -patmega328p -calamode -P"+self.port+" -b115200 -D -Uflash:w:"
            
            cmdline = cmdline + hexfile
            cmdline = cmdline + ":i"
            output = ""
            if os.path.isfile(hexfile) and os.access(hexfile, os.R_OK):
                debug("resetting alamode to try to force it to listen to us...")
                self.dispatch.resetAlaMode()
                debug("giving it a short break to wake up again...")
                time.sleep(2)
    
                try: 
                    debug("reflashing Arduino via:\n" + cmdline)
                    output = subprocess.check_output(cmdline, shell=True, stderr=subprocess.STDOUT,)
                    debug( output )
                except Exception as ex:
                    print 'RPINTS: reflashing Arduino failed, moving on anyways, error was: ', ex
                    debug (output)
            else:
                self.resetAlamode = False
                debug("no hexfile to flash Arduino (or not readable), moving on")

    def assembleConfigMessage(self):
        alamodeRelayTrigger = 0
        debug(  "getting config data for Arduino" )

        rpConfig = self.dispatch.getConfig()
        taps = self.dispatch.getTapConfig()
        for item in rpConfig:
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
        
        numberOfTaps = len(taps)
        pins = []
        valvePins = []
        for tap in taps:
            pins.append(tap["flowPin"])
            valvePins.append(tap["valvePin"])
        lastLen = 0
        #'C:<numSensors>:<sensor pin>:<...>:<pourMsgDelay>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>':<useRFID>|
        cfgmsg = "C:" 
        cfgmsg = cfgmsg + str(numberOfTaps) + ":"
        for pin in pins:
            cfgmsg = cfgmsg + str(pin) + ":"
        if len(cfgmsg) - lastLen > 50:
            cfgmsg = cfgmsg + "~"
            lastLen = len(cfgmsg)
        cfgmsg = cfgmsg + str(alamodeUseTapValves) + ":"            
        if int(alamodeUseTapValves) > 0:
            cfgmsg = cfgmsg + str(alamodeRelayTrigger) + ":"
            for pin in valvePins:
               cfgmsg = cfgmsg + str(pin) + ":"
               if len(cfgmsg) - lastLen > 50:
                    cfgmsg = cfgmsg + "~"
                    lastLen = len(cfgmsg)
        cfgmsg = cfgmsg + alamodePourMessageDelay + ":"
        cfgmsg = cfgmsg + alamodePourTriggerCount + ":"
        if len(cfgmsg) - lastLen > 50:
            cfgmsg = cfgmsg + "~"
            lastLen = len(cfgmsg)
        cfgmsg = cfgmsg + alamodeKickTriggerCount + ":"
        cfgmsg = cfgmsg + alamodeUpdateTriggerCount + ":"
        cfgmsg = cfgmsg + alamodePourShutOffCount + ":"
        cfgmsg = cfgmsg + ("1" if self.alamodeUseRFID else "0") + ":"
        cfgmsg = cfgmsg + ("1" if config["dispatch.debug"] else "0")
        cfgmsg = cfgmsg + "|"
        return cfgmsg
                  
    def serialResetInputBuffer(self):
        #depending on python version (3.0 and newer) different calls are needed
        if sys.version_info >= (3,0):
            self.arduino.reset_input_buffer
        else:
            self.arduino.flushInput()
                     
    def serialInWaiting(self):
        #depending on python version (3.0 and newer) different calls are needed
        if sys.version_info >= (3,0):
            return self.arduino.in_waiting
        else:
            return self.arduino.inWaiting()
                            
    def reconfigAlaMode(self):

        debug( "waiting for Arduino to come alive" )
        
        # wait for arduiono to come alive, it sens out a stream of 'a' once it's ready
        msg = self.readline_notimeout()
        while (b"alive" != msg):
            #debug("["+str(msg)+"]")
            if(b"StatusCheck" == msg):
                msg = "Status;%s;%d;%s;|" % ("NOTOK", -1, 1)
                debug( "Sending "+ msg )
                self.arduino.write(msg)
            msg = self.readline_notimeout()
        self.serialResetInputBuffer()
        
        debug( "Arduino alive..." )
        self.alaIsAlive = True
        cfgmsg = self.assembleConfigMessage()

        debug( "Arduino config, about to send: " + cfgmsg )
        ii = 0
        while(ii < len(cfgmsg)):
            self.arduino.write(cfgmsg[ii:ii+1]) # send config message, this will make it send pulses
            if cfgmsg[ii:ii+1] == "~":
                reply = ""
                while reply.strip() != "continue":
                    while self.serialInWaiting() == 0:
                        time.sleep(.005)
                    reply = self.arduino.readline()
            ii += 1
        debug("Waiting for Config Response")
        while self.serialInWaiting() == 0:
            time.sleep(.005)
        reply = self.arduino.readline()
        debug( "Arduino says: " + reply )
        
    # 'C:<numSensors>:<sensor pin>:<...>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'    
    def monitor(self):
        running = True
        
        if self.alaIsAlive is False:
            debug( "resetting Arduino" )
            self.dispatch.resetAlaMode()
            self.arduino = serial.Serial(self.port,9600,timeout=.5)
        else:
            self.alaIsAlive = False
            debug( "NOT resetting Arduino" )

        if GPIO_IMPORT_SUCCESSFUL:
            self.motionDetectors = []
            configMD = self.dispatch.getMotionDetectors()
            for item in configMD:
                if (item["type"] == 0):
                    detector = MotionDetectionPIRThread( "MD-" + str(item["name"]), pirPin=int(item["pin"]) )
                    detector.start()
                    self.motionDetectors.append(detector)
                    
            self.loadCellThreads = []
            configMD = self.dispatch.getLoadCellConfig()
            for item in configMD:
                loadCell = LoadCellCheckThread( "LC-" + str(item["tapId"]), updateDir=config['pints.dir'], dispatch=self.dispatch, tapId=item["tapId"], commandPin=item["loadCellCmdPin"], responsePin=item["loadCellRspPin"], unit=item["loadCellUnit"], logger=log.logger )
                loadCell.start()
                self.loadCellThreads.append(loadCell)
            
        self.readers = []
        if RFID_IMPORT_SUCCESSFUL:
            dbReaders = self.dispatch.getRFIDReaders()
            for item in dbReaders:
                if (item["type"] == 0):
                        self.readers.append( RFIDCheckThread( "RFID-" + str(item["name"]), self.rfiddir, rfidSPISSPin=int(item["pin"]) ) )
                self.alamodeUseRFID = True
        
        self.reconfigTempProbes()
        
        self.reconfigAlaMode()
        debug( "listening to Arduino" )
        
        try:
            while running:   
                #msg = self.arduino.readline()
                msg = self.readline_notimeout()
                if not msg:
                    continue
                
                reading = msg.split(";")
                if reading[0] == "alive" :
                    debug(msg)
                    if self.alaIsAlive == True :
                        debug( "Arduino was restarted, restart flowmonitor" )
                    else :
                        debug( "Arduino was started" )
                    #incase the arduino restarts its self we want to do not alive so that we reset it next time
                    self.alaIsAlive = not self.alaIsAlive 
                    return # arduino was restarted, get out and let the caller restart us
                if reading[0] == "dead" :
                    # check if we need to reconfigure Arduino
                    debug( "Arduino reconfig in progress..." )
                    self.alaIsAlive = False
                    return # get out and let the caller restart us                
                if ( len(reading) < 2 ):
                    debug( "Arduino - Unknown message (length too short): "+ msg )
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
                    WritePinsThread("WP", reading, self.dispatch).start()
                    msg = "DONE;%d;%d|" % (COUNT, MODE)
                    #debug( "Sending "+ msg )
                    self.arduino.write(msg)
                    
                #request basic status infomration like rfid/user and reconfig required
                elif ( reading[0] == "StatusCheck" ):
                    #debug("RFIDCheck")
                    RFIDState = "NOTOK"
                    userId = -1
                    if self.alamodeUseRFID == True:
                        for item in self.readers:
                            if not item.isAlive():
                                item.start() 
    
                            userId = item.getLastUserId() 
                            if userId > -1:
                                RFIDState = "OK"
                                break
                    
                    valves = ""
                    valvesState = self.dispatch.getValvesState()
                    if not valvesState is None :
                        valves = ';'.join(map(str, valvesState))
                                
                    msg = "Status;%s;%d;%s;%s;|" % (RFIDState, userId, self.dispatch.needAlaModeReconfig(), valves)
                    debug( "Sending "+ msg )
                    self.arduino.write(msg)
                #log message
                elif ( reading[0] == "Log" ):
                   log(reading[1], "Arduino")
                #debug message
                elif ( reading[0] == "Debug" ):
                   debug(reading[1], "Arduino")
                else:
                    debug( "unknown message: "+ msg )
        except:
            print("Unexpected error:", sys.exc_info()[0])
            traceback.print_exc(file=sys.stdout)
        finally:            
            if self.alaIsAlive is False :
                debug( "closing serial connection to Arduino..." )
                self.arduino.close()
            for item in self.readers:
                if item.isAlive():
                    item.exit()
            for item in self.motionDetectors:
                if item.isAlive():
                    item.exit()
            for item in self.loadCellThreads:
                if item.isAlive():
                    item.exit()
            if self.tempProbeThread is not None and self.tempProbeThread.isAlive():
                self.tempProbeThread.exit()

    def fakemonitor(self):
        running = True
        debug( "listening to Arduino" )
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
                    debug( "Arduino - Unknown message (length too short): "+ msg )
                    continue
                if ( reading[0] == "P" ):
                    MCP_RFID = str(reading[1])
                    MCP_PIN = str(reading[2])  
                    POUR_COUNT = str(reading[3])   
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
            debug( "Closing serial connection to Arduino..." )
            debug( "Exiting" )

    def tareRequest(self):
        for item in self.loadCellThreads:
            if item.isAlive():
                item.setCheckTare(True)
        
    def reconfigTempProbes(self):
        if(self.dispatch.getTempProbeConfig()):
            if(self.tempProbeThread is None or not self.tempProbeThread.is_alive()):
                self.tempProbeThread = OneWireTemperatureThread(threadID="1", dispatch=self.dispatch, delay=1, bound_hi=212, bound_lo=0)
                self.tempProbeThread.start()
            self.tempProbeThread.set_delay(float(self.dispatch.getConfigValueByName('tempProbeDelay')))
            self.tempProbeThread.set_bound_lo(float(self.dispatch.getConfigValueByName('tempProbeBoundLow')))
            self.tempProbeThread.set_bound_hi(float(self.dispatch.getConfigValueByName('tempProbeBoundHigh')))
            #Make sure the thread stays alive instead of exiting, incase the user disabled and reenabled when the thread was sleeping 
            self.tempProbeThread.keepAlive()
        else:
            if(self.tempProbeThread is not None and self.tempProbeThread.is_alive):
                self.tempProbeThread.exit()
            
                
class RFIDCheckThread (threading.Thread):
    userId = -1
    def __init__(self, threadID, rfiddir, delay=.250, rfidSPISSPin=24):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.delay = delay
        self.rfidSPISSPin = rfidSPISSPin
        self.rfiddir = rfiddir
        self.lastUserId = -1
        self.shutdown_required = False
        
    def exit(self):
        self.shutdown_required = True
        
    def run(self):
        log("RFID Reader " + self.threadID + " is Running")
        while not self.shutdown_required:
            try:
                self.checkRFID(self.rfidSPISSPin)
            except Exception, e:
                debug("RFID Reader: " +str(e))
            finally:
                time.sleep(self.delay)

    def checkRFID(self, rfidSPISSPin):
        try:
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
                    usrId = int(proc)
                    if usrId > -1:
                        if usrId <> self.lastUserId or self.rfidTag <> rfidTag:
                            debug("RFID "+rfidTag+" User Id "+ proc)
                        self.userId = usrId
                        self.lastUserId = usrId
                    self.rfidTag = rfidTag
        
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
                    
        except Exception, e:
            debug("RFID Reader: " +str(e))
        finally:
            MIFAREReader.Close_MFRC522()
                
    def getLastUserId(self):
        ret = self.userId
        if ret <> -1:
            self.userId = -1
        return ret 
    
class WritePinsThread (threading.Thread):
    def __init__(self, threadID, splitMsg, dispatch, delay = .005):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.splitMsg = splitMsg
        self.delay = delay
        self.dispatch = dispatch
      
    def run(self):
        part = 1
        MODE = int(self.splitMsg[part])
        part += 1
        COUNT = int(self.splitMsg[part])
        part += 1
        while ( part-2 <= COUNT and COUNT > 0 ):
            if not self.splitMsg[part]:
                debug("Got empty pin for part "+str(part))
                continue
            self.dispatch.updatepin(int(self.splitMsg[part]), MODE)
            part += 1
            if self.delay > 0:
                time.sleep(self.delay) 
                
#Following is based on code from day_trippr (coverted to thread and allow configurable pin)
class MotionDetectionPIRThread (threading.Thread):
    def __init__(self, threadID, pirPin = 7):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.pirPin = pirPin
        self.shutdown_required = False
      
    def exit(self):
        self.shutdown_required = True
        
    def MOTION(self, PIR_PIN):
        debug("Motion Detector " + self.threadID + " Detected Motion")
        #Wake up every users monitor, need to loop through the users otherwise the command wont know who is currently logged in
        #To see full command replace ;'s with new lines
        os.system('export DISPLAY=":0.0"; for dir in /home/*/; do export XAUTHORITY=$dir.Xauthority; xscreensaver-command -deactivate > /dev/null 2>&1; done;')
        time.sleep(1)

    def run(self):
        log("Motion Detector " + self.threadID + " is Running")
        try:
            GPIO.setup(self.pirPin, GPIO.IN)
            GPIO.add_event_detect(self.pirPin, GPIO.RISING, callback=self.MOTION)
            while not self.shutdown_required:
                time.sleep(100)
        except:
            log("Unable to run Motion Detection")
            return
        
        
class LoadCellCheckThread (threading.Thread):
    def __init__(self, threadID, dispatch, updateDir, tapId = 1, commandPin = 7, responsePin = 8, delay=1, updateVariance=.01, unit="lb", logger=None):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.dispatch = dispatch
        self.updateDir = updateDir
        self.tapId = tapId
        self.commandPin = commandPin
        self.responsePin = responsePin
        self.delay = delay
        self.updateVariance = updateVariance
        self.unit = unit
        self.checkTare = False
        self.shutdown_required = False
        self.hx711 = HX711(name=threadID, dout_pin=responsePin, pd_sck_pin=commandPin, logger=logger) 
        
    def exit(self):
        self.shutdown_required = True
        
    def setCheckTare(self, checkTare):
        self.checkTare = checkTare
        
    def tare(self):
        self.hx711.zero()
        return
    
    def getWeight(self):
        return self.hx711.get_weight_mean(20)
    
    def run(self):
        log("Load Cell Checker " + self.threadID + " is Running")
        lastWeight = -1
        try:
            while not self.shutdown_required:
                if self.checkTare:
                    if self.dispatch.getTareRequest(self.tapId):
                        self.tare()
                        self.dispatch.setTareRequest(self.tapId, False)
                        self.setCheckTare(False)
                    
                weight = self.getWeight()
                #if weight is valid and the difference between the last read is significant enough to update
                if weight > 0 and abs(lastWeight - weight) > self.updateVariance :
                    #The following 2 lines passes the PIN and WEIGHT to the php script
                    subprocess.call(["php", self.updateDir + '/admin/updateKeg.php', str(self.tapId), str(weight), self.unit])
                    lastWeight = weight
                time.sleep(self.delay)
        except Exception as ex:
            log("Unable to run Load Cell Checker")
            debug(str(ex))
            return
        
#See https://www.homebrewtalk.com/forum/threads/web-accessible-temperature-logger-for-raspberry-pi.469523/ for source information
class OneWireTemperatureThread (threading.Thread):
    def __init__(self, threadID, dispatch, delay=1, bound_lo=-200, bound_hi=212):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.dispatch = dispatch
        self.delay = delay
        self.bound_lo = bound_lo
        self.bound_hi = bound_hi
        self.shutdown_required = False
    
    def keepAlive(self):
        self.shutdown_required = False
    def exit(self):
        self.shutdown_required = True
        
    def set_delay(self, delay):
        self.delay = delay
    def set_bound_lo(self, bound_lo):
        self.bound_lo = bound_lo
    def set_bound_hi(self, bound_hi):
        self.bound_hi = bound_hi
        
    #-------------------------------------------------------------------------------------------------------
    # get temperature
    # returns None on error, or the temperature as a float
    def get_temp(self, devicefile):
    
        try:
            fileobj = open(devicefile,'r')
            lines = fileobj.readlines()
            fileobj.close()
        except:
            return None
    
        # get the status from the end of line 1 
        status = lines[0][-4:-1]
    
        equals_pos = lines[1].find('t=')
        if equals_pos != -1: 
            tempstr = lines[1][equals_pos+2:]
            tempvalue_c=float(tempstr)/1000.0
            tempvalue = round(tempvalue_c,1)
            #tempvalue_f = tempvalue_c * 9.0 / 5.0 + 32.0
            #tempvalue = round(tempvalue_f,1)
            return tempvalue
            
        else:
            return None
        
    def run(self):
        log("1Wire Temperature Thread " + self.threadID + " is Running")
        lastWeight = -1
        firstTime = True
        try:
            # enable kernel modules
            os.system('sudo modprobe w1-gpio')
            os.system('sudo modprobe w1-therm')
            
            while not self.shutdown_required:
                # search for a device file that starts with 28
                devicelist = glob.glob('/sys/bus/w1/devices/28*')
                for probeDir in devicelist:
                    probeName = os.path.basename(probeDir)
                    if(firstTime):
                        self.dispatch.addTempProbeAsNeeded(probeName)
                    # append /w1slave to the device file
                    device = probeDir + '/w1_slave'
                    temp = self.get_temp(device)
                    #if temperature doesnt make sense try again 1 time
                    if temp == None or temp < self.bound_lo or temp > self.bound_hi:
                        temp = self.get_temp(device)
                        
                    #if valid temp save it to the database
                    if temp != None and temp >= self.bound_lo and temp <= self.bound_hi:
                        self.dispatch.saveTemp(probeName, temp, 'C')
                        
                time.sleep(self.delay)
                firstTime = False
        except Exception, e:
            log("Unable to Run 1Wire Temperature")
            return
            
