#include <Servo.h>

int ledPin = 13; // пин для светодиода
int redPin = 11;
int greenPin = 10;
int bluePin = 9;
#define ctsPin 2 // пин для епкостного датчика касания

boolean lastButton = LOW;
boolean currentButton = LOW;
int ledMode = 0;

Servo myservo;

void setup ()
{
  pinMode(redPin, OUTPUT);
  pinMode(greenPin, OUTPUT);
  pinMode(bluePin, OUTPUT);
  pinMode(ctsPin, INPUT);
  myservo.attach(8);
}

boolean debounce(boolean last)
{
  boolean current = digitalRead(ctsPin);
  if (last != current)
  {
    delay(5);
    current = digitalRead(ctsPin);
    return current;
  }
}

void setMode(int mode)
{
  // Открыто
  if (mode == 1)
  {
    int ctsValue = digitalRead(ctsPin);
    myservo.write(90);
    if (ctsValue == HIGH) {
    setColor(0, 255, 0);
    delay(2000);
  }
  }
  // Закрыто
  else
  {
    myservo.write(0);
    setColor(0, 0, 0);
  }
}

void loop()
{
  currentButton = debounce(lastButton);
  int SerRead = myservo.read();
  
  if (lastButton == LOW && currentButton == HIGH)
  {
    ledMode++;
  }
  lastButton = currentButton;

  if (ledMode == 2)
    ledMode = 0;
  setMode(ledMode);
}


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

