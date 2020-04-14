<?php

        namespace App\Http\Controllers;

        use App\Customer;
        use Illuminate\Http\Request;
        use Validator;
        use DB;

        class CustomerController extends Controller
        {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(){

            return Customer::all();
        
        }


        /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {
        $validator = Validator::make($request->all(), [ 
        'customer_name' => 'required', 
        'customer_cell' => 'required'
        ]); 
        if ($validator->fails()) { 

        return response()->json([
        'response_status' => false,
        'errors' => $validator->errors()

        ]); 

        }


        $success = Customer::create([
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,
        'customer_cell' => $request->customer_cell,
        'customer_address' => $request->customer_address
        ]);
        return response()->json([
        'response_status' => true,
        'message' => 'customer has been created',
        'new_record' => Customer::find($success->id)

        ]); 


        }

        /**
        * Display the specified resource.
        *
        * @param  \App\Customer  $customer
        * @return \Illuminate\Http\Response
        */
        public function show(Customer $customer)
        {
        //
        }

        
        /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \App\Customer  $customer
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, Customer $customer)
        {
        $updated = DB::table('customerS')->where('id',$customer->id)->update(

        [
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,
        'customer_cell' => $request->customer_cell,
        'customer_address' => $request->customer_address,
        'updated_at' => now()
        ]

        );

        if ($updated) {

        return response()->json([
        'response_status' => true,
        'message' => 'customer has been updated', 
        'new_record' => DB::table('customers')->where('id',$customer->id)->first()
        ]);

        }
        else{
        return response()->json([
        'response_status' => false,
        'message' => 'customer cannot update', 
        ]);            
        }
        }

        /**
        * Remove the specified resource from storage.
        *
        * @param  \App\Customer  $customer
        * @return \Illuminate\Http\Response
        */
        public function destroy(Customer $customer)
        {

        return (DB::table('customers')->where('id',$customer->id)->delete()) 
                ? [ 'response_status' => true,  'message' => 'customer has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'customer cannot delete' ];
        

        }
        }
