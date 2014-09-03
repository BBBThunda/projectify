<?php

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
            return View::make('projects.add');
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
            'parent_project' => null,
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
            $project = Project::create($data);
            $project->save();
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
