<?php

// Model:'EmployeeAddress' - Database Table: 'employee_address'

Class EmployeeAddress extends Eloquent
{

    protected $table='employee_address';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

}