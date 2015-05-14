<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    if (Auth::check()) {
        return Redirect::to('/home');
    }
    return View::make('pages.home');
});
Route::get('/contribute', function() {
    return View::make('pages.contribute');
});
Route::get('/about', function() {
    return View::make('pages.about');
});

Route::resource('sessions', 'SessionsController');
Route::get('/login', 'SessionsController@create');
Route::get('/logout', 'SessionsController@destroy');

//Projects
Route::get('/home', 'ProjectsController@home')->before('auth');
Route::get('/addProject', 'ProjectsController@add')->before('auth');
Route::post('/projects', [
    'as' => 'projects.store',
    'uses' => 'ProjectsController@store'
    ])->before(['auth', 'csrf']);
Route::post('/storeProject', [
    'as' => 'projects.storeProject',
    'uses' => 'ProjectsController@storeProject'
    ])->before(['auth', 'csrf']);
Route::post('/projects/setCompleted', 'ProjectsController@setCompleted')->before(['auth', 'csrf']);
Route::post('/resequence', [
    'as' => 'projects.resequence',
    'uses' => 'ProjectsController@resequence'
    ])->before(['auth', 'csrf']);
//Route::resource('projects', 'ProjectsController');
Route::get('/projectify/{project_id}', 'ProjectsController@projectify')->before('auth');

//Contexts
Route::post('/contexts', 'ContextsController@addContext')
	->before(['auth', 'csrf']);
Route::delete('/contexts/{contextId}', 'ContextsController@removeContext')
	->before(['auth', 'csrf']);

Route::resource('users', 'UsersController');

//Stuff to be moved to Profile controller
Validator::extend('password', 'User@validatePassword');
Route::post('users.store','UsersController@store')->before('csrf');
Route::get('verifyEmail/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'UsersController@verifyEmail'
    ]);
Route::get('/unverified', 'UsersController@unverified');
Route::get('/resend', [
    'as' => 'resendVerificationMail',
    'uses' => 'UsersController@resend'
    ]);
Route::get('/register','UsersController@register');
Route::get('/forgotPassword', 'RemindersController@getRemind');
Route::get('/editProfile', 'UsersController@editProfile')->before('auth');
Route::post('/updateProfile', 'UsersController@updateProfile')->before(['auth','csrf']);

Route::controller('password', 'RemindersController');


if($app->env != 'live') {
    Route::get('/test', 'TestsController@test');
    Route::post('/test', 'TestsController@test');
}
            
