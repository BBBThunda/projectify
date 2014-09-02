@extends('layouts.master')

@section('bodyContent')

@if (!empty($tokenExpired))

<p>Sorry, the token you provided (or the link you clicked) is more than 60 minutes old.</p>

<p>Please go to <a href="/forgotPassword">forgot password</a> and submit your email address.</p>

@else

{{ Form::open([ 'action' => 'RemindersController@postReset' ]) }}

{{-- Email address field. -------------------}}
{{ Form::label('email', 'Email address') }}
{{ Form::text('email', $email, ['readonly' => 'readonly']) }}

{{-- CSRF Token -----------------------------}}
{{ Form::hidden('token', $token) }}

{{-- Password field. ------------------------}}
<ul class="errors">
    @foreach($errors->get('password') as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
{{ Form::label('password', 'Password') }}
{{ Form::password('password', ['autofocus' => 'autofocus']) }}

{{-- Password confirmation field. -----------}}
{{ Form::label('password_confirmation', 'Confirm password') }}
{{ Form::password('password_confirmation') }}

{{-- Form submit button. --------------------}}
{{ Form::submit('Reset Password') }}

{{ Form::close() }}

@endif

@stop
