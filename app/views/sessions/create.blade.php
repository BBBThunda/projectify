@extends('layouts.master')

@section('bodyContent')

<h1> Sign in</h1>

{{-- If any messages were passed, display them ------------}}
@if (Session::has('error'))
<div class="error">
    <p>{{{ Session::get('error') }}}</p>
</div>
@elseif (Session::has('status'))
<div>
    <p>{{{ Session::get('status') }}}</p>
</div>
@endif

{{ Form::open([ 'route' => 'sessions.store' ]) }}

{{-- Email field ---------------------------------------------}}
<div>
    {{ Form::label('email', 'Email:') }}
    {{ Form::email('email', '', ['autofocus' => 'autofocus']) }}
</div>

{{-- Password field ------------------------------------------}}
<div>
    {{ Form::label('password', 'Password:') }}
    {{ Form::password('password') }}
</div>

{{-- Remember checkbox ---------------------------------------}}
<div>
    {{ Form::label('Remember me:') }}
    {{ Form::checkbox('remember') }}
</div>

<div>
    {{ Form::submit('Login') }}
</div>

{{ Form::close() }}

<a href="/register">Sign Up</a>
<a href="/forgotPassword">Forgot Password</a>

@stop
