<?php

class ClientContactController extends \BaseController {

    /**
    * Filter users with enough authorization
    */
    public function __construct(){
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAnyAccess(array('add_client_contact'))) return Response::json(
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
        $client_id = Request::input('client_id');

        if($client_id) $ClientContacts = ClientContact::where('client_id', $client_id)->get();
        else $ClientContacts = ClientContact::get();

        return Response::json(
            array(
                'error' => false,
                'ClientContacts' => $ClientContacts->toArray()
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
        try {
            $ClientContact = new ClientContact;

            $ClientContact->client_id = Request::json('client_id');
            $ClientContact->title_id = Request::json('title_id');
            $ClientContact->first_name = Request::json('first_name');
            $ClientContact->last_name = Request::json('last_name');
            $ClientContact->sex_id = Request::json('sex_id');
            $ClientContact->mobile_phone_number = Request::json('mobile_phone_number');
            $ClientContact->primary_contact = Request::json('primary_contact');

            //$ClientContact->user_id = Auth::user()->id;

            // Validation and Filtering is sorely needed!!
            // Seriously, I'm a bad person for leaving that out.

            $ClientContact->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Contact created',
                    'action' => 'insert',
                    'contact' => $ClientContact->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Contact cannot be created. ' . $e->getMessage(),
                    'action' => 'insert'
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
        $ClientContact = ClientContact::where('id', $id)
                ->take(1)
                ->get();

        return Response::json(
            array(
                'error' => false,
                'ClientContacts' => $ClientContact->toArray()
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

        try {

            $ClientContact = ClientContact::find($id);

            if (!is_null(Request::json('client_id'))){
                $ClientContact->client_id = Request::json('client_id');
            }

            if (!is_null(Request::json('client_id'))){
                $ClientContact->client_id = Request::json('client_id');
            }

            if (!is_null(Request::json('title_id'))){
                $ClientContact->title_id = Request::json('title_id');
            }

            if (!is_null(Request::json('first_name'))){
                $ClientContact->first_name = Request::json('first_name');
            }

            if (!is_null(Request::json('last_name'))){
                $ClientContact->last_name = Request::json('last_name');
            }

            if (!is_null(Request::json('sex_id'))){
                $ClientContact->sex_id = Request::json('sex_id');
            }

            if (!is_null(Request::json('mobile_phone_number'))){
                $ClientContact->mobile_phone_number = Request::json('mobile_phone_number');
            }

            if (!is_null(Request::json('primary_contact'))){
                $ClientContact->primary_contact = Request::json('primary_contact');
            }

            $ClientContact->id = $id;

            $ClientContact->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client contact updated',
                    'action' => 'update',
                    'contact' => $ClientContact->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Contact cannot be updated. ' . $e->getMessage(),
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

        $ClientContact = ClientContact::find($id);

        $ClientContact->delete();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Client department deleted'
                ),
            200
        );
    }

}
