<?php

class ModelStaticLabelController extends \BaseController {

    public function show($modelStaticLabel){
        $formattedLabels = array();
        /* default HTTP status cached */
        $httpCode = 200;

        /* trying to get it from the cache first */
        $formattedLabels = Cache::get('modelStaticLabel'.$modelStaticLabel);

        if(empty($formattedLabels)){
            switch($modelStaticLabel){
                case 'employee':
                    // Titles
                    $neededClass = new Title;
                    $formattedLabels['title'] = $neededClass->get()->toArray();

                    // Sexes
                    $neededClass = new Sex;
                    $formattedLabels['sex'] = $neededClass->get()->toArray();

                    // Races
                    $neededClass = new Race;
                    $formattedLabels['race'] = $neededClass->get()->toArray();

                    // Identity doc types
                    $neededClass = new IdentityDocType;
                    $formattedLabels['identity_doc_type'] = $neededClass->get()->toArray();

                    // Identity doc types
                    $neededClass = new DocType;
                    $formattedLabels['doc_type'] = $neededClass->get()->toArray();

                    // Statuses
                    $neededClass = new Status;
                    $formattedLabels['status'] = $neededClass->get()->toArray();

                    // Work pass types
                    $neededClass = new WorkPassType;
                    $formattedLabels['work_pass_type'] = $neededClass->get()->toArray();

                    // Work pass types
                    $neededClass = new School;
                    $formattedLabels['school'] = $neededClass->get()->toArray();

                    break;
                case 'contact':
                    //Titles
                    $neededClass = new Title;
                    $formattedLabels['title'] = $neededClass->get()->toArray();

                    //Sexes
                    $neededClass = new Sex;
                    $formattedLabels['sex'] = $neededClass->get()->toArray();

                    break;
                case 'department':
                    //Work types
                    $neededClass = new WorkType;
                    $formattedLabels['work_type'] = $neededClass->get()->toArray();

                    break;
                case 'globalevent':

                    // Work types
                    $neededClass = new WorkType;
                    $formattedLabels['work_type'] = $neededClass->get()->toArray();

                default:
                    //
                    $formattedLabels = null;

            }

            /* Caching the result and change the httpCode */
            $httpCode = 200;
            Cache::forever('modelStaticLabel'.$modelStaticLabel, $formattedLabels);
        }

        if(empty($formattedLabels)){
            return Response::json(
                array(
                    'error' => "the static labels you required are not available",
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
