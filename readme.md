## Projectify - get stuff done

[Projectify](https://proj.ectify.com) is a todo-list manager that's laser-focused on digitizing your responsibilities and getting them done.

## Installation

''Note: installation instructions were written for installation on debian-based Linux distributions, namely Ubuntu.  Pull-requests of instructions for other platforms are welcome if you'd like to help!''

# Install and configure Git, Apache, PHP and MySQL

I've put these here for the convenience of those who aren't too comfortable with any of these tools.  Most of you probably use these already and can skip this part.

1. Install any of the following you do not already have
   '''apt-get update && apt-get upgrade && apt-get install php5 php5-mcrypt mysql-server apache2 libapache2-php5 git
   '''

If you did not already have mysql-server, you will be prompted to create a root password. Pick a good one and don't lose it.

2. Install composer if needed
   '''curl -sS https://getcomposer.org/installer | php
   mv composer.phar /usr/local/bin/composer
   composer self-update
   '''

3. Clone the repository (or your own fork of the repository if you plan to contribute) into your preferreed <projectify_root> and copy 
   '''cd <parent_of_projectify_root>
   git clone https://github.com/BBBThunda/projectify.git
   cp <projectify_root>/projectify.conf /etc/apache2/sites-available
   '''

4. Edit /etc/apache2/sites-available/projectify.conf so that ServerName is whatever you plan to type into your browser to access the site and point DocumentRoot to your <projectfy_root>/public folder.  If you're not familiar with apache virtual hosts, copy the   Also change the directory tag pointing to ...../public so it matches.  If you are not using an existing hostname like localhost, add the new hostname to your /etc/hosts file.

5. Enable modules, disable the default site (if enabled by default), enable projectify.conf and restart apache.
   '''a2enmod rewrite
   php5enmod mcrypt
   a2dissite 000-default.conf
   a2ensite projectify.conf
   service apache2 restart
   '''

You should now be able to browse to the site.  Now it's time to set up your environment in Laravel.

# Setting up your environment and migrating the DB

1. Install composer and do an update in your repository.

   '''php -r "readfile('https://getcomposer.org/installer');" | php
   composer update
   '''

This will download all of the dependencies required for projectify, including those required for Laravel and store them in the "vendor" directory.

2. Once you can browse to your repository, you need to set up the environment.  But first, you should create the database and the mysql user. Call them whatever you want, (here we will call both projectify_dev) just make sure .env.dev.php has the correct name, password, host, db, etc.  Login to mysql as root or a user with root privileges or at least the ability to create users and databases and to grant privileges.

   '''mysqladmin -u root -p create projectify_dev
   mysql -u root -p
   CREATE USER 'projectify_dev'@localhost IDENTIFIED BY 'password';
   GRANT ALL PRIVILEGES ON projectify_dev . * TO 'projectify_dev'@'localhost';
   FLUSH PRIVILEGES;
   quit
   '''

If this is confusing, [this tutorial](https://www.digitalocean.com/community/tutorials/how-to-create-a-new-user-and-grant-permissions-in-mysql) might be helpful, or check the MySQL documentation.

Also, if you use PHPMyAdmin, there is an option to create a new user with a checkbox to automatically create a new db with the same name and grant all privs like we did above.

3. Basically you want to find all of the files with .default.php and remove the .default.  In the case of the env.default files in the projectify_root> directory, you also want to prepend a dot. So copy the files and then edit them to fit your environment:
   '''cd <projectify_root>
   cp env.dev.default.php .env.dev.php
   cp bootstrap/start.default.php bootstrap/start.php
   '''

Note: env.live.default.php can be ignored since we only use the "live" environment if the request domain is proj.ectify.com

4. Run the migrations and seed the database.  If you have set up the database and environment correctly, you should be able to  run the following command from the <projectify_home> directory:

   '''php artisan migrate --seed
   ''' 

## Contributing To Projectify

**All issues and pull requests should be filed on the [bbbthunda/projectify](http://github.com/bbbthunda/projectify) repository.**

See CONTRIBUTING.md for more details.

## License

Projectify and the Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
