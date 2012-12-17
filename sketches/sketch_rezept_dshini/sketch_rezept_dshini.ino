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
#include "Jongleur.h"
#include "Jongleur404.h"

#define FONT_END7F //chars: 0x20-0xFF

#define LED_1 13
#define LED_2 12
#define LED_3 11
#define LED_4 9
#define LED_5 8
#define LED_6 7

// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
byte mac[6] = {  0x90, 0xA2, 0xDA, 0x0D, 0x0F, 0xB2 };
IPAddress server(10,15,20,110);
int printer_RX_Pin = 22;  // This is the green wire
int printer_TX_Pin = 23;  // This is the yellow wire


// notes in the melody:
int melody[] = {
  NOTE_A5, NOTE_A4};
  
  // note durations: 4 = quarter note, 8 = eighth note, etc.:
int noteDurations[] = {4, 8};

// notes in the melody:
int melody404[] = {
  NOTE_A4, NOTE_GS4, NOTE_G4, NOTE_FS4, NOTE_F4, NOTE_E4};

// note durations: 4 = quarter note, 8 = eighth note, etc.:
int noteDurations404[] = {32, 32, 32, 32, 32, 32};
  
// define Tone pin
int tonePin = 47;
  
  
const int buttonPinGo = 43;     // the number of the pushbutton pin

const int buttonPinRational_1 = 28;     // the number of the pushbutton pin
const int buttonPinRational_2 = 32;     // the number of the pushbutton pin
const int buttonPinRational_3 = 36;     // the number of the pushbutton pin
const int buttonPinRational_4 = 40;     // the number of the pushbutton pin
const int buttonPinRational_5 = 44;     // the number of the pushbutton pin
const int buttonPinRational_6 = 46;     // the number of the pushbutton pin


const int buttonPinEmotional_1 = 27;     // the number of the pushbutton pin
const int buttonPinEmotional_2 = 31;     // the number of the pushbutton pin
const int buttonPinEmotional_3 = 35;     // the number of the pushbutton pin
const int buttonPinEmotional_4 = 39;     // the number of the pushbutton pin


int buttonStateGo = 0;         // variable for reading the button status
int buttonStateRational = 0;         // variable for reading the button status
int buttonStateEmotional = 0;         // variable for reading the button status

int brightness = 0;    // how bright the LED is
int brightnessRest = 70;  // delay * value
int brightnessRestCounter = 0;
int fadeAmount = 1;
int brightness1 = 0;
int brightness2 = 0;
int brightness3 = 0;
int brightness4 = 0;
int brightness5 = 0;
  
  

Adafruit_Thermal printer(printer_RX_Pin, printer_TX_Pin);

String emotional = "";
String rational = "";
String title = "";
String ingredients = "";
String preparition_time = "";
String preparation = "";
String line = "";
boolean startPrint = false;
boolean specialChar = false;
char specialCharChar;

// config
boolean printItToPrinterToo = true;
boolean playSound = true;


// Initialize the Ethernet client library
// with the IP address and port of the server 
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;




////////////////////////////////////////////////////////////////////////////////////////////////////////////




