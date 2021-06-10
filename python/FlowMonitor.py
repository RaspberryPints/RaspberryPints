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
from socket import socket, AF_INET, SOCK_STREAM, SOL_SOCKET, SO_REUSEADDR, SHUT_RDWR
import json
LOAD_CELL_EQUIP_TYPE_TAP = 0
LOAD_CELL_EQUIP_TYPE_GT  = 1
MQTT_IMPORT_SUCCESSFUL = True
try:
    import paho.mqtt.client as mqtt # Added library for mqtt
except:
    MQTT_IMPORT_SUCCESSFUL = False

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

def debug(msg, process="FlowMonitor", logDB=True, debugConfig='flowmon.debug'):
    if(config[debugConfig]):
        log(msg, process, True, logDB)
                 
def log(msg, process="FlowMonitor", isDebug=False, logDB=True):
    if ("RFIDCheck" not in msg and "Status" not in msg) or log.lastMsg != msg:
        log.logger.log(msg, process, isDebug, logDB)
        log.lastMsg = msg
    else:
         if logDB:
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
        self.iSpindels = []
        self.tempProbeThread = None
        
    def readline_notimeout(self, serialTrace=False):
        eol = b'\r\n'
        leneol = len(eol)
        line = bytearray()
        while True:
            c = self.arduino.read(1)
            if serialTrace:
                debug(repr(c), "FlowMonitor", False)
            if c:
                line += c
                if line[-leneol:] == eol:
                    break
        return bytes(line[:-leneol])
    
    def setup(self):
        if config['flowmon.port'] == "MQTT":
                return
        hexfile = config['pints.dir'] + "/arduino/raspberrypints/raspberrypints.cpp.hex"
        inofile = config['pints.dir'] + "/arduino/raspberrypints/raspberrypints.ino"
        if os.path.isfile(inofile) and os.access(inofile, os.R_OK) and os.path.getmtime(inofile) > os.path.getmtime(hexfile) :
            log("Ino newer than Hex. manual upload assumed")
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
                    print ('RPINTS: reflashing Arduino failed, moving on anyways, error was: ', ex)
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
                msg = "Status;%s;%d;%s;|" % ("N", -1, 1)
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
    def monitor(self, flowMetersEnabld=True):
        running = True
        
        if flowMetersEnabld and GPIO_IMPORT_SUCCESSFUL:
            if self.alaIsAlive is False:
                debug( "resetting Arduino" )
                if config['flowmon.port'] == "MQTT":
                    debug( "Creating MQTT Listener" )
                    self.arduino = MQTTListenerThread( "MQTT-1", flowMonitor=self, host=config['mqtt.host'], port=config['mqtt.port'],
                                                       user=config['mqtt.user'], password=config['mqtt.password'] )
                    self.arduino.start()
                else:
                    debug( "Creating Serial Listener" )
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
                loadCell = LoadCellCheckThread( "LC-" + str(item["tapId"]), updateDir=config['pints.dir'], 
                                                dispatch=self.dispatch, tapId=item["tapId"], commandPin=item["loadCellCmdPin"], 
                                                responsePin=item["loadCellRspPin"], unit=item["loadCellUnit"], logger=log.logger,
                                                scaleRatio=item["loadCellScaleRatio"], tareOffset=item["loadCellTareOffset"] )
                loadCell.start()
                self.loadCellThreads.append(loadCell)
            
            configMD = self.dispatch.getGasTankLoadCellConfig()
            for item in configMD:
                loadCell = LoadCellCheckThread( "LC-" + str(item["id"]), updateDir=config['pints.dir'], 
                                                dispatch=self.dispatch, tapId=item["id"], commandPin=item["loadCellCmdPin"], 
                                                responsePin=item["loadCellRspPin"], unit=item["loadCellUnit"], logger=log.logger,
                                                scaleRatio=item["loadCellScaleRatio"], tareOffset=item["loadCellTareOffset"], equipType=LOAD_CELL_EQUIP_TYPE_GT )
                loadCell.start()
                self.loadCellThreads.append(loadCell)
            
        self.readers = []
        if RFID_IMPORT_SUCCESSFUL:
            dbReaders = self.dispatch.getRFIDReaders()
            for item in dbReaders:
                if (item["type"] == 0):
                        self.readers.append( RFIDCheckThread( "RFID-" + str(item["name"]), self.rfiddir, rfidSPISSPin=int(item["pin"]) ) )
                self.alamodeUseRFID = True
        
        self.iSpindels = []
        dbiSpindels = self.dispatch.getiSpindelConnectors()
        for item in dbiSpindels:
            if (item["address"] != '' and item["port"]):
                connector = iSpindelListenerThread( "iSpindal-" + str(item["address"]) + ":" + str(item["port"]), self, self.dispatch, item["address"], int(item["port"]), item["allowedConnections"], updateDir=config['pints.dir'])
                connector.start()
                self.iSpindels.append( connector )
            
        self.reconfigTempProbes()
        
        if flowMetersEnabld and GPIO_IMPORT_SUCCESSFUL:
            self.reconfigAlaMode()
            debug( "listening to Arduino" )
        else:
            log("Not listening for flowmeters")
        
        try:
            while running:   
                if config['flowmon.port'] != "MQTT" and flowMetersEnabld and GPIO_IMPORT_SUCCESSFUL:
                    #msg = self.arduino.readline()
                    msg = self.readline_notimeout(False)
                    if not msg:
                        continue
                    if not self.processMsg(msg):
                        return
                else:
                    time.sleep(1)
                    
        except:
            print("Unexpected error:", sys.exc_info()[0])
            traceback.print_exc(file=sys.stdout)
        finally:            
            if self.alaIsAlive is False :
                debug( "closing serial connection to Arduino..." )
                if config['flowmon.port'] == "MQTT":
                    self.arduino.exit()
                else:
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
            for item in self.iSpindels:
                if item.isAlive():
                    item.exit()
            if self.tempProbeThread is not None and self.tempProbeThread.isAlive():
                self.tempProbeThread.exit()
            self.alaIsAlive = False
            
    def processMsg(self, msg):
        reading = msg.split(";")
        if reading[0] == "alive" :
            debug(msg)
            if self.alaIsAlive == True :
                debug( "Arduino was restarted, restart flowmonitor" )
            else :
                debug( "Arduino was started" )
            #incase the arduino restarts its self we want to do not alive so that we reset it next time
            self.alaIsAlive = not self.alaIsAlive 
            return False# arduino was restarted, get out and let the caller restart us
        if reading[0] == "dead" :
            # check if we need to reconfigure Arduino
            debug( "Arduino reconfig in progress..." )
            self.alaIsAlive = False
            return False# get out and let the caller restart us                
        if ( len(reading) < 2 ):
            debug( "Arduino - Unknown message (length too short): "+ msg )
            return True
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
            WritePinsThread("WP", reading, self.dispatch).start()
            msg = "DONE;%d;%d|" % (COUNT, MODE)
            #debug( "Sending "+ msg )
            self.arduino.write(msg)
            
        #request basic status infomration like rfid/user and reconfig required
        elif ( reading[0] == "StatusCheck" ):
            #debug("RFIDCheck")
            RFIDState = "N"
            userId = -1
            if self.alamodeUseRFID == True:
                for item in self.readers:
                    if not item.isAlive():
                        item.start() 

                    userId = item.getLastUserId() 
                    if userId > -1:
                        RFIDState = "Y"
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
        
        return True
            
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
                if not self.processMsg(msg):
                    return
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
            except Exception as e:
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
                        if usrId != self.lastUserId or self.rfidTag != rfidTag:
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
                    
        except Exception as e:
            debug("RFID Reader: " +str(e))
            debug(traceback.format_exc())
        finally:
            MIFAREReader.Close_MFRC522()
                
    def getLastUserId(self):
        ret = self.userId
        if ret != -1:
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
    def __init__(self, threadID, pirPin = 7, ledPin=0, soundFile='', 
                mqttCommand='', mqttEvent='', mqttUser='', mqttPass='', mqttHost='', mqttPort='', mqttInterval=100):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.pirPin = pirPin
        self.shutdown_required = False
        self.ledPin = ledPin
        self.soundFile = soundFile
        self.mqttCommand = mqttCommand
        self.mqttEvent = mqttEvent
        self.mqttClient = None
        if self.mqttCommand != '':
            # Initiate MQTT Client
            self.mqttClient = mqtt.Client()
            #user and Pass
            self.mqttc.username_pw_set(username=mqttUser,password=mqttPass)            
            # mqttClient with MQTT Broker
            self.mqttClient.connect(mqttHost, mqttPort, mqttInterval)
      
    def exit(self):
        self.shutdown_required = True
        
    def MOTION(self, PIR_PIN):
        debug("Motion Detector " + self.threadID + " Detected Motion")
        #Wake up every users monitor, need to loop through the users otherwise the command wont know who is currently logged in
        #To see full command replace ;'s with new lines
        os.system('export DISPLAY=":0.0"; for dir in /home/*/; do export XAUTHORITY=$dir.Xauthority; xscreensaver-command -deactivate > /dev/null 2>&1; done;')
        
        if self.ledPin != 0:
            self.dispatch.updatepin(int(self.ledPin), True)
        if self.soundFile != '':
            os.system(mpg321 + self.soundFile)
        else:
            time.sleep(1)
        if self.mqttClient != None and self.mqttCommand != '':
            self.mqttc.publish(self.mqttEvent,self.mqttCommand)
        if self.ledPin != 0:
            self.dispatch.updatepin(int(self.ledPin), False)
        
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
            debug(traceback.format_exc())
            return
        
