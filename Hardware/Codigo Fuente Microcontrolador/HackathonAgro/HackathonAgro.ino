/*
 ***********************************************************************
 *                      LIBRERIAS y CONSTANTES
 ***********************************************************************
 */

/****** INICIO MODULO RELOJ ******/

#include <virtuabotixRTC.h> //
// Creation of the Real Time Clock Object
virtuabotixRTC myRTC(21, 20, 19); // CLK,DAT,RST -- SCLK -> 21, I/O -> 20, CE -> 19

/****** FIN MODULO RELOJ ******/

/***** INICIO LCD ******/

#include <LiquidCrystal.h>
LiquidCrystal lcd(12, 11, 10, 9, 8, 7); // LiquidCrystal(rs, enable, d4, d5, d6, d7)

/***** FIN LCD ******/

/***** INICIO MODULO GPS ******/
#include <SoftwareSerial.h>
SoftwareSerial mySerial(13, 31); // RX, TX

#include "TinyGPS.h"
TinyGPS gps;

#define GPS_TX_DIGITAL_OUT_PIN 13
#define GPS_RX_DIGITAL_OUT_PIN 31

#define MAX_BUFFER 500

unsigned long momento_anterior = 0;
unsigned long bytes_recibidos = 0;

long startMillis;
long secondsToFirstLocation = 0;

float latitude = 0.0;
float longitude = 0.0;

char latit[12];
char longi[12];
/***** FIN MODULO GPS ******/

/****** INICIO HUMEDAD Y TEMPERATURA AMBIENTE ******/

#include "DHT.h"
#define DHTPIN 6
#define DHTTYPE DHT22 // DHT 22 (AM2302)
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
volatile float uvIntensity;

// Hardware pin definitions MP8511
int UVOUT = A0; // Output from the sensor
int REF_3V3 = A1; // 3.3V power on the Arduino board

/****** FIN UV ******/

/****** INICIO GASES ******/
float CO, COV;
/****** FIN GASES ******/

/****** INICIO MP ******/
float MP;
int measurePin = A5;

int samplingTime = 280;
int deltaTime = 40;
int sleepTime = 9680;

float voMeasured = 0;
float calcVoltage = 0;
float dustDensity = 0;
/****** FIN MP ******/

/****** INICIO CONTROL DE LECTURAS ******/
unsigned long time;
int alertaUV;
/****** FIN CONTROL DE LECTURAS ******/

/****** INICIO CONTADOR SET POINT *****/
const int boton = 2; // Interrupcion 0
volatile int contador = 0;
int lastInt = millis();
/****** FIN CONTADOR SET POINT *****/

/****** INICIO MODULO SD ******/

// #include <SD.h>
// File myFile;
/****** FIN MODULO SIM ******/
#include <SoftwareSerial.h>
SoftwareSerial sim800l(3,4); //RX - TX
/****** INICIO MODULO SIM ******/

// #include <SD.h>
// File myFile;
/****** FIN MODULO SD ******/

/**
 * FUNCION DE CONFIGURACION INICIAL
 */
void setup() {

	// Wire.begin();
	// RTC.begin();
	// Si quitamos el comentario de la linea siguiente, se ajusta la hora
	// y la fecha con la del ordenador
	// RTC.adjust(DateTime(__DATE__, __TIME__));
	myRTC.setDS1302Time(00, 25, 4, 6, 27, 2, 2016); // seg, min, hora,
	// dia de la
	// semana, dia del
	// mes, mes, año

	Serial.begin(9600);
	Serial.println("Iniciando..");
        sim800l.begin(19200); //Configuracion de puerto serial del modulo (baudios por segundo)
	

        mySerial.begin(9600);
	// pinMode(53, OUTPUT);
        Serial.println("Iniciando configuracion del modulo GSM"); 
        sim800l.println(F("AT"));
        delay(500);
        Serial.println(debug());
        sim800l.println(F("AT+CBC"));  //Retorna el estado de la bateria del dispositivo, el % y milivol
        delay(500);
        Serial.println(debug());
        sim800l.println(F("AT+IPR=19200"));  //Retorna el estado de la bateria del dispositivo, el % y milivol
        delay(500);
        Serial.println(debug());
        
        sim800l.println(F("AT+CSQ")); // Retorna la calidad de la señal que depende de la antena y la localizacion
        delay(500);
        Serial.println(debug());
        configuracionGPRS();
        Serial.print("Configuracion finalizada.\r\n");
        //enviardatos();
	dht.begin();

	pinMode(GPS_TX_DIGITAL_OUT_PIN, INPUT);
	pinMode(GPS_RX_DIGITAL_OUT_PIN, INPUT);

	lcd.begin(16, 2);

	// Antirebote para pulsador por software
	attachInterrupt(0, SetPoint, FALLING);

	// /////////////////////////////////////////////////////

	// Serial.print("Initializing SD card...");
	//
	// pinMode(53, OUTPUT);
	//
	// if (!SD.begin(53)) {
	// Serial.println("initialization failed!");
	// return;
	// }
	// Serial.println("initialization done.");
}

