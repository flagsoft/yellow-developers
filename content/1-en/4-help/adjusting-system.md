---
Title: Adjusting system
---
All settings are located in the `system` folder. You can adjust your website here.

[image screenshot-system.png Screenshot]

The `config` folder contains configuration files. The `plugins` folder contains the features of your website. The `themes` folder is for the appearance of your website. The `trash` folder stores deleted files. Changes in these folders affect the entire website.

## System settings

The main configuration file is `system/config/config.ini`. Here's an example:

    Sitename: Anna Svensson Design
    Author: Anna Svensson
    Email: anna@svensson.com
    Language: en
    Timezone: Europe/Stockholm
    Theme: flatsite

You can define the system settings here, for example the name of the website and the email of the webmaster. Individual [settings](markdown-cheat-sheet#settings) can be defined at the top of each page. For a new installation you should set `Sitename`, `Author` and `Email`.

## Text settings

Another configuration file is `system/config/text.ini`. Here's an example:

    EditLoginTitle: Welcome to Stockholm
    Error404Title: File not found
    Error404Text: The requested file was not found. Oh no...
    DateFormatShort: F Y
    DateFormatMedium: Y-m-d
    DateFormatLong: Y-m-d H:i

You can define the text settings here, for example error messages of the website and the date format. The default text is defined in the corresponding [language file](https://github.com/datenstrom/yellow-plugins/blob/master/language/language-en.txt). You can copy text from the language file into the text settings and customise it.

## User accounts

All user accounts are stored in file `system/config/user.ini`. Here's an example:

    anna@svensson.com: $2y$10$j26zDnt/xaWxC/eqGKb9p.d6e3pbVENDfRzauTawNCUHHl3CCOIzG,Anna,en,active,21196d7e857d541849e4,946684800,0,none,/
    english@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Demo,en,active,f3e71699df534913a823,946684800,0,none,/
    guest@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Guest,en,active,b3106b8b1732ee60f5b3,946684800,0,none,/tests/

You can use the [web browser](https://github.com/datenstrom/yellow-plugins/tree/master/edit) and the [command line](https://github.com/datenstrom/yellow-plugins/tree/master/command) to create new user accounts and change passwords. A user account consists of one line with email, encrypted password and different settings. At the end of the line is the user's home page.

[Next: Language configuration →](language-configuration)