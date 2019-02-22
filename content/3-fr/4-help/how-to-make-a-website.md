---
Title: Comment faire un site web
---
Apprenez à faire un propre site web. [Voir la démo](/fr/).

[[image screenshot-website-fr.png Screenshot screenshot 75%]](/fr/)  

## Installer votre site

1. [Téléchargez et dézippez Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copiez tout les fichiers sur votre serveur web.
3. Accédez à votre site depuis un navigateur web et choisissez 'Website'.

Votre site web est immédiatement accessible. L'installation est fournie avec deux pages, 'Home' et 'À propos'. Elles sont juste un exemple pour commencer, vous pouvez les modifier comme il vous convient. Vous pouvez créer votre site web en ajoutant des fichiers et des dossiers.

S'il y a des problèmes, vérifiez la [configuration du serveur](server-configuration) ou demandez le [support](support).

## Écrire une page web

Jetons un oeil dans le dossier `content`, où se trouvent toutes vos pages web. Ouvrer le fichier `content/1-home/page.md`. Vous y verrez les paramètres et le texte de la page. Vous pouvez changer le titre de la page `Title` ainsi que d'autres [paramètres](markdown-cheat-sheet#paramètres) en haut de la page. Ci-dessous, vous pouvez utiliser [Markdown](markdown-cheat-sheet). Voici un exemple:

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

## Afficher une sidebar

Pour afficher une sidebar (menu latéral), ajoutez le fichier `content/shared/sidebar.md`. Vous pouvez également créer un `sidebar.md` dans n’importe quel dossier `content` et il ne sera affiché que sur les pages du même dossier. Voici un exemple:

```
---
Title: Sidebar
Status: hidden
---
Liens

* [Twitter](https://twitter.com/datenstromse)
* [GitHub](https://github.com/datenstrom)
* [Datenstrom](https://datenstrom.se/fr/)
```

## Afficher un en-tête

Pour afficher nu en-tête, ajoutez le fichier `content/shared/header.md`. Vous pouvez également créer un `header.md` dans n’importe quel dossier `content` et il ne sera affiché que sur les pages du même dossier. Voici un exemple:

```
---
Title: Header
Status: hidden
---
J'aime Markdown.
```

## Ajuster un pied de page

Pour ajuster le pied de page, changez le fichier `content/shared/footer.md`. Vous pouvez également créer un `footer.md` dans n’importe quel dossier `content` et il ne sera affiché que sur les pages du même dossier. Voici un exemple:

```
---
Title: Footer
Status: hidden
---
[Fait avec Datenstrom Yellow](https://datenstrom.se/fr/yellow/)
```

## Ajouter des extensions

* [Comment ajouter une galerie d'images](https://github.com/datenstrom/yellow-extensions/tree/master/features/gallery)
* [Comment ajouter un moteur de recherche à votre site](https://github.com/datenstrom/yellow-extensions/tree/master/features/search)
* [Comment ajouter un plan à votre site](https://github.com/datenstrom/yellow-extensions/tree/master/features/sitemap)
* [Comment ajouter une page de contact à votre site](https://github.com/datenstrom/yellow-extensions/tree/master/features/contact)
* [Comment créer un site web statique](server-configuration#site-web-statique)

[Suivant: Comment faire un blog →](how-to-make-a-blog)
