
/*
 * This is the Arduino Code for Raspberry Pints.
 * Written by Kerber and mcangeli
 *
 */

#include <Arduino.h>
#include <avr/interrupt.h>
#include <avr/pgmspace.h>
#include <util/atomic.h> // this library includes the ATOMIC_BLOCK macro.

ISR (PCINT0_vect) // handle pin change interrupt for D8 to D13 here
{    
  pollPins();
} 
#if defined(PCINT1_vect)
ISR(PCINT1_vect, ISR_ALIASOF(PCINT0_vect));//Handle PCINT1 as if its PCINT0
#endif

#if defined(PCINT2_vect)
ISR(PCINT2_vect, ISR_ALIASOF(PCINT0_vect));//Handle PCINT2 as if its PCINT0
#endif

#if defined(PCINT3_vect)
ISR(PCINT3_vect, ISR_ALIASOF(PCINT0_vect));//Handle PCINT3 as if its PCINT0
#endif

#define INPUT_SIZE 50
#define RFID_TAG_LEN 11
#define INVALID_USER_ID -1
#define SERIAL_TIMEOUT 10
#define MAX_PIN_LENGTH 4
#define serialPrint(VALUE) Serial.print(VALUE)
#define serialPrintln(VALUE) Serial.println(VALUE);Serial.flush()
#define serialFlush() Serial.flush()

#define CMD_READ_PINS     "RP"
#define CMD_WRITE_PINS    F("WP")
#define CMD_UPDATE_PINS   F("UP")
#define CMD_SET_PINS_MODE F("SM")
#define MSG_DELIMETER   ";"

#define LED_PIN 13
const int maxpins = 30;
//This is the number of flow sensors connected.
unsigned int numSensors = 5;
int pulsePin[maxpins];
int valvesPin[maxpins];
int manualValveState[maxpins];
long userIdForPin[maxpins];
//The last OK RFID tag read
long activeUserId = INVALID_USER_ID;
unsigned long activeUserDate = -1;
unsigned long tapSelectTime = 30000;
//number of milliseconds to wait after pour before sending message
unsigned int pourMsgDelay = 300;
unsigned int rfidCheckDelay = 250;
// the number of counts until a pour starts (used to filter small flukes)
unsigned int pourTriggerValue = 10;
// the number of counts in the same time slice which are considered a kick
unsigned int kickTriggerValue = 30;
// the number of counts when a pour update will be send out
unsigned int updateTriggerValue = 200;
// the number of counts when a tap needs to be stopped
unsigned int pourShutOffCount = 700;
// the number of counts when a pour will trigger the user being assigned to the tap
unsigned int userPourTriggerValue = 50;
// the rfid should be read
unsigned int useRFID = 0;
// the Valves should be used
unsigned int useValves = 0;
unsigned int relayTrigger = 0;
unsigned int reconfigRequired = 0;
unsigned int debugEnabled = 0;
// data structures to keep current state
volatile unsigned int pulseCount[maxpins];
volatile unsigned int kickedCount[maxpins];
volatile unsigned int updateCount[maxpins];
volatile unsigned long lastPulseTime[maxpins];
volatile unsigned long lastPinStateChangeTime[maxpins];
int lastPinState[maxpins];
unsigned long nowTime;
unsigned long lastTapPulseTime;
unsigned long lastRfidCheckTime = 0;
unsigned long lastBlinkTime = 0;
unsigned long lastBlinkState = LOW;

unsigned long lastSend = 0;
int waitingStatusResponse = false;
void debug(char *sfmt, ...);
#define writePin(pin, value) _writePin(pin, value, true, __func__)
#define writePinUpdatePi(pin, value, updatePi) _writePin(pin, updatePi, true, __func__)

