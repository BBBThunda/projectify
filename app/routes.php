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
    return View::make('hello');
});

Route::get('/register','UsersController@register');

Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');
Route::resource('sessions', 'SessionsController');

//Route::resource('account', 'AccountController');

Route::get('account', function()
    {
        $buffer = 'My Account';
        $buffer .= "\n";
        $buffer .= '<a href="/logout">Log Out</a>';

        return $buffer;
    })->before('auth');
