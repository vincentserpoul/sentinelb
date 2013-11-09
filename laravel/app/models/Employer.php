<?php

// Model:'Employer' - Database Table: 'employer'

Class Employer extends Eloquent
{

    protected $table='employer';

    public function employercontact()
    {
        return $this->hasMany('Employercontact');
    }

    public function employerdepartment()
    {
        return $this->hasMany('Employerdepartment');
    }

}