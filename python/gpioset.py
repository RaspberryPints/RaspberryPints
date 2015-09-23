import RPi.GPIO as GPIO
import sys, getopt

def main(argv):
	pin = ''
	value = ''
	try:
		opts, args = getopt.getopt(argv,"hp:v:",["pin=","value="])
	except getopt.GetoptError:
		print 'gpioset -p <pin> -v <value>'
		sys.exit(2)
	for opt, arg in opts:
		if opt == '-h':
			print 'gpioset -p <pin> -v <value>'
			sys.exit()
		elif opt in ("-p", "--pin"):
			pin = arg
		elif opt in ("-v", "--value"):
			value = arg
   
#	print 'pin is ', pin.strip()
#	print 'value is ', value.strip()
	GPIO.setwarnings(False)
	GPIO.setmode(GPIO.BCM) # Broadcom pin-numbering scheme
	GPIO.setup(int(pin), GPIO.OUT)
	if int(value) == 1 :
		GPIO.output(int(pin), GPIO.HIGH)
	else:
		GPIO.output(int(pin), GPIO.LOW)
      
#   GPIO.cleanup()

if __name__ == "__main__":
	main(sys.argv[1:])