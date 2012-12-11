/*
  Web client
 
 This sketch connects to a website (http://www.google.com)
 using an Arduino Wiznet Ethernet shield. 
 
 Circuit:
 * Ethernet shield attached to pins 10, 11, 12, 13
 
 created 18 Dec 2009
 modified 9 Apr 2012
 by David A. Mellis
 
 */

#include <SPI.h>
#include <Ethernet.h>
#include <Adafruit_Thermal.h>
#include <SoftwareSerial.h>
#include "pitches.h"

#define FONT_END7F //chars: 0x20-0xFF

#define LED_1 7
#define LED_2 8
#define LED_3 9
#define LED_4 11
#define LED_5 12
#define LED_6 13

// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
byte mac[6] = {  0x90, 0xA2, 0xDA, 0x0D, 0x0F, 0xB2 };
IPAddress server(10,15,20,110);
int printer_RX_Pin = 22;  // This is the green wire
int printer_TX_Pin = 23;  // This is the yellow wire


// notes in the melody:
int melody[] = {
  NOTE_C4, NOTE_G3,NOTE_G3, NOTE_A3, NOTE_G3,0, NOTE_B3, NOTE_C4};

// note durations: 4 = quarter note, 8 = eighth note, etc.:
int noteDurations[] = {
  4, 8, 8, 4,4,4,4,4 };
  
// define Tone pin
int tonePin = 49;
  
  
const int buttonPinGo = 24;     // the number of the pushbutton pin

const int buttonPinRational_1 = 26;     // the number of the pushbutton pin
const int buttonPinRational_2 = 28;     // the number of the pushbutton pin
const int buttonPinRational_3 = 30;     // the number of the pushbutton pin
const int buttonPinRational_4 = 32;     // the number of the pushbutton pin
const int buttonPinRational_5 = 34;     // the number of the pushbutton pin
const int buttonPinRational_6 = 36;     // the number of the pushbutton pin


const int buttonPinEmotional_1 = 27;     // the number of the pushbutton pin
const int buttonPinEmotional_2 = 29;     // the number of the pushbutton pin
const int buttonPinEmotional_3 = 31;     // the number of the pushbutton pin
const int buttonPinEmotional_4 = 33;     // the number of the pushbutton pin


int buttonStateGo = 0;         // variable for reading the button status
int buttonStateRational = 0;         // variable for reading the button status
int buttonStateEmotional = 0;         // variable for reading the button status

int brightness = 0;    // how bright the LED is
int fadeAmount = 5;
  
  

Adafruit_Thermal printer(printer_RX_Pin, printer_TX_Pin);

String emotional = "";
String rational = "";
String title = "";
String ingredients = "";
String preparition_time = "";
String preparation = "";
String line = "";
boolean startPrint = false;
boolean printItToPrinterToo = true;
boolean specialChar = false;
char specialCharChar;




// Initialize the Ethernet client library
// with the IP address and port of the server 
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;




////////////////////////////////////////////////////////////////////////////////////////////////////////////




