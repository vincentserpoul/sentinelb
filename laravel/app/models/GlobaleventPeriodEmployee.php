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
        return $this->belongsToMany('Payment', 'period_employee_payment');
    }

    public function scopeEmployee($employee_id){
        return $this->getQuery()->where('employee_id', '=', $employee_id);
    }

}
