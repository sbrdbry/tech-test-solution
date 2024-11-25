# A Tech-Test Solution

## Introduction

This is an MVC application using the Zend Framework MVC layer and module
systems. This application is a suggested solution to a technical test.
A reference to the deliverables is available [here](https://github.com/sbrdbry/tech-test-solution/blob/main/DELIVERABLES.md).


### Installation on Ubuntu 16.04 LTS

###### Dependencies:

```bash
sudo apt -y install php7.0-fpm php-mbstring php-dom php-intl zip unzip php7.0-zip
```

The easiest way to deploy the project is to use
[Composer](https://getcomposer.org/).  If you don't have it already installed,
then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

```bash
sudo apt -y install composer
```

###### Clone the project:

```bash
$ git clone https://github.com/sbrdbry/reimagined-octo-waddle.git
```

###### Move it to your web directory:

```bash
sudo mv reimagined-octo-waddle /var/www/html
```

###### Change into the directory:

```bash
cd /var/www/html/reimagined-octo-waddle
```

###### Change the owner of the data directory:

```bash
sudo chown -R $USER:www-data data
```

###### Install using Composer:

```bash
$ composer clear-cache
$ composer install
```

###### You can choose option 1 when prompted:

```bash
  Please select which config file you wish to inject 'Zend\Session' into:
  [0] Do not inject
  [1] config/modules.config.php
```



## Database Setup MySQL

```bash
sudo apt-get install mysql-server php7.0-mysql
```

The database schema:

```sql
-- data/fixtures_mysql.sql

DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS jobrole;

CREATE TABLE jobrole
(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name varchar(50) NOT NULL
) ENGINE=INNODB;

INSERT INTO jobrole (name)
VALUES
("Developer"),
("Project Manager");

CREATE TABLE people
(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname varchar(30) NOT NULL,
lastname varchar(30) NOT NULL,
email varchar(50) NOT NULL,
job_role INT(6) UNSIGNED NOT NULL,
FOREIGN KEY (job_role)
  REFERENCES jobrole(id)
) ENGINE=INNODB;

INSERT INTO people (firstname, lastname, email, job_role)
VALUES
("Jo", "Strummer", "mail+j+strummer@example.com", 1),
("Mick", "Jones", "mail+m+jones@example.com", 2),
("Pauline", "Black", "mail+p+black@example.com", 1),
("Topper", "Headon", "mail+t+headon@example.com", 1),
("Stuart", "Bradbury", "mail+s+bradbury@example.com", 1);
```

###### Launch MySQL:

```bash
mysql -uroot -p
```

###### Create database:

```bash
CREATE DATABASE demo;
CREATE USER 'demouser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON demo.* TO 'demouser'@'localhost';
```

###### Switch to it:

```bash
use demo;
```

Copy & Paste the schema into the cli.

###### Add database credentials:

```php
// config/autoload/global.php
return array(
	'db' => array(
		'driver'         => 'Pdo',
		'dsn'            => 'mysql:dbname=demo;host=127.0.0.1',
		'username'       => 'demouser',
		'password'       => 'password',
	),
	// ...
);
```

## Test it out


Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public/ public/index.php
# OR use the composer alias:
$ composer serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/
- which will bring up the welcome page.

**Note:** The built-in CLI server is *for development only*.

_For other installation options visit [this](https://github.com/zendframework/ZendSkeletonApplication)._

### Web server setup

#### Apache

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName zfapp.localhost
    DocumentRoot /path/to/zfapp/public
    <Directory /path/to/zfapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```
