<?php

// Model:'Event' - Database Table: 'event'

Class Globalevent extends Eloquent
{

    protected $table='globalevent';

    public function employeeremarks()
    {
        return $this->hasMany('Employeeremark');
    }

    public function employerdepartment()
    {
        return $this->hasOne('Employerdepartment');
    }

    public function globalevent_period()
    {
        return $this->hasMany('GlobaleventPeriod');
    }


}
