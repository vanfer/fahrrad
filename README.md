# Fahrradergometer

Dieses Repository stellt die Webanwendung zum Fahrradergometer bereit.
Die Messdatenverarbeitung ist hier zu finden: https://github.com/xenco/fahrrad-messdaten

// TODO: Weitere Beschreibung + Skizze

### Technologie

Die Anwendung nutzt verschiedene Bibliotheken und Frameworks.

* [PHP 5.6]
* [Laravel 5]
* [Mysql 5]
* [Twitter Bootstrap]
* [jQuery]
* [Highchart.js]

### Installation

##### 0. Vorbedignungen
* Webserver (z.B. Apache)
* MySQL DB Server
* Git
* Composer

##### 1. Herunterladen des aktuellen Codes
Der Code kann mittels Git aus diesem Repository geladen werden.
``` 
$ git clone https://github.com/xenco/fahrrad.git [Lokaler Speicherort]
``` 
z.B.
``` 
$ git clone https://github.com/xenco/fahrrad.git C:\xampp\htdocs\fahrrad
```
Das entstehende Verzeichnis sollte im Document Root des Webservers abgelegt, oder auf andere Weise dort verfügbar gemacht werden.

##### 2. Erstellen fehlender Ordner
Einige Ordner müssen erst erstellt werden bevor die Anwendung funktioniert.
Dazu in der Konsole in den gerade angelegten Ordner wechseln.
``` 
$ cd C:\xampp\htdocs\fahrrad
```
Und dort die fehlenden Ordner erstellen
``` 
$ mkdir storage\framework\cache storage\framework\views storage\framework\sessions
```

##### 3. Nachladen der Vendor Daten
Die Anwendung nutzt Composer, somit können die fehlenden Daten einfach installiert werden per:
``` 
$ composer update
```

##### 4. Konfiguration anpassen
Die Werte für die Datenbank, sowie die Url zur Anwendung sind in der Datei ./.env anzupassen:
```
APP_URL=http://localhost/fahrrad/
```
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fahrradergometer
DB_USERNAME=root
DB_PASSWORD=root
```

##### 5. Datenbankschema migrieren
Sofern die Datenbank läuft und in der .env Datei die richtigen Zugangsdaten eingetragen wurden lässt sich die Datenbank wie folgt erstellen:
``` 
$ php artisan migrate:refresh --seed
```

##### 5. Abschluss
Die Anwendung wurde nun vollständig installiert und kann über http://localhost/fahrrad/public/ aufgerufen werden.

Vorhandene Routen sind u.a.:
* Zentraler Display: /central
* Admin Ansicht (Passwort="test"): /admin

Diese befinden sich noch in der Entwicklung, mit Änderungen muss also gerechnet werden.