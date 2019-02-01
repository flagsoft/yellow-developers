---
Title: Sicherheitseinstellungen
---
Wie man Sicherheit und Datenschutz konfiguriert.

## Datenverschlüsselung

Überprüfe ob deine Webseite [Datenverschlüsselung](https://www.ssllabs.com/ssltest/) unterstützt. Falls Probleme auftreten, kontaktiere bitte deinen Webhoster. Am Besten ist es wenn deine Webseite automatisch von HTTP nach HTTPS weiterleitet und die Internetverbindung immer verschlüsselt ist.

## Loginbeschränkungen

Falls du nicht willst dass Benutzerkonten im Webbrowser erstellt werden, beschränke die [Login-Seite](https://github.com/datenstrom/yellow-plugins/tree/master/edit). Öffne die Datei `system/config/config.ini` und ändere `EditLoginRestrictions: 1`. Benutzer dürfen sich dann noch einloggen, aber keine Benutzerkonten erstellen.

## Benutzerbeschränkungen

Falls du nicht willst dass Seiten im Webbrowser verändert werden, beschränke [Benutzerkonten](adjusting-system#benutzerkonten). Öffne die Datei `system/config/user.ini` und ändere am Zeilenende die Startseite. Benutzer dürfen dann nur noch Seiten innerhalb ihrer Startseite bearbeiten.

## Sicherheitsmodus

Falls du deine Webseite vor Unfug schützen willst, beschränke weitere Funktionen. Öffne die Datei `system/config/config.ini` und ändere `SafeMode: 1`. Benutzer dürfen dann nicht mehr HTML und JavaScript benutzen, [Markdown](markdown-cheat-sheet) und andere Funktionen sind eingeschränkt.

[Weiter: Servereinstellungen →](server-configuration)