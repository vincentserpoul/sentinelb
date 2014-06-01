<?php

// Model:'EventPeriodEmployee' - Database Table: 'event_period_employee'

Class Payment extends Eloquent
{

    protected $table='payment';

    public function payment_type()
    {
        return $this->belongsTo('PaymentType');
    }

    public function getGlobaleventPeriodPayments($globaleventPeriodEmployeeIds){
        $payment = new GlobaleventPeriodEmployee;
        $payment = $payment->getGlobaleventPeriodEmployeePayments($globaleventPeriodEmployeeIds);

        return $payment;
    }
}
