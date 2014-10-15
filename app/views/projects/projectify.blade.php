@extends('layouts.master')

@section('bodyContent')

{{ Form::open([ 'route' => 'projects.store' ]) }}

<div class="row">
    <h2>Projectify! Task</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{-- Completed checkbox --}}
                {{ Form::checkbox($project->id . '_completed', $project->id, 
                $project->completed, ['class' => 'cb-completed']) }}

                {{-- Description error messages --}}
                @if (!empty($errors))
                <ul class="errors">
                    @foreach($errors->get('description') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
                {{-- Description field ---------------------------------}}
                {{ Form::label('description', 'Description:') }}
                {{ Form::text('description', $project->description, ['autofocus' => 'autofocus', 'tabindex' => '1' ]) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">

                {{-- Contexts --}}
                @if (!empty($contexts))
                <div class="col-md-4">
                    {{-- Context Checkboxes ---------------------------------}}
                    {{ Form::label('context', 'Context:') }}
                    @foreach ($contexts as $context)
                    <div class="form-group-fluid">
                        {{ Form::checkbox('context[]', $context['id'], $context['checked'],
                        ['id' => 'context_' . $context['id'] ]) }}
                        {{ Form::label('context_' . $context['id'], $context['description']) }}
                    </div>
                    @endforeach
                </div>
                @endif


                {{-- Roadblocks --}}


                {{-- Tags --}}

            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{-- Tasks --}}
                @if (!empty($subtasks))
                {{-- Existing Child Tasks --}}

                @foreach ($subtasks as $subtask)
                
                @endforeach

                @endif


                {{-- Submit button ----------------------------------------------}}
                {{ Form::submit('Save Project', ['class' => 'btn btn-primary'] ) }}
            </div>
        </div>
    </div>

    @if (!empty($contexts))
    <div class="col-md-4">
        {{-- Context Checkboxes ---------------------------------}}
        {{ Form::label('context', 'Context:') }}
        @foreach ($contexts as $context)
        <div class="form-group-fluid">
            {{ Form::checkbox('context[]', $context['id'], $context['checked'], 
            ['id' => 'context_' . $context['id'] ]) }}
            {{ Form::label('context_' . $context['id'], $context['description']) }}
        </div>
        @endforeach
    </div>
    @endif

</div>

{{-- TODO: add a way to select context(s) --}}

{{ Form::close() }}

@stop
