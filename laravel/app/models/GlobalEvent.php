<?php

// Model:'Event' - Database Table: 'event'

Class Globalevent extends Eloquent
{

    protected $table='globalevent';

    public function employeeremarks()
    {
        return $this->hasMany('Employeeremark');
    }

    public function employerdepartment()
    {
        return $this->hasOne('Employerdepartment');
    }

    public function globalevent_period()
    {
        return $this->hasMany('GlobaleventPeriod');
    }

    public function employeeConflictQueryBuilder(){
        /* get all globaleventperiods related to the globalevent */
        $globaleventPeriods = $this->globalevent_period()->get()->toArray();

        /* init the select that will be added to the employee select */
        $select = array();
        $minDatetime = null;
        $maxDatetime = null;

        /* foreach globaleventperiod, check create the select that will show if there is any conflicting event_period for the employee */
        foreach($globaleventPeriods as $key => $globaleventPeriod){
            /* find the min date */
            $minDatetime > $globaleventPeriod['start_datetime'] ? $minDatetime = $globaleventPeriod['start_datetime']:true;
            /* find the max date */
            $maxDatetime < $globaleventPeriod['end_datetime'] ? $maxDatetime = $globaleventPeriod['end_datetime']:true;
            /* addselects to be added to the employee select to show if there is at least one conflict */
            $select[] = "MAX(IF('".$globaleventPeriod['start_datetime']."' between gp.start_datetime and gp.end_datetime OR '".$globaleventPeriod['end_datetime']."' between gp.start_datetime and gp.end_datetime, gp.id, '')) AS '".$globaleventPeriod['id']."'";
        }

        return array(
                    'select' => $select,
                    'mindatetime' => $minDatetime,
                    'maxdatetime' => $maxDatetime);

    }

}
