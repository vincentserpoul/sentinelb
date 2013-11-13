<?php

// Model:'Status' - Database Table: 'status'

Class Currency extends Eloquent
{


    protected $visible = array('code', 'label');
    protected $table='currency';

    public function employer_departement()
    {
        return $this->hasMany('EmployerDepartment');
    }

}