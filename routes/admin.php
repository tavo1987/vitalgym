<?php

Route::get('users', 'UserController@index')->name('admin.users.index');

//Levels
Route::resource('levels', 'LevelController');

//Routines
Route::resource('routines', 'RoutineController');
Route::post('download', 'RoutineController@downloadFile')->name('file.download');

//Plans
Route::get('/plans', 'PlanController@index')->name('admin.plans.index');
Route::get('/plans/create', 'PlanController@create')->name('admin.plans.create');
Route::get('/plans/{planId}/edit', 'PlanController@edit')->name('admin.plans.edit');
Route::post('/plans', 'PlanController@store')->name('admin.plans.store');
Route::patch('/plans/{planId}', 'PlanController@update')->name('admin.plans.update');
Route::delete('/plans/{planId}', 'PlanController@destroy')->name('admin.plans.destroy');

//Payments
Route::get('/payments', 'PaymentController@index')->name('admin.payments.index');

//Memberships
Route::get('/memberships', 'MembershipController@index')->name('admin.memberships.index');
Route::get('/memberships/{planId}/create', 'MembershipController@create')->name('admin.memberships.create');
Route::get('/memberships/{id}/details', 'MembershipController@show')->name('admin.memberships.show');
Route::get('/memberships/{id}/edit', 'MembershipController@edit')->name('admin.memberships.edit');
Route::post('/memberships/{planId}/', 'MembershipController@store')->name('admin.memberships.store');
Route::patch('/memberships/{membershipId}/', 'MembershipController@update')->name('admin.memberships.update');
Route::delete('/memberships/{membershipId}/', 'MembershipController@destroy')->name('admin.memberships.destroy');

//Membership Exports
Route::get('/memberships/exports/excel', 'MembershipExportController@excel')->name('admin.memberships-export.excel');

//Customers
Route::get('/customers', 'CustomerController@index')->name('admin.customers.index');
Route::get('/customers/create', 'CustomerController@create')->name('admin.customers.create');
Route::get('/customers/{id}/edit', 'CustomerController@edit')->name('admin.customers.edit');
Route::get('/customers/{customerId}/details', 'CustomerController@show')->name('admin.customers.show');
Route::post('/customers', 'CustomerController@store')->name('admin.customers.store');
Route::patch('/customers/{customerId}', 'CustomerController@update')->name('admin.customers.update');
Route::delete('/customers/{customerId}', 'CustomerController@destroy')->name('admin.customers.destroy');

//Attendances
Route::get('/attendances/', 'AttendanceController@index')->name('admin.attendances.index');
Route::get('/attendances/create', 'AttendanceController@create')->name('admin.attendances.create');
Route::post('/attendances', 'AttendanceController@store')->name('admin.attendances.store');
Route::delete('/attendances/{attendanceId}', 'AttendanceController@destroy')->name('admin.attendances.destroy');

//Membership Exports
Route::get('/customers/exports/excel', 'CustomerExportController@excel')->name('admin.customers-export.excel');

//Reports
Route::get('/reports', 'ReportController@index')->name('admin.reports.index');
