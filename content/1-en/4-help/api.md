---
Title: API
---
API for developers. We :heart: developers.

[toc]

## Developer kit

[Install the developer kit](https://github.com/datenstrom/yellow-developers). The developer kit for Datenstrom Yellow includes [examples](/search/query:example/) and [tests](/tests/). You can try out how to make small web pages, blogs and wikis. You can learn how to customise your website. It's a great place to get started.

When there are problems, please check the [server configuration](server-configuration) or ask the [support](support).

## Folder structure

The following folders are available:

```
├── content               = content files
├── media                 = media files
│   ├── downloads         = files to download
│   ├── images            = image files for the content
│   └── thumbnails        = image thumbnails
└── system                = system files
    ├── extensions        = installed extensions
    ├── layouts           = layout files, HTML files
    ├── resources         = resource files, CSS files etc.
    ├── settings          = configuration files, INI files
    └── trash             = deleted files
```

## Objects

The following objects are available:

`$this->yellow->page` = [access to current page](#yellow-page)  
`$this->yellow->content` = [access to content files from file system](#yellow-content)  
`$this->yellow->media` = [access to media files from file system](#yellow-media)  
`$this->yellow->system` = [access to system settings](#yellow-system)  
`$this->yellow->text` = [access to text settings](#yellow-text)  
`$this->yellow->toolbox` = [access to toolbox with helpers](#yellow-toolbox)  
`$this->yellow->extensions` = [access to features and themes](#yellow-extensions) 

### Yellow page

Yellow page gives access to current page:

**$this->yellow->page->get($key)**  
Return page [setting](markdown-cheat-sheet#settings) 

**$this->yellow->page->getHtml($key)**  
Return page [setting](markdown-cheat-sheet#settings), HTML encoded  

**$this->yellow->page->getDate($key, $format = "")**  
Return page [setting](markdown-cheat-sheet#settings) as [language specific date format](adjusting-system#text-settings)  

**$this->yellow->page->getDateHtml($key, $format = "")**  
Return page [setting](markdown-cheat-sheet#settings) as [language specific date format](adjusting-system#text-settings), HTML encoded  

**$this->yellow->page->getDateRelative($key, $format = "", $daysLimit = 0)**  
Return page [setting](markdown-cheat-sheet#settings) as [language specific date format](adjusting-system#text-settings), relative to today

**$this->yellow->page->getDateRelativeHtml($key, $format = "", $daysLimit = 0)**  
Return page [setting](markdown-cheat-sheet#settings) as [language specific date format](adjusting-system#text-settings), relative to today, HTML encoded

**$this->yellow->page->getDateFormatted($key, $format)**  
Return page [setting](markdown-cheat-sheet#settings) with [custom date format](http://php.net/manual/en/function.date.php)  

**$this->yellow->page->getDateFormattedHtml($key, $format)**  
Return page [setting](markdown-cheat-sheet#settings) with [custom date format](http://php.net/manual/en/function.date.php), HTML encoded  

**$this->yellow->page->getContent($rawFormat = false, $sizeMax = 0)**  
Return page content, HTML encoded or raw format

**$this->yellow->page->getParent()**  
Return parent page, null if none

**$this->yellow->page->getParentTop($homeFallback = false)**  
Return top-level parent page, null if none

**$this->yellow->page->getSiblings($showInvisible = false)**  
Return [page collection](#yellow-page-collection) with pages on the same level

**$this->yellow->page->getChildren($showInvisible = false)**  
Return [page collection](#yellow-page-collection) with child pages

**$this->yellow->page->getPages()**  
Return [page collection](#yellow-page-collection) with additional pages

**$this->yellow->page->getPage($key)**  
Return related page

**$this->yellow->page->getBase($multiLanguage = false)**  
Return page base

**$this->yellow->page->getLocation($absoluteLocation = false)**  
Return page location

**$this->yellow->page->getUrl()**  
Return page URL

**$this->yellow->page->getExtra($name)**  
Return page extra data

**$this->yellow->page->getHeader($key)**  
Return page response header

**$this->yellow->page->getModified($httpFormat = false)**  
Return page modification date, Unix time or HTTP format

**$this->yellow->page->getLastModified($httpFormat = false)**  
Return last modification date, Unix time or HTTP format

**$this->yellow->page->getStatusCode($httpFormat = false)**  
Return page status code, number or HTTP format

**$this->yellow->page->error($statusCode, $pageError = "")**  
Respond with error page

**$this->yellow->page->clean($statusCode, location = "")**  
Respond with status code, no page content

**$this->yellow->page->isAvailable()**  
Check if page is available

**$this->yellow->page->isVisible()**  
Check if page is visible

**$this->yellow->page->isActive()**  
Check if page is within current HTTP request

**$this->yellow->page->isCacheable()**  
Check if page is cacheable

**$this->yellow->page->isError()**  
Check if page with error

**$this->yellow->page->isHeader($key)**  
Check if response header exists

**$this->yellow->page->isExisting($key)**  
Check if page [setting](markdown-cheat-sheet#settings) exists  

**$this->yellow->page->isPage($key)**  
Check if related page exists  

Here's an example layout for showing page content:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php echo $this->yellow->page->getContent() ?>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing page content with additional setting:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p><?php echo $this->yellow->page->getHtml("author") ?></p>
<?php echo $this->yellow->page->getContent() ?>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```


Here's an example layout for showing page content with additional date:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p><?php echo $this->yellow->page->getDateHtml("modified", "dateFormatMedium") ?></p>
<?php echo $this->yellow->page->getContent() ?>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow page collection

Yellow page collection gives access to multiple pages:

**$pages->filter($key, $value, $exactMatch = true)**  
Filter page collection by [setting](markdown-cheat-sheet#settings)   

**$pages->match($regex = "/.*/")**  
Filter page collection by file name

**$pages->sort($key, $ascendingOrder = true)**  
Sort page collection by [setting](markdown-cheat-sheet#settings)   

**$pages->similar($page, $ascendingOrder = false)**  
Sort page collection by [settings similarity](markdown-cheat-sheet#settings)

**$pages->merge($input)**  
Merge page collection

**$pages->append($page)**  
Append to end of page collection

**$pages->prepend($page)**  
Prepend to start of page collection

**$pages->limit($pagesMax)**  
Limit the number of pages in page collection

**$pages->reverse()**  
Reverse page collection

**$pages->shuffle()**  
Randomize page collection

**$pages->pagination($limit, $reverse = true)**  
Paginate page collection

**$pages->getPaginationNumber()**  
Return current page number in pagination

**$pages->getPaginationCount()**  
Return highest page number in pagination

**$pages->getPaginationLocation($absoluteLocation = true, $pageNumber = 1)**  
Return location for a page in pagination

**$pages->getPaginationPrevious($absoluteLocation = true)**  
Return location for previous page in pagination

**$pages->getPaginationNext($absoluteLocation = true)**  
Return location for next page in pagination

**$pages->getPagePrevious($page)**  
Return previous page in collection, null if none

**$pages->getPageNext($page)**  
Return next page in collection, null if none

**$pages->getFilter()**  
Return current page filter

**$pages->getModified($httpFormat = false)**  
Return page collection modification date, Unix time or HTTP format

**$pages->isPagination()**  
Check if there is a pagination

Here's an example layout for showing three random pages:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $pages = $this->yellow->content->index()->shuffle()->limit(3) ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<ul>
<?php foreach ($pages as $page): ?>
<li><?php echo $page->getHtml("title") ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing latest pages:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $pages = $this->yellow->content->index()->sort("modified", false) ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<ul>
<?php foreach ($pages as $page): ?>
<li><?php echo $page->getHtml("title") ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing draft pages:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $pages = $this->yellow->content->index(true, true)->filter("status", "draft") ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<ul>
<?php foreach ($pages as $page): ?>
<li><?php echo $page->getHtml("title") ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow content

Yellow content gives access to [content files](adding-content) from file system:

**$this->yellow->content->find($location, $absoluteLocation = false)**  
Return [page](#yellow-page) from file system, null if not found

**$this->yellow->content->index($showInvisible = false, $multiLanguage = false, $levelMax = 0)**  
Return [page collection](#yellow-page-collection) with all pages

**$this->yellow->content->top($showInvisible = false)**  
Return [page collection](#yellow-page-collection) with top-level navigation

**$this->yellow->content->path($location, $absoluteLocation = false)**  
Return [page collection](#yellow-page-collection) with path ancestry

**$this->yellow->content->shared($location, $absoluteLocation = false, $name = "shared")**  
Return [page](#yellow-page) with shared content, null if not found  

**$this->yellow->content->multi($location, $absoluteLocation = false, $showInvisible = false)**  
Return [page collection](#yellow-page-collection) with multiple languages in [multi language mode](language-configuration#multi-language-mode)

**$this->yellow->content->clean()**  
Return [page collection](#yellow-page-collection) that is empty

Here's an example layout for showing all pages:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $pages = $this->yellow->content->index(true, true) ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<ul>
<?php foreach ($pages as $page): ?>
<li><?php echo $page->getHtml("title") ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing pages below a specific location:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $pages = $this->yellow->content->find("/help/")->getChildren(true) ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<ul>
<?php foreach ($pages as $page): ?>
<li><?php echo $page->getHtml("title") ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing top-level navigation pages:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $pages = $this->yellow->content->top() ?>
<?php $this->yellow->page->setLastModified($pages->getModified()) ?>
<ul>
<?php foreach ($pages as $page): ?>
<li><?php echo $page->getHtml("titleNavigation") ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow media

Yellow media gives access to [media files](adding-media) from file system:

**$this->yellow->media->find($location, $absoluteLocation = false)**  
Return [page](#yellow-page) with media file information, null if not found

**$this->yellow->media->index($showInvisible = false, $multiPass = false, $levelMax = 0)**  
Return [page collection](#yellow-page-collection) with all media files

**$this->yellow->media->clean()**  
Return [page collection](#yellow-page-collection) that is empty

Here's an example layout for showing all media files:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $files = $this->yellow->media->index(true) ?>
<?php $this->yellow->page->setLastModified($files->getModified()) ?>
<ul>
<?php foreach ($files as $file): ?>
<li><?php echo $file->getLocation(true) ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing latest media files:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $files = $this->yellow->media->index(true)->sort("modified", false) ?>
<?php $this->yellow->page->setLastModified($files->getModified()) ?>
<ul>
<?php foreach ($files as $file): ?>
<li><?php echo $file->getLocation(true) ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing media files of a specific type:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $files = $this->yellow->media->index(true)->filter("type", "pdf") ?>
<?php $this->yellow->page->setLastModified($files->getModified()) ?>
<ul>
<?php foreach ($files as $file): ?>
<li><?php echo $file->getLocation(true) ?></li>
<?php endforeach ?>
</ul>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow system

Yellow system gives access to [system settings](adjusting-system#system-settings):

**$this->yellow->system->get($key)**  
Return system setting

**$this->yellow->system->getHtml($key)**  
Return system setting, HTML encoded

**$this->yellow->system->getData($filterStart = "", $filterEnd = "")**  
Return system settings

**$this->yellow->system->getModified($httpFormat = false)**  
Return system settings modification date, Unix time or HTTP format

**$this->yellow->system->isExisting($key)**  
Check if system setting exists

Here's an example layout for showing static website settings:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php foreach ($this->yellow->system->getData("static") as $key=>$value): ?>
<?php echo htmlspecialchars("$key: $value") ?><br />
<?php endforeach ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing webmaster settings:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php echo "Author: ".$this->yellow->system->getHtml("author")."<br />" ?>
<?php echo "Email: ".$this->yellow->system->getHtml("email")."<br />" ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing if safe mode is activated:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php $safeMode = $this->yellow->system->get("safeMode") ?>
Safe mode is <?php echo htmlspecialchars($safeMode ? "on" : "off") ?>.
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow text

Yellow text gives access to [text settings](adjusting-system#text-settings):

**$this->yellow->text->get($key)**  
Return text setting

**$this->yellow->text->getHtml($key)**  
Return text setting, HTML encoded

**$this->yellow->text->getText($key, $language )**  
Return text setting for specific language

**$this->yellow->text->getTextHtml($key, $language )**  
Return text setting for specific language, HTML encoded

**$this->yellow->text->getData($filterStart = "", $language = "")**  
Return text settings

**$this->yellow->text->getLanguages()**  
Return languages

**$this->yellow->text->getModified($httpFormat = false)**  
Return text settings modification date, Unix time or HTTP format

**$this->yellow->text->isLanguage($language)**  
Check if language exists

**$this->yellow->text->isExisting($key, $language = "")**  
Check if text setting exists

Here's an example layout for showing error messages:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php foreach ($this->yellow->text->getData("error") as $key=>$value): ?>
<?php echo htmlspecialchars("$key: $value") ?><br />
<?php endforeach ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing languages and translators:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php foreach ($this->yellow->text->getLanguages() as $language): ?>
<?php echo $this->yellow->text->getTextHtml("languageDescription", $language) ?> - 
<?php echo $this->yellow->text->getTextHtml("languageTranslator", $language) ?><br />
<?php endforeach ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for checking if a specific language exists:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<?php $swedish = $this->yellow->text->isLanguage("sv") ?>
<p>Swedish language <?php echo htmlspecialchars($swedish ? "" : "not") ?> installed.</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow text encoding

The following functions are available to encode text:

`htmlspecialchars($string)` = encode text string into HTML format  
`rawurlencode($string)` = encode URL, e.g. hyperlink arguments  
`strencode($string)` = encode string, e.g. JavaScript arguments  

Here's an example layout for encoding HTML arguments:

``` html
<?php list($name, $class) = $this->yellow->getLayoutArgs() ?>
<?php if (empty($class)) $class = "regular" ?>
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p><img src="https://unsplash.it/210/140/?random" class="<?php echo htmlspecialchars($class) ?>" /></p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for encoding hyperlink arguments:

``` html
<?php list($name, $id) = $this->yellow->getLayoutArgs() ?>
<?php if (empty($id)) $id = "821" ?>
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p><img src="https://unsplash.it/210/140/?image=<?php echo rawurlencode($id) ?>" /></p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for encoding JavaScript arguments:

``` html
<?php list($name, $message) = $this->yellow->getLayoutArgs() ?>
<?php if (empty($message)) $message = "Hello world" ?>
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<script type="text/javascript">
console.log("<?php echo strencode($message) ?>");
</script>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow toolbox

Yellow toolbox gives access to toolbox with helpers:

**$this->yellow->toolbox->getLocation($filterStrict = true)**  
Return location from current HTTP request

**$this->yellow->toolbox->getLocationArgs()**  
Return location arguments from current HTTP request

**$this->yellow->toolbox->isLocationArgs($location = "")**  
Check if there are location arguments in current HTTP request

**$this->yellow->toolbox->normaliseArgs($text, $appendSlash = true, $filterStrict = true)**  
Normalise location arguments

**$this->yellow->toolbox->getDirectoryEntries($path, $regex = "/.*/", $sort = true, $directories = true, $includePath = true)**  
Return files and directories

**$this->yellow->toolbox->readFile($fileName, $sizeMax = 0)**  
Read file, empty string if not found  

**$this->yellow->toolbox->createFile($fileName, $fileData, $mkdir = false)**  
Create file  

**$this->yellow->toolbox->copyFile($fileNameSource, $fileNameDestination, $mkdir = false)**  
Copy file  

**$this->yellow->toolbox->renameFile($fileNameSource, $fileNameDestination, $mkdir = false)**  
Rename file  

**$this->yellow->toolbox->renameDirectory($pathSource, $pathDestination, $mkdir = false)**  
Rename directory  

**$this->yellow->toolbox->deleteFile($fileName, $pathTrash = "")**  
Delete file  

**$this->yellow->toolbox->deleteDirectory($path, $pathTrash = "")**  
Delete directory  

**$this->yellow->toolbox->modifyFile($fileName, $modified)**  
Set file modification date, Unix time  

**$this->yellow->toolbox->getFileModified($fileName)**  
Return file modification date, Unix time  

**$this->yellow->toolbox->getTextLines($text)**  
Return lines from text string, including newline  

**$this->yellow->toolbox->getTextArgs($text, $optional = "-")**  
Return arguments from text string, space separated  

Here's an example layout for showing location and arguments:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php echo htmlspecialchars($this->yellow->toolbox->getLocation()) ?><br />
<?php foreach ($_REQUEST as $key=>$value): ?>
<?php echo htmlspecialchars("$key: $value") ?><br />
<?php endforeach ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for showing files in a directory:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php $path = $this->yellow->system->get("settingDir") ?>
<?php foreach ($this->yellow->toolbox->getDirectoryEntries($path, "/.*/", true, false) as $entry): ?>
<?php echo htmlspecialchars($entry) ?><br />
<?php endforeach ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example layout for reading text lines from file:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php $fileName = $this->yellow->system->get("settingDir").$this->yellow->system->get("systemFile") ?>
<?php $fileData = $this->yellow->toolbox->readFile($fileName) ?>
<?php foreach ($this->yellow->toolbox->getTextLines($fileData) as $line): ?>
<?php echo htmlspecialchars($line) ?><br />
<?php endforeach ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

### Yellow extensions

Yellow extensions gives access to [features](/features/) and [themes](/themes/):

**$this->yellow->extensions->get($name)**  
Return extension

**$this->yellow->extensions->getData($type = "")**  
Return extensions version

**$this->yellow->extensions->getModified($httpFormat = false)**  
Return extensions modification date, Unix time or HTTP format

**$this->yellow->extensions->isExisting($name)**  
Check if extension exists

Here's an example layout for showing information about extensions:

``` html
<?php $this->yellow->layout("header") ?>
<div class="content">
<div class="main" role="main">
<h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
<p>
<?php foreach($this->yellow->extensions->getData() as $key=>$value): ?>
<?php echo htmlspecialchars("$key $value") ?><br />
<?php endforeach ?>
</p>
</div>
</div>
<?php $this->yellow->layout("footer") ?>
```

Here's an example extension for creating own features:

``` php
<?php
class YellowExample {
    const VERSION = "0.1.0";
    const TYPE = "feature";
}
```

Here's an example extension for creating own themes:

``` php
<?php
class YellowExample {
    const VERSION = "0.1.0";
    const TYPE = "theme";
}
```

## Events

The following events are available in extensions:

```
onLoad ─────▶ onStartup ─────▶ onRequest
                  │                │
                  │                ├──────────────────────┐
                  │                │                      │
                  ▼                ▼                      ▼
              onCommand        onParseMeta             onEditUserRestrictions
              onCommandHelp    onParseContentRaw       onEditUserAccount
                  │            onParseContentShortcut  onEditContentFile
                  │            onParseContentText      onEditMediaFile
                  │            onParsePageLayout          │
                  │            onParsePageExtra           │
                  │            onParsePageOutput          │
                  ▼                │                      │
exit ◀─────── onShutDown ◀─────────┴──────────────────────┘
```

When a page is displayed, the extensions are loaded and `onLoad` will be called. As soon as all extensions are loaded `onStartup` will be called. After that the core informs with `onRequest` that there's a request. The page can be analysed with various `onParse` events. Then the page content will be generated. If an error occurs, an error page will be generated. Finally the page is output and `onShutdown` will be called.

When a command is executed, the extensions are loaded and `onLoad` will be called. As soon as all extensions are loaded `onStartup` will be called. After that the core informs with `onCommand` that there's a command, which will be handled by the corresponding extension. If no command has been entered at the [command line](https://github.com/datenstrom/yellow-extensions/tree/master/features/command), then `onCommandHelp` will be called and extensions can provide a help. Finally a return code is output and `onShutdown` will be called.

When a page is edited, the extensions are loaded and `onLoad` will be called. As soon as all extensions are loaded `onStartup` will be called. After that the core informs with `onRequest` that there's a request, which will be handled by the [edit extension](https://github.com/datenstrom/yellow-extensions/tree/master/features/edit). Changes at the page can be analysed with various `onEdit` events. Then the page will be saved in the file system. Finally a status code is output to reload the page and `onShutdown` will be called.

### Yellow core events

Yellow core events notify when a state has changed.

**public function onLoad($yellow)**  
Handle initialisation

**public function onStartup($update)**  
Handle startup

**public function onRequest($scheme, $address, $base, $location, $fileName)**  
Handle request

**public function onParseMeta($page)**  
Handle page [meta data](markdown-cheat-sheet#settings)

**public function onParseContentRaw($page, $text)**  
Handle page content in raw format

**public function onParseContentShortcut($page, $name, $text, $type)**  
Handle page content of [shortcut](markdown-cheat-sheet#shortcuts)

**public function onParseContentText($page, $text)**  
Handle page content

**public function onParsePageLayout($page, $name)**  
Handle page [layout](html-files)

**public function onParsePageExtra($page, $name)**  
Handle page extra data

**public function onParsePageOutput($page, $text)**  
Handle page output data

**public function onShutdown()**  
Handle shutdown

Here's an example extension for handling an `[example]` shortcut:

``` php
<?php
class YellowExample {
    const VERSION = "0.1.1";
    const TYPE = "feature";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    
    // Handle page content of shortcut
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if ($name=="example" && ($type=="block" || $type=="inline")) {
            $output = "<div class=\"".htmlspecialchars($name)."\">";
            $output .= "Add more HTML code here";
            $output .= "</div>";
        }
        return $output;
    }
}
```

### Yellow command events

Yellow command events notify when a command is executed.

**public function onCommand($args)**  
Handle command

**public function onCommandHelp()**  
Handle command help

Here's an example extension for handling a command:

``` php
<?php
class YellowExample {
    const VERSION = "0.1.2";
    const TYPE = "feature";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    
    // Handle command help
    public function onCommandHelp() {
        return "example\n";
    }
    
    // Handle command
    public function onCommand($args) {
        $statusCode = 0;
        list($command) = $args;
        if ($command=="example") {
            echo "Yellow $command: Add more text here\n";
            $statusCode = 200;
        }
        return $statusCode;
    }
}
```

### Yellow edit events

Yellow edit events notify when a page is edited in the web browser.

**public function onEditUserRestrictions($email, $location, $fileName, $users)**  
Handle user restrictions

**public function onEditUserAccount($email, $password, $action, $users)**  
Handle [user account](adjusting-system#user-accounts) changes

**public function onEditContentFile($page, $action)**  
Handle content file changes

**public function onEditMediaFile($file, $action)**  
Handle media file changes

Here's an example extension for restricting certain users:

``` php
<?php
class YellowExample {
    const VERSION = "0.1.3";
    const TYPE = "feature";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    
    // Handle user restrictions
    public function onEditUserRestrictions($email, $location, $fileName, $users) {
        return $users->getHome($email)=="/guests/";
    }
}
```

## Troubleshooting

Open the file `system/extensions/core.php`, change first line to `<?php define("DEBUG", 1);`

```
YellowCore::sendPage Cache-Control: max-age=60
YellowCore::sendPage Content-Type: text/html; charset=utf-8
YellowCore::sendPage Content-Modified: Wed, 06 Feb 2019 13:54:17 GMT
YellowCore::sendPage Last-Modified: Thu, 07 Feb 2019 09:37:48 GMT
YellowCore::sendPage layout:blogpages theme:flatsite parser:markdown
YellowCore::processRequest file:content/1-en/2-features/1-blog/page.md
YellowCore::request status:200 handler:core time:19 ms
```

Get file system information by increasing debug level to `<?php define("DEBUG", 2);`
```
Datenstrom Yellow 0.8.2, PHP 7.1.16, Apache/2.4.33 Darwin
YellowSystem::load file:system/settings/system.ini
YellowUsers::load file:system/settings/user.ini
YellowText::load file:system/extensions/english-language.txt
YellowText::load file:system/extensions/french-language.txt
YellowText::load file:system/extensions/german-language.txt
YellowText::load file:system/settings/text.ini
```

Get maximum information by increasing debug level to `<?php define("DEBUG", 3);`
```
Datenstrom Yellow 0.8.2, PHP 7.1.16, Apache/2.4.33 Darwin
YellowSystem::load file:system/settings/system.ini
YellowSystem::load Sitename:Datenstrom developers
YellowSystem::load Author:Datenstrom
YellowSystem::load Email:webmaster
YellowSystem::load Language:en
YellowSystem::load Timezone:Europe/Stockholm
```

[Next: HTML files →](html-files)
