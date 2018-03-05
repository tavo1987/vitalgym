<?php

Route::resource('users', 'UserController');

Route::get('/membership-types', 'MembershipTypeController@index')->name('membership-types');
Route::post('/memberships', 'MembershipController@store')->name('membership.create');
