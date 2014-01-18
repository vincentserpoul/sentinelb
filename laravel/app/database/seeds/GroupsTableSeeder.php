<?php

class GroupsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('groups')->delete();

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'developers',
	        'permissions' => array(
	        	'user' => 1, 
	        	'add_client_contact' => 1, 
	        	'admin' => 1
	        )));

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'users',
	        'permissions' => array(
	            'user' => 1, 
	        	'add_client_contact' => 0,
	        	'admin' => 0
	        )));

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'admins',
	        'permissions' => array(
	            'user' => 1, 
	        	'add_client_contact' => 1, 
	        	'admin' => 1
	        )));

		Sentry::getGroupProvider()->create(array(
	        'name'        => 'managers',
	        'permissions' => array(
	            'user' => 1, 
	        	'add_client_contact' => 1,
	        	'admin' => 1
	        )));
	}

}