
const int maxpins = 50;
//This is the number of flow sensors connected.
int numSensors = 5;
int pulsePin[maxpins];
//number of milliseconds to wait after pour before sending message
int pourMsgDelay = 300;
// the number of counts until a pour starts (used to filteer small flukes)
int pourTriggerValue = 10;
// the number of counts in the same time slice which are considered a kick
int kickTriggerValue = 30;
// the number of counts when a pour update will be send out
int updateTriggerValue = 200;

// data structures to keep current state
unsigned int pulseCount[maxpins];
unsigned int kickedCount[maxpins];
unsigned int updateCount[maxpins];
unsigned long nowTime;
unsigned long lastPourTime = 0;
unsigned long lastPinStateChangeTime[maxpins];
int lastPinState[maxpins];


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
  // send a stream of 'a' to signal the Pi we're alive
  establishContact();
  // config string is in the form:
  // 'C:<numSensors>:<sensor pin>:<...>:<pourMsgDelay>:<pourTriggerValue>:<kickTriggerValue>:<updateTriggerValue>'|
  
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
  pourMsgDelay = Serial.parseInt();
  while(':' != getsc());           // read ':'
  pourTriggerValue = Serial.parseInt();
  while(':' != getsc());           // read ':'
  kickTriggerValue = Serial.parseInt();
  while(':' != getsc());           // read ':'
  updateTriggerValue = Serial.parseInt();
  while('|' != getsc());           // read '|' (end of message)
  
  // echo back the config string with our own stuff
  Serial.print("C:");
  Serial.print(numSensors);
  for( int i = 0; i < numSensors; i++ ) {
    Serial.print(":");
    Serial.print(pulsePin[i]);
  }
  Serial.print(":");
  Serial.print(pourMsgDelay);
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
