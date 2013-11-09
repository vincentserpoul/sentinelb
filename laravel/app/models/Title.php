<?php

// Model:'Status' - Database Table: 'status'

Class Title extends Eloquent
{


    protected $visible = array('id', 'label');
    protected $table='title';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

}