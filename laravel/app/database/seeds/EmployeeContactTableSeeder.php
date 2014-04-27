<?php

class EmployeeContactTableSeeder extends Seeder {

      public function run(){

            DB::table('employee_contact')->delete();

            EmployeeContact::create(
                  array(
                        'employee_id' => 1,
                        'title_id' => 1,
                        'first_name' => 'Jean',
                        'last_name' => 'Michel',
                        'sex_id' => 1,
                        'mobile_phone_number' => '+6598745563',
                        'primary_contact' => true
                  )
            );

            EmployeeContact::create(
                  array(
                        'employee_id' => 2,
                        'title_id' => 2,
                        'first_name' => 'Merlu',
                        'last_name' => 'Lampoin',
                        'sex_id' => 0,
                        'mobile_phone_number' => '+6598749876',
                        'primary_contact' => false
                  )
            );

            EmployeeContact::create(
                  array(
                        'employee_id' => 3,
                        'title_id' => 2,
                        'first_name' => 'Pol',
                        'last_name' => 'Polluxc',
                        'sex_id' => 1,
                        'mobile_phone_number' => '+6598749875',
                        'primary_contact' => true
                  )
            );

    }
}
