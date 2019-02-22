---
Title: System anpassen
---
Alle Einstellungen befinden sich im `system`-Verzeichnis. Hier macht man Anpassungen.

[image screenshot-system.png Screenshot]

Das `extensions`-Verzeichnis enthält installierte Erweiterungen. Im `layouts`-Verzeichnis und im `resources`-Verzeichnis kann man das Aussehen seiner Webseite anpassen. Das `settings`-Verzeichnis enthält Konfigurationsdateien. Das `trash`-Verzeichnis enthält gelöschte Dateien.

## Systemeinstellungen

Die zentrale Konfigurationsdatei ist `system/settings/system.ini`. Hier ist ein Beispiel:

    Sitename: Anna Svensson Design
    Author: Anna Svensson
    Email: anna@svensson.de
    Language: de
    Timezone: Europe/Berlin

Dort kannst du die Systemeinstellungen festlegen, zum Beispiel den Namen der Webseite und die E-Mail des Webmasters. Die individuellen [Einstellungen](markdown-cheat-sheet#einstellungen) lassen sich ganz oben auf jeder Seite festlegen. Bei einer neuen Installation sollte man `Sitename`, `Author` und `Email` anpassen.

## Texteinstellungen

Eine weitere Konfigurationsdatei ist `system/settings/text.ini`. Hier ist ein Beispiel:

    EditLoginTitle: Willkommen in Berlin
    Error404Title: Datei nicht gefunden
    DateFormatShort: F Y
    DateFormatMedium: d.m.Y
    DateFormatLong: d.m.Y H:i

Dort kannst du die Texteinstellungen festlegen, zum Beispiel Fehlermeldungen der Webseite und das Datumsformat. Der Standard-Text wird in der entsprechenden [Sprachdatei](https://github.com/datenstrom/yellow-extensions/blob/master/languages/german/german-language.txt) festgelegt. Man kann Text aus einer Sprachdatei in die Texteinstellungen kopieren und anpassen.

## Benutzerkonten

Alle Benutzerkonten sind in `system/settings/user.ini` gespeichert. Hier ist ein Beispiel:

    anna@svensson.de: $2y$10$j26zDnt/xaWxC/eqGKb9p.d6e3pbVENDfRzauTawNCUHHl3CCOIzG,Anna,de,active,21196d7e857d541849e4,946684800,0,none,/
    deutsch@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Demo,de,active,2a2ddef05dbea5071ba0,946684800,0,none,/
    guest@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Guest,en,active,b3106b8b1732ee60f5b3,946684800,0,none,/tests/

Im [Webbrowser](https://github.com/datenstrom/yellow-extensions/tree/master/features/edit) und der [Befehlszeile](https://github.com/datenstrom/yellow-extensions/tree/master/features/command) kannst du neue Benutzerkonten anlegen und Kennwörter ändern. Ein Benutzerkonto besteht aus einer Zeile mit E-Mail, verschlüsseltem Kennwort und verschiedenen Einstellungen. Am Zeilenende befindet sich die Startseite des Benutzers.

[Weiter: Spracheinstellungen →](language-configuration)