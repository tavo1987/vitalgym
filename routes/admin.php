<?php

Route::resource('users', 'UserController');

Route::get('/plans', 'PlanController@index')->name('admin.plans.index');
Route::get('/memberships', 'MembershipController@index')->name('admin.memberships.index');
Route::post('/memberships/{planId}/', 'MembershipController@store')->name('admin.memberships.store');
Route::get('/memberships/{planId}/create', 'MembershipController@create')->name('admin.memberships.create');
