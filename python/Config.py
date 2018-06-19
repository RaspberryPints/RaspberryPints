config = {}

# the dir everything lives in
config['pints.dir' ] = '/var/www/html/'
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
#Use fake monitoring to report flow
config['dispatch.debugMonitoring' ] = False
# restart line cooling timer if a pour happens
config['dispatch.restart_fan_after_pour'] = False
# valve types, in here for now
config['dispatch.valve_type'] = 'two_pin_solenoid'
#config['dispatch.valve_type'] = 'three_pin_ballvalve'

