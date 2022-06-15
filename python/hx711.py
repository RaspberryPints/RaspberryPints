#From https://github.com/tatobari/hx711py

import time
import threading


GPIO_IMPORT_SUCCESSFUL = True
try:
    import RPi.GPIO as GPIO
except:
    GPIO_IMPORT_SUCCESSFUL = False
from Config import config

def debug(msg, process="HX711"):
    if(config['loadcell.debug']):
        log(msg, process, True)
                 
def log(msg, process="HX711", isDebug=False):
    if ("RFIDCheck" not in msg and "Status" not in msg) or log.lastMsg != msg:
        if log.logger is not None :
            log.logger.log(msg, process, isDebug)
        log.lastMsg = msg
    else:
        log.logger.logDB(msg, process, isDebug)
log.lastMsg = ""

class HX711:

    def __init__(self, 
                 name,
                 dout_pin, 
                 pd_sck_pin, 
                 logger=None,
                 scale_ratio=1,
                 tare_offset=0,
                 gain=128,
                 select_channel='A'):
        
        log.logger = logger
        debug(name + " Starting")
        
        self.nextEmulationByte = 0
        
        try:
            self.dout_pin = int(dout_pin)         
        except:
            raise TypeError('dout_pin_pin must be type int. '
                            'Received dout_pin_pin: {}'.format(dout_pin))
        try:
            self.pd_sck_pin = int(pd_sck_pin)
        except:
            raise TypeError('pd_sck_pin_pin must be type int. '
                                'Received pd_sck_pin_pin: {}'.format(pd_sck_pin))

        # Mutex for reading from the HX711, in case multiple threads in client
        # software try to access get values from the class at the same time.
        self.readLock = threading.Lock()
        
        if GPIO_IMPORT_SUCCESSFUL:
            GPIO.setup(self.pd_sck_pin, GPIO.OUT)
            GPIO.setup(self.dout_pin, GPIO.IN)

        self.GAIN = 0

        # The value returned by the hx711 that corresponds to your reference
        # unit AFTER dividing by the SCALE.
        self.REFERENCE_UNIT = 1
        self.REFERENCE_UNIT_B = 1

        self.OFFSET = 1
        self.OFFSET_B = 1
        self.lastVal = int(0)

        self.byte_format = 'MSB'
        self.bit_format = 'MSB'

        self.set_gain(gain)
        
        if scale_ratio != '' and scale_ratio is not None:
            self.set_reference_unit(scale_ratio)
        if tare_offset != '' and tare_offset is not None:
            self.set_offset(int(tare_offset))
        debug("Init Finished Command " + str(pd_sck_pin) + " Rsp " + str(dout_pin))

        # Think about whether this is necessary.
        time.sleep(1)

        
    def convertFromTwosComplement24bit(self, inputValue):
        return -(inputValue & 0x800000) + (inputValue & 0x7fffff)

    
    def is_ready(self):
        if GPIO_IMPORT_SUCCESSFUL:
            return GPIO.input(self.dout_pin) == 0
        return True

    
    def set_gain(self, gain):
        if gain == 128:
            self.GAIN = 1
        elif gain == 64:
            self.GAIN = 3
        elif gain == 32:
            self.GAIN = 2

        if GPIO_IMPORT_SUCCESSFUL:
            GPIO.output(self.pd_sck_pin, False)

        # Read out a set of raw bytes and throw it away.
        self.readRawBytes()

        
    def get_gain(self):
        if self.GAIN == 1:
            return 128
        if self.GAIN == 3:
            return 64
        if self.GAIN == 2:
            return 32

        # Shouldn't get here.
        return 0
        

    def readNextBit(self):
       # Clock HX711 Digital Serial Clock (pd_sck_pin).  dout_pin will be
       # ready 1us after pd_sck_pin rising edge, so we sample after
       # lowering PD_SCL, when we know dout_pin will be stable.
       if GPIO_IMPORT_SUCCESSFUL:
           GPIO.output(self.pd_sck_pin, True)
           GPIO.output(self.pd_sck_pin, False)
           value = GPIO.input(self.dout_pin)
       else:
            value = 0

       # Convert Boolean to int and return it.
       return int(value)


    def readNextByte(self):
       byteValue = 0

       # Read bits and build the byte from top, or bottom, depending
       # on whether we are in MSB or LSB bit mode.
       for x in range(8):
          if self.bit_format == 'MSB':
             byteValue <<= 1
             byteValue |= self.readNextBit()
          else:
             byteValue >>= 1              
             byteValue |= self.readNextBit() * 0x80

       # Return the packed byte.
       return byteValue 
        

    def readRawBytes(self):
        # Wait for and get the Read Lock, incase another thread is already
        # driving the HX711 serial interface.
        self.readLock.acquire()

        # Wait until HX711 is ready for us to read a sample.
        while not self.is_ready():
           pass

        # Read three bytes of data from the HX711.
        firstByte  = self.readNextByte()
        secondByte = self.readNextByte()
        thirdByte  = self.readNextByte()

        # HX711 Channel and gain factor are set by number of bits read
        # after 24 data bits.
        for i in range(self.GAIN):
           # Clock a bit out of the HX711 and throw it away.
           self.readNextBit()

        # Release the Read Lock, now that we've finished driving the HX711
        # serial interface.
        self.readLock.release()           

        # Depending on how we're configured, return an orderd list of raw byte
        # values.
        if self.byte_format == 'LSB':
           return [thirdByte, secondByte, firstByte]
        else:
           return [firstByte, secondByte, thirdByte]


    def read_long(self):
        # Get a sample from the HX711 in the form of raw bytes.
        dataBytes = self.readRawBytes()


        debug("Raw Byte Values %s" % str(dataBytes))
        
        # Join the raw bytes into a single 24bit 2s complement value.
        twosComplementValue = ((dataBytes[0] << 16) |
                               (dataBytes[1] << 8)  |
                               dataBytes[2])

        debug("Twos: 0x%06x" % twosComplementValue)
        
        # Convert from 24bit twos-complement to a signed value.
        signedIntValue = self.convertFromTwosComplement24bit(twosComplementValue)

        # Record the latest sample value we've read.
        self.lastVal = signedIntValue

        # Return the sample value we've read from the HX711.
        return int(signedIntValue)

    
    def read_average(self, times=3):
        # Make sure we've been asked to take a rational amount of samples.
        if times <= 0:
            raise ValueError("HX711()::read_average(): times must >= 1!!")

        # If we're only average across one value, just read it and return it.
        if times == 1:
            return self.read_long()

        # If we're averaging across a low amount of values, just take the
        # median.
        if times < 5:
            return self.read_median(times)

        # If we're taking a lot of samples, we'll collect them in a list, remove
        # the outliers, then take the mean of the remaining set.
        valueList = []

        for x in range(times):
            valueList += [self.read_long()]

        valueList.sort()

        # We'll be trimming 20% of outlier samples from top and bottom of collected set.
        trimAmount = int(len(valueList) * 0.2)

        # Trim the edge case values.
        valueList = valueList[trimAmount:-trimAmount]

        # Return the mean of remaining samples.
        return sum(valueList) / len(valueList)


    # A median-based read method, might help when getting random value spikes
    # for unknown or CPU-related reasons
    def read_median(self, times=3):
       if times <= 0:
          raise ValueError("HX711::read_median(): times must be greater than zero!")
      
       # If times == 1, just return a single reading.
       if times == 1:
          return self.read_long()

       valueList = []

       for x in range(times):
          valueList += [self.read_long()]

       valueList.sort()

       # If times is odd we can just take the centre value.
       if (times & 0x1) == 0x1:
          return valueList[len(valueList) // 2]
       else:
          # If times is even we have to take the arithmetic mean of
          # the two middle values.
          midpoint = len(valueList) / 2
          return sum(valueList[midpoint:midpoint+2]) / 2.0


    # Compatibility function, uses channel A version
    def get_value(self, times=3):
        return self.get_value_A(times)


    def get_value_A(self, times=3):
        return self.read_median(times) - self.get_offset_A()


    def get_value_B(self, times=3):
        # for channel B, we need to set_gain(32)
        g = self.get_gain()
        self.set_gain(32)
        value = self.read_median(times) - self.get_offset_B()
        self.set_gain(g)
        return value

    # Compatibility function, uses channel A version
    def get_weight_mean(self, times=3):
        return self.get_weight(times)
        
    # Compatibility function, uses channel A version
    def get_weight(self, times=3):
        if GPIO_IMPORT_SUCCESSFUL:
            return self.get_weight_A(times)
        else:
            self.nextEmulationByte = (self.nextEmulationByte%20)+1
            return self.nextEmulationByte


    def get_weight_A(self, times=3):
        value = self.get_value_A(times)
        value = value / self.REFERENCE_UNIT
        return value

    def get_weight_B(self, times=3):
        value = self.get_value_B(times)
        value = value / self.REFERENCE_UNIT_B
        return value

    
    # Sets tare for channel A for compatibility purposes
    def tare(self, times=15):
        self.tare_A(times)
    
    
    def tare_A(self, times=15):
        # Backup REFERENCE_UNIT value
        backupReferenceUnit = self.get_reference_unit_A()
        self.set_reference_unit_A(1)
        
        value = self.read_average(times)

        log("Tare A value:", value)
        
        self.set_offset_A(value)

        # Restore the reference unit, now that we've got our offset.
        self.set_reference_unit_A(backupReferenceUnit)

        return value


    def tare_B(self, times=15):
        # Backup REFERENCE_UNIT value
        backupReferenceUnit = self.get_reference_unit_B()
        self.set_reference_unit_B(1)

        # for channel B, we need to set_gain(32)
        backupGain = self.get_gain()
        self.set_gain(32)

        value = self.read_average(times)

        log("Tare B value:", value)
        
        self.set_offset_B(value)

        # Restore gain/channel/reference unit settings.
        self.set_gain(backupGain)
        self.set_reference_unit_B(backupReferenceUnit)
       
        return value


    
    def set_reading_format(self, byte_format="LSB", bit_format="MSB"):
        if byte_format == "LSB":
            self.byte_format = byte_format
        elif byte_format == "MSB":
            self.byte_format = byte_format
        else:
            raise ValueError("Unrecognised byte_format: \"%s\"" % byte_format)

        if bit_format == "LSB":
            self.bit_format = bit_format
        elif bit_format == "MSB":
            self.bit_format = bit_format
        else:
            raise ValueError("Unrecognised bitformat: \"%s\"" % bit_format)

            


    # sets offset for channel A for compatibility reasons
    def set_offset(self, offset):
        self.set_offset_A(offset)

    def set_offset_A(self, offset):
        self.OFFSET = offset

    def set_offset_B(self, offset):
        self.OFFSET_B = offset

    def get_offset(self):
        return self.get_offset_A()

    def get_offset_A(self):
        return self.OFFSET

    def get_offset_B(self):
        return self.OFFSET_B


    
    def set_reference_unit(self, reference_unit):
        self.set_reference_unit_A(reference_unit)

        
    def set_reference_unit_A(self, reference_unit):
        # Make sure we aren't asked to use an invalid reference unit.
        if reference_unit == 0:
            raise ValueError("HX711::set_reference_unit_A() can't accept 0 as a reference unit!")
            return

        self.REFERENCE_UNIT = reference_unit

        
    def set_reference_unit_B(self, reference_unit):
        # Make sure we aren't asked to use an invalid reference unit.
        if reference_unit == 0:
            raise ValueError("HX711::set_reference_unit_A() can't accept 0 as a reference unit!")
            return

        self.REFERENCE_UNIT_B = reference_unit


    def get_reference_unit(self):
        return get_reference_unit_A()

        
    def get_reference_unit_A(self):
        return self.REFERENCE_UNIT

        
    def get_reference_unit_B(self):
        return self.REFERENCE_UNIT_B
        
        
    def power_down(self):
        # Wait for and get the Read Lock, incase another thread is already
        # driving the HX711 serial interface.
        self.readLock.acquire()

        # Cause a rising edge on HX711 Digital Serial Clock (pd_sck_pin).  We then
        # leave it held up and wait 100 us.  After 60us the HX711 should be
        # powered down.
        if GPIO_IMPORT_SUCCESSFUL:
            GPIO.output(self.pd_sck_pin, False)
            GPIO.output(self.pd_sck_pin, True)

        time.sleep(0.0001)

        # Release the Read Lock, now that we've finished driving the HX711
        # serial interface.
        self.readLock.release()           


    def power_up(self):
        # Wait for and get the Read Lock, incase another thread is already
        # driving the HX711 serial interface.
        self.readLock.acquire()

        # Lower the HX711 Digital Serial Clock (pd_sck_pin) line.
        if GPIO_IMPORT_SUCCESSFUL:
            GPIO.output(self.pd_sck_pin, False)

        # Wait 100 us for the HX711 to power back up.
        time.sleep(0.0001)

        # Release the Read Lock, now that we've finished driving the HX711
        # serial interface.
        self.readLock.release()

        # HX711 will now be defaulted to Channel A with gain of 128.  If this
        # isn't what client software has requested from us, take a sample and
        # throw it away, so that next sample from the HX711 will be from the
        # correct channel/gain.
        if self.get_gain() != 128:
            self.readRawBytes()


    def reset(self):
        self.power_down()
        self.power_up()


# EOF - hx711.py