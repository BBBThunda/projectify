@extends('layouts.master')

@section('bodyContent')


<div class="well">

    <h1>What is Projectify</h1>

    <p>You're busy.  You have commitments.  They need to get done.  But you
    can't do them all now.  In fact, maybe you can only do 3 of them now.</p>

    <p>Why waste energy thinking about the tasks you can't do now?  Focus on the
    doable tasks now and let Projectify keep track of the rest until you can do
    them!</p>

</div>


<div class="well">

    <h2>Open Source</h2>

    <p>Projectify is open-source, which means the code is freely available.  The
    community can see the code and contribute.  If you like this style of task
    management and want to help, check out the
    <a href="/contribute">Contribute</a> page to find out how you can help</p>

</div>


<div class="well">

    <h2>Reasons a task can't be completed</h2>

    <p>When you can't complete a task in life, there are generally 3 reasons</p>

</div>


<div class="well">

    <h3>Reason 1: Context</h3>

    <p>If your task requires you to be in a certain place or have access to
    certain equipment.  For example, if your task is "Mow the Lawn", you could
    apply the context "home" while adding it, since it can only be done at home.  
    If you're out running errands, you may be in the "car" context.  Since
    you're not in the right context to complete this task, Projectify hides it
    for now.</p>

</div>


<div class="well">

    <h3>Reason 2: Complexity</h3>

    <p>Maybe you started working on a task, but weren't able to complete it yet.
    You may be inclined to mark the task with a status, like "in progress" or 
    15% Complete.  But these arbitrary labels are a bit abstract and don't do a 
    great job of illustrating your progress.  If you start accumulating a lot of 
    tasks with these partially complete labels, it can make a mess, and now 
    you're back to using mental energy every time you look at your list.</p>

    <p>What do yo do with a task like this?  <strong>Projectify it!</strong></p>

    <p>Click the Projectify icon next to the task, and you will have the option 
    to turn a Task into a Project by adding subtasks.</p>

</div>


<div class="well">

    <h3>Reason 3: Roadblocks</h3>

    <p>What if a task can't be done for external reasons that have nothing to do 
    with you?  Or if a task is dependent upon completion of another task?  We 
    call these <strong>Roadblocks</strong>, and they generally can be broken 
    down into three types:</p>

    <p><em>Note: roadblocks haven't been implemented yet, but here's the current
        plan for how they will work once they are.</em></p>

    <h4>Roadblock type 1: Waiting on Task</h4>

    <p>When you add this Roadblock, you can reference another task or project.
    This task will remain hidden until the other task is completed.</p>

    <h4>Roadblock type 2: Waiting on Contact</h4>

    <p>When you add this roadblock, you will be able to associate a contact and
    a date/time when you'd like a reminder to follow up with that contact.</p>

    <h4>Roadblock type 3: Waiting on Event</h4>

    <p>Adding this roadblock allows you to add a date/time when the task will
    become visible again.</p>

</div>


<div class="well">

    <h2>Get Stuff Done</h2>

    <p>Using the tools explained above, you should be able to focus on only the
    tasks you can do now without being distracted by all of the other tasks you
    are responsible for.  This should make it much easier to prioritize these
    tasks on the fly based on importance or personal preference.</p>

    <p>With the peace of mind that comes from knowing you will be reminded of
    doable tasks at an appropriate time, you will have the confidence to focus
    on the things that are important right now and stop worrying that you might
    forget something.</p>

</div>


@stop
