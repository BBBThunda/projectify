<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        @include('layouts.style')

        <title>Projectify {{ isset($pageTitle) ? ' - ' . $pageTitle : ' - Get Stuff Done' }}</title>
    </head>
    <body>

        @include('layouts.header')

        @yield('bodyContent')

        @include('layouts.footer')

    </html>
