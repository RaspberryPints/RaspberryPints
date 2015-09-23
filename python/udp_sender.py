import socket
import time

#addr = ('localhost', 33333)                                # localhost, port
addr = ('127.0.0.1', 33333)                                # localhost explicitly
#addr = ('xyz', 33333)                                      # explicit computer
#addr = ('<broadcast>', 33333)                              # broadcast address
#addr = ('255.255.255.255', 33333)                          # broadcast address explicitly

UDPSock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM) # Create socket

data = 'Message sent...\n'
# Almost infinite loop... ;)
try:
    while True:
        time.sleep(1)
        if len(data) == 0:
            break
        else:
            if UDPSock.sendto(data, addr):
                print "Sending message '%s'..." % data

finally:
    UDPSock.close()             # Close socket
    print 'Client stopped.'