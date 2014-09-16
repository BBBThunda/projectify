@extends('layouts.master')

@section('bodyContent')

{{ Form::open([ 'route' => 'projects.store' ]) }}

<div class="row">
    <h2>Create Task</h2>
    <div class="col-md-4">
        <div class="form-group">
            {{-- Description field. ---------------------------------}}
            @if (!empty($errors))
            <ul class="errors">
                @foreach($errors->get('description') as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
            @endif
            {{ Form::label('description', 'Text:') }}
            {{ Form::text('description', '', ['autofocus' => 'autofocus', 'tabindex' => '1' ]) }}
        </div>
    </div>
    
    {{-- Submit button ----------------------------------------------}}
    {{ Form::submit('Add Task', ['class' => 'btn btn-primary'] ) }}

    @if (!empty($contexts))
    <div class="col-md-4">
        <div class="form-group">
            {{-- Context Checkboxes ---------------------------------}}
            {{ Form::label('context', 'Context:') }}
            @foreach ($contexts as $context)
            {{ Form::checkbox('context[]', $context['id'], $context['checked'], 
                ['id' => 'context_' . $context['id'] ]) }}
            {{ Form::label('context_' . $context['id'], $context['description']) }}
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- TODO: add a way to select context(s) --}}

{{ Form::close() }}

@stop
