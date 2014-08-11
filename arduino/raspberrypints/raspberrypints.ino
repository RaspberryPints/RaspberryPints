//This line is the number of flow sensors connected.
const uint8_t numSensors = 4;
//This line initializes an array with the pins connected to the flow sensors
uint8_t pulsePin[] = {8,9,10,11};
//number of milliseconds to wait after pour before sending message
unsigned int pourMsgDelay = 300;

unsigned int pulseCount[numSensors];
unsigned int kickedCount[numSensors];
unsigned long nowTime;
unsigned long lastPourTime = 0;
unsigned long lastPinStateChangeTime[numSensors];
int lastPinState[numSensors];

unsigned long lastSend = 0;

void setup() {
  pinMode(13, OUTPUT);
  // initialize serial communications at 9600 bps:
  Serial.begin(9600);
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
      if ( pulseCount[i] > 100 ) {
      //filter out tiny bursts
        sendPulseCount(0, pulsePin[i], pulseCount[i]);
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
        sendKickedMsg(0, pulsePin[i]);
      }
      //reset the counter if any high speed pulses exist
      kickedCount[i] = 0;
    }
  }
}
