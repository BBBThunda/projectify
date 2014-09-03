@extends('layouts.master')

@section('bodyContent')

{{ Form::open([ 'route' => 'projects.store' ]) }}

{{-- Description field. -------------------}}
<ul class="errors">
    @foreach($errors->get('description') as $message)
    <li>{{ $message }}</li>
    @endforeach
</ul>
{{ Form::label('description', 'Text:') }}
{{ Form::text('description') }}

{{ Form::submit('Add Task') }}

{{ Form::close() }}

@stop
