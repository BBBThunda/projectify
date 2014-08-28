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
     * Show "create a new project" form
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

    public function store()
    {
        // Validate inputs
        $error = true;

        if ($error == false){

            /*if (id provided){
                //update
            }
            else {
                //insert
            }*/

        }

        // Need to figure out if L4 uses flash errors, etc.
        return Redirect::to('home');

    }

    public function delete()
    {
    }

    /**
     * home
     * This is where the magic happens - well eventually anyway :)
     *
     * @return Response
     */
    public function home()
    {

        // Display home screen page
        return View::make('projects.home');
 
    }
}
