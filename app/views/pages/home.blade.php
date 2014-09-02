<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <a href="/"><img src="/img/projectify.jpg" width="300" height="70" /></a>
        <a href="/register">Sign Up</a>
        <a href="/login">Log In</a>

        
        {{-- If any messages were passed, display them ------------}}
        @if (Session::has('error'))
        <div class="error">
            <p>{{{ Session::get('error') }}}</p>
        </div>
        @elseif (Session::has('status'))
        <div>
            <p>{{{ Session::get('status') }}}</p>
        </div>
        @endif

        <p><strong>Projectify is an open-source to-do list application for people who are serious 
            about digitizing their responsibilities.</strong></p>

        <p class="warn">Currently, passwords are stored securely, but the site does not yet use 
        SSL encryption.  If you choose to try the site in the meantime, please be careful not to
        use any sensitive passwords that you use elsewhere.</p>

        <a href="/register">Sign Up</a>
        <a href="/login">Log In</a>

        <h2>Features</h2>
        <p>
        <ul>
            <li>Register</li>
            <li>verify email</li>
            <li>login</li>
            <li>forgot password reset via email</li>
            <li>edit display name and password.</li>
        </ul>
        </p>

        <p>Features to be added next:
        <ul>
            <li>Add TBS3 framework to make the site look nicer</li>
            <li>Master template for views (with page headers/footers)</li>
            <li>Projects module<ul>
                <li>Create task</li>
                <li>List tasks</li>
                <li>Filter tasks</li>
                <li>Check off completed tasks</li>
                <li>Projectify task (add child tasks, etc.)</li>
            </ul></li>
        </ul>
        </p>

        <p>Future "someday maybe" features:
        <ul>
            <li>Create API</li>
            <li>Integrate with Evernote, Dropbox, etc.</li>
            <li>Share projects w/ friends</li>
            <li>API-based mobile apps</li>
            <li>Use mobile apps offline</li>
            <li>Shopping lists</li>
            <li>Recurring tasks</li>
        </ul>
        </p>

    </body>
</html>
