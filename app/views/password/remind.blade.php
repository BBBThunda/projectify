<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <h1>Reset Password</h1>

        {{ Form::open([ 'action' => 'RemindersController@postRemind', 'method' => 'post' ]) }}

            @if (Session::has('error'))
            <ul class="errors">
                <li>{{ trans(Session::get('error')) }}</li>
            </ul>
            @elseif (Session::has('status'))
                <ul><li>{{ trans(Session::get('status')) }}</li></ul>
            @endif
            
            {{-- Email address field. -------------------}}
            {{ Form::label('email', 'Email address') }}
            {{ Form::email('email') }}

            {{-- Form submit button. --------------------}}
            {{ Form::submit('Send Email') }}

        {{ Form::close() }}

    </body>
</html>
