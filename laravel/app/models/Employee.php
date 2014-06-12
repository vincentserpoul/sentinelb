<?php

// Model:'Employee' - Database Table: 'employee'

Class Employee extends Eloquent
{

    protected $hidden = array('user_id', 'created_at', 'updated_at');
    protected $table='employee';

    public function employee_address()
    {
        return $this->hasMany('EmployeeAddress');
    }

    public function employee_identity_doc()
    {
        return $this->hasMany('EmployeeIdentityDoc');
    }

    public function employee_doc()
    {
        return $this->hasMany('EmployeeDoc');
    }

    public function employee_contact()
    {
        return $this->hasMany('EmployeeContact');
    }

    public function employee_remark()
    {
        return $this->hasMany('EmployeeRemark');
    }

    public function globalevent_period_employee()
    {
        return $this->hasMany('GlobaleventPeriodEmployee');
    }

    public function globalevent_period()
    {
        return $this->belongsToMany('GlobaleventPeriod', 'globalevent_period_employee')
                    ->withPivot('real_start_datetime', 'real_end_datetime');
    }

    public function race()
    {
        return $this->belongsTo('Race');
    }

    public function status()
    {
        return $this->belongsTo('Status');
    }

    public function work_pass_type()
    {
        return $this->hasOne('WorkPassType');
    }

    public function sex()
    {
        return $this->hasOne('Sex');
    }

    public function title()
    {
        return $this->hasOne('Title');
    }

    public function country()
    {
        return $this->hasOne('Country');
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
              'work_pass_type'=>null
            , 'race'=>null
            , 'sex'=>null
            , 'school'=>null
            , 'status'=>null
            , 'age_min'=>null
            , 'age_max'=>null
            , 'identity_doc_number'=>null
            , 'last_name'=>null
            , 'mobile_phone_number' => null
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
     * function employee list
     * @return querybuilder
     */
    public function listWithDetails($listFilterParams = null)
    {

        $EmployeesList = $this->select(DB::raw('title.label as title_label')
                                , 'employee.id'
                                , 'employee.first_name'
                                , 'employee.last_name'
                                , DB::raw('TIMESTAMPDIFF(YEAR,date_of_birth,CURDATE()) AS age')
                                , DB::raw('GROUP_CONCAT(DISTINCT(employee_identity_doc.identity_doc_number)) AS identity_doc_number')
                            )
                        ->join('title', 'employee.title_id', '=', 'title.id')
                        ->join('employee_identity_doc', 'employee.id', '=', 'employee_identity_doc.employee_id')
                        ->groupBy('employee.date_of_birth', 'employee.id', 'employee.first_name', 'employee.last_name', 'title.label' );

        if(!is_null($listFilterParams)){
            $EmployeesList = $this->filterList($EmployeesList, $listFilterParams);
        }


        return $EmployeesList;

    }


    /**
     * function employee list
     * @return querybuilder
     */
    protected function filterList($list, $listFilterParams = null)
    {

        /* Init employees list */
        $EmployeesList =  $list;

        /* If there is no filters, return directly the employee list */
        if(is_null($listFilterParams)){
            return $EmployeesList;
        }

        /* We filter out the criterias that are not supposed to be there */
        $searchCriterias = $this->filterAllowedSearchCriterias($listFilterParams);

        /* We get the ids for each of the criterias */
        foreach($searchCriterias as $searchCriteria => $searchValues){
            /* if the searchValues is a list of ref ids to filter */
            if(is_array($searchValues)){
                $EmployeesList->whereIn($searchCriteria.'_id', $searchValues);
            } /* identity_doc */
            elseif($searchCriteria == 'identity_doc_number' && !empty($searchValues) && is_string($searchValues)){
                $EmployeesList->whereRaw('exists (select 1 from employee_identity_doc where employee_identity_doc.employee_id = employee.id and employee_identity_doc.identity_doc_number like ?)', array('%'.$searchValues.'%'));
            } /* age_min */
            elseif($searchCriteria == 'age_min' && is_integer($searchValues)){
                $EmployeesList->whereRaw('TIMESTAMPDIFF(YEAR,date_of_birth,CURDATE()) > ?', array($searchValues));
            } /* age_max */
            elseif($searchCriteria == 'age_max' && is_integer($searchValues)){
                $EmployeesList->whereRaw('TIMESTAMPDIFF(YEAR,date_of_birth,CURDATE()) < ?', array($searchValues));
            } /* if the values is not an integer, then it is a text comparison */
            elseif(is_string($searchValues) && !is_integer($searchValues)){
                $EmployeesList->whereRaw($searchCriteria.' like ?', array(strtolower($searchValues).'%'));
            }
        }

        return $EmployeesList;
    }
}
