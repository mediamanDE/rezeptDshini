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

#define FONT_END7F //chars: 0x20-0xFF

// Enter a MAC address for your controller below.
// Newer Ethernet shields have a MAC address printed on a sticker on the shield
byte mac[6] = {  0x90, 0xA2, 0xDA, 0x0D, 0x0F, 0xB2 };
IPAddress server(10,15,20,110);
int printer_RX_Pin = 5;  // This is the green wire
int printer_TX_Pin = 6;  // This is the yellow wire

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


// Initialize the Ethernet client library
// with the IP address and port of the server 
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;

void setup() {
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
    client.println("GET /indexTest.php HTTP/1.1");
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

boolean specialChar = false;
void loop()
{
  // if there are incoming bytes available 
  // from the server, read them and print them:
  if (client.available()) {
    char c = client.read();
    
    Serial.print(int(c));
    Serial.print(", ");

    if(int(c) == -61){
      specialChar = true;
    }else if(specialChar == true){
      if(int(c) == -68) c = 129;
      if(int(c) == -74) c = 148;
      if(int(c) == -92) c = 132;
      if(int(c) == -97) c = 225;
      if(int(c) == -100) c = 154;
      if(int(c) == -106) c = 153;
      if(int(c) == -124) c = 142;
      specialChar = false;
    }

    /*
    if(int(c) == -4) c = 'u';
    if(int(c) == -10) c = 148;
    if(int(c) == -28) c = 'a';
    if(int(c) == -33) c = 's';
    if(int(c) == -36) c = 'U';
    if(int(c) == -42) c = 'O';
    if(int(c) == -60) c = 'A';
    */
//-4, -10, -28, -33, 10, üöäß
//-36, -42, -60, 10, ÜÖÄ
    if(specialChar == false){

      line = line + c;
      if(c == '\n'){
        if(startPrint){
          if(line.startsWith("::")){
            Serial.print("COMMAND");
            Serial.print(line);
            if(printItToPrinterToo){
              if(line.startsWith("::doubleHeightOn")){
                printer.doubleHeightOn();
              }
              if(line.startsWith("::doubleHeightOff")){
                printer.doubleHeightOff();
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

    printer.sleep();      // Tell printer to sleep
    printer.wake();       // MUST call wake() before printing again, even if reset
    printer.setDefault(); // Restore printer to defaults    client.stop();

    // do nothing forevermore:
    for(;;)
      ;
  }
}

