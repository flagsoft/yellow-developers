---
Title: Language configuration
---
Here's how to set up languages.

## Single language mode

The installation comes with three languages and you can [download more languages](https://github.com/datenstrom/yellow-extensions/tree/master/languages). The default language is defined the [system settings](adjusting-system#system-settings). A different language can be defined in the [settings](markdown-cheat-sheet#settings) at the top of each page, for example `Language: en`.

Here's an English page:

```
---
Title: About us
Language: en
---
Birds of a feather flock together.
```

A German page:

```
---
Title: Über uns
Language: de
---
Wo zusammenwächst was zusammen gehört.
```

A French page:

```
---
Title: À propos de nous
Language: fr
---
Les oiseaux de même plumage volent toujours ensemble.
```

## Multi language mode

For multilingual websites you can use the multi language mode. For example if you plan to translate an entire website. Open file `system/settings/system.ini` and change `MultiLanguageMode: 1`. Go to your `content` folder and create a new folder for each language. Here's an example:

[image screenshot-language1.png Screenshot]

The first screenshot shows the folders `1-en`, `2-de` and `3-fr`. This gives you the URLs `http://website/` `http://website/de/` `http://website/fr/` for English, German and French. Here's another example:

[image screenshot-language2.png Screenshot]

The second screenshot shows the folders `1-en`, `2-de`, `3-fr` and `default`. This gives you the URLs `http://website/en/` `http://website/de/` `http://website/fr/` and a home page `http://website/` that automatically detects the visitor's language. 

To show a [language selection](/language/), you can create a page that lists available languages. This allows visitors to choose their language. The language selection can be integrated into your website, for example in the navigation or the footer.

[Next: Security configuration →](security-configuration)