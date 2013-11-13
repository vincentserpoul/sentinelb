<?php

// Model:'Race' - Database Table: 'race'

Class Race extends Eloquent
{

    protected $visible = array('id', 'label');
    protected $table='race';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

}