class LoadCellCheckThread (threading.Thread):
    def __init__(self, threadID, dispatch, updateDir, tapId = 1, commandPin = 7, responsePin = 8, delay=1, 
                 updateVariance=.01, unit="lb", logger=None, scaleRatio=1, tareOffset=0, equipType=LOAD_CELL_EQUIP_TYPE_TAP):
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
        self.equipType = equipType
        self.hx711 = HX711(name=threadID, dout_pin=responsePin, pd_sck_pin=commandPin, logger=logger,scale_ratio=scaleRatio,tare_offset=tareOffset) 
        
    def exit(self):
        self.shutdown_required = True
        
    def setCheckTare(self, checkTare):
        self.checkTare = checkTare
        
    def tare(self):
        self.hx711.zero()
        self.dispatch.setLoadCellTareOffset(self.hx711.get_offset())
        return
    
    def getWeight(self):
        return self.hx711.get_weight_mean(20)
    
    def run(self):
        log("Load Cell Checker " + self.threadID + " is Running")
        lastWeight = -1.0
        try:
            while not self.shutdown_required:
                if self.checkTare:
                    if self.equipType == LOAD_CELL_EQUIP_TYPE_TAP:
                        if self.dispatch.getTareRequest(self.tapId):
                            self.tare()
                            self.dispatch.setTareRequest(self.tapId, False)
                            self.setCheckTare(False)
                    else:
                        if self.dispatch.getGasTankTareRequest(self.tapId):
                            self.tare()
                            self.dispatch.setGasTankTareRequest(self.tapId, False)
                            self.setCheckTare(False)
                    
                weight = self.getWeight()
                debug(self.threadID+": Weight="+str(weight))
                #if weight is valid and the difference between the last read is significant enough to update
                if weight > 0 and (lastWeight == -1.0 or abs(lastWeight - weight) > self.updateVariance) :
                    #The following 2 lines passes the PIN and WEIGHT to the php script
                    if self.equipType == LOAD_CELL_EQUIP_TYPE_GT:
                        subprocess.call(["php", self.updateDir + '/admin/updateGasTank.php', str(self.tapId), str(weight), self.unit])
                    else:
                        subprocess.call(["php", self.updateDir + '/admin/updateKeg.php', str(self.tapId), str(weight), self.unit])
                    debug(self.threadID+": Updating "+str(self.tapId)+" Weight="+str(weight)+" "+self.unit)
                    lastWeight = weight
                time.sleep(self.delay)
        except Exception as ex:
            log("Unable to run Load Cell Checker")
            debug(str(ex))
            debug(traceback.format_exc())
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
    
        if len(lines) <= 0:
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
            tempStatus = {}
            statePins = {}
            while not self.shutdown_required:
                takenDate = datetime.datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S')
                temps = []
                # search for a device file that starts with 28
                devicelist = glob.glob('/sys/bus/w1/devices/28*')
                for probeDir in devicelist:
                    probeName = os.path.basename(probeDir)
                    if(firstTime):
                        statePins[probeName] = self.dispatch.addTempProbeAsNeeded(probeName)
                    # append /w1slave to the device file
                    device = probeDir + '/w1_slave'
                    temp = self.get_temp(device)
                    #if temperature doesnt make sense try again 1 time
                    if temp == None or temp < self.bound_lo or temp > self.bound_hi:
                        temp = self.get_temp(device)
                    #if valid temp save it to the database
                    if temp != None and temp >= self.bound_lo and temp <= self.bound_hi:
                        pinState = None
                        if statePins[probeName] > 0:
                            pinState = self.dispatch.readpin(statePins[probeName]) 
                        temps.append([probeName, temp, 'C', takenDate, pinState])
                        if probeName not in tempStatus:
                            debug("Adding " + probeName +" Temp[" + str(temp) + "] low:" + str(self.bound_lo) + " high:"+str(self.bound_hi) ) 
                        tempStatus[probeName] = True
                    elif tempStatus.get(probeName, False):
                        tempStatus[probeName] = False
                        debug("Not Adding " + probeName + " Temp[" + str(temp) + "] low:"+str(self.bound_lo) + " high:" + str(self.bound_hi) )
                self.dispatch.saveTemps(temps)
                
                time.sleep(self.delay)
                firstTime = False
        except Exception as e:
            log("Unable to Run 1Wire Temperature")
            debug("1Wire Temperature: " +str(e))
            debug(traceback.format_exc())
            return
            
