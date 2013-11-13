<?php

// Model:'Status' - Database Table: 'status'

Class Status extends Eloquent
{


    protected $visible = array('id', 'label');
    protected $table='status';

    public function employee()
    {
        return $this->hasMany('Employee');
    }

}