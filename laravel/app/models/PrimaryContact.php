<?php

// Model:'Primary Contact' - Database Table: 'client_contact'

Class PrimaryContact extends Eloquent
{
    protected $visible = array('id', 'label');
    protected $table='client_contact';

    public function employee()
    {
        return $this->hasMany('Employee');
    }

}
