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

            $validationForPayment = array(
                'amount' => 'required',
                'currency_code' => 'required|size:3|alphanum',
                'globalevent_period_employee_ids' => 'required|array|min:1',
                'payment_type_id' => 'required|integer',
                'employee_id' => 'required|integer',
            );

            $paymentRequest = Request::json()->all();

            /* If theres no payment type, then we push for the default one */
            if(empty($paymentRequest['payment_type_id'])){
                $paymentRequest['payment_type_id'] = 2;
            }

            /* if there is no globalevent periods then we remove the check and else we need an amount and a currency */
            if(empty($paymentRequest['globalevent_period_employee_ids'])){
                unset($validationForPayment['globalevent_period_employee_ids']);
                // it means it is labor work
                $paymentRequest['payment_type_id'] = 1;
            } else {
                unset($validationForPayment['amount']);
                unset($validationForPayment['currency_code']);
                unset($validationForPayment['employee_id']);
            }

            /* Validation of the data */
            $valid = Validator::make(
                $paymentRequest,
                $validationForPayment
            );

            if ($valid->fails())
            {
                throw new Exception(implode($valid->messages()->all(':message'), ' - '), 1);
            }


            /* Validation of globalevent_periodids and generate amount and currency */
            $Payment = new Payment;

            if(!empty($paymentRequest['globalevent_period_employee_ids'])){
            $paymentInfos = $Payment->getGlobaleventPeriodPayments($paymentRequest['globalevent_period_employee_ids']);

                $paymentRequest['amount'] = $paymentInfos[0]['amount'];
                $paymentRequest['currency_code'] = $paymentInfos[0]['currency_code'];
                $paymentRequest['employee_id'] = $paymentInfos[0]['employee_id'];

                /* If none of the global event periods is processable, throw an error */
                if(empty($paymentInfos[0]['globalevent_period_employee_ids'])){
                    throw new Exception('none of your event period is processable', 1);
                }

                $paymentRequest['globalevent_period_employee_ids'] = explode(', ', $paymentInfos[0]['globalevent_period_employee_ids']);
            }

            // Pas de création en direct
            $Payment->amount = $paymentRequest['amount'];
            $Payment->currency_code = $paymentRequest['currency_code'];
            $Payment->payment_type_id = $paymentRequest['payment_type_id'];
            $Payment->employee_id = $paymentRequest['employee_id'];

            $Payment->save();


            /* If globalevent_period are specified, Associate the payment with globalevent_period */
            if(!empty($paymentRequest['globalevent_period_employee_ids'])){
                $Payment->globalevent_period_employee()->sync($paymentRequest['globalevent_period_employee_ids']);
            }

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
