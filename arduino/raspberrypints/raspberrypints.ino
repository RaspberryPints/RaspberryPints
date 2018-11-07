
/*
 * This is the Arduino Code for Raspberry Pints.
 * Written by Kerber and mcangeli
 *
 */

#include <Arduino.h>
#include <avr/interrupt.h>
#include <avr/pgmspace.h>

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
#define SERIAL_TIMEOUT 100

#define serialPrint(VALUE) Serial.print(VALUE)
#define serialPrintln(VALUE) Serial.println(VALUE)
#define serialFlush(VALUE) Serial.flush(VALUE)

#define CMD_READ_PINS     "RP"
#define CMD_WRITE_PINS    "WP"
#define CMD_SET_PINS_MODE "SM"
const char *MSG_DELIMETER   = ";";

#define LED_PIN 13
const int maxpins = 50;
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
// data structures to keep current state
volatile unsigned int pulseCount[maxpins];
volatile unsigned int kickedCount[maxpins];
volatile unsigned int updateCount[maxpins];
unsigned long lastPourTime[maxpins];
unsigned long lastPinStateChangeTime[maxpins];
int lastPinState[maxpins];
unsigned long nowTime;
unsigned long lastRfidCheckTime = 0;
unsigned long lastBlinkTime = 0;
unsigned long lastBlinkState = LOW;

unsigned long lastSend = 0;
int waitingStatusResponse = false;

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
  if(configDone != true) serialPrintln("Missing Configuration End");

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
  serialPrintln("|");


  setPinsMode(numSensors, pulsePin, INPUT);
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
  for( unsigned int i = 0; i < numSensors; i++ ) {
    nowTime = millis();
    if ( lastPourTime[i] <= 0 ) continue;
    if ( pulseCount[i] > 0 ) {
      //If pulse count has reached a point were we can assign the user to this tap
      if( pulseCount[i] > userPourTriggerValue &&
        activeUserId != INVALID_USER_ID && 
        userIdForPin[i] == INVALID_USER_ID) 
      {
        userIdForPin[i] = activeUserId;
        activeUserId = INVALID_USER_ID;
        if( useValves ) shutNonPouring = true;
      }
      //If we have enough pulses for a pour and no new pulses have come in we have a complete pour
      if ( (pulseCount[i] > pourTriggerValue && 
           (nowTime - lastPourTime[i]) > pourMsgDelay) )
      {
        //filter out tiny bursts
        sendPulseCount(userIdForPin[i], pulsePin[i], pulseCount[i]);
        reset = true;
        if( useValves ) shutNonPouring = true;
      }
      //If we have too many pulses for the valve to be open shut off the tap which will trigger a pour eventually
      else if ( useValves > 0 && 
              pourShutOffCount > 0 && 
              pulseCount[i] >= pourShutOffCount )
      {
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
        (nowTime - lastPourTime[i]) > pourMsgDelay ) {
        //if there are enough high speed pulses, send a kicked message
        sendKickedMsg(userIdForPin[i], pulsePin[i]);
        reset = true;
        if( useValves ) shutNonPouring = true;
      }
      if ( reset == true ) {
        //We had at activity on this pin, if it wasnt enough to trigger 
        //we want to reset so snowballing doesnt happen (i.e. small pulses turns into a pour)
        resetTap(i);
      }
      if ( useValves && shutNonPouring ) shutDownNonPouringTaps(i);

    }
  }
  fastLED();

  if( activeUserDate != -1UL && activeUserId != INVALID_USER_ID &&
    nowTime - activeUserDate > tapSelectTime )
  {
    activeUserId = INVALID_USER_ID;
    activeUserDate = nowTime;
    if ( useValves ) shutDownNonPouringTaps(-1);
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
        }
        else{
          kickedCount[i] ++;
        }
        lastPinStateChangeTime[i] = checkTime;
        lastPourTime[i] = checkTime;
      }
      lastPinState[i] = pinState;
    }
  }
}

