<?php

namespace App\Http\Controllers;

use Validator;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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

$model_class = new Project;

$model_name = 'project';

if($request){
	$validator = Validator::make($request->all(), [ 
		'name' => 'required|min:3', 
	
	]); 

	if ($validator->fails()) { 
		return $validator->errors();
	}
	$arr = [ 
        'name' => $request->name,
        'client_id' => $request->client_id,
        'status_id' => $request->status_id,
        'comments' => $request->comments,
        'user_id' => $request->user_id
     ];
	
}

switch ($action) {

//  code to update------------------------------------------------------

    case 'u':    

		$updated = $model_class::where('id',$id)->update($arr);

		$record = $model_class::where('id',$id)->first();

		list($status,$msg)  = ($updated) ? [true,$model_name.' has been updated'] : [false,$model_name.' cannot update'];	
        $record->client = $record->client;

        $record->status = $record->status;  
         $ok  = $record->progress()->orderBy('id', 'DESC')->first();  
            if (!$ok) {
                $record->progress = ['progress' => 0];
            } 
            else{
                 $record->progress;
            }  
            
		return [ 'response_status' => $status, 'message' => $msg, 'updated_record' => $record ];

        break;

//  code to create------------------------------------------------------

    case 'c':   

		$record = $model_class::create($arr); 

		list($status,$msg)  = ($record) ? [true,$model_name.' has been created'] : [false,$model_name.' cannot create'];
        $record->client = $record->client;
        $record->status = $record->status;  
        $record->user = $record->user;  
          $ok  = $record->progress()->orderBy('id', 'DESC')->first();  
            if (!$ok) {
                $record->progress = ['progress' => 0];
            } 
            else{
                 $record->progress;
            }  
		return [ 'response_status' => $status, 'message' => $msg, 'new_record' => $record ];

        break;

//  code to delete----------------------------------------------------------

    case 'd':   

		list($status,$msg)  = $model_class::find($id)->delete() ? [true,$model_name.' has been deleted'] : [false,$model_name.' cannot delete'];

		return [ 'response_status' => $status, 'message' => $msg ];

        break;

//  code to read-------------------------------------------------------------

    default: 	

       $records = $model_class::all();  
       // $users = [];
        foreach($records as $record){

            $record->client = $record->client;
            $record->status = $record->status;  
            // foreach($record->user_id as $user_id){
            //     $users[] = \App\User::find($user_id);
            // }
            // $record->user = $users;
            $record->user = $record->user;  
          
            $ok  = $record->progress()->orderBy('id', 'DESC')->first();  
            if (!$ok) {
                $record->progress = ['progress' => 0];
            } 
            else{
                 $record->progress;
            }
            
        }
      return $records;
              
	}
}
}
