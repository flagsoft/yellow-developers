---
Title: Templates anpassen
---
Du kannst den Quellcode deiner Webseite anpassen. [Demo anschauen](/de/tests/custom-template).

## Templates

Templates erzeugen den Quellcode deiner Webseite. Das Standardtemplate wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine anderes Template lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Template: default`.

Snippets sind die Bausteine deiner Webseite. Es sind kleine Stücke [HTML](https://www.w3schools.com/html/) und [PHP](https://www.w3schools.com/php/). Du kannst alles in ein Template schreiben, aber es ist häufig praktischer ein Template in mehrere Snippets aufzuteilen und wiederzubenutzen. Mache was am Besten für dich funktioniert.

## Template anpassen

Das Template legt fest welche Snippets benutzt werden. Um den Quellcode deiner Webseite anzupassen, ändere das Template oder die entsprechenden Snippets. Du kannst auch ein neues Template anlegen, zum Beispiel `Template: custom`.

Hier ist eine Beispiel-Templatedatei `system/themes/templates/custom.html`:

``` html
<?php $yellow->snippet("header") ?>
<?php $yellow->snippet("content-custom") ?>
<?php $yellow->snippet("footer") ?>
```

Hier ist eine Beispiel-Snippetdatei `system/themes/snippets/content-custom.php`:

``` html
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<?php echo $yellow->page->getContent() ?>
</div>
</div>
```

Hier ist ein Beispiel-Snippet um den Seiteninhalt und zusätzliche Metadaten anzuzeigen:

``` html
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<p><?php echo $yellow->page->getHtml("author") ?></p>
<?php echo $yellow->page->getContent() ?>
</div>
</div>
```

Hier ist ein Beispiel-Snippet um die neusten Blogseiten anzuzeigen:

``` html
<?php $pages = $yellow->pages->index()->filter("template", "blog")->sort("published", false)->limit(5) ?>
<?php $yellow->page->setLastModified($pages->getModified()) ?>
<?php $yellow->page->setHeader("Cache-Control", "max-age=60") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<?php echo $yellow->page->getContent() ?>
<table>
<?php foreach($pages as $page): ?>
<tr>
<td><a href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("title") ?></a></td>
<td><?php echo $page->getHtml("author") ?></td>
<td><?php echo $page->getDateRelativeHtml("published") ?></td>
</tr>
<?php endforeach ?>
</table>
</div>
</div>
```

## Navigation anpassen

Oben befindet sich der Header mit der Navigation. Die Standardnavigation wird in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festgelegt. Eine andere Navigation lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Navigation: navigation`. 

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
<?php foreach($pages as $page): ?>
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
<?php foreach($pages as $page): ?>
<li><a<?php echo $page->isActive() ? " class=\"active\"" : "" ?> href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("titleNavigation") ?></a></li>
<?php endforeach ?>
<li><a href="https://twitter.com/datenstromse">Twitter</a></li>
<li><a href="https://github.com/datenstrom">GitHub</a></li>
<li><a href="https://datenstrom.se">Datenstrom</a></li>
</ul>
</div>
<div class="navigation-banner"></div>
```

Hier ist ein Beispiel-Snippet um [Icons und Symbole](https://github.com/datenstrom/yellow-plugins/tree/master/fontawesome) in der Navigation anzuzeigen:

``` html
<?php $pages = $yellow->pages->top() ?>
<?php $yellow->page->setLastModified($pages->getModified()) ?>
<div class="navigation" role="navigation">
<ul>
<?php foreach($pages as $page): ?>
<li><a<?php echo $page->isActive() ? " class=\"active\"" : "" ?> href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("titleNavigation") ?></a></li>
<?php endforeach ?>
<li><a href="https://twitter.com/datenstromse"><i class="fa fa-twitter fa-lg"></i></a></li>
<li><a href="https://github.com/datenstrom"><i class="fa fa-github fa-lg"></i></a></li>
<li><a href="https://datenstrom.se"><i class="fa fa-heart fa-lg"></i></a></li>
</ul>
</div>
<div class="navigation-banner"></div>
```

## Fußzeile anpassen

Unten befindet sich die Fußzeile. Um die Fußzeile anzupassen, ändere das entsprechende Snippet. Das Template legt fest welche Snippets benutzt werden. Du kannst entweder das vorhandene Snippet ändern oder ein neues Snippet anlegen.

Hier ist eine Beispiel-Snippetdatei `system/themes/snippets/footer.php`:

``` html
<div class="footer" role="contentinfo">
<div class="siteinfo">
<a href="<?php echo $yellow->page->base."/" ?>">&copy; 2019 <?php echo $yellow->page->getHtml("sitename") ?></a>.
<a href="<?php echo $yellow->text->get("yellowUrl") ?>">Erstellt mit Datenstrom Yellow</a>.
</div>
</div>
</div>
<?php echo $yellow->page->getExtra("footer") ?>
</body>
</html>
```

Hier ist ein Beispiel-Snippet um zusätzliche Links in der Fußzeile anzuzeigen:

``` html
<div class="footer" role="contentinfo">
<div class="siteinfo">
<a href="<?php echo $yellow->page->base."/" ?>">&copy; 2019 <?php echo $yellow->page->getHtml("sitename") ?></a>.
<a href="<?php echo $yellow->page->base."/sitemap/" ?>">Sitemap</a>.
<a href="<?php echo $yellow->page->base."/feed/page:feed.xml" ?>">Feed</a>.
<a href="<?php echo $yellow->page->get("pageEdit") ?>">Bearbeiten</a>.
<a href="<?php echo $yellow->text->get("yellowUrl") ?>">Erstellt mit Datenstrom Yellow</a>.
</div>
</div>
</div>
<?php echo $yellow->page->getExtra("footer") ?>
</body>
</html>
```

Hier ist ein Beispiel-Snippet um die Fußzeile in Links und Rechts aufzuteilen:

``` html
<div class="footer" role="contentinfo">
<div class="siteinfo">
<div class="siteinfo-left">
<a href="<?php echo $yellow->page->base."/" ?>">&copy; 2019 <?php echo $yellow->page->getHtml("sitename") ?></a>.
</div>
<div class="siteinfo-right">
<a href="<?php echo $yellow->text->get("yellowUrl") ?>">Erstellt mit Datenstrom Yellow</a>.
</div>
<div class="siteinfo-banner"></div>
</div>
</div>
</div>
<?php echo $yellow->page->getExtra("footer") ?>
</body>
</html>
```

## Sidebar anpassen

Um eine Sidebar anzuzeigen, erstelle die Datei `sidebar.md` in einem `content`-Verzeichnis. Die Sidebar wird auf allen Seiten im gleichen Verzeichnis angezeigt. Eine andere Sidebar lässt sich in den [Einstellungen](markdown-cheat-sheet#einstellungen) ganz oben auf jeder Seite festlegen, zum Beispiel `Sidebar: sidebar`. 

Hier ist eine Beispiel-Sidebar-Datei `content/1-home/sidebar.md`:

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

[Weiter: Support finden →](support)