#define writePins( count, pins, state ) _writePins(count, pins, state, true, __func__)
#define sendPins(cmd, count, msg, state) _sendPins(cmd, count, msg, state, __func__)
// Install Pin change interrupt for a pin, can be called multiple times
void pciSetup(byte pin) 
{
  *digitalPinToPCMSK(pin) |= bit (digitalPinToPCMSKbit(pin));  // enable pin
  PCIFR  |= bit (digitalPinToPCICRbit(pin)); // clear any outstanding interrupt
  PCICR  |= bit (digitalPinToPCICRbit(pin)); // enable interrupt for the group 
}
int getSerialInteger(int *configDone){
  char readMsg[INPUT_SIZE]; 
  int ii = 0;
  while(ii < INPUT_SIZE)
  {
    readMsg[ii] = getsc();
    if(readMsg[ii] == '~'){
      serialPrintln("continue");
      ii = 0;
      continue;
    }
    if(readMsg[ii] == ':')break;
    if(readMsg[ii] == '|'){
      *configDone = true;
      break;
    }
    ii++;	
  }
  readMsg[ii] = 0;
  return atoi(readMsg);
}
void setup() {

  int configDone = false;

  // initialize serial communications at 9600 bps:
  Serial.begin(9600);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for Leonardo only
  }
  serialFlush();


  while(Serial.available()) {
    Serial.read();
  }
  // send a stream of 'a' to signal the Pi we're alive
  establishContact();

  while('C' != getsc());       // wait for 'C'  
  while(':' != getsc());       // read ':'

  numSensors = getSerialInteger(&configDone);
  for( unsigned int i = 0; i < numSensors; i++ ) {
    pulsePin[i] = getSerialInteger(&configDone);          // read pulse pin for given slot
  }  
  useValves = getSerialInteger(&configDone);
  if(useValves > 0){ 
    relayTrigger = getSerialInteger(&configDone);
    for( unsigned int i = 0; i < numSensors; i++ ) {
      valvesPin[i] = getSerialInteger(&configDone);
    }
  }
  pourMsgDelay = getSerialInteger(&configDone);
  pourTriggerValue = getSerialInteger(&configDone);
  kickTriggerValue = getSerialInteger(&configDone);
  updateTriggerValue = getSerialInteger(&configDone);
  pourShutOffCount = getSerialInteger(&configDone);
  useRFID = getSerialInteger(&configDone);
  debugEnabled = getSerialInteger(&configDone);
  if(configDone != true) serialPrintln(F("Missing Configuration End"));

  // echo back the config string with our own stuff
  serialPrint("C:");
  serialPrint(numSensors);
  for( unsigned int i = 0; i < numSensors; i++ ) {
    serialPrint(":");
    serialPrint(pulsePin[i]);
  }
  serialPrint(":");
  serialPrint(useValves);
  if(useValves > 0){	  
    serialPrint(":");
    serialPrint(relayTrigger);
    for( unsigned int i = 0; i < numSensors; i++ ) {
      serialPrint(":");
      serialPrint(valvesPin[i]);
    }
  }
  serialPrint(":");
  serialPrint(pourMsgDelay);
  serialPrint(":");
  serialPrint(pourTriggerValue);
  serialPrint(":");
  serialPrint(kickTriggerValue);
  serialPrint(":");
  serialPrint(updateTriggerValue);
  serialPrint(":");
  serialPrint(pourShutOffCount);
  serialPrint(":");
  serialPrint(useRFID);
  serialPrint(":");
  serialPrint(debugEnabled);
  serialPrintln("|");


  setPinsMode(numSensors, pulsePin, INPUT);
  writePins(numSensors, pulsePin, HIGH); //Enable pull-up resistors
  if(useValves > 0) setPinsMode(numSensors, valvesPin, OUTPUT);
  for( unsigned int i = 0; i < numSensors; i++ ) {    
    resetTap(i);
    lastPinState[i] = readPin(pulsePin[i]);
    pciSetup(pulsePin[i]);
  }

  setPinMode(LED_PIN, OUTPUT);
}

