/*
 ***********************************************************************
 *              LIBRERIAS y CONSTANTES
 ***********************************************************************
 */

/****** INICIO MODULO RELOJ ******/
#include <virtuabotixRTC.h> //
// Creation of the Real Time Clock Object
virtuabotixRTC myRTC(21, 20, 19); // CLK,DAT,RST -- SCLK -> 21, I/O -> 20, CE -> 19
/****** FIN MODULO RELOJ ******/

/***** INICIO KEYBOARD *****/
#include <Keypad.h> 
const byte ROWS = 4; // four rows
const byte COLS = 4; // three columns

char keys[ROWS][COLS] = { { '1', '2', '3', 'A' }, 
              { '4', '5', '6', 'B' }, 
              { '7', '8', '9', 'C' }, 
              { '*', '0', '#', 'D' } };

byte rowPins[ROWS] = { 45, 43, 41, 39 }; // connect to the row pinouts of the keypad
byte colPins[COLS] = { 53, 51, 49, 47 }; // connect to the column pinouts of the keypad

Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

int posicion = 0;
const char clave[] = "ABC";
const int tamannoClave = strlen(clave);
char passin[tamannoClave - 1];//indice 3 denota 4 elementos 0,1,2,3...
int ledLogin = 5;
int intentos = 10;
/***** FIN KEYBOARD *****/

/***** INICIO LCD ******/
#include <LiquidCrystal.h>
LiquidCrystal lcd(12, 11, 10, 9, 8, 7); // LiquidCrystal(rs, enable, d4, d5, d6, d7)
/***** FIN LCD ******/

/***** INICIO MODULO GPS ******/
#define GPS_TX_DIGITAL_OUT_PIN 13
#define GPS_RX_DIGITAL_OUT_PIN 31

#include <SoftwareSerial.h>
SoftwareSerial gpsSerial(13, 31); // RX placa <- TX sensor, TX placa -> RX senxor

#include "TinyGPS.h"
TinyGPS gps;

#define MAX_BUFFER 500

unsigned long momento_anterior = 0;
unsigned long bytes_recibidos = 0;

long startMillis;
long secondsToFirstLocation = 0;

float latitude = 4.0;
float longitude = 69.0;

char latit[12];
char longi[12];
/***** FIN MODULO GPS ******/

/****** INICIO HUMEDAD Y TEMPERATURA AMBIENTE ******/
#include "DHT.h"
#define DHTPIN 6
#define DHTTYPE DHT11 // DHT 22 / 11 (AM2302)
DHT dht(DHTPIN, DHTTYPE);
float h;
float t;
/****** FIN HUMEDAD Y TEMPERATURA AMBIENTE ******/

/******* INICIO TEMPERATURA DEL SUELO **********/
int temp_pin = A7;
float TempC;
/******* FIN TEMPERATURA DEL SUELO **********/

/******* INICIO HUMEDAD DEL SUELO **********/
float HS;
/******* FIN HUMEDAD DEL SUELO **********/

/****** INICIO UV ******/
int uvLevel;
int refLevel;
float outputVoltage;
float uvIntensity;

// Hardware pin definitions MP8511
int UVOUT = A0; // Output from the sensor
int REF_3V3 = A1; // 3.3V power on the Arduino board
/****** FIN UV ******/

/****** INICIO MODULO GSM/GPRS ******/
#include <SoftwareSerial.h>
SoftwareSerial sim800l(17,16); //RX - TX
String operadorAPN = "";
/****** FIN MODULO GSM/GPRS ******/

/****** INICIO VOLTIMETRO ******/
int pinSonda = A6;
float escala = 0.1; //100 para voltios, 0.1 para milivoltios
/****** FIN VOLTIMETRO ******/

/*
 ***********************************************************************
 *              SETUP CONFIGURACIÓN INICIAL
 ***********************************************************************
 */
void setup() {
    configurarMonitorSerial();
    configurarLCD();
    mensajeBienvenida();
    validarAccesoPorClave();
    ingresarAPN();
    mensajeCargando();
    configurarGPRS();
    configurarRTC();
    configurarGPS();
    configurarSensorDHT();    
}

