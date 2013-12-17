<?php

class EmployeeController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        $Employees = Employee::with(array('employee_identity_doc', 'employee_doc'))->get();

        return Response::json(
            array(
                'error' => false,
                'employees' => $Employees->toArray()
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
        $Employee = new Employee;

        $Employee->title_id = Request::json('title_id');
        $Employee->first_name = Request::json('first_name');
        $Employee->last_name = Request::json('last_name');
        $Employee->sex_id = Request::json('sex_id');
        $Employee->country_code = Request::json('country_code');
        $Employee->date_of_birth = Request::json('date_of_birth');
        $Employee->mobile_phone_number = Request::json('mobile_phone_number');
        $Employee->school = Request::json('school');
        $Employee->join_date = Request::json('join_date');
        $Employee->race_id = Request::json('race_id');
        $Employee->status_id = Request::json('status_id');
        $Employee->work_pass_type_id = Request::json('work_pass_type_id');

        //$Employee->user_id = Auth::user()->id;

        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.

        $Employee->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Employee created',
                'action' => 'insert',
                'employee' => $Employee->toArray()
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
        $Employee = Employee::where('id', $id)
                ->take(1)
                ->get();

        return Response::json(
            array(
                'error' => false,
                'employees' => $Employee->toArray()
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

        $Employee = Employee::find($id);

        if ( Request::json('title_id') ){
            $Employee->title_id = Request::json('title_id');
        }

        if ( Request::json('first_name') ){
            $Employee->first_name = Request::json('first_name');
        }

        if ( Request::json('last_name') ){
            $Employee->last_name = Request::json('last_name');
        }

        if ( Request::json('sex_id') ){
            $Employee->sex_id = Request::json('sex_id');
        }

        if ( Request::json('country_code') ){
            $Employee->country_code = Request::json('country_code');
        }

        if ( Request::json('date_of_birth') ){
            $Employee->date_of_birth = Request::json('date_of_birth');
        }

        if ( Request::json('mobile_phone_number') ){
            $Employee->mobile_phone_number = Request::json('mobile_phone_number');
        }

        if ( Request::json('school') ){
            $Employee->school = Request::json('school');
        }

        if ( Request::json('join_date') ){
            $Employee->join_date = Request::json('join_date');
        }

        if ( Request::json('race_id') ){
            $Employee->race_id = Request::json('race_id');
        }

        if ( Request::json('status_id') ){
            $Employee->status_id = Request::json('status_id');
        }

        if ( Request::json('work_pass_type_id') ){
            $Employee->work_pass_type_id = Request::json('work_pass_type_id');
        }

        $Employee->id = $id;

        /*****************/
        /* Employee docs */
        /*****************/
        $newEmployeeDocs = Request::json('employee_doc');

        if(!is_null($newEmployeeDocs)){
            /* List of ids that we will keep in the docs */
            $employeeDocIdTokeep = array_column($newEmployeeDocs, 'id');

            /*
             * Delete all doc ids that are not given in the employee json
             * We could do a simple delete in Db, but in order to trigger the event 'deleted'
             * We need to loop through the objects
             */
            $employeeDocToDelete = EmployeeDoc::where('employee_doc.employee_id', '=', $id);
            if(!empty($employeeDocIdTokeep)){
                $employeeDocToDelete->whereNotIn('id', $employeeDocIdTokeep);
            }
            $employeeDocDeleteList = $employeeDocToDelete->get();

            foreach($employeeDocDeleteList as $employeeDoc){
                $employeeDoc->delete();
            }

            /* Create the new Docs */
            foreach($newEmployeeDocs as $index=>$newEmployeeDoc){
                /* if there is no ID, it means it is a new Doc */
                if(!array_key_exists('id', $newEmployeeDoc)){
                    $employeeDoc = new EmployeeDoc;
                    $employeeDoc->employee_id = $id;
                    $employeeDoc->doc_type_id = $newEmployeeDoc['doc_type_id'];
                    $employeeDoc->save();
                    $newEmployeeDocs[$index]['id'] = $employeeDoc->id;

                    /* if there is an uploaded image */
                    if(array_key_exists('doc_image', $newEmployeeDoc)){
                        $employeeDoc->saveImage($newEmployeeDoc['doc_image']);
                        /* replace the url data so that the response is not long */
                        unset($newEmployeeDocs[$index]['doc_image']);
                    }
                }
            }
        }

        /**************************/
        /* Employee Identity docs */
        /**************************/
        $newEmployeeIdentityDocs = Request::json('employee_identity_doc');

        if(!is_null($newEmployeeIdentityDocs)){
            /* List of ids that we will keep in the docs */
            $employeeIdentityDocIdTokeep = array_column($newEmployeeIdentityDocs, 'id');

            /*
             * Delete all doc ids that are not given in the employee json
             * We could do a simple delete in Db, but in order to trigger the event 'deleted'
             * We need to loop through the objects
             */
            $employeeIdentityDocToDelete = EmployeeIdentityDoc::where('employee_identity_doc.employee_id', '=', $id);
            if(!empty($employeeIdentityDocIdTokeep)){
                $employeeIdentityDocToDelete->whereNotIn('id', $employeeIdentityDocIdTokeep);
            }
            $employeeIdentityDocToDeleteList = $employeeIdentityDocToDelete->get();

            foreach($employeeIdentityDocToDeleteList as $employeeIdentityDoc){
                $employeeIdentityDoc->delete();
            }

            /* Create the new Docs */
            foreach($newEmployeeIdentityDocs as $index=>$newEmployeeIdentityDoc){
                /* if there is no ID, it means it is a new Doc */
                if(!array_key_exists('id', $newEmployeeIdentityDoc)){
                    $employeeIdentityDoc = new EmployeeIdentityDoc;
                    $employeeIdentityDoc->employee_id = $id;
                    $employeeIdentityDoc->identity_doc_type_id = $newEmployeeIdentityDoc['identity_doc_type_id'];
                    $employeeIdentityDoc->identity_doc_number = $newEmployeeIdentityDoc['identity_doc_number'];
                    $employeeIdentityDoc->identity_doc_validity_start = $newEmployeeIdentityDoc['identity_doc_validity_start'];
                    $employeeIdentityDoc->identity_doc_validity_end = $newEmployeeIdentityDoc['identity_doc_validity_end'];
                    $employeeIdentityDoc->save();
                    $newEmployeeIdentityDocs[$index]['id'] = $employeeIdentityDoc->id;

                    /* if there is an uploaded image */
                    if(array_key_exists('doc_image', $newEmployeeIdentityDoc)){
                        $employeeIdentityDoc->saveImage($newEmployeeIdentityDoc['doc_image']);
                        /* replace the url data so that the response is not long */
                        $newEmployeeIdentityDoc[$index]['image_name'] = $employeeIdentityDoc->image_name;
                        unset($newEmployeeIdentityDoc[$index]['doc_image']);
                    }
                }
            }
        }



        $Employee->save();

        /* updates employee with the new data for identity docs */
        $Employee['employee_identity_doc'] = $newEmployeeIdentityDocs;

        /* updates employee with the new data */
        $Employee['employee_doc'] = $newEmployeeDocs;

        return Response::json(
            array(
                'error' => false,
                'message' => 'Employee updated',
                'action' => 'update',
                'employee' => $Employee->toArray()
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

        $Employee = Employee::find($id);
        $EmployeeIdentityDoc = EmployeeIdentityDoc::where('employee_id', $id);

        $EmployeeIdentityDoc->delete();
        $Employee->delete();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Employee deleted',
                'action' => 'delete',
                'employee' => $Employee->toArray()
                ),
            200
        );
    }

    /**
     * Retrieve The list of employee assignments.
     *
     * @param  int  $employee_id
     * @return Response
     */
    public function globalevent_period($employee_id){

        $globaleventPeriods = Employee::where('employee.id', '=', $employee_id)
                                ->join('globalevent_period_employee', 'employee.id', '=', 'globalevent_period_employee.employee_id')
                                ->join('globalevent_period', 'globalevent_period.id', '=', 'globalevent_period_employee.globalevent_period_id')
                                ->join('globalevent', 'globalevent_period.globalevent_id', '=', 'globalevent.id')
                                ->leftjoin('period_employee_payment', 'globalevent_period_employee.id', '=', 'period_employee_payment.globalevent_period_employee_id')
                                ->leftjoin('payment', 'period_employee_payment.payment_id', '=', 'payment.id')
                                ->select('globalevent.*', 'globalevent_period.*', 'globalevent_period_employee.*', 'payment.id as payment_id')
                                ->orderBy('globalevent_period.end_datetime', 'desc')
                                ->get();

        return Response::json(
            array(
                'error' => false,
                'globalevent_periods' => $globaleventPeriods->toArray()
            ),
            200
        );
    }

    /**
     * Retrieve The list of employee assignments.
     *
     * @param  int  $employee_id
     * @return Response
     */
    public function unpaid_globalevent_period($employee_id){

        $globaleventPeriods = Employee::where('employee.id', '=', $employee_id)
                                ->join('globalevent_period_employee', 'employee.id', '=', 'globalevent_period_employee.employee_id')
                                ->join('globalevent_period', 'globalevent_period.id', '=', 'globalevent_period_employee.globalevent_period_id')
                                ->join('globalevent', 'globalevent_period.globalevent_id', '=', 'globalevent.id')
                                ->whereRaw('not exists (select 1 from period_employee_payment pep where pep.globalevent_period_employee_id = globalevent_period_employee.id)')
                                ->select('globalevent.*', 'globalevent_period.*', 'globalevent_period_employee.*')
                                ->orderBy('globalevent_period.end_datetime', 'desc')
                                ->get();

        return Response::json(
            array(
                'error' => false,
                'globalevent_periods' => $globaleventPeriods->toArray()
            ),
            200
        );
    }

    /**
     * Retrieve The list of employee possible assignments.
     *
     * @param  int  $employee_id, $event_id
     * @return Response
     */
    public function possible_globalevent_period ($employee_id, $event_id) {

        try {
            return Response::json(
                array(
                    'error' => false,
                    'globalevent_periods' => $this->get_possible_globalevent_period($employee_id, $event_id)
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => $e->getMessage()
                ),
                500
            );
        }
    }

    public function all_possible_globalevent_period ($event_id) {
        
        try {
            $Employees = Employee::with(array('employee_identity_doc', 'employee_doc'))->get();
            foreach ($Employees as $Employee) {
                $Employee['possible_globalevent_periods'] = $this->get_possible_globalevent_period($Employee['id'], $event_id);
            }
            return Response::json(
                array(
                    'error' => false,
                    'Employees' => $Employees->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => $e->getMessage()
                ),
                500
            );   
        }
    }

    public function assigned_employees ($globalevent_period_id) {

        try {
            $assigned_employees = 
                DB::table('employee')
                ->join('globalevent_period_employee', 'globalevent_period_employee.employee_id', '=', 'employee.id')
                ->join('globalevent_period', 'globalevent_period_employee.globalevent_period_id', '=', 'globalevent_period.id')
                ->where('globalevent_period.id', '=', $globalevent_period_id)
                ->select('employee.*', 'globalevent_period_employee.id as globalevent_period_employee_id')
                ->distinct()
                ->get();

            return Response::json(
                array(
                    'error' => false,
                    'Employees' => $assigned_employees
                ),
                200
            );    
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => $e->getMessage()
                ),
                500
            ); 
        }
    }

    /**
     * Retrieve The list of employee possible assignments.
     *
     * @param  int  $employee_id, $event_id
     * @return Response
     */
    private function get_possible_globalevent_period ($employee_id, $event_id) {
        $assginedGlobaleventPeriodQuery = 
            'SELECT DISTINCT globalevent_period.* ' .
            'FROM globalevent_period WHERE id IN ( ' .
                'SELECT globalevent_period_employee.globalevent_period_id ' .
                'FROM globalevent_period_employee ' .
                'WHERE globalevent_period_employee.employee_id = ' . $employee_id . ')';

        $query =    
            'NOT EXISTS (SELECT * FROM (' . 
            $assginedGlobaleventPeriodQuery . 
            ') AS assgined_globalevent_period ' .
            'WHERE globalevent_period.id = assgined_globalevent_period.id ' .
                'OR (assgined_globalevent_period.start_datetime <= globalevent_period.end_datetime ' .
                'AND globalevent_period.start_datetime <= assgined_globalevent_period.end_datetime))';

        if ($event_id)
            return $globaleventPeriods = 
                DB::table('globalevent_period')
                ->whereRaw($query)
                ->where('globalevent_period.globalevent_id', '=', $event_id)
                ->select('globalevent_period.*')
                ->distinct()
                ->get();
        else 
            return $globaleventPeriods = 
                DB::table('globalevent_period')
                ->whereRaw($query)
                ->select('globalevent_period.*')
                ->distinct()
                ->get();

    }
}
