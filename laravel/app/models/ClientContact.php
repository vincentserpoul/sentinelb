<?php

// Model:'ClientContact' - Database Table: 'client_contact'

Class ClientContact extends Eloquent
{

    protected $table='client_contact';

    public function client()
    {
        return $this->belongsTo('Client');
    }

    public function title()
    {
        return $this->belongsTo('Title');
    }

    public function sex()
    {
        return $this->belongsTo('Sex');
    }
}