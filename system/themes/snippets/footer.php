<div class="footer" role="contentinfo">
<div class="siteinfo">
<div class="siteinfo-left">
<?php if ($yellow->page->isPage("footer")) echo $yellow->page->getPage("footer")->getContent() ?>
</div>
<div class="siteinfo-right">
<p><a href="<?php echo $yellow->page->getBase(true)."/help/support" ?>">Support</a> &nbsp; <a class="language" href="<?php echo $yellow->page->getBase()."/language/" ?>"><img src="<?php echo "/media/images/language-".$yellow->text->language.".png"?>" width="20" height="20" alt="<?php echo $yellow->text->getHtml("languageDescription") ?>" title="<?php echo $yellow->text->getHtml("languageDescription") ?>"><?php echo $yellow->text->getHtml("languageDescription") ?></a></p>
</div>
<div class="siteinfo-banner"></div>
</div>
</div>
</div>
<?php echo $yellow->page->getExtra("footer") ?>
</body>
</html>
