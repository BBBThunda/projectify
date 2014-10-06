@extends('layouts.master')

@section('bodyContent')

<h2>{{ Auth::user()->display_name . '\'s List' }}</h2>

{{--
@if (Session::has('message'))
<p>{{{ Session::get('message') }}}</p>
@endif
--}}

<!-- Primary Controls -->
<div class="row">
    
    <!-- Add Task Button -->
    <div class="col-md-2">
        <a class="btn btn-primary" href="/addProject">Add Task</a>
    </div>

    <!-- Context filters -->
    <div class="col-md-5">
        <a class="btn btn-default btn-info context-btn" id="context-btn-All" name="All" href="">All</a>

        {{--TODO: Add contexts to data and put a foreach here --}}
        <a class="btn btn-default context-btn" id="context-btn-Home" name="Home" href="">Home</a>
        <a class="btn btn-default context-btn" id="context-btn-Work" name="Work" href="">Work</a>
        <a class="btn btn-default context-btn" id="context-btn-Phone" name="Phone" href="">Phone</a>
        <a class="btn btn-default context-btn" id="context-btn-Computer" name="Computer" href="">Computer</a>
    </div>

    <div class="col-md-5">
        <a class="btn btn-default completed-btn" id="show-completed-btn" href="">Show Completed</a>
    </div>

    <!-- Show completed button -->
    <div class="col-md-1">
    </div>

</div>

<!-- Todo List -->
<div class="row">

    <div class="col-md-8">
        {{ Form::open([ 'method' => 'post', 'url' => '/projects/setCompleted' ]) }}

        <ul id="project-list-main">
            @if (!empty($projects))
            @foreach ($projects as $project)
            
            <?php
            // Include contexts in class attribute
            $class = 'project';
            foreach ($project->contexts as $context) { 
            $class .= ' ' . $context->description;
            }

            if ($project->completed) {
                $class .= ' completed';
            } ?>

            <li class="{{{ $class }}}">

            {{ Form::checkbox($project->id . '_completed', $project->id, $project->completed, ['class' => 'cb-completed']) }}
            <input type="text" readonly="readonly" value="{{{ $project->description }}}" />
            @foreach ($project->contexts as $context)
            <a class="context-label label label-info">{{{ $context->description }}}</a>
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

@stop
