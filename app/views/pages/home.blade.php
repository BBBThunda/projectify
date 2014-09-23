@extends('layouts.master')

@section('bodyContent')

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
</div>

<div class="jumbotron">
    <div class="container">

        <h1>Projectify</h1>

        <p><strong>Projectify is an open-source to-do list application for people who are serious 
            about digitizing their responsibilities.</strong></p>

        <p class="text-warning">The site is in a pre-alpha stage. SSL is working now, but we're not 
        forcing it for now.  So unless you have a reason not to, make sure you are accessing the site 
        via https.  If you're not sure, <a href="https://proj.ectify.com">click here.</a>  In the future 
        we will automatically redirect you.</p>

        <p><a class="btn btn-primary btn-lg" role="button">Sign Up Now!</a></p>

    </div>
</div>

<div class="container">

    <div class="well">
        <div class="row">

            <div class="col-md-4">
                <h2>Features</h2>
                <p>
                <ul>
                    <li>Register</li>
                    <li>verify email</li>
                    <li>login</li>
                    <li>forgot password reset via email</li>
                    <li>edit display name and password.</li>
                    <li>Add TBS3 framework to make the site look nicer</li>
                    <li>Master template for views (with page headers/footers)</li>
                    <li>Create task</li>
                    <li>List tasks</li>
                    <li>Filter tasks by context</li>
                    <li>Check off completed tasks</li>
                </ul>
                </p>
            </div>

            <div class="col-md-4">
                <h2>Coming Soon</h2>
                <ul>
                    <li>Edit task</li>
                    <li>Projectify task (add child tasks, etc.)</li>
                    <li>Customize contexts</li>
                </ul>
            </div>

            <div class="col-md-4">
                <h2>"Someday Maybe"</h2>
                <ul>
                    <li>Create API</li>
                    <li>Integrate with Evernote, Dropbox, etc.</li>
                    <li>Share projects w/ friends</li>
                    <li>API-based mobile apps</li>
                    <li>Use mobile apps offline</li>
                    <li>Shopping lists</li>
                    <li>Recurring tasks</li>
                </ul>
            </div>
        </div> 
    </div>

    @stop
