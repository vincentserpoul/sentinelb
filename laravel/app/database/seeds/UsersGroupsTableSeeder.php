<?php

class UsersGroupsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users_groups')->delete();

		$userUser = Sentry::getUserProvider()->findByLogin('user@gmail.com');
		$adminUser = Sentry::getUserProvider()->findByLogin('admin@gmail.com');
		$developerUser = Sentry::getUserProvider()->findByLogin('developer@gmail.com');
		$managerUser = Sentry::getUserProvider()->findByLogin('manager@gmail.com');

		$userGroup = Sentry::getGroupProvider()->findByName('Users');
		$adminGroup = Sentry::getGroupProvider()->findByName('Admins');
		$developerGroup = Sentry::getGroupProvider()->findByName('Developers');
		$managerGroup = Sentry::getGroupProvider()->findByName('Managers');

	    // Assign the groups to the users
	    $userUser->addGroup($userGroup);		
	    $adminUser->addGroup($adminGroup);
	    $developerUser->addGroup($developerGroup);
	    $managerUser->addGroup($managerGroup);
	}

}