#Based on logic from bscuderi
class MQTTListenerThread (threading.Thread):
    def __init__(self, threadID, flowMonitor, host, port, user, password, live_interval=45, topics="rpints/pours"):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.flowMonitor = flowMonitor
        self.host = host
        self.port = port
        self.user = user
        self.password = password
        self.live_interval = live_interval
        self.topics = topics
        self.shutdown_required = False
    
    def keepAlive(self):
        self.shutdown_required = False
    def exit(self):
        self.shutdown_required = True
        
    def set_live_interval(self, delay):
        self.live_interval = live_interval
        
    def run(self):
        log("MQTT Listener Thread " + self.threadID + " is Running")
        try:
            # Initiate MQTT Client
            self.mqttc = mqtt.Client()
            
            # Assign event callbacks
            self.mqttc.on_message = self.on_message
            self.mqttc.on_connect = self.on_connect
            self.mqttc.on_subscribe = self.on_subscribe
            
            #user and Pass
            self.mqttc.username_pw_set(username=self.user,password=self.password)
            
            # Connect with MQTT Broker
            self.mqttc.connect(self.host, self.port, self.live_interval)
            
            # Continue monitoring the incoming messages for subscribed topic
            while not self.shutdown_required:
                self.mqttc.loop()
        except Exception as e:
            log("Unable to Run MQTT Listener")
            debug("MQTT Listener: " +str(e))
            return
            
    # Define on connect event function
    # We shall subscribe to our Topic in this function
    def on_connect(self, client, userdata, flags, rc):
        debug("Connect on "+self.host)
        try:
            self.mqttc.subscribe(self.topics)
        except Exception as e:
            log("Unable to Run MQTT Listener")
            debug("MQTT Listener: " +str(e))
            debug(traceback.format_exc())
    
    def on_subscribe(self, client, userdata, mid, granted_qos):
        debug("Subscribed to Topic: " + self.topics + " with QoS: " + str(granted_qos))
        
    # Define on_message event function.
    # This function will be invoked every time,
    # a new message arrives for the subscribed topic
    def on_message(self, client, userdata, message):
        debug("Recevied: " + str(message) + "FROM MQTT")
        self.flowMonitor.processMsg(message.payload)

    def write(self, msg):
        self.mqttc.publish("rpints",msg)
        
    def read(self, numCharacters):
        return ""
    
    
    
