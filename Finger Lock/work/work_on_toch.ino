#include <Servo.h>
const int green = 10;
const int red = 11;
const int gt = 6;
Servo myservo;
boolean stat, pred;
void setup() {
  // put your setup code here, to run once:
  myservo.attach(8);
  pinMode(green, OUTPUT);
  pinMode(red, OUTPUT);
  pinMode(gt, INPUT);
  boolean stat = false;
  myservo.write(173);
}

void loop() {
  if (digitalRead(gt) && stat == true) {
    unlock();
  }
  else if (digitalRead(gt) && stat == false) {
    lock();
  }
}
void unlock() {
  myservo.write(77);
  do
  {
    digitalWrite(green, HIGH);
    delay(50);
  } while (digitalRead(gt) == true);
  delay(5000);
  digitalWrite(green, LOW);
  delay(5);
  myservo.write(177);
  myservo.write(173);
  digitalWrite(red, HIGH);
  delay(2000);
  digitalWrite(red, LOW);
  stat = true;
}
void lock() {
  myservo.write(173);
  digitalWrite(red, HIGH);
  delay(250);
  digitalWrite(red, LOW);
  stat = true;
}
