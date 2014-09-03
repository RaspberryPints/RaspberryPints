#!/usr/bin/python
import serial
import syslog
import time
import subprocess

#The following line is for serial over GPIO
port = '/dev/ttyS0'
#The following line is for serial over USB
#port = '/dev/ttyACM0'

arduino = serial.Serial(port,9600,timeout=5)



running = True

try:
	while running:	
		msg = arduino.readline()
		if not msg:
			continue
		reading = msg.split(";")
		if ( len(reading) < 2 ):
			print "Unknown message: "+msg
			continue
		if ( len(reading) > 4 ):
			if ( reading[0] == "R"):
				RFID = str(reading[1])
				MCP_ADDR = str(reading[3])
                        	MCP_PIN = str(reading[4])
                        	POUR_COUNT = str(reading[5])
                        	PULSES_PERL = 5600

				#print "RFID POUR:"
				#print "  - RFID : "+str(RFID)
				#print "  - Pin  : "+str(MCP_PIN)
				#print "  - Count: "+str(POUR_COUNT)
				#The following 2 lines passes the PIN and PULSE COUNT to the php script
                        	path = '/home/pi/raspberrypints/includes/pours.php'
                        	subprocess.call(["php", path, RFID, MCP_PIN, POUR_COUNT])
				#serial.Serial.flushInput()
			elif (reading[2] =="K"):
				RFID = str(reading[1])
				MCP_ADDR = str(reading[3])
                                MCP_PIN = str(reading[4])
				
				#print "RFID KICK:"
				#print "  - RFID :"+str(RFID)
				#print "  - KICK :"+str(MCP_PIN)
				#serial.Serial.flushInput()

      		elif ( reading[0] == "P" ):
			RFID = "0";
			MCP_ADDR = str(reading[1])
			MCP_PIN = str(reading[2])
			POUR_COUNT = str(reading[3])
			PULSES_PERL = 5600
			
                        	#MLITERS = (POUR_COUNT/5.600)/1000			
			
			
			#print "Pour:"
			#print "  - RFID : "+str(MCP_ADDR)
			#print "  - Pin  : "+str(MCP_PIN)
			#print "  - Count: "+str(POUR_COUNT)
				#print "  - Ounces: "+str(POUR_COUNT / 165)
				#print "  - Mliters: "+str(MLITERS)
						
				#The following 2 lines passes the PIN and PULSE COUNT to the php script
			path = '/home/pi/raspberrypints/includes/pours.php'
			subprocess.call(["php", path, RFID, MCP_PIN, POUR_COUNT])
			#serial.Serial.flushInput()
				
		elif ( reading[0] == "K" ):
			MCP_ADDR = int(reading[1])
			MCP_PIN = int(reading[2])
				#print "Keg Kicked:"
				#print "  - Addr : "+hex(MCP_ADDR)
				#print "  - Pin  : "+str(MCP_PIN)
			
			
			#serial.Serial.flushInput()
		else:

			print "Unknown message: "+msg
finally:
        print "Exiting"
