<?php

class EmployerController extends \BaseController {
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        
        $Employers = Employer::get();

        return Response::json(
            array(
                'error' => false,
                'employers' => $Employers->toArray()
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
        $Employer = new Employer;

        $Employer->name = Request::json('name');
        $Employer->address = Request::json('address');
        $Employer->city = Request::json('city');
        $Employer->postcode = Request::json('postcode');
        $Employer->country_code = Request::json('country_code');
        $Employer->phone_number = Request::json('phone_number');
        $Employer->fax_number = Request::json('fax_number');

        //$Employer->user_id = Auth::user()->id;
     
        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.
     
        $Employer->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Employer created',
                'action' => 'insert',               
                'employer' => $Employer->toArray()
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
        $Employer = Employer::where('id', $id)
                ->take(1)
                ->get();
     
        return Response::json(
            array(
                'error' => false,
                'employers' => $Employer->toArray()
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

        $Employer = Employer::find($id);
     
        if ( Request::json('name') ){
            $Employer->name = Request::json('name');
        }

        if ( Request::json('address') ){
            $Employer->address = Request::json('address');
        }

        if ( Request::json('city') ){
            $Employer->city = Request::json('city');
        }

        if ( Request::json('postcode') ){
            $Employer->postcode = Request::json('postcode');
        }

        if ( Request::json('country_code') ){
            $Employer->country_code = Request::json('country_code');
        }

        if ( Request::json('phone_number') ){
            $Employer->phone_number = Request::json('phone_number');
        }

        if ( Request::json('fax_number') ){
            $Employer->fax_number = Request::json('fax_number');
        }

        $Employer->id = $id;
     
        $Employer->save();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Employer updated',
                'action' => 'update',
                'employer' => $Employer->toArray()
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

        $Employer = Employer::find($id);
        $EmployerContact = EmployerContact::where('employer_id', $id);
        
        $EmployerContact->delete();
        $Employer->delete();
     
        return Response::json(
            array(
                'error' => false,
                'message' => 'Employer deleted',
                'action' => 'delete',
                'employer' => $Employer->toArray()
                ),
            200
        );
    }

}