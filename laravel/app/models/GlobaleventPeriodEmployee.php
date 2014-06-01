<?php

// Model:'GlobaleventPeriodEmployee' - Database Table: 'globalevent_period_employee'

Class GlobaleventPeriodEmployee extends Eloquent
{

    protected $table='globalevent_period_employee';

    public function globalevent_period()
    {
        return $this->belongsTo('GlobaleventPeriod');
    }

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function payment()
    {
        return $this->belongsTo('Payment');
    }

    public function scopeEmployee($employee_id){
        return $this->getQuery()->where('employee_id', '=', $employee_id);
    }


    public function getGlobaleventPeriodEmployeePayments($globaleventPeriodEmployeeIds){
        $GlobaleventPeriodEmployees = GlobaleventPeriodEmployee::whereIn('globalevent_period_employee.id', $globaleventPeriodEmployeeIds)
                                        ->join('globalevent_period', 'globalevent_period.id', '=', 'globalevent_period_employee.globalevent_period_id')
                                        ->join('globalevent', 'globalevent_period.globalevent_id', '=', 'globalevent.id')
                                        ->join('client_department', 'client_department.id', '=', 'globalevent.client_department_id')
                                        ->whereNotNull('real_start_datetime')
                                        ->whereNotNull('real_end_datetime')
                                        ->selectRaw('ROUND(IF(ISNULL(globalevent_period_employee.employee_h_rate), client_department.employee_h_rate, globalevent_period_employee.employee_h_rate)*(TIMESTAMPDIFF(SECOND, real_start_datetime, real_end_datetime)-real_break_duration_s)/3600, 2) as amount
                                                    , GROUP_CONCAT(globalevent_period_employee.id) as globalevent_period_employee_ids
                                                    , client_department.employee_h_rate_currency_code as currency_code
                                                    , globalevent_period_employee.employee_id')
                                        ->groupBy('client_department.employee_h_rate_currency_code');

        return $GlobaleventPeriodEmployees->get()->toArray();
    }

}