void piStatusCheck(){
  char readMsg[INPUT_SIZE]; 
  int ii = 0;
  char *command = NULL;
  char *rfidState = NULL;
  char *curPart = readMsg;
  char *tagValue = NULL;
  char *reconfigReq = NULL;
  char *valveState = NULL;
  unsigned int tapNum = 0;
  int newState;
  int turnOnPins[numSensors];
  int turnOffPins[numSensors];
  int countOn = 0;
  int countOff = 0;

  memset(turnOnPins, 0, sizeof(turnOnPins));
  memset(turnOffPins, 0, sizeof(turnOffPins));
  memset(readMsg, 0, INPUT_SIZE);
  if(!waitingStatusResponse){
	  serialPrintln("StatusCheck;");
	  serialFlush();
	  waitingStatusResponse = true;
  }
  if(Serial.available() <= 0) return;
  while(ii < INPUT_SIZE)
  {
    readMsg[ii] = getsc();
    if(readMsg[ii] == '\n' || readMsg[ii] == '|'){
      readMsg[ii] = 0;
      break;
    }
    ii++;
  }

  command     = strtok(readMsg, MSG_DELIMETER); //Read Status (const)
  rfidState   = strtok(NULL, MSG_DELIMETER);
  tagValue    = strtok(NULL, MSG_DELIMETER);
  reconfigReq = strtok(NULL, MSG_DELIMETER);
  for(tapNum = 0; tapNum < numSensors; tapNum++){
	  valveState = strtok(NULL, MSG_DELIMETER);
	  if(!valveState) break;
	  newState = atoi(valveState);
	  if( newState != manualValveState[tapNum] ){
		 if(newState){
			 turnOnPins [countOn++] = valvesPin[tapNum];
	     //If not waiting to select a tap and tap is not pouring then we can shut off tap
		 }else if( activeUserId == INVALID_USER_ID &&
				   !isValvePinPouring(valvesPin[tapNum], tapNum) ){
			 turnOffPins[countOff++] = valvesPin[tapNum];
		 }
	  }
	  manualValveState[tapNum] = newState;
  }

  if(rfidState && strcmp(rfidState, "OK") == 0)
  {
    activeUserDate = millis();
    if(tagValue && activeUserId != atol(tagValue)){
      activeUserId = atol(tagValue);
      //serialPrint("RFID:");
      //serialPrintln(activeUserId);
      if(useValves > 0){
        writePins( numSensors, valvesPin, relayTrigger );
      }
    }
  }

  if(reconfigReq) reconfigRequired = atol(reconfigReq);

  //If any pins changed write them now
  if(turnOffPins[0] != 0) writePins(countOff, turnOffPins, !relayTrigger);
  if(turnOnPins [0] != 0) writePins(countOn,  turnOnPins,  relayTrigger);

  waitingStatusResponse = false;
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
  writePin(LED_PIN, state);
  lastBlinkState = state;
  lastBlinkTime = millis();
}

