---
Title: Comment faire un site web
---
[[image screenshot-website-fr.png Screenshot screenshot 75%]](/fr/)  
Apprenez à faire un propre site web. [Voir la démo](/fr/).

## Installer votre site

1. [Téléchargez et dézippez Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copiez tout les fichiers chez votre hébergeur.
3. Accédez à votre site depuis un navigateur web et choisissez 'Website'.

Votre site web est immédiatement accessible. L'installation est fournie avec deux pages, 'Home' et 'À propos'. Elles sont juste un exemple pour commencer, vous pouvez les modifier comme il vous convient. Vous pouvez créer votre site web en ajoutant des fichiers et des dossiers.

S'il y a des problèmes, vérifiez la [configuration du serveur](server-configuration) ou demandez le [support](support).

## Écrire une page web

Jetons un oeil dans le dossier `content`, où se trouvent toutes vos pages web. Ouvrer le fichier `content/1-home/page.md`. Vous y verrez les paramètres et le texte de la page. Vous pouvez changer le titre de la page `Title` ainsi que d'autres [paramètres](markdown-cheat-sheet#paramètres) en haut de la page. Voici un exemple:

```
---
Title: Home
---
Votre site web fonctionne!

[edit - Vous pouvez modifier cette page] ou utiliser un éditeur de texte.
```

Pour créer une nouvelle page, ajoutez un nouveau fichier dans le dossier `1-home` ou dans tout autre dossier du dossier `content`. Le menu de [navigation](adding-content) est automatiquement créée à partir de vos dossiers présents dans le dossier content. Voici un autre exemple:

```
---
Title: Demo
---
[edit - Vous pouvez modifier cette page]. L'aide montre comment 
créer de petites pages web, blogs et wikis. 
[Apprenez-en plus](https://developers.datenstrom.se/fr/help/).
```

Maintenant ajoutons une image:

```
---
Title: Demo
---
[image picture.jpg Exemple rounded]

[edit - Vous pouvez modifier cette page]. L'aide montre comment 
créer de petites pages web, blogs et wikis. 
[Apprenez-en plus](https://developers.datenstrom.se/fr/help/).
```

Vous pouvez utiliser [Markdown](markdown-cheat-sheet) pour éditer des pages web.

## Afficher une sidebar

Pour afficher une sidebar (menu latéral), ajoutez le fichier `sidebar.md` dans un dossier de `content`. La sidebar est visible sur toutes les pages présentes dans le même dossier. Vous pouvez décider si vous souhaitez avoir une sidebar ou non. Voici un exemple de sidebar:

```
---
Title: Sidebar
Status: hidden
---
Liens

* [Twitter](https://twitter.com/datenstromse)
* [GitHub](https://github.com/datenstrom)
* [Datenstrom](https://datenstrom.se)
```

## Plus de fonctionnalités

* [Comment ajouter une galerie d'images](https://github.com/datenstrom/yellow-plugins/tree/master/gallery)
* [Comment ajouter un moteur de recherche à votre site](https://github.com/datenstrom/yellow-plugins/tree/master/search)
* [Comment ajouter un plan à votre site](https://github.com/datenstrom/yellow-plugins/tree/master/sitemap)
* [Comment ajouter une page de contact à votre site](https://github.com/datenstrom/yellow-plugins/tree/master/contact)
* [Comment créer un site web statique](server-configuration#site-web-statique)

[Suivant: Comment faire un blog →](how-to-make-a-blog)
