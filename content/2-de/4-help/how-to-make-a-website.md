---
Title: Webseite erstellen
---
[[image screenshot-website-de.png Screenshot screenshot 75%]](/de/)  
Lerne wie man eine eigene Webseite erstellt. [Demo anschauen](/de/).

## Webseite installieren

1. [Datenstrom Yellow herunterladen und entpacken](https://github.com/datenstrom/yellow/archive/master.zip).
2. Kopiere alle Dateien auf dein Webhosting.
3. Öffne deine Webseite im Webbrowser und wähle "Website" aus.

Deine Webseite ist sofort erreichbar. Die Installation kommt mit zwei Seiten, "Home" und "Über". Das ist nur ein Beispiel um loszulegen, verändere alles so wie du willst. Man kann eine Webseite erstellen, indem man weitere Dateien und Verzeichnisse hinzufügt.

Falls Probleme auftreten, überprüfe bitte die [Servereinstellungen](server-configuration) oder frage den [Support](support).

## Webseiten schreiben

Lass uns einen Blick ins `content`-Verzeichnis werfen, hier sind alle Webseiten. Öffne die Datei `content/1-home/page.md`. Es werden Einstellungen und Text der Seite angezeigt. Ganz oben auf der Seite kannst du `Title` und weitere [Einstellungen](markdown-cheat-sheet#einstellungen) ändern. Hier ist ein Beispiel:

```
---
Title: Home
---
Deine Webseite funktioniert!

[edit - Du kannst diese Seite bearbeiten] oder einen Texteditor benutzen.
```

Um eine neue Seite hinzuzufügen, erstellst du eine neue Datei im Home-Verzeichnis oder einem anderen `content`-Verzeichnis. Die [Navigation](adding-content) wird automatisch aus deinen `content`-Verzeichnissen erstellt. Hier ist ein weiteres Beispiel:

```
---
Title: Demo
---
[edit - Du kannst diese Seite bearbeiten]. Die Hilfe zeigt dir wie 
man kleine Webseiten, Blogs und Wikis erstellt. 
[Weitere Informationen](https://developers.datenstrom.se/de/help/).
```

Ein Bild hinzufügen:

```
---
Title: Demo
---
[image picture.jpg Beispiel rounded]

[edit - Du kannst diese Seite bearbeiten]. Die Hilfe zeigt dir wie 
man kleine Webseiten, Blogs und Wikis erstellt. 
[Weitere Informationen](https://developers.datenstrom.se/de/help/).
```

Du kannst [Markdown](markdown-cheat-sheet) benutzen um Webseiten zu bearbeiten.

## Sidebar anzeigen

Um eine Sidebar anzuzeigen, erstelle die Datei `sidebar.md` in einem `content`-Verzeichnis. Die Sidebar wird auf allen Seiten im gleichen Verzeichnis angezeigt. Du kannst entscheiden ob du eine Sidebar haben möchtest oder nicht. Hier ist eine Beispiel-Sidebar:

```
---
Title: Sidebar
Status: hidden
---
Links

* [Twitter](https://twitter.com/datenstromse)
* [GitHub](https://github.com/datenstrom)
* [Datenstrom](https://datenstrom.se)
```

## Weitere Funktionen

* [Eine Bildergalerie zur Webseite hinzufügen](https://github.com/datenstrom/yellow-plugins/tree/master/gallery)
* [Eine Suche zur Webseite hinzufügen](https://github.com/datenstrom/yellow-plugins/tree/master/search)
* [Eine Sitemap zur Webseite hinzufügen](https://github.com/datenstrom/yellow-plugins/tree/master/sitemap)
* [Eine Kontaktseite zur Webseite hinzufügen](https://github.com/datenstrom/yellow-plugins/tree/master/contact)
* [Eine statische Webseite erstellen](server-configuration#statische-webseite)

[Weiter: Blog erstellen →](how-to-make-a-blog)