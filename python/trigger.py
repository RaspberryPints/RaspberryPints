import sys
from mod_python import apache
import socket

MCAST_PORT = 0xBEE2
HOST = 'localhost'

def parseGet(req):
    req.add_common_vars()
    env_vars = req.subprocess_env   
    getReqStr = env_vars['QUERY_STRING']
    getReqArr = getReqStr.split('&')
    getReqDict = {}
    if len(getReqArr) < 1:
        return getReqDict
    for item in getReqArr:
        tempArr = item.split('=')
        getReqDict[tempArr[0]] = tempArr[1]
    return getReqDict
       
def index(req):
    
    received = "RPNAK"
    
    # parse, check and get HTTP GET parameters
    gets = parseGet(req)
    if ( not 'value' in gets ):
        apache.log_error("RPINTS trigger: no value in gets")
        req.content_type = "text/plain"
        req.write(received)
        return apache.OK    
        
    value = gets['value']
    
    # connect to rpints dispatcher and send the valve command
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    if(value == "valve"):
        data = "RPC:valve"
    elif (value == "fan"):
        data = "RPC:fan"
    elif (value == "flow"):
        data = "RPC:flow"
    else:
        apache.log_error("RPINTS trigger: value not recognized")
        req.content_type = "text/plain"
        req.write(received)
        return apache.OK    
        
    try:
        sock.connect((HOST, MCAST_PORT))
        sock.sendall(data + "\n")
        received = sock.recv(1024)
    finally:
        sock.close()
        req.content_type = "text/plain"
        req.write(received)
        return apache.OK    
