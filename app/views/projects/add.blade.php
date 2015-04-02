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
            {{ Form::label('description', 'Description:') }}
            {{ Form::text('description', '', ['autofocus' => 'autofocus', 'tabindex' => $tabindex ]) }}
            <?php $tabindex++; ?>
        </div>
        
        {{-- Submit button ----------------------------------------------}}
        {{ Form::submit('Add Task', [
        'class' => 'btn btn-primary',
        'tabindex' => $tabindex] ) }}

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
            @if (!empty($context['owner']))
            {{--TODO: Add onclick event to submit AJAX request --}}
            <button class="removeContextButton"
                value="{{ $context['id'] }}"
                title="Remove context">-</button>
            @endif
        </div>
        @endforeach

        {{-- Add a context --------------------------------------}}
        <div class="newContexts">
            <span class="context-add-btn glyphicon glyphicon-plus"
                title="Add Context"></span>
        </div>
        
    </div>
    @endif

</div>

{{ Form::close() }}

@stop
