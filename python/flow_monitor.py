#!/usr/bin/python
import serial
import syslog
import time
import MySQLdb as mdb
import subprocess

#The following line is for serial over GPIO
port = '/dev/ttyS0'
#The following line is for serial over USB
#port = '/dev/ttyACM0'

arduino = serial.Serial(port,9600,timeout=2)



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
		if ( reading[0] == "P" ):
			MCP_ADDR = int(reading[1])
			MCP_PIN = str(reading[2])
			POUR_COUNT = str(reading[3])
			PULSES_PERL = 5600
			
                        #MLITERS = (POUR_COUNT/5.600)/1000			
			
			
			print "Pour:"
			print "  - Addr : "+hex(MCP_ADDR)
			print "  - Pin  : "+str(MCP_PIN)
			print "  - Count: "+str(POUR_COUNT)
			#print "  - Ounces: "+str(POUR_COUNT / 165)
			#print "  - Mliters: "+str(MLITERS)
						
			#The following 2 lines passes the PIN and PULSE COUNT to the php script
			path = '../includes/utcheckin.php'
			subprocess.call(["php", path, MCP_PIN, POUR_COUNT])
			
			#con = mdb.connect('localhost','root','YEbrak4M!','devpints')
			
			#cur = con.cursor()
			#cur.execute("SELECT tapNumber,batchId,PulsesPerLiter from taps where pinAddress = %s and active = %s",(MCP_PIN,"1"))
			#taps = cur.fetchall()
			#if taps:
			#	cur.execute("INSERT INTO pours(tapId,amountPoured,batchId,pinAddress,pulseCount,pulsesPerLiter,liters) values (%s,%s,%s,%s,%s,%s,%s)",(taps[0][0],POUR_COUNT / 165,taps[0][1],MCP_PIN,POUR_COUNT,taps[0][2],round((POUR_COUNT/5.600)/1000,3)))
			#	con.commit()
			#else:
			#	print "Tap is not active"
		elif ( reading[0] == "K" ):
			MCP_ADDR = int(reading[1])
			MCP_PIN = int(reading[2])
			print "Keg Kicked:"
			print "  - Addr : "+hex(MCP_ADDR)
			print "  - Pin  : "+str(MCP_PIN)
			
			if ( MCP_PIN == 8 ):
				TAP = 4
			elif ( MCP_PIN == 9 ):
				TAP = 3
			elif ( MCP_PIN == 10 ):
				TAP = 2
			elif ( MCP_PIN == 11 ):
				TAP = 1
				
			#con = mdb.connect('localhost','root','YEbrak4M!','raspberrypints')
			
			#cur = con.cursor()
			#cur.execute("INSERT INTO pourData(count,pin,reading) values (%s,%s,%s)", (0,MCP_PIN,reading[0]))
			#con.commit()
		else:
			print "Unknown message: "+msg
finally:
        print "Exiting"
