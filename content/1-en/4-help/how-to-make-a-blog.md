---
Title: How to make a blog
---
[[image screenshot-blog.png Screenshot screenshot 75%]](/plugins/blog/fika-is-good-for-you)  
Learn how to make your own blog. [See demo](/plugins/blog/).

## Install blog

1. [Download and unzip Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copy all files to your web hosting.
3. Open your website in a web browser and select 'Blog'.

Your blog is immediately available. The installation comes with several pages, 'Home', 'Blog' and 'About'. This is just an example to get you started, change everything as you like. You can delete 'Home', if you want to show the blog on the home page.

When there are problems, please check the [server configuration](server-configuration) or ask the [support](support).
 
## Writing blog pages

Have a look inside your `content` folder, there's the blog folder with all your blog pages. Open the file `2013-04-07-blog-example.md`. You'll see settings and text of the page. You can change `Title` and other [settings](markdown-cheat-sheet#settings) at the top of a page. Here's an example:

```
---
Title: Blog example
Published: 2013-04-07
Author: Datenstrom
Template: blog
Tag: Example
---
This is an example blog page. 

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 
tempor incididunt ut labore et dolore magna pizza. Ut enim ad minim veniam, 
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. 
```

To create a new blog page, add a new file to the blog folder. Set `Published` and more settings at the top of a page. Dates should be written in the format YYYY-MM-DD. The publishing date will be used to sort blog pages. You can use `Tag` to group similar pages together. Here's another example:

```
---
Title: Fika is good for you
Published: 2016-06-01
Author: Datenstrom
Template: blog
Tag: Example, Coffee
---
Fika is a Swedish custom. It's a social coffee break where people 
gather to have a cup of coffee or tea together. You can have fika with 
colleagues at work. You can invite your friends to fika. Fika is such 
an important part of life in Sweden that it is both a verb and a noun. 
How often do you fika?
```

Now let's add a video with the [Youtube plugin](https://github.com/datenstrom/yellow-plugins/tree/master/youtube):

```
---
Title: Fika is good for you
Published: 2016-06-01
Author: Datenstrom
Template: blog
Tag: Example, Coffee, Video
---
Fika is a Swedish custom. It's a social coffee break where people 
gather to have a cup of coffee or tea together. You can have fika with 
colleagues at work. You can invite your friends to fika. Fika is such 
an important part of life in Sweden that it is both a verb and a noun. 
How often do you fika?

[youtube aIMR73COZQU]
```

Let's show the video when a visitor clicks on the blog page. You can use `[--more--]` to add a page break at the desired spot:

```
---
Title: Fika is good for you
Published: 2016-06-01
Author: Datenstrom
Template: blog
Tag: Example, Coffee, Video
---
Fika is a Swedish custom. It's a social coffee break where people 
gather to have a cup of coffee or tea together. You can have fika with 
colleagues at work. You can invite your friends to fika. Fika is such 
an important part of life in Sweden that it is both a verb and a noun. 
How often do you fika? [--more--]

[youtube aIMR73COZQU]
```

You can use [Markdown](markdown-cheat-sheet) to edit blog pages.

## Showing a sidebar

To show a sidebar add the file `sidebar.md` to your blog folder. The sidebar will be shown on all pages in the same folder. You can decide if you like to have a sidebar or not. Here's an example sidebar:

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

You can use [shortcuts](https://github.com/datenstrom/yellow-plugins/tree/master/blog#how-to-show-blog-information) to show information about the blog:

```
---
Title: Sidebar
Status: hidden
---
New

[blogchanges /blog/ 5]

Tags

[blogtags /blog/ 5]
```

Here is the same sidebar, if the blog is located on the home page:

```
---
Title: Sidebar
Status: hidden
---
New

[blogchanges / 5]

Tags

[blogtags / 5]
```

## More features

* [How to add comments to your blog](https://github.com/datenstrom/yellow-plugins/tree/master/disqus)
* [How to add a search to your blog](https://github.com/datenstrom/yellow-plugins/tree/master/search)
* [How to add a feed to your blog](https://github.com/datenstrom/yellow-plugins/tree/master/feed)
* [How to make a draft page](https://github.com/datenstrom/yellow-plugins/tree/master/draft)
* [How to make a static blog](server-configuration#static-website)

[Next: How to make a wiki →](how-to-make-a-wiki)