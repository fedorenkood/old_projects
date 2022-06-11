int redPin = 11;
int greenPin = 10;
int bluePin = 9;
//уберите тег комментария со строки ниже, если вы используете светодиод с общим анодом
//#define COMMON_ANODE

void setup()
{
pinMode(redPin, OUTPUT);
pinMode(greenPin, OUTPUT);
pinMode(bluePin, OUTPUT);
}

void loop()
{
digitalWrite(redPin, true);
}

void setColor(int red, int green, int blue)
{
#ifdef COMMON_ANODE
red = 1 - red;
green = 1 - green;
blue = 1 - blue;
#endif
analogWrite(redPin, red);
analogWrite(greenPin, green);
analogWrite(bluePin, blue);
}
