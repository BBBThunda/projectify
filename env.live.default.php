<?php

// Configuration for sensitive information in local environment
//
// FIRST-TIME Projectify installers, do the following:
// 1) Copy this file from 'env.dev.default.php' to '.env.dev.php' (note the preceding dot)
// 2) Change the values in the array to fit your database credentials
// 3) Don't forget to create the database and user in the database itself

return array(

    'DB_HOST' => 'your-db-hostname',
    'DB_NAME' => 'projectifylive',
    'DB_USER' => 'projectifylive',
    'DB_PASS' => 'password-for-projectify-dev-user',
    'MAIL_PRETEND' => false,
    'MAIL_HOST' => 'your.smtp.server.com',
    'MAIL_PORT' => 465, // recommended
    'MAIL_ENCRYPTION' => 'ssl', // recommended
    'MAIL_USER' => 'your-email-username',
    'MAIL_PASS' => 'your-email-password',
    'MAIL_DISPLAY_ADDRESS' => 'your.email.display.address@your.smtp.server.com',
    'MAIL_DISPLAY_NAME' => 'Your Email Display Name'

);
