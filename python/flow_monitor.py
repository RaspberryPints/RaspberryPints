#!/usr/bin/python
import serial
import syslog
import time

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
		elif ( reading[0] == "K" ):
			MCP_ADDR = int(reading[1])
			MCP_PIN = int(reading[2])
			print "Keg Kicked:"
			print "  - Addr : "+hex(MCP_ADDR)
			print "  - Pin  : "+str(MCP_PIN)
		else:
			print "Unknown message: "+msg
finally:
        print "Exiting"
