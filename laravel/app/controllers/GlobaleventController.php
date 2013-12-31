<?php

class GlobaleventController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        try {
            $Globalevents = Globalevent::paginate(20);

            return Response::json(
                array(
                    'error' => false,
                    'Globalevents' => $Globalevents->toArray()
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
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){
        try {
            $Globalevent = new Globalevent;

            $Globalevent->employer_id = Request::json('employer_id');
            $Globalevent->label = Request::json('label');
            $Globalevent->employer_department_id = Request::json('employer_department_id');
            $Globalevent->date = Request::json('date');

            $Globalevent->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event successfully created',
                    'Globalevent' => $Globalevent->toArray()
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

            if ( Request::json('employer_department_id') ){
                $Globalevent->employer_department_id = Request::json('employer_department_id');
            }

            if ( Request::json('employer_id') ) {
                $Globalevent->employer_id = Request::json('employer_id');
            }

            if ( Request::json('date') ) {
                $Globalevent->date = Request::json('date');
            }

            $Globalevent->id = $id;

            $Globalevent->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event updated'
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Event cannot be updated"
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
