<?php

class EmployeeController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        
        $Employees = Employee::with(array('employee_identity_doc', 'employee_doc'))->get();

        return Response::json(
            array(
                'error' => false,
                'employees' => $Employees->toArray()
            ),
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){
        $Employee = new Employee;

        $Employee->title_id = Request::json('title_id');
        $Employee->first_name = Request::json('first_name');
        $Employee->last_name = Request::json('last_name');
        $Employee->sex_id = Request::json('sex_id');
        $Employee->country_code = Request::json('country_code');
        $Employee->date_of_birth = Request::json('date_of_birth');
        $Employee->mobile_phone_number = Request::json('mobile_phone_number');
        $Employee->school = Request::json('school');
        $Employee->join_date = Request::json('join_date');
        $Employee->race_id = Request::json('race_id');
        $Employee->status_id = Request::json('status_id');
        $Employee->work_pass_type_id = Request::json('work_pass_type_id');

        //$Employee->user_id = Auth::user()->id;
     
        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.
     
        $Employee->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Employee created',
                'action' => 'insert',               
                'employee' => $Employee->toArray()
            ),
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){
        // Make sure current user owns the requested resource
        $Employee = Employee::where('id', $id)
                ->take(1)
                ->get();
     
        return Response::json(
            array(
                'error' => false,
                'employees' => $Employee->toArray()
            ),
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

var_dump(Request::json());die();

        $Employee = Employee::find($id);
     
        if ( Request::json('title_id') ){
            $Employee->title_id = Request::json('title_id');
        }

        if ( Request::json('first_name') ){
            $Employee->first_name = Request::json('first_name');
        }

        if ( Request::json('last_name') ){
            $Employee->last_name = Request::json('last_name');
        }

        if ( Request::json('sex_id') ){
            $Employee->sex_id = Request::json('sex_id');
        }

        if ( Request::json('country_code') ){
            $Employee->country_code = Request::json('country_code');
        }

        if ( Request::json('date_of_birth') ){
            $Employee->date_of_birth = Request::json('date_of_birth');
        }

        if ( Request::json('mobile_phone_number') ){
            $Employee->mobile_phone_number = Request::json('mobile_phone_number');
        }

        if ( Request::json('school') ){
            $Employee->school = Request::json('school');
        }

        if ( Request::json('join_date') ){
            $Employee->join_date = Request::json('join_date');
        }

        if ( Request::json('race_id') ){
            $Employee->race_id = Request::json('race_id');
        }

        if ( Request::json('status_id') ){
            $Employee->status_id = Request::json('status_id');
        }

        if ( Request::json('work_pass_type_id') ){
            $Employee->work_pass_type_id = Request::json('work_pass_type_id');
        }

        $Employee->id = $id;
     
        $Employee->save();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Employee updated',
                'action' => 'update',
                'employee' => $Employee->toArray()
            ),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

        $Employee = Employee::find($id);
        $EmployeeIdentityDoc = EmployeeIdentityDoc::where('employee_id', $id);
        
        $EmployeeIdentityDoc->delete();
        $Employee->delete();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Employee deleted',
                'action' => 'delete',
                'employee' => $Employee->toArray()
                ),
            200
        );
    }

}