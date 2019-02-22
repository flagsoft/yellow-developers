---
Title: Spracheinstellungen
---
Wie man Sprachen konfiguriert.

## Einsprachen-Modus

Die Installation kommt mit drei Sprachen und man kann [weitere Sprachen herunterladen](https://github.com/datenstrom/yellow-extensions/tree/master/languages). Die Standardsprache wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine andere Sprache lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Language: de`. 

Hier ist eine Englische Seite:

```
---
Title: About us
Language: en
---
Birds of a feather flock together.
```

Eine Deutsche Seite:

```
---
Title: Über uns
Language: de
---
Wo zusammenwächst, was zusammen gehört.
```

Eine Französische Seite:

```
---
Title: À propos de nous
Language: fr
---
Les oiseaux de même plumage volent toujours ensemble.
```

## Mehrsprachen-Modus

Für mehrsprachige Webseiten kann man den Mehrsprachen-Modus benutzen. Öffne die Datei `system/settings/system.ini` und ändere `MultiLanguageMode: 1`. Gehe ins `content`-Verzeichnis und erstelle für jede Sprache ein eigenes Verzeichnis. Hier ist ein Beispiel:

[image screenshot-language1.png Screenshot]

Der erste Screenshot zeigt die Verzeichnisse `1-en`, `2-de` und `3-fr`. Das erzeugt die URLs `http://website/` `http://website/de/` `http://website/fr/` für Englisch, Deutsch und Französisch. Hier ist noch ein Beispiel:

[image screenshot-language2.png Screenshot]

Der zweite Screenshot zeigt die Verzeichnisse `1-en`, `2-de`, `3-fr` und `default`. Das erzeugt die URLs `http://website/en/` `http://website/de/` `http://website/fr/` und die Startseite `http://website/` welche automatisch die Sprache der Besucher ermittelt. 

Um eine [Sprachauswahl](/language/) anzuzeigen, kannst du eine Seite erstellen welche die vorhandenen Sprachen auflistet. Das ermöglicht es Besuchern ihre Sprache auszuwählen. Die Sprachauswahl kann man in die Webseite einbauen, beispielsweise in der Navigation oder Fußzeile.

[Weiter: Sicherheitseinstellungen →](security-configuration)