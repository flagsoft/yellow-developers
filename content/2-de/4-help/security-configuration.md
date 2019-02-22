---
Title: Sicherheitseinstellungen
---
Wie man Sicherheit und Datenschutz konfiguriert.

## Datenverschlüsselung

Überprüfe ob deine Webseite [Datenverschlüsselung](https://www.ssllabs.com/ssltest/) unterstützt. Falls Probleme auftreten, kontaktiere bitte deinen Webhoster. Am Besten ist es wenn deine Webseite automatisch von HTTP nach HTTPS weiterleitet und die Internetverbindung immer verschlüsselt ist.

## Loginbeschränkungen

Falls du nicht willst dass Benutzerkonten im Webbrowser erstellt werden, beschränke die [Login-Seite](https://github.com/datenstrom/yellow-extensions/tree/master/features/edit). Öffne die Datei `system/settings/system.ini` und ändere `EditLoginRestrictions: 1`. Benutzer dürfen sich dann einloggen, aber keine neue Benutzerkonten erstellen.

## Benutzerbeschränkungen

Falls du nicht willst dass Seiten im Webbrowser verändert werden, beschränke [Benutzerkonten](adjusting-system#benutzerkonten). Öffne die Datei `system/settings/user.ini` und ändere am Zeilenende die Startseite. Benutzer dürfen dann Seiten innerhalb ihrer Startseite bearbeiten, aber nirgendwo sonst.

## Sicherheitsmodus

Falls du deine Webseite vor unterschiedlichem Unfug schützen willst, beschränke Funktionen. Öffne die Datei `system/settings/system.ini` und ändere `SafeMode: 1`. Benutzer dürfen dann [Markdown](markdown-cheat-sheet) benutzen, aber HTML und andere Funktionen sind eingeschränkt.

[Weiter: Servereinstellungen →](server-configuration)