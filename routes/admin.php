<?php

Route::resource('users', 'UserController');

Route::get('/membership-types', 'MembershipTypeController@index')->name('admin.membership-types');
Route::post('/memberships', 'MembershipController@store')->name('admin.membership.create');
