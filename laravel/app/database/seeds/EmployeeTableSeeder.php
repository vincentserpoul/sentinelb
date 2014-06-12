<?php

class EmployeeTableSeeder extends Seeder {

      public function run(){

            DB::table('employee')->delete();

            Employee::create(
                  array(
                        'title_id' => 1,
                        'first_name' => 'Gokul',
                        'last_name' => 'Jeyo',
                        'sex_id' => 1,
                        'country_code' => 'IND',
                        'date_of_birth' => '1980-01-01',
                        'mobile_phone_number' => '+6599999999',
                        'school_id' => 2,
                        'join_date' => '2012-02-03',
                        'race_id' => 2,
                        'status_id' => 1,
                        'work_pass_type_id' => 2
                  )
            );

            Employee::create(
                  array(
                        'title_id' => 3,
                        'first_name' => 'Jessi',
                        'last_name' => 'Troland',
                        'sex_id' => 1,
                        'country_code' => 'CHN',
                        'date_of_birth' => '1978-12-24',
                        'mobile_phone_number' => '+6598999999',
                        'school_id' => 3,
                        'join_date' => '2012-02-01',
                        'race_id' => 3,
                        'status_id' => 1,
                        'work_pass_type_id' => 1
                  )
            );

            Employee::create(
                  array(
                        'title_id' => 1,
                        'first_name' => 'Fred',
                        'last_name' => 'Lornac',
                        'sex_id' => 1,
                        'country_code' => 'FRA',
                        'date_of_birth' => '1979-08-08',
                        'mobile_phone_number' => '+3365986598',
                        'school_id' => 2,
                        'join_date' => '2012-02-03',
                        'race_id' => 1,
                        'status_id' => 1,
                        'work_pass_type_id' => 1
                  )
            );

    }
}
