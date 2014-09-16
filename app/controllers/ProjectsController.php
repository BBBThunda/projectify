<?php

use Carbon\Carbon;

class ProjectsController extends BaseController {

    /*
     * ------------------------------------
     * Projects Controller
     * ------------------------------------
     *
     */

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {

        $this->beforeFilter('auth', array('except' => 'login'));

    }




    /**
     * add
     * Show "create a new project" form
     *
     * @return Response
     */
    public function add()
    {
        if (Auth::check())
        {
            // Get contexts
            $contexts = Context::getUserContexts(Auth::id());

            // Pass to view
            return View::make('projects.add')->with('contexts', $contexts);;
        }
    }


    public function show() {
        dd('wtf?!?!');
    }


    public function edit()
    {
    }





    /**
     * store
     * Validate POST data and create a new project
     *
     * @return Response
     */
    public function store()
    {
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

        // Create project
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

            // Get selected contexts and insert into junction table
            // TODO: Find out if there's a way to optimize this
            if (Input::has('context')) {
                $contexts = Input::get('context');
                $time = new Carbon;
                foreach($contexts as $context) {
                    // TODO: Request enhancement to handle timestamps
                    // or to update projects.updated_at when making changes to junction table
                    // NOTE: either way, we can't see when a context is removed unless we add
                    // an 'active' field to the junction table or something
                    $project->contexts()->attach($context, array(
                        'created_at' => $time,
                        'updated_at' => $time
                    ));
                }
                $project->save();
            }

            // Tags
            

            // Roadblocks


        }
        catch (Exception $e) {
            $message = 'Sorry, we were unable to create the user due to the following issue: '
                . $e->getMessage();
        }

        return Redirect::to('/home')->with('message', $message);

    }

    public function delete()
    {
    }





    /**
     * home
     * This is where the magic happens - well eventually anyway :)
     *
     * @param $message
     * @return Response
     */
    public function home($message = null)
    {
        // Get projects for this user
        $projects = Project::where('user_id', Auth::id())->get();

        //dd($projects);

        // Display home screen page
        return View::make('projects.home')->with('projects', $projects);

    }
}