void resetTap(int tapNum){
  pulseCount[tapNum]   = 0;
  userIdForPin[tapNum] = INVALID_USER_ID;
  updateCount[tapNum]  = 0;
  lastPourTime[tapNum] = 0;
  kickedCount[tapNum]  = 0;
  if(useValves > 0){
    shutDownTap(tapNum);
  }/*else if(useRFID > 0 && activeUserId > 0){		
   		unsigned int pouring = false;
   		for( unsigned int i = 0; i < numSensors; i++ ) {
   			if(lastPourTime[i] > 0) {
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
    if(valvesPin[i] == valvePin && lastPourTime[i] > 0) {
      return true;
    }
  }
  return false;
}
void sendPulseCount(long rfidUser, int pinNum, unsigned int pulseCount) {
  serialPrint("P;");
  serialPrint(rfidUser);
  serialPrint(";");
  serialPrint(pinNum);
  serialPrint(";");
  serialPrintln(pulseCount);
}

void sendKickedMsg(long rfidUser, int pinNum) {
  serialPrint("K;");
  serialPrint(rfidUser);
  serialPrint(";");
  serialPrintln(pinNum);
}

void sendUpdateCount(long rfidUser, int pinNum, unsigned int count) {
  serialPrint("U;");
  serialPrint(rfidUser);
  serialPrint(";");
  serialPrint(pinNum);
  serialPrint(";");
  serialPrintln(count);
}

void establishContact() {
  serialPrintln("") ;
  while (Serial.available() <= 0) {
    serialPrintln("alive");   // send 'aaaa' to get the Pi side started after reset
    delay(100);
  }
}

int getsc() {
  return getsc_timeout(-1);
}

int getsc_timeout(long timeout) {
  unsigned long startTime = millis();
  while(Serial.available() <= 0 )
  {
    if( timeout > -1 && startTime + timeout < millis() ){
      return 0;
    } 
  }
  return Serial.read();
}

/**
 * Following are Pin helper function allowing requesting python to set the pin for Arduino
 */
void setPinMode(int pin, uint8_t state) {
  int	pins[2];
  pins[0] = pin;
  setPinsMode(1, pins, state);
}
void setPinsMode(int count, int pins[], uint8_t state) {
  int  ii = 0;
  int  pinCount = 0;
  int  pin;
  char msg[INPUT_SIZE];
  char pinStr[INPUT_SIZE];
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
      memset( pinStr, 0, sizeof(pinStr) );
      snprintf(pinStr, INPUT_SIZE, "%d", pin*-1);
      if( strlen(pinStr) + strlen(msg) + 1 < INPUT_SIZE)
      {
        snprintf(msg, INPUT_SIZE, "%s%s%s", msg, (msg[0]==0?"":";"), pinStr);
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
  char readMsg[INPUT_SIZE]; 
  char *curPart;
  if(pin > 0) {
    return digitalRead(pin);		
  }
  else if(pin < 0){
    serialPrint(CMD_READ_PINS";");
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
void writePin(int pin, uint8_t state) {
  int	pins[2];
  pins[0] = pin;
  writePins(1, pins, state);
}
void writePins(int count, int pins[], uint8_t state) {
  int  ii = 0;
  int  pinCount = 0;
  int  pin;
  char msg[INPUT_SIZE];
  char pinStr[INPUT_SIZE];
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
    }
    else if(pin < 0){
      memset( pinStr, 0, sizeof(pinStr) );
      snprintf(pinStr, INPUT_SIZE, "%d", pin*-1);
      if( strlen(pinStr) + strlen(msg) + 1 < INPUT_SIZE)
      {
        snprintf(msg, INPUT_SIZE, "%s%s%s", msg, (msg[0]==0?"":";"), pinStr);
        pinCount++;
      } 
      else 
      {
        //Not enough space in the string to write send what we have and retry pin
        sendPins(CMD_WRITE_PINS, pinCount, msg, state);
        pinCount = 0;
        memset( msg, 0, sizeof(msg) );
        ii--;
      }
    }
  }
  if ( msg [0] != 0 )
  {
    sendPins(CMD_WRITE_PINS, pinCount, msg, state);
  }
} // End writePin()

void sendPins(char *cmd, int count, char *msg, uint8_t state){
  unsigned long sendTime = millis();

  serialPrint(cmd);
  serialPrint(";");
  serialPrint(state);
  serialPrint(";");
  //If we dont have a count then we just want to send the message 
  if(count > 0){
    serialPrint(count);
    serialPrint(";");
  }
  serialPrint(msg);
  serialPrintln("");
  serialFlush();
  
  while(getsc_timeout(SERIAL_TIMEOUT) != '|' && sendTime+SERIAL_TIMEOUT > millis());
}//End sendPins






