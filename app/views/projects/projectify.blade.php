@extends('layouts.master')

@section('bodyContent')

{{ Form::open([ 'route' => [ 'projects.storeProject', 
'project_id' => $data['project']->id ] ]) }}

<div class="row">
    <h2>Projectify a Task</h2>
    <div class="row">
        <div class="col-md-4">
            <h4>Project</h4>
            <div class="form-group">

                {{-- Description error messages --}}
                @if (!empty($errors))
                <ul class="errors">
                    @foreach($errors->get('description') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif

                {{-- Completed checkbox --}}
                {{ Form::checkbox('completed', $data['project']->id, 
                $data['project']->completed, ['class' => 'cb-completed']) }}

                {{-- Description field ---------------------------------}}
                {{ Form::text('description', $data['project']->description, 
                ['autofocus' => 'autofocus', 'tabindex' => '1' ]) }}
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">

                {{-- Contexts --}}
                @if (!empty($data['contexts']))
                
                <div class="col-md-4 contextsWidgetTemplate">
                    {{-- Label --}}
                    {{ Form::label('context', 'Context: ') }}

                    {{-- Checkboxes --}} 
                    @foreach ($data['contexts'] as $context)

                    <span class="form-group-fluid">
                        {{ Form::checkbox('context[]', $context['id'], 
                        $context['checked'], 
                        ['id' => 'context_' . $context['id'] ]) }}
                        {{ Form::label('context_' . $context['id'], 
                        $context['description']) }}
                    </span>

                    @endforeach

                </div>
                @endif

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 well">
            <h4>Subtasks</h4>
            <ul>
                <li>
                <span class="task-add-btn glyphicon glyphicon-plus"
                    title="Add Subtask"></span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">


            {{-- Roadblocks --}}


            {{-- Tags --}}

        </div>
    </div>

    <!-- Submit button -->
    <div class="row">
        <div class="col-md-12">

            {{-- Submit button ----------------------------------------------}}
            {{ Form::submit('Save Project', ['class' => 'btn btn-primary'] ) }}

        </div>
    </div> 
</div>

{{-- TODO: add a way to select context(s) --}}

{{ Form::close() }}

@stop
