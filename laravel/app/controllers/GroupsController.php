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
            if(!is_null(Request::json('name')) && !is_null(Request::json('group_permissions'))){
                $groupPermissions = array();
                $permissions = Request::json('group_permissions');
                
                foreach($permissions as $permission){
                    $groupPermissions[$permission['name']] = ($permission['isPermitted']) ? 1 : 0;
                }                

                $group = Sentry::createGroup(array(
                    'name' => Request::json('name'), 
                    'permissions' => $groupPermissions
                ));

                $this->setGroupPermissions($group, null);

                return Response::json(
                    array(
                        'error' => false,
                        'message' => 'Group created',
                        'action' => 'insert',               
                        'group' => $group->toArray()
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

            if(!is_null(Request::json('group_permissions')) && !is_null(Request::json('name'))){
                $groupPermissions = array();
                $permissions = Request::json('group_permissions');
                
                foreach($permissions as $permission){
                    $groupPermissions[$permission['name']] = ($permission['isPermitted']) ? 1 : 0;
                }                

                $group->name = Request::json('name');
                $group->permissions = $groupPermissions;
                $group->save();

                $this->setGroupPermissions($group, null);
            }

            return Response::json(
                array(
                    'error' => false,
                    'message' => 'Group updated',
                    'action' => 'insert',               
                    'group' => $group->toArray()
                ),
                200
            );

        } catch (Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'message' => 'Group cannot be updated. ' . $e->getMessage(),
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
    private function getAllGroups() {
        $groups = Groups::get();
        $permissions = array();
        foreach ($groups as $group) {
            $permissions = array_merge($permissions, (array)json_decode($group->permissions));
        }
        for ($i = 0; $i < count($groups); $i++)
            $this->setGroupPermissions($groups[$i], $permissions);  
        return $groups->toArray();
    }

    private function setGroupPermissions($Group, $permissions) {
        if (is_null($permissions)) {
            $groups = Groups::get();
            $permissions = array();
            foreach ($groups as $group) {
                $permissions = array_merge($permissions, (array)json_decode($group->permissions));
            }
        }
        if (gettype($Group->permissions) !== 'array')
            $groupPermissions = (array)json_decode($Group->permissions);
        else 
            $groupPermissions = $Group->permissions;
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
        $Group['group_permissions'] = $groupPermissions;
    }
}