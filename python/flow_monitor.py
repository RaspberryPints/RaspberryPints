#!/usr/bin/python
import serial
import syslog
import time

arduino = serial.Serial('/dev/ttyACM0',9600,timeout=2)


running = True

try:
	while running:	
		msg = arduino.readline()
		if not msg:
			continue
		reading = msg.split(";")
		if ( len(reading) < 2 ):
			continue
		if ( reading[0] == "P" ):
			MCP_ADDR = int(reading[1])
			MCP_PIN = int(reading[2])
			POUR_COUNT = long(reading[3])
			print "Pour:"
			print "  - Addr : "+hex(MCP_ADDR)
			print "  - Pin  : "+str(MCP_PIN)
			print "  - Count: "+str(POUR_COUNT)
		if ( reading[0] == "K" ):
			MCP_ADDR = int(reading[1])
			MCP_PIN = int(reading[2])
			print "Keg Kicked:"
			print "  - Addr : "+hex(MCP_ADDR)
			print "  - Pin  : "+str(MCP_PIN)
finally:
        print "Exiting"
