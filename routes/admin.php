<?php

Route::resource('users', 'UserController');

//Plans
Route::get('/plans', 'PlanController@index')->name('admin.plans.index');

//Memberships
Route::get('/memberships', 'MembershipController@index')->name('admin.memberships.index');
Route::get('/memberships/{planId}/create', 'MembershipController@create')->name('admin.memberships.create');
Route::get('/memberships/{id}/details', 'MembershipController@show')->name('admin.memberships.show');
Route::get('/memberships/{id}/edit', 'MembershipController@edit')->name('admin.memberships.edit');
Route::post('/memberships/{planId}/', 'MembershipController@store')->name('admin.memberships.store');
Route::patch('/memberships/{membershipId}/', 'MembershipController@update')->name('admin.memberships.update');
