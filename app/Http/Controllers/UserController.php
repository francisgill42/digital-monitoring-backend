<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Role;

class UserController extends Controller
{
public function __construct()
{
	$this->middleware('auth:api')->except('register','login','logout');
}

public function store(Request $request)
{
	return $this->worker($request,null,'c');
}

public function index()
{
	return $this->worker(null,null,'r');
}

public function update(Request $request,$id)
{
	return $this->worker($request,$id,'u');
}

public function destroy($id){

	return $this->worker(null,$id,'d');
}

public function worker($request = null,$id = null,$action = null)
{

//return $request->all();
$model_name = 'user';

if($request){
	$validator = Validator::make($request->all(), [ 
		'name' => 'required|min:3|max:15', 
		'email' =>'required|email|unique:users', 
		'password' => $id ? 'min:8|max:20' : 'required|min:8|max:20', 
		'role_id' => 'required'
	]); 

	if ($validator->fails()) { 
		return $validator->errors();
	}
	$arr = [
		'name' => $request->name,
		'email' => $request->email,
		'master' => 0,
		'role_id' => $request->role_id
	];
	if ($request->password) {
		$arr['password'] = bcrypt($request->password);
	}
}

	

switch ($action) {

//  code to update------------------------------------------------------

    case 'u':    

		$updated = User::where('id',$id)->update($arr);

		$user = User::where('id',$id)->first();

		list($status,$msg)  = ($updated) ? [true,$model_name.' has been updated'] : [false,$model_name.' cannot update'];	

		$user->role = $user->role;

		return [ 'response_status' => $status, 'message' => $msg, 'updated_record' => $user ];

        break;

//  code to create------------------------------------------------------

    case 'c':   

		$user = User::create($arr); 

		list($status,$msg)  = ($user) ? [true,$model_name.' has been created'] : [false,$model_name.' cannot create'];

		$user->role = $user->role;

		return [ 'response_status' => $status, 'message' => $msg, 'new_record' => $user ];

        break;

//  code to delete----------------------------------------------------------

    case 'd':   

		list($status,$msg)  = User::find($id)->delete() ? [true,$model_name.' has been deleted'] : [false,$model_name.' cannot delete'];

		return [ 'response_status' => $status, 'message' => $msg ];

        break;

//  code to read-------------------------------------------------------------

    default: 	

		$users = User::has('role')->get();	

		foreach ($users as $user) {

			$user->role = $user->role;
		}
	
		return $users;        
	}
}
}
