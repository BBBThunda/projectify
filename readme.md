## Projectify - get stuff done

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/downloads.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Projectify is blahblahblahblahdescription  This readme needs some work... just putting the installation instructions here for now.

## Installation

1 Install any of the following you do not already have
 apt-get update && apt-get upgrade && apt-get install php5 php5-mcrypt mysql-server apache2 libapache2-php5 git

If you did not already have mysql-server, you will be prompted to create a root password. Pick a good one and don't lose it.

2 Clone the repository into your preferreed <projectify_root> and copy 
 cd <parent_of_projectify_root>
 git clone ????????????
 cp <projectify_root>/projectify.conf /etc/apache2/sites-available

3 Edit /etc/apache2/sites-available/projectify.conf so that ServerName is whatever you plan to type into your browser to access the site and point DocumentRoot to your <projectfy_root>/public folder.  Also change the directory tag pointing to ...../public so it matches.

4 Enable modules, disable the default site (if enabled by default), enable projectify.conf and restart apache.
 a2enmod rewrite
 php5enmod mcrypt
 a2dissite 000-default.conf
 a2ensite projectify.conf
 service apache2 restart

You should now be able to browse to the site.  Now it's time to set up your environment in Laravel.  Basically you want to find all of the files with .default.php and remove the .default.  In the case of the env.default files in the projectify_root> directory, you also want to prepend a dot. So copy the files and then edit them to fit your environment:
 cd <projectify_root>
 cp env.dev.default.php .env.dev.php
 cp env.live.default..php .env.live.php
 cp bootstrap/start.default.php bootstrap/start.php

## Contributing To Projectify

**All issues and pull requests should be filed on the [bbbthunda/projectify](http://github.com/bbbthunda/projectify) repository.**

## License

Projectify and the Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
