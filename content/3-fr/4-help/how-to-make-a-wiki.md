---
Title: Comment faire un wiki
---
Apprenez à faire un propre wiki. [Voir la démo](/fr/features/wiki/).

[[image screenshot-wiki.png Screenshot screenshot 75%]](/fr/features/wiki/coffee-is-good-for-you)  

## Installer un wiki

1. [Téléchargez et dézippez Datenstrom Yellow](https://github.com/datenstrom/yellow/archive/master.zip).
2. Copiez tout les fichiers sur votre serveur web.
3. Accédez à votre site depuis un navigateur web et choisissez 'Wiki'.

Votre wiki est immédiatement accessible. L'installation est fournie avec plusieurs pages, 'Home', 'Wiki' et 'À propos'. Elles sont juste un exemple pour commencer, vous pouvez les modifier comme il vous convient. Vous pouvez supprimer 'Home', si vous souhaitez faire de votre wiki la page d'accueil.

S'il y a des problèmes, vérifiez la [configuration du serveur](server-configuration) ou demandez le [support](support).

## Écrire une page de wiki

Jetons un oeil dans le dossier `content`, où se trouve le dossier de votre wiki avec toutes vos pages de wiki. Ouvrez le fichier `wiki-page.md`. Vous y verrez les paramètres et le texte de la page. Vous pouvez changer le titre de la page `Title` ainsi que d'autres [paramètres](markdown-cheat-sheet#paramètres) en haut de la page. Ci-dessous, vous pouvez utiliser [Markdown](markdown-cheat-sheet). Voici un exemple:

```
---
Title: Exemple de wiki
Template: wiki
Tag: Exemple
---
Ceci est un exemple de page de wiki.

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 
tempor incididunt ut labore et dolore magna pizza. Ut enim ad minim veniam, 
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. 
```

Pour créer une nouvelle page de wiki, ajoutez un nouveau fichier dans le dossier de wiki. Définissez le `Title` et d'autres paramètres en haut de la page. Vous pouvez utiliser `Tag` pour grouper des pages similaires entres elles. Voici un autre exemple:

```
---
Title: Café est bon pour toi
Template: wiki
Tag: Exemple, Café
---
Le café est une boisson fabriquée à partir des haricots rôtis de l'usine de café.

1. Commencez par un café frais. Les grains de café commencent à perdre de la 
   qualité immédiatement après la torréfaction et le broyage. Le meilleur café 
   est fabriqué à partir de haricots au sol juste après la torréfaction.
2. Faites une tasse de café. Le café est préparé avec différentes méthodes 
   et des arômes supplémentaires tels que le lait et le sucre. Il existe un 
   café espresso, un filtre, une presse française, un cafetière italienne, un 
   café turc et beaucoup d'autres. Découvrez quel est votre favori.
3. Prendre plaisir.
```

Maintenant ajoutons une vidéo avec le [plugin Youtube](https://github.com/datenstrom/yellow-extensions/tree/master/features/youtube):

```
---
Title: Café est bon pour toi
Template: wiki
Tag: Exemple, Café, Vidéo
---
Le café est une boisson fabriquée à partir des haricots rôtis de l'usine de café.

1. Commencez par un café frais. Les grains de café commencent à perdre de la 
   qualité immédiatement après la torréfaction et le broyage. Le meilleur café 
   est fabriqué à partir de haricots au sol juste après la torréfaction.
2. Faites une tasse de café. Le café est préparé avec différentes méthodes 
   et des arômes supplémentaires tels que le lait et le sucre. Il existe un 
   café espresso, un filtre, une presse française, un cafetière italienne, un 
   café turc et beaucoup d'autres. Découvrez quel est votre favori.
3. Prendre plaisir.

[youtube SUpY1BT9Xf4]
```

## Afficher une sidebar

Pour afficher une sidebar (menu latéral), ajoutez le fichier `content/shared/sidebar.md`. Vous pouvez également créer un `sidebar.md` dans votre dossier de wiki, la sidebar ne sera alors affichée que sur les pages du même dossier. Voici un exemple:

```
---
Title: Sidebar
Status: hidden
---
Liens

* [Voir toutes les pages](/wiki/special:pages/)
* [Voir changements récents](/wiki/special:changes/)
* [Voir l'exemple](/wiki/tag:exemple/)
```

Vous pouvez utiliser des [raccourcis](https://github.com/datenstrom/yellow-extensions/tree/master/features/wiki#how-to-show-wiki-information) afin d'afficher des informations à propos du wiki:

```
---
Title: Sidebar
Status: hidden
---
Liens

* [Voir toutes les pages](/wiki/special:pages/)
* [Voir changements récents](/wiki/special:changes/)
* [Voir l'exemple](/wiki/tag:exemple/)

Tags

[wikitags /wiki/ 5]
```

Voici la même sidebar, si le wiki est situé sur la page d'accueil:

```
---
Title: Sidebar
Status: hidden
---
Liens

* [Voir toutes les pages](/special:pages/)
* [Voir changements récents](/special:changes/)
* [Voir l'exemple](/tag:exemple/)

[wikitags / 5]
```

## Ajuster le pied de page

Pour ajuster le pied de page, changez le fichier `content/shared/footer.md`. Vous pouvez également créer un `footer.md` dans votre dossier de wiki, le pied de page ne sera alors affiché que sur les pages du même dossier. Voici un exemple:

```
---
Title: Footer
Status: hidden
---
[Fait avec Datenstrom Yellow](https://datenstrom.se/fr/yellow/)
```

## Plus de fonctionnalités

* [Comment ajouter une table des matières à votre wiki](https://github.com/datenstrom/yellow-extensions/tree/master/features/toc)
* [Comment ajouter un moteur de recherche à votre wiki](https://github.com/datenstrom/yellow-extensions/tree/master/features/search)
* [Comment ajouter une page de contact à votre wiki](https://github.com/datenstrom/yellow-extensions/tree/master/features/contact)
* [Comment créer une page de brouillon](https://github.com/datenstrom/yellow-extensions/tree/master/features/draft)
* [Comment créer un wiki statique](server-configuration#site-web-statique)

[Suivant: Ajouter des pages →](adding-content)
