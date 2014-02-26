//This line is the number of flow sensors connected.
const uint8_t numSensors = 3;
//This line initializes an array with the pins connected to the flow sensors
uint8_t pulsePin[] = {8,9,10};
//number of milliseconds to wait after pour before sending message
unsigned int pourMsgDelay = 300;

unsigned long pulseCount[numSensors];
unsigned long nowTime;
unsigned long lastPourTime = 0;
unsigned long lastPinStateChangeTime[numSensors];
boolean kicked[numSensors];
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
    kicked[i] = false;
    lastPinState[i] = digitalRead(pulsePin[i]);
  }
}

void loop() {
  nowTime = millis();
  pollPins();
  if ( (nowTime - lastPourTime) > pourMsgDelay ) {
    //this ensures that the last pour message is only sent once
    if ( lastPourTime > 0 ) {
      lastPourTime = 0;
      checkPulseCount();
    }
    checkKicked();
  }
}

void pollPins() {
  for ( int i = 0; i < numSensors; i++ ) {
    int pinState = digitalRead(pulsePin[i]);
    if ( pinState != lastPinState[i] ) {
      if ( pinState == HIGH ) {
        //don't count pulses for now if the keg was kicked
        if (!kicked[i]) {
          //check if the pour speed was > 1khz. Signals an empty keg
          if( nowTime - lastPinStateChangeTime[i] > 0 ){
            pulseCount[i] += 1;
          }
          else{
            kicked[i] = true;
          }
        }
        lastPinStateChangeTime[i] = nowTime;
        lastPourTime = nowTime;
      }
      lastPinState[i] = pinState;
    }
  }
}

void checkPulseCount() {
  for( int i = 0; i < numSensors; i++ ) {
    if ( pulseCount[i] > 0 ) {
      //filter out tiny bursts
      if ( pulseCount[i] > 100 )
        sendPulseCount(0, pulsePin[i], pulseCount[i]);
      pulseCount[i] = 0;
    }
  }
}

void checkKicked() {
  for( int i = 0; i < numSensors; i++ ) {
    if ( kicked[i] ) {
      sendKickedMsg(0, pulsePin[i]);
      kicked[i] = false;
    }
  }
}
