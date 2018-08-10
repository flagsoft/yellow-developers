---
Title: Themes anpassen
---
Du kannst das Aussehen deiner Webseite anpassen. [Demo anschauen](/de/tests/custom-theme).

## Themes


Themes bestimmen das Aussehen deiner Webseite und es gibt [Themes zum Herunterladen](/de/themes/). Das Standardtheme wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine anderes Theme lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Theme: flatsite`. 

Jede Webseite hat ein kleines Icon, auch Favicon genannt. Der Webbrowser zeigt dieses Icon beispielsweise in der Adresszeile, in Lesezeichen oder auf der Arbeitsfläche an. Um das Standardicon zu ändern überschreibe die Datei `system/themes/assets/icon.png`.

## HTML

Um Themes zu verstehen, ist es gut die [HTML](https://www.w3schools.com/html/)-Struktur einer Seite zu kennen. Es gibt eine Standard-HTML-Struktur die von den meisten Webseiten, Blogs und Wikis benutzt wird. Das ist nur ein Vorschlag damit alles zusammenpasst, du kannst jede Struktur benutzen die du willst.

Hier ist die Standard-HTML-Struktur:

``` html
<!DOCTYPE html>
<html>
  <head>…</head>
  <body>
    <div class="page template-default">
      <div class="header">…</div>
      <div class="content">…</div>
      <div class="footer">…</div>
    </div>
  </body>
</html>
```

Das erste `<div>`-Element hat nützliche Klassen-Information, zum Beispiel `template-default`. Eine Blog-Seite benutzt `template-blog`, eine Wiki-Seite `template-wiki` und eine Sidebar `with-sidebar`. Damit kann man Themes an unterschiedliche [Templates](customising-templates) anpassen.

## CSS

Um Themes anzupassen, kann man [CSS](https://www.w3schools.com/css/) benutzen. Damit kannst du Farben, Schriftart und das Aussehen deiner Webseite anpassen. Am Einfachsten ist es die vorhandenen CSS-Dateien zu ändern. Du kannst auch eine neue Datei anlegen, zum Beispiel `Theme: custom`.

Hier ist eine Beispiel-CSS-Datei `system/themes/assets/custom.css`:

``` css
.page {
    background-color: #fc4;
    color: #fff;
    text-align:center; 
}
```

## JavaScript

Um Themes noch weiter anzupassen, kann man [JavaScript](https://www.w3schools.com/js/) benutzen. Damit kannst du Webseiten mit dynamischen Funktionen erstellen. Du kannst JavaScript in eine Datei speichern die einen ähnlichen Namen hat wie die CSS-Datei. Sie wird dann automatisch eingebunden.

Hier ist eine Beispiel-JS-Datei `system/themes/assets/custom.js`:

``` javascript
var ready = function() {
	console.log("Hello world");
	// Add more JavaScript code here
}
window.addEventListener("load", ready, false);
```

[Weiter: Templates anpassen →](customising-templates)