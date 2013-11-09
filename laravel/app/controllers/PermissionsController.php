<?php

class PermissionsController extends \BaseController {

    /**
    * Filter users with enough authorization
    */
    public function __construct(){
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAnyAccess(array('admin'))) return Response::json(
                            array(
                                'error' => true, 
                                'message' => 'Please log in to continue.'
                            ),
                            401
                        );
        });
    }   

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
        
        $Groups = Groups::get();

        $permissions = array();

        foreach($Groups as $group){
            $permissions = array_merge($permissions, Sentry::findGroupById($group->id)->getPermissions());
        }

        return Response::json(
            array(
                'error' => false,
                'permissions' => array_keys($permissions)
            ),
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id){

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){

    }

}