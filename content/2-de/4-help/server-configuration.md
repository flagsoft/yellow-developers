---
Title: Servereinstellungen
---
Wie man unterschiedliche Webserver konfiguriert.

## Apache

Die `.htaccess` Konfigurationsdatei für den [Apache](http://httpd.apache.org)-Webserver:

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

Wenn deine Webseite nicht funktioniert, wird angezeigt "Datenstrom Yellow requires Apache rewrite module". 
Überprüfe bitte die folgenden Schritte. Füge `RewriteBase` zur Konfigurationsdatei hinzu, das behebt die meisten Apache-Webserverprobleme. Hier ist ein Beispiel für ein Unterverzeichnis:

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

Wenn deine Webseite immer noch nicht funktioniert und sich über das Rewrite-Module beschwert, dann überprüfe bitte den Apache-Webserver. Du musst vermutlich das [Rewrite-Modul](https://stackoverflow.com/questions/869092/how-to-enable-mod-rewrite-for-apache-2-2) aktivieren und `AllowOverride All` in den [Webserver-Einstellungen](https://stackoverflow.com/questions/18740419/how-to-set-allowoverride-all) konfigurieren.

Wenn der Dateizugriff nicht funktioniert, wird angezeigt "Datenstrom Yellow requires Apache read/write access". Stelle sicher dass der Webserver Dateien lesen und schreiben kann. Du kannst [Schreibrechte](https://superuser.com/questions/51838/recursive-chmod-rw-for-files-rwx-for-directories) für Dateien manuell angleichen, zum Beispiel mit `chmod -R a+rw *`. Als Alternative kannst du Webserver und Benutzern die Gruppe `www-data` und `umask 002` zuweisen.

Wenn man eine [statische Webseite](#statische-webseite) hat, sollte man die folgende Konfigurationsdatei benutzen:

```apache
ErrorDocument 404 /404.html
```

## Nginx

Die `nginx.conf` Konfigurationsdatei für den [Nginx](https://nginx.org/)-Webserver:

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

Wenn deine Webseite nicht funktioniert, wird angezeigt "Datenstrom Yellow requires Nginx rewrite module". Überprüfe bitte `server_name` und `root` in der Konfigurationsdatei. Falls die Konfigurationsdatei verändert wurde, musst du den Nginx-Webserver [neustarten/neuladen](https://stackoverflow.com/questions/21292533/reload-nginx-configuration).

Wenn der Dateizugriff nicht funktioniert, wird angezeigt "Datenstrom Yellow requires Nginx read/write access". Stelle sicher dass der Webserver Dateien lesen und schreiben kann. Du kannst [Schreibrechte](https://superuser.com/questions/51838/recursive-chmod-rw-for-files-rwx-for-directories) für Dateien manuell angleichen, zum Beispiel mit `chmod -R a+rw *`. Als Alternative kannst du Webserver und Benutzern die Gruppe `www-data` und `umask 002` zuweisen.

Wenn man eine [statische Webseite](#statische-webseite) hat, sollte man die folgende Konfigurationsdatei benutzen:

```nginx
server {
    listen 80;
    server_name website.com;
    root /var/www/website/;
    error_page 404 /404.html;
}
```

## Statische Webseite

Falls man eine statische Webseite erstellen will, benutzt man den Static-Site-Generator. Dazu führt man einen Build-Befehl im Installations-Verzeichnis aus. Daraufhin wird eine statische Webseite erstellt, die auf fast jedem Webserver funktioniert.

Du kannst eine statische Webseite in der [Befehlszeile](https://github.com/datenstrom/yellow-plugins/tree/master/command) erstellen:

1. Öffne ein Terminal-Fenster.
2. Gehe ins Installations-Verzeichnis, dort wo sich die `yellow.php` befindet.
3. Gib die folgende Zeile ein: `php yellow.php build`

Das erstellt eine statische Webseite im `public`-Verzeichnis. Lade das Verzeichnis auf dein Webserver hoch und erstelle bei Bedarf eine neue Webseite. Die URL deiner Webseite kannst du in den [Systemeinstellungen](adjusting-system#systemeinstellungen) festlegen, zum Beispiel `StaticUrl: http://website/`. 

Man kann eine statische Webseite auch testen, ohne sie auf einen Webserver hochzuladen. Das ist vor allem für Entwickler praktisch, da alles auf dem eigenem Computer läuft. Hier ist ein Beispiel: `php yellow.php serve`. Daraufhin ist die Webseite vorhanden als `http://localhost:8000`.

Als Alternative zu einer statischen Webseite kannst du einen Cache erstellen. Das beschleunigt deine Webseite deutlich, jedoch muss der Cache immer wieder aktualisiert werden. Hier ist ein Beispiel: `php yellow.php build cache`. Zum Löschen gibt man ein: `php yellow.php clean cache`.

[Weiter: Spracheinstellungen →](language-configuration)