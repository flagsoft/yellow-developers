---
Title: Adding content 
---
All content is located in the `content` folder. You can edit your website here.

[image screenshot-content.png Screenshot]

The `content` folders are available on your website. Every folder has a file called `page.md` or with the name of the folder. You can also add more files and folders. Basically, what you see in the file manager is the website you get.

## Files and folders

The navigation is automatically created from your `content` folders. Folders with prefix are for visible pages, which are shown in the navigation. Folders without prefix are for invisible pages, which are not shown in the navigation. All folders and files can have a prefix:

1. Folders can have a numerical prefix, e.g. `1-home` or `9-about`
2. Folders without a prefix are not shown in the navigation, e.g. `shared`
3. Files can have a numerical prefix, e.g. `2013-04-07-blog-example.md`
4. Files without a prefix have no special meaning, e.g. `wiki-example.md`

Prefix and suffix are removed from the location, so that it looks better. For example the folder `content/9-about/` is available on your website as `http://website/about/`. The file `content/9-about/what-we-do.md` becomes `http://website/about/what-we-do`. 

There are two exception. The first folder must not contain subfolders, because it's responsible for the home page and available on your website as `http://website/`. The `shared` folder may only be included in other pages, it's not available on your website.

## Markdown

You can use [Markdown](markdown-cheat-sheet) to edit web pages. Open the file `content/1-home/page.md` in your favorite text editor. You'll see settings and text of the page. You can change `Title` and other [settings](markdown-cheat-sheet#settings) at the top of a page. Here's an example:

    ---
    Title: Home
    ---
    Your website works!
    
    [edit - You can edit this page] or use your text editor.

Formatting text:

    Normal **bold** *italic* `code`

Making a list:

    * item one
    * item two
    * item three

[Next: Adding media →](adding-media)