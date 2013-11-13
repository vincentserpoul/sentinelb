<?php

// Model:'EventPeriodEmployee' - Database Table: 'event_period_employee'

Class GlobaleventPeriodEmployee extends Eloquent
{

    protected $table='globalevent_period_employee';

    public function globaleventperiod()
    {
        return $this->hasMany('Globaleventperiod');
    }

    public function employee()
    {
        return $this->hasMany('Employee');
    }

    public function payment()
    {
        return $this->belongsTo('Payment');
    }   

}