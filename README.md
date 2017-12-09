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

file conf in sites-availables
```apacheconf
<VirtualHost *:80>
	
	ServerName base.local
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/html/base
	
	<Directory /var/www/html/base>
	    Options Indexes FollowSymLinks MultiViews
	    AllowOverride All
	    Order allow,deny
	    allow from all
	</Directory>
</VirtualHost>

```

## Credit
  
Basato su:
- [ToroPHP](https://github.com/anandkunal/ToroPHP)
