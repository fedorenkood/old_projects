#define ctsPin 2 // пин для епкостного датчика касания
int ledPin = 13; // пин для светодиода
int redPin = 11;
int greenPin = 10;
int bluePin = 9;

boolean lastButton = LOW;
boolean currentButton = LOW;
boolean ledOn = false;

void setup() {
Serial.begin(9600);
pinMode(ledPin, OUTPUT);
pinMode(ctsPin, INPUT);
}

boolean debounce(boolean last)
{
boolean current = digitalRead(ctsPin);
if (last != current) {
delay(5);
current = digitalRead(ctsPin);
}
return current;
}

void loop() {
int ctsValue = digitalRead(ctsPin);
currentButton = debounce(lastButton);
int redValue = digitalRead(redPin);
if (ctsValue == LOW) {
  setColor(255, 0, 0);
delay(500);
setColor(0, 0, 0);
delay(2000);
}

if (ctsValue == HIGH) {
setColor(0, 255, 0);
delay(2000);
}
if (lastButton == HIGH && currentButton == LOW) {
setColor(255, 0, 0);
delay(500);
}
setColor(0, 0, 0);
return 0;

setColor(0, 0, 0);

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
