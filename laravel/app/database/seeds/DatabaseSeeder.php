<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('GroupsTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('UsersGroupsTableSeeder');

		$this->call('RaceTableSeeder');
		$this->call('StatusTableSeeder');
		$this->call('CurrencyTableSeeder');
		$this->call('CountryTableSeeder');
		$this->call('SexTableSeeder');
		$this->call('TitleTableSeeder');
		$this->call('WorkPassTypeTableSeeder');
		$this->call('WorkTypeTableSeeder');
		$this->call('IdentityDocTypeTableSeeder');
		$this->call('DocTypeTableSeeder');
		$this->call('PaymentTypeTableSeeder');

		$this->call('EmployeeTableSeeder');
		$this->call('EmployeeIdentityDocTableSeeder');
		$this->call('EmployeeDocTableSeeder');

		$this->call('ClientTableSeeder');
		$this->call('ClientContactTableSeeder');
		$this->call('ClientDepartmentTableSeeder');


		$this->call('PaymentTableSeeder');
		$this->call('GlobaleventTableSeeder');
		$this->call('GlobaleventPeriodTableSeeder');
		$this->call('GlobaleventPeriodEmployeeTableSeeder');
		$this->call('EmployeeContactTableSeeder');
		$this->call('EmployeeRemarkTableSeeder');

	}

}