void configurarLCD(){
    lcd.begin(16, 2);
}

void mensajeCargando(){
    lcd.clear();
    lcd.print("....Cargando....");
}

void mensajeBienvenida(){
  char *mensaje  = (char*)"    Bienvenido a SIE    ";
  char *mensaje2 = (char*)"    Cultivando Futuro.  ";
  mostrarMensajesAutoscroll(mensaje,mensaje2);
}

void validarAccesoPorClave(){
    pinMode(ledLogin, OUTPUT);//Iniciar estado led
    lcd.clear();
    Serial.println("Ingresa Clave:");
    lcd.print("Ingresa Clave:");
    while(!ingresarClave()){}
}

/*
 *  Funcion mensaje 
 */
void ingresarAPN() {
  const char  mensaje[] = "   Ingresa Operador Movil:    ";//El mensaje y el operador deben ser del mismo tamaño
  const char operador[] = "   1-CLARO 2-MOVISTAR 3-VIRGIN";
  mostrarMensajesAutoscrollConFuncion(mensaje,operador,detectarTeclaOperador);
}

/*
 *  Funcion para seleccionar operadorAPN por teclado matricial
 */
bool detectarTeclaOperador(){
    char key = keypad.getKey();
    Serial.println(String(key));
    /////////////////////////////////////////Números del 1 al 3
    if (key) {
      switch (key) {
        case '1':
            operadorAPN = String("AT+CSTT=\"internet.comcel.com.co\",\"COMCELWEB\",\"COMCELWEB\"");
            Serial.println("Configurando APN Claro");
            break;
        case '2':
            operadorAPN = String("AT+CSTT=\"internet.movistar.com.co\",\"movistar\",\"movistar\"");
            Serial.println("Configurando APN Movistar");
            break;
        case '3':
            operadorAPN = String("AT+CSTT=\"web.vmc.net.co\",\"\",\"\"");
            Serial.println("Configurando APN Virgin Mobile");
            break;
        default:
            return false;
            break;
      }
      return true;
    } else {
      return false;
    }
}

void configurarMonitorSerial(){
    Serial.begin(9600);
    Serial.println("Iniciando...");
}

void configurarRTC(){
    myRTC.setDS1302Time(00, 14, 23, 2, 31, 5, 2016); // seg, min, hora, dia de la semana, dia del mes, mes, año
}

void configurarSensorDHT(){    
    dht.begin();//Sensor temperatura y humedad
}

void configurarGPS(){    
    pinMode(GPS_TX_DIGITAL_OUT_PIN, INPUT);
    pinMode(GPS_RX_DIGITAL_OUT_PIN, INPUT);
    gpsSerial.begin(9600);
}

/**
 * Se configura el módulo GSM
 */
void configurarGPRS() {
    Serial.println("Iniciando configuracion del modulo GSM"); 
    sim800l.println(F("AT"));
    delay(500);
    Serial.println(debugGSM());
    sim800l.println(F("AT+CBC"));  //Retorna el estado de la bateria del dispositivo, el % y milivol
    delay(500);
    Serial.println(debugGSM());
    sim800l.println(F("AT+IPR=19200"));  //Retorna el estado de la bateria del dispositivo, el % y milivol
    delay(500);
    Serial.println(debugGSM());
    
    sim800l.println(F("AT+CSQ")); // Retorna la calidad de la señal que depende de la antena y la localizacion
    delay(500);
    Serial.println(debugGSM());
    
    sim800l.println(F("AT+CREG=1")); // Verifica si la simcard a sido o no registrada
    Serial.println(debugGSM());
    delay(500);
    sim800l.println(F("AT+CIPSHUT")); // Resetea las direcciones IP
    Serial.println(debugGSM());
    delay(500);
    sim800l.println(F("AT+CGATT=1")); // Verifica si el gprs esta activo o no
    Serial.println(debugGSM());
    delay(500);
    sim800l.println(F("AT+CIPSTATUS")); //Verifica si la pila o stack IP es inicializada
    Serial.println(debugGSM());
    delay(500);
    sim800l.println(F("AT+CIPMUX=0")); //Esta la conexión en modo simple(udp/tcp cliente o tcp server)
    Serial.println(debugGSM());
    delay(500);
    
    // Configurar tarea y configura el APN
    sim800l.println(operadorAPN);
    Serial.println(debugGSM());
    delay(500);
    
    sim800l.println(F("AT+CIICR")); // Levantar conexión wireless(GPRS o CSD)
    Serial.println(debugGSM());
    delay(500);
}

