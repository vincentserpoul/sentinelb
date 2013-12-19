<?php

class GlobaleventPeriodController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        try {
            $GlobaleventPeriods = GlobaleventPeriod::with(array('globalevent', 'eventperiodemployee'))->get();

            return Response::json(
                array(
                    'error' => false,
                    'GlobaleventPeriods' => $GlobaleventPeriods->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event period cannot be returned',
                    'action' => 'get'
                ),
                500
            );
        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){

        try {
            $GlobaleventPeriod = new GlobaleventPeriod;

            $GlobaleventPeriod->event_id = Request::json('event_id');
            $GlobaleventPeriod->start_datetime = new DateTime(Request::json('start_datetime'));
            $GlobaleventPeriod->end_datetime = new DateTime(Request::json('end_datetime'));
            $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');

            $GlobaleventPeriod->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event Period successfully created',
                    'GlobaleventPeriod' => $GlobaleventPeriod->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employer cannot be created.' . $e,
                    'action' => 'update'
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
            $GlobaleventPeriod = GlobaleventPeriod::find($id);

            if ( Request::json('globalevent_id') ){
                $GlobaleventPeriod->globalevent_id = Request::json('globalevent_id');
            }

            if ( Request::json('start_datetime') ){
                $GlobaleventPeriod->start_datetime = new DateTime(Request::json('start_datetime'));
            }

            if ( Request::json('end_datetime') ){
                $GlobaleventPeriod->end_datetime = new DateTime(Request::json('end_datetime'));
            }

            if ( Request::json('number_of_employee_needed') ){
                $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');
            }

            $GlobaleventPeriod->id = $id;

            $GlobaleventPeriod->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Global event period updated',
                    'globalevent_period' => $GlobaleventPeriod->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event period cannot be updated.' . $e->getMessage(),
                    'action' => 'update'
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
            $GlobaleventPeriod = GlobaleventPeriod::find($id);
            $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::where('globalevent_period_id', $id);


            $GlobaleventPeriodEmployee->delete();
            $GlobaleventPeriod->delete();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Global event period deleted'
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event period cannot be deleted.' . $e,
                    'action' => 'delete'
                ),
                500
            );
        }
    }

}
