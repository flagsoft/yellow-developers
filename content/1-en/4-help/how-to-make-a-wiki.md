---
Title: How to make a wiki
---
Learn how to make your own wiki. [See demo](/plugins/wiki/).

[[image screenshot-wiki.png Screenshot screenshot 75%]](/plugins/wiki/coffee-is-good-for-you)  

## Install wiki

1. [Download and unzip Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copy all files to your web server.
3. Open your website in a web browser and select 'Wiki'.

Your wiki is immediately available. The installation comes with several pages, 'Home', 'Wiki' and 'About'. This is just an example to get you started, change everything as you like. You can delete 'Home', if you want to show the wiki on the home page.

When there are problems, please check the [server configuration](server-configuration) or ask the [support](support).

## Writing wiki pages

Have a look inside your `content` folder, there's the wiki folder with all your wiki pages. Open the file `wiki-page.md`. You'll see settings and text of the page. You can change `Title` and other [settings](markdown-cheat-sheet#settings) at the top of a page. Below that you can use [Markdown](markdown-cheat-sheet). Here's an example:

```
---
Title: Wiki page
Template: wiki
Tag: Example
---
This is an example wiki page. 

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 
tempor incididunt ut labore et dolore magna pizza. Ut enim ad minim veniam, 
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. 
```

To create a new wiki page, add a new file to the wiki folder. Set `Title` and more settings at the top of a page. You can use `Tag` to group similar pages together. Here's another example:

```
---
Title: Coffee is good for you
Template: wiki
Tag: Example, Coffee
---
Coffee is a beverage made from the roasted beans of the coffee plant.

1. Start with fresh coffee. Coffee beans start losing quality immediately 
   after roasting and grinding. The best coffee is made from beans ground 
   right after roasting. 
2. Brew a cup of coffee. Coffee is prepared with different methods and 
   additional flavorings such as milk and sugar. There are Espresso, Filter 
   coffee, French press, Italian Moka, Turkish coffee and many more. Find 
   out what's your favorite.
3. Enjoy.
```

Now let's add a video with the [Youtube plugin](https://github.com/datenstrom/yellow-plugins/tree/master/youtube):

```
---
Title: Coffee is good for you
Template: wiki
Tag: Example, Coffee, Video
---
Coffee is a beverage made from the roasted beans of the coffee plant.

1. Start with fresh coffee. Coffee beans start losing quality immediately 
   after roasting and grinding. The best coffee is made from beans ground 
   right after roasting. 
2. Brew a cup of coffee. Coffee is prepared with different methods and 
   additional flavorings such as milk and sugar. There are Espresso, Filter 
   coffee, French press, Italian Moka, Turkish coffee and many more. Find 
   out what's your favorite.
3. Enjoy.

[youtube SUpY1BT9Xf4]
```

## Showing sidebar

To show a sidebar create the file `content/shared/sidebar.md`. You can also create a `sidebar.md` in your wiki folder, the sidebar will then only be shown on pages in the same folder. Here's an example:

```
---
Title: Sidebar
Status: hidden
---
Links

* [See all pages](/wiki/special:pages/)
* [See recent changes](/wiki/special:changes/)
* [See example](/wiki/tag:example/)
```

You can use [shortcuts](https://github.com/datenstrom/yellow-plugins/tree/master/wiki#how-to-show-wiki-information) to show information about the wiki:

```
---
Title: Sidebar
Status: hidden
---
Links

* [See all pages](/wiki/special:pages/)
* [See recent changes](/wiki/special:changes/)
* [See example](/wiki/tag:example/)

Tags

[wikitags /wiki/ 5]
```

Here is the same sidebar, if the wiki is located on the home page:

```
---
Title: Sidebar
Status: hidden
---
Links

* [See all pages](/special:pages/)
* [See recent changes](/special:changes/)
* [See example](/tag:example/)

Tags

[wikitags / 5]
```

## Adjusting footer

To adjust the footer change the file `content/shared/footer.md`. You can also create a `footer.md` in your wiki folder, the footer will then only be shown on pages in the same folder. Here's an example:

```
---
Title: Footer
Status: hidden
---
[Made with Datenstrom Yellow](https://datenstrom.se/yellow/)
```

## More features

* [How to add a table of contents to your wiki](https://github.com/datenstrom/yellow-plugins/tree/master/toc)
* [How to add a search to your wiki](https://github.com/datenstrom/yellow-plugins/tree/master/search)
* [How to add a contact page to your wiki](https://github.com/datenstrom/yellow-plugins/tree/master/contact)
* [How to make a draft page](https://github.com/datenstrom/yellow-plugins/tree/master/draft)
* [How to make a static wiki](server-configuration#static-website)

[Next: Adding content →](adding-content)