void loop() {
  if(reconfigRequired){
	  unsigned int j ;
	  for( j = 0; j < numSensors; j++ ) {
		  if(pulseCount[j] > 0) break;
	  }
	  if(j == numSensors){
		  if(reconfigRequired == 1)serialPrintln("dead;");
		  reconfigRequired = 2;
		  return;
	  }
  }
  nowTime = millis();
  if((nowTime - lastRfidCheckTime) > rfidCheckDelay || lastRfidCheckTime == 0 || waitingStatusResponse){
	  piStatusCheck();
	  lastRfidCheckTime = nowTime;
  }

  int shutNonPouring = false;
  int reset = false;
  int tapPouring = false;
  unsigned long lastTapPulseTime;
  for( unsigned int i = 0; i < numSensors; i++ ) {
    ATOMIC_BLOCK(ATOMIC_RESTORESTATE){
    	lastTapPulseTime = lastPulseTime[i];
    }
    if ( lastTapPulseTime <= 0 ) continue;
    shutNonPouring = false;
    reset = false;
    tapPouring = true;
    if ( pulseCount[i] > 0 ) {
      //If pulse count has reached a point were we can assign the user to this tap
      if( pulseCount[i] > userPourTriggerValue &&
        activeUserId != INVALID_USER_ID && 
        userIdForPin[i] == INVALID_USER_ID) 
      {
        userIdForPin[i] = activeUserId;
        activeUserId = INVALID_USER_ID;
        if( useValves ){
            debug("%s %d %d", "Tap Selected Pin", pulsePin[i], i);
        	shutNonPouring = true;
        }
      }
      nowTime = millis();
      //If no new pulses have come in awhile
      if ( (nowTime - lastTapPulseTime) > pourMsgDelay )
      {
        //only save pours that meet the trigger to filter out tiny bursts
    	if(pulseCount[i] > pourTriggerValue )
    	{
    		sendPulseCount(userIdForPin[i], pulsePin[i], pulseCount[i]);
    	}
    	//Reset no matter what, if there was not enough pulses to save the pour
    	//we want to reset to 0 so we dont accumulate until there is
    	reset = true;
    	//only stop nonPouringTaps if we have an update
        if( useValves && pulseCount[i] >= updateTriggerValue) shutNonPouring = true;
      }
      //If we have too many pulses for the valve to be open shut off the tap which will trigger a pour eventually
      else if ( useValves > 0 && 
              pourShutOffCount > 0 && 
              pulseCount[i] >= pourShutOffCount )
      {
        debug("%s %d %d", "Shutdown Tap too many pulses Pin", pulsePin[i], i);
        shutDownTap(i);
      }
      //If we just need to send an update
      else if ( updateCount[i] > updateTriggerValue ) 
      {
        sendUpdateCount(userIdForPin[i], pulsePin[i], pulseCount[i]);
        updateCount[i] = 0;
      }
      //If we detect a kck
      if ( kickedCount[i] > 0 && 
        kickedCount[i] > kickTriggerValue &&
        (nowTime - lastTapPulseTime) > pourMsgDelay ) {
        //if there are enough high speed pulses, send a kicked message
        sendKickedMsg(userIdForPin[i], pulsePin[i]);
        reset = true;
        if( useValves ) shutNonPouring = true;
      }
      if ( reset == true ) {
        //We had at activity on this pin, if it wasnt enough to trigger 
        //we want to reset so snowballing doesnt happen (i.e. small pulses turns into a pour)
    	//Only log if we have a major pulse count
        if( pulseCount[i] > 10 )debug("%s %d %d %lu %lu %lu %d %d %d",
              "RT L", pulsePin[i], i,
              nowTime, lastTapPulseTime, (nowTime-lastTapPulseTime),
              pourMsgDelay,
              pulseCount[i], pourTriggerValue);
        resetTap(i);
      }
      if ( useValves && shutNonPouring ){
          debug("%s %d %d %lu %lu %lu %d %d %d", "SD NP L ", pulsePin[i], i,
                nowTime, lastTapPulseTime, (nowTime-lastTapPulseTime), pourMsgDelay,
                pulseCount[i], pourTriggerValue);
    	  shutDownNonPouringTaps(i);
      }

    }
  }
  if(!tapPouring){
	  fastLED();
  }else{
	  longLED();
  }

  nowTime = millis();
  if( activeUserDate != -1UL && activeUserId != INVALID_USER_ID &&
      nowTime - activeUserDate > tapSelectTime )
  {
    activeUserId = INVALID_USER_ID;
    activeUserDate = nowTime;
    //If we already shut non-pouring dont do it again
    if ( useValves && !shutNonPouring ){
        debug(F("Shutdown All taps, no select"));
    	shutDownNonPouringTaps(-1);
    }
  }
}

void pollPins() {
  unsigned long checkTime = millis();
  for ( unsigned int i = 0; i < numSensors; i++ ) {
    int pinState = readPin(pulsePin[i]);
    if ( pinState != lastPinState[i] ) {
      if ( pinState == HIGH ) {
        //separate high speed pulses to detect kicked kegs
        if( checkTime - lastPinStateChangeTime[i] > 0 ){
          pulseCount[i] ++;
          updateCount[i] ++;
        }else{
          kickedCount[i] ++;
        }
        lastPulseTime[i] = lastPinStateChangeTime[i] = millis();
      }
      lastPinState[i] = pinState;
    }
  }
}

