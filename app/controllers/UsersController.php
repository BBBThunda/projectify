<?php

class UsersController extends BaseController {

        /*
        |--------------------------------------------------------------------------
        | Users Controller
        |--------------------------------------------------------------------------
        |
        |
        */

        public function create()
        {
            return View::make('users.create');
        }

        public function delete()
        {
            Auth::logout();
            return Redirect::to('login');
        }

        public function store()
        {
            /*if (Auth::attempt(Input::only('email', 'password')))
            {
               return Redirect::to('account');
            }

            // TODO: add an error message flash here 

            // Re-display login form
            return Redirect::back()->withInput();
             */
        }
}
