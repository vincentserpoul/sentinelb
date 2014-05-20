<?php

// Model:'EventPeriodEmployee' - Database Table: 'event_period_employee'

Class Payment extends Eloquent
{

    protected $table='payment';

    public function globalevent_period_employee()
    {
        return $this->belongsToMany('GlobaleventPeriodEmployee', 'period_employee_payment')->withTimestamps();
    }

    public function payment_type()
    {
        return $this->belongsTo('PaymentType');
    }

}
