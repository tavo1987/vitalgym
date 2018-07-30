<?php

Route::get('/', 'HomeController@index');

/*
 *  Memberships
 */
Route::get('/plans', 'PlanController@index')->name('plans.index');

/**
 *Customers
 */
Route::get('/customer/memberships', 'CustomerMembershipController@index')->name('customer.memberships.index');

/*
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

/*
 * Activate account
 */
Route::get('/activation/account/{token}', 'Auth\ActivationController@activate')->name('auth.activate.account');
Route::get('/activate/resend/{email}', 'Auth\ActivationController@resend')->name('auth.activate.resend');