#Based on https://github.com/DottoreTozzi/iSpindel-TCP-Server
ISPINDEL_ACK = chr(6)  # ASCII ACK (Acknowledge)
ISPINDEL_NAK = chr(21)  # ASCII NAK (Not Acknowledged)
ISPINDEL_BUFF_SIZE = 256  # Buffer Size
class iSpindelListenerThread (threading.Thread):
    def __init__(self, threadID, flowMonitor, dispatch, host, port, allowedConnections=5, updateDir=''):
        threading.Thread.__init__(self)
        self.threadID = threadID
        self.flowMonitor = flowMonitor
        self.dispatch = dispatch
        self.updateDir = updateDir
        self.host = host
        self.port = port
        self.allowedConnections = allowedConnections
        self.shutdown_required = False
    
    def keepAlive(self):
        self.shutdown_required = False
    def exit(self):
        self.shutdown_required = True
        if self.serversock != None:
            self.serversock.shutdown(SHUT_RDWR)
        
        
    def run(self):
        log("iSpindel Listener Thread " + self.threadID + " is Running")

        while not self.shutdown_required:
            ADDR = (self.host, self.port)
            self.serversock = socket(AF_INET, SOCK_STREAM)
            self.serversock.setsockopt(SOL_SOCKET, SO_REUSEADDR, 1)
            self.serversock.bind(ADDR)
            self.serversock.listen(self.allowedConnections)
            try:
                clientsock, addr = self.serversock.accept()
            except:
                debug('Socket Accept interrupted normally', debugConfig='iSpindel.debug')
                continue
            
            inpstr = ''
            success = 0
            spindle_name = ''
            spindle_id = 0
            angle = 0.0
            temperature = 0.0
            battery = 0.0
            gravity = 0.0
            user_token = ''
            interval = 0
            rssi = 0
            timestart = time.clock()
            config_sent = 0
            try:
                device = None
                while not self.shutdown_required:
                    data = clientsock.recv(ISPINDEL_BUFF_SIZE)
                    if not data: break  # client closed connection
                    #debug(repr(addr) + ' received:' + repr(data), debugConfig='iSpindel.debug')
                    if "close" == data.rstrip():
                        clientsock.send(ISPINDEL_ACK)
                        debug(repr(addr) + ' ACK sent. Closing.', debugConfig='iSpindel.debug')
                        break  # close connection
                    try:
                        inpstr += str(data.rstrip())
                        if inpstr[0] != "{":
                            clientsock.send(ISPINDEL_NAK)
                            debug(repr(addr) + ' Not JSON.', debugConfig='iSpindel.debug')
                            break  # close connection
                        if inpstr.find("}") != -1:
                            debug(repr(addr) + 'Received:' + inpstr, debugConfig='iSpindel.debug')
                            jinput = json.loads(inpstr)
                            spindle_name = jinput['name']
                            spindle_id = jinput['ID']
                            angle = jinput['angle']
                            temperature = jinput['temperature']
                            temperatureUnit = jinput['temp_units']
                            battery = jinput['battery']
            
                            try:
                                gravity = jinput['gravity']
                                interval = jinput['interval']
                                rssi = jinput['RSSI']
                            except:
                                # older firmwares might not be transmitting all of these
                                debug("Consider updating your iSpindel's Firmware.", debugConfig='iSpindel.debug')
                            try:
                                # get user token for connection to ispindle.de public server
                                user_token = jinput['token']
                            except:
                                # older firmwares < 5.4 or field not filled in
                                user_token = '*'
                                
                            device = self.dispatch.getiSpindelDevice(spindle_id, user_token, spindle_name, gravity)
                            # looks like everything went well :)
                            #
                            # Should we reply with a config JSON?
                            #
                            if device["remoteConfigEnabled"]:
                                resp = ISPINDEL_ACK
                                try:
                                    config = self.dispatch.getiSpindelUnsentConfig(spindle_id)
                                    if config != None:
                                        jresp = {}
                                        jresp["interval"] = config["interval"]
                                        jresp["token"] = config["token"]
                                        jresp["polynomial"] = config["polynomial"]
                                        resp = json.dumps(jresp)
                                        debug(repr(addr) + ' JSON Response: ' + resp, debugConfig='iSpindel.debug')
                                        config_sent = 1
                                    else:
                                        debug(repr(addr) + ' No unsent data for iSpindel "' + spindle_name + '". Sending ACK.', debugConfig='iSpindel.debug')
                                except Exception as e:
                                    debug(repr(addr) + " Can't send config response. Something went wrong:", debugConfig='iSpindel.debug')
                                    debug(repr(addr) + " Error: " + str(e), debugConfig='iSpindel.debug')
                                    debug(repr(addr) + " Sending ACK.", debugConfig='iSpindel.debug')
                                clientsock.send(resp)
                            else:
                                clientsock.send(ISPINDEL_ACK)
                                debug(repr(addr) + ' Sent ACK.', debugConfig='iSpindel.debug')
                            #
                            debug(repr(addr) + ' ' + spindle_name + ' (ID:' + str(spindle_id) + ') : Data Transfer OK. Time: '+str(time.clock() - timestart), debugConfig='iSpindel.debug')
                            success = 1
                            break  # close connection
                    except Exception as e:
                        # something went wrong
                        # traceback.print_exc() # this would be too verbose, so let's do this instead:
                        debug(repr(addr) + ' Error: ' + str(e), debugConfig='iSpindel.debug')
                        debug(traceback.format_exc(), debugConfig='iSpindel.debug')
                        clientsock.send(ISPINDEL_NAK)
                        debug(repr(addr) + ' NAK sent.', debugConfig='iSpindel.debug')
                        break  # close connection server side after non-success
                if clientsock != None:
                    clientsock.close()
                #debug(repr(addr) + " - closed connection", debugConfig='iSpindel.debug')  # log on console
            
                if config_sent:
                    # update sent status in config table
                    self.dispatch.updateiSpindeConfigMarkSent(spindle_id)
            
                if success:
                    # We have the complete spindle data now, so let's make it available
                    
                    if device["csvEnabled"]:
                        OUTPATH   = device["csvOutpath"]  # CSV output file path; filename will be name_id.csv
                        DELIMITER = device["csvDelimiter"]  # CSV delimiter (normally use ; for Excel)
                        NEWLINE   = '\r\n' if device["csvNewLine"] == 0 else '\n'  # newline type ( 0 = \r\n for windows clients, 1 = \n)
                        DATETIME  = device["csvIncludeDateTime"]  # Leave this at 1 to include Excel compatible timestamp in CSV
                
                
                        try:
                            filename = OUTPATH + spindle_name + '_' + str(spindle_id) + '.csv'
                            debug(repr(addr) + ' - writing CSV:' + filename, debugConfig='iSpindel.debug')
                            if not os.path.exists(filename):
                                with open(filename, 'a') as csv_file:
                                    outstr = ''
                                    if DATETIME == 1:
                                        outstr += "DateTime" + DELIMITER
                                    outstr += "spindle_name" + DELIMITER
                                    outstr += "spindle_id" + DELIMITER
                                    outstr += "angle" + DELIMITER
                                    outstr += "temperature" + DELIMITER
                                    outstr += "battery" + DELIMITER
                                    outstr += "gravity" + DELIMITER
                                    outstr += "User Token" + DELIMITER
                                    outstr += "interval" + DELIMITER
                                    outstr += "rssi" + DELIMITER
                                    outstr += "Beer ID" + DELIMITER
                                    outstr += "Beer Name" + DELIMITER
                                    outstr += "Batch"
                                    outstr += NEWLINE
                                    csv_file.writelines(outstr)
                                    debug(repr(addr) + ' - CSV headers written. ' + filename, debugConfig='iSpindel.debug')
                                
                            with open(filename, 'a') as csv_file:
                                # this would sort output. But we do not want that...
                                # import csv
                                # csvw = csv.writer(csv_file, delimiter=DELIMITER)
                                # csvw.writerow(jinput.values())
                                outstr = ''
                                if DATETIME == 1:
                                    outstr += datetime.datetime.now().strftime('%x %X') + DELIMITER
                                outstr += str(spindle_name) + DELIMITER
                                outstr += str(spindle_id) + DELIMITER
                                outstr += str(angle) + DELIMITER
                                outstr += str(temperature) + DELIMITER
                                outstr += str(battery) + DELIMITER
                                outstr += str(gravity) + DELIMITER
                                outstr += user_token + DELIMITER
                                outstr += str(interval) + DELIMITER
                                outstr += str(rssi) + DELIMITER
                                outstr += (str(device["beerId"]) if device["beerId"] is not None else '') + DELIMITER
                                outstr += (str(device["beerName"]) if device["beerId"] is not None else '') + DELIMITER
                                outstr += (str(device["batchName"]) if device["batchName"] is not None else '')
                                outstr += NEWLINE
                                csv_file.writelines(outstr)
                                debug(repr(addr) + ' - CSV data written.', debugConfig='iSpindel.debug')
                        except Exception as e:
                            debug(repr(addr) + ' CSV Error: ' + str(e), debugConfig='iSpindel.debug')
                            debug(traceback.format_exc(), debugConfig='iSpindel.debug')
                
                    if device["sqlEnabled"]:                
                        try:
                            debug(repr(addr) + ' - writing to database', debugConfig='iSpindel.debug')
                            # standard field definitions:
                            fieldlist = ['createdDate', 'name', 'iSpindelId', 'angle', 'temperature', 'temperatureUnit', 'battery', 'gravity', 'gravityUnit', 'beerId', 'beerBatchId','beerName' ]
                            valuelist = [datetime.datetime.now(), spindle_name, spindle_id, angle, temperature, temperatureUnit, battery, gravity, device["gravityUnit"], device["beerId"], device["beerBatchId"],str(device["beerName"])]
            
                            # do we have a user token defined? (Fw > 5.4.x)
                            # this is for later use (public server) but if it exists, let's store it for testing purposes
                            # this also should ensure compatibility with older fw versions and not-yet updated databases
                            if user_token != '':
                                fieldlist.append('userToken')
                                valuelist.append(user_token)
            
                            # If we have firmware 5.8 or higher:
                            if rssi != 0:
                                fieldlist.append('`interval`')  # this is a reserved SQL keyword so it requires additional quotes
                                valuelist.append(interval)
                                fieldlist.append('RSSI')
                                valuelist.append(rssi)
            
                            self.dispatch.insertiSpindelData(fieldlist, valuelist)
                            debug(repr(spindle_name) + ' - DB data written.', debugConfig='iSpindel.debug')
                        
                            if self.updateDir != '' and device["beerBatchId"] and device["beerBatchId"] > 0:
                                subprocess.call(["php", self.updateDir + '/admin/updateBeerBatch.php', str(device["beerBatchId"]), str(temperature), str(temperatureUnit), str(gravity), str(device["gravityUnit"])])
                        
                        except Exception as e:
                            debug(repr(addr) + ' Database Error: ' + str(e) + '\nDid you update your database?', debugConfig='iSpindel.debug')
                            debug(traceback.format_exc(), debugConfig='iSpindel.debug')
            
                    if device["brewPiLessEnabled"]:
                        try:
                            debug(repr(addr) + ' - forwarding to BREWPILESS at http://' + device["brewPiLessAddress"], debugConfig='iSpindel.debug')
                            import urllib2
                            outdata = {
                                'name': spindle_name,
                                'angle': angle,
                                'temperature': temperature,
                                'battery': battery,
                                'gravity': gravity,
                            }
                            out = json.dumps(outdata)
                            debug(repr(addr) + ' - sending: ' + out, debugConfig='iSpindel.debug')
                            url = 'http://' + device["brewPiLessAddress"] + '/gravity'
                            req = urllib2.Request(url)
                            req.add_header('Content-Type', 'application/json')
                            req.add_header('User-Agent', spindle_name)
                            response = urllib2.urlopen(req, out)
                            debug(repr(addr) + ' - received: ' + response.read(), debugConfig='iSpindel.debug')
            
                        except Exception as e:
                            debug(repr(addr) + ' Error while forwarding to URL ' + url + ' : ' + str(e), debugConfig='iSpindel.debug')
            
                    if device["craftBeerPiEnabled"]:
                        try:
                            debug(repr(addr) + ' - forwarding to CraftBeerPi3 at http://' + device["craftBeerPiAddress"], debugConfig='iSpindel.debug')
                            import urllib2
                            outdata = {
                                'name' : spindle_name,
                                'angle' : angle if device["craftBeerPiSendAngle"] else gravity,
                                'temperature' : temperature,
                                'battery' : battery,
                            }
                            out = json.dumps(outdata)
                            debug(repr(addr) + ' - sending: ' + out, debugConfig='iSpindel.debug')
                            url = 'http://' + device["craftBeerPiAddress"] + '/api/hydrometer/v1/data'
                            req = urllib2.Request(url)
                            req.add_header('Content-Type', 'application/json')
                            req.add_header('User-Agent', spindle_name)
                            response = urllib2.urlopen(req, out)
                            debug(repr(addr) + ' - received: ' + response.read(), debugConfig='iSpindel.debug')
            
                        except Exception as e:
                            debug(repr(addr) + ' Error while forwarding to URL ' + url + ' : ' + str(e), debugConfig='iSpindel.debug')
            
            
                    if device["unidotsEnabled"]:
                        try:
                            token = user_token if device["unidotsUseiSpindleToken"] else device["unidotsToken"]
                            if token != '':
                                if token[:1] != '*':
                                    debug(repr(addr) + ' - sending to ubidots', debugConfig='iSpindel.debug')
                                    import urllib2
                                    outdata = {
                                        'tilt': angle,
                                        'temperature': temperature,
                                        'battery': battery,
                                        'gravity': gravity,
                                        'interval': interval,
                                        'rssi': rssi
                                    }
                                    out = json.dumps(outdata)
                                    debug(repr(addr) + ' - sending: ' + out, debugConfig='iSpindel.debug')
                                    url = 'http://things.ubidots.com/api/v1.6/devices/' + spindle_name + '?token=' + token
                                    req = urllib2.Request(url)
                                    req.add_header('Content-Type', 'application/json')
                                    req.add_header('User-Agent', spindle_name)
                                    response = urllib2.urlopen(req, out)
                                    debug(repr(addr) + ' - received: ' + response.read(), debugConfig='iSpindel.debug')
                        except Exception as e:
                            debug(repr(addr) + ' Ubidots Error: ' + str(e), debugConfig='iSpindel.debug')
            
                    if device["forwardEnabled"]:
                        try:
                            debug(repr(addr) + ' - forwarding to ' + device["forwardAddress"] + ":" + device["forwardPort"], debugConfig='iSpindel.debug')
                            outdata = {
                                'name': spindle_name,
                                'ID': spindle_id,
                                'angle': angle,
                                'temperature': temperature,
                                'battery': battery,
                                'gravity': gravity,
                                'token': user_token,
                                'interval': interval,
                                'recipe': recipe,
                                'RSSI': rssi
                            }
                            out = json.dumps(outdata)
                            debug(repr(addr) + ' - sending: ' + out, debugConfig='iSpindel.debug')
                            s = socket(AF_INET, SOCK_STREAM)
                            s.connect((device["forwardAddress"], device["forwardPort"]))
                            s.send(out)
                            rcv = s.recv(ISPINDEL_BUFF_SIZE)
                            s.close()
                            if rcv[0] == ISPINDEL_ACK:
                                debug(repr(addr) + ' - received ACK - OK!', debugConfig='iSpindel.debug')
                            elif rcv[0] == ISPINDEL_NAK:
                                debug(repr(addr) + ' - received NAK - Not OK...', debugConfig='iSpindel.debug')
                            else:
                                debug(repr(addr) + ' - received: ' + rcv, debugConfig='iSpindel.debug')
                        except Exception as e:
                            debug(repr(addr) + ' Error while forwarding to ' + device["forwardAddress"] + ': ' + str(e), debugConfig='iSpindel.debug')
            
                    if device["fermentTrackEnabled"]:
                        try:
                            
                            token = user_token if device["fermentTrackUseiSpindleToken"] else device["fermentTrackToken"]
                            if token != '':
                                if token[:1] != '*':
                                    debug(repr(addr) + ' - sending to fermentrack', debugConfig='iSpindel.debug')
                                    import urllib2
                                    outdata = {
                                        "ID": spindle_id,
                                        "angle": angle,
                                        "battery": battery,
                                        "gravity": gravity,
                                        "name": spindle_name,
                                        "temperature": temperature,
                                        "token": token
                                    }
                                    out = json.dumps(outdata)
                                    debug(repr(addr) + ' - sending: ' + out, debugConfig='iSpindel.debug')
                                    url = 'http://' + device["fermentTrackAddress"] + ':' + device["fermentTrackPort"] + '/ispindel/'
                                    debug(repr(addr) + ' to : ' + url, debugConfig='iSpindel.debug')
                                    req = urllib2.Request(url)
                                    req.add_header('Content-Type', 'application/json')
                                    req.add_header('User-Agent', spindle_name)
                                    response = urllib2.urlopen(req, out)
                                    debug(repr(addr) + ' - received: ' + response.read(), debugConfig='iSpindel.debug')
                        except Exception as e:
                            debug(repr(addr) + ' Fermentrack Error: ' + str(e), debugConfig='iSpindel.debug')
            
                    if device["brewSpyEnabled"]:
                        try:
                            token = user_token if device["brewSpyUseiSpindleToken"] else device["brewSpyToken"]
                            if token != '':
                                if token[:1] != '*':
                                    debug(repr(addr) + ' - sending to brewspy', debugConfig='iSpindel.debug')
                                    import urllib2
                                    outdata = {
                                        "ID": spindle_id,
                                        "angle": angle,
                                        "battery": battery,
                                        "gravity": gravity,
                                        "name": spindle_name,
                                        "temperature": temperature,
                                        "token": token,
                                        "RSSI": rssi
                                    }
                                    out = json.dumps(outdata)
                                    debug(repr(addr) + ' - sending: ' + out, debugConfig='iSpindel.debug')
                                    url = 'http://' + device["brewSpyAddress"] + ':' + device["brewSpyPort"] + '/api/ispindel/'
                                    debug(repr(addr) + ' to : ' + url, debugConfig='iSpindel.debug')
                                    req = urllib2.Request(url)
                                    req.add_header('Content-Type', 'application/json')
                                    req.add_header('User-Agent', spindle_name)
                                    response = urllib2.urlopen(req, out)
                                    debug(repr(addr) + ' - received: ' + response.read(), debugConfig='iSpindel.debug')
                        except Exception as e:
                            debug(repr(addr) + ' Brewspy Error: ' + str(e), debugConfig='iSpindel.debug')
            
                    if device["brewFatherEnabled"]:
                        try:
                            token = user_token if device["brewFatherUseiSpindleToken"] else device["brewFatherToken"]
                            if token != '':
                                if token[:1] != '*':
                                    debug(repr(addr) + ' - sending to brewfather', debugConfig='iSpindel.debug')
                                    import urllib2
                                    outdata = {
                                        "ID": spindle_id,
                                        "angle": angle,
                                        "battery": battery,
                                        "gravity": gravity,
                                        "name": spindle_name + device["brewFatherSuffix"],
                                        "temperature": temperature,
                                        "token": token
                                    }
                                    out = json.dumps(outdata)
                                    debug(repr(addr) + ' - sending: ' + out, debugConfig='iSpindel.debug')
                                    url = 'http://' + device["brewFatherAddress"] + ':' + device["brewFatherPort"] + '/ispindel?id=' + token
                                    debug(repr(addr) + ' to : ' + url, debugConfig='iSpindel.debug')
                                    req = urllib2.Request(url)
                                    req.add_header('Content-Type', 'application/json')
                                    req.add_header('User-Agent', spindle_name)
                                    response = urllib2.urlopen(req, out)
                                    debug(repr(addr) + ' - received: ' + response.read(), debugConfig='iSpindel.debug')
                        except Exception as e:
                            debug(repr(addr) + ' Brewfather Error: ' + str(e), debugConfig='iSpindel.debug')

            except Exception as e:
                log("Unable to Run iSpindel Listener")
                debug("iSpindel Listener: " +str(e), debugConfig='iSpindel.debug')
                debug(traceback.format_exc(), debugConfig='iSpindel.debug')
                return
            
