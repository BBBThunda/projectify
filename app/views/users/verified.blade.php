<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

<?php
//TODO: Move text to language file 
//TODO: Replace "register" link with link to resend verification email
//TODO: Add a link to report an issue or contact us
?>

        <h1>Email address verified</h1>
        @if (!empty($message))
        <p>{{ $message }}</p>
        @endif

    </body>
</html>
