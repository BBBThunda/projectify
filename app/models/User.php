<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    //protected $table = 'users';

    protected $fillable = ['display_name', 'email', 'password', 'confirmation_code'];




    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    public function validatePassword($attribute, $value, $parameters) {

        if ( !preg_match('/[0-9]/', $value) ) { 
            return false; 
        }

        if ( !preg_match('/[a-z]/', $value) ) { 
            return false; 
        }

        if ( !preg_match('/[A-Z]/', $value) ) { 
            return false; 
        }

        if ( !preg_match('/[!@#$%^&*`~\-+=]/', $value) ) { 
            return false; 
        }

        return true;
    }




    /**
     * Validate inputs before allowing create
     *
     * @param array() $data
     * @return Validator
     */
    public static function validate($data, $userId = null)
    {

        // Validation rules
        if (empty($userId))
        {

            // Insert
            $rules = array(

                'email' => array('required', 'email', 'unique:users'),
                'display_name' => array('required', 'alpha_num', 'min:3', 'max:32', 'unique:users'),
                'password' => array('required', 'confirmed', 'min:8', 'max:128', 'password')
                
            );
        }
        else
        {

            // Update
            $rules = array(

                'display_name' => array(
                    'alpha_num', 'min:3', 'max:32', 'unique:users,display_name,' . $userId),
                'password' => array('confirmed', 'min:8', 'max:128', 'password')
            
            );

        }

        // Custom error messages
        // Todo: figure out proper DRY place to put this
        $messages = array(

            'password' => 'Password must contain at least one of each: <ul>'
            . '   <li>lower</li>'
            . '   <li>upper</li>'
            . '   <li>number</li>'
            . '   <li>special</li>'
            . '</ul>'

        );

        // Validate input data
        return Validator::make($data, $rules, $messages);
    }




    /**
     * confirmEmail
     * Process the confirmation of an email address
     * -Happens when user browses to the link in their welcome email
     *
     * @param string $confirmation_code
     * @return bool
     */
    public static function confirmEmail($confirmation_code)
    {
        if( !$confirmation_code ) {
            throw new NoConfirmationCodeException;
        }

        // Find the user with the provided confirmation code
        $user = User::whereConfirmationCode($confirmation_code)->first();

        if( !$user ) {
            throw new UnknownConfirmationCodeException;
        }
        if ($user->updated_at->diffInMinutes() > 60) {
            throw new ExpiredConfirmationCodeException;
        }

        // Update the user
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

    }





    /**
     * updateForgottenPassword
     *
     *
     * @param string $password
     * @param DB $reminder
     */
    public function updateForgottenPassword($password, Reminder $reminder)
    {

        // Update password
        $this->password = Hash::make(Input::get('password'));
        if ($this->save()) {
            // If successful, delete the reminder
            $reminder->delete(); 
        }
    }




}
