---
Title: How to make a website
---
[[image screenshot-website-en.png Screenshot screenshot 75%]](/)  
Learn how to make your own website. [See demo](/).

## Install website

1. [Download and unzip Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copy all files to your web hosting.
3. Open your website in a web browser and select 'Website'.

Your website is immediately available. The installation comes with two pages, 'Home' and 'About'. This is just an example to get you started, change everything as you like. You can make a website by adding more files and folders.

When there are problems, please check the [server configuration](server-configuration) or ask the [support](support).

## Writing web pages

Have a look inside your `content` folder, here are all your web pages. Open the file `content/1-home/page.md`. You'll see settings and text of the page. You can change `Title` and other [settings](markdown-cheat-sheet#settings) at the top of a page. Here's an example:

```
---
Title: Home
---
Your website works! 

[edit - You can edit this page] or use your text editor. 
```

To create a new page, add a new file to the home folder or another `content` folder. The [navigation](adding-content) is automatically created from your `content` folders. Here's another example:

```
---
Title: Demo
---
[edit - You can edit this page]. The help gives you more information 
about how to create small web pages, blogs and wikis. 
[Learn more](https://developers.datenstrom.se/help/).
```

Now let's add an image:

```
---
Title: Demo
---
[image picture.jpg Example rounded]

[edit - You can edit this page]. The help gives you more information 
about how to create small web pages, blogs and wikis. 
[Learn more](https://developers.datenstrom.se/help/).
```

You can use [Markdown](markdown-cheat-sheet) to edit web pages.

## Showing a sidebar

To show a sidebar add the file `sidebar.md` to a `content` folder. The sidebar will be shown on all pages in the same folder. You can decide if you like to have a sidebar or not. Here's an example sidebar:

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

## More features

* [How to add an image gallery to your website](https://github.com/datenstrom/yellow-plugins/tree/master/gallery)
* [How to add a search to your website](https://github.com/datenstrom/yellow-plugins/tree/master/search)
* [How to add a sitemap to your website](https://github.com/datenstrom/yellow-plugins/tree/master/sitemap)
* [How to add a contact page to your website](https://github.com/datenstrom/yellow-plugins/tree/master/contact)
* [How to make a static website](server-configuration#static-website)

[Next: How to make a blog →](how-to-make-a-blog)