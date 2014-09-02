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
    return View::make('pages.home');
});

Route::resource('sessions', 'SessionsController');
Route::get('/login', 'SessionsController@create');
Route::get('/logout', 'SessionsController@destroy');

Route::resource('projects', 'ProjectsController');
Route::get('/home', 'ProjectsController@home')->before('auth');
Route::get('/addProject', 'ProjectsController@add')->before('auth');

Route::resource('users', 'UsersController');

//Stuff to be moved to Profile controller
Validator::extend('password', 'User@validatePassword');
Route::post('users.store','UsersController@store')->before('csrf');
Route::get('verifyEmail/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'UsersController@verifyEmail'
    ]);
Route::get('/unverified', 'UsersController@unverified')->before('auth');
Route::get('/resend', [
    'as' => 'resendVerificationMail',
    'uses' => 'UsersController@resend'
    ]);
Route::get('/register','UsersController@register');
Route::get('/forgotPassword', 'RemindersController@getRemind');
Route::get('/editProfile', 'UsersController@editProfile')->before('auth');
Route::post('/updateProfile', 'UsersController@updateProfile')->before(['auth','csrf']);

Route::controller('password', 'RemindersController');
