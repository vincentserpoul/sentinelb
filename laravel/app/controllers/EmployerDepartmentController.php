<?php

class EmployerDepartmentController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        //try {
            $employer_id = Request::input('employer_id');        

            if($employer_id) $EmployerDepartments = $this->getDepartments($employer_id);
            else $EmployerDepartments = EmployerDepartment::get()->toArray();   

            return Response::json(
                array(
                    'error' => false,
                    'EmployerDepartments' => $EmployerDepartments
                ),
                200
            );
        /*} catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "departments cannot be returned. " . $e->getMessage()
                ),
                500
            );
        }*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){

        try {
            $EmployerDepartment = new EmployerDepartment;

            $EmployerDepartment->employer_id = Request::json('employer_id');
            $EmployerDepartment->label = Request::json('label');
            $EmployerDepartment->description = Request::json('description');
            $EmployerDepartment->work_type_id = Request::json('work_type_id');
            $EmployerDepartment->employee_h_rate = Request::json('employee_h_rate');
            $EmployerDepartment->employee_h_rate_currency_code = Request::json('employee_h_rate_currency_code');
            $EmployerDepartment->employer_h_rate = Request::json('employer_h_rate');
            $EmployerDepartment->employer_h_rate_currency_code = Request::json('employer_h_rate_currency_code');
            $EmployerDepartment->parent_id = Request::json('parent_id');
         
            $EmployerDepartment->save();

            $EmployerDepartments = $this->getDepartments($EmployerDepartment->employer_id);

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Department created',
                    'action' => 'insert',
                    'EmployerDepartments' => $EmployerDepartments['data']
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Employers cannot be created. " . $e->getMessage(),
                    'action' => "create"
                ),
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        try {
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

            if ( Request::json('employee_h_rate') ){
                $EmployerDepartment->employee_h_rate = Request::json('employee_h_rate');
            }

            if ( Request::json('employee_h_rate_currency_code') ){
                $EmployerDepartment->employee_h_rate_currency_code = Request::json('employee_h_rate_currency_code');
            }

            if ( Request::json('employer_h_rate') ){
                $EmployerDepartment->employer_h_rate = Request::json('employer_h_rate');
            }

            if ( Request::json('employer_h_rate_currency_code') ){
                $EmployerDepartment->employer_h_rate_currency_code = Request::json('employer_h_rate_currency_code');
            }

            if ( Request::json('parent_id') ){
                $EmployerDepartment->employer_h_rate = Request::json('parent_id');
            }

            $EmployerDepartment->id = $id;
         
            $EmployerDepartment->save();

            $EmployerDepartments = $this->getDepartments($EmployerDepartment->employer_id);
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'EmployerDepartment updated', 
                    'action' => 'update', 
                    'EmployerDepartments' => $EmployerDepartments['data']
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Employers cannot be updated",
                    'action' => "update"
                ),
                500
            );
        }
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
                                            ->get()
                                            ->toArray(); 
        // set pagination info for departments                   
        for ($i = 0; $i < count($rootDepartments['data']); $i++){            
            $rootDepartments[$i]['children'] = $this->getDepartmentChildren($rootDepartments['data'][$i]['id'], $employer_id);
        } 

        return $rootDepartments;
    }

    private function getDepartmentChildren($parent_id, $employer_id){
        $departments = EmployerDepartment::where('employer_id', $employer_id)
                                         ->where('parent_id', $parent_id)
                                         ->get()
                                         ->toArray();     

        if(!count($departments)) 
            return null;
        
        for ($i = 0; $i < count($departments); $i++){
            $departments[$i]['children'] = $this->getDepartmentChildren($departments[$i]['id'], $employer_id);
        }      
        return $departments;
    }
}