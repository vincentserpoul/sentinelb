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
        return hasMany('Globaleventperiodemployee');
    }
    public function globalevent()
    {
        return $this->hasOne('Globalevent');
    }

}