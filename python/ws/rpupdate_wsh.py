import socket
import struct
import select

MCAST_GRP = '224.1.1.1'
MCAST_PORT = 0xBEE2

def web_socket_do_extra_handshake(request):
    pass  # Always accept.

def web_socket_transfer_data(request):
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
    sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    sock.bind((MCAST_GRP, MCAST_PORT))  # use MCAST_GRP instead of '' to listen only to MCAST_GRP, not all groups on MCAST_PORT
    sock.setblocking(0)
    
    try:
        while True:
            try: 
                #keep apache socket alive by sending hello every 20 seconds
                ready = select.select([sock], [], [], 20.0)
                if ready[0]:
                    line = sock.recv(1024)
                else:
                    line = "RPH \n"
            finally:
                pass
    
            if not line is None:
                request.ws_stream.send_message(line, binary=False)
    finally:
        sock.close()

