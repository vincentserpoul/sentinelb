<?php
// Model:'IdentityDocType' - Database Table: 'identity_doc_type'

Class IdentityDocType extends Eloquent
{

	protected $visible = array('id', 'label');
    protected $table='identity_doc_type';

    public function employeeidentitydoc()
    {
        return hasMany('EmployeeIdentityDoc');
    }
}