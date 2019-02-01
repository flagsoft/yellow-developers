---
Title: Personnaliser des templates
---
Vous pouvez personnaliser le code source de votre site web. [Voir la démo](/fr/tests/custom-template).

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/customising-templates.md)

Templates generate the source code of your website. Let's see how templates are made. The default template is defined in the [system settings](adjusting-system#system-settings). A different template can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Template: default`.

## Custom template

To adjust the source code of your website change the template or the corresponding snippets. You can also create a new template, for example `Template: custom`.

Here's an example template file `system/themes/templates/custom.html`:

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

Here's an example template for showing page content with additional meta data:

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

Here's an example template for showing latest blog pages:

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

## Custom navigation

There's a default navigation defined in the [system settings](adjusting-system#system-settings). A different navigation can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Navigation: navigation`.

The following navigations are available:

`Navigation: navigation` shows top level pages  
`Navigation: navigation-tree` shows all pages  
`Navigation: navigation-sidebar` shows sub level pages  
`Navigation: navigation-search` shows search bar from the [search plugin](https://github.com/datenstrom/yellow-plugins/tree/master/search)  

Here's an example snippet file `system/themes/snippets/navigation.php`:

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

Here's an example snippet to show additional links in the navigation:

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

Here's an example snippet to show additional [icons and symbols](https://github.com/datenstrom/yellow-plugins/tree/master/fontawesome) in the navigation:

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

[Suivant: Obtenir de l'aide →](support)