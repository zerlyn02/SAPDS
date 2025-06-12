#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN D2  // SDA / SS pin
#define RST_PIN D1 // RST pin
#define BUZZER D8

MFRC522 mfrc522(SS_PIN, RST_PIN); // correct variable name

const char* ssid = "potatohaochi";
const char* password = "hahahaha"; // not needed for open WiFi

const char* server = "18.141.9.202"; // server IP
const int serverPort = 80;
const String endpoint = "/sapds/src/attendance.php";

WiFiClient client;

void setup() {
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();  // fixed variable name

  WiFi.begin(ssid,password);
  pinMode(BUZZER, OUTPUT);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500); Serial.print(".");
  }
  Serial.println("\nConnected to WiFi");
}

void loop() {
  if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) return;

  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    uid += (mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
    uid += String(mfrc522.uid.uidByte[i], HEX);
  }

  uid.toUpperCase(); // optional for consistency
  Serial.println("RFID UID: " + uid);

  sendToServer(uid);
  delay(3000);  // delay to prevent spamming
}

void sendToServer(String uid) {
  if (client.connect(server, serverPort)) {
    digitalWrite(BUZZER, HIGH);
    delay(200);
    digitalWrite(BUZZER, LOW);
    delay(200);
    digitalWrite(BUZZER, HIGH);
    delay(200);
    digitalWrite(BUZZER, LOW);
    String location = "Main Gate"; // adjust per device
    String postData = "id=" + uid + "&location=" + location;

    client.println("POST " + endpoint + " HTTP/1.1");
    client.println("Host: " + String(server));
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.println("Content-Length: " + String(postData.length()));
    client.println();
    client.print(postData);

    Serial.println("Sent to server: " + postData);
  } else {
    Serial.println("Failed to connect to server.");
  }
}
