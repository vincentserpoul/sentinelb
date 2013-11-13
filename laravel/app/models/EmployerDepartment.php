<?php

// Model:'EmployerDepartment' - Database Table: 'employer_department'

Class EmployerDepartment extends Eloquent
{

    protected $table='employer_department';

    public function event()
    {
        return $this->hasOne('Event');
    }

    public function employer()
    {
        return $this->hasOne('Employer');
    }

    public function worktype()
    {
        return $this->hasMany('Worktype');
    }

    public function currency()
    {
        return $this->belongsTo('Currency');
    }
}