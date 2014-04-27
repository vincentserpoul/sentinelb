<?php

// Model:'EmployeeContact' - Database Table: 'employee_contact'

Class EmployeeContact extends Eloquent
{

    protected $table='employee_contact';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function title()
    {
        return $this->belongsTo('Title');
    }

    public function sex()
    {
        return $this->belongsTo('Sex');
    }
}
