<?php

Route::resource('users', 'UserController');

Route::get('/membership-types', 'MembershipTypeController@index')->name('admin.membership-types');
Route::post('/memberships', 'MembershipController@store')->name('admin.membership.store');
Route::get('/memberships/{membershipTypeId}/create', 'MembershipController@create')->name('admin.memberships.create');
