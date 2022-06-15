# ----------------------------------------------------------------------------
# "THE BEER-WARE LICENSE" (Revision 42 3/4):
# <thomas@hentschel.net> wrote this file. As long as you retain this notice you
#  can do whatever you want with this stuff. If we meet some day, and you think
#  this stuff is worth it, you can buy me a beer in return 
# -Th
#  ----------------------------------------------------------------------------
  
import socket
import struct
import select
import sys
import datetime
import time
from pprint import pprint
from mod_pywebsocket import common
from mod_pywebsocket import handshake
from symbol import except_clause

MCAST_GRP = '224.1.1.1'
MCAST_PORT = 0xBEE2

OPTION_DEBUG = False

def debug(msg):
    if(OPTION_DEBUG):
        print (datetime.datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S') + " RPINTS: " + msg.rstrip())
        sys.stdout.flush()
                 
def web_socket_do_extra_handshake(request):
    pass  # Always accept.

def web_socket_transfer_data(request):
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
    sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    sock.bind((MCAST_GRP, MCAST_PORT))  # use MCAST_GRP instead of '' to listen only to MCAST_GRP, not all groups on MCAST_PORT
    sock.setblocking(0)
    
#    pprint (vars(request._request_handler))
#    print "----"
#    sys.stdout.flush()
#    ws_sock = request._request_handler.connection
# TODO: see if we can use the ws_socket in the select below to figure if we need to receive_message() from client
#    inputs,outputs,excepts = select.select([sock, ws_sock],[],[])
#    for input in inputs: 
#        if input == sock: 
#            # handle the server socket 
#        elif input == ws_sock:
#            clientmsg = request.ws_stream.receive_message() 
# etc....
# this way could try to figure if ws client sends a close, and close this handler
    
    client = str(request._request_handler.client_address)
    
    debug ("got WS connection from " + client)
    
    try:
        while True:
            try: 
                #keep apache socket alive by sending hello every 20 seconds
                ready = select.select([sock], [], [], 20.0)
                if ready[0]:
                    line = sock.recv(1024)
                    try:
                        debug("received server update, sending '" + line.decode().rstrip() + "' to " + client)
                    except:
                        pass
                else:
#                    line = "RPH \n"
                    line = None
                    
                if not line is None:
                    request.ws_stream.send_message(line, binary=False)
            except Exception as e:
                #debug(str(e))
                break
            finally:
                pass
    

#            received = request.ws_stream.receive_message()
#            if (received == "RPK"):
#                request.ws_stream.close_connection(None, '')
#                raise handshake.AbortedByUserException("Aborted connection to " + client)            
    finally:
        debug ("closing WS connection to " + client)
        try:
            sock.close()
        except Exception as e:
            #debug(str(e))
            return

def web_socket_passive_closing_handshake(request):
    # Simply echo a close status code
    code, reason = request.ws_close_code, request.ws_close_reason
    
    client = str(request._request_handler.client_address)
    debug ("Passive close WS connection to " + client)

    # pywebsocket sets pseudo code for receiving an empty body close frame.
    if code == common.STATUS_NO_STATUS_RECEIVED:
        code = None
        reason = ''
    return code, reason
