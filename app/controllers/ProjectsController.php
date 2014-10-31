<?php

use Carbon\Carbon;

class ProjectsController extends BaseController {

    /**
     * ------------------------------------
     * Projects Controller
     * ------------------------------------
     *
     */

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct() {

        $this->beforeFilter('auth', array('except' => 'login'));

    }




    /**
     * add
     * Show "create a new project" form
     *
     * @return Response
     */
    public function add() {

        // Get contexts
        $contexts = Context::getUserContexts(Auth::id());

        // Pass to view
        return View::make('projects.add')->with('contexts', $contexts);;
    }


    public function show() {
        dd('show? wtf?!?!');
    }


    public function edit() {
        dd('edit? wtf?!?!');
    }





    /**
     * store
     * Validate POST data and create a new project
     *
     * @return Response
     */
    public function store() {

        // Validate inputs
        $user = Auth::id();
        $sequence = Project::where('user_id', $user)->max('sequence') + 1;
        $data = array(
            'user_id' => $user,
            'parent_project_id' => null,
            'sequence' => $sequence,
            'description' => Input::get('description'),
            'completed' => false
        );
            
        // Validate user input
        $validator = Project::validate($data);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // CREATE PROJECT
        $message = 'Project created!';
        try {

            // TODO: Wrap this block in a reversable DB transaction

            // Insert new project
            $project = new Project;
            $project->user_id = $user;
            $project->parent_project_id = null;
            $project->sequence = $sequence;
            $project->description = Input::get('description');
            $project->completed = false;
            $project->save();

            // CONTEXTS
            // If the project's contexts have changed, update those
            $contextChanges = $project->getContextChanges(
                Input::get('context'));

            if (!empty($contextChanges['detach'])) {
                throw new Exception("New Project should not have contexts!");
            }
            if (empty($contextChanges['attach'])) {
                //TODO: put info level logging here?
            }
            else {
                // Update project's contexts relationship
                $project->updateContexts($contextChanges);
            }


            // ROADBLOCKS


            // TAGS


        }
        catch (Exception $e) {
            $message = 'Sorry, we were unable to create the task due to the'
                . ' following issue: '
                . $e->getMessage();
        }

        return Redirect::to('/home')->with('message', $message);

    }

    public function delete() {
    }





    /**
     * home
     * This is where the magic happens - well eventually anyway :)
     *
     * @param $message
     * @return Response
     */
    public function home($message = null) {

        // Get projects for this user
        $data['projects'] = Project::where('user_id', Auth::id())->get();
        $data['contexts'] = Context::getUserContexts(Auth::id());

        // Display home screen page
        return View::make('projects.home')->with('data', $data);

    }




    /**
     * complete
     * Mark project as completed or uncompleted
     *
     * Requires post values:
     * 'project_id' (valid project_id belonging to current user)
     * 'value' ('0' or '1' expected)
     *
     * @return Response
     */
    public function setCompleted() {

        // Get inputs from request
        $projectId = Input::get('project_id');
        $value = Input::get('value') == "0" ? 0 : 1; //Prevent strange values

        // First make sure the user is authorized to modify this project
        $project = Project::find($projectId);

        if (!$project || $project->user_id !== Auth::id()) {
            if (Request::ajax()) {
                return Response::make('Unauthorized', 401);
            }
            else {
                return Redirect::to('/home');
            }
        }

        // Update DB and build/return response
        $status = $project->setCompleted($value);

        $response = array(
            'response' => $status
        );

        //TODO: add conditional here to support non-ajax form submit
        return Response::json($response);

    }

    /**
     * projectify
     * Turn a task into a project (or just edit the task)
     *
     * @return Response
     */
    public function projectify($project_id) {

        // Get data
        $data['project'] = Project::find($project_id);
        $data['contexts'] = 
            Context::getUserContexts(Auth::id(), $data['project']->contexts);
        
        //$data['subtasks'] = Project::where('parent_project_id', $project_id);

        return View::make('projects.projectify')->with('data', $data);
    }

    /**
     * storeProject
     *
     * @return Response
     */
    public function storeProject() {

        $project = Project::find(Input::get('project_id'));

        // Validate inputs
        $user = Auth::id();
        if ($user != $project->user_id) {
            //TODO: Throw error
            return Redirect::to('project.home');
        }

        $data = array(
            'description' => Input::get('description'),
            'completed' => Input::get('completed')
        );

        // Validate user input
        $validator = Project::validate($data, 'update');
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $message = 'Task updated!';

        //$sequence = Project::where('user_id', $user)->max('sequence') + 1;

        // Create tasks
        $message = 'Project created!';
        try {

            // TODO: Wrap this block in a reversible DB transaction

            // Get existing project
            $project = Project::find(Input::get('project_id'));

            // If the project hasn't been changed, skip update 
            if (!empty(Input::get('completed')) == $project->completed
                && Input::get('description') == $project->description) {
                    //throw new Exception('Project did not change.');
                }
            else {
                // Update parent project's attributes
                $project->description = Input::get('description');
                $project->completed = !empty(Input::get('completed'));
                $project->save();
            }


            // If the project's contexts have changed, update those
            $contextChanges = $project->getContextChanges(
                Input::get('context'));

            if (empty($contextChanges['attach'])
                && empty($contextChanges['detach'])) {
                    //throw new Exception("Project's contexts did not change");
                }
            else
            {
                // Update project's contexts relationship
                $project->updateContexts($contextChanges);
            }


            // Now to add the subtasks, YAY!!!
        }
        catch (Exception $e) {
            $message = 'Sorry, we were unable to create the task due to the'
                . ' following issue: '
                . $e->getMessage();
        }

        return Redirect::to('/home')->with('message', $message);

    }

}
