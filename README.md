# Route

Implementazione gestione route con coda in mysql.

## Install

1. Copy this directory to your server/virtual host root
2. Create a database called `routequeue` and execute the `routequeue.sql` dump
4. Adjust your MySQL database/user information in `lib/mysql.php`

## Server

.htaccess file  

```apacheconf
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond $1 !^(index\.php)
RewriteRule ^(.*)$ /index.php/$1 [L]
```