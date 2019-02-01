---
Title: Configuration du serveur
---
Comment configurer différents serveurs web.

>>> [Vous pouvez nous aider à traduire cette page.](https://github.com/datenstrom/yellow-developers/blob/master/content/3-fr/4-help/server-configuration.md)

## Apache

Le fichier de configuration `.htaccess` pour le serveur web [Apache](http://httpd.apache.org):

```apache
<IfModule mod_rewrite.c>
RewriteEngine on

DirectoryIndex index.html yellow.php
RewriteRule ^(cache|content|system)/ error [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ yellow.php [L]
</IfModule>
```

Si votre site web ne fonctionne pas, il affiche "Datenstrom Yellow requires Apache rewrite module". Vérifiez les étapes suivantes. Ajoutez `RewriteBase` au fichier de configuration, ceci résoudra la plupart des problèmes de serveur web Apache. Voici un exemple pour un sous-dossier:

```apache
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteBase /yellow/
DirectoryIndex index.html yellow.php
RewriteRule ^(cache|content|system)/ error [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ yellow.php [L]
</IfModule>
```

Si votre site web ne fonctionne toujours pas et se plaint du module rewrite, vérifiez du côté du serveur web Apache. Vous devez probablement activer le [module rewrite](https://stackoverflow.com/questions/869092/how-to-enable-mod-rewrite-for-apache-2-2) et configurer `AllowOverride All` dans les [paramètres du serveur web](https://stackoverflow.com/questions/18740419/how-to-set-allowoverride-all). 

Si l'accès aux fichiers ne fonctionne pas, il affiche "Datenstrom Yellow requires Apache read/write access". Assurez-vous que le serveur web est accès en écriture et en lecture aux fichiers. Vous pouvez ajuster les [droits de permissions](https://superuser.com/questions/51838/recursive-chmod-rw-for-files-rwx-for-directories) sur les fichiers avec la commande `chmod -R a+rw *`. Vous pouvez également assigner le groupe `www-data` et `umask 002` au serveur web et aux utilisateurs.

Si vous avez un [site web statique](#site-web-statique), vous devez utiliser le fichier de configuration suivant:

```apache
ErrorDocument 404 /404.html
```

## Nginx

Le fichier de configuration `nginx.conf` pour le serveur web [Nginx](https://nginx.org/):

```nginx
server {
    listen 80;
    server_name website.com;
    root /var/www/website/;
    index index.html yellow.php;

    location /cache {
        rewrite ^(.*)$ /error break;
    }

    location /content {
        rewrite ^(.*)$ /error break;
    }

    location /system {
        rewrite ^(.*)$ /error break;
    }

    location / {
        if (!-e $request_filename) {
            rewrite ^/(.*)$ /yellow.php last;
            break;
        }
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index yellow.php;
        include fastcgi_params;
    }
}
```

Si votre site web ne fonctionne pas, il affiche "Datenstrom Yellow requires Nginx rewrite module". Vérifiez `server_name` et `root` dans le fichier de configuration. Lorsque vous modifiez le fichier de configuration, vous devez [redémarrer](https://stackoverflow.com/questions/21292533/reload-nginx-configuration) le serveur web Nginx.

Si l'accès aux fichiers ne fonctionne pas, il affiche "Datenstrom Yellow requires Nginx read/write access". Assurez-vous que le serveur web est accès en écriture et en lecture aux fichiers. Vous pouvez ajuster les [droits de permissions](https://superuser.com/questions/51838/recursive-chmod-rw-for-files-rwx-for-directories) sur les fichiers avec la commande `chmod -R a+rw *`. Vous pouvez également assigner le groupe `www-data` et `umask 002` au serveur web et aux utilisateurs.

Si vous avez un [site web statique](#site-web-statique), vous devez utiliser le fichier de configuration suivant:

```nginx
server {
    listen 80;
    server_name website.com;
    root /var/www/website/;
    error_page 404 /404.html;
}
```

## Site web statique

Si vous souhaitez créer un site web statique, utilisez le générateur de site statique. Ceci est fait en exécutant une commande de construction depuis le dossier d'installation. Il génère un site web statique, qui fonctionne sur presque tous les serveurs web.

Vous pouvez créer un site statique depuis une interface en [ligne de commande](https://github.com/datenstrom/yellow-plugins/tree/master/command).

1. Lancez un terminal.
2. Rendez-vous dans le dossier d'installation, où se trouve `yellow.php`.
3. Tapez la commande suivante: `php yellow.php build`

Ceci construira votre site statique dans le dossier `public`. Placez ce dossier sur votre espace d'hébergement, et contruisez une nouvelle version lorsque c'est nécessaire. L'URL peut être défini dans les [paramètres du système](adjusting-system#paramètres-du-système), par exemple `StaticUrl: http://website/`.

Vous pouvez tester un site web statique sans le télécharger sur un serveur web. Ceci est pratique pour les développeurs web, puisque tout fonctionne sur votre propre ordinateur. Voici un exemple: `php yellow.php serve`. Le site web est accessible à l'adresse `http://localhost:8000`.

Comme alternative à un site statique, vous pouvez créer un cache. Cela accélère considérablement votre site web, mais le cache doit être mis à jour. Voici un exemple: `php yellow.php build cache`. Pour effacer le cache, tapez la commande suivante: `php yellow.php clean cache`.

[Suivant: API pour les développeurs →](api)