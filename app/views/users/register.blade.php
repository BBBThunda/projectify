<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        {{ Form::open([ 'route' => 'users.store' ]) }}

            {{-- Email address field. -------------------}}
            <ul class="errors">
            @foreach($errors->get('email') as $message)
                <li>{{ $message }}</li>
            @endforeach
            </ul>
            {{ Form::label('email', 'Email address') }}
            {{ Form::email('email', '', ['autofocus', 'autofocus']) }}

            {{-- Display name field. ------------------------}}
            <ul class="errors">
            @foreach($errors->get('display_name') as $message)
                <li>{{ $message }}</li>
            @endforeach
            </ul>
            {{ Form::label('display_name', 'Display name') }}
            {{ Form::text('display_name') }}

            {{-- Password field. ------------------------}}
            <ul class="errors">
            @foreach($errors->get('password') as $message)
                <li>{{ $message }}</li>
            @endforeach
            </ul>
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password') }}

            {{-- Password confirmation field. -----------}}
            {{ Form::label('password_confirmation', 'Confirm password') }}
            {{ Form::password('password_confirmation') }}

            {{-- Form submit button. --------------------}}
            {{ Form::submit('Register') }}

        {{ Form::close() }}

        <p>Already have an account? <a href="/login">Log In</a></p>
        
    </body>
</html>
