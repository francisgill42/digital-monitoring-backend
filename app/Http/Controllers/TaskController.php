<?php

namespace App\Http\Controllers;

use Validator;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   
    public function index()
    {
        return $this->worker(null,null,'v');
    }

    public function show($id)
    {
        return $this->worker(null,$id,'s');
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
$model_class = new Task;

$model_name = 'task';

if($request){
    $validator = Validator::make($request->all(), [ 
        'task' => 'required|min:3',
        'comments' => 'max:150'
    ]); 

    if ($validator->fails()) { 
        return $validator->errors();
    }
    $arr = [ 
        'task' => $request->task,
        'comments' => $request->comments,
        'project_id' => $request->project_id,
        'status_id' => $request->status_id,
        'assigned_by' => $request->assigned_by,
        'user_id' => $request->user_id
     ];
    
}

switch ($action) {

//  code to update------------------------------------------------------

    case 'u':    

        $updated = $model_class::where('id',$id)->update(['status_id' => $request->status_id]);

        $record = $model_class::where('id',$id)->first();

        list($status,$msg)  = ($updated) ? [true,$model_name.' has been updated'] : [false,$model_name.' cannot update'];   

        return [ 'response_status' => $status, 'message' => $msg, 'updated_record' => $record ];

        break;

//  code to create------------------------------------------------------

    case 'c':   

        $record = $model_class::create($arr); 

        $record->project = $record->project;
        $record->status = $record->status;  
        $record->user = $record->user;  
        $record->assigned_by_user = $record->assigned_by_user; 

        list($status,$msg)  = ($record) ? [true,$model_name.' has been created'] : [false,$model_name.' cannot create'];

        return [ 'response_status' => $status, 'message' => $msg, 'new_record' => $record ];

        break;

//  code to delete----------------------------------------------------------

    case 'd':   

        list($status,$msg)  = $model_class::find($id)->delete() ? [true,$model_name.' has been deleted'] : [false,$model_name.' cannot delete'];

        return [ 'response_status' => $status, 'message' => $msg ];

        break;

//  code to show single record-----------------------------------------------        
    case 's':   


        $records = $model_class::where('user_id',$id)->orderBy('id','DESC')->get(); 

        foreach($records as $record){

            $record->project = $record->project;
            $record->status = $record->status;  
            $record->user = $record->user;  
            $record->assigned_by_user = $record->assigned_by_user; 
          
        }
        return $records;        
        break;

//  code to read-------------------------------------------------------------

    default:    

          $records = $model_class::orderBy('id','DESC')->get();  

        foreach($records as $record){

            $record->project = $record->project;
            $record->status = $record->status;  
            $record->user = $record->user;  
            $record->assigned_by_user = $record->assigned_by_user; 
          
            // $ok  = $record->progress()->orderBy('id', 'DESC')->first();  
            // if (!$ok) {
            //     $record->progress = ['progress' => 0];
            // } 
            // else{
            //      $record->progress;
            // }
            
        }
      return $records;        
    }
}
}