/*
 ***********************************************************************
 *              LOOP BUCLE PRINCIPAL
 ***********************************************************************
 */
void loop() {
    sensarEstadoBateria();
    mensajeCargando();
    GetTimeRTC();
    GetGPS();
    GetHT();
    GetTs();
    GetHS();
    GetUV();
    mostrarFecha();    
    mostrarRegistros();//Humedad y Temperatura, Aire y Suelo
    mostrarRegistros2();//Nivel UV e Intensidad UV
    mostrarRegistros3();//Latitud y Longitud
    enviarDatosSIM();
    delay(4000);
    visualizarVariablesSerial();
}

/****** INICIO FUNCIONES ADICIONALES ******/

/*
 *  Funcion para el sensado de baterias
 */
void sensarEstadoBateria(void){
   float lectura = analogRead(pinSonda);
   lectura = map(lectura, 0, 1023, 0, 500);
   float voltaje = lectura / escala;
   //voltaje = 3100.01; //para probarlo
   if (voltaje < 3400){
      char *mensaje1 = (char*)"    Nivel de carga baja,    ";
      char *mensaje2 = (char*)"    Cargue el dispositivo.  ";
      mostrarMensajesAutoscroll(mensaje1,mensaje2);
      if (voltaje<3200){ 
        char *mensaje  = (char*)"    NIVEL CRITICO DE BATERIA    ";
        mostrarMensajeAutoscroll(mensaje);
        sensarEstadoBateria();
      }
   }
}

/*
 *  Funcion para obtener Fecha y Hora con el uso de la RTC
 */
void GetTimeRTC(){
    myRTC.updateTime();
    // Delay so the program doesn't print non-stop
    delay(5000);
}

/**
 * Se utiliza para cargar los datos del modulo GPS y se guardan en las variables
 * globales latit y longi.
 */
void GetGPS() {

    bool newData = false;
    unsigned long chars = 0;
    unsigned short sentences, failed;

    for (unsigned long start = millis(); millis() - start < 1000;) {
        while (gpsSerial.available()) {
            int c = gpsSerial.read();
            ++chars;
            if (gps.encode(c)){
                newData = true;
            }
        }
    }

    if (newData) {
        if (secondsToFirstLocation == 0) {
            secondsToFirstLocation = (millis() - startMillis) / 1000;
        }
        unsigned long age;
        gps.f_get_position(&latitude, &longitude, &age);
        Serial.print("Location: ");
        Serial.print(latitude, 6);
        Serial.print(" , ");
        Serial.print(longitude, 6);
        Serial.println("");
  }
  dtostrf(latitude, 0, 6, latit);
  dtostrf(longitude, 0, 6, longi);
  Serial.println(latit);
  Serial.println(longi);
}

/**
 * Se obtiene la humedad relativa (aire) y se guarda en las variables globales h y t.
 */
void GetHT() {
  h = dht.readHumidity();
  t = dht.readTemperature();
}

/**
 * Se obtiene la temperatura por medio de la lectura analoga del pin temp_pin
 */
void GetTs() {
  TempC = analogRead(temp_pin);
  TempC = (5.0 * TempC * 100.0) / 1024.0;
}

/**
 * Se optiene la humedad del suelo por medio del PIN analogo A2.
 */
void GetHS() {
  int val2 = analogRead(A2);
  HS = val2 * (5.0 / 1023.0);
}

/**
 * Se obtiene la radiacion ultravioleta y se guarda en la variable global uvIntensity.
 */
void GetUV() {
  uvLevel = averageAnalogRead(UVOUT);
  refLevel = averageAnalogRead(REF_3V3);

  // Use the 3.3V power pin as a reference to get a very accurate output
  // value from sensor
  outputVoltage = 3.3 / refLevel * uvLevel;
  uvIntensity = mapfloat(outputVoltage, 0.99, 2.9, 0.0, 15.0); // (mW/cm^2)
}

