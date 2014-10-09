## Projectify - get stuff done

[Projectify](https://proj.ectify.com) is a todo-list manager that's laser-focused on digitizing your responsibilities and getting them done.

## Installation

''Note: installation instructions were written for installation on debian-based Linux distributions, namely Ubuntu.  Pull-requests of instructions for other platforms are welcome if you'd like to help!''

# Install and configure Git, Apache, PHP and MySQL

I've put these here for the convenience of those who aren't too comfortable with any of these tools.  Most of you probably use these already and can skip this part.

## 1. Install any of the following you do not already have
What we're doing in this crazy long command is
-Make sure python-software-properties is installed so we can:
-Add the ondrej/php5-5.6 PPA so we can install php 5.6 from package
-Install the remaining packages we need

```
sudo apt-get update && sudo apt-get -y install python-software-properties && sudo add-apt-repository -y ppa:ondrej/php5-5.6 && sudo apt-get update && sudo apt-get -y upgrade && sudo apt-get -y dist-upgrade && sudo apt-get -y install php5 php5-mysql php5-mcrypt mysql-server apache2 libapache2-mod-php5 git
```

This should all happen in the background except if you didn't already have MySQL Server installed, you will be prompted to set the root password.  Pick a good one and don't lose it!

Verify that you are now running PHP 5.6:
```
php --version
```

And after all of that it's probably a good idea to restart the server if you can:
```
sudo shutdown -r now
```

## 2. Install composer if needed
Make sure you start in a directory where you have write privileges
```
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer self-update
```

## 3. Clone the repository (or your own fork of the repository if you plan to contribute) into your preferreed <projectify_root> and copy 
```
cd <parent_of_projectify_root>
git clone git@github.com:BBBThunda/projectify.git
cp <projectify_root>/projectify.conf /etc/apache2/sites-available
```

## 4. Configure an Apache virtual host
Edit /etc/apache2/sites-available/projectify.conf so that ServerName is whatever you plan to type into your browser to access the site and point DocumentRoot to your <projectfy_root>/public folder.  If you're not familiar with apache virtual hosts, do the following:
- Copy the default site file
```
sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/projectify.conf
```
- Edit the projectify.conf file:
 - Add a ServerName directive where 'hostname' is the host you plan to type into your browser to access the test site:
```
ServerName hostname
```
 - Change the <directory> tag pointing to /var/www/html (if one exists) and point it to <projectify_root>/public/
 - It's recommended you also change the error.log filename to something like projectify_error.log
- If you are not using an existing hostname like localhost or some name your DNS server understands, add the new hostname to your /etc/hosts file under 127.0.0.1 (localhost is probably there already, just add a space, followed by your ServerName).

## 5. Enable modules, disable the default site (if enabled by default), enable projectify.conf and restart apache.
```
sudo php5enmod mcrypt
sudo php5enmod pdo_mysql
sudo a2enmod rewrite
sudo a2dissite 000-default
sudo a2ensite projectify
sudo service apache2 restart
```

Now it's time to set up your environment in Laravel.

# Setting up your environment and migrating the DB

## 1. Copy and edit default config files and make storage directory writeable
Basically you want to find all of the files with .default.php and remove the .default.  In the case of the env.default files in the projectify_root> directory, you also want to prepend a dot. So copy the files and then edit them to fit your environment:
```
cd <projectify_root>
cp env.dev.default.php .env.dev.php
cp bootstrap/start.default.php bootstrap/start.php
chmod 777 app/storage/*
```

Note: env.live.default.php can be ignored since we only use the "live" environment if the request domain is proj.ectify.com

## 2. Do a composer update in your repository to download dependencies.
```
cd <projectify_root>
composer update
```

This will download all of the dependencies required for projectify, including those required for Laravel and store them in the "vendor" directory.

## 3. Initialize the database

Create the database and the mysql user. Call them whatever you want, (here we will call both projectify_dev) just make sure .env.dev.php has the correct name, password, host, db, etc.  Login to mysql as root or a user with root privileges or at least the ability to create users and databases and to grant privileges.

- Create the database as root (remember the password you set up earlier)
```
mysqladmin -u root -p create projectify_dev
```

- Log in as root
```
mysql -u root -p
```

- Create user and grant privileges (change 'password' before pasting into terminal)
```
CREATE USER 'projectify_dev'@localhost IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON projectify_dev . * TO 'projectify_dev'@'localhost';
FLUSH PRIVILEGES;
quit
```

- If you want you can verify the user was created correctly
```
mysql -u projectify_dev -p
```

If this is confusing, [this tutorial](https://www.digitalocean.com/community/tutorials/how-to-create-a-new-user-and-grant-permissions-in-mysql) might be helpful, or check the MySQL documentation.

Also, if you use PHPMyAdmin, there is an option to create a new user that includes a checkbox to automatically create a new db with the same name and grant all privs like we did above.

## 4. Run the migrations and seed the database.  If you have set up the database and environment correctly, you should be able to  run the following command from the <projectify_home> directory:

```
php artisan migrate --seed
```

# Contributing To Projectify

**All issues and pull requests should be filed on the [bbbthunda/projectify](http://github.com/bbbthunda/projectify) repository.**

See CONTRIBUTING.md for more details.

# License

Projectify is open-sourced software licensed under the [GNU General Public License Ver 3.0 (GPLv3)](https://www.gnu.org/licenses/quick-guide-gplv3.html) *see LICENSE.txt*
