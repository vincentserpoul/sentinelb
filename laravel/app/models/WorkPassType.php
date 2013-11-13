<?php

// Model:'WorkPassType' - Database Table: 'work_pass_type'

Class WorkPassType extends Eloquent
{

    protected $visible = array('id', 'label');
    protected $table='work_pass_type';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

}