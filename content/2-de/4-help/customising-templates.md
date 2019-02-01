---
Title: Templates anpassen
---
Du kannst den Quellcode deiner Webseite anpassen. [Demo anschauen](/de/tests/custom-template).

## Templates

Templates erzeugen den Quellcode deiner Webseite. Das Standardtemplate wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine anderes Template lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Template: default`.

## Template anpassen

Um den Quellcode deiner Webseite anzupassen, ändere das Template oder die entsprechenden Snippets. Du kannst auch ein neues Template anlegen, zum Beispiel `Template: custom`.

Hier ist eine Beispiel-Templatedatei `system/themes/templates/custom.html`:

``` html
<?php $yellow->snippet("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<?php echo $yellow->page->getContent() ?>
</div>
</div>
<?php $yellow->snippet("footer") ?>
```

Hier ist ein Beispiel-Template um den Seiteninhalt und zusätzliche Metadaten anzuzeigen:

``` html
<?php $yellow->snippet("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<p><?php echo $yellow->page->getHtml("author") ?></p>
<?php echo $yellow->page->getContent() ?>
</div>
</div>
<?php $yellow->snippet("footer") ?>
```

Hier ist ein Beispiel-Template um die neusten Blogseiten anzuzeigen:

``` html
<?php $yellow->snippet("header") ?>
<?php $pages = $yellow->pages->index()->filter("template", "blog")->sort("published", false)->limit(5) ?>
<?php $yellow->page->setLastModified($pages->getModified()) ?>
<?php $yellow->page->setHeader("Cache-Control", "max-age=60") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<?php echo $yellow->page->getContent() ?>
<table>
<?php foreach ($pages as $page): ?>
<tr>
<td><a href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("title") ?></a></td>
<td><?php echo $page->getHtml("author") ?></td>
<td><?php echo $page->getDateRelativeHtml("published") ?></td>
</tr>
<?php endforeach ?>
</table>
</div>
</div>
<?php $yellow->snippet("footer") ?>
```

## Navigation anpassen

Die Standardnavigation wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine andere Navigation lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Navigation: navigation`. 

Die folgenden Navigationen sind vorhanden:

`Navigation: navigation` zeigt Hauptseiten  
`Navigation: navigation-tree` zeigt alle Seiten  
`Navigation: navigation-sidebar` zeigt Unterseiten  
`Navigation: navigation-search` zeigt Suchzeile vom [Search-Plugin](https://github.com/datenstrom/yellow-plugins/tree/master/search)  

Hier ist eine Beispiel-Snippetdatei `system/themes/snippets/navigation.php`:

``` html
<?php $pages = $yellow->pages->top() ?>
<?php $yellow->page->setLastModified($pages->getModified()) ?>
<div class="navigation" role="navigation">
<ul>
<?php foreach ($pages as $page): ?>
<li><a<?php echo $page->isActive() ? " class=\"active\"" : "" ?> href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("titleNavigation") ?></a></li>
<?php endforeach ?>
</ul>
</div>
<div class="navigation-banner"></div>
```

Hier ist ein Beispiel-Snippet um zusätzliche Links in der Navigation anzuzeigen:

``` html
<?php $pages = $yellow->pages->top() ?>
<?php $yellow->page->setLastModified($pages->getModified()) ?>
<div class="navigation" role="navigation">
<ul>
<?php foreach ($pages as $page): ?>
<li><a<?php echo $page->isActive() ? " class=\"active\"" : "" ?> href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("titleNavigation") ?></a></li>
<?php endforeach ?>
<li><a href="https://twitter.com/datenstromse">Twitter</a></li>
<li><a href="https://github.com/datenstrom">GitHub</a></li>
<li><a href="https://datenstrom.se">Datenstrom</a></li>
</ul>
</div>
<div class="navigation-banner"></div>
```

Hier ist ein Beispiel-Snippet um zusätzliche [Icons und Symbole](https://github.com/datenstrom/yellow-plugins/tree/master/fontawesome) in der Navigation anzuzeigen:

``` html
<?php $pages = $yellow->pages->top() ?>
<?php $yellow->page->setLastModified($pages->getModified()) ?>
<div class="navigation" role="navigation">
<ul>
<?php foreach ($pages as $page): ?>
<li><a<?php echo $page->isActive() ? " class=\"active\"" : "" ?> href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("titleNavigation") ?></a></li>
<?php endforeach ?>
<li><a href="https://twitter.com/datenstromse"><i class="fa fa-twitter fa-lg"></i></a></li>
<li><a href="https://github.com/datenstrom"><i class="fa fa-github fa-lg"></i></a></li>
<li><a href="https://datenstrom.se"><i class="fa fa-heart fa-lg"></i></a></li>
</ul>
</div>
<div class="navigation-banner"></div>
```

[Weiter: Support finden →](support)