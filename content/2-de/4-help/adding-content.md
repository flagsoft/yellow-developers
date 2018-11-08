---
Title: Inhalt hinzufügen
---
Alle Inhalte befinden sich im `content`-Verzeichnis. Hier bearbeitet man seine Webseite. 

[image screenshot-content.png Screenshot]

Die `content`-Verzeichnisse stehen auf deiner Webseite zur Verfügung. In jedem Verzeichnis gibt es eine Datei mit Namen `page.md` oder dem Namen des Verzeichnisses. Man kann auch weitere Dateien und Verzeichnisse hinzufügen. Im Prinzip ist das, was du im Dateimanager siehst, die Webseite die du bekommst.

## Dateien und Verzeichnisse

Die Navigation wird automatisch aus deinen `content`-Verzeichnissen erstellt. Es werden nur Verzeichnisse mit einem Präfix in der Navigation angezeigt. Verzeichnisse mit Präfix sind für sichtbare Seiten, Verzeichnisse ohne Präfix sind für unsichtbare Seiten. Alle Dateien und Verzeichnisse können ein Präfix benutzen:

1. Verzeichnisse können ein numerisches Präfix haben, z.B. `1-home` oder `9-about`
2. Dateien können ein Datumspräfix haben, z.B. `2013-04-07-blog-example.md`
3. Ohne Präfix gibt es keine besondere Reihenfolge, z.B. `wiki-example.md`

Präfixe und Suffixe werden aus der Adresse entfernt, damit es besser aussieht. Zum Beispiel ist das Verzeichnis `content/9-about/` vorhanden als `http://website/about/`. Die Datei `content/9-about/what-we-do.md` wird zu `http://website/about/what-we-do`.

Verzeichnisse können weitere Dateien und Verzeichnisse enthalten. Es gibt eine Ausnahme. Das erste Verzeichnis darf keine Unterverzeichnisse besitzen, da es für die Startseite verantwortlich ist und auf deiner Webseite vorhanden ist als `http://website/`.

## Markdown

Du kannst [Markdown](markdown-cheat-sheet) benutzen um Webseiten zu bearbeiten. Probier es einfach mal aus. Öffne die Datei `content/1-home/page.md`. Es werden Einstellungen und Text der Seite angezeigt. Ganz oben auf der Seite kannst du `Title` und weitere [Einstellungen](markdown-cheat-sheet#einstellungen) ändern. Hier ist ein Beispiel:

    ---
    Title: Home
    ---
    Deine Webseite funktioniert!
    
    [edit - Du kannst diese Seite bearbeiten] oder einen Texteditor benutzen.

Text formatieren:

    Normal **Fettschrift** *Kursiv* `Code`

Eine Liste erstellen:

    * Punkt eins
    * Punkt zwei
    * Punkt drei

[Weiter: Medien hinzufügen →](adding-media)