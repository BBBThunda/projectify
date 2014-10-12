# Setting up your Laravel environment and migrating the DB

## 1. Copy and edit default config files and make storage directory writeable
- Copy the files
From &lt;projectify_root&gt;:
```
cp env.dev.default.php .env.dev.php
cp bootstrap/start.default.php bootstrap/start.php
chmod 777 app/storage/*
```
Basically you want to find all of the files ending with .default.php and remove the .default.  In the case of the env.default files in the &lt;projectify_root&gt; directory, you also want to prepend a dot.  And while we're at it, we're also making the app/storage directory writeable because not doing so will break Laravel.

- Edit the files to fit your environment
 - Configure the MySQL database credentials you plan to use
 - Configure email credentials.  For dev, you can just set 'MAIL_PRETEND' to true.  I prefer to use a personal email account, but this can be dangerous.  If you do this, just be careful not to do anything to spam the server.

*Note: env.live.default.php can be ignored since we only use the "live" environment if the request domain is proj.ectify.com.  Most likely you will use env.dev.default.php.*

## 2. Do a composer update in your repository to download dependencies.
From &lt;projectify_root&gt;:
```
composer update
```
This will take a couple minutes.  It may appear to be hung at first.  Be patient.

This will download all of the dependencies required for projectify, including those required for Laravel and store them in the "vendor" directory.

## 3. Initialize the database

Create the database and the mysql user. Call them whatever you want, (here we will call both of them projectify_dev) just make sure .env.dev.php has the correct name, password, host, db, etc.  Login to mysql as root or a user with root privileges or at least the ability to create users and databases and to grant privileges.

- Create the database as root (remember the password you set up earlier)
```
mysqladmin -u root -p create projectify_dev
```

- Log in as root
```
mysql -u root -p
```
You should get the mysql prompt.

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
*Also, if you use PHPMyAdmin, there is an option to create a new user that includes a checkbox to automatically create a new db with the same name and grant all privs like we did above.*

## 4. Run the migrations and seed the database.  If you have set up the database and environment correctly, you should be able to  run the following command from the &lt;projectify_home&gt; directory:
```
php artisan migrate --seed
```

## 5. Browse to the dev site you just configured
You should now be able to browse to http://&lt;ServerName&gt; and bring up the Projectify home page.
