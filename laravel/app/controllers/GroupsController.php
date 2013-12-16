<?php

class GroupsController extends \BaseController {

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
                    'groups' => $this->getAllGroups()
                ),
                200
            );    
        } catch (Exception $e){
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Group cannot be returned' . $e
                ),
                500
            );
        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(){
        try{
            if(!is_null(Request::json('name')) && !is_null(Request::json('permissions'))){
                $groupPermissions = array();
                $permissions = Request::json('permissions');
                
                foreach($permissions as $permission){
                    $groupPermissions[$permission['name']] = ($permission['isPermitted']) ? 1 : 0;
                }                

                Sentry::createGroup(array(
                    'name' => Request::json('name'), 
                    'permissions' => $groupPermissions
                ));

                return Response::json(
                    array(
                        'error' => false,
                        'message' => 'Group created',
                        'action' => 'insert',               
                        'groups' => $this->getAllGroups()
                    ),
                    200
                );
            }
        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Group cannot be created' . $e,
                    'action' => 'create'
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
            //find the group using group id
            $group = Sentry::findGroupById($id);

            if(!is_null(Request::json('permissions')) && !is_null(Request::json('name'))){
                $groupPermissions = array();
                $permissions = Request::json('permissions');
                
                foreach($permissions as $permission){
                    $groupPermissions[$permission['name']] = ($permission['isPermitted']) ? 1 : 0;
                }                

                $group->name = Request::json('name');
                $group->permissions = $groupPermissions;
                $group->save();
            }

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Group created',
                    'action' => 'insert',               
                    'groups' => $this->getAllGroups()
                ),
                200
            );

        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Group cannot be updated' . $e,
                    'action' => 'update'
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

            $group = Sentry::findGroupById($id);

            $group->delete();

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Group deleted',
                    'action' => 'delete',
                    'groups' => $this->getAllGroups()
                    ),
                200
            );

        } catch (Exception $e){
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Group cannot be deleted' . $e,
                    'action' => 'delete'
                ),
                500
            );
        }
    }

    /**
    *  @return all groups
    */

    private function getAllGroups(){
        try{
            $Groups = Groups::get();

            $permissions = array();

            foreach($Groups as $group){
                $groupPermissions = Sentry::findGroupById($group->id)->getPermissions();
                $group['permissions'] = $groupPermissions;
                $permissions = array_merge($permissions, Sentry::findGroupById($group->id)->getPermissions());
            }

            foreach($Groups as $group){
                $groupPermissions = $group['permissions'];
                foreach(array_keys($permissions) as $permission){
                    if(isset($groupPermissions[$permission]) && $groupPermissions[$permission]){ 
                        $groupPermissions[$permission] = array(
                            'name' => $permission, 
                            'isPermitted' => true
                        );
                    } else {
                        $groupPermissions[$permission] = array(
                            'name' => $permission, 
                            'isPermitted' => false
                        );
                    }
                }
                $group['permissions'] = $groupPermissions;
            }

            return $Groups->toArray();
        } catch (Exception $e){

        }
    }

}