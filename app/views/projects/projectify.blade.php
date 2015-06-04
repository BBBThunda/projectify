@extends('layouts.master')

@section('bodyContent')

{{ Form::open([ 'route' => [ 'projects.storeProject',
'project_id' => $data['project']->id ] ]) }}

<div class="row">
    <h2>Projectify a Task</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <legend>Project</legend>

                {{-- Completed/Description error messages --}}
                @if (sizeof($errors) > 0)

                <ul class="errors">
                    @foreach($errors->get('completed') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                    @foreach($errors->get('description') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>

                @endif

                {{-- Completed checkbox --}}
                {{ Form::checkbox('completed', 1,
                $data['project']->completed, ['class' => 'cb-completed']) }}

                {{-- Description field ---------------------------------}}
                {{ Form::text('description', $data['project']->description,
                ['class' => 'taskDescription',
                'autofocus' => 'autofocus', 'tabindex' => '1' ]) }}
            </div>
            <!--        </div>
        <div class="col-md-8">
            -->            <div class="form-group">

                {{-- Contexts --}}
                @if (!empty($data['contexts']))

                <div class="col-md-8 contextsWidgetTemplate">
                    {{-- Label --}}
                    {{ Form::label('context', 'Context: ') }}

                    {{-- Checkboxes --}}
                    @foreach ($data['contexts'] as $context)

                    <span class="form-group-fluid">

                        {{ Form::checkbox('context[]', $context['id'],
                        $context['checked'],
                        ['id' => 'context_' . $context['id'] ]) }}

                        {{ Form::label('context_' . $context['id'],
                        $context['description']) }}

                    </span>

                    @endforeach

                </div>
                @endif

            </div>
        </div>
    </div>



    {{-- PARENT TASK --}}
    @if (!empty($data['parentTask']))
    <div class="row">
        <div class="col-md-6 well">
            <h4>Parent Project</h4>
            <ul class="list-unstyled" id="parent-project-list-main">

                <li class="project">

                {{-- Handle for dragging sortable projects
                <span class="icon icon-menu drag-project"><img src="/img/menu.png" /></span> --}}

                {{-- Projectify icon --}}
                <a class="projectifyButton"
                    title="Projectify/Edit Task"
                    href="/projectify/{{ $data['parentTask']->id }}">
                    <img src="/img/projectify-icon2.jpg" /></a>

                {{-- Completed checkbox --}}
                {{ Form::checkbox($data['parentTask']->id . '_completed',
                $data['parentTask']->id,
                $data['parentTask']->completed,
                ['class' => 'cb-completed',
                'title' => 'Mark whether task is complete'])
                }}

                {{-- Description --}}
                <span class="projectDesc">{{{ $data['parentTask']->description }}}</span>

                {{-- Context labels --}}
                @foreach ($data['parentTask']->contexts as $context)
                <a class="context-label label label-info">
                    {{{ $context->description }}}</a>
                @endforeach


                </li>

            </ul>
        </div>
    </div>
    @endif




    {{-- EXISTING SUBTASKS --}}
    <div class="row">
        <div class="col-md-6 well">
            <h4>Subtasks</h4>
            <ul class="list-unstyled" id="subtask-list-main">

                <?php $subtaskCount = 0; ?>

                @foreach ($data['subtasks'] as $subtask)

                <li>

                {{-- Projectify icon --}}
                <a class="projectifyButton"
                    title="Projectify/Edit Task"
                    href="/projectify/{{ $subtask->id }}">
                    <img src="/img/projectify-icon2.jpg" /></a>

                <?php $prefix = 'subtask_' . $subtask->id . '_'; ?>

                {{-- Completed checkbox --}}
                {{ Form::checkbox($prefix . 'completed', 1,
                $subtask->completed, ['class' => 'cb-completed']) }}

                {{-- Description field ---------------------------------}}
                {{ Form::text($prefix . 'description',
                $subtask->description,
                ['tabindex' => $subtaskCount * 2 + 1 ]) }}

                {{-- Contexts --}}
                @if (!empty($data['contexts']))

                <div> {{-- class="col-md-8"> --}}
                    {{-- Label --}}
                    {{ Form::label('context', 'Context: ') }}
                    {{-- Checkboxes --}}
                    @foreach ($data['contexts'] as $context)

                    {{-- TODO: see if making hashmap of $sub_context->id's improves performance with a large context list --}}
                    <?php $checked = false; ?>
                    @foreach($subtask->contexts as $sub_context)
                    @if ($sub_context->id == $context['id'])
                    <?php $checked = true; ?>
                    @endif
                    @endforeach

                    <span class="form-group-fluid">

                        {{ Form::checkbox($prefix . 'context' . '[]', $context['id'],
                        $checked,
                        ['id' => $prefix . 'context' ]) }}

                        {{ Form::label('context_' . $context['id'],
                        $context['description']) }}

                    </span>

                    @endforeach

                </div>
                @endif

                </li>

                @endforeach

                <input type="hidden" id="subtaskCount" name="subtaskCount"
                value="{{ $subtaskCount }}" />

                <li>
                <span class="task-add-btn glyphicon glyphicon-plus"
                    title="Add Subtask"></span>
                </li>

            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">


            {{-- Roadblocks --}}


            {{-- Tags --}}

        </div>
    </div>

    <!-- Submit button -->
    <div class="row">
        <div class="col-md-12">

            {{-- Submit button ----------------------------------------------}}
            {{ Form::submit('Save Project', ['class' => 'btn btn-primary'] ) }}

        </div>
    </div>
</div>

{{-- TODO: add a way to select context(s) --}}

{{ Form::close() }}

@stop
