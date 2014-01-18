<?php

class ClientController extends \BaseController {
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        
        try { 
            $Clients = Client::get()->toArray();

            return Response::json(
                array(
                    'error' => false,
                    'message' => "Clients returned",
                    'clients' => $Clients
                ),
                200
            );
        } catch (Exception $e) { 
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Clients cannot be returned"
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
            $Client = new Client;

            $Client->name = Request::json('name');
            $Client->address = Request::json('address');
            $Client->city = Request::json('city');
            $Client->postcode = Request::json('postcode');
            $Client->country_code = Request::json('country_code');
            $Client->phone_number = Request::json('phone_number');
            $Client->fax_number = Request::json('fax_number');

            //$Client->user_id = Auth::user()->id;
         
            // Validation and Filtering is sorely needed!!
            // Seriously, I'm a bad person for leaving that out.
         
            $Client->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client created',
                    'action' => 'insert',               
                    'client' => $Client->toArray()
                ),
                200
            );
        } catch (Exception $e) { 
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client cannot be created'
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

            $Client = Client::find($id);
         
            if ( Request::json('name') ){
                $Client->name = Request::json('name');
            }

            if ( Request::json('address') ){
                $Client->address = Request::json('address');
            }

            if ( Request::json('city') ){
                $Client->city = Request::json('city');
            }

            if ( Request::json('postcode') ){
                $Client->postcode = Request::json('postcode');
            }

            if ( Request::json('country_code') ){
                $Client->country_code = Request::json('country_code');
            }

            if ( Request::json('phone_number') ){
                $Client->phone_number = Request::json('phone_number');
            }

            if ( Request::json('fax_number') ){
                $Client->fax_number = Request::json('fax_number');
            }

            $Client->id = $id;
         
            $Client->save();
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client updated',
                    'action' => 'update',
                    'client' => $Client->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client cannot be updated',
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

        try{
            $Client = Client::find($id);
            $ClientContact = ClientContact::where('client_id', $id);
            
            $ClientContact->delete();
            $Client->delete();
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Client deleted'
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Client cannot be deleted.' . $e
                    ),
                500
            );
        }
    }

}