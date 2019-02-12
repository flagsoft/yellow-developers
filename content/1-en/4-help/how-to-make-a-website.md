---
Title: How to make a website
---
Learn how to make your own website. [See demo](/).

[[image screenshot-website-en.png Screenshot screenshot 75%]](/)  

## Install website

1. [Download and unzip Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copy all files to your web server.
3. Open your website in a web browser and select 'Website'.

Your website is immediately available. The installation comes with two pages, 'Home' and 'About'. This is just an example to get you started, change everything as you like. You can make a website by adding more files and folders.

When there are problems, please check the [server configuration](server-configuration) or ask the [support](support).

## Writing web pages

Have a look inside your `content` folder, here are all your web pages. Open the file `content/1-home/page.md`. You'll see settings and text of the page. You can change `Title` and other [settings](markdown-cheat-sheet#settings) at the top of a page. Below that you can use [Markdown](markdown-cheat-sheet). Here's an example:

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

## Showing sidebar

To show a sidebar create the file `content/shared/sidebar.md`. You can also create a `sidebar.md` in any `content` folder, the sidebar will then only be shown on pages in the same folder. Here's an example:

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

## Adjusting footer

To adjust the footer change the file `content/shared/footer.md`. You can also create a `footer.md` in any `content` folder, the footer will then only be shown on pages in the same folder. Here's an example:

```
---
Title: Footer
Status: hidden
---
[Made with Datenstrom Yellow](https://datenstrom.se/yellow/)
```

## More features

* [How to add an image gallery to your website](https://github.com/datenstrom/yellow-extensions/tree/master/features/gallery)
* [How to add a search to your website](https://github.com/datenstrom/yellow-extensions/tree/master/features/search)
* [How to add a sitemap to your website](https://github.com/datenstrom/yellow-extensions/tree/master/features/sitemap)
* [How to add a contact page to your website](https://github.com/datenstrom/yellow-extensions/tree/master/features/contact)
* [How to make a static website](server-configuration#static-website)

[Next: How to make a blog →](how-to-make-a-blog)