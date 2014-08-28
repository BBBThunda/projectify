<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        {{ Form::open([ 'route' => 'projects.store' ]) }}

                {{ Form::label('text', 'Text:') }}
                {{ Form::text('text') }}
            
                {{ Form::submit('Add Task') }}

        {{ Form::close() }}

    </body>
</html>
