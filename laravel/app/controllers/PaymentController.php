<?php

class PaymentController extends \BaseController {

     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        
        $Payments = Payment::get();        

        return Response::json(
            array(
                'error' => false,
                'Payments' => $Payments->toArray()
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

        $Payment = new Payment;
        $Payment->amount = Request::json('amount');
        $Payment->currency_code = Request::json('currency_code');
        //$Payment->user_id = Auth::user()->id;
        $Payment->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Payment created',
                'action' => 'insert',
                'Payment' => $Payment->toArray()
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

        $Payment = Payment::where('id', $id)
        ->take(1)
        ->get();
     
        return Response::json(
            array(
                'error' => false,
                'Payments' => $Payment->toArray()
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
        try
        {
            $Payment = Payment::find($id);
            if ( Request::json('amount') )
            {
                $Payment->amount = Request::json('amount');
            }
            //$Payment->id = $id; 
            $Payment->save();
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment updated',
                    'action' => 'update',
                    'payment' => $Payment->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment cannot be updated',
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
       try
        {
            $Payment = Payment::find($id);
            $Payment->id = $id; 
            $Payment->delete();
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment deleted',
                    'action' => 'delete',
                    'payment' => $Payment->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment cannot be deleted',
                    'action' => 'delete',
                    'payment' => $id
                ),
                500
            );
        }


    }

}