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

        <p><strong>Projectify is an open-source to-do list application for
            people who are serious about digitizing their responsibilities.
        </strong></p>

        <p><a class="btn btn-primary btn-lg" href="/register" role="button">
            Sign Up Now!</a></p>

        <p class="text-warning">This site is pre-alpha stage, meaning there are
        a few more features needed before it will be considered alpha.  In the
        meantime, please try out the site and contact Support with your
        comments/suggestions/issues: 
        <a href="mailto:bobby@<?php print $_SERVER['SERVER_NAME'] ?>">
            bobby@<?php print $_SERVER['SERVER_NAME'] ?></a></p>

        <p>This project is open source.  For more info about the site, see the
        <a href="/about">ABOUT</a> page.  If you are interested in contributing
        to the project, check out the <a href="/contribute">CONTRIBUTE</a>
        page.  Links are also in the nav bar at the top of the page.</p>

        <p><strong>UPDATE:</strong> You can now add your own custom contexts to 
        the list. Go to the "Add Task" page and click the '+' icon to get a 
        textbox where you can enter your new context name.  Press ENTER to save
        it to your list.  But be careful for now about how many contexts you
        add.  Generally it's a good idea to keep these to a minimum anyway, but
        at the moment there's no way to delete contexts or a practical way to
        display a large list of them.</p>

    </div>
</div>

<div class="container">

    <div class="well">
        <div class="row">

            <div class="col-md-4">
                <h2>Features</h2>
                <p>
                <ul>
                    <li>Email registration system</li>
                    <li>Edit display name and password.</li>
                    <li>Twitter Bootstrap</li>
                    <li>Create task</li>
                    <li>List tasks</li>
                    <li>Filter tasks by context</li>
                    <li>Complete/uncomplete tasks</li>
                    <li>Filter completed tasks</li>
                    <li>Edit task and add/remove contexts</li>
                    <li>Projectify task (add child tasks, etc.)</li>
                    <li>Customize contexts</li>
                </ul>
                </p>
            </div>

            <div class="col-md-4">
                <h2>Coming Soon</h2>
                <ul>
                    <li>Enabled context toggle</li>
                    <li>Roadblocks</li>
                    <li>Add tags</li>
                    <li>Roadblock reminders</li>
                    <li>Search by tag</li>
                    <li>Archive tasks completed X days</li>
                </ul>
            </div>

            <div class="col-md-4">
                <h2>"Someday Maybe"</h2>
                <ul>
                    <li>REST API</li>
                    <li>Evernote, Dropbox, Drive, etc.</li>
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
