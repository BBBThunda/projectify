@extends('layouts.master')

@section('bodyContent')

<h1>Email Address Unverified</h1>

<p>You have logged in successfully, but you have not yet verified your email address.</p>


<h2>What do I do now?</h2>

<p>If you haven't already, check your email for a message from {{ getenv('MAIL_DISPLAY_ADDRESS') }}.  This message contains a link.  Clicking the link or pasting it into your browser's address bar should verify your account</p>

<p>If you have lost the welcome email or if it's been more than 60 minutes since it was sent, then you can:<br />
<a href="/resend">click here to send a new welcome email</a>.</p>

<p>If you have tried resending and are still unable to find the email, check your spam/junk folder.  For some email providers you may need to add {{ getenv('MAIL_DISPLAY_ADDRESS') }} to your contacts so our emails will not be blocked.</p>


<h2>Why do we have to do this?</h2>

<p>For the security of our users, we require everyone to confirm that they can receive the emails we send and that the email address they used to register doesn't belong to someone else.</p>

@stop
