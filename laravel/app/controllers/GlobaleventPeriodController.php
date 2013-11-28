<?php

class GlobaleventPeriodController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        $GlobaleventPeriods = GlobaleventPeriod::with(array('globalevent', 'eventperiodemployee'))->get();

        return Response::json(
            array(
                'error' => false,
                'GlobaleventPeriods' => $GlobaleventPeriods->toArray()
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
        $GlobaleventPeriod = new GlobaleventPeriod;

        $GlobaleventPeriod->event_id = Request::json('event_id');
        $GlobaleventPeriod->start_datetime = Request::json('start_datetime');
        $GlobaleventPeriod->end_datetime = Request::json('end_datetime');
        $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');

        //$GlobaleventPeriod->user_id = Auth::user()->id;

        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.

        $GlobaleventPeriod->save();

        return Response::json(
            array(
                'error' => false,
                'GlobaleventPeriod' => $GlobaleventPeriod->toArray()
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
        $GlobaleventPeriod = GlobaleventPeriod::where('id', $id)
                ->take(1)
                ->get();

        return Response::json(
            array(
                'error' => false,
                'GlobaleventPeriods' => $GlobaleventPeriod->toArray()
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

        $GlobaleventPeriod = GlobaleventPeriod::find($id);

        if ( Request::json('globalevent_id') ){
            $GlobaleventPeriod->globalevent_id = Request::json('globalevent_id');
        }

        if ( Request::json('start_datetime') ){
            $GlobaleventPeriod->start_datetime = Request::json('start_datetime');
        }

        if ( Request::json('end_datetime') ){
            $GlobaleventPeriod->end_datetime = Request::json('end_datetime');
        }

        if ( Request::json('number_of_employee_needed') ){
            $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');
        }

        $GlobaleventPeriod->id = $id;

        $GlobaleventPeriod->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Global event period updated'
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

        $GlobaleventPeriod = GlobaleventPeriod::find($id);
        $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::where('Eevent_period_id', $id);


        $GlobaleventPeriodEmployee->delete();
        $GlobaleventPeriod->delete();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Global event period deleted'
                ),
            200
        );
    }

}
