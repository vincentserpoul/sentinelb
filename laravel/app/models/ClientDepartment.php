<?php

// Model:'ClientDepartment' - Database Table: 'client_department'

Class ClientDepartment extends Eloquent
{

    protected $table='client_department';

    public function event()
    {
        return $this->hasOne('Event');
    }

    public function client()
    {
        return $this->hasOne('Client');
    }

    public function worktype()
    {
        return $this->hasMany('Worktype');
    }

    public function currency()
    {
        return $this->belongsTo('Currency');
    }
}