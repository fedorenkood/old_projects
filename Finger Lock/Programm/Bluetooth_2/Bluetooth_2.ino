
#include <SoftwareSerial.h>
SoftwareSerial mySerial(2, 3); // RX | TX
char c;
int  LED = 7;
 
void setup() 
{
    Serial.begin(9600);
    pinMode(LED, OUTPUT);
    mySerial.begin(9600);  
}
 
void loop()
{
  while (mySerial.available()){
  
  c = mySerial.read();
  if (c == '1') 
  {
    digitalWrite(LED, HIGH);
  }
  if (c == '0') 
  {
    digitalWrite(LED, LOW);
  } 
  }
}
