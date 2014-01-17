<?php

// Model:'WorkType' - Database Table: 'work_type'

Class WorkType extends Eloquent
{

    protected $table='work_type';

    public function clientdepartment()
    {
        return $this->belongsTo('Clientdepartment');
    }

}