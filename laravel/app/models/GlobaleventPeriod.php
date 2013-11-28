<?php

// Model:'EventPeriod' - Database Table: 'event_period'

Class GlobaleventPeriod extends Eloquent
{

    protected $table='globalevent_period';

    public function employeeremarks()
    {
        return $this->hasMany('Employeeremark');
    }

    public function eventperiodemployee()
    {
        return $this->hasMany('GlobaleventPeriodEmployee');
    }

    public function globalevent()
    {
        return $this->belongsTo('Globalevent');
    }

    public function employee()
    {
        return $this->belongsToMany('Employee', 'globalevent_period_employee')
                     ->withPivot('real_start_datetime', 'real_end_datetime');
    }

}
