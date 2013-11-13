<?php
// Model:'EmployeeDoc' - Database Table: 'employee_doc'

Class EmployeeDoc extends Eloquent
{

    protected $hidden = array('user_id', 'created_at', 'updated_at');
    protected $table='employee_doc';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function doc_type()
    {
        return $this->belongsTo('DocType');
    }    
    
}