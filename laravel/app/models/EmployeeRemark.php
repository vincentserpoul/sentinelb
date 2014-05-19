<?php

// Model:'EmployeeRemark' - Database Table: 'employee_remark'

Class EmployeeRemark extends Eloquent
{

    protected $table='employee_remark';

    public function employee()
    {
        return $this->BelongsTo('Employee');
    }

    public function event()
    {
        return $this->belongsTo('Event');
    }

    public function globaleventperiod()
    {
        return $this->belongsTo('Globaleventperiod');
    }

}
