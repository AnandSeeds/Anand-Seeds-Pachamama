#include <Keypad.h>
const byte ROWS = 4;
const byte COLS = 4;
char keys[ROWS][COLS] = {{'1','2','3','A'},
                        {'4','5','6','B'},
                        {'7','8','9','C'},
                        {'*','0','#','D'}};
byte rowPins[ROWS] = { 45, 43, 41, 39 }; //Filas(pines)
byte colPins[COLS] = { 53, 51, 49, 47 }; //Columnas (pines)

Keypad keypad = Keypad( makeKeymap(keys), rowPins, colPins, ROWS, COLS );
int ledSim = 5;
////////////////////////////////////////////////////////////////////VOID SETUP
void setup(){
Serial.begin (9600);
pinMode(ledSim, OUTPUT);
Serial.println("Seleccione telefonia");
}
////////////////////////////////////////////////////////////////////VOID LOOP
void loop(){
validarSimCard();
}

void validarSimCard(){
char key = keypad.getKey();
/////////////////////////////////////////Boton A
if(key) {
switch (key)
{
case 'A'://Cuando key "A" es oprimida...          
Serial.println("www.anandseeds.co");//El monitor serial escribe "www.anandseeds.co"
digitalWrite(ledSim, HIGH);//El led se enciende
break;
}
}
/////////////////////////////////////////Boton B
if(key) {
switch (key)
{
case 'B'://Cuando key "B" es oprimida...          
Serial.println("Visitanos!");//El monitor serial escribe "Visítanos"
digitalWrite(ledSim, LOW);//El led se apaga
break;
}
}
/////////////////////////////////////////Números del 1 al 3
if(key) {
switch (key)
{
case '1':        
Serial.println("Configurando APN Claro");
digitalWrite(ledSim, HIGH);//El led se enciende
break;
}
}
if(key) {
switch (key)
{
case '2':        
Serial.println("Configurando APN Movistar");
digitalWrite(ledSim, HIGH);//El led se enciende
break;
}
}
if(key) {
switch (key)
{
case '3':        
Serial.println("Configurando APN Virgin Mobile");
digitalWrite(ledSim, HIGH);//El led se enciende
break;
}
}
///...
}