/**
 * Se imprimen los registros de:
 * Humedad Relativa
 * Temperatura
 * Humedad del Suelo
 * Temperatura del Suelo
 * Se espera 3 segundo para que se mantengan los datos.
 */
void mostrarRegistros() {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("H:");
  lcd.print(h);
  lcd.setCursor(0, 1);
  lcd.print("T:");
  lcd.print(t);
  lcd.setCursor(9, 0);
  lcd.print("Hs:");
  lcd.print(HS);
  lcd.setCursor(9, 1);
  lcd.print("Ts:");
  lcd.print(TempC);
  delay(3000);
}

/**
 * Se imprimen los datos:
 * Nivel UV
 * Intensidad UV
 * Y se esperan 3 segundos.
 */
void mostrarRegistros2() {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("UV level:");
  lcd.print(uvLevel);
  lcd.setCursor(0, 1);
  lcd.print("UV Inten:");
  lcd.print(uvIntensity);
  delay(3000);
}

/**
 * Se imprime en el LCD la latitud y longitud dadas por el GPS
 */
void mostrarRegistros3() {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("La:");
  lcd.print(latit);
  lcd.setCursor(0, 1);
  lcd.print("Lo:");
  lcd.print(longi);
  delay(3000);
}


/**
 * Para información del usuario en el LCD se imprime la fecha y la hora.
 */
void mostrarFecha() {
  // DateTime now = RTC.now();
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("FECHA:");
  lcd.print(myRTC.dayofmonth);
  lcd.print("/");
  lcd.print(myRTC.month);
  lcd.print("/");
  lcd.print(myRTC.year);
  lcd.setCursor(0, 1);
  lcd.print("HORA:");
  lcd.print(myRTC.hours);
  lcd.print(":");
  lcd.print(myRTC.minutes);
  lcd.print(":");
  lcd.print(myRTC.seconds);
  delay(3000);
}

/**
 * Funcion para promedio de muestreo
 * @param int pinToRead el puerto análogo que se debe leer 
 * @return int se obtiene el promedio de las últimas 8 muestras tomadas en el pin 
 */
int averageAnalogRead(int pinToRead) {
  byte numberOfReadings = 8;
  unsigned int runningValue = 0;

  for (int x = 0; x < numberOfReadings; x++)
    runningValue += analogRead(pinToRead);
  runningValue /= numberOfReadings;

  return (runningValue);
}

/**
 * Arreglo para mapeo de punto flotante UVSensor
 * The Arduino Map function but for floats
 * From: http://forum.arduino.cc/index.php?topic=3922.0
 * https://learn.sparkfun.com/tutorials/ml8511-uv-sensor-hookup-guide
 * @param float x es el voltaje de salida del sensor
 * @param float in_min es un voltaje de 0.99V
 * @param float in_max es un voltaje de 2.8V
 * @param float out_min es el minimo nivel de radiación UV
 * @param float out_max es el maximo nivel de radiación UV
 * @return float que representa el nivel de radiación UV
 */
float mapfloat(float x, float in_min, float in_max, float out_min, float out_max) {
    return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}


/**
 * Se acitva si el peso se encuentra en un limite definido
 */
