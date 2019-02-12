---
Title: Ajouter des pages
---
Les pages de votre site se trouvent dans le dossier `content`. Vous pouvez modifier votre site web à partir de ce dossier.

[image screenshot-content.png Screenshot]

Le contenu de tout les dossiers présents dans `content` est accessible depuis votre site. Chaque dossier dispose d'un fichier nommé `page.md` ou d'un fichier possédant le même nom que le dossier. Vous pouvez y ajouter d'autres fichiers et dossiers. Pour faire simple, ce que vous voyez dans votre gestionnaire de fichiers représente la structure du site web que vous aurez.

## Fichiers et dossiers

Le menu de navigation est automatiquement créée à partir de vos dossiers `content`. Les dossiers avec préfixe sont destinés aux pages visibles, qui sont affichées dans la navigation. Les dossiers sans préfixe sont destinés aux pages invisibles, qui ne sont pas affichées dans la navigation. Tous les dossiers et fichiers peuvent avoir un préfixe:

1. Les dossiers peuvent avoir un préfixe numérique, par exemple `1-home` ou` 9-about`
2. Les dossiers sans préfixe ne sont pas affichés dans la navigation, par exemple `shared`
3. Les fichiers peuvent avoir un préfixe numérique, par exemple `2013-04-07-blog-example.md`
4. Les fichiers sans préfixe n’ont aucune signification particulière, par exemple `wiki-example.md`

Préfixe et suffixe sont retirés de l'url afin de proposer une navigation cohérente et propre. Le dossier `content/9-about/` est accessible à l'adresse `http://website/about/`. Le fichier `content/9-about/what-we-do.md` devient quand à lui `http://website/about/what-we-do`. 

Il y a deux exceptions. Le premier dossier ne doit pas contenir de sous-dossiers, car il est responsable de la page d'accueil et est accessible en tant que `http://website/`. Le dossier `shared` peut uniquement être inclus dans d'autres pages, il n'est pas disponible sur votre site web.

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
