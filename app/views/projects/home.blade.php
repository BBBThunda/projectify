@extends('layouts.master')

@section('bodyContent')

<h1>{{ Auth::user()->display_name . '\'s Home' }}</h1>

@if (Session::has('message'))
<p>{{{ Session::get('message') }}}</p>
@endif

<div class="row">
    <h2>Todo List</h2>

    <div class="col-md-8">
        <ul>
            @if (!empty($projects))
            @foreach ($projects as $project)
                <li>
                {{ Form::checkbox($project->id . 'completed', $project->completed) }}
                {{{ $project->description }}}
                @foreach ($project->contexts as $context)
                <p class="label label-info">{{{ $context->description }}}</p>
                @endforeach
                </li>
            @endforeach
            @else
            <li>No todo items - go have some fun!</li>
            @endif
        </ul>
    </div>

</div>

<a class="btn btn-primary" href="/addProject">Add Project</a>

@stop
