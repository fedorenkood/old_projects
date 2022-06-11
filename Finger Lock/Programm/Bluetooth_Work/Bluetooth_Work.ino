#include <SoftwareSerial.h>
SoftwareSerial BTserial(2, 3); // RX | TX
// Connect the HC-06 TX to the Arduino RX on pin 2. 
// Connect the HC-06 RX to the Arduino TX on pin 3 through a voltage divider.
// 
#include <Servo.h>
int redPin = 9;
int greenPin = 10;
int bluePin = 11;
const int gt = 6;
Servo myservo;
boolean stat, pred;
 
void setup() 
{
    Serial.begin(9600);
    // HC-06 default serial speed is 9600
    BTserial.begin(9600); 
    myservo.attach(8);
    pinMode(redPin, OUTPUT);
    pinMode(greenPin, OUTPUT);
    pinMode(bluePin, OUTPUT);  
    pinMode(gt, INPUT);
    stat = false;
    myservo.write(173);
}
 
void loop()
{
  
    // Keep reading from HC-06 and send to Arduino Serial Monitor
    if (BTserial.available())
    {  
        Serial.write(BTserial.read());
    }
    
    if (digitalRead(gt) && stat == true) {
      unlock();
    }
    else if (BTserial.read()=='1' && stat == true) {
      funlock();
    }
    else if ((digitalRead(gt) && stat == false)||(BTserial.read()=='1' && stat == false)) {
      lock();
    }
}

//old code 
void setColor(int red, int green, int blue)
{
  #ifdef COMMON_ANODE
    red = 255 - red;
    green = 255 - green;
    blue = 255 - blue;
  #endif
  analogWrite(redPin, red);
  analogWrite(greenPin, green);
  analogWrite(bluePin, blue);  
}
void unlock() {
  myservo.write(77);
  do
  {
    digitalWrite(greenPin, HIGH);  
    delay(50);
  } while (digitalRead(gt) == true);
  delay(5000);
  digitalWrite(greenPin, LOW);  
  delay(5);
  myservo.write(177);
  myservo.write(173);
  digitalWrite(redPin, HIGH); // red
  delay(2000);
  digitalWrite(redPin, LOW); 
  stat = true;
}
void funlock() {
  myservo.write(77);
  digitalWrite(greenPin, HIGH);  
  delay(1000);
  digitalWrite(greenPin, LOW);  
  delay(5); 
  stat = false;
}
void lock() {
  myservo.write(173);
  digitalWrite(redPin, HIGH); // red
  delay(500);
  digitalWrite(redPin, LOW); 
  stat = true;
}

