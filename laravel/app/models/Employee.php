<?php

// Model:'Employee' - Database Table: 'employee'

Class Employee extends Eloquent
{

    protected $hidden = array('user_id', 'created_at', 'updated_at');
    protected $table='employee';

    public function employee_address()
    {
        return $this->hasMany('Employeeaddress');
    }

    public function employee_identity_doc()
    {
        return $this->hasMany('EmployeeIdentityDoc');
    }

    public function employee_doc()
    {
        return $this->hasMany('EmployeeDoc');
    }


    public function employee_remarks()
    {
        return $this->hasMany('Employeeremark');
    }

    public function event_period_employee()
    {
        return hasMany('Eventperiodemployee');
    }

    public function race()
    {
        return $this->hasOne('Race');
    }

    public function status()
    {
        return $this->belongsTo('Status');
    }

    public function work_pass_type()
    {
        return $this->hasOne('WorkPassType');
    }

    public function sex()
    {
        return $this->hasOne('Sex');
    }

    public function title()
    {
        return $this->hasOne('Title');
    }

    public function country()
    {
        return $this->hasOne('Country');
    }  
}