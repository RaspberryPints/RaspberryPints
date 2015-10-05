
const unsigned int maxpins = 20;
//This line is the number of flow sensors connected.
uint8_t numSensors = 5;
//This line initializes an array with the pins connected to the flow sensors
uint8_t pulsePin[] = {5,6,7,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25};
//number of milliseconds to wait after pour before sending message
unsigned int pourMsgDelay = 300;

unsigned int pulseCount[maxpins];
unsigned int kickedCount[maxpins];
unsigned int updateCount[maxpins];
unsigned long nowTime;
unsigned long lastPourTime = 0;
unsigned long lastPinStateChangeTime[maxpins];
int lastPinState[maxpins];

int pourTriggerValue = 10;
int kickTriggerValue = 30;
int updateTriggerValue = 200;


unsigned long lastSend = 0;

void setup() {
  int readByte = 0;
  pinMode(13, OUTPUT);
  // initialize serial communications at 9600 bps:
  Serial.begin(9600);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for Leonardo only
  }
  Serial.flush();

  while(Serial.available()) {
    Serial.read();
  }

  establishContact();
  // config string is in the form:
  // 'C:<numSensors>:<sensor pin>:<...>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'|
  
  while('C' != getsc());       // wait for 'C'
  while(':' != getsc());       // read ':'
  numSensors = Serial.parseInt();        // num sensors
  
  
  for( int i = 0; i < numSensors; i++ ) {
    while(':' != getsc());                    // read ':'
    pulsePin[i] = Serial.parseInt();          // read pulse pin for given slot
    
    pinMode(pulsePin[i], INPUT);
    digitalWrite(pulsePin[i], HIGH);
    kickedCount[i] = 0;
    updateCount[i] = 0;
    lastPinState[i] = digitalRead(pulsePin[i]);
  }
  
  while(':' != getsc());           // read ':'
  pourTriggerValue = Serial.parseInt();
  while(':' != getsc());           // read ':'
  kickTriggerValue = Serial.parseInt();
  while(':' != getsc());           // read ':'
  updateTriggerValue = Serial.parseInt();
  while('|' != getsc());           // read '|' (end of message)
  
  Serial.print("C:");
  Serial.print(numSensors);
  for( int i = 0; i < numSensors; i++ ) {
    Serial.print(":");
    Serial.print(pulsePin[i]);
  }
  Serial.print(":");
  Serial.print(pourTriggerValue);
  Serial.print(":");
  Serial.print(kickTriggerValue);
  Serial.print(":");
  Serial.print(updateTriggerValue);
  Serial.println("|");
}

void loop() {
  nowTime = millis();
  pollPins();
  checkUpdate();
  if ( (nowTime - lastPourTime) > pourMsgDelay && lastPourTime > 0) {
    //only send pour messages after all taps have stopped pulsing for a short period
    //use lastPourTime=0 to ensure this code doesn't get run constantly
    lastPourTime = 0;
    checkPours();
    checkKicks();
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
          updateCount[i] ++;
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

void checkPours() {
  for( int i = 0; i < numSensors; i++ ) {
    if ( pulseCount[i] > 0 ) {
      if ( pulseCount[i] > pourTriggerValue ) {
      //filter out tiny bursts
        sendPulseCount(0, pulsePin[i], pulseCount[i]);
      }
      pulseCount[i] = 0;
      updateCount[i] = 0;
    }
  }
}

void checkUpdate() {
  for( int i = 0; i < numSensors; i++ ) {
    if ( updateCount[i] > updateTriggerValue ) {
        sendUpdateCount(0, pulsePin[i], pulseCount[i]);
        updateCount[i] = 0;
    }
  }
}

void checkKicks() {
  for( int i = 0; i < numSensors; i++ ) {
    if ( kickedCount[i] > 0 ) {
      if ( kickedCount[i] > kickTriggerValue ) {
        //if there are enough high speed pulses, send a kicked message
        sendKickedMsg(0, pulsePin[i]);
      }
      //reset the counter if any high speed pulses exist
      kickedCount[i] = 0;
    }
  }
}
