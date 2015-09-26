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
        port = '/dev/ttyS0'
        #The following line is for serial over USB
        #port = '/dev/ttyACM0'
        self.dispatch = dispatcher
        self.arduino = serial.Serial(port,9600,timeout=2)
        
        # Edit this line to point to where your rpints install is
        self.poursdir = '/var/www'
    
    def fakemonitor(self):
        running = True
        print "RPINTS: Listening to arduino"
        
        try:
            while running:  
                time.sleep(30)  
                msg = "P;0;9;450"
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
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                elif ( reading[0] == "K" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = int(reading[2])
                else:
                    print "RPINTS: Unknown message: "+ msg
        finally:
            print "Closing serial connection to arduino..."
            print "Exiting"
        
    def monitor(self):
        running = True
        print "RPINTS: Listening to arduino"
        
        try:
            while running:    
                msg = self.arduino.readline()
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
                    
                    #MLITERS = (POUR_COUNT/5.600)/1000            
                    
                    #Uncomment next for lines for debugging
                    #print "Pour:"
                    #print "  - Addr : "+hex(MCP_ADDR)
                    #print "  - Pin  : "+str(MCP_PIN)
                    #print "  - Count: "+str(POUR_COUNT)
                    #print "  - Msg  : "+str(msg)
                    #print "  - Ounces: "+str(POUR_COUNT / 165)
                    #print "  - Mliters: "+str(MLITERS)
                                
                    #The following 2 lines passes the PIN and PULSE COUNT to the php script
                    path = '/var/www/includes/pours.php'
                    subprocess.call(["php", path, MCP_PIN, POUR_COUNT])
                    
                    #con = mdb.connect('localhost','root','YEbrak4M!','devpints')
                    
                    #cur = con.cursor()
                    #cur.execute("SELECT tapNumber,batchId,PulsesPerLiter from taps where pinAddress = %s and active = %s",(MCP_PIN,"1"))
                    #taps = cur.fetchall()
                    #if taps:
                    #    cur.execute("INSERT INTO pours(tapId,amountPoured,batchId,pinAddress,pulseCount,pulsesPerLiter,liters) values (%s,%s,%s,%s,%s,%s,%s)",(taps[0][0],POUR_COUNT / 165,taps[0][1],MCP_PIN,POUR_COUNT,taps[0][2],round((POUR_COUNT/5.600)/1000,3)))
                    #    con.commit()
                    self.dispatch.sendflowupdate(MCP_PIN, POUR_COUNT)
                    #else:
                    #    print "Tap is not active"
                elif ( reading[0] == "K" ):
                    MCP_ADDR = int(reading[1])
                    MCP_PIN = int(reading[2])
                    #print "Keg Kicked:"
                    #print "  - Addr : "+hex(MCP_ADDR)
                    #print "  - Pin  : "+str(MCP_PIN)
                    #print "  - Msg  : "+str(msg)
                        
                    #con = mdb.connect('localhost','root','YEbrak4M!','raspberrypints')
                    
                    #cur = con.cursor()
                    #cur.execute("INSERT INTO pourData(count,pin,reading) values (%s,%s,%s)", (0,MCP_PIN,reading[0]))
                    #con.commit()
                else:
                    print "RPINTS: Unknown message: "+ msg
        finally:
            print "RPints: Closing serial connection to arduino..."
            self.arduino.close()
