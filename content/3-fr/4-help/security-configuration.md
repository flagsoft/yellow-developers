---
Title: Configuration de la sécurité
---
Comment configurer la sécurité et la confidentialité.

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/security-configuration.md)

## Chiffrement des données

Pensez à vérifier que votre site web supporte [chiffrement des données](https://www.ssllabs.com/ssltest/). S'il y a des problèmes, contacter votre fournisseur d'hébergement web. Il est préférable que votre site web redirige automatiquement HTTP vers HTTPS et que la connexion Internet soit toujours cryptée.

## Restrictions de connexion

Si vous ne voulez pas créer de compte d'utilisateurs dans le navigateur, restreignez le [login](https://github.com/datenstrom/yellow-extensions/tree/master/features/edit). Ouvrez le fichier `system/settings/system.ini` et modifiez `EditLoginRestrictions: 1`. Les utilisateurs sont autorisés à se connecter, mais ne peuvent pas créer de nouveaux comptes utilisateur.

## Restrictions d'utilisateur

Si vous ne voulez pas que les pages soient modifiées, restreignez les [compte d'utilisateurs](adjusting-system#comptes-d-utilisateurs). Ouvrez le fichier `system/settings/user.ini` et à la fin de la ligne de changer la page d'accueil. Les utilisateurs sont autorisés à modifier des pages dans leur page d'accueil, mais nulle part ailleurs.

## Mode de sécurité

Si vous souhaitez protéger votre site web contre les nuisances, restreignez les autres fonctionnalités. Ouvrez le fichier `system/settings/system.ini` et changez `SafeMode: 1`. Les utilisateurs sont autorisés à utiliser [Markdown](markdown-cheat-sheet), mais HTML et d'autres fonctionnalités sont limitées.

[Suivant: Configuration du serveur →](server-configuration)