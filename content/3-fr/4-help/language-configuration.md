---
Title: Configuration de la langue
---
Comment configurer les langues.

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/language-configuration.md)

## Le mode uni-langue

L'installation est fournie avec trois langues et vous pouvez [télécharger plus de de langues](https://github.com/datenstrom/yellow-extensions/tree/master/languages). La langue par défaut est définie dans [paramètres du système](adjusting-system#paramètres-du-système). Une langue différente peut être définie dans les [paramètres](markdown-cheat-sheet#paramètres) en haut de chaque page, par exemple `Language: fr`.

Voici une page en anglais:

```
---
Title: About us
Language: en
---
Birds of a feather flock together.
```

Une page en allemand:

```
---
Title: Über uns
Language: de
---
Wo zusammenwächst was zusammen gehört.
```

Une page en français:

```
---
Title: À propos de nous
Language: fr
---
Les oiseaux de même plumage volent toujours ensemble.
```

## Le mode multi-langage

Pour les sites web multilingues, vous pouvez utiliser le mode multi-langage. Ouvrez le fichier `system/settings/system.ini` et modifiez `MultiLanguageMode: 1`. Puis rendez-vous dans votre dossier `content` et créez un nouveau dossier pour chaque langue. Voici un exemple:

[image screenshot-language1.png Screenshot]

Cette capture d'écran montre les dossiers `1-en`, `2-de` et `3-fr`. Celà donne accès aux URLs suivantes: `http://website/` `http://website/de/` `http://website/fr/` pour respectivement l'anglais, l'allemand et le français. Voici un autre exemple:

[image screenshot-language2.png Screenshot]

Ici nous voyons les dossiers `1-en`, `2-de`, `3-fr` et `default`. Celà donne accès aux URLs suivantes `http://website/en/` `http://website/de/` `http://website/fr/` ainsi qu'une page d'accueil à `http://website/` qui détectera automatiquement la langue pour le visiteur.

Pour afficher une [sélection de langue](/language/), vous pouvez créer une page qui répertorie les langues disponibles. Cela permet aux visiteurs de choisir leur langue. La sélection de la langue peut être intégrée à votre site web, par exemple dans la navigation ou le pied de page.

[Suivant: Configuration de la sécurité →](security-configuration)