---
Title: Adding content 
---
All content is located in the `content` folder. You can edit your website here.

[image screenshot-content.png Screenshot]

The `content` folders are available on your website. Every folder has a file called `page.md` or with the name of the folder. You can also add more files and folders. Basically, what you see in the file manager is the website you get.

## Files and folders

The navigation is automatically created from your `content` folders. Only folders with a prefix are shown in the navigation. Folders with prefix are for visible pages, folders without prefix are for invisible pages. All files and folders can have a prefix:

1. Folders can have a numerical prefix, e.g. `1-home` `9-about`
2. Files can have a date prefix for sorting, e.g. `2013-04-07-blog-example.md`
3. No prefix means there is no special order, e.g. `wiki-example.md`

Prefix and suffix are removed from the location, so that it looks better. For example the folder `content/9-about/` is available on your website as `http://website/about/`. The file `content/9-about/what-we-do.md` becomes `http://website/about/what-we-do`. 

Folders may contain files and folders. There is one exception. The first folder may not contain subfolders, because it's responsible for the home page and available on your website as `http://website/`.

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