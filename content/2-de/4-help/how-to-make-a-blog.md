---
Title: Blog erstellen
---
Lerne wie man ein eigenes Blog erstellt. [Demo anschauen](/de/features/blog/).

[[image screenshot-blog.png Screenshot screenshot 75%]](/de/features/blog/fika-is-good-for-you)  

## Blog installieren

1. [Datenstrom Yellow herunterladen und entpacken](https://github.com/datenstrom/yellow/archive/master.zip).
2. Kopiere alle Dateien auf deinen Webserver.
3. Öffne deine Webseite im Webbrowser und wähle "Blog" aus.

Dein Blog ist sofort erreichbar. Die Installation kommt mit mehreren Seiten, "Home", "Blog" und "Über". Das ist nur ein Beispiel um loszulegen, verändere alles so wie du willst. Du kannst "Home" löschen, wenn du das Blog auf der Startseite anzeigen willst.

Falls Probleme auftreten, überprüfe bitte die [Servereinstellungen](server-configuration) oder frage den [Support](support).
 
## Blogeinträge schreiben

Lass uns einen Blick ins `content`-Verzeichnis werfen, dort befindet sich das Blogverzeichnis mit allen Blogseiten. Öffne die Datei `2013-04-07-blog-example.md`. Es werden Einstellungen und Text der Seite angezeigt. Ganz oben auf der Seite kannst du `Title` und andere [Einstellungen](markdown-cheat-sheet#einstellungen) ändern. Darunter kannst du [Markdown](markdown-cheat-sheet) benutzen. Hier ist ein Beispiel:

```
---
Title: Blog-Beispiel
Published: 2013-04-07
Author: Datenstrom
Layout: blog
Tag: Beispiel
---
Das ist eine Beispiel-Blogseite.

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 
tempor incididunt ut labore et dolore magna pizza. Ut enim ad minim veniam, 
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. 
```

Um eine neue Blogseite hinzuzufügen, erstellst du eine neue Datei im Blogverzeichnis. Ganz oben auf der Seite solltest du `Published` und weitere Einstellungen ändern. Datumsangaben erfolgen im Format JJJJ-MM-TT. Das Veröffentlichungsdatum wird zur Sortierung der Blogseiten verwendet. Mit `Tag` kann man ähnliche Seiten gruppieren. Hier ein weiteres Beispiel:

```
---
Title: Fika ist gut für dich
Published: 2016-06-01
Author: Datenstrom
Layout: blog
Tag: Beispiel, Kaffee
---
Fika ist ein schwedischer Brauch. Es ist eine Kaffeepause, bei der Menschen  
bei einer Tasse Kaffee oder Tee zusammenkommen. Das kann mit Arbeitskollegen  
sein oder du lädst Freude dazu ein. Fika ist ein so bedeutender Teil vom 
schwedischen Alltag, dass es sowohl als Verb als auch als Nomen verwendet  
wird. Wie oft machst du Fika?
```

Ein Video hinzufügen mit der [Youtube-Erweiterung](https://github.com/datenstrom/yellow-extensions/tree/master/features/youtube):

```
---
Title: Fika ist gut für dich
Published: 2016-06-01
Author: Datenstrom
Layout: blog
Tag: Beispiel, Kaffee, Video
---
Fika ist ein schwedischer Brauch. Es ist eine Kaffeepause, bei der Menschen  
bei einer Tasse Kaffee oder Tee zusammenkommen. Das kann mit Arbeitskollegen  
sein oder du lädst Freude dazu ein. Fika ist ein so bedeutender Teil vom 
schwedischen Alltag, dass es sowohl als Verb als auch als Nomen verwendet  
wird. Wie oft machst du Fika?

[youtube aIMR73COZQU]
```

Das Video erst anzeigen wenn ein Besucher auf die Blogseite klickt. Du kannst `[--more--]` benutzen, um an der gewünschten Stelle einen Seitenumbruch zu erzeugen:

```
---
Title: Fika ist gut für dich
Published: 2016-06-01
Author: Datenstrom
Layout: blog
Tag: Beispiel, Kaffee, Video
---
Fika ist ein schwedischer Brauch. Es ist eine Kaffeepause, bei der Menschen  
bei einer Tasse Kaffee oder Tee zusammenkommen. Das kann mit Arbeitskollegen  
sein oder du lädst Freude dazu ein. Fika ist ein so bedeutender Teil vom 
schwedischen Alltag, dass es sowohl als Verb als auch als Nomen verwendet  
wird. Wie oft machst du Fika? [--more--]

[youtube aIMR73COZQU]
```

## Sidebar anzeigen

Um eine Sidebar anzuzeigen, erstelle die Datei `content/shared/sidebar.md`. Du kannst auch eine `sidebar.md` in deinem Blogverzeichnis erstellen und sie wird nur auf Seiten im gleichen Verzeichnis angezeigt. Hier ist ein Beispiel:

```
---
Title: Sidebar
Status: hidden
---
Links

* [Twitter](https://twitter.com/datenstromse)
* [GitHub](https://github.com/datenstrom)
* [Datenstrom](https://datenstrom.se/de/)
```

Verwende [Abkürzungen](https://github.com/datenstrom/yellow-extensions/tree/master/features/blog#how-to-show-blog-information), um Informationen über das Blog anzuzeigen.

```
---
Title: Sidebar
Status: hidden
---
Neu

[blogchanges /blog/ 5]

Tags

[blogtags /blog/ 5]
```

Hier ist die selbe Sidebar, falls sich das Blog auf der Startseite befindet:

```
---
Title: Sidebar
Status: hidden
---
Neu

[blogchanges / 5]

Tags

[blogtags / 5]
```

## Kopfzeile anzeigen

Um eine Kopfzeile anzuzeigen, erstelle die Datei `content/shared/header.md`. Du kannst auch eine `header.md` in deinem Blogverzeichnis erstellen und sie wird nur auf Seiten im gleichen Verzeichnis angezeigt. Hier ist ein Beispiel:

```
---
Title: Header
Status: hidden
---
Ich mag Markdown.
```

## Fußzeile anpassen

Um die Fußzeile anzupassen, ändere die Datei `content/shared/footer.md`. Du kannst auch eine `footer.md` in deinem Blogverzeichnis erstellen und sie wird nur auf Seiten im gleichen Verzeichnis angezeigt. Hier ist ein Beispiel:

```
---
Title: Footer
Status: hidden
---
[Erstellt mit Datenstrom Yellow](https://datenstrom.se/de/yellow/)
```

## Erweiterungen hinzufügen

* [Eine Kommentarfunktion zum Blog hinzufügen](https://github.com/datenstrom/yellow-extensions/tree/master/features/disqus)
* [Eine Suche zum Blog hinzufügen](https://github.com/datenstrom/yellow-extensions/tree/master/features/search)
* [Einen Feed zum Blog hinzufügen](https://github.com/datenstrom/yellow-extensions/tree/master/features/feed)
* [Eine Entwurfseite hinzufügen](https://github.com/datenstrom/yellow-extensions/tree/master/features/draft)
* [Ein statisches Blog erstellen](server-configuration#statische-webseite)

[Weiter: Wiki erstellen →](how-to-make-a-wiki)
