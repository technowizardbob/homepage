# PHP SQLite3 Home Page

## Install

PDO should be installed....

Install SQLite3 for PHP, if your on a newer PHP version, change that below:

$ sudo apt-get install php7.4-sqlite3

Move folder into /var/www/homepage/ or your web folder.

## Creating Users for homepage usage

Create a sqlite3 database for each user, be sure to replace USERNAME with a name:

Note: Username must be Title case! So, ex: Bob_sql_lite3.db

$ touch USERSNAME_sql_lite3.db

$ sudo chown www-data:www-data USERNAME_sql_lite3.db

$ sudo chmod 660 USERNAME_sql_lite3.db

To setup the password of Temp: goto http://127.0.0.1/homepage/?name=USERNAME&new=true

#### Normal use visit yoursite via:

https://YOURSITE/homepage/?name=USERNAME
