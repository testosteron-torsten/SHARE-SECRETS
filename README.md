# SHARE SECRETS

_Share Secrets is an open source project to securly share passwords or other sensitive sorts of text over the internet.
The data is stored in the database and gets encrypted and decrypted by PHP. The data is only stored encrypted in the database. However, we strongly recommend using an SSL certificate._

## Dependencies

- Linux
- PHP
- MySQL, MariaDB or PostgreSQL
- Apache2

## Installation

### Database

After you successfully installed PHP, Apach2 and MySQL, you have to create a new Database.
You are free to choose the database name and username.

```bash
  mysql -u root -p
  CREATE DATABASE db_share;
  CREATE USER 'share_user'@'localhost' IDENTIFIED BY 'password';
  GRANT ALL PRIVILEGES ON db_share.* TO 'share_user'@'localhost';
  FLUSH PRIVILEGES;
  Exit;

```

Login with the new user and check if you have permissions to the Database you have just created.
Then switch to the Database and insert the SQL statements from the _database.sql_ File.

```bash
  mysql -u share_user -p
  SHOW DATABASES;
  USE db_share;

  CREATE TABLE passwords(
    secret VARCHAR(255) NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    code VARCHAR(255) NOT NULL
    );

```

### Config

It doesn't matter if you use virtual hosts or not. Copy the entire directory into your web server directory.
Then open the _config.php_ file and make some changes:

```bash
  vim /var/www/html/config.php
```

Change the Database name.

```bash
  $DB_NAME = "db_share";
```

Change the Database username.

```bash
  $DB_USER = "share_user";
```

Change the password for the Database user.

```bash
  $DB_PASS = "password";
```

Change the DSN if you use PostgreSQL to _pgsql_ leave it like it is if you use MySQL or MariaDB.

```bash
  $DSN = "mysql:host=localhost;dbname=$DB_NAME";
```

Change the URL to your Domain.

```bash
  $URL = "yourdomain.com";
```

Change the site title if you want.

```bash
  $TITEL = "SHARE SECRETS";
```

Change the key to some random chars, it does not matter how long it is.

```bash
  $key = 'kljgljdg762!%&HGA&"HJDdb3HAU3zuduhguFZTA';
```

### Personalize

If you want, you can change the colors, fonts and image. The button colors you can find in
_index-style.css_ and _secret-style.css_, also the fonts are defined there. The Image link is defined in the main tag
part of _index.php_ and _secret.php_.

### Creating a Cronjob

To check if a link has expired, we need to create a cronjob for _expireation-checker.php_, you can also change the expiry cycle by simply change the days in _expireation-checker.php_

```bash
  $date = date('Y-m-d', strtotime('-30 days'));
```

Now, lets create the Cronjob.

```bash
  crontab -e
```

```bash
  */10 * * * * /usr/bin/php /var/www/sites/secret/expireation-checker.php
```

### Finish

Your are done! Have fun with SHARE SECRET!
