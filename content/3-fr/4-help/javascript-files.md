---
Title: Fichiers JavaScript
---
Voici comment ajuster les fonctionnalités dynamiques de votre site web.

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/javascript-files.md)

## Customising JavaScript

To adjust your website even more you can use [JavaScript](https://www.w3schools.com/js/). This allows you to create dynamic features for websites. You can save JavaScript into a file which has a similar name as the CSS file. Then it will be automatically included.

Here's an example file `system/resources/custom.js`:

``` javascript
var ready = function() {
	console.log("Hello world");
	// Add more JavaScript code here
}
window.addEventListener("load", ready, false);
```

[Suivant: Obtenir de l'aide →](support)