---
Title: Ajuster le système
---
Tout les paramètres se trouvent dans le dossier `system`. Vous pouvez y faire des ajustements.

[image screenshot-system.png Screenshot]

Le dossier `extensions` contient les extensions installées. Vous pouvez utiliser le dossier `layouts` et le dossier `resources` pour ajuster l'apparence de votre site web. Le dossier `settings` contient les fichiers de configuration. Le dossier `trash` stocke les fichiers supprimés.

## Paramètres du système

Le fichier de configuration principal est `system/settings/system.ini`. Voici un exemple:

    Sitename: Anna Svensson Design
    Author: Anna Svensson
    Email: anna@svensson.fr
    Language: fr
    Timezone: Europe/Paris

Vous pouvez y définir les paramètres du système, par exemple le nom du site web et l'email du webmaster. Des [paramètres](markdown-cheat-sheet#paramètres) individuels peuvent être définis au haut de chaque page. Lors d'une nouvelle installation, il est conseillé de modifier `Sitename`, `Author` et `Email`.

## Paramètres de texte

Un autre fichier de configuration est `system/settings/text.ini`. Voici un exemple:

    EditLoginTitle: Bienvenue à Paris
    Error404Title: Fichier non trouvé
    DateFormatShort: F Y
    DateFormatMedium: d/m/Y
    DateFormatLong: d/m/Y H:i

Vous pouvez définir ici les paramètres de texte, par exemple les messages d'erreur du site seb et le format de la date. Le texte par défaut est défini dans le [fichier de langue](https://github.com/datenstrom/yellow-extensions/blob/master/languages/french/french-language.txt) correspondant. Vous pouvez copier le texte d'un fichier de langue dans les paramètres de texte et le personnaliser.

## Comptes d'utilisateurs

Tous les utilisateurs sont stockés dans le fichier `system/settings/user.ini`. Voici un exemple:

    anna@svensson.fr: $2y$10$j26zDnt/xaWxC/eqGKb9p.d6e3pbVENDfRzauTawNCUHHl3CCOIzG,Anna,fr,active,21196d7e857d541849e4,946684800,0,none,/
    français@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Demo,fr,active,1c5a6e50c714112c7c25,946684800,0,none,/
    guest@demo.com: $2y$10$zG5tycOnAJ5nndGfEQhrBexVxNYIvepSWYd1PdSb1EPJuLHakJ9Ri,Guest,en,active,b3106b8b1732ee60f5b3,946684800,0,none,/tests/

Le [navigateur web](https://github.com/datenstrom/yellow-extensions/tree/master/features/edit) et le [ligne de commande](https://github.com/datenstrom/yellow-extensions/tree/master/features/command) vous permet de créer de nouveaux comptes d'utilisateurs et de changer les mots de passe. Un compte d'utilisateur consiste en une ligne avec email et différents paramètres. À la fin de la ligne se trouve la page d'accueil de l'utilisateur.

[Suivant: Configuration de la langue →](language-configuration)