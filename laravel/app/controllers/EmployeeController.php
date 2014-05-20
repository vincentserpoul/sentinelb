<?php

class EmployeeController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        $Employees = new Employee;

        $EmployeesList = $Employees->listWithDetails()
                        ->limit(100)
                        ->paginate(50)
                        ->toArray();

        return Response::json(
            array(
                'error' => false,
                'employees' => $EmployeesList['data'],
                'current_page' => $EmployeesList['current_page'],
                'total' => $EmployeesList['total'],
                'last_page' => $EmployeesList['last_page'],
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

            /* Validation of the data */
            $valid = Validator::make(
                Request::json()->all(),
                array(
                    'title_id' => 'integer',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'sex_id' => 'required|integer',
                    'country_code' => 'required',
                    'date_of_birth' => 'required|date',
                    'mobile_phone_number' => 'required',
                    'school' => 'required',
                    'race_id' => 'required',
                    'work_pass_type_id' => 'required',
                    'race_id' => 'required',
                    'employee_identity_doc' => 'min:1'
                )
            );

            if ($valid->fails())
            {
                throw new Exception(implode($valid->messages()->all(':message'), ' - '), 1);
            }

            $Employee = new Employee;

            /* if title_id is undefined, make it 4 */
            $title_id = Request::json('title_id');
            if(empty($title_id)){
                $title_id = 4;
            }
            $Employee->title_id = $title_id;
            $Employee->first_name = strip_tags(trim(ucfirst(strtolower(Request::json('first_name')))));
            $Employee->last_name = strip_tags(trim(ucfirst(strtolower(Request::json('last_name')))));
            $Employee->sex_id = Request::json('sex_id');
            $Employee->country_code = Request::json('country_code');
            $Employee->date_of_birth = Request::json('date_of_birth');
            $Employee->mobile_phone_number = strip_tags(trim(Request::json('mobile_phone_number')));
            $Employee->school = strip_tags(trim(ucfirst(strtolower(Request::json('school')))));
            $Employee->join_date = date('Y-m-d');
            $Employee->race_id = Request::json('race_id');
            $Employee->status_id = 1;
            $Employee->work_pass_type_id = Request::json('work_pass_type_id');

            $Employee->save();

            $id = $Employee->id;

            /*********************/
            /* Employee contacts */
            /*********************/
            $newEmployeeContacts = Request::json('employee_contact');

            if(!is_null($newEmployeeContacts)){

                /* Create the new Docs */
                foreach($newEmployeeContacts as $index=>$newEmployeeContact){
                /* if there is no ID, it means it is a new Doc */
                    $employeeContact = new EmployeeContact;
                    $employeeContact->employee_id = $id;

                    /* if title_id is undefined, make it 4 */
                    if(!array_key_exists('title_id', $newEmployeeContact)){
                        $contact_title_id = 4;
                    }
                    $employeeContact->title_id = $contact_title_id;
                    $employeeContact->first_name = $newEmployeeContact['first_name'];
                    $employeeContact->last_name = $newEmployeeContact['last_name'];
                    $employeeContact->mobile_phone_number = $newEmployeeContact['mobile_phone_number'];
                    $employeeContact->save();
                    $newEmployeeContact[$index]['id'] = $employeeContact->id;
                }
            }

            /*****************/
            /* Employee docs */
            /*****************/
            $newEmployeeDocs = Request::json('employee_doc');

            if(!is_null($newEmployeeDocs)){

                /* Create the new Docs */
                foreach($newEmployeeDocs as $index=>$newEmployeeDoc){
                /* if there is no ID, it means it is a new Doc */
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

            /**************************/
            /* Employee Identity docs */
            /**************************/
            $newEmployeeIdentityDocs = Request::json('employee_identity_doc');

            if(!empty($newEmployeeIdentityDocs)){

                /* Create the new Docs */
                foreach($newEmployeeIdentityDocs as $index=>$newEmployeeIdentityDoc){
                /* if there is no ID, it means it is a new Doc */
                    $employeeIdentityDoc = new EmployeeIdentityDoc;
                    $employeeIdentityDoc->employee_id = $id;
                    $employeeIdentityDoc->identity_doc_type_id = $newEmployeeIdentityDoc['identity_doc_type_id'];
                    $employeeIdentityDoc->identity_doc_number = strip_tags(trim(strtoupper($newEmployeeIdentityDoc['identity_doc_number'])));
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

            /* updates employee with the new data for identity docs */
            $Employee['employee_identity_doc'] = $newEmployeeIdentityDocs;

            /* updates employee with the new data */
            $Employee['employee_doc'] = $newEmployeeDocs;

            /* updates employee with the new data */
            $Employee['employee_contact'] = $newEmployeeContacts;

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employee created',
                    'action' => 'insert',
                    'employee' => $Employee->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Employee cannot be created. " . $e->getMessage(),
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

        // Make sure current user owns the requested resource
        $Employee = Employee::with(array('employee_identity_doc', 'employee_doc', 'employee_contact'))
                ->where('id', $id)
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

        try {

            /* Validation of the data */
            $valid = Validator::make(
                Request::json()->all(),
                array(
                    'title_id' => 'integer',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'sex_id' => 'required|integer',
                    'country_code' => 'required',
                    'date_of_birth' => 'required|date',
                    'mobile_phone_number' => 'required',
                    'school' => 'required',
                    'race_id' => 'required',
                    'work_pass_type_id' => 'required',
                    'race_id' => 'required',
                    'employee_identity_doc' => 'min:1'
                )
            );

            if ($valid->fails())
            {
                throw new Exception(implode($valid->messages()->all(':message'), ' - '), 1);
            }

            $Employee = Employee::find($id);

            if ( !is_null(Request::json('title_id')) ){
                $Employee->title_id = Request::json('title_id');
            }

            if ( !is_null(Request::json('first_name')) ){
                $Employee->first_name = strip_tags(trim(ucfirst(strtolower(Request::json('first_name')))));
            }

            if ( !is_null(Request::json('last_name'))){
                $Employee->last_name = strip_tags(trim(ucfirst(strtolower(Request::json('last_name')))));
            }

            if ( !is_null(Request::json('sex_id')) ){
                $Employee->sex_id = Request::json('sex_id');
            }

            if ( !is_null(Request::json('country_code')) ){
                $Employee->country_code = Request::json('country_code');
            }

            if ( !is_null(Request::json('date_of_birth')) ){
                $Employee->date_of_birth = Request::json('date_of_birth');
            }

            if ( !is_null(Request::json('mobile_phone_number')) ){
                $Employee->mobile_phone_number = strip_tags(trim(Request::json('mobile_phone_number')));
            }

            if ( !is_null(Request::json('school')) ){
                $Employee->school = strip_tags(trim(ucfirst(strtolower(Request::json('school')))));
            }

            if ( !is_null(Request::json('join_date')) ){
                $Employee->join_date = Request::json('join_date');
            }

            if ( !is_null(Request::json('race_id')) ){
                $Employee->race_id = Request::json('race_id');
            }

            if ( !is_null(Request::json('status_id')) ){
                $Employee->status_id = Request::json('status_id');
            }

            if ( !is_null(Request::json('work_pass_type_id')) ){
                $Employee->work_pass_type_id = Request::json('work_pass_type_id');
            }

            $Employee->id = $id;


            /*********************/
            /* Employee contacts */
            /*********************/
            $newEmployeeContacts = Request::json('employee_contact');

            if(!is_null($newEmployeeContacts)){

                /* List of ids that we will keep in the docs */
                $employeeContactIdTokeep = array_column($newEmployeeContacts, 'id');

                /*
                 * Delete all contacts that are not given in the employee json
                 * We could do a simple delete in Db, but in order to trigger the event 'deleted'
                 * We need to loop through the objects
                 */
                $employeeContactToDelete = EmployeeContact::where('employee_contact.employee_id', '=', $id);
                if(!empty($employeeContactIdTokeep)){
                    $employeeContactToDelete->whereNotIn('id', $employeeContactIdTokeep);
                }
                $employeeContactDeleteList = $employeeContactToDelete->get();

                foreach($employeeContactDeleteList as $employeeContact){
                    $employeeContact->delete();
                }

                /* Create the new Docs */
                foreach($newEmployeeContacts as $index=>$newEmployeeContact){
                    /* if there is no ID, it means it is a new Contact */
                    if(!array_key_exists('id', $newEmployeeContact)){
                        $employeeContact = new EmployeeContact;
                        $employeeContact->employee_id = $id;

                        /* if title_id is undefined, make it 4 */
                        if(!array_key_exists('title_id', $newEmployeeContact)){
                            $contact_title_id = 4;
                        }
                        $employeeContact->title_id = $contact_title_id;
                        $employeeContact->first_name = $newEmployeeContact['first_name'];
                        $employeeContact->last_name = $newEmployeeContact['last_name'];
                        $employeeContact->mobile_phone_number = $newEmployeeContact['mobile_phone_number'];
                        $employeeContact->save();
                        $newEmployeeContact[$index]['id'] = $employeeContact->id;
                    }
                }
            }


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
                        $employeeIdentityDoc->identity_doc_number = strip_tags(trim(strtoupper($newEmployeeIdentityDoc['identity_doc_number'])));
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
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Employee cannot be updated. " . $e->getMessage(),
                    'action' => "create"
                ),
                422
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

        $Employee = Employee::find($id);

        /* We don't want a full delete, just inactive status
        $EmployeeIdentityDoc = EmployeeIdentityDoc::where('employee_id', $id);

        $EmployeeIdentityDoc->delete();
        $Employee->delete();
        */
        /* Hardcoded delete status */
        $Employee->status = 1;
        $Employee->save();

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
                                ->limit(10)
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
                                ->whereRaw('not exists (select 1 from period_employee_payment pep, payment pa where pa.payment_id = pep,payment_id and pa.payment_type_id = 1 andpep.globalevent_period_employee_id = globalevent_period_employee.id)')
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

    public function assigned_employees($globalevent_period_id) {

        /* Init employee model */
        $Employees = new Employee;

        /* Get usual employee list details */
        $EmployeesList = $Employees->listWithDetails();

        /* filter with globalevent_period */
        $EmployeesList->join('globalevent_period_employee AS gpe', 'gpe.employee_id', '=', 'employee.id')
                        ->where('gpe.globalevent_period_id', '=', $globalevent_period_id);

        $EmployeesList = $EmployeesList->limit(500)->paginate(50)
                                        ->toArray();

        return Response::json(
            array(
                'error' => false,
                'employees' => $EmployeesList['data'],
                'current_page' => $EmployeesList['current_page'],
                'total' => $EmployeesList['total'],
                'last_page' => $EmployeesList['last_page'],
            ),
            200
        );
    }


    /**
     * Retrieve The list of employee according to a search
     *
     * @param  search criterias
     * @return json List of employees corresponding to criterias
     */
    public function search($listFilterParams) {
        $listFilterParams = json_decode($listFilterParams, true);

        /* If the param is not decodable as array */
        if(is_null($listFilterParams) || !is_array($listFilterParams)){
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'The search params are not well formatted.'
                ),
                200
            );
        }

        /* Init employee model */
        $Employees = new Employee;

        /* Get usual employee list details */
        $EmployeesList = $Employees->listWithDetails($listFilterParams);

        /* In case we want more details on the assignments for a specific event */
        if (isset($listFilterParams['globalevent_id'])) {
            /* get information on the specific assignment we are working on */
            $conflictSelect = Globalevent::find($listFilterParams['globalevent_id'])->employeeConflictQueryBuilder();
            foreach( $conflictSelect['select'] as $conflictEventPeriod){
                 $EmployeesList->addSelect(DB::raw($conflictEventPeriod));
            }

            $EmployeesList->leftjoin('globalevent_period_employee AS gpe ', 'employee.id', '=', 'gpe.employee_id')
                            ->leftjoin('globalevent_period AS gp', function($join) use($conflictSelect){
                                                                        $join->on('gpe.globalevent_period_id', '=', 'gp.id')
                                                                                ->on('gp.start_datetime', '>=', DB::raw("'".$conflictSelect['mindatetime']."'"))
                                                                                ->on('gp.end_datetime', '<=', DB::raw("'".$conflictSelect['maxdatetime']."'"));
                                                                    }
                            );
        }

        //echo $EmployeesList->toSql();die();

        $EmployeesList = $EmployeesList->limit(500)->paginate(50)
                                        ->toArray();

        return Response::json(
            array(
                'error' => false,
                'employees' => $EmployeesList['data'],
                'current_page' => $EmployeesList['current_page'],
                'total' => $EmployeesList['total'],
                'last_page' => $EmployeesList['last_page'],
            ),
            200
        );
    }

}
