<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


/**
 * Removed routes belonging to admin lte package.
 */
Route::get('/home', function () {
    abort(404);
});

Route::get('register', function () {
    abort(404);
});

Route::post('register', function () {
    abort(404);
});

Route::get('/', 'HomeController@index');


/*
 * Activate account routes
 */

Route::get('/activation/account/{token}', 'Auth\ActivationController@activate')->name('auth.activate.account');
