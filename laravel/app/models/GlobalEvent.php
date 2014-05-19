<?php

// Model:'Event' - Database Table: 'event'

Class Globalevent extends Eloquent
{

    protected $table='globalevent';

    public function employeeremark()
    {
        return $this->hasMany('Employeeremark');
    }

    public function clientdepartment()
    {
        return $this->hasOne('Clientdepartment');
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

        /* foreach globaleventperiod, create the select that will check if there is any conflicting event_period for the employee */
        foreach($globaleventPeriods as $key => $globaleventPeriod){
            /* find the min date */
            ($minDatetime > $globaleventPeriod['start_datetime'] || is_null($minDatetime) )? $minDatetime = $globaleventPeriod['start_datetime']:true;
            /* find the max date */
            ($maxDatetime < $globaleventPeriod['end_datetime'] || is_null($maxDatetime) ) ? $maxDatetime = $globaleventPeriod['end_datetime']:true;
            /* addselects to be added to the employee select to show if there is at least one conflict */
            $select[] = "MAX(IF('".$globaleventPeriod['start_datetime']."' between gp.start_datetime and gp.end_datetime OR '".$globaleventPeriod['end_datetime']."' between gp.start_datetime and gp.end_datetime, gp.id, '')) AS '".$globaleventPeriod['id']."'";
        }

        return array(
                    'select' => $select,
                    'mindatetime' => $minDatetime,
                    'maxdatetime' => $maxDatetime
                );

    }

    /**
     * Filters the list of search criterias
     *
     * @param  search criterias
     * @return search criterias
     */
    public function filterAllowedSearchCriterias($searchCriterias){
        /* if parameter not an array */
        if(!is_array($searchCriterias)){
            return false;
        }

        /* List of searchable criterias */
        $allowedCriterias = array(
            'id'=>null
        );

        $newSearchCriteria = array();

        /* First step, make sure the params are an associative array like that:
         * array('sex'=>array(0, 1)), 'age_min' => 12);
         */
        foreach($searchCriterias as $key=>$value){
            /* If it is an array and it contains the id we wanna search for, we need to push it inside a new array */
            if(is_array($value)){
                /* then we are in the case of a list of tuple returned by angular */
                foreach($value as $tuple){
                    if(array_key_exists('id', $tuple)){
                        $newSearchCriterias[$key][] = $tuple['id'];
                    }
                }
            } else {
                $newSearchCriterias[$key] = $value;
            }
        }

        return array_intersect_key($newSearchCriterias, $allowedCriterias);
    }

    /**
     * function events list
     * @return querybuilder
     */
    public function listWithDetails($listFilterParams = null)
    {

        $GlobaleventsList = $this->select(DB::raw('client.name as client_name')
                                , DB::raw('client_department.label as client_department_label')
                                , 'globalevent.id'
                                , 'globalevent.label'
                                , DB::raw('MIN(globalevent_period.start_datetime) AS start_datetime')
                                , DB::raw('MAX(globalevent_period.start_datetime) AS end_datetime')
                            )
                        ->join('client_department', 'client_department.id', '=', 'globalevent.client_department_id')
                        ->join('client', 'client.id', '=', 'client_department.client_id')
                        ->leftJoin('globalevent_period', 'globalevent_period.globalevent_id', '=', 'globalevent.id')
                        ->groupBy('client.name', 'client_department.label', 'globalevent.id', 'globalevent.label')
                        ->orderBy('id', 'desc');

        if(!is_null($listFilterParams)){
            $GlobaleventsList = $this->filterList($GlobaleventsList, $listFilterParams);
        }

        return $GlobaleventsList;

    }


    /**
     * function employee list
     * @return querybuilder
     */
    protected function filterList($list, $listFilterParams = null)
    {

        /* Init employees list */
        $GlobaleventsList =  $list;

        /* If there is no filters, return directly the employee list */
        if(is_null($listFilterParams)){
            return $GlobaleventsList;
        }

        /* We filter out the criterias that are not supposed to be there */
        $searchCriterias = $this->filterAllowedSearchCriterias($listFilterParams);

        /* We get the ids for each of the criterias */
        foreach($searchCriterias as $searchCriteria => $searchValues){
            if($searchCriteria == 'id'){
                $GlobaleventsList->where('globalevent.id', '=', $searchValues);
            } /* if the searchValues is a list of ref ids to filter */
            elseif(is_array($searchValues)){
                $GlobaleventsList->whereIn($searchCriteria.'_id', $searchValues);
            }
        }

        return $GlobaleventsList;
    }

}
