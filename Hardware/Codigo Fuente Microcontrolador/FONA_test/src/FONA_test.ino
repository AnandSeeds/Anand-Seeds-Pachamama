#include <SoftwareSerial.h>

//PIN FONA Vio = 5V
//PIN FONA GND = GND
#define FONA_RX 3 // Serial RX
#define FONA_TX 4 // Serial TX
#define FONA_RST 5  //resets board
#define FONA_KEY 6 //powers board down
#define FONA_PS 7 //status pin. Is the board on or not?

SoftwareSerial fonaSS = SoftwareSerial(FONA_TX, FONA_RX); //initialize software serial
char inChar = 0;

void setup() {
  pinMode(FONA_PS, INPUT);
  pinMode(FONA_KEY,OUTPUT);
  digitalWrite(FONA_KEY, HIGH);
  Serial.begin(9600);
  Serial.println("Serial Listo");
  fonaSS.begin(9600);
  Serial.println("FONA Serial Listo");
}

void loop() {
  if (fonaSS.available()){
    inChar = fonaSS.read();
    Serial.write(inChar);
    delay(20);
  }
  if (Serial.available()>0){
    fonaSS.write(Serial.read());
  }
}
