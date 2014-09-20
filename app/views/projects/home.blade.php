@extends('layouts.master')

@section('bodyContent')

<h1>{{ Auth::user()->display_name . '\'s Home' }}</h1>

@if (Session::has('message'))
<p>{{{ Session::get('message') }}}</p>
@endif

<div class="row">
    <h2>Todo List</h2>

    <div class="col-md-8">
        {{ Form::open([ 'method' => 'post', 'url' => '/projects/setCompleted' ]) }}
        <ul>
            @if (!empty($projects))
            @foreach ($projects as $project)
            <li>
            {{ Form::checkbox($project->id . '_completed', $project->id, $project->completed, ['class' => 'cb-completed']) }}
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
        {{ Form::close() }}
    </div>

</div>

<a class="btn btn-primary" href="/addProject">Add Project</a>

@stop
