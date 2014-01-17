<?php

// Model:'Primary Contact' - Database Table: 'client_contact'

Class Sex extends Eloquent
{
    protected $visible = array('id', 'label');
    protected $table='sex';

    public function employee()
    {
        return $this->hasMany('Employee');
    }

}