@extends('layouts.master')

@section('bodyContent')

<h1>{{ Auth::user()->display_name . '\'s Home' }}</h1>

@if (Session::has('message'))
<p>{{{ Session::get('message') }}}</p>
@endif

<div>
    <h2>Todo List</h2>

    <ul>
        @if (empty($project))
        <li>No todo items - go have some fun!</li>
        @else
        @foreach ($projects as $project)
        <li>List Item</li>
        @endforeach
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
