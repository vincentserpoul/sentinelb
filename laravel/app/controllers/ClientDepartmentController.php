<?php

class ClientDepartmentController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        //try {
            $client_id = Request::input('client_id');        

            if($client_id) $ClientDepartments = $this->getDepartments($client_id);
            else $ClientDepartments = ClientDepartment::get()->toArray();   

            return Response::json(
                array(
                    'error' => false,
                    'ClientDepartments' => $ClientDepartments
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
            $ClientDepartment = new ClientDepartment;

            $ClientDepartment->client_id = Request::json('client_id');
            $ClientDepartment->label = Request::json('label');
            $ClientDepartment->description = Request::json('description');
            $ClientDepartment->work_type_id = Request::json('work_type_id');
            $ClientDepartment->employee_h_rate = Request::json('employee_h_rate');
            $ClientDepartment->employee_h_rate_currency_code = Request::json('employee_h_rate_currency_code');
            $ClientDepartment->client_h_rate = Request::json('client_h_rate');
            $ClientDepartment->client_h_rate_currency_code = Request::json('client_h_rate_currency_code');
            $ClientDepartment->parent_id = Request::json('parent_id');
         
            $ClientDepartment->save();

            $ClientDepartments = $this->getDepartments($ClientDepartment->client_id);

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Department created',
                    'action' => 'insert',
                    'ClientDepartments' => $ClientDepartments['data']
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Clients cannot be created. " . $e->getMessage(),
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
            $ClientDepartment = ClientDepartment::find($id);
         
            if ( Request::json('client_id') ){
                $ClientDepartment->client_id = Request::json('client_id');
            }

            if ( Request::json('label') ){
                $ClientDepartment->label = Request::json('label');
            }

            if ( Request::json('description') ){
                $ClientDepartment->description = Request::json('description');
            }

            if ( Request::json('work_type_id') ){
                $ClientDepartment->work_type_id = Request::json('work_type_id');
            }

            if ( Request::json('employee_h_rate') ){
                $ClientDepartment->employee_h_rate = Request::json('employee_h_rate');
            }

            if ( Request::json('employee_h_rate_currency_code') ){
                $ClientDepartment->employee_h_rate_currency_code = Request::json('employee_h_rate_currency_code');
            }

            if ( Request::json('client_h_rate') ){
                $ClientDepartment->client_h_rate = Request::json('client_h_rate');
            }

            if ( Request::json('client_h_rate_currency_code') ){
                $ClientDepartment->client_h_rate_currency_code = Request::json('client_h_rate_currency_code');
            }

            if ( Request::json('parent_id') ){
                $ClientDepartment->client_h_rate = Request::json('parent_id');
            }

            $ClientDepartment->id = $id;
         
            $ClientDepartment->save();

            $ClientDepartments = $this->getDepartments($ClientDepartment->client_id);
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'ClientDepartment updated', 
                    'action' => 'update', 
                    'ClientDepartments' => $ClientDepartments['data']
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Clients cannot be updated",
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
            $ClientDepartment = ClientDepartment::find($id);

            $ClientDepartment->delete();
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client department deleted',
                    'ClientDepartments' => $this->getDepartments($ClientDepartment->client_id)
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Client department cannot be deleted.' . $e
                    ),
                500
            );
        }
    }

    private function getDepartments($client_id){
        $rootDepartments = ClientDepartment::where('client_id', $client_id)
                                            ->where('parent_id', null)
                                            ->get()
                                            ->toArray(); 
        // set pagination info for departments                   
        for ($i = 0; $i < count($rootDepartments['data']); $i++){            
            $rootDepartments[$i]['children'] = $this->getDepartmentChildren($rootDepartments['data'][$i]['id'], $client_id);
        } 

        return $rootDepartments;
    }

    private function getDepartmentChildren($parent_id, $client_id){
        $departments = ClientDepartment::where('client_id', $client_id)
                                         ->where('parent_id', $parent_id)
                                         ->get()
                                         ->toArray();     

        if(!count($departments)) 
            return null;
        
        for ($i = 0; $i < count($departments); $i++){
            $departments[$i]['children'] = $this->getDepartmentChildren($departments[$i]['id'], $client_id);
        }      
        return $departments;
    }
}