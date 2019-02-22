---
Title: Server configuration
---
Here's how to set up different web servers.

## Apache

The `.htaccess` configuration file for the [Apache](http://httpd.apache.org) web server:

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

When your website doesn't work, it shows "Datenstrom Yellow requires Apache rewrite module". Please check the following steps. Add `RewriteBase` to your configuration file, this will fix most Apache web server problems. Here's an example for a subfolder:

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

When your website still doesn't work and complains about the rewrite module, then please check the Apache web server. You probably have to enable the [rewrite module](https://stackoverflow.com/questions/869092/how-to-enable-mod-rewrite-for-apache-2-2) and configure `AllowOverride All` in the [web server settings](https://stackoverflow.com/questions/18740419/how-to-set-allowoverride-all). 

When file access doesn't work, it shows "Datenstrom Yellow requires Apache read/write access".
Make sure that the web server can read and write files. You can manually adjust [file permissions](https://superuser.com/questions/51838/recursive-chmod-rw-for-files-rwx-for-directories) so that the web server can overwrite files, for example with command `chmod -R a+rw *`. As an alternative you can assign the group `www-data` and `umask 002` to the web server and users.

When you have a [static website](#static-website) you should use the following configuration file:

```apache
ErrorDocument 404 /404.html
```

## Nginx

The `nginx.conf` configuration file for the [Nginx](https://nginx.org/) web server:

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

When your website doesn't work, it shows "Datenstrom Yellow requires Nginx rewrite module".
Please check `server_name` and `root` in the configuration file. If the configuration file has been changed, you need to [restart/reload](https://stackoverflow.com/questions/21292533/reload-nginx-configuration) the Nginx web server.

When file access doesn't work, it shows "Datenstrom Yellow requires Nginx read/write access". Make sure that the web server can read and write files. You can manually adjust [file permissions](https://superuser.com/questions/51838/recursive-chmod-rw-for-files-rwx-for-directories) so that the web server can overwrite files, for example with command `chmod -R a+rw *`. As an alternative you can assign the group `www-data` and `umask 002` to the web server and users.

When you have a [static website](#static-website) you should use the following configuration file:

```nginx
server {
    listen 80;
    server_name website.com;
    root /var/www/website/;
    error_page 404 /404.html;
}
```

## Static website

If you want to create a static website, use the static site generator. This is done by running a build command from within the installation folder. It generates a static website, that works on almost any web server.

You can create a static website from the [command line](https://github.com/datenstrom/yellow-extensions/tree/master/features/command):

1. Open a terminal window.
2. Go to your installation folder, where the `yellow.php` is.
3. Type the following line: `php yellow.php build`

This will build a static website in the `public` folder. Upload the folder to your web server and build a new version when needed. The URL of the website can be defined in the [system settings](adjusting-system#system-settings), for example `StaticUrl: http://website/`.

As an alternative to a static website you can build a cache. This speeds up your website significantly, but the cache needs to be updated repeatedly. Here's an example: `php yellow.php build cache`. To clean the cache type the following line: `php yellow.php clean cache`.

You can test a static website without uploading it to a web server. Start the built-in web server. This is especially handy for [developers](api), since everything runs on your own computer. Here's an example: `php yellow.php serve`. Now the website is available as `http://localhost:8000`.

[Next: API for developers →](api)