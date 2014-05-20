<?php

class PaymentController extends \BaseController {

     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){


        $Payments = Payment::take(10)->get();

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

        try{

            /* Validation of the data */
            $valid = Validator::make(
                Request::json()->all(),
                array(
                    'amount' => 'required',
                    'currency_code' => 'required|size:3|alphanum',
                    'globalevent_period_ids' => 'required|array|min:1',
                    'payment_type_id' => 'required|integer',
                )
            );

            if ($valid->fails())
            {
                throw new Exception(implode($valid->messages()->all(':message'), ' - '), 1);
            }

            // Pas de création en direct
            $Payment = new Payment;
            $Payment->amount = Request::json('amount');
            $Payment->currency_code = Request::json('currency_code');
            $Payment->payment_type_id = Request::json('payment_type_id');
            $Payment->save();
            // Associate the payment with globalevent_period
            $Payment->globalevent_period_employee()->sync(Request::json('globalevent_period_ids'));

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment created',
                    'action' => 'create',
                    'Payment' => $Payment->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Payment cannot be created: " . $e->getMessage(),
                    'action' => "create"
                ),
                422
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

        try{
            $Payment = Payment::findOrFail($id);

            return Response::json(
                array(
                    'error' => false,
                    'Payments' => $Payment->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment cannot be found',
                    'action' => 'show'
                ),
                404
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
        return true;
        // Pas de mise à jour en direct
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
        try{
            $Payment = Payment::findOrFail($id);
            $PeriodEmployeePayment = PeriodEmployeePayment::where('payment_id', $id);
            $PeriodEmployeePayment->delete();
            $Payment->delete();
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment deleted',
                    'action' => 'delete'
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Payment cannot be deleted: '.$e->getMessage(),
                    'action' => 'delete'
                ),
                404
            );
        }
    }

}
