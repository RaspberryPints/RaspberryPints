
/*
 * This is the Arduino Code for Raspberry Pints.
 * Written by Kerber and mcangeli
 *
 */

/**
 * RFID Access Control
 *
 * Some of this code was inspired by Tom Igoe's RFID tutorial
 * From the ID-12 example code on the Arduino Playground
 * And HIGHLY based on Jonathan Oxer's project at:
 * http://www.practicalarduino.com/projects/medium/rfid-access-control
 */

// Set up the serial connection to the RFID reader module. In order to
// keep the Arduino TX and RX pins free for communication with a host,
// the sketch uses the SoftwareSerial library to implement serial
// communications on other pins.
#include <SoftwareSerial.h>

// The RFID module's TX pin needs to be connected to the Arduino. 

 #define rxPin 9 
 #define txPin 10 
#define unlockSeconds 2
// Create a software serial object for the connection to the RFID module
SoftwareSerial RFIDReader = SoftwareSerial( rxPin, txPin );


//#include <SPI.h> // SPI is used to control the OpenSegment Shield
//This line is the number of flow sensors connected.
const uint8_t numSensors = 4;
//This line initializes an array with the pins connected to the flow sensors
uint8_t pulsePin[] = {5,6,7,8};
//number of milliseconds to wait after pour before sending message
unsigned int pourMsgDelay = 300;

unsigned int pulseCount[numSensors];
unsigned int kickedCount[numSensors];
unsigned long nowTime;
unsigned long lastPourTime = 0;
unsigned long lastPinStateChangeTime[numSensors];
int lastPinState[numSensors];
char tagValue[10];

unsigned long lastSend = 0;

void setup() {
  pinMode(13, OUTPUT);
  // initialize serial communications at 9600 bps:
  Serial.begin(9600);
  RFIDReader.begin(9600);      // Serial port for connection to RFID module

  while (!Serial) {
    ; // wait for serial port to connect. Needed for Leonardo only
  }
  Serial.flush();
  for( int i = 0; i < numSensors; i++ ) {
    pinMode(pulsePin[i], INPUT);
    digitalWrite(pulsePin[i], HIGH);
    kickedCount[i] = 0;
    lastPinState[i] = digitalRead(pulsePin[i]);
  }
}

void loop() {
  nowTime = millis();
   pollPins();
  if ( (nowTime - lastPourTime) > pourMsgDelay && lastPourTime > 0) {
    //only send pour messages after all taps have stopped pulsing for a short period
    //use lastPourTime=0 to ensure this code doesn't get run constantly
  
    lastPourTime = 0;
    readRFID();
    checkPours();
    checkKicks();
    //Serial.println();
   fastLED();
  }

}

void pollPins() {
  for ( int i = 0; i < numSensors; i++ ) {
    int pinState = digitalRead(pulsePin[i]);
    if ( pinState != lastPinState[i] ) {
      if ( pinState == HIGH ) {
        //separate high speed pulses to detect kicked kegs
        if( nowTime - lastPinStateChangeTime[i] > 0 ){
          pulseCount[i] ++;
        }
        else{
          kickedCount[i] ++;
        }
        lastPinStateChangeTime[i] = nowTime;
        lastPourTime = nowTime;
      }
      lastPinState[i] = pinState;
    }
  }
}

// Code to read the RFID Tag
void readRFID() {
  byte r = 0;
  byte val = 0;
  byte code[6];
  byte checksum = 0;
  byte bytesread = 0;
  byte tempbyte = 0;
  char tagValue[10];
  
  if(RFIDReader.available() > 0) {
    if((val = RFIDReader.read()) == 2) {                  // check for header 
      bytesread = 0; 
      while (bytesread < 12) {                        // read 10 digit code + 2 digit checksum
        if( RFIDReader.available() > 0) { 
          val = RFIDReader.read();
           if (bytesread < 10)
      {
        tagValue[bytesread] = val;
      }
          if((val == 0x0D)||(val == 0x0A)||(val == 0x03)||(val == 0x02)) { // if header or stop bytes before the 10 digit reading 
            break;                                    // stop reading
          }

          // Do Ascii/Hex conversion:
          if ((val >= '0') && (val <= '9')) {
            val = val - '0';
          } else if ((val >= 'A') && (val <= 'F')) {
            val = 10 + val - 'A';
          }

          // Every two hex-digits, add byte to code:
          if (bytesread & 1 == 1) {
            // make some space for this hex-digit by
            // shifting the previous hex-digit with 4 bits to the left:
            code[bytesread >> 1] = (val | (tempbyte << 4));

            if (bytesread >> 1 != 5) {                // If we're at the checksum byte,
              checksum ^= code[bytesread >> 1];       // Calculate the checksum... (XOR)
            };
          } else {
            tempbyte = val;                           // Store the first hex digit first...
          };

          bytesread++;                                // ready to read next digit
        } 
      } 

      // Output to Serial:

      if (bytesread == 12) {
        // if 12 digit read is complete
        tagValue[10] = '\0';
        
        
        //Print the tag Value
        Serial.print("R;");
        Serial.print(tagValue);
        Serial.print(";");
             
        
        RFIDReader.flush();
        bytesread = 0;
      
    } 
      bytesread = 0;
      
    } 
  }
  
}

void fastLED() {
  digitalWrite(13, HIGH);
  delay(500);
  digitalWrite(13, LOW);
  delay(500);
  digitalWrite(13, HIGH);
  delay(500);
  digitalWrite(13, LOW);
  delay(500);
  digitalWrite(13, HIGH);
  delay(500);
  digitalWrite(13, LOW);
}

void longLED() {
  digitalWrite(13, HIGH);
  delay(3*1000);
  digitalWrite(13, LOW);
  
}
  
void checkPours() {
    
  for( int i = 0; i < numSensors; i++ ) {
    if ( pulseCount[i] > 0 ) {
      if ( pulseCount[i] > 50 ) {
      //filter out tiny bursts
        
        //sendPulseCount(0, pulsePin[i], pulseCount[i]);
        Serial.print("P;0;");
        Serial.print(pulsePin[i]);
        Serial.print(";");
        Serial.println(pulseCount[i]); 
      }
      pulseCount[i] = 0;
    }
  }
  
}

void checkKicks() {
  for( int i = 0; i < numSensors; i++ ) {
    if ( kickedCount[i] > 0 ) {
      if ( kickedCount[i] > 30 ) {
        //if there are enough high speed pulses, send a kicked message
        //sendKickedMsg(0, pulsePin[i]);
        Serial.print("K;0;");
        Serial.println(pulsePin[i]);
      }
      //reset the counter if any high speed pulses exist
      kickedCount[i] = 0;
    }
  }
}
