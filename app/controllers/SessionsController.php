<?php

class SessionsController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Sessions Controller
    |--------------------------------------------------------------------------
    |
    |
     */

    public function create()
    {
        return View::make('sessions.create');
    }

    public function destroy()
    {
        Auth::logout();
        return Redirect::to('login');
    }

    public function store()
    {
        if (Auth::attempt(Input::only('email', 'password'), Input::has('remember')))
        {
            if (User::find((int)Auth::id())->confirmed) {
                return Redirect::to('/home');
            }
            else {
                // User still needs to verify email address
                Session::flash('unverifiedUserId', (int)Auth::id());
                Auth::logout();
                return Redirect::to('/unverified');
            }
        }

        //TODO: add an error message flash here
        Session::flash('error', 'The email/password combination was not found in our system.');

        // Re-display login form
        return Redirect::to('/login')->withInput();
    }

}
