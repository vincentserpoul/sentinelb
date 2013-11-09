<?php
// Model:'EmployeeIdentityDoc' - Database Table: 'employee_identity_doc'

Class EmployeeIdentityDoc extends Eloquent
{

    protected $hidden = array('user_id', 'created_at', 'updated_at');
    protected $table='employee_identity_doc';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function identity_doc_type()
    {
        return $this->belongsTo('IdentityDocType');
    }    
    
}