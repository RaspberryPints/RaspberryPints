import sys
from mod_pywebsocket import common
from PintDispatch import PintDispatch

def index(req):
    dispatch = PintDispatch()
    return "Test successful %s", sys.path;
