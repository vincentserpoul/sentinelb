<?php

class EmployerDepartmentController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        $employer_id = Request::input('employer_id');        

        if($employer_id) $EmployerDepartments = $this->getDepartments($employer_id);
        else $EmployerDepartments = EmployerDepartment::get();    

        return Response::json(
            array(
                'error' => false,
                'EmployerDepartments' => $employer_id ? $EmployerDepartments : $EmployerDepartments->toArray()
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
        $EmployerDepartment = new EmployerDepartment;

        $EmployerDepartment->employer_id = Request::json('employer_id');
        $EmployerDepartment->label = Request::json('label');
        $EmployerDepartment->description = Request::json('description');
        $EmployerDepartment->work_type_id = Request::json('work_type_id');
        $EmployerDepartment->employee_hourly_rate = Request::json('employee_hourly_rate');
        $EmployerDepartment->employee_hourly_rate_currency_code = Request::json('employee_hourly_rate_currency_code');
        $EmployerDepartment->employer_hourly_rate = Request::json('employer_hourly_rate');
        $EmployerDepartment->employer_hourly_rate_currency_code = Request::json('employer_hourly_rate_currency_code');
        $EmployerDepartment->parent_id = Request::json('parent_id');

        //$EmployerDepartment->user_id = Auth::user()->id;
     
        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.
     
        $EmployerDepartment->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Department created',
                'action' => 'insert',
                'EmployerDepartment' => $EmployerDepartment->toArray()
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
        $EmployerDepartment = EmployerDepartment::where('id', $id)
                ->take(1)
                ->get();
     
        return Response::json(
            array(
                'error' => false,
                'EmployerDepartments' => $EmployerDepartment->toArray()
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

        $EmployerDepartment = EmployerDepartment::find($id);
     
        if ( Request::json('employer_id') ){
            $EmployerDepartment->employer_id = Request::json('employer_id');
        }

        if ( Request::json('label') ){
            $EmployerDepartment->label = Request::json('label');
        }

        if ( Request::json('description') ){
            $EmployerDepartment->description = Request::json('description');
        }

        if ( Request::json('work_type_id') ){
            $EmployerDepartment->work_type_id = Request::json('work_type_id');
        }

        if ( Request::json('employee_hourly_rate') ){
            $EmployerDepartment->employee_hourly_rate = Request::json('employee_hourly_rate');
        }

        if ( Request::json('employee_hourly_rate_currency_code') ){
            $EmployerDepartment->employee_hourly_rate_currency_code = Request::json('employee_hourly_rate_currency_code');
        }

        if ( Request::json('employer_hourly_rate') ){
            $EmployerDepartment->employer_hourly_rate = Request::json('employer_hourly_rate');
        }

        if ( Request::json('employer_hourly_rate_currency_code') ){
            $EmployerDepartment->employer_hourly_rate_currency_code = Request::json('employer_hourly_rate_currency_code');
        }

        if ( Request::json('parent_id') ){
            $EmployerDepartment->employer_hourly_rate = Request::json('parent_id');
        }

        $EmployerDepartment->id = $id;
     
        $EmployerDepartment->save();

        $EmployerDepartment->children = $this->getDepartmentChildren($EmployerDepartment->id, $EmployerDepartment->employer_id);       
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'EmployerDepartment updated', 
                'action' => 'update', 
                'EmployerDepartment' => $EmployerDepartment->toArray()
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
        try {
            $EmployerDepartment = EmployerDepartment::find($id);

            $EmployerDepartment->delete();
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employer department deleted',
                    'EmployerDepartments' => $this->getDepartments($EmployerDepartment->employer_id)
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Employer department cannot be deleted.' . $e
                    ),
                500
            );
        }
    }

    private function getDepartments($employer_id){
        $rootDepartments = EmployerDepartment::where('employer_id', $employer_id)
                                            ->where('parent_id', null)
                                            ->get();              
        $departments = array();                                                                                                                                         
        $rootDepartments = $this->getAttributes($rootDepartments);        
        foreach($rootDepartments as $rootDepartment){            
            $rootDepartment['children'] = $this->getDepartmentChildren($rootDepartment['id'], $employer_id);
            $departments[] = $rootDepartment;
        } 
        return $departments;
    }

    private function getDepartmentChildren($parent_id, $employer_id){
        $departments = EmployerDepartment::where('employer_id', $employer_id)
                                         ->where('parent_id', $parent_id)
                                         ->get();          
        $departments = $this->getAttributes($departments);                                         
        if(!count($departments)) 
            return null;
        else { 
            $return_departments = array();        
            foreach($departments as $department){
                $department['children'] = $this->getDepartmentChildren($department['id'], $employer_id);                                  
                $return_departments[] = $department;
            }      
            return $return_departments;
        }
    }

    private function getAttributes($array){
        $attributes_array = array();
        foreach($array as $item){
            array_push($attributes_array, $item['attributes']);
        }
        return $attributes_array;
    }
}