<?php

class GlobaleventPeriodEmployeeController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        try {
            $GlobaleventPeriodEmployees = GlobaleventPeriodEmployee::get();

            return Response::json(
                array(
                    'error' => false,
                    'GlobaleventPeriodEmployees' => $GlobaleventPeriodEmployees->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'GlobaleventPeriodEmployees cannot be returned. ' . $e->getMessage(),
                    'action' => 'get'
                ),
                500
            );
        }
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
    public function store () {

        try {
            if (!Request::json('globalevent_period_id') || !Request::json('employee_id'))
                throw new Exception('Missing event period detail or employee detail');

            $globalevent_period_employees = $this->assign(Request::json('globalevent_period_id'), Request::json('employee_id'));

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employee is successfully assigned',
                    'globalevent_period_employees' => $globalevent_period_employees->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employee cannot be assigned.' . $e->getMessage(),
                    'action' => 'create'
                ),
                500
            );
        }
    }

    public function assign_whole_event () {
        try {
            if (!Request::json('globalevent_id') || !Request::json('employee_id'))
                throw new Exception('Missing event detail or employee detail');

            $possible_globalevent_periods = $this->get_possible_globalevent_period(Request::json('employee_id'), Request::json('globalevent_id'));
            
            $globalevent_period_employees = array();

            foreach ($possible_globalevent_periods as $possible_globalevent_period) {
                $globalevent_period_employee = $this->assign($possible_globalevent_period->id, Request::json('employee_id'));
                $globalevent_period_employees[] = $globalevent_period_employee->toArray();
            }

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employee is successfully assigned',
                    'globalevent_period_employees' => $globalevent_period_employees
                ),
                200
            );

        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Employee cannot be assigned.' . $e->getMessage(),
                    'globalevent_period_employees' => $globalevent_period_employees,
                    'action' => 'create'
                ),
                500
            );
        }
    }

    /**
     * assign event period 
     * 
     */
    private function assign($globalevent_period_id, $employee_id) {
        $GlobaleventPeriodEmployee = new GlobaleventPeriodEmployee;
        $GlobaleventPeriodEmployee->globalevent_period_id = $globalevent_period_id;
        $GlobaleventPeriodEmployee->employee_id = $employee_id;
        //$GlobaleventPeriodEmployee->real_start_datetime = Request::json('real_start_datetime');

        if (!$this->check_assignment($GlobaleventPeriodEmployee->employee_id, $GlobaleventPeriodEmployee->globalevent_period_id))
            throw new Exception('Already assigned or employee is assigned to event period with overlapping timeslot');

        $GlobaleventPeriodEmployee->save();
        return $GlobaleventPeriodEmployee;
    }

    private function check_assignment ($employee_id, $globalevent_period_id) {
        
        $assginedGlobaleventPeriodQuery = 
            'SELECT DISTINCT globalevent_period.* ' .
            'FROM globalevent_period WHERE id IN ( ' .
                'SELECT globalevent_period_employee.globalevent_period_id ' .
                'FROM globalevent_period_employee ' .
                'WHERE globalevent_period_employee.employee_id = ' . $employee_id . ')';

        $query =    
            'EXISTS (SELECT * FROM (' . 
            $assginedGlobaleventPeriodQuery . 
            ') AS assgined_globalevent_period ' .
            'WHERE globalevent_period.id = assgined_globalevent_period.id ' .
                'OR (assgined_globalevent_period.start_datetime <= globalevent_period.end_datetime ' .
                'AND globalevent_period.start_datetime <= assgined_globalevent_period.end_datetime))';
                

        $globaleventPeriods = 
            DB::table('globalevent_period')
            ->where('globalevent_period.id', '=', $globalevent_period_id)
            ->whereRaw($query)
            ->select('globalevent_period.*')
            ->distinct()
            ->get();

        if (count($globaleventPeriods))
            return false;
        return true;    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){
        // Make sure current user owns the requested resource
        $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::where('id', $id)
                ->take(1)
                ->get();

        return Response::json(
            array(
                'error' => false,
                'GlobaleventPeriodEmployees' => $GlobaleventPeriodEmployee->toArray()
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

        $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::find($id);

        if ( Request::json('Globalevent_period_id') ){
            $GlobaleventPeriodEmployee->globalevent_period_id = Request::json('globalevent_period_id');
        }

        if ( Request::json('employee_id') ){
            $GlobaleventPeriodEmployee->employee_id = Request::json('employee_id');
        }

        if ( Request::json('real_start_datetime') ){
            $GlobaleventPeriodEmployee->real_start_datetime = Request::json('real_start_datetime');
        }

        if ( Request::json('real_end_datetime') ){
            $GlobaleventPeriodEmployee->real_end_datetime = Request::json('real_end_datetime');
        }


        $GlobaleventPeriodEmployee->id = $id;

        $GlobaleventPeriodEmployee->save();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Globalevent period employee updated'
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

        try {
            if (Input::has('employee_id') && Input::has('event_period_id')) { 

                $now = new Datetime();

                $GlobaleventPeriod = GlobaleventPeriod::find(Input::get('event_period_id'));

                if ($now > new Datetime($GlobaleventPeriod->end_datetime))
                    throw new Exception('Cannot delete assignments from past event periods');

                $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::where('employee_id', '=', Input::get('employee_id'))
                                        ->where('globalevent_period_id', '=', Input::get('event_period_id'))
                                        ->delete();

                return Response::json(
                    array(
                        'error' => false,
                        'message' => 'Globalevent period employee deleted',
                        'globalevent_period_employee' => $GlobaleventPeriodEmployee->toArray()
                        ),
                    200
                );
            } else throw new Exception ('Missing arguments');
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Globalevent period employee cannot be deleted. ' . $e->getMessage()
                    ),
                500
            );
        }
    }

    /*
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
