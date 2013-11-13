<?php

// Model:'Status' - Database Table: 'status'

Class Sex extends Eloquent
{


    protected $visible = array('id', 'label');
    protected $table='sex';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

}