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
#include <aJSON.h>
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
boolean printItToPrinterToo = false;


// Initialize the Ethernet client library
// with the IP address and port of the server 
// that you want to connect to (port 80 is default for HTTP):
EthernetClient client;

void setup() {
 // Open serial communications and wait for port to open:
  Serial.begin(9600);
   while (!Serial) {
    ; // wait for serial port to connect. Needed for Leonardo only
  }
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
    Serial.println("connected");
    // Make a HTTP request:
    //client.println("GET /indexRaw.php?emo=1&ratio= HTTP/1.1");
    client.println("GET /index2.html HTTP/1.1");
    client.println("Host: rezept.dshini.dev.mediaman.de");
    client.println("Content-Type: application/x-www-form-urlencoded; charset=iso-8859-1");
    client.println();
  } 
  else {
    // kf you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  
}

void loop()
{
  // if there are incoming bytes available 
  // from the server, read them and print them:
  if (client.available()) {
    char c = client.read();
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
            printer.println(line);
          }
        }
      }
      if(line.startsWith("::BEGIN")){
        startPrint = true;
      }
      line = "";
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

/**
 * Parse the JSON String. Uses aJson library
 * 
 * Refer to http://hardwarefun.com/tutorials/parsing-json-in-arduino
 */
char* parseJson(char *jsonString) 
{
    char* value;

    aJsonObject* root = aJson.parse(jsonString);

    if (root != NULL) {
        //Serial.println("Parsed successfully 1 " );
        aJsonObject* created_at = aJson.getObjectItem(root, "created_at"); 

       value = created_at->valuestring;
    }else{
      Serial.println('root is NULL');
    }

    if (value) {
        return value;
    } else {
        return NULL;
    }
}
