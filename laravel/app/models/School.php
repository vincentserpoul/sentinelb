<?php

// Model:'School' - Database Table: 'school'

Class School extends Eloquent
{


    protected $visible = array('id', 'label');
    protected $table='school';

    public function employee()
    {
        return $this->hasMany('Employee');
    }

}
