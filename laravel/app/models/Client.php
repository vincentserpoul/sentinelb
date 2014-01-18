<?php

// Model:'Client' - Database Table: 'client'

Class Client extends Eloquent
{

    protected $table='client';

    public function clientcontact()
    {
        return $this->hasMany('Clientcontact');
    }

    public function clientdepartment()
    {
        return $this->hasMany('Clientdepartment');
    }

}