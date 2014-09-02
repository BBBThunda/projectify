<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <title>Projectify {{ isset($pageTitle) ? ' - ' . $pageTitle : ' - Get Stuff Done' }}</title>
    </head>
    <body>

        @include('layouts.header')

        @yield('bodyContent')

        <!-- FOOTER -->
 
    </body>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" />

</html>
