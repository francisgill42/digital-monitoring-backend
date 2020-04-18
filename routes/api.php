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

Route::resource('records', 'RecordController');

Route::get('fetch',function(){
$file = fopen(public_path().'/Book2.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  
  \App\Record::create([
  	'country' => $line[0],
  	'cases' => $line[1],
  	'deaths' => $line[2],
  	'recovered' => $line[3],
  ]);
}
fclose($file);
});
