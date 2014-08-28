<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <h1>Edit profile</h1>

        @if (!empty($message))
        <p>{{ $message }}</p>
        @endif

        {{ Form::open([ 'url' => '/updateProfile' ]) }}

            {{-- Display name field. ------------------------}}
            <ul class="errors">
            @foreach($errors->get('display_name') as $message)
                <li>{{ $message }}</li>
            @endforeach
            </ul>
            {{ Form::label('display_name', 'Display name') }}
            {{ Form::text('display_name', $user->display_name) }}

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
            {{ Form::submit('Save Changes') }}

        {{ Form::close() }}

    </body>
</html>
