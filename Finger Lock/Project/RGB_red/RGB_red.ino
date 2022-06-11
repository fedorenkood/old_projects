int ledPin = 12; // пин для светодиода
int redPin = 11;
int greenPin = 10;
int bluePin = 9;
#define ctsPin 6 // пин для епкостного датчика касания

boolean lastButton = LOW;
boolean currentButton = LOW;
int ledMode = 0;

void setup ()
{
  pinMode(redPin, OUTPUT);
  pinMode(greenPin, OUTPUT);
  pinMode(bluePin, OUTPUT);
  pinMode(ctsPin, INPUT);
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
  // Красный
  if (mode == 1)
  {
    setColor(0, 0, 0);
  }
  // Зеленый
  else if (mode == 2)
  {
    setColor(0, 255, 0);
  }
  // Выключен (mode = 0)
  else
  {
    setColor(255, 0, 0);
  }
}

void loop()
{
  currentButton = debounce(lastButton);
  if (lastButton == LOW && currentButton == HIGH)
  {
    ledMode++;
  }
  lastButton = currentButton;

  if (ledMode == 3)
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

