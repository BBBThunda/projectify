# Install and configure Git, Apache, PHP and MySQL

*Note: installation instructions were written for installation on debian-based Linux distributions, namely Ubuntu.  Pull-requests of instructions for other platforms are welcome if you'd like to help!*

## 1. Install any of the following you do not already have
What we're doing in this crazy long command is
- Make sure python-software-properties is installed so we can:
- Add the ondrej/php5-5.6 PPA so we can install php 5.6 from package
- Install the remaining packages we need

```
sudo apt-get update && sudo apt-get -y install python-software-properties && sudo add-apt-repository -y ppa:ondrej/php5-5.6 && sudo apt-get update && sudo apt-get -y upgrade && sudo apt-get -y dist-upgrade && sudo apt-get -y install php5 mysql-server apache2 git php5-mysql php5-mcrypt libapache2-mod-php5
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
php -r "readfile('https://getcomposer.org/installer');" | php
sudo mv composer.phar /usr/local/bin/composer
composer self-update
```

## 3. Clone the repository into your preferred &lt;projectify_root&gt;
*or your own fork of the repository if you plan to contribute*
```
cd <parent_of_projectify_root>
git clone git://github.com/BBBThunda/projectify.git
```

## 4. Configure an Apache virtual host
From &lt;projectify_root&gt;, copy the projectify.conf from the repository into your apache sites directory:
```
sudo cp projectify.conf /etc/apache2/sites-available
```
### Edit /etc/apache2/sites-available/projectify.conf
1. Set the ServerName to whatever hostname you plan to type into your browser to access the site.

2. Point DocumentRoot to your &lt;projectfy_root&gt;/public folder.

3. Change the &lt;directory&gt; tag pointing to /var/www/projectify and point it to &lt;projectify_root&gt;

*Note: If you are not using an existing hostname like localhost or some name your DNS server already understands, add the new hostname to your /etc/hosts file under 127.0.0.1 (localhost is probably there already, just add a space, followed by your ServerName).*

## 5. Enable modules, disable the default site (if enabled by default), enable projectify.conf and restart apache.
```
sudo php5enmod mcrypt pdo_mysql
sudo a2enmod rewrite
sudo a2dissite 000-default
sudo a2ensite projectify
sudo service apache2 restart
```
If you get an AH0058 message, don't worry.  It won't break your site.  Now it's time to set up your environment in Laravel.
