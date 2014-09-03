@extends('layouts.master')

@section('bodyContent')

<h1>{{ Auth::user()->display_name . '\'s Home' }}</h1>

@if (Session::has('message'))
<p>{{{ Session::get('message') }}}</p>
@endif

<?php //dd(Session::all()); ?>
<?php //dd($projects); ?>
<div>
    <h2>Todo List</h2>

    <ul>
        @if (!empty($projects))
        @foreach ($projects as $project)
        <li>{{ Form::checkbox($project->id . 'completed', $project->completed) }}
        {{{ $project->description }}}</li>
        @endforeach
        @else
        <li>No todo items - go have some fun!</li>
        @endif
    </ul>
</div>

<br />
<a href="/addProject">Add Project</a>
<br />
<a href="/editProfile">Edit Profile</a>
<br />
<a href="/logout">Log Out</a>

@stop
