<?php

class GlobaleventController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        try {
            /* Init employee model */
            $Globalevents = new Globalevent;

            /* Get usual employee list details */
            $Globalevents = $Globalevents->listWithDetails()
                                    ->limit(500)->paginate(10)
                                    ->toArray();

            return Response::json(
                array(
                    'error' => false,
                    'globalevents' => $Globalevents['data'],
                    'current_page' => $Globalevents['current_page'],
                    'last_page' => $Globalevents['last_page'],
                    'total' => $Globalevents['total']
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Events cannot be returned: ".$e->getMessage()
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
        $Globalevent = Globalevent::with(array('globalevent_period'))
                ->where('id', $id)
                ->take(1)
                ->get();

        return Response::json(
            array(
                'error' => false,
                'globalevents' => $Globalevent->toArray()
            ),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){
        try {
            $Globalevent = new Globalevent;

            $Globalevent->label = Request::json('label');
            $Globalevent->client_department_id = Request::json('client_department_id');

            $Globalevent->save();

            $id = $Globalevent->id;

            // We get the newly created item
            $Globalevent = new Globalevent;

            $Globalevent = $Globalevent->listWithDetails(array('id'=>$id))
                ->take(1)
                ->get();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event successfully created',
                    'globalevents' => $Globalevent->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Event cannot be created " . $e->getMessage()
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
            $Globalevent = Globalevent::find($id);

            if ( Request::json('label') ){
                $Globalevent->label = Request::json('label');
            }

            if ( Request::json('client_department_id') ){
                $Globalevent->client_department_id = Request::json('client_department_id');
            }

            if ( Request::json('client_id') ) {
                $Globalevent->client_id = Request::json('client_id');
            }

            if ( Request::json('date') ) {
                $Globalevent->date = Request::json('date');
            }

            $Globalevent->id = $id;

            $Globalevent->save();

            $this->set_labels($Globalevent);

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event updated',
                    'globalevents' => $Globalevent->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Event cannot be updated. " . $e->getMessage()
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
            $Globalevent = Globalevent::find($id);
            $GlobaleventPeriod = GlobaleventPeriod::where('globalevent_id', $id);
            //$GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::with('globalevent_period')->where('globalevent_id', $id);

            //$GlobaleventPeriodEmployee->delete();
            $GlobaleventPeriod->delete();
            $Globalevent->delete();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Globalevent deleted'
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Event cannot be deleted. " . $e->getMessage()
                ),
                500
            );
        }
    }


    public function globalevent_periods ($globalevent_id) {

        try {
            $GlobaleventPeriods = GlobaleventPeriod::where('globalevent_id', '=', $globalevent_id)
                                                    ->paginate(10);

            foreach ($GlobaleventPeriods as $GlobaleventPeriod) {
                $GlobaleventPeriod['number_of_employees_assigned'] = GlobaleventPeriodEmployee::where('globalevent_period_id', '=', $GlobaleventPeriod->id)
                                                                                               ->count();
            }

            $GlobaleventPeriods = $GlobaleventPeriods->toArray();

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
                    'message' => 'Event period cannot be returned. ' . $e->getMessage(),
                    'action' => 'get'
                ),
                500
            );
        }
    }

}
