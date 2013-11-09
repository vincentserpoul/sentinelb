<?php

// Model:'PeriodEmployeePayment' - Database Table: 'period_employee_payment'

Class PeriodEmployeePayment extends Eloquent
{

    protected $table='period_employee_payment';

    public function globaleventperiod()
    {
        return $this->belongsTo('Globaleventperiod');
    }

    public function payment()
    {
        return $this->hasMany('Payment');
    }   

}