<?php

class UsersController extends BaseController {

    /*
    |------------------
    | Users Controller
    |------------------
    |
    |
    */

    /**
     * Display registration page
     *
     * @return Response
     */
    public function register()
    {
        return View::make('users.register');
    }




    /**
     * Store a newly created User
     *
     * @return Response
     */
    public function store()
    {

        // Validate user input
        $validator = User::validate(Input::all());
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user
        try {
            $user = User::create([
                'email' => Input::get('email'),
                'display_name' => Input::get('display_name'),
                'password' => Hash::make(Input::get('password'))
                ]);
        }
        catch (Exception $e) {
            $message = 'Sorry, we were unable to create the user due to the following issue: '
            . $e->getMessage();
        }

        if (!$this->sendVerificationMail($user)) {
            return View::make('users.sendVerificationFail');
        }

        return View::make('users.welcome');
    }




    /**
     * sendVerificationMail
     * Send an email to verify user's email address
     *
     * @param User
     * @return Boolean
     */
    public function sendVerificationMail($user) {

        if (!$user) {
            dd('no user');
            return false;
        }
        
        if ($user->confirmed == 1) {
            dd($user->confirmed);
            return false;
        }

        $user->confirmation_code = str_random(255);
        $user->save();

        $data = array(
            'display_name' => $user->getAttribute('display_name'),
            'confirmation_code' => $user->getAttribute('confirmation_code')
        );

        // Send confirmation email
        Mail::send('emails.auth.welcomeHtml', $data, function($message) use ($user)
        {
            $message->to($user->getAttribute('email'))
                ->subject('Welcome to Projectify! Please confirm your email.');
        });

        return true;
        
    }




    /**
     * resend
     * Resend verification email - requires flash key 'unverifiedUserId' to be populated.
     *
     * @return Response
     */
    public function resend()
    {
        // User should not be logged in at this point
        if (Auth::check()) {
            return Redirect::to('/home');
        }
        // Don't allow direct browsing
        if (!Session::has('unverifiedUserId')) {
            //throw new NoUserForResendException;
            return Redirect::to('/login');
        }

        // Look up user
        $user = User::find(Session::get('unverifiedUserId'));

        if (!$user) {
            return 'User ' . Session::get('unverifiedUserId') . ' not found';
        }
        
        if (!$this->sendVerificationMail($user)) {
            return 'There was a problem sending the verification email for this user.  Please try logging in and you will be given a link to resend the welcome email.';
        }

        return 'A new verification link has been sent to your email address. Any previous links are no longer valid and this one will remain valid for 60 minutes.  Please check your email and browse to the link provided.';
        
    }




    /**
     * verifyEmail
     * Verify a new user's email address is legitimate
     *
     * @param String $confirmation_code
     * @return Response
     */
    public function verifyEmail($confirmation_code)
    {

        // Default message if there are no errors
        $message = 'Your email address has been verified.  You may now <a href="/login">log in</a>.  Welcome to the Projectify community!';

        try {
            User::confirmEmail($confirmation_code);
        }
        catch (Exception $e) {
            //TODO: This is broken: $e->getMessage() returns nothing
            //(probably need to edit the custom exceptions)
            $message = 'Sorry, the email address could not be verified because '
                . $e->getMessage();
        }
        finally {
            return View::make('users.verified')->with('message', $message);
        }
    }




    /**
     * unverified
     * User is logged in but email has not been verified
     *
     * @return Response
     */
    public function unverified()
    {
        // User should not be logged in at this point
        if (Auth::check()) {
            return Redirect::to('/home');
        }

        // Display "unverified" form
        if (Session::has('unverifiedUserId')) {
            Session::keep('unverifiedUserId');
            return View::make('users.loggedInUnverified');
        }

        // Don't allow people to browse directly
        return Redirect::to('/');
    }




    /**
     * editProfile
     * Display form for logged in user to edit their profile
     *
     * @return Response
     */
    public function editProfile()
    {
        
        If (Auth::guest()) {
            return Redirect::to('/login');
        }

        $user = User::find(Auth::id());

        return View::make('users.editProfile')->with('user', $user);

    }




    /**
     * updateProfile
     * Update logged in user's profile
     *
     * @return Response
     */
    public function updateProfile()
    {

        // Default success message
        $message = 'Profile updated successfully!';

        $user = User::find(Auth::id());

        // Validate user input
        $validator = User::validate(Input::all(), $user->id);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user table
        try {
            $user->display_name = Input::get('display_name');
            $user->password = Hash::make(Input::get('password'));
            $user->save();
        }
        catch (Exception $e) {
            $message = 'Sorry, we were unable to update this profile due to the following issue: '
                . $e->getMessage();
            return Redirect::back()->with('message', $message);
        }

        return Redirect::to('/home')->with('message', $message);

    }




    /**
     * List Users - Administrators
     *
     * @return Response
     */
    public function index()
    {
        die('users.index');
    }

    /**
     * Create User - Administrators
     *
     * @return Response
     */
    public function create()
    {
        return Redirect::to('register');
    }

    /**
     * Display a specific User - Administrators
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        die('users.show');
    }

    /**
     * Display the Edit User form - Administrators
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return View::make('users.edit');
    }

    /**
     * Update User in DB
     *
     * @param int $id
     * @return Response
     */
    public function update($id)
    {
        //Todo
    }

    /**
     * Prompt user to confirm delete
     *
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
       //Todo 
    }



    
    /**
     * destroy
     * Delete User from DB
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        
        $user = User::find($id);
        $result = $user->delete();

        if ($result == false)
        {
            // Throw error
            return ('Error deleting user');
        }

        Auth::logout();

        return ('User deleted successfully');
    }

}
