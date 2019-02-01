---
Title: Configuration de la sécurité
---
Comment configurer la sécurité et la confidentialité.

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/security-configuration.md)

## Chiffrement des données

Pensez à vérifier que votre site web supporte [chiffrement des données](https://www.ssllabs.com/ssltest/). S'il y a des problèmes, contacter votre fournisseur d'hébergement web. Il est préférable que votre site web redirige automatiquement HTTP vers HTTPS et que la connexion Internet soit toujours cryptée.

## Restrictions de connexion

Si vous ne voulez pas créer de compte d'utilisateurs dans le navigateur, restreignez le [login](https://github.com/datenstrom/yellow-plugins/tree/master/edit). Ouvrez le fichier `system/config/config.ini` et modifiez `EditLoginRestrictions: 1`. Les utilisateurs sont autorisés à se connecter, mais pas à créer des comptes d'utilisateurs.

## Restrictions d'utilisateur

Si vous ne voulez pas que les pages soient modifiées dans le navigateur, restreignez les [compte d'utilisateurs](adjusting-system#comptes-d-utilisateurs). Ouvrez le fichier `system/config/user.ini` et à la fin de la ligne de changer la page d'accueil. Les utilisateurs ne peuvent éditer uniquement que leur page d'accueil.

## Mode de sécurité

Si vous souhaitez protéger votre site web contre les nuisances, restreignez les autres fonctionnalités. Ouvrez le fichier `system/config/config.ini` et changez `SafeMode: 1`. Les utilisateurs ne sont plus autorisés à utiliser HTML et JavaScript, [Markdown](markdown-cheat-sheet) et d'autres fonctionnalités sont restreintes.

[Suivant: Configuration du serveur →](server-configuration)