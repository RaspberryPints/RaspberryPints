import threading
import time
import sys
import struct
import socket

from FlowMonitor import FlowMonitor
import SocketServer

MCAST_GRP = '224.1.1.1'
MCAST_PORT = 0xBEE2

class CommandTCPHandler(SocketServer.StreamRequestHandler):

    def handle(self):
        self.data = self.rfile.readline().strip()

        #DEBUG
#        print "{} wrote:".format(self.client_address[0])
#        print self.data
        
        if not self.data:
            self.wfile.write("RPNAK\n")
            return
        
        reading = self.data.split(":")
        if ( len(reading) < 2 ):
            print "Unknown message: "+ self.data
            self.wfile.write("RPNAK\n")
            return
        
        if ( reading[0] == "RPV" ):
            valvecommand = reading[1].split("=")
            if ( len(valvecommand) < 2 ):
                print "Unknown valvecommand: "+ self.data
                self.wfile.write("RPNAK\n")
                return
            
            pin = int(valvecommand[0])
            value = int(valvecommand[1])
            self.server.pintdispatch.updatepin(pin, value)
        
        self.wfile.write("RPACK\n")

class CommandTCPServer(SocketServer.TCPServer):
    def server_bind(self):
        self.socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.socket.bind(self.server_address)
        
class PintDispatch(object):
    
    def __init__(self):
        self.flowmonitor = FlowMonitor(self)
        #multicast socket
        self.mcast = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_LOOP, 1)

        mreq = struct.pack("4sl", socket.inet_aton(MCAST_GRP), socket.INADDR_ANY)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)
        
        self.commandserver = CommandTCPServer(('localhost', MCAST_PORT), CommandTCPHandler)
        self.commandserver.pintdispatch = self
        
    def sendflowupdate(self, pin, count):
        self.mcast.sendto("RPU:FLOW:%s=%s\n" % (pin, count), (MCAST_GRP, MCAST_PORT))
        
    def sendvalveupdate(self, pin, value):
        self.mcast.sendto("RPU:VALVE:%s=%s\n" % (pin, value), (MCAST_GRP, MCAST_PORT))
        
    def updatepin(self, pin, value):
        print "update pin %s to %s" %(pin, value)
        #updating GPIO goes here
        self.sendvalveupdate(pin, value)

    def spawn_monitor(self):
        self.flowmonitor.fakemonitor()

    def start(self):
        t = threading.Thread(target=self.spawn_monitor)
        t.setDaemon(True)
        t.start()
        print("RPINTS: flow monitor thread started, starting command server\n")
        self.commandserver.serve_forever()
        
dispatch = PintDispatch()
dispatch.start()