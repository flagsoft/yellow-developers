---
Title: Ajuster le système
---
Tout les paramètres se trouvent dans le dossier `system`. Vous pouvez y faire des ajustements.

[image screenshot-system.png Screenshot]

Le dossier `config` contient les fichiers de configurations. Le dossier `plugins` contient les fonctionnalités de votre site web. Le dossier `themes` concerne l'apparence de votre site web. Le dossier `trash` stocke les fichiers supprimés. Apporter des changements dans ces dossiers affectera entièrement votre site web.

## Paramètres du système

Le fichier de configuration principal est `system/config/config.ini`. Voici un exemple:

    Sitename: Anna Svensson Design
    Author: Anna Svensson
    Email: anna@svensson.fr
    Language: fr
    Timezone: Europe/Paris
    Theme: flatsite

Vous pouvez y définir les paramètres du système, par exemple le nom du site web et l'email du webmaster. Des [paramètres](markdown-cheat-sheet#paramètres) individuels peuvent être définis au haut de chaque page. Lors d'une nouvelle installation, il est conseillé de modifier `Sitename`, `Author` et `Email`.

## Paramètres de texte

Un autre fichier de configuration est `system/config/text.ini`. Voici un exemple:

    EditLoginTitle: Bienvenue à Paris
    DateFormatShort: F Y
    DateFormatMedium: d/m/Y
    DateFormatLong: d/m/Y H:i

Vous pouvez définir ici les paramètres de texte, par exemple le texte affiché sur votre site web et le [format de la date](http://php.net/manual/fr/function.date.php). Le texte par défaut est défini dans le [fichier de langue](https://github.com/datenstrom/yellow-plugins/blob/master/language/language-fr.txt) correspondant. Ce texte peut être personnalisé dans les paramètres de texte.

## Comptes d'utilisateurs

Tous les utilisateurs sont stockés dans le fichier `system/config/user.ini`. Voici un exemple:

    anna@svensson.fr: $2y$10$j26zDnt/xaWxC/eqGKb9p.d6e3pbVENDfRzauTawNCUHHl3CCOIzG,Anna,fr,active,21196d7e857d541849e4,946684800,0,none,/
    français@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Demo,fr,active,1c5a6e50c714112c7c25,946684800,0,none,/
    guest@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Guest,en,active,b3106b8b1732ee60f5b3,946684800,0,none,/tests/

Le [navigateur web](https://github.com/datenstrom/yellow-plugins/tree/master/edit) et le [ligne de commande](https://github.com/datenstrom/yellow-plugins/tree/master/command) vous permet de créer de nouveaux comptes d'utilisateurs et de changer les mots de passe. Un compte d'utilisateur se compose d'un email, d'un mot de passe crypté, de différents paramètres, tandis que le dernier paramètre concerne la page d'accueil de l'utilisateur.

[Suivant: Configuration du serveur →](server-configuration)