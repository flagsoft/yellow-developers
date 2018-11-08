---
Title: Personnaliser des thèmes
---
Vous pouvez personnaliser l'apparence de votre site web. [Voir la démo](/fr/tests/custom-theme).

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/customising-themes.md)

## Thèmes

Les thèmes définissent l'apparence de votre site web et il existe [thèmes à télécharger](/fr/themes/). Le thème par défaut est défini dans les [paramètres du système](adjusting-system#paramètres-du-système). Une autre thème peut-être définie pour chacune de vos pages dans les [paramètres](markdown-cheat-sheet#paramètres) en haut de celle-ci, par exemple `Theme: flatsite`.

Every website has a small icon, sometimes called favicon. The web browser displays this icon for example in address bar, in bookmarks or on the desktop. To change the default icon overwrite file `system/themes/assets/icon.png`.

## HTML

To understand themes it's good to know the [HTML](https://www.w3schools.com/html/) layout of a page. There's a default HTML layout that's used by most web pages, blogs and wikis. This is just a suggestion so that everything fits together, you can use any layout you like.

Here's the default HTML layout:

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

The first `<div>` element contains useful class information, for example `template-default`. A blog page uses `template-blog`, a wiki page `template-wiki` and a sidebar `with-sidebar`. This allows you to adjust themes to different [templates](customising-templates).

## CSS

To adjust themes you can use [CSS](https://www.w3schools.com/css/). This allows you to change colors, font and the appearance of your website. The easiest way is to change the available CSS files. You can also create a new file, for example `Theme: custom`.
 
Here's an example CSS file `system/themes/assets/custom.css`:

``` css
.page {
    background-color: #fc4;
    color: #fff;
    text-align:center; 
}
```

## JavaScript

To adjust themes even more you can use [JavaScript](https://www.w3schools.com/js/). This allows you to create websites with dynamic features. You can save JavaScript into a file which has a similar name as the CSS file. Then it will be automatically included.

Here's an example JS file `system/themes/assets/custom.js`:

``` javascript
var ready = function() {
	console.log("Hello world");
	// Add more JavaScript code here
}
window.addEventListener("load", ready, false);
```

[Suivant: Personnaliser des templates →](customising-templates)