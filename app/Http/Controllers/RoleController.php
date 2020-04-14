<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('register','login','logout');
	}


    public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        $created = Role::create(['role' => $request->role]);

        if ($created) {
         return response()->json([
            'response_status' => true,
            'message' => 'role has been inserted', 
            'new_record' => Role::find($created->id)
     ]);

    }
    else{
        return response()->json([
            'response_status' => false,
            'message' => 'role cannot create', 
     ]);
    }

      
}

    public function update(Request $request,$id){

        $updated = Role::where('id',$id)->update(['role' => $request->role]);

        if ($updated) {

         return response()->json([
            'response_status' => true,
            'message' => 'role has been updated', 
            'updated_record' => Role::find($id)
         ]);

    }
    else{
        return response()->json([
            'response_status' => false,
            'message' => 'role cannot update', 
     ]);
    }

}

    public function destroy(Role $role){


        return (Role::find($role->id)->delete()) 
                ? [ 'response_status' => true,  'message' => 'role has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'role cannot delete' ];
            

    }
}
