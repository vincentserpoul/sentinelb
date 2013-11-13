<?php

class ModelIsoLabelController extends \BaseController {

    public function show($modelStaticLabel){
        $formattedLabels = array();
        $neededClass = new Title;

        switch($modelStaticLabel){
            case 'country':
                // Titles
                $neededClass = new Country;
                $formattedLabels['country'] = $neededClass->get()->toArray();

                break;

            case 'currency':

                // Countries
                $neededClass = new Currency;
                $formattedLabels['currency'] = $neededClass->get()->toArray();

                break;

            default:
                //
        }
        
        if(empty($formattedLabels)){
            return Response::json(
                array(
                    'error' => "the iso labels you required are not available",
                    'labels' => array()
                ),
                200
            );
        }

        return Response::json(
            array(
                'error' => false,
                'labels' => $formattedLabels
            ),
            200
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