void piStatusCheck(){
  static char readMsg[INPUT_SIZE];
  int ii;
  char *command = NULL;
  char *rfidState = NULL;
  char *tagValue = NULL;
  char *reconfigReq = NULL;
  char *valveState = NULL;
  unsigned int tapNum;
  int newState;
  static unsigned long checkTime = 0;
  if( checkTime > 0 && waitingStatusResponse && millis() - checkTime > 1000)
  {
  	waitingStatusResponse = false;
  }

  memset(readMsg, 0, INPUT_SIZE);
  if(!waitingStatusResponse){
	  serialPrintln(F("StatusCheck;"));
	  serialFlush();
	  waitingStatusResponse = true;
	  checkTime = millis();
  }
  if(Serial.available() <= 0) return;
  ii = 0;
  while(ii + 1 < INPUT_SIZE)
  {
    readMsg[ii] = getsc_timeout(SERIAL_TIMEOUT);
    if(readMsg[ii] == 'S') ii = 0; //In case serial string starts over (S)tatus
    if(readMsg[ii] == '\n' || readMsg[ii] == '|' || readMsg[ii] == 0) break;
    ii++;
  }
  readMsg[ii] = 0;

  command     = strtok(readMsg, MSG_DELIMETER); //Read Status (const)
  if( strcmp(command, "Status") == 0){
	  rfidState   = strtok(NULL, MSG_DELIMETER);
	  tagValue    = strtok(NULL, MSG_DELIMETER);
	  reconfigReq = strtok(NULL, MSG_DELIMETER);
	  for(tapNum = 0; tapNum < numSensors; tapNum++){
		  valveState = strtok(NULL, MSG_DELIMETER);
		  if(!valveState) break;
		  newState = atoi(valveState);
		  if( newState != manualValveState[tapNum] ){
			 if(newState){
				  writePin(valvesPin[tapNum],  relayTrigger);
		     //If not waiting to select a tap and tap is not pouring then we can shut off tap
			 }else if( activeUserId == INVALID_USER_ID &&
					   !isValvePinPouring(valvesPin[tapNum], tapNum) ){
				  writePin(valvesPin[tapNum], !relayTrigger);
			 }
			 manualValveState[tapNum] = newState;
		  }
	  }


	  if(rfidState && strcmp(rfidState, "Y") == 0){
	    activeUserDate = millis();
	    if(tagValue && activeUserId != atol(tagValue)){
	      activeUserId = atol(tagValue);
          debug("%s%d", "RFID:", activeUserId);
	      if(useValves > 0){
	        writePins( numSensors, valvesPin, relayTrigger );
	      }
	    }
	  }

	  if(reconfigReq) reconfigRequired = atol(reconfigReq);

	  waitingStatusResponse = false;
  }
}

void fastLED() {
  LED(500);
}

void longLED() {
  LED(3000);  
}

void LED(unsigned int delay){
  if(useRFID > 0) return;
  if((millis() - lastBlinkTime) < delay) return;
  int state = LOW;
  if(lastBlinkState == LOW) state = HIGH;
  writePinUpdatePi(LED_PIN, state, false);
  lastBlinkState = state;
  lastBlinkTime = millis();
}

void resetTap(int tapNum){
  pulseCount[tapNum]   = 0;
  userIdForPin[tapNum] = INVALID_USER_ID;
  updateCount[tapNum]  = 0;
  lastPulseTime[tapNum] = 0;
  kickedCount[tapNum]  = 0;
  if(useValves > 0 && activeUserId == INVALID_USER_ID){
    shutDownTap(tapNum);
  }/*else if(useRFID > 0 && activeUserId > 0){		
   		unsigned int pouring = false;
   		for( unsigned int i = 0; i < numSensors; i++ ) {
   			if(lastPulseTime[i] > 0) {
   				pouring = true;
   				break;
   			}
   		}
   		if(pouring == false)activeUserId = 0;
   	}*/
}

void startUpTap(int tapNum){
  writePin(valvesPin[tapNum], relayTrigger);
}

