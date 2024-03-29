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
            
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Users cannot be returned"
                ),
                500
            );
        }
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

            if (!is_null(Request::json('groups'))) {

                $groups = $user->getGroups();

                foreach ($groups as $group) {
                    $user->removeGroup(Sentry::findGroupById($group->id));
                }

                foreach (Request::json('groups') as $assigned_group_id) {
                    $user->addGroup(Sentry::findGroupById($assigned_group_id));
                }
            }

            function getId ($a) {
                return $a['id'];
            }
         
            return Response::json(
                array(
                    'error' => false,
                    'message' => 'User updated',
                    'action' => 'update',
                    'user' => $this->getUser($id)
                ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "Users cannot be updated"
                ),
                500
            );
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
                    'message' => 'User deleted',
                    'action' => 'delete', 
                    'users' => $this->getAllUsers()
                    ),
                200
            );
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => "User cannot be deleted. " . $e->getMessage()
                ),
                500
            );
        }
    }

    /**
    *   @return all users
    */    
    private function getAllUsers() {
        $Users = Sentry::findAllUsers();

        $returnedUsers = array();

        function getId ($a) {
            return $a['id'];
        }

        foreach ($Users as $user) {
            $returnedUsers[] = $this->getUser($user->id);
        }

        return $returnedUsers;
    }

    private function getUser($id) {
        $user = Sentry::findUserById($id);

        $returnedUser = array(
            'id' => $user->id,
            'email' => $user->email,
            'activated' => $user->activated,
            'groups' => array_map('getId', $user->getGroups()->toArray())
        );

        return $returnedUser;
    }
}