<?php

namespace App\Http\Controllers;

use Validator;
use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
   
    public function index()
    {
        return $this->worker(null,null,'v');
    }

    public function store(Request $request)
    {
        return $this->worker($request,null,'c');
    }

    public function update(Request $request, $id)
    {
        return $this->worker($request,$id,'u');
    }

    public function destroy($id)
    {
        return $this->worker(null,$id,'d');
    }

public function worker($request = null,$id = null,$action = null)
{
$model_class = new Client;
$model_name = 'client';

if($request){
	$validator = Validator::make($request->all(), [ 
		'client' => 'required|min:3|max:15', 
	
	]); 

	if ($validator->fails()) { 
		return $validator->errors();
	}
	$arr = [ 'client' => $request->client ];
	
}

switch ($action) {

//  code to update------------------------------------------------------

    case 'u':    

		$updated = $model_class::where('id',$id)->update($arr);

		$record = $model_class::where('id',$id)->first();

		list($status,$msg)  = ($updated) ? [true,$model_name.' has been updated'] : [false,$model_name.' cannot update'];	

		return [ 'response_status' => $status, 'message' => $msg, 'updated_record' => $record ];

        break;

//  code to create------------------------------------------------------

    case 'c':   

		$record = $model_class::create($arr); 

		list($status,$msg)  = ($record) ? [true,$model_name.' has been created'] : [false,$model_name.' cannot create'];

		return [ 'response_status' => $status, 'message' => $msg, 'new_record' => $record ];

        break;

//  code to delete----------------------------------------------------------

    case 'd':   

		list($status,$msg)  = $model_class::find($id)->delete() ? [true,$model_name.' has been deleted'] : [false,$model_name.' cannot delete'];

		return [ 'response_status' => $status, 'message' => $msg ];

        break;

//  code to read-------------------------------------------------------------

    default: 	

		return $model_class::all();        
	}
}
}