void shutDownTap(int tapNum){
  //If the valve is not pouring and the User did not Manual Opened Valve Through UI, dont shut it off
  if(!isValvePinPouring(valvesPin[tapNum], tapNum) && !manualValveState[tapNum]){
    writePin(valvesPin[tapNum], !relayTrigger);
  }
}
void shutDownNonPouringTaps(unsigned int currentTap){
  int pins[maxpins];
  int count = 0;
  memset(&pins, 0, sizeof(pins));
  for( unsigned int i = 0; i < numSensors; i++ ) {
    if ( i == currentTap ) continue;
    if ( manualValveState[i] ) continue; //User Manual Opened Valve Through UI, dont shut it off
    if( !isValvePinPouring(valvesPin[i], i) ){
      pins[count++] = valvesPin[i];
    }
  }
  writePins(count, pins, !relayTrigger);
}
int isValvePinPouring(int valvePin, unsigned int currentTap){
  for( unsigned int i = 0; i < numSensors; i++ ) {
    if(i == currentTap) continue;
    if(valvesPin[i] == valvePin && (lastPulseTime[i] > 0 || pulseCount[i] > 0)) {
      return true;
    }
  }
  return false;
}
void sendPulseCount(long rfidUser, int pinNum, unsigned int pulseCount) {
  serialPrint("P;");
  serialPrint(rfidUser);
  serialPrint(MSG_DELIMETER);
  serialPrint(pinNum);
  serialPrint(MSG_DELIMETER);
  serialPrintln(pulseCount);
}

void sendKickedMsg(long rfidUser, int pinNum) {
  serialPrint("K;");
  serialPrint(rfidUser);
  serialPrint(MSG_DELIMETER);
  serialPrintln(pinNum);
}

void sendUpdateCount(long rfidUser, int pinNum, unsigned int count) {
  serialPrint("U;");
  serialPrint(rfidUser);
  serialPrint(MSG_DELIMETER);
  serialPrint(pinNum);
  serialPrint(MSG_DELIMETER);
  serialPrintln(count);
}

void establishContact() {
  unsigned long startTime;
  serialPrintln("") ;
  while (Serial.available() <= 0) {
    serialPrintln(F("alive"));   // send 'aaaa' to get the Pi side started after reset
    startTime = millis();
    while( Serial.available() <= 0 && millis() - startTime < 5000 ) delay(5);
  }
}

int getsc() {
  return getsc_timeout(-1);
}

int getsc_timeout(unsigned long timeout) {
  unsigned long startTime = millis();
  while(Serial.available() <= 0 )
  {
    if( timeout > -1 && millis() - startTime > timeout){
      return 0;
    } 
  }
  return Serial.read();
}

/**
 * Following are Pin helper function allowing requesting python to set the pin for Arduino
 */
void setPinMode(int pin, uint8_t state) {
  static int	pins[1];
  pins[0] = pin;
  setPinsMode(1, pins, state);
}
void setPinsMode(int count, int pins[], uint8_t state) {
  int  ii = 0;
  int  pinCount = 0;
  int  pin;
  static char msg[INPUT_SIZE];
  memset( msg, 0, sizeof(msg) );
  while (ii < count )
  {	
    pin = pins[ii++];
    //RFID uses SPI which has the CLOCK on pin 13
    if ( useRFID &&
      ( pin == 13 ) )
    {
      continue;
    }
    if(pin > 0) {
      pinMode(pin, state);		
    }
    else if(pin < 0){
      if( MAX_PIN_LENGTH + strlen(msg) + 1 < INPUT_SIZE)
      {
        snprintf(msg, INPUT_SIZE, "%s%s%d", msg, (msg[0]==0?"":MSG_DELIMETER), pin*-1);
        pinCount++;
      } 
      else 
      {
        //Not enough space in the string to write send what we have and retry pin
        sendPins(CMD_SET_PINS_MODE, pinCount, msg, state);
        pinCount = 0;
        memset( msg, 0, sizeof(msg) );
        ii--;
      }
    }
  }
  if ( msg [0] != 0 )
  {
    sendPins(CMD_SET_PINS_MODE, pinCount, msg, state);
  }
} // End setPinMode()
/**
 * Read A Pin helper allows requesting python to read the pin for Arduino
 */
