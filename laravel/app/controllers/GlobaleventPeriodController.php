<?php

class GlobaleventPeriodController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        try {
            $GlobaleventPeriods = GlobaleventPeriod::with(array('globalevent', 'eventperiodemployee'))
                                                    ->paginate(10)
                                                    ->toArray();

            return Response::json(
                array(
                    'error' => false,
                    'GlobaleventPeriods' => $GlobaleventPeriods['data'],
                    'current_page' => $GlobaleventPeriods['current_page'],
                    'last_page' => $GlobaleventPeriods['last_page'],
                    'total' => $GlobaleventPeriods['total']
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

            $GlobaleventPeriod->globalevent_id = Request::json('event_id');
            $GlobaleventPeriod->start_datetime = Request::json('start_datetime');
            $GlobaleventPeriod->end_datetime = Request::json('end_datetime');
            $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');

            // validate info
            if (strtotime($GlobaleventPeriod->end_datetime) <= strtotime($GlobaleventPeriod->start_datetime))
                throw new Exception('End datetime must be after start datetime', 1);
            if ($GlobaleventPeriod->number_of_employee_needed < 1) 
                throw new Exception("Number of employees needed must be greater than 0", 1);
                
            $GlobaleventPeriod->save();

            $GlobaleventPeriod['number_of_employees_assigned'] = 0;

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event Period successfully created',
                    'eventPeriod' => $GlobaleventPeriod->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client cannot be created.' . $e->getMessage(),
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

            if ( new DateTime(Request::json('start_datetime')) ){
                $GlobaleventPeriod->start_datetime = Request::json('start_datetime');
            }

            if ( new DateTime(Request::json('end_datetime')) ){
                $GlobaleventPeriod->end_datetime = Request::json('end_datetime');
            }

            if ( Request::json('number_of_employee_needed') ){
                $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');
            }

            // validate info
            if ($GlobaleventPeriod->end_datetime <= $GlobaleventPeriod->start_datetime)
                throw new Exception('End datetime must be after start datetime', 1);
            if ($GlobaleventPeriod->number_of_employee_needed < 1) 
                throw new Exception("Number of employees needed must be greater than 0", 1);

            $GlobaleventPeriod->id = $id;

            $GlobaleventPeriod->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Global event period updated',
                    'eventPeriod' => $GlobaleventPeriod->toArray()
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
