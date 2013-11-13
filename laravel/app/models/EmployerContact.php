<?php

// Model:'EmployerContact' - Database Table: 'employer_contact'

Class EmployerContact extends Eloquent
{

    protected $table='employer_contact';

    public function employer()
    {
        return $this->belongsTo('Employer');
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