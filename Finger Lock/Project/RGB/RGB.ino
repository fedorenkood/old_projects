/*
Adafruit Arduino - RGB светодиод подробная инструкция на сайте:
arduino-diy.com
*/
byte lol;
void setup() {
Serial.begin(9600);
pinMode(13,1);
}

void loop(){
  if (Serial.available() > 0){
    lol=Serial.read();
    if (lol=='1') {
      digitalWrite(13,1);
    }
    if (lol=='0') {
      digitalWrite(13,0);
    }
  }
  delay(3);
}


