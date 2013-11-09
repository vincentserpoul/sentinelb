<?php

// Model:'Status' - Database Table: 'status'

Class Country extends Eloquent
{


    protected $visible = array('code', 'label');
    protected $table='country';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

}