/**
 * FUNCION DE BUCLE PRINCIPAL
 */
void loop() {
	// Start printing elements as individuals
	myRTC.updateTime();
	Serial.print("Current Date / Time: ");
	Serial.print(myRTC.dayofmonth);
	Serial.print("/");
	Serial.print(myRTC.month);
	Serial.print("/");
	Serial.print(myRTC.year);
	Serial.print(" ");
	Serial.print(myRTC.hours);
	Serial.print(":");
	Serial.print(myRTC.minutes);
	Serial.print(":");
	Serial.println(myRTC.seconds);
	// Delay so the program doesn't print non-stop
	delay(5000);

	/*
	 * myFile = SD.open("test.txt", FILE_WRITE);
	 * 
	 * // if the file opened okay, write to it: if (myFile) {
	 * Serial.print("Writing to test.txt...");
	 * 
	 * DateTime now = RTC.now(); myFile.print(now.day(), DEC);
	 * myFile.print("/"); myFile.print(now.month(), DEC);
	 * myFile.print("/"); myFile.print(now.year(), DEC); myFile.print("
	 * "); myFile.print(now.hour(), DEC); myFile.print(":");
	 * myFile.print(now.minute(), DEC); myFile.print(":");
	 * myFile.print(now.second(), DEC); myFile.print(" ");
	 * myFile.print("Sensores: "); myFile.print(h); myFile.print(",");
	 * myFile.print(t); myFile.print(","); myFile.print(uvindex);
	 * myFile.print(","); myFile.print(CO); myFile.print(",");
	 * myFile.print(COV); myFile.print(","); myFile.print(MP);
	 * myFile.print(","); myFile.print(latit); myFile.print(",");
	 * myFile.println(longi); myFile.close(); Serial.println("Hecho.");
	 * // close the file: myFile.close(); Serial.println("done."); } else
	 * { // if the file didn't open, print an error: Serial.println("error 
	 * opening test.txt"); }
	 * 
	 * // re-open the file for reading: myFile = SD.open("test.txt"); if
	 * (myFile) { Serial.println("test.txt:");
	 * 
	 * // read from the file until there's nothing else in it: while
	 * (myFile.available()) { Serial.write(myFile.read()); } // close the
	 * file: myFile.close(); } else { // if the file didn't open, print an 
	 * error: Serial.println("error opening test.txt"); }
	 * 
	 */

	GetGPS();
	GetHT();
	GetTs();
	GetHS();
	GetUV();
	GetFecha();
        
	Imprime_registros();
	Imprime_registros2();
	Imprime_registros3();
	Imprime_registros4();

        enviarDatosSIM();
        Serial.print("Envio de datos finalizado.\r\n");
}

/****** INICIO FUNCIONES ADICIONALES ******/

/**
 * Se utiliza para cargar los datos del modulo GPS y se guardan en las variables
 * globales latit y longi.
 */
void GetGPS() {

	bool newData = false;
	unsigned long chars = 0;
	unsigned short sentences, failed;

	for (unsigned long start = millis(); millis() - start < 1000;) {
		while (mySerial.available()) {
			int c = mySerial.read();
			++chars;
			if (gps.encode(c))
				newData = true;
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

	dtostrf(latitude, 6, 6, latit);
	dtostrf(longitude, 6, 6, longi);
	Serial.println(latit);
	Serial.println(longi);
}

/**
 * Se obtiene la humedad relativa (aire) y se guarda en las variables globales h y t.
 */
void GetHT() {
	h = dht.readHumidity();
	t = dht.readTemperature();
	// Serial.print("Humidity: ");
	// Serial.print(h);
	// Serial.print("% ");
}

/**
 * Se obtiene la temperatura por medio de la lectura analoga del pin temp_pin
 */
void GetTs() {
	TempC = analogRead(temp_pin);
	TempC = (5.0 * TempC * 100.0) / 1024.0;
	// Serial.print(temperatura);
	// Serial.println(" oC");
	// delay(1000);
}

/**
 * Se optiene la humedad del suelo por medio del PIN analogo A2.
 */
void GetHS() {
	int val2 = analogRead(A2);
	HS = val2 * (5.0 / 1023.0);
	// Serial.print("Humedad Suelo:");
	// delay(1000);
	// Serial.print(HS);
	// delay(1000);
	// Serial.print("\n ");
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

	// Serial.print("Nivel MP8511:");
	// Serial.print(uvLevel);
	// delay(1000);
	// Serial.print("\n ");
	// Serial.print(" Voltaje MP8511 : ");
	// Serial.print(outputVoltage);
	// delay(1000);
	// Serial.print("\n ");
	// Serial.print("Intensidad (mW/cm^2): ");
	// Serial.print(uvIntensity);
	// delay(500);
	// Serial.print("\n ");
	// delay(500);
}

/**
 * Arreglo Set Point que no se sabe qué significa
 */
void SetPoint() {
	if ((millis() - lastInt) > 500) {
		contador++;
		lastInt = millis();
	}
}

/*
 * void GetSD() {
 * 
 * 
 * myFile = SD.open("test.txt", FILE_WRITE);
 * 
 * // if the file opened okay, write to it: if (myFile) {
 * 
 * DateTime now = RTC.now(); Serial.print("Writing to test.txt...");
 * 
 * myFile.print("Sensores: "); myFile.print(h); myFile.print(",");
 * myFile.print(t); myFile.print(","); myFile.print(uvindex);
 * myFile.print(","); myFile.print(CO); myFile.print(",");
 * myFile.print(COV); myFile.print(","); myFile.print(MP);
 * myFile.print(","); myFile.print(latit); myFile.print(",");
 * myFile.println(longi); myFile.close(); Serial.println("Hecho.");
 * // close the file: myFile.close(); Serial.println("done."); } else
 * { // if the file didn't open, print an error: Serial.println("error 
 * opening test.txt"); }
 * 
 * // re-open the file for reading: myFile = SD.open("test.txt"); if
 * (myFile) { Serial.println("test.txt:");
 * 
 * // read from the file until there's nothing else in it: while
 * (myFile.available()) { Serial.write(myFile.read()); } // close the
 * file: myFile.close(); } else { // if the file didn't open, print an 
 * error: Serial.println("error opening test.txt"); }
 * 
 * 
 * 
 * 
 * } 
 */

/**
 * Se imprimen los registros de:
 * Humedad Relativa
 * Temperatura
 * Humedad del Suelo
 * Temperatura del Suelo
 * Se espera 3 segundo para que se mantengan los datos.
 */
void Imprime_registros() {
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
void Imprime_registros2() {

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
void Imprime_registros3() {

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
 * Se imprimen los registros:
 * set point
 * Y se esperan 3 segundos
 */
void Imprime_registros4() {

	lcd.clear();
	lcd.setCursor(0, 0);
	lcd.print("Set Point:");
	lcd.print(contador);
	delay(3000);
}

/**
 * Para información del usuario en el LCD se imprime la fecha y la hora.
 */
void GetFecha() {
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
	delay(2000);
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
 * @param float x es alguna cosa
 * @param float in_min es alguna cosa
 * @param float in_max es alguna cosa
 * @param float out_min es alguna cosa
 * @param float out_max es alguna cosa
 * @return float que representa alguna cosa
 */
float mapfloat(float x, float in_min, float in_max, float out_min,
		float out_max) {
	return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}



void configuracionGPRS() {
        sim800l.println(F("AT+CREG=1")); // Verifica si la simcard a sido o no registrada
        Serial.println(debug());
        delay(500);
        sim800l.println(F("AT+CIPSHUT")); // Resetea las direcciones IP
        Serial.println(debug());
        delay(500);
        sim800l.println(F("AT+CGATT=1")); // Verifica si el gprs esta activo o no
        Serial.println(debug());
        delay(500);
        sim800l.println(F("AT+CIPSTATUS")); //Verifica si la pila o stack IP es inicializada
        Serial.println(debug());
        delay(500);
        sim800l.println(F("AT+CIPMUX=0")); //Esta la conexión en modo simple(udp/tcp cliente o tcp server)
        Serial.println(debug());
        delay(500);
        
        // Configurar tarea y configura el APN
        sim800l.println(F("AT+CSTT=\"internet.comcel.com.co\",\"COMCELWEB\",\"COMCELWEB\""));
        Serial.println(debug());
        delay(500);
        
        sim800l.println(F("AT+CIICR")); // Levantar conexión wireless(GPRS o CSD)
        Serial.println(debug());
        delay(500);
}

/**
 * Se acitva si el peso se encuentra en un limite definido
 */
void enviarDatosSIM() {
        //Se acitva si el peso se encuentra en un limite definido
        //sim800l.println(F("AT+CIPSHUT")); //Resetea las direcciones IP
        //Serial.println(debug());
        //delay(500);
        sim800l.println("AT+CIFSR"); // Obtiene una dirección IP
        Serial.println(debug());
        delay(2000);
        
        sim800l.println(F("AT+CIPSTART=\"TCP\",\"107.170.208.9\",\"80\"")); //Inicia conexión UDP o TCP
        Serial.println(debug());
        delay(2000);
        
        sim800l.println(F("AT+CIPSEND\r\n")); // Envia datos al servidor remoto, ctlr+z o 0x1A,
        //verifica que los datos salieron del puerto serial pero no indica si llegaron al servidor UDP
        Serial.println(debug());
        delay(500);
        //sim800l.println("GET /dato.php?temp="+ String(t)+"&hum="+ String(h)+"&uv="+ String(t)+"&co="+ String(CO)+"&cov="+ String(COV)+"&hs="+ String(HS)+"&gpslat="+String(latitude)+"&gpslog="+ String(longitude)); 
//        sim800l.println("GET /index.php?data=N0FIQXVGSnFZMWF6WUx3VkVMbnhRYjhRZE1uNXRTY3JpOGVQTUVobEtRMWlPYmo4TVdzMENwMTROaWloUnllOGNDeW8wZjhwWm1lN29Fc1I1QmprbHk4bFhBPT0"
//        +"&id_dispositivo=1&temp="+ String(t)
//        +"&hum="+ String(h)
//        +"&uv="+ String(t)
//        +"&co="+ String(CO)
//        +"&cov="+ String(COV)
//        +"&hs="+ String(HS)
//        +"&gpslat="+String(latitude)
//        +"&gpslog="+ String(longitude));
        //sim800l.println("GET /index.php?data=0Ihzhj0geg_u16zk9AJNLlGl9F-9kE_bxeocU3n_RBOoDc-di1h93jvWz6chN9zBuF78S7NlmsMoYCF7NQ4-MeD5sqbkKWcF1onSaZz8EI-ABc1Ej1tNL-HMdr2YJS-N&id=1&ts=1&ta=1&hs=1&hr=1&nuv=1&iuv=1&lat=10&log=10 HTTP/1.1");
        sim800l.println("GET /index.php?data=0Ihzhj0geg_u16zk9AJNLlGl9F-9kE_bxeocU3n_RBOoDc-di1h93jvWz6chN9zBuF78S7NlmsMoYCF7NQ4-MeD5sqbkKWcF1onSaZz8EI-ABc1Ej1tNL-HMdr2YJS-N");
        //sim800l.println("Host: 107.170.208.9");
        //+"&co="+ String(CO)+"&cov="+ String(COV)+"&hs="+ String(HS)
        //sim800l.println("GET /dato.php?temp="+ String(t)+"&hum="+ String(h)); 
        //sim800l.println(F("GET /dato.php?temp=200&hum=200&ozon=100&uv=100")); 
        // Se envia por un peticion GET los valores obtenidos
        //Serial.println(debug());
        //delay(500);
        pushSlow("\r\n",100,100); //Envia un salto de linea
        pushSlow("\x1A",100,100);//ctlr+z para finalizar el envio o 0x1A
        //sim800l.write(0x1A);//ctlr+z para finalizar el envio o 0x1A
        Serial.println(debug());
        delay(500);
        sim800l.println(F("AT+CIPSHUT")); //Resetea las direcciones IP
        Serial.println(debug());
        delay(4000);
        //pesomin=0;
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
 *
 */
char *debug()  // devuelve el ``contenido de un objeto apuntado por un apuntador''. 
{
int i=0;
char cad[255]="\0";
char c='\0';
        
        strcpy(cad,"");
        while(sim800l.available()>0)
        {
        c=sim800l.read();
        cad[i]=c;
        i++;
        }
      
return cad;
}


/****** FIN FUNCIONES ADICIONALES ******/
