<?php

// Model:'Employee' - Database Table: 'employee'

Class Employee extends Eloquent
{

    protected $hidden = array('user_id', 'created_at', 'updated_at');
    protected $table='employee';

    public function employee_address()
    {
        return $this->hasMany('EmployeeAddress');
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

    public function globalevent_period_employee()
    {
        return $this->hasMany('GlobaleventPeriodEmployee');
    }

    public function globalevent_period()
    {
        return $this->belongsToMany('GlobaleventPeriod', 'globalevent_period_employee')
                    ->withPivot('real_start_datetime', 'real_end_datetime');
    }

    public function race()
    {
        return $this->belongsTo('Race');
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
