<div class="content main">
<h1><?php echo $yellow->page->getHtml("titleContent") ?></h1>
<?php echo $yellow->page->getContent() ?>
<?php $pages = $yellow->pages->index()->filter("template", "blog")->sort("published", false)->limit(3) ?>
<?php foreach($pages as $page): ?>
<h2><a href="<?php echo $page->getLocation(true) ?>"><?php echo $page->getHtml("title") ?></a></h1>
<p><?php echo $yellow->toolbox->createTextDescription($page->getContent(), 250) ?></p>
<?php endforeach ?>
<?php $yellow->page->setLastModified($pages->getModified()) ?>
<?php $yellow->page->setHeader("Cache-Control", "max-age=60") ?>
</div>
