<?php

class UsersTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		Sentry::getUserProvider()->create(array(
	        'email'    => 'admin@gmail.com',
	        'password' => 'password12',
	        'activated' => 1,
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'user@gmail.com',
	        'password' => 'password12',
	        'activated' => 1,
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'developer@gmail.com',
	        'password' => 'password12',
	        'activated' => 1,
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'manager@gmail.com',
	        'password' => 'password12',
	        'activated' => 1,
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'newuser@gmail.com',
	        'password' => 'password12',
	        'activated' => 1,
	    ));
	}

}