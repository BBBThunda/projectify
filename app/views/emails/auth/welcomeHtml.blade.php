<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Welcome to Projectify!</h2>

        <div>
            Hi {{ $display_name }},<br />
            <br />
            We're glad to have you on board!  Before you can login we need you to confirm your email address by clicking the following link:<br />
            {{ URL::to('verifyEmail/' . $confirmation_code) }}.<br />
            <br />
            This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
        </div>
    </body>
</html>
