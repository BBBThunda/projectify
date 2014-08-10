<?php

// Configuration for sensitive information in local environment
//
// FIRST-TIME Projectify installers, do the following:
// 1) Copy this file from 'env.dev.default.php' to '.env.dev.php' (note the preceding dot)
// 2) Change the values in the array to fit your database credentials
// 3) Don't forget to create the database and user in the database itself

return array(

    'DB_HOST' => 'your-db-hostname',
    'DB_NAME' => 'projectify-dev',
    'DB_USER' => 'projectify-dev',
    'DB_PASS' => 'password-for-projectify-dev-user'

);
