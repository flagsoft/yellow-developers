---
Title: Fichiers HTML
---
Voici comment ajuster la mise en page de votre site web.

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/html-files.md)

## Customising HTML

To adjust the [HTML](https://www.w3schools.com/html/) code of your website change the layout. Let's see how layouts are made. The default layout is defined in the [system settings](adjusting-system#system-settings). A different layout can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Layout: default`.

Here's an example file `system/layouts/default.html`:

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

Here's an example layout for showing page content and additional HTML code:

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

Here's an example layout for showing page content and additional blog pages:

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

To adjust the HTML code to themes create a new layout file. You can add a theme to the file name. For example the file `system/layouts/default.html` will be used with any page, the file `system/layouts/default-stockholm.html` will only be used with `Theme: Stockholm`.

## Customising navigation

To adjust the navigation of your website change the navigation layout. The default navigation is defined in the [system settings](adjusting-system#system-settings). A different navigation can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Navigation: navigation`. The following navigations are available:

`Navigation: navigation` shows top level pages  
`Navigation: navigation-tree` shows all pages  
`Navigation: navigation-sidebar` shows sub level pages  

Here's an example file `system/layouts/navigation.html`:

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

[Suivant: Fichiers CSS →](css-files)