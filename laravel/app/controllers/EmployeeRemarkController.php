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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($remark_id){

        try{

            $EmployeeRemark = EmployeeRemark::findOrFail($remark_id);

            return Response::json(
                array(
                    'error' => false,
                    'EmployeeRemarks' => $EmployeeRemark->toArray()
                ),
                200
            );
        }
        catch{
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Remark cannot be found: '.$e->getMessage()
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
     * @param  int  $remark_id
     * @return Response
     */
    public function update($remark_id){
        try{
            $EmployeeRemark = EmployeeRemark::findOrFail($remark_id);

            $EmployeeRemark->remark = Request::json('remark');
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
                    'message' => 'Remark cannot be updated: '.$e->getMessage()
                ),
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $remark_id
     * @return Response
     */
    public function destroy($remark_id){

        try{

            $EmployeeRemark = EmployeeRemark::findOrFail($remark_id);

            $EmployeeRemark->delete();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Remark deleted'
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Remark cannot be deleted: ' . $e->getMessage()
                    ),
                500
            );
        }
    }

}
