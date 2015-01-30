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
        // TODO: Move validation into model
        $validator = Project::validate($data);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $project = Project::storeProject($data, Input::get('context'));

        return Redirect::to('/home')->with('message', $project->message);

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

        /////////////////////////
        /// PARENT TASK (PROJECT)
        /////////////////////////

        // Get project from DB
        $parentProjectId = Input::get('project_id');
        $project = Project::find($parentProjectId);
        $sequence = Project::where('user_id', Auth::id())->max('sequence') + 1;

        // Validate user
        $user = Auth::id();
        if ($user != $project->user_id) {
            //TODO: Throw error
            return Redirect::to('project.home');
        }

        $data = array(
            'user_id' => $user,
            'description' => Input::get('description'),
            'completed' => Input::get('completed')
        );
            
        // Validate user input
        // TODO: Move validation into model
        $validator = Project::validate($data);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = Project::storeProject($data, Input::get('context'), $project);
        $message = $project->message;

        
        ////////////
        /// SUBTASKS
        ////////////

        // CREATE ARRAY OF NEW TASKS FROM INPUT
        $input = Input::all();
        $newTask = array();

        foreach ($input as $key => $value) {
            if(strpos($key, 'newTask_') !== false) {

                echo $key . ': ';
                var_dump($value); 
                echo '<br />';
                
                // Get the task number
                $taskNum = explode('_', $key)[1];
                echo 'TaskNum:'. $taskNum; 
                $newKey = explode( 'newTask_' . $taskNum . '_', $key )[1];
                echo 'NewKey:'. $newKey; 

                // create subarray if needed
                if (empty($newTask[$taskNum])) {
                    $newTask[$taskNum] = array();
                }

                // add to subarray
                $newTask[$taskNum][$newKey] = $value;


                echo '<br />';
                echo '<br />';
            }
        }

        echo "<br />\n<br />\n";

        // CREATE TASK FOR EACH NEW TASK IN THE ARRAY

        // TODO: Handle validation issues on a per-task basis
        // For now, just validate each and redirect back if one fails
        foreach ($newTask as $task) {
            $sequence++;

            $data = array(
                'user_id' => $user,
                'parent_project_id' => $parentProjectId,
                'sequence' => $sequence,
                'description' => $task['description']
            );

            if (!empty($task['completed'])) {
                $data['completed'] = $task['completed'];
            }

            // Validate user input
            // TODO: Move validation into model
            $validator = Project::validate($data);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $project = Project::storeProject($data, $task['context']);

        }

        return Redirect::to('/home')->with('message', $message);

    }

}
