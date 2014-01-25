<?php

class GlobaleventController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        try {
            $Globalevents = Globalevent::orderBy('id', 'desc')
                                        ->paginate(20);

            foreach ($Globalevents as $Globalevent)
                $this->set_labels($Globalevent);

            $Globalevents = $Globalevents->toArray();

            return Response::json(
                array(
                    'error' => false,
                    'Globalevents' => $Globalevents['data'],
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
                    'message' => "Events cannot be returned"
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


    private function set_labels ($Globalevent) {
        $Globalevent['client_name'] = Client::find($Globalevent['client_id'])->name;
        $Globalevent['client_department_label'] = ClientDepartment::find($Globalevent['client_department_id'])->label;
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

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){
        try {
            $Globalevent = new Globalevent;

            $Globalevent->client_id = Request::json('client_id');
            $Globalevent->label = Request::json('label');
            $Globalevent->client_department_id = Request::json('client_department_id');
            $Globalevent->date = Request::json('date');
            $Globalevent->remark = Request::json('remark');

            $Globalevent->save();

            // set labels for new event
            $this->set_labels($Globalevent);

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event successfully created',
                    'event' => $Globalevent->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Event cannot be created " . $e
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

            if ( Request::json('remark') ) {
                $Globalevent->remark = Request::json('remark');
            }

            $Globalevent->id = $id;

            $Globalevent->save();

            $this->set_labels($Globalevent);

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event updated',
                    'event' => $Globalevent->toArray()
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

}
