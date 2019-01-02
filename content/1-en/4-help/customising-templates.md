---
Title: Customising templates
---
You can customise the source code of your website. [See demo](/tests/custom-template).

## Templates

Templates generate the source code of your website. Let's see how templates are made. The default template is defined in the [system settings](adjusting-system#system-settings). A different template can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Template: default`.

Snippets are the building blocks of your website. They are small pieces of [HTML](https://www.w3schools.com/html/) and [PHP](https://www.w3schools.com/php/). You can put everything into one template, but it's often more practical to split up a template into multiple snippets and to reuse them. Do what works best for you. 

## Custom template

The template defines which snippets will be used. To adjust the source code of your website change the template or the corresponding snippets. You can also create a new template, for example `Template: custom`.

Here's an example template file `system/themes/templates/custom.html`:

``` html
<?php $yellow->snippet("header") ?>
<?php $yellow->snippet("content-custom") ?>
<?php $yellow->snippet("footer") ?>
```

Here's an example snippet file `system/themes/snippets/content-custom.php`:

``` html
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<?php echo $yellow->page->getContent() ?>
</div>
</div>
```

Here's an example snippet for showing page content with additional meta data:

``` html
<div class="content">
<div class="main" role="main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<p><?php echo $yellow->page->getHtml("author") ?></p>
<?php echo $yellow->page->getContent() ?>
</div>
</div>
```

Here's an example snippet for showing latest blog pages:

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

## Custom navigation

At the top is the header with the navigation. There's a default navigation defined in the [system settings](adjusting-system#system-settings). A different navigation can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Navigation: navigation`.

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
<?php foreach($pages as $page): ?>
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

Here's an example snippet to show [icons and symbols](https://github.com/datenstrom/yellow-plugins/tree/master/fontawesome) in the navigation:

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

## Custom footer

At the bottom is the footer. To adjust the footer change the corresponding snippet. The template defines which snippets will be used. You can either change the available snippet or create a new snippet.

Here's an example snippet file `system/themes/snippets/footer.php`:

``` html
<div class="footer" role="contentinfo">
<div class="siteinfo">
<a href="<?php echo $yellow->page->base."/" ?>">&copy; 2019 <?php echo $yellow->page->getHtml("sitename") ?></a>.
<a href="<?php echo $yellow->text->get("yellowUrl") ?>">Made with Datenstrom Yellow</a>.
</div>
</div>
</div>
<?php echo $yellow->page->getExtra("footer") ?>
</body>
</html>
```

Here's an example snippet to show additional links in the footer:

``` html
<div class="footer" role="contentinfo">
<div class="siteinfo">
<a href="<?php echo $yellow->page->base."/" ?>">&copy; 2019 <?php echo $yellow->page->getHtml("sitename") ?></a>.
<a href="<?php echo $yellow->page->base."/sitemap/" ?>">Sitemap</a>.
<a href="<?php echo $yellow->page->base."/feed/page:feed.xml" ?>">Feed</a>.
<a href="<?php echo $yellow->page->get("pageEdit") ?>">Edit</a>.
<a href="<?php echo $yellow->text->get("yellowUrl") ?>">Made with Datenstrom Yellow</a>.
</div>
</div>
</div>
<?php echo $yellow->page->getExtra("footer") ?>
</body>
</html>
```

Here's an example snippet to divide the footer into left and right:

``` html
<div class="footer" role="contentinfo">
<div class="siteinfo">
<div class="siteinfo-left">
<a href="<?php echo $yellow->page->base."/" ?>">&copy; 2019 <?php echo $yellow->page->getHtml("sitename") ?></a>.
</div>
<div class="siteinfo-right">
<a href="<?php echo $yellow->text->get("yellowUrl") ?>">Made with Datenstrom Yellow</a>.
</div>
<div class="siteinfo-banner"></div>
</div>
</div>
</div>
<?php echo $yellow->page->getExtra("footer") ?>
</body>
</html>
```

## Custom sidebar

To show a sidebar add the file `sidebar.md` to a `content` folder. The sidebar will be shown on all pages in the same folder. A different sidebar can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Sidebar: sidebar`.

Here's an example sidebar file `content/1-home/sidebar.md`:

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

[Next: Get support →](support)
