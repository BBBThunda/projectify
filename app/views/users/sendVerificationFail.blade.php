@extends('layouts.master')

@section('bodyContent')

<?php
//TODO: Replace "register" link with link to resend verification email
//TODO: Add a link to report an issue or contact us
?>

<h1>Sending of Verification Failed</h1>

<p>There was a problem sending the verification email.  Please try 
<a href="/login">logging in</a>
. If you are in our system, you will be given a link to resend the welcome email.</p>
<p>If that doesn\'t work, you\'ll have to 
<a href="/register">register</a>.</p>

@stop
