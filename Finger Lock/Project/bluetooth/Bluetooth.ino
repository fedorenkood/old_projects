#include <SoftwareSerial.h>
char c;
int redPin = 11;
int greenPin = 10;
int bluePin = 9;
const byte rxPin = 0;
const byte txPin = 1;

// set up a new serial object
SoftwareSerial mySerial (rxPin, txPin);
/**
 * connect bluetooth
 */
void setup()
{
  pinMode(redPin, OUTPUT);
  pinMode(greenPin, OUTPUT);
  pinMode(bluePin, OUTPUT);
  mySerial.begin(9600);
}

void loop()
{
  while (!mySerial.available());
  c = mySerial.read();
  if (c == '1')
  {
    setColor(255, 0, 0);
  }
  if (c == '0')
  {
    setColor(0, 0, 0);
  }
}


void setColor(int red, int green, int blue)
{
#ifdef COMMON_ANODE
red = 255 - red;
green = 255 - green;
blue = 1 - blue;
#endif
analogWrite(redPin, red);
analogWrite(greenPin, green);
analogWrite(bluePin, blue);
}
