---
Title: Markdown antisèche
Sidebar: none
---
Markdown est un moyen pratique pour éditer des pages web.

## Les bases

Formatage du texte:

    Normal **gras** *italique* `code`

Créer une liste:

    * point une
    * point deux
    * point trois

Créer une liste ordonnée:

    1. point une
    2. point deux
    3. point trois

Créer un titre:

    # Titre 1
    ## Titre 2
    ### Titre 3

Créer des citations:

    > Voici une citation
    >> Voici une citation d'une citation
    >>> Voici une citation d'une citation d'une citation

Créer des liens:

    [Lien vers une page](/fr/help/how-to-make-a-website)  
    [Lien vers le fichier](/media/downloads/yellow.pdf)  
    [Lien vers un site](https://datenstrom.se/fr/)  

Ajouter des images:

    [image picture.jpg]
    [image picture.jpg Picture]
    [image picture.jpg "Ceci est un exemple d'image"]

Ajouter des images, autre moyen:

    ![image](picture.jpg)
    ![image](picture.jpg "Picture")
    ![image](picture.jpg "Ceci est un exemple d'image")

## Extras

Créer des tables:

    | Café       | Lait | Force  |
    |------------|------|--------|
    | Espresso   | non  | forte  |
    | Macchiato  | oui  | moyen  |
    | Cappuccino | oui  | faible |

Créer des notes de bas de page:

    Texte avec une note de bas de page[^1] et quelques autres notes de bas de page.[^2] [^3]
    
    [^1]: Voici la première note de bas de page
    [^2]: Voici la deuxième note de bas de page
    [^3]: Voici la troisième note de bas de page

Créer des paragraphes:

    Voici le premier paragraphe. Le texte peut s'étendre sur plusieurs lignes
    et peut être séparé par une ligne vierge du paragraphe suivant.
    
    Voici le deuxième paragraphe.

Créer des sauts de ligne:

    Voici la première ligne⋅⋅
    Voici la deuxième ligne⋅⋅
    Voici la troisième ligne⋅⋅
    Les espaces à la fin de la ligne sont affichés avec des points (⋅)

En utilisant des blocs de code:

    ```
    Code source dans un bloc de code sera affiché inchangé.
    function onLoad($yellow) {
        $this->yellow = $yellow;
    }
    ```

En utilisant des blocs HTML:

    <div class="custom">
    <strong>Texte avec HTML</strong> peut être utilisé en option.
    <a href="https://datenstrom.se/fr/">Lien vers un site</a>.
    </div>

## Raccourcis

`[image picture.jpg Picture - 50%]` = [ajouter des miniatures](https://github.com/datenstrom/yellow-extensions/tree/master/features/image)  
`[gallery photo.*jpg - 20%]` = [ajouter des galeries](https://github.com/datenstrom/yellow-extensions/tree/master/features/gallery)  
`[slider photo.*jpg]` = [ajouter des galeries avec slider](https://github.com/datenstrom/yellow-extensions/tree/master/features/slider)  
`[youtube fhs55HEl-Gc]` = [intégrer des vidéos Youtube](https://github.com/datenstrom/yellow-extensions/tree/master/features/youtube)  
`[vimeo 13387502]` = [intégrer des vidéos Vimeo](https://github.com/datenstrom/yellow-extensions/tree/master/features/vimeo)  
`[soundcloud 101175715]` = [intégrer des audio Soundcloud](https://github.com/datenstrom/yellow-extensions/tree/master/features/soundcloud)  
`[twitter datenstromse]` = [intégrer des messages Twitter](https://github.com/datenstrom/yellow-extensions/tree/master/features/twitter)  
`[instagram BISN9ngjV2-]` = [intégrer une photo Instagram](https://github.com/datenstrom/yellow-extensions/tree/master/features/instagram)  
`[googlecalendar fr.french#holiday]` = [intégrer un calendrier Google](https://github.com/datenstrom/yellow-extensions/tree/master/features/googlecalendar)  
`[googlemaps Stockholm]` = [intégrer une carte Google](https://github.com/datenstrom/yellow-extensions/tree/master/features/googlemaps)  
`[blogchanges /blog/]` = [afficher des dernières pages du blog](https://github.com/datenstrom/yellow-extensions/tree/master/features/blog)  
`[wikichanges /wiki/]` = [afficher des dernières pages du wiki](https://github.com/datenstrom/yellow-extensions/tree/master/features/wiki)  
`[fa fa-envelope-o]` = [afficher des icones et symboles](https://github.com/datenstrom/yellow-extensions/tree/master/features/fontawesome)  
`[ea ea-smile]` = [afficher des emoji et images coloréess](https://github.com/datenstrom/yellow-extensions/tree/master/features/emojiawesome)  
`[yellow]` = [afficher des informations sur le site](https://github.com/datenstrom/yellow-extensions/tree/master/features/core)  
`[edit]` = [éditer le site depuis le navigateur](https://github.com/datenstrom/yellow-extensions/tree/master/features/edit)  
`[toc]` = [afficher une table des matières](https://github.com/datenstrom/yellow-extensions/tree/master/features/toc)  
`[--more--]` = [ajouter un saut de page](https://github.com/datenstrom/yellow-extensions/tree/master/features/blog) 

## Paramètres

`Title` = titre de la page  
`TitleContent` = titre de la page affichée dans le contenu  
`TitleNavigation` = titre de la page affichée dans la navigation  
`TitleHeader` = titre de la page affichée dans la navigateur web  
`TitleSlug` = titre de la page utilisé pour enregistrer la page  
`Description` = description de la page  
`Keywords` = mots clés de la page, séparés par des virgules  
`Author` = auteur(s) de la page, séparés par des virgules  
`Language` = langue de la page  
`Layout` = modèle de la page  
`LayoutNew` = modèle pour créer une nouvelle page  
`Theme` = thème de la page  
`Parser` = parser de la page  
`Modified` = date de modification de la page, format YYYY-MM-DD  
`Published` = date de publication de la page, format YYYY-MM-DD  
`Tag` = mots-clés pour la catégorisation, séparés par des virgules  
`Redirect` = redirection vers une page ou une URL  
`Status` = état de la page  
`Navigation` = menu de navigation pour la page  
`Header` = en-tête de la page  
`Footer` = pied de la page  
`Sidebar` = sidebar de la page  
`Sitename` = nom su site web  
`Email` = email du webmaster  
