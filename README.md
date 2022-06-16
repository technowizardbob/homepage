# PHP SQLite3 Home Page

## Install

Install a web server: apache2, nginx, or other. Install PHP for web server.

PDO should also be installed....

Use your system's package manager to install SQLite3 for PHP.

Install SQLite3 for PHP, if your on a newer PHP version, change that below:

$ sudo apt-get install php8.1-sqlite3

Move folder into /var/www/homepage/ or your web folder.

## Creating Users for homepage usage

Create a sqlite3 database for each user, be sure to replace USERNAME with a name:

Note: Username must be Title case! So, ex: Bob_sql_lite3.db

$ touch USERSNAME_sql_lite3.db

$ sudo chown www-data:www-data USERNAME_sql_lite3.db

$ sudo chmod 660 USERNAME_sql_lite3.db

To setup the password of Temp with your web browser go to:

http://127.0.0.1/homepage/?name=USERNAME&new=true

#### Normal use visit yoursite via:

https://YOURSITE/homepage/?name=USERNAME
