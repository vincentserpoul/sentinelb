<?php
// Model:'DocType' - Database Table: 'DocType'

Class DocType extends Eloquent
{

	protected $visible = array('id', 'label');
    protected $table='doc_type';

    public function employeedoc()
    {
        return hasMany('EmployeeDoc');
    }
}