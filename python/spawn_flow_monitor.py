import threading
import time

def spawn():
    import flow_monitor

def start():    
    t = threading.Thread(target=spawn)
    t.setDaemon(True)
    t.start()
    print("flow monitoring started")
