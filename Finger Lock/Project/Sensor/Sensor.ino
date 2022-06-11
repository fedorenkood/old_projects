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
  boolean curent = digitalRead(ctsPin);
  if (last != current) {
    delay(5);
    current = digitalRead(ctsPin);
  }
  return current;
}

void loop() {
  currentButton = debounce(lastButton);
  if (lastButton == LOW && currentButton == HIGH) {
    ledOn = !ledOn;
  }
  lastButton = currentButton;
  digitalWrite(ledPin, ledOn);
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
