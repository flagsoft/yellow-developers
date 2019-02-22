---
Title: HTML-Dateien
---
Wie man das Layout seiner Webseite anpasst.

## HTML anpassen

Um den [HTML](https://www.w3schools.com/html/)-Code deiner Webseite anzupassen, ändere das Layout. Das Standardlayout wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine anderes Layout lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Layout: default`.


Hier ist eine Beispiel-Datei `system/layouts/default.html`:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<?php $this->yellow->layout("sidebar") ?>
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php echo $this->yellow->page->getContent() ?>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Hier ist ein Beispiel-Layout um Seiteninhalt und zusätzlichen HTML-Code anzuzeigen:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<?php $this->yellow->layout("sidebar") ?>
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php echo $this->yellow->page->getContent() ?>
<p>Hello world</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Hier ist ein Beispiel-Layout um Seiteninhalt und zusätzliche Blogseiten anzuzeigen:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<?php $this->yellow->layout("sidebar") ?>
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php echo $this->yellow->page->getContent() ?>
<?php $pages = $this->yellow->content->index()->filter("layout", "blog")->sort("published", false)->limit(5) ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<?php $this->yellow->page->setHeader("Cache-Control", "max-age=60") ?>
<table>
<?php foreach ($pages as $page): ?>
<tr>
<td><a href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("title") ?></a></td>
<td><?php echo $page->getHtml("author") ?></td>
<td><?php echo $page->getDateRelativeHtml("published", "dateFormatMedium") ?></td>
</tr>
<?php endforeach ?>
</table>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Um den HTML-Code an Themen anzupassen, erstelle eine neue Layoutdatei. Du kannst ein Thema an den Dateinamen anhängen. Zum Beispiel wird die Datei `system/layouts/default.html` bei allen Seiten verwendet, die Datei `system/layouts/default-stockholm.html` jedoch nur beim `Theme: Stockholm`. 

## Navigation anpassen

Um die Navigation deiner Webseite anzupassen, ändere das Navigationslayout das verwendet wird. Die Standardnavigation wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine andere Navigation lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Navigation: navigation`. Die folgenden Navigationen sind vorhanden:

`Navigation: navigation` zeigt Hauptseiten  
`Navigation: navigation-tree` zeigt alle Seiten  
`Navigation: navigation-sidebar` zeigt Unterseiten  

Hier ist eine Beispiel-Datei `system/layouts/navigation.html`:

``` html
<?php $pages = $this->yellow->content->top() ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<div class="navigation" role="navigation">
<ul>
<?php foreach ($pages as $page): ?>
<li><a<?php echo $page->isActive() ? " class=\"active\" aria-current=\"page\"" : "" ?> href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("titleNavigation") ?></a></li>
<?php endforeach ?>
</ul>
</div>
<div class="navigation-banner"></div>
```

[Weiter: CSS-Dateien →](css-files)