void enviarDatosSIM() {
    lcd.clear();
    lcd.print("Enviando Datos...");
    //Se acitva si el peso se encuentra en un limite definido
    //sim800l.println(F("AT+CIPSHUT")); //Resetea las direcciones IP
    //Serial.println(debugGSM());
    //delay(500);
    sim800l.println("AT+CIFSR"); // Obtiene una dirección IP
    Serial.println(debugGSM());
    delay(2000);
    
    sim800l.println(F("AT+CIPSTART=\"TCP\",\"107.170.208.9\",\"8080\"")); //Inicia conexión UDP o TCP
    Serial.println(debugGSM());
    delay(2000);

    sim800l.println(F("AT+CIPMODE=1")); //Inicia conexión UDP o TCP
    Serial.println(debugGSM());
    delay(2000);
    
    sim800l.println(F("AT+CIPSEND\r\n")); // Envia datos al servidor remoto, ctlr+z o 0x1A,
    //verifica que los datos salieron del puerto serial pero no indica si llegaron al servidor UDP
    Serial.println(debugGSM());
    delay(500);

    static char ts[15];
    dtostrf(TempC, 0, 3, ts);  // dtostrf(var, characters long, characters after the decimal point,array to save)
    static char ta[15];
    dtostrf(t, 0, 3, ta);
    static char hs[15];
    dtostrf(HS, 0, 3, hs);
    static char hr[15];
    dtostrf(h, 0, 3, hr);
    static char iuv[15];
    dtostrf(uvIntensity, 0, 3, iuv);
    String cadena = "GET /index.php?data=0Ihzhj0geg_u16zk9AJNLlGl9F-9kE_bxeocU3n_RBOoDc-di1h93jvWz6chN9zBuF78S7NlmsMoYCF7NQ4-MeD5sqbkKWcF1onSaZz8EI-ABc1Ej1tNL-HMdr2YJS-N&id=1&ts="
    +String(ts)
    +"&ta="+String(ta)
    +"&hs="+String(hs)
    +"&hr="+String(hr)
    +"&nuv="+String(uvLevel)
    +"&iuv="+String(iuv)
    +"&lat="+String(latit)
    +"&lon="+String(longi);
    Serial.println(cadena);
    sim800l.println(cadena);
    
    pushSlow((char*)"\r\n",100,100); //Envia un salto de linea
    pushSlow((char*)"\x1A",100,100);//ctlr+z para finalizar el envio o 0x1A
    //sim800l.write(0x1A);//ctlr+z para finalizar el envio o 0x1A
    Serial.println(debugGSM());
    delay(500);
    sim800l.println(F("AT+CIPSHUT")); //Resetea las direcciones IP
    Serial.println(debugGSM());
    //delay(4000);
    lcd.clear();
    lcd.print("Datos Enviados");
}

/**
 * Envia datos por el SoftSerial lentamente
 */
void pushSlow(char* command,int charaterDelay,int endLineDelay) {
    for(int i=0; i<strlen(command); i++) {
        sim800l.write(command[i]);
        if(command[i]=='\n') {
         delay(endLineDelay);
        } else {
         delay(charaterDelay);
        }
    }
}

/**
 * Realiza la lectura del buffer del módulo GSM, acumula la salida de
 * caracteres hasta que la transmisión serial termina
 * Acumulador de caracteres recursivo
 */
char *debugGSM()  {// devuelve el ``contenido de un objeto apuntado por un apuntador''. 
    int i=0;
    static char cad[255]="\0";
    char c='\0';    
    strcpy(cad,"");
    while(sim800l.available()>0) {
        c=sim800l.read();
        cad[i]=c;
        i++;
    } 
    return cad;
}

/*
 *  Funcion acceso por teclado matricial
 */
boolean ingresarClave() {
    char key = keypad.getKey();
    if (key) {
        if (posicion == tamannoClave - 1) {
            lcd.setCursor(posicion, 1);
            passin[posicion] = key;
            // print the number of seconds since reset:
            lcd.print(key);
            boolean iguales = true;
            for (int i = 0; i < strlen(clave); i++) {
              if(passin[i] == clave[i]){
                iguales = iguales && true;
              } else {
                iguales = iguales && false;
              }
            }
            if (iguales) {
                lcd.setCursor(0, 0);
                lcd.print("Ingreso Correcto");
                lcd.setCursor(0, 1);
                lcd.print("        ");
                digitalWrite(ledLogin, HIGH);
                return true;
            } else {
                lcd.setCursor(0, 0);
                lcd.print("Intenta de nuevo...");
                lcd.setCursor(0, 1);
                lcd.print("           ");

                if (intentos <= 0) {
                    while (true) {
                      mostrarMensajeAutoscroll((char*)"    Reinicie el sistema    ");
                    }
                } else {
                    intentos--;
                    posicion = 0;
                }
            }
        } else {
            lcd.setCursor(posicion, 1);
            // print the number of seconds since reset:
            lcd.print(key);
            passin[posicion] = key;
            posicion++;
        }
    }
    return false;
}