unsigned char readPin(int pin) {
  static char readMsg[INPUT_SIZE];
  char *curPart;
  if(pin > 0) {
    return digitalRead(pin);		
  }
  else if(pin < 0){
    serialPrint(CMD_READ_PINS);
    serialPrint(MSG_DELIMETER);
    serialPrint(pin*-1);
    serialPrintln("");
    while(!Serial.available()) ;
    int ii = 0;
    curPart = readMsg;
    char* command = NULL;
    char *readPin = NULL;
    char *state   = NULL;
    while(ii < INPUT_SIZE)
    {
      readMsg[ii] = getsc();
      if(readMsg[ii] == ';' && !command){
        readMsg[ii] = 0;
        command = curPart;
        curPart = &(readMsg[ii+1]);
      }
      if(readMsg[ii] == ';' && !readPin){
        readMsg[ii] = 0;
        readPin = curPart;
        curPart = &(readMsg[ii+1]);
      }
      if(readMsg[ii] == ';' && !state){
        readMsg[ii] = 0;
        state = curPart;
        curPart = &(readMsg[ii+1]);
      }
      if(readMsg[ii] == '\n' || readMsg[ii] == '|'){
        readMsg[ii] = 0;
        break;
      }
      ii++;
    }
    if(state && atoi(state) != LOW)return HIGH;
    return LOW;
  }
  return -1;
} // End readPin()
/**
 * Write A Pin helper allows requesting python to write the pin for Arduino
 */
void _writePin(int pin, uint8_t state, int updatePi, char *func) {
  static int	pins[1];
  pins[0] = pin;
  _writePins(1, pins, state, updatePi, func);
}
void _writePins(int count, int pins[], uint8_t state, int updatePi, char *func) {
  int  ii = 0;
  int  pinCount = 0;
  int  pin;
  static char msg[INPUT_SIZE];
  static char update_msg[INPUT_SIZE];
  memset( msg, 0, sizeof(msg) );
  while (ii < count )
  {	
    pin = pins[ii++];
    //RFID uses SPI which has the CLOCK on pin 13
    if ( useRFID &&
      ( pin == 13 ) )
    {
      continue;
    }
    if(pin > 0) {
      digitalWrite(pin, state);		
      memset( update_msg, 0, sizeof(update_msg) );
      snprintf(update_msg, INPUT_SIZE, "%s%s%d", update_msg, (update_msg[0]==0?"":MSG_DELIMETER), pin);
      if( updatePi ) _sendPins(CMD_UPDATE_PINS, 1, update_msg, state, func);
    }
    else if(pin < 0){
      if( MAX_PIN_LENGTH + strlen(msg) + 1 < INPUT_SIZE)
      {
        snprintf(msg, INPUT_SIZE, "%s%s%d", msg, (msg[0]==0?"":MSG_DELIMETER), pin*-1);
        pinCount++;
      } 
      else 
      {
        //Not enough space in the string to write send what we have and retry pin
        _sendPins(CMD_WRITE_PINS, pinCount, msg, state, func);
        pinCount = 0;
        memset( msg, 0, sizeof(msg) );
        ii--;
      }
    }
  }
  if ( msg [0] != 0 )
  {
    _sendPins(CMD_WRITE_PINS, pinCount, msg, state, func);
  }
} // End writePin()

void _sendPins(const __FlashStringHelper *cmd, int count, char *msg, uint8_t state, char *func){
  unsigned long sendTime = millis();

  serialPrint(cmd);
  serialPrint(MSG_DELIMETER);
  serialPrint(state);
  serialPrint(MSG_DELIMETER);
  //If we dont have a count then we just want to send the message 
  if(count > 0){
    serialPrint(count);
    serialPrint(MSG_DELIMETER);
  }
  serialPrint(msg);
  serialPrint(MSG_DELIMETER);
  serialPrint(func);
  serialPrintln("");
  serialFlush();
  
  //while(Serial.available() <= 0 && millis()- sendTime < SERIAL_TIMEOUT);
  while(getsc_timeout(SERIAL_TIMEOUT) != '|' && millis()- sendTime < SERIAL_TIMEOUT);
}//End sendPins


void debug(const char *msg){
	if(debugEnabled){
		serialPrint(F("Debug;"));
		serialPrintln(msg);
	}
}
void debug(const __FlashStringHelper *msg){
	if(debugEnabled){
		serialPrint(F("Debug;"));
		serialPrintln(msg);
	}
}
void debug(char *sfmt, ...){
	if(debugEnabled){
		char temp[50];
		serialPrint(F("Debug;"));
		va_list l_arg;
		va_start(l_arg, sfmt);
		vsnprintf(temp, sizeof(temp), sfmt, l_arg);
		serialPrintln(temp);
		va_end(l_arg);
	}
}
void log(const char *msg){
	serialPrint(F("Log;"));
	serialPrintln(msg);
}
void log(const __FlashStringHelper *msg){
	serialPrint(F("Log;"));
	serialPrintln(msg);
}
