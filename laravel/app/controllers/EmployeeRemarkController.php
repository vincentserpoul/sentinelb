<?php

class EmployeeRemarkController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($employee_id){

        try {

            if (empty($employee_id))
            {
                throw new Exception('Please specify an employee', 1);
            }

            $EmployeeRemarks = new EmployeeRemark;

            $EmployeeRemarksList = $EmployeeRemarks::where('employee_id', '=', $employee_id)->get()->toArray();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Remarks for '.$employee_id,
                    'employee_remarks' => $EmployeeRemarksList,
                ),
                200
            );

        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => $e->getMessage()
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
    public function store($employee_id){

        try {

            if (empty($employee_id))
            {
                throw new Exception('Please specify an employee', 1);
            }

            /* Validation of the data */
            $valid = Validator::make(
                Request::json()->all(),
                array(
                    'remark' => 'required|min:5|max:5000',
                )
            );

            if ($valid->fails())
            {
                throw new Exception(implode($valid->messages()->all(':message'), ' - '), 1);
            }

            $EmployeeRemark = new EmployeeRemark;

            $EmployeeRemark->employee_id = $employee_id;
            if( !empty(Request::json('globalevent_period_id'))){
                $EmployeeRemark->globalevent_period_id = Request::json('globalevent_period_id');
            }
            $EmployeeRemark->remark = Request::json('remark');

            // Validation and Filtering is sorely needed!!
            // Seriously, I'm a bad person for leaving that out.

            $EmployeeRemark->save();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Remark saved',
                    'action' => 'create',
                    'employee_remark' => $EmployeeRemark->toArray()
                ),
                200
            );

        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Remark cannot be created: '.$e->getMessage()
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
