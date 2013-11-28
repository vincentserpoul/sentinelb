<?php

class GlobaleventPeriodEmployeeController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        $GlobaleventPeriodEmployees = GlobaleventPeriodEmployee::get();

        return Response::json(
            array(
                'error' => false,
                'GlobaleventPeriodEmployees' => $GlobaleventPeriodEmployees->toArray()
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
        $GlobaleventPeriodEmployee = new GlobaleventPeriodEmployee;

        $GlobaleventPeriodEmployee->globalevent_period_id = Request::json('globalevent_period_id');
        $GlobaleventPeriodEmployee->employee_id = Request::json('employee_id');
        $GlobaleventPeriodEmployee->real_start_datetime = Request::json('real_start_datetime');

        //$GlobaleventPeriodEmployee->user_id = Auth::user()->id;

        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.

        $GlobaleventPeriodEmployee->save();

        return Response::json(
            array(
                'error' => false,
                'GlobaleventPeriodEmployee' => $GlobaleventPeriodEmployee->toArray()
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

        $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::find($id);

        $GlobaleventPeriodEmployee->delete();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Globalevent period employee deleted'
                ),
            200
        );
    }

}
