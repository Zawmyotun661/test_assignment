<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('api')->check()){
        $employee = Employee::all();
        return response($employee, 200);
        }
        return response(['data'=> 'Unauthenticate']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    if(Auth::guard('api')->check()){
        $request->validate([
            'name' => 'required',
            'email'=> 'required',
            'phone' => 'required',
            'address' => 'required',
            'salary' =>'required'
        ]);
        $input = $request->all();
        $employee= Employee::create($input);
         return response()->json($employee, 200);
    }
        return response('Error',500);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::guard('api')->check()){
            $request->validate([
                'name' => 'required',
                'email'=> 'required',
                'phone' => 'required',
                'address' => 'required',
                'salary' =>'required'
            ]);
            $employee = Employee::find($id);
            $input = $request->all();
           $employee->update($input);

        return response()->json('Success', 200);
        }
        $response= ['messages' => 'Can not update this employee'];
        return response($response,4);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::guard('api')->check()){
        Employee::find($id)->delete();

        return response ('Successfully deleted');
        }
        return response (['messages'=> 'can not delete']);
    }
}
