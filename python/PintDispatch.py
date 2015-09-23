import threading
import time
import sys
import struct

from FlowMonitor import Flowmonitor
import SocketServer

MCAST_GRP = '224.1.1.1'
MCAST_PORT = 0xBEE2

class CommandTCPHandler(SocketServer.StreamRequestHandler):

    def handle(self):
        self.data = self.rfile.readline().strip()

        #DEBUG
        print "{} wrote:".format(self.client_address[0])
        print self.data
        
        if not self.data:
            continue
        reading = self.data.split(":")
        if ( len(reading) < 3 ):
            print "Unknown message: "+msg
            continue
        if ( reading[0] == "RPV" ):
            pin = int(reading[1])
            value = int(reading[2])
            self.server.pintdispatch.updatepin(pin, value)
        
        self.wfile.write("RPA\n")
        
class PintDispatch(object):
    
    def __init__(self):
        self.flowmonitor = FlowMonitor(self)
        #multicast socket
        self.mcast = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_LOOP, 1)

        mreq = struct.pack("4sl", socket.inet_aton(MCAST_GRP), socket.INADDR_ANY)
        self.mcast.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)
        
        self.commandserver = SocketServer.TCPServer(('localhost', MCAST_PORT), CommandTCPHandler)
        self.commandserver.pintdispatch = self
        
    def sendupdate(self, pin, count):
        self.mcast.sendto("RPU:%s:%s\n" % (pin, count), (MCAST_GRP, MCAST_PORT))
        
    def updatepin(self, pin, value):
        print "update pin %s to %s" %(pin, value)
        #updating GPIO goes here

    def spawn_monitor(self):
        self.flowmonitor.monitor()

    def start(self):
        t = threading.Thread(target=self.spawn_monitor)
        t.setDaemon(True)
        t.start()
        print("RPINTS: flow monitor thread started, starting command server")
        self.commandserver.serve_forever()
        
dispatch = PintDispatch()
dispatch.start()