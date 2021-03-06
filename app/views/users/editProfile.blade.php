@extends('layouts.master')

@section('bodyContent')

<h1>Edit profile</h1>

@if (Session::has('message'))
<p>{{{ Session::get('message') }}}</p>
@endif

{{ Form::open([ 'url' => '/updateProfile' ]) }}

{{-- Display name field. ------------------------}}
<ul class="errors">
    @foreach($errors->get('display_name') as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
{{ Form::label('display_name', 'Display name') }}
{{ Form::text('display_name', $user->display_name, ['autofocus', 'autofocus']) }}

{{-- Password field. ------------------------}}
<ul class="errors">
    @foreach($errors->get('password') as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
{{ Form::label('password', 'Password') }}
{{ Form::password('password') }}

{{-- Password confirmation field. -----------}}
{{ Form::label('password_confirmation', 'Confirm password') }}
{{ Form::password('password_confirmation') }}

{{-- Form submit button. --------------------}}
{{ Form::submit('Save Changes') }}

{{ Form::close() }}

@stop
