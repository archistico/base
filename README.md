# Route

Implementazione gestione route con coda in mysql.

## Install

1. Copia i file nel tuo server
2. Crea un db chiamato `routequeue` e inviagli `routequeue.sql` 
4. Sistema i dati di accesso in `lib/mysql.php`

## Server

.htaccess file  

```apacheconf
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond $1 !^(index\.php)
RewriteRule ^(.*)$ /index.php/$1 [L]
```