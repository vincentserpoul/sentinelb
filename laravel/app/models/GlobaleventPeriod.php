<?php

// Model:'EventPeriod' - Database Table: 'event_period'

Class GlobaleventPeriod extends Eloquent
{

    protected $table='globalevent_period';

    public function employeeremark()
    {
        return $this->hasMany('Employeeremark');
    }

    public function eventperiodemployee()
    {
        return $this->hasMany('GlobaleventPeriodEmployee');
    }

    public function globalevent()
    {
        return $this->belongsTo('Globalevent');
    }

    public function employee()
    {
        return $this->belongsToMany('Employee', 'globalevent_period_employee')
                     ->withPivot('real_start_datetime', 'real_end_datetime');
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
            'id'=>null,
            'globalevent_id'=>null
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


    public function listWithDetails($listFilterParams = null){

        $GlobaleventPeriodsList = $this->leftJoin('globalevent_period_employee', 'globalevent_period_employee.globalevent_period_id', '=', 'globalevent_period.id')
                                ->select('globalevent_period.id'
                                    , 'globalevent_period.globalevent_id'
                                    , 'globalevent_period.start_datetime'
                                    , 'globalevent_period.end_datetime'
                                    , 'globalevent_period.number_of_employee_needed'
                                    , DB::raw('SUM(globalevent_period_employee.employee_id IS NOT NULL) as number_of_employee_assigned')
                                    , DB::raw('HOUR(TIMEDIFF(globalevent_period.end_datetime, globalevent_period.start_datetime)) as duration')
                                    )
                                ->groupBy('globalevent_period.id', 'globalevent_period.globalevent_id', 'globalevent_period.start_datetime', 'globalevent_period.end_datetime', 'globalevent_period.number_of_employee_needed')
                                ->orderBy('globalevent_period.id', 'desc');

        if(!is_null($listFilterParams)){
            $GlobaleventPeriodsList = $this->filterList($GlobaleventPeriodsList, $listFilterParams);
        }

        return $GlobaleventPeriodsList;

    }

    /**
     * function employee list
     * @return querybuilder
     */
    protected function filterList($list, $listFilterParams = null)
    {

        /* Init employees list */
        $GlobaleventPeriodsList =  $list;

        /* If there is no filters, return directly the employee list */
        if(is_null($listFilterParams)){
            return $GlobaleventPeriodsList;
        }

        /* We filter out the criterias that are not supposed to be there */
        $searchCriterias = $this->filterAllowedSearchCriterias($listFilterParams);

        /* We get the ids for each of the criterias */
        foreach($searchCriterias as $searchCriteria => $searchValues){
            if($searchCriteria == 'id'){
                $GlobaleventPeriodsList->where('globalevent_period.id', '=', $searchValues);
            } /* globalevent id */
            elseif($searchCriteria == 'globalevent_id'){
                $GlobaleventPeriodsList->where('globalevent_period.globalevent_id', '=', $searchValues);
            } /* if the searchValues is a list of ref ids to filter */
            elseif(is_array($searchValues)){
                $GlobaleventPeriodsList->whereIn($searchCriteria.'_id', $searchValues);
            }
        }

        return $GlobaleventPeriodsList;
    }

}
