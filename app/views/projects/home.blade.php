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
        {{-- All button for removing context filters --}}
        <a class="btn btn-default btn-info context-btn" 
            id="context-btn-All" name="All" href="">All</a>

        {{-- Show buttons for filtering tasks by context --}}
        @foreach ($data['contexts'] as $context)
        <a class="btn btn-default context-btn" 
            id="context-btn-{{{ $context['description'] }}}"
            name="{{{ $context['description'] }}}"
            href="">{{{ $context['description'] }}}</a>
        @endforeach
    </div>

    <!-- Completed filter -->
    <div class="col-md-5">
        <a class="btn btn-default completed-btn" id="show-completed-btn" 
            href="">Show Completed</a>
    </div>

</div>



<!-- Todo List -->
<div class="row">

    <div class="col-md-8">
        {{ Form::open([ 'method' => 'post', 
        'url' => '/projects/setCompleted' ]) }}

        <ul id="project-list-main">
            @if (!empty($data['projects']))
            
            @foreach ($data['projects'] as $project)

            <?php
            // Build class attribute
            //TODO: CLEAN THIS UP 
            $class = 'project';

            // Include contexts
            foreach ($project->contexts as $context) { 
                $class .= ' ' . $context->description;
            }

            if ($project->completed) {
                $class .= ' completed hidden';
            } ?>

            <li class="{{{ $class }}}">

            {{-- Projectify icon --}}
            <a class="projectifyButton" 
                title="Projectify/Edit Task"
                href="/projectify/{{ $project->id }}">
                <img src="/img/projectify-icon2.jpg" /></a>

            {{-- Completed checkbox --}}
            {{ Form::checkbox($project->id . '_completed', 
                $project->id, 
                $project->completed, 
                ['class' => 'cb-completed',
                'title' => 'Mark whether task is complete'])
            }}

            {{-- Description --}}
            <span class="projectDesc">{{{ $project->description }}}</span>

            {{-- Context labels --}}
            @foreach ($project->contexts as $context)
            <a class="context-label label label-info">
                {{{ $context->description }}}</a>
            @endforeach

            </li>
            @endforeach {{-- End project foreach --}}
            @else {{-- If there are no projects --}}
            <li>No todo items - go have some fun!</li>
            @endif

        </ul>

        {{ Form::close() }}
    </div>

</div>

{{-- Include libraries from CDN if live, else use local files --}}
@if ($app->env == 'live')
<script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.1.1/Sortable.min.js"></script>
@else
<script src="/script/Sortable.min.js"></script>
@endif

@stop
