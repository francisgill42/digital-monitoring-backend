<?php

use Illuminate\Http\Request;

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::get('me', 'AuthController@me');
Route::post('logout', 'AuthController@logout');


// Route::post('role', 'AuthController@role_insert');

Route::resource('user', 'UserController');
Route::resource('role', 'RoleController');

Route::resource('activity', 'ActivityController');
Route::resource('task', 'TaskController');
Route::resource('client', 'ClientController');
Route::resource('status', 'StatusController');
Route::resource('project', 'ProjectController');
Route::resource('progress', 'ProgressController');
