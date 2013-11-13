<?php

class UsersController extends \BaseController {

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

        try{            

            return Response::json(
                array(
                    'error' => false,
                    'users' => $this->getAllUsers()
                ),
                200
            );

        } catch (Exception $e) {

        }
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

        try{
            $user = Sentry::findUserById($id);

            $groups = $user->getGroups();

            if(!is_null(Request::json('group'))){
                $assignedGroupId = Request::json('group')['id'];

                $user->addGroup(Sentry::findGroupById($assignedGroupId));

                foreach($groups as $group){
                    if($assignedGroupId !== $group->id){
                        $user->removeGroup(Sentry::findGroupById($group->id));
                    }
                }
            }
            
            $user['group_id'] = UsersGroups::where('user_id', $user->id)->pluck('group_id');
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'User updated',
                    'action' => 'update',
                    'users' => $this->getAllUsers()
                ),
                200
            );
        } catch (Exception $e) {

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){
        try{
            $user = Sentry::findUserById($id);

            $user->delete();
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Users deleted',
                    'action' => 'delete', 
                    'users' => $this->getAllUsers()
                    ),
                200
            );
        } catch (Exception $e) {

        }
    }

    /**
    *   @return all users
    */    
    private function getAllUsers(){
        try{
            $Users = Users::get();

            foreach($Users as $user){
                $user['group_id'] = UsersGroups::where('user_id', $user->id)->pluck('group_id');
            }

            return $Users->toArray();
        } catch (Exception $e){

        }
    }
}