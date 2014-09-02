@extends('layouts.master')

@section('bodyContent')

{{ Form::open([ 'route' => 'projects.store' ]) }}

{{ Form::label('text', 'Text:') }}
{{ Form::text('text') }}

{{ Form::submit('Add Task') }}

{{ Form::close() }}

@stop
