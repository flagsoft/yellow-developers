---
Title: Ajouter des pages
---
Les pages de votre site se trouvent dans le dossier `content`. Vous pouvez modifier votre site web à partir de ce dossier.

[image screenshot-content.png Screenshot]

Le contenu de tout les dossiers présents dans `content` est accessible depuis votre site. Chaque dossier dispose d'un fichier nommé `page.md` ou d'un fichier possédant le même nom que le dossier. Vous pouvez y ajouter d'autres fichiers et dossiers. Pour faire simple, ce que vous voyez dans votre gestionnaire de fichiers représente la structure du site web que vous aurez.

## Fichiers et dossiers

Le menu de navigation est automatiquement créée à partir de vos dossiers présents dans le dossier `content`. Seuls les dossiers possédant un préfixe sont présents dans le menu de navigation. Les dossiers possédant un préfixe concernent les pages visibles, les dossiers sans préfixes seront pour des pages invisibles. Tous les fichiers et les dossiers peuvent avoir un préfixe:

1. Avec un préfixe numérique, p. ex. `1-home` `9-about`
2. Avec un préfixe de la date, p. ex. `2013-04-07-blog-example.md`
3. L'absence de préfixe pour ne pas trier, p. ex. `wiki-example.md`

Préfixe et suffixe sont retirés de l'url afin de proposer une navigation cohérente et propre. Le dossier `content/9-about/` est accessible à l'adresse `http://website/about/`. Le fichier `content/9-about/what-we-do.md` devient quand à lui `http://website/about/what-we-do`. 

Chaque dossier peut contenir des fichiers et des sous-dossiers. Il y a une exception cependant: le premier dossier ne peut pas contenir de sous-dossiers, car il est responsable de la page d'accueil et est accessible en tant qu'url principale `http://website/`.

## Markdown

Vous pouvez utiliser [Markdown](markdown-cheat-sheet) pour éditer des pages web. Essayez-le. Ouvrez le fichier `content/1-home/page.md` dans votre éditeur de texte préféré. Vous y verrez la configuration et le contenu de la page. Vous pouvez modifier le titre `Title` et ajouter d'autres [paramètres](markdown-cheat-sheet#paramètres) en haut de la page. Voici un exemple:

    ---
    Title: Home
    ---
    Votre site web fonctionne!
    
    [edit - Vous pouvez modifier cette page] ou utiliser un éditeur de texte.

Formatage du texte:

    Normal **gras** *italique* `code`

Créer une liste:

    * point une
    * point deux
    * point trois

[Suivant: Ajouter des fichiers →](adding-media)