void setup() {
    
  pinMode(LED_1, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_2, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_3, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_4, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_5, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_6, OUTPUT);  // LED is an OUTPUT 
  
  pinMode(buttonPinGo, INPUT);     
  
  pinMode(buttonPinRational_1, INPUT);
  pinMode(buttonPinRational_2, INPUT);
  pinMode(buttonPinRational_3, INPUT);
  pinMode(buttonPinRational_4, INPUT);
  pinMode(buttonPinRational_5, INPUT);
  pinMode(buttonPinRational_6, INPUT);
  
  pinMode(buttonPinEmotional_1, INPUT);
  pinMode(buttonPinEmotional_2, INPUT);
  pinMode(buttonPinEmotional_3, INPUT);
  pinMode(buttonPinEmotional_4, INPUT);

  
  
 // Open serial communications and wait for port to open:
  Serial.begin(9600);
  if(printItToPrinterToo){
    pinMode(7, OUTPUT); digitalWrite(7, LOW); // To also work w/IoTP printer
    printer.begin();
  }

  // start the Ethernet connection:
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // no point in carrying on, so do nothing forevermore:
    for(;;)
      ;
  }
  // give the Ethernet shield a second to initialize:
  delay(1000);
  Serial.println("connecting...");
  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.println("cönnected");
    // Make a HTTP request:
    //client.println("GET /indexRaw.php?emo=1&ratio= HTTP/1.1");
    client.println("GET /indexRawTest.php HTTP/1.1");
    client.println("Host: rezept.dshini.dev.mediaman.de");
    //client.println("Content-Type: application/x-www-form-urlencoded; charset=iso-8859-1");
    client.println("Content-Type: application/x-www-form-urlencoded; charset=cp437");
    client.println();
  } 
  else {
    // kf you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  
 
  
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////


void loop()
{
  // if there are incoming bytes available 
  // from the server, read them and print them:
  if (client.available()) {
    char c = client.read();
    
    if(startPrint){
      Serial.print(int(c));
      Serial.print(", ");
    }

    if(int(c) == -61 || int(c) == -62){
      specialChar = true;
      specialCharChar = c;
    }else if(specialChar == true){
      if(int(specialCharChar) == -61){
        if(int(c) == -68) c = 129; //ü
        else if(int(c) == -74) c = 148; //ö
        else if(int(c) == -92) c = 132; //ä
        else if(int(c) == -97) c = 225; //ß
        else if(int(c) == -100) c = 154;//Ü  
        else if(int(c) == -106) c = 153;//Ö
        else if(int(c) == -124) c = 142;//Ä
      }else if(int(specialCharChar) == -62){
        if(int(c) == -80) c = 248;//°
        else if(int(c) == -68) c = 171;// 1/2
        else if(int(c) == -67) c = 172;// 1/4
      }
      specialChar = false;
    }

    if(specialChar == false){

      line = line + c;
      if(c == '\n'){
        if(startPrint){
          if(line.startsWith("::")){
            Serial.print("COMMAND");
            Serial.print(line);
            if(printItToPrinterToo){
              if(line.startsWith("::L")){
                printer.setSize('L');
              }else if(line.startsWith("::M")){
                printer.setSize('M');
              }else if(line.startsWith("::S")){
                printer.setSize('S');
              }else if(line.startsWith("::JC")){
                printer.justify('C');
              }else if(line.startsWith("::JL")){
                printer.justify('L');
              }else if(line.startsWith("::BOLD")){
                printer.boldOn();
              }else if(line.startsWith("::NORMAL")){
                printer.boldOff();
              }
            }
          }else{
            Serial.print(line);
            if(printItToPrinterToo){
              printer.print(line);
            }
          }
        }
        if(line.startsWith("::BEGIN")){
          startPrint = true;
        }
        line = "";
      }
    }
  }

  // if the server's disconnected, stop the client:
  if (!client.connected()) {
    Serial.println();
    Serial.println("disconnecting.");

    if(printItToPrinterToo){
      printer.feed(3);
      printer.sleep();      // Tell printer to sleep
      printer.wake();       // MUST call wake() before printing again, even if reset
      printer.setDefault(); // Restore printer to defaults    client.stop();
    }

    // do nothing forevermore:
    for(;;)
      ;
  }
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////




void zumEssen() {
  // iterate over the notes of the melody:
  for (int thisNote = 0; thisNote < 8; thisNote++) {

    // to calculate the note duration, take one second 
    // divided by the note type.
    //e.g. quarter note = 1000 / 4, eighth note = 1000/8, etc.
    int noteDuration = 1000/noteDurations[thisNote];
    tone(tonePin, melody[thisNote],noteDuration);

    // to distinguish the notes, set a minimum time between them.
    // the note's duration + 30% seems to work well:
    int pauseBetweenNotes = noteDuration * 1.30;
    delay(pauseBetweenNotes);
    // stop the tone playing:
    noTone(tonePin);
  }
}



// Ende Loop
////////////////////////////////////////////////////////////////////////////////////////////////////////////



void fadeAussen()  { 
 
  analogWrite(LED_1, brightness);   
  analogWrite(LED_2, brightness);
  analogWrite(LED_3, brightness);
  analogWrite(LED_4, brightness);
  analogWrite(LED_5, brightness);

  // change the brightness for next time through the loop:
  brightness = brightness + fadeAmount;

  // reverse the direction of the fading at the ends of the fade: 
  if (brightness == 0 || brightness == 255) {
    fadeAmount = -fadeAmount ; 
  }     
  // wait for 30 milliseconds to see the dimming effect    
  delay(30);                            
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////



void fadeInnen()  { 
 
  analogWrite(LED_6, brightness); 

  // change the brightness for next time through the loop:
  brightness = brightness + fadeAmount;

  // reverse the direction of the fading at the ends of the fade: 
  if (brightness == 0 || brightness == 255) {
    fadeAmount = -fadeAmount ; 
  }     
  // wait for 30 milliseconds to see the dimming effect    
  delay(30);                            
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////



void lauflichtAussen()  { 
 
  do 
  {
    brightness = brightness + fadeAmount;
    analogWrite(LED_1, brightness);   
  }
  while (brightness < 255);

  do 
  {
    brightness = brightness + fadeAmount;
    analogWrite(LED_2, brightness);   
  }
  while (brightness < 255);

  do 
  {
    brightness = brightness + fadeAmount;
    analogWrite(LED_3, brightness);   
  }
  while (brightness < 255);

  do 
  {
    brightness = brightness + fadeAmount;
    analogWrite(LED_4, brightness);   
  }
  while (brightness < 255);

  do 
  {
    brightness = brightness + fadeAmount;
    analogWrite(LED_5, brightness);   
  }
  while (brightness < 255);

////////
  
  delay (1000);
  
  
////////

  do 
  {
    brightness = brightness - fadeAmount;
    analogWrite(LED_1, brightness);   
  }
  while (brightness > 0);

  do 
  {
    brightness = brightness - fadeAmount;
    analogWrite(LED_2, brightness);   
  }
  while (brightness > 0);

  do 
  {
    brightness = brightness - fadeAmount;
    analogWrite(LED_3, brightness);   
  }
  while (brightness > 0);

  do 
  {
    brightness = brightness - fadeAmount;
    analogWrite(LED_4, brightness);   
  }
  while (brightness > 0);

  do 
  {
    brightness = brightness - fadeAmount;
    analogWrite(LED_5, brightness);   
  }
  while (brightness > 0);
  
                           
}


