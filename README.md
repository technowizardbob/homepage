# PHP SQLite3 Home Page

PDO should be installed....

Install SQLite3 for PHP, if your on a newer PHP version, change that below:

$ sudo apt-get install php7.4-sqlite3

Move folder into /var/www/homepage/ or your web folder.

Create a sqlite3 database for each user, be sure to replace USERNAME with a name:

$ touch USERSNAME_sql_lite3.db

$ sudo chown www-data:www-data USERNAME_sql_lite3.db

$ sudo chmod 664 USERNAME_sql_lite3.db

To setup the password of Temp: goto http://127.0.0.1/homepage/?name=USERNAME&new=true

## Normal use visit yoursite and do https://YOURSITE/homepage/?name=USERNAME
