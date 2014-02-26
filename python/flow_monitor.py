#!/usr/bin/python
import serial
import syslog
import time
import MySQLdb as mdb

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
			MCP_PIN = int(reading[2])
			POUR_COUNT = long(reading[3])
			print "Pour:"
			print "  - Addr : "+hex(MCP_ADDR)
			print "  - Pin  : "+str(MCP_PIN)
			print "  - Count: "+str(POUR_COUNT)
			con = mdb.connect('localhost','root','YEbrak4M!','raspberrypints')
			
			cur = con.cursor()
			cur.execute("INSERT INTO pourData(count,pin,reading) values (%s,%s,%s)",(POUR_COUNT,MCP_PIN,reading[0]))
			con.commit()
		elif ( reading[0] == "K" ):
			MCP_ADDR = int(reading[1])
			MCP_PIN = int(reading[2])
			print "Keg Kicked:"
			print "  - Addr : "+hex(MCP_ADDR)
			print "  - Pin  : "+str(MCP_PIN)
			con = mdb.connect('localhost','root','YEbrak4M!','raspberrypints')
			
			cur = con.cursor()
			cur.execute("INSERT INTO pourData(pin,reading) values (%s,%s)", (MCP_PIN,reading[0]))
			con.commit()
		else:
			print "Unknown message: "+msg
finally:
        print "Exiting"
