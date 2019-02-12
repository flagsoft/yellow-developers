---
Title: System anpassen
---
Alle Einstellungen befinden sich im `system`-Verzeichnis. Hier macht man Anpassungen.

[image screenshot-system.png Screenshot]

Das `config`-Verzeichnis enthält Konfigurationsdateien. Das `plugins`-Verzeichnis enthält die Funktionen der Webseite. Das `themes`-Verzeichnis ist für das Aussehen der Webseite zuständig. Im `trash`-Verzeichnis werden die gelöschten Dateien gespeichert. Änderungen in diesen Verzeichnissen wirken sich auf die gesamte Webseite aus. 

## Systemeinstellungen

Die zentrale Konfigurationsdatei ist `system/config/config.ini`. Hier ist ein Beispiel:

    Sitename: Anna Svensson Design
    Author: Anna Svensson
    Email: anna@svensson.de
    Language: de
    Timezone: Europe/Berlin
    Theme: flatsite

Dort kannst du die Systemeinstellungen festlegen, zum Beispiel den Namen der Webseite und die E-Mail des Webmasters. Die individuellen [Einstellungen](markdown-cheat-sheet#einstellungen) lassen sich ganz oben auf jeder Seite festlegen. Bei einer neuen Installation sollte man `Sitename`, `Author` und `Email` anpassen.

## Texteinstellungen

Eine weitere Konfigurationsdatei ist `system/config/text.ini`. Hier ist ein Beispiel:

    EditLoginTitle: Willkommen in Berlin
    Error404Title: Datei nicht gefunden
    Error404Text: Die angeforderte Datei wurde nicht gefunden. Oh nein...
    DateFormatShort: F Y
    DateFormatMedium: d.m.Y
    DateFormatLong: d.m.Y H:i

Dort kannst du die Texteinstellungen festlegen, zum Beispiel Fehlermeldungen der Webseite und das Datumsformat. Der Standard-Text wird in der entsprechenden [Sprachdatei](https://github.com/datenstrom/yellow-plugins/blob/master/language/language-de.txt) festgelegt. Man kann Text aus der Sprachdatei in die Texteinstellungen kopieren und anpassen.

## Benutzerkonten

Alle Benutzerkonten sind in `system/config/user.ini` gespeichert. Hier ist ein Beispiel:

    anna@svensson.de: $2y$10$j26zDnt/xaWxC/eqGKb9p.d6e3pbVENDfRzauTawNCUHHl3CCOIzG,Anna,de,active,21196d7e857d541849e4,946684800,0,none,/
    deutsch@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Demo,de,active,2a2ddef05dbea5071ba0,946684800,0,none,/
    guest@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Guest,en,active,b3106b8b1732ee60f5b3,946684800,0,none,/tests/

Im [Webbrowser](https://github.com/datenstrom/yellow-plugins/tree/master/edit) und der [Befehlszeile](https://github.com/datenstrom/yellow-plugins/tree/master/command) kannst du neue Benutzerkonten anlegen und Kennwörter ändern. Ein Benutzerkonto besteht aus einer Zeile mit E-Mail, verschlüsseltem Kennwort und verschiedenen Einstellungen. Am Zeilenende befindet sich die Startseite des Benutzers.

[Weiter: Spracheinstellungen →](language-configuration)