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
config['flowmon.debug' ] = False#True

#logging settings for pintdispatch
config['dispatch.debug' ] = False#True

#logging settings for load cells
config['loadcell.debug' ] = False#True

#logging settings for load cells
config['iSpindel.debug' ] = False#True

#Use fake monitoring to report flow
config['dispatch.debugMonitoring' ] = False

