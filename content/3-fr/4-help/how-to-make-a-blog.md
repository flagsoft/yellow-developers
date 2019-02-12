---
Title: Comment faire un blog
---
Apprenez à faire un propre blog. [Voir la démo](/fr/features/blog/).

[[image screenshot-blog.png Screenshot screenshot 75%]](/fr/features/blog/fika-is-good-for-you)

## Installer un blog

1. [Téléchargez et dézippez Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copiez tout les fichiers sur votre serveur web.
3. Accédez à votre site depuis un navigateur web et choisissez 'Blog'.

Votre blog est immédiatement accessible. L'installation est fournie avec plusieurs pages, 'Home', 'Blog' et 'À propos'. Elles sont juste un exemple pour commencer, vous pouvez les modifier comme il vous convient. Vous pouvez supprimer 'Home', si vous souhaitez faire de votre blog la page d'accueil.

S'il y a des problèmes, vérifiez la [configuration du serveur](server-configuration) ou demandez le [support](support).

## Écrire une page de blog

Jetons un oeil dans le dossier `content`, où se trouve le dossier de votre blog avec toutes vos pages de blog. Ouvrez le fichier `2013-04-07-blog-example.md`. Vous y verrez les paramètres et le texte de la page. Vous pouvez changer le titre de la page `Title` ainsi que d'autres [paramètres](markdown-cheat-sheet#paramètres) en haut de la page. Ci-dessous, vous pouvez utiliser [Markdown](markdown-cheat-sheet). Voici un exemple:

```
---
Title: Exemple de blog
Published: 2013-04-07
Author: Datenstrom
Template: blog
Tag: Exemple
---
Ceci est un exemple de page de blog.

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 
tempor incididunt ut labore et dolore magna pizza. Ut enim ad minim veniam, 
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. 
```

Pour créer une nouvelle page de blog, ajoutez un nouveau fichier dans le dossier de votre blog. Définissez la date de publication `Published` en haut de la page. Les dates doivent être au format YYYY-MM-DD. La date de publication sera utilisé afin de classer les pages du blog. Vous pouvez utiliser `Tag` pour grouper des pages similaires entres elles. Voici un autre exemple:

```
---
Title: Fika est bon pour toi
Published: 2016-06-01
Author: Datenstrom
Template: blog
Tag: Exemple, Café, Vidéo
---
Fika est une coutume suédoise. C'est une pause-café sociale où les gens se 
rassemblent pour prendre une tasse de café ou de thé ensemble. Vous pouvez 
avoir fika avec des collègues au travail. Vous pouvez inviter vos amis à fika. 
Fika est une part aussi importante de la vie en Suède que c'est à la fois un 
verbe et un nom. À quelle fréquence faites-vous fika?
```

Maintenant ajoutons une vidéo avec le [plugin Youtube](https://github.com/datenstrom/yellow-extensions/tree/master/features/youtube):

```
---
Title: Fika est bon pour toi
Published: 2016-06-01
Author: Datenstrom
Template: blog
Tag: Exemple, Café, Vidéo
---
Fika est une coutume suédoise. C'est une pause-café sociale où les gens se 
rassemblent pour prendre une tasse de café ou de thé ensemble. Vous pouvez 
avoir fika avec des collègues au travail. Vous pouvez inviter vos amis à fika. 
Fika est une part aussi importante de la vie en Suède que c'est à la fois un 
verbe et un nom. À quelle fréquence faites-vous fika?

[youtube aIMR73COZQU]
```

Faisons en sorte que la vidéo soit visible quand le visiteur clique sur la page de blog. Vous pouvez ajouter `[--more--]` à l'endroit désiré le saut de page:

```
---
Title: Fika est bon pour toi
Published: 2016-06-01
Author: Datenstrom
Template: blog
Tag: Exemple, Café, Vidéo
---
Fika est une coutume suédoise. C'est une pause-café sociale où les gens se 
rassemblent pour prendre une tasse de café ou de thé ensemble. Vous pouvez 
avoir fika avec des collègues au travail. Vous pouvez inviter vos amis à fika. 
Fika est une part aussi importante de la vie en Suède que c'est à la fois un 
verbe et un nom. À quelle fréquence faites-vous fika? [--more--]

[youtube aIMR73COZQU]
```

## Afficher une sidebar

Pour afficher une sidebar (menu latéral), ajoutez le fichier `content/shared/sidebar.md`. Vous pouvez également créer un `sidebar.md` dans votre dossier de blog, la sidebar ne sera alors affichée que sur les pages du même dossier. Voici un exemple:

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

Vous pouvez utiliser des [raccourcis](https://github.com/datenstrom/yellow-extensions/tree/master/features/blog#how-to-show-blog-information) afin d'afficher des informations à propos du blog.

```
---
Title: Sidebar
Status: hidden
---
Nouveau

[blogchanges /blog/ 5]

Tags

[blogtags /blog/ 5]
```

Voici les mêmes raccourcis, si le blog est situé sur la page d'accueil:

```
---
Title: Sidebar
Status: hidden
---
Nouveau

[blogchanges / 5]

Tags

[blogtags / 5]
```

## Ajuster le pied de page

Pour ajuster le pied de page, changez le fichier `content/shared/footer.md`. Vous pouvez également créer un `footer.md` dans votre dossier de blog, le pied de page ne sera alors affiché que sur les pages du même dossier. Voici un exemple:

```
---
Title: Footer
Status: hidden
---
[Fait avec Datenstrom Yellow](https://datenstrom.se/fr/yellow/)
```

## Plus de fonctionnalités

* [Comment ajouter des commentaires à votre blog](https://github.com/datenstrom/yellow-extensions/tree/master/features/disqus)
* [Comment ajouter un moteur de recherche à votre blog](https://github.com/datenstrom/yellow-extensions/tree/master/features/search)
* [Comment ajouter un feed à votre blog](https://github.com/datenstrom/yellow-extensions/tree/master/features/feed)
* [Comment créer une page de brouillon](https://github.com/datenstrom/yellow-extensions/tree/master/features/draft)
* [Comment créer un blog statique](server-configuration#site-web-statique)

[Suivant: Comment faire un wiki →](how-to-make-a-wiki)
