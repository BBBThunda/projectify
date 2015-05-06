<?php

use Carbon\Carbon;

class RemindersController extends Controller {

    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function getRemind()
    {
        return View::make('password.remind');
    }




    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postRemind()
    {
        $response = Password::remind(Input::only('email'), function($message) {
            $message->subject('Reset your Projectify Password');
        });

        switch ($response)
        {
        case Password::INVALID_USER:
            return Redirect::back()->with('error', Lang::get($response));

        case Password::REMINDER_SENT:
            return Redirect::back()->with('status', Lang::get($response));
        }
    }




    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        // We should USE the token, not just check for its existence
        if (is_null($token)) {
            Log::error('Missing token');
            App::abort(404);
        }

        $reminder = DB::table('password_reminders')->where('token', $token)->first();

        if (is_null($reminder)) {
            Log::error('Invalid token');
            App::abort(404);
        }
        $tokenExpired = false;
        $created = new Carbon($reminder->created_at);
        if ($created->diffInMinutes() > 60) {
            Redirect::back()->with('tokenExpired', true);
        }

        $user = User::where('email', $reminder->email)->first();

        if (is_null($user)) {
            Log::error('Invalid User');
            App::abort(404);
        }

        return View::make('password.reset')
            ->with('email', $user->email)
            ->with('token', $token);
    }




    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {

        $credentials = Input::only(
            'email', 'password', 'password_confirmation'
        );

        $email = Input::get('email');
        $token = Input::get('token');
        $reminder = Reminder::where('token', $token)->first();

        if (is_null($reminder)) {
            Log::error('A reminder with this token was not found');
            App::abort(404);
        }

        $created = new Carbon($reminder->created_at);
        if ($created->diffInMinutes() > 60) {
            Log::warning('Token has expired');
            Redirect::back()->with('tokenExpired', true);
        }
        if ($email != $reminder->email) {
            Log::error('Reminder for token does not match email');
            App::abort(404);
        }

        // Default success message
        $message = 'Password updated successfully! Please sign in with your new password.';

        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            Log::error('Invalid user');
            App::abort(404);
        }

        // Validate user input
        $validator = User::validate($credentials, $user->id);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update database
        try {
            $user->updateForgottenPassword(Input::get('password'), $reminder);
        }
        catch (Exception $e) {
            $message = 'Sorry, we were unable to update your password: '
                . $e->getMessage();
            Log::error($message);
            return Redirect::back()
                ->withInput()
                ->with('status', $message);
        }

        // If successful, direct user to login page w/ message
        return Redirect::to('/login')->with('status', $message);

    }

}
