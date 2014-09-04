@extends('layouts.master')

@section('bodyContent')

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

{{ Form::open([ 'route' => 'sessions.store', 'role' => 'form'  ]) }}

<div class="row">
    <h2>Sign in</h2>
    <div class="col-md-4">
        {{-- Email field ---------------------------------------------}}
        <div class="form-group">
            {{-- Form::label('email', 'Email:') --}}
            {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Enter email', 'autofocus' => 'autofocus']) }}
        </div>

        {{-- Password field ------------------------------------------}}
        <div class="form-group">
            {{-- Form::label('password', 'Password:') --}}
            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
        </div>

        {{-- Remember checkbox ---------------------------------------}}
        <div class="form-group">
            {{ Form::label('Remember me:') }}
            {{ Form::checkbox('remember') }}
            {{ Form::submit('Login', ['class' => 'btn btn-primary pull-right'] ) }}
        </div>


        {{ Form::close() }}
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a class="btn btn-default" href="/forgotPassword">I forgot my password</a>
        </div>
        <div class="form-group">
            <a class="btn btn-default" href="/register">Sign me up!</a>
        </div>
    </div>
</div>

@stop
