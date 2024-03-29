<?php

class GlobaleventPeriodController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        $GlobaleventPeriods = GlobaleventPeriod::with(array('globalevent', 'globaleventperiodemployee'))
                                                ->paginate(10)
                                                ->toArray();

        return Response::json(
            array(
                'error' => false,
                'globalevent_periods' => $GlobaleventPeriods['data'],
                'current_page' => $GlobaleventPeriods['current_page'],
                'last_page' => $GlobaleventPeriods['last_page'],
                'total' => $GlobaleventPeriods['total']
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

        $GlobaleventPeriods = new GlobaleventPeriod;

        // Make sure current user owns the requested resource
        $GlobaleventPeriods = $GlobaleventPeriods
                ->where('id', $id)
                ->take(1)
                ->get();

        return Response::json(
            array(
                'error' => false,
                'globalevent_periods' => $GlobaleventPeriods->toArray()
            ),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){

        $GlobaleventPeriod = new GlobaleventPeriod;

        $GlobaleventPeriod->globalevent_id = Request::json('globalevent_id');
        $GlobaleventPeriod->start_datetime = Request::json('start_datetime');
        $GlobaleventPeriod->end_datetime = Request::json('end_datetime');
        $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');

        // validate info
        if (strtotime($GlobaleventPeriod->end_datetime) <= strtotime($GlobaleventPeriod->start_datetime))
            throw new Exception('End datetime must be after start datetime', 1);
        if ($GlobaleventPeriod->number_of_employee_needed < 1)
            throw new Exception("Number of employees needed must be greater than 0", 1);

        $GlobaleventPeriod->save();

        $id = $GlobaleventPeriod->id;

        /* Get the data back */
        $GlobaleventPeriod = new GlobaleventPeriod;
        $GlobaleventPeriod = $GlobaleventPeriod->listWithDetails(array('id'=>$id))
                                                ->take(1)
                                                ->get();

        return Response::json(
            array(
                'error' => false,
                'message' => 'Event Period successfully created',
                'globalevent_periods' => $GlobaleventPeriod->toArray()
            ),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

        try {
            $GlobaleventPeriod = GlobaleventPeriod::find($id);

            if ( Request::json('globalevent_id') ){
                $GlobaleventPeriod->globalevent_id = Request::json('globalevent_id');
            }

            if ( new DateTime(Request::json('start_datetime')) ){
                $GlobaleventPeriod->start_datetime = Request::json('start_datetime');
            }

            if ( new DateTime(Request::json('end_datetime')) ){
                $GlobaleventPeriod->end_datetime = Request::json('end_datetime');
            }

            if ( Request::json('number_of_employee_needed') ){
                $GlobaleventPeriod->number_of_employee_needed = Request::json('number_of_employee_needed');
            }

            // validate info
            if ($GlobaleventPeriod->end_datetime <= $GlobaleventPeriod->start_datetime)
                throw new Exception('End datetime must be after start datetime', 1);
            if ($GlobaleventPeriod->number_of_employee_needed < 1)
                throw new Exception("Number of employees needed must be greater than 0", 1);

            $GlobaleventPeriod->id = $id;

            $GlobaleventPeriod->save();

            $id = $GlobaleventPeriod->id;

            /* Get the data back */
            $GlobaleventPeriod = new GlobaleventPeriod;
            $GlobaleventPeriod = $GlobaleventPeriod->listWithDetails(array('id'=>$id))
                                                    ->take(1)
                                                    ->get();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event Period successfully created',
                    'globalevent_periods' => $GlobaleventPeriod->toArray()
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event period cannot be updated.' . $e->getMessage(),
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

        try {
            $GlobaleventPeriod = GlobaleventPeriod::find($id);
            $GlobaleventPeriodEmployee = GlobaleventPeriodEmployee::where('globalevent_period_id', $id);

            if($GlobaleventPeriodEmployee->count() > 1){
                throw new Exception('Some employees are still associated to it', 1);
            }

            $GlobaleventPeriodEmployee->delete();
            $GlobaleventPeriod->delete();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Global event period deleted'
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Event period cannot be deleted: ' . $e->getMessage(),
                    'action' => 'delete'
                ),
                500
            );
        }
    }

    /**
     * Get the the list of employees already assigned to the globalevent period
     *
     * @return Response
     */
    public function assigned_employees($id){

        $Employees = new Employee;

        $EmployeesList = $Employees
                        ->listWithDetails()
                        ->join('globalevent_period_employee', 'globalevent_period_employee.employee_id', '=', 'employee.id')
                        ->where('globalevent_period_employee.globalevent_period_id', '=', $id)
                        ->addSelect(DB::raw('globalevent_period_employee.id AS globalevent_period_employee_id'))
                        ->limit(100)
                        ->paginate(10)
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
