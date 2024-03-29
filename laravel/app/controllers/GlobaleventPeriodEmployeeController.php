<?php

class GlobaleventPeriodEmployeeController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        try {
            $GlobaleventPeriodEmployees = GlobaleventPeriodEmployee::get();

            return Response::json(
                array(
                    'error' => false,
                    'GlobaleventPeriodEmployees' => $GlobaleventPeriodEmployees->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'GlobaleventPeriodEmployees cannot be returned. ' . $e->getMessage(),
                    'action' => 'get'
                ),
                500
            );
        }
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
    public function store () {

        try {
            if (!Request::json('globaleventPeriodId')){
                throw new Exception('Missing event period id');
            }
            if (!Request::json('employeeId')){
                throw new Exception('Missing employee id');
            }

            $GlobaleventPeriodEmployee = new GlobaleventPeriodEmployee;
            $GlobaleventPeriodEmployee->globalevent_period_id = Request::json('globaleventPeriodId');
            $GlobaleventPeriodEmployee->employee_id = Request::json('employeeId');

            $GlobaleventPeriodEmployee->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employee is successfully assigned',
                    'globalevent_period_employees' => $GlobaleventPeriodEmployee->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employee cannot be assigned.' . $e->getMessage(),
                    'action' => 'create'
                ),
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){
        // Make sure current user owns the requested resource
        $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::where('id', $id)
                ->take(1)
                ->get();

        return Response::json(
            array(
                'error' => false,
                'GlobaleventPeriodEmployees' => $GlobaleventPeriodEmployee->toArray()
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

        $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::find($id);

        if ( Request::json('Globalevent_period_id') ){
            $GlobaleventPeriodEmployee->globalevent_period_id = Request::json('globalevent_period_id');
        }

        if ( Request::json('employee_id') ){
            $GlobaleventPeriodEmployee->employee_id = Request::json('employee_id');
        }

        if ( Request::json('real_start_datetime') ){
            $GlobaleventPeriodEmployee->real_start_datetime = Request::json('real_start_datetime');
        }

        if ( Request::json('real_end_datetime') ){
            $GlobaleventPeriodEmployee->real_end_datetime = Request::json('real_end_datetime');
        }


        $GlobaleventPeriodEmployee->id = $id;

        $GlobaleventPeriodEmployee->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Globalevent period employee updated'
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
            $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::find($id);

            $GlobaleventPeriodEmployee->delete();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Globalevent period employee deleted',
                    'globalevent_period_employee' => $GlobaleventPeriodEmployee->toArray()
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Globalevent period employee cannot be deleted. ' . $e->getMessage()
                    ),
                500
            );
        }
    }

}
