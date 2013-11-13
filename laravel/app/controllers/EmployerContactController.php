<?php

class EmployerContactController extends \BaseController {

    /**
    * Filter users with enough authorization
    */
    public function __construct(){
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAnyAccess(array('add_employer_contact'))) return Response::json(
                            array(
                                'error' => true, 
                                'message' => 'Please log in to continue.'
                            ),
                            401
                        );
        }, array('only' => array('store')));
    }   

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        $employer_id = Request::input('employer_id');

        if($employer_id) $EmployerContacts = EmployerContact::where('employer_id', $employer_id)->get();
        else $EmployerContacts = EmployerContact::get();        

        return Response::json(
            array(
                'error' => false,
                'EmployerContacts' => $EmployerContacts->toArray()
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
        $EmployerContact = new EmployerContact;

        $EmployerContact->employer_id = Request::json('employer_id');
        $EmployerContact->title_id = Request::json('title_id');
        $EmployerContact->first_name = Request::json('first_name');
        $EmployerContact->last_name = Request::json('last_name');
        $EmployerContact->sex_id = Request::json('sex_id');
        $EmployerContact->mobile_phone_number = Request::json('mobile_phone_number');
        $EmployerContact->primary_contact = Request::json('primary_contact');

        //$EmployerContact->user_id = Auth::user()->id;
     
        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.
     
        $EmployerContact->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Contact created', 
                'action' => 'insert',
                'EmployerContact' => $EmployerContact->toArray()
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
        $EmployerContact = EmployerContact::where('id', $id)
                ->take(1)
                ->get();
     
        return Response::json(
            array(
                'error' => false,
                'EmployerContacts' => $EmployerContact->toArray()
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

        $EmployerContact = EmployerContact::find($id);
     
        if (!is_null(Request::json('employer_id'))){
            $EmployerContact->employer_id = Request::json('employer_id');
        }

        if (!is_null(Request::json('employer_id'))){
            $EmployerContact->employer_id = Request::json('employer_id');
        }

        if (!is_null(Request::json('title_id'))){
            $EmployerContact->title_id = Request::json('title_id');
        }

        if (!is_null(Request::json('first_name'))){
            $EmployerContact->first_name = Request::json('first_name');
        }

        if (!is_null(Request::json('last_name'))){
            $EmployerContact->last_name = Request::json('last_name');
        }

        if (!is_null(Request::json('sex_id'))){
            $EmployerContact->sex_id = Request::json('sex_id');
        }

        if (!is_null(Request::json('mobile_phone_number'))){
            $EmployerContact->mobile_phone_number = Request::json('mobile_phone_number');
        }

        if (!is_null(Request::json('primary_contact'))){
            $EmployerContact->primary_contact = Request::json('primary_contact');
        }

        $EmployerContact->id = $id;
     
        $EmployerContact->save();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Employer contact updated', 
                'action' => 'update', 
                'EmployerContact' => $EmployerContact->toArray()
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

        $EmployerContact = EmployerContact::find($id);

        $EmployerContact->delete();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Employer department deleted'
                ),
            200
        );
    }

}