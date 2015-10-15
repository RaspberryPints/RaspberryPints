void sendPulseCount(uint8_t addr, int pinNum, unsigned int pulseCount) {
  Serial.print("P;");
  Serial.print(addr);
  Serial.print(";");
  Serial.print(pinNum);
  Serial.print(";");
  Serial.println(pulseCount);
}

void sendUpdateCount(uint8_t addr, int pinNum, unsigned int count) {
  Serial.print("U;");
  Serial.print(addr);
  Serial.print(";");
  Serial.print(pinNum);
  Serial.print(";");
  Serial.println(count);
}

void sendKickedMsg(uint8_t addr, int pinNum) {
  Serial.print("K;");
  Serial.print(addr);
  Serial.print(";");
  Serial.println(pinNum);
}

void establishContact() {
  while (Serial.available() <= 0) {
    Serial.print('a');   // send 'a' to get the Pi side started after reset
    delay(300);
  }
}

int getsc() {
  while(!(Serial.available() > 0 ));
  return Serial.read();
}




