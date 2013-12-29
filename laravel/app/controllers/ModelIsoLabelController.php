<?php

class ModelIsoLabelController extends \BaseController {

    public function show($modelIsoLabel){
        $formattedLabels = array();
        /* default HTTP status cached */
        $httpCode = 200;

        /* trying to get it from the cache first */
        $formattedLabels = Cache::get('modelIsoLabel'.$modelIsoLabel);

        if(empty($formattedLabels)){
            switch($modelIsoLabel){
                case 'country':
                    // Titles
                    $neededClass = new Country;
                    break;

                case 'currency':
                    // Countries
                    $neededClass = new Currency;
                    break;

                    default:
                        //
                        $neededClass = new stdClass();
            }

            $formattedLabels[$modelIsoLabel] = $neededClass->get()->toArray();

            /* Caching the result and change the httpCode */
            $httpCode = 200;
            Cache::forever('modelIsoLabel'.$modelIsoLabel, $formattedLabels);
        }

        if(empty($formattedLabels)){
            return Response::json(
                array(
                    'error' => "the iso labels you required are not available",
                    'labels' => array()
                ),
                $httpCode
            );
        }

        return Response::json(
            array(
                'error' => false,
                'labels' => $formattedLabels
            ),
            $httpCode
        );

    }

    private function getFormattedLabels($_model){
        $labels = $_model->get();
        $formattedLabels = array();

        foreach($labels->toArray() as $array_label){
            $formattedLabels[$array_label['id']] = $array_label['label'];
        }

        return $formattedLabels;
    }

}
