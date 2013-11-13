<?php

class GlobaleventController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        
        $Globalevents = Globalevent::get();

        return Response::json(
            array(
                'error' => false,
                'Globalevents' => $Globalevents->toArray()
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
        $Globalevent = new Globalevent;

        $Globalevent->employer_id = Request::json('employer_id');
        $Globalevent->label = Request::json('label');
        $Globalevent->employer_department_id = Request::json('employer_department_id');
/*        $Globalevent->computed_start_date = Request::json('start_date');
        $Globalevent->computed_end_date = Request::json('end_date');
*/

        //$Globalevent->user_id = Auth::user()->id;
     
        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.
     
        $Globalevent->save();

        return Response::json(
            array(
                'error' => false,
                'Globalevent' => $Globalevent->toArray()
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
        $Globalevent = Globalevent::where('id', $id)
                ->take(1)
                ->get();
     
        return Response::json(
            array(
                'error' => false,
                'Globalevents' => $Globalevent->toArray()
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

        $Globalevent = Globalevent::find($id);
     
        if ( Request::json('label') ){
            $Globalevent->label = Request::json('label');
        }

        if ( Request::json('employer_department_id') ){
            $Globalevent->employer_department_id = Request::json('employer_department_id');
        }

/*        if ( Request::json('start_date') ){
            $Globalevent->start_date = Request::json('start_date');
        }

        if ( Request::json('end_date') ){
            $Globalevent->end_date = Request::json('end_date');
        }*/

        $Globalevent->id = $id;
     
        $Globalevent->save();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Globalevent updated'
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

        $Globalevent = Globalevent::find($id);
        $GlobaleventPeriod = GlobaleventPeriod::where('globalevent_id', $id);
        $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::with('globalevent_period')->where('globalevent_id', $id);


        $GlobaleventPeriodEmployee->delete();
        $GlobaleventPeriod->delete();
        $Globalevent->delete();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Globalevent deleted'
                ),
            200
        );
    }

}