/**
  * Permite configurar la visualizacion de variables
  */
void visualizarVariablesSerial(){
    Serial.print("FECHA:");
    Serial.print(myRTC.dayofmonth);
    Serial.print("/");
    Serial.print(myRTC.month);
    Serial.print("/");
    Serial.println(myRTC.year);
    Serial.print("HORA:");
    Serial.print(myRTC.hours);
    Serial.print(":");
    Serial.print(myRTC.minutes);
    Serial.print(":");
    Serial.println(myRTC.seconds);
    Serial.println("Humedad:");
    Serial.println(h);
    Serial.println("Temperatura:");
    Serial.println(t);
    Serial.println("Humedad Suelo:");
    Serial.println(HS);
    Serial.println("Temperatura Suelo:");
    Serial.println(TempC);
    Serial.println("UV level:");
    Serial.println(uvLevel);
    Serial.println("UV Inten:");
    Serial.println(uvIntensity);
    Serial.println("Latitud:");
    Serial.println(latit);
    Serial.println("Longitud:");
    Serial.println(longi);
    Serial.print("Envio de datos finalizado.\r\n");
}

/*
 *  Funcion para mostrar mensaje autoScroll en 1 fila
 */
void mostrarMensajeAutoscroll(char *mensaje){
  int tamannoOp = strlen(mensaje)-1;
  int ancho = 15;//El número de columnas del LCD son 16 menos 1 = 15
  int barrido = 0;
  while(barrido<=tamannoOp-ancho){
    for (int positionCounter = barrido; positionCounter <= ancho + barrido; positionCounter++) {
      lcd.setCursor(positionCounter-barrido, 0);
      lcd.print(String(mensaje[positionCounter]));
    }
    barrido++;
    delay(500);
    lcd.clear();
  }
}

/*
 *  Funcion para mostrar mensaje autoScroll en 2 filas
 */
void mostrarMensajesAutoscroll(char *mensaje, char *mensaje2){
  //El mensaje1 y el mensaje 2 deben ser del mismo tamaño
  const int tamannoOp = strlen(mensaje2)-1;
  int ancho = 15;//El número de columnas del LCD son 16 menos 1 = 15
  int barrido = 0;
  
  while(barrido<=tamannoOp-ancho){
    for (int positionCounter = barrido; positionCounter <= ancho + barrido; positionCounter++) {
      lcd.setCursor(positionCounter-barrido, 0);
      lcd.print(String(mensaje[positionCounter]));
      lcd.setCursor(positionCounter-barrido, 1);
      lcd.print(String(mensaje2[positionCounter]));
    }
    barrido++;
    delay(500);
    lcd.clear();
  }
}

/*
 *  Funcion para mostrar mensaje autoScroll en 2 filas con funcion CallBack
 */
void mostrarMensajesAutoscrollConFuncion(const char mensaje[], const char mensaje2[],bool (*fun)() ){
  //El mensaje1 y el mensaje 2 deben ser del mismo tamaño
  const int tamannoOp = strlen(mensaje2)-1;
  int ancho = 15;//El número de columnas del LCD son 16 menos 1 = 15

  VOLVERAMOSTRAR:
  int barrido = 0;
  
  while(barrido<=tamannoOp-ancho){
    for (int positionCounter = barrido; positionCounter <= ancho + barrido; positionCounter++) {
      lcd.setCursor(positionCounter-barrido, 0);
      lcd.print(String(mensaje[positionCounter]));
      lcd.setCursor(positionCounter-barrido, 1);
      lcd.print(String(mensaje2[positionCounter]));
      bool siTecla = (*fun)();
      if(siTecla){
        return;
      }
    }
    barrido++;
    int temporizador = 150;
    while (temporizador>0){
      bool siTecla = (*fun)();
      if(siTecla){
        return;
      }
      temporizador--;
    }
    lcd.clear();
  }

  goto VOLVERAMOSTRAR;
}



/****** FIN FUNCIONES ADICIONALES ******/