void setup() {
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
    
  pinMode(LED_1, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_2, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_3, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_4, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_5, OUTPUT);  // LED is an OUTPUT 
  pinMode(LED_6, OUTPUT);  // LED is an OUTPUT 
  
  pinMode(buttonPinGo, INPUT_PULLUP);     
  
  pinMode(buttonPinRational_1, INPUT_PULLUP);
  pinMode(buttonPinRational_2, INPUT_PULLUP);
  pinMode(buttonPinRational_3, INPUT_PULLUP);
  pinMode(buttonPinRational_4, INPUT_PULLUP);
  pinMode(buttonPinRational_5, INPUT_PULLUP);
  pinMode(buttonPinRational_6, INPUT_PULLUP);
  
  pinMode(buttonPinEmotional_1, INPUT_PULLUP);
  pinMode(buttonPinEmotional_2, INPUT_PULLUP);
  pinMode(buttonPinEmotional_3, INPUT_PULLUP);
  pinMode(buttonPinEmotional_4, INPUT_PULLUP);

 // Open serial communications and wait for port to open:
  Serial.begin(9600);
  Serial.println("Ready");
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////

boolean executionFinished = false;
void loop()
{
  changeBrightness();
  delay(30);
  analogWrite(LED_6, brightness);
  finishExecutionDisplay();

  if(digitalRead(buttonPinGo) == 0){
    Serial.println("Start");
    //Serial.println("buttonPinGo: " + String(digitalRead(buttonPinGo)));
    Serial.print("buttonPinRational: ");
    Serial.print(String(digitalRead(buttonPinRational_1)) + " ");
    Serial.print(String(digitalRead(buttonPinRational_2)) + " ");
    Serial.print(String(digitalRead(buttonPinRational_3)) + " ");
    Serial.print(String(digitalRead(buttonPinRational_4)) + " ");
    Serial.print(String(digitalRead(buttonPinRational_5)) + " ");
    Serial.print(String(digitalRead(buttonPinRational_6)) + " ");
    Serial.print("= " + String(getRationalButtonValue()));
    Serial.println(" ");
    Serial.print("buttonPinEmotional: ");
    Serial.print(String(digitalRead(buttonPinEmotional_1)) + " ");
    Serial.print(String(digitalRead(buttonPinEmotional_2)) + " ");
    Serial.print(String(digitalRead(buttonPinEmotional_3)) + " ");
    Serial.print(String(digitalRead(buttonPinEmotional_4)) + " ");
    Serial.print("= " + String(getEmotionalButtonValue()));
    Serial.println(" ");
    Serial.println("-------------------------------------");
    if(getRationalButtonValue() <= 4 && getEmotionalButtonValue() <=6){
      initExecution();
      brightness = 254; //254 weil in changeBrightness zu Anfang eins aufaddiert wird
      analogWrite(LED_6, brightness);
      while(executeRecipe() == false);
      if(playSound) zumEssen();
      Serial.println("finished");
    }else{
      printErrorMessage();
    }
    delay(500);
  }
}
// Ende Loop
////////////////////////////////////////////////////////////////////////////////////////////////////////////

int getRationalButtonValue(){
  if(digitalRead(buttonPinRational_1) == 0) return 6;
  if(digitalRead(buttonPinRational_2) == 0) return 5;
  if(digitalRead(buttonPinRational_3) == 0) return 4;
  if(digitalRead(buttonPinRational_4) == 0) return 3;
  if(digitalRead(buttonPinRational_5) == 0) return 2;
  if(digitalRead(buttonPinRational_6) == 0) return 1;
  return 1;
}

int getEmotionalButtonValue(){
  int b1 = digitalRead(buttonPinEmotional_1);
  int b2 = digitalRead(buttonPinEmotional_2);
  int b3 = digitalRead(buttonPinEmotional_3);
  int b4 = digitalRead(buttonPinEmotional_4);
  if(b1 && !b2 && b3 && b4) return 1; // 1 0 1 1
  if(!b1 && b2 && !b3 && b4) return 2; // 0 1 0 1  
  if(b1 && !b2 && !b3 && b4) return 3; // 1 0 0 1  
  if(!b1 && b2 && !b3 && !b4) return 4; // 0 1 0 0  
  if(b1 && !b2 && !b3 && !b4) return 5; // 1 0 0 0  
  if(b1 && b2 && b3 && b4) return 6; // 1 1 1 1  
  if(!b1 && b2 && b3 && b4) return 7; // 0 1 1 1
  return 8;
}

void printErrorMessage(){
  Serial.println("404");
  if(playSound) zumFehler();
  if(printItToPrinterToo){
    printer.feed(1);
    printer.printBitmap(Jongleur404_width, Jongleur404_height, Jongleur404_data); //Print Jongleur Bitmap
    printer.feed(2);
    printer.println("OH NEIN! Da ist etwas falsch gelaufen. Einer oder beide Drehschalter stehen auf einer Position, die (noch) nicht unterstuetzt wird. Korrigiere die Schalterposition und versuch's noch mal!");
    printer.feed(5);
    if(playSound) zumEssen();
    printer.sleep();      // Tell printer to sleep
    printer.wake();       // MUST call wake() before printing again, even if reset
    printer.setDefault(); // Restore printer to defaults    client.stop();
  }
}

void executionDisplay(){
  int executionStep = 15;
  if(brightness5 == 0   && brightness1 < 255) brightness1+=executionStep;
  if(brightness1 == 255 && brightness2 < 255) brightness2+=executionStep;
  if(brightness2 == 255 && brightness3 < 255) brightness3+=executionStep;
  if(brightness3 == 255 && brightness4 < 255) brightness4+=executionStep;
  if(brightness4 == 255 && brightness5 < 255) brightness5+=executionStep;
  
  if(brightness5 == 255  && brightness1 > 0) brightness1-=executionStep;
  if(brightness1 == 0    && brightness2 > 0) brightness2-=executionStep;
  if(brightness2 == 0    && brightness3 > 0) brightness3-=executionStep;
  if(brightness3 == 0    && brightness4 > 0) brightness4-=executionStep;
  if(brightness4 == 0    && brightness5 > 0) brightness5-=executionStep;

  //Serial.println("executionDisplay brightness1-5: " + String(brightness1) + ", " + String(brightness2) + ", " + String(brightness3) + ", " + String(brightness4) + ", " + String(brightness5) + ", ");
  analogWrite(LED_1, brightness1); 
  analogWrite(LED_2, brightness2); 
  analogWrite(LED_3, brightness3); 
  analogWrite(LED_4, brightness4); 
  analogWrite(LED_5, brightness5); 
}

void finishExecutionDisplay(){
  int executionStep = 5;
  if(brightness1 > 0 || brightness2 > 0 || brightness3 > 0 || brightness4 > 0 || brightness5 > 0){
    if(brightness1 > 0){
      brightness1-=executionStep;
    }else if(brightness2 > 0){
      brightness2-=executionStep;
    }else if(brightness3 > 0){
      brightness3-=executionStep;
    }else if(brightness4 > 0){
      brightness4-=executionStep;
    }else if(brightness5 > 0){
      brightness5-=executionStep;
    }
  
    //Serial.println("finishExecutionDisplay brightness1-5: " + String(brightness1) + ", " + String(brightness2) + ", " + String(brightness3) + ", " + String(brightness4) + ", " + String(brightness5) + ", ");
    analogWrite(LED_1, brightness1); 
    analogWrite(LED_2, brightness2); 
    analogWrite(LED_3, brightness3); 
    analogWrite(LED_4, brightness4); 
    analogWrite(LED_5, brightness5); 
  }
}


void changeBrightness() {
  if(brightnessRestCounter > 0){
    brightnessRestCounter--;
  }else{
    brightness += fadeAmount;
    if(brightness == 255) {
      fadeAmount = -fadeAmount;
    }else if(brightness == 0) {
      fadeAmount = -fadeAmount;
      brightnessRestCounter = brightnessRest;
    }
  }
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////

void initExecution() {
  Serial.println("connecting...");
  client.flush();
  Serial.println("connected: " + String(client.connected()));
  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.println("connected");
    // Make a HTTP request:
    client.println("GET /indexRaw.php?emo=" + String(getEmotionalButtonValue()) + "&ratio=" + String(getRationalButtonValue()) + " HTTP/1.1");
    //client.println("GET /indexRawTest.php HTTP/1.1");
    client.println("Host: rezept.dshini.dev.mediaman.de");
    //client.println("Content-Type: application/x-www-form-urlencoded; charset=iso-8859-1");
    client.println("Content-Type: application/x-www-form-urlencoded; charset=cp437");
    client.println();
  } else {
    // kf you didn't get a connection to the server:
    Serial.println("connection failed");
  }
}

boolean executeRecipe() {
  startPrint = false; 
  // if there are incoming bytes available 
  // from the server, read them and print them:
  while (client.available()) {
    char c = client.read();
    /*
    if(startPrint){
      Serial.print(int(c));
      Serial.print(", ");
    }
    */
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
        executionDisplay();
        //Serial.println("executionDisplay");
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
            int charPos = 0;
            int charCount = 0;
            for(charPos = 0; charPos < line.length(); charPos++, charCount++){
              //Serial.println(line.length());
              if(charCount == 2){
                charCount = 0;
                executionDisplay();
              }
              Serial.print(line[charPos]);
              if(printItToPrinterToo){
                printer.print(line[charPos]);
              }
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
    client.stop();

    if(printItToPrinterToo){
      printer.feed(2);
      printer.printBitmap(Jongleur_width, Jongleur_height, Jongleur_data); //Print Jongleur Bitmap
      printer.feed(5);
      printer.sleep();      // Tell printer to sleep
      printer.wake();       // MUST call wake() before printing again, even if reset
      printer.setDefault(); // Restore printer to defaults    client.stop();
    }

    return true;
  }  
  return false;
}


void zumEssen() {
  // iterate over the notes of the melody:
  for (int thisNote = 0; thisNote < 2; thisNote++) {

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


void zumFehler() {
  // iterate over the notes of the melody:
  for (int thisNote = 0; thisNote < 6; thisNote++) {

    // to calculate the note duration, take one second 
    // divided by the note type.
    //e.g. quarter note = 1000 / 4, eighth note = 1000/8, etc.
    int noteDuration = 1000/noteDurations404[thisNote];
    tone(tonePin, melody404[thisNote],noteDuration);

    // to distinguish the notes, set a minimum time between them.
    // the note's duration + 30% seems to work well:
    int pauseBetweenNotes = noteDuration * 1.30;
    delay(pauseBetweenNotes);
    // stop the tone playing:
    noTone(tonePin);
  }
}



