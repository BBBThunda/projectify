<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
	<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        -->
	<link href="/style/projectify.css" rel="stylesheet">

        <link href="/style/bootstrap.min.css" rel="stylesheet">
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <title>Projectify {{ isset($pageTitle) ? ' - ' . $pageTitle : ' - Get Stuff Done' }}</title>
    </head>
    <body>

        @include('layouts.header')

        @yield('bodyContent')

        @include('layouts.footer')

    </html>
