---
Title: Fichiers CSS
---
Voici comment ajuster l'apparence de votre site web.

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/css-files.md)

## Customising CSS

To adjust the [CSS](https://www.w3schools.com/css/) of your website change the theme. Let's see how themes work. The default theme is defined in the [system settings](adjusting-system#system-settings). A different theme can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Theme: custom`.

Here's an example file `system/resources/custom.css`:

``` css
.page {
    background-color: #fc4;
    color: #fff;
    text-align:center; 
}
```

## Customising resources

The `system/resources` folder contains all resource files. You can store your images and font files here, which are used in themes. Each website has a small icon, sometimes called a favicon. The web browser displays this icon for example in the address bar.

[Suivant: Fichiers JavaScript →](javascript-files)