config = {}

# the dir everything lives in
config['pints.dir' ] = '/var/www'
#the serial port to the alamode
config['flowmon.port'] = '/dev/ttyS0'
#The following line is for serial over USB
#config['flowmon.port' ] = '/dev/ttyACM0'
#The following line is for serial over bluetooth
#config['flowmon.port'] = '/dev/rfcomm0'

#logging settings for flowmon
config['flowmon.debug' ] = True

#logging settings for pintdispatch
config['dispatch.debug' ] = True
# restart line cooling timer if a pour happens
config['dispatch.restart_fan_after_pour'] = False
