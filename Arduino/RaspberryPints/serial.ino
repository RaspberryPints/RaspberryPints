void sendPulseCount(uint8_t addr, int pinNum, unsigned int pulseCount) {
  Serial.print("P;");
  Serial.print(addr);
  Serial.print(";");
  Serial.print(pinNum);
  Serial.print(";");
  Serial.println(pulseCount);
}

void sendKickedMsg(uint8_t addr, int pinNum) {
  Serial.print("K;");
  Serial.print(addr);
  Serial.print(";");
  Serial.println(pinNum);
}
