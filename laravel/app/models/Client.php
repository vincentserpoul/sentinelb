<?php

// Model:'Client' - Database Table: 'client'

Class Client extends Eloquent
{

    protected $table='client';

    public function clientcontact()
    {
        return $this->hasMany('Clientcontact');
    }

    public function client_department()
    {
        return $this->hasMany('ClientDepartment');
    }

}
