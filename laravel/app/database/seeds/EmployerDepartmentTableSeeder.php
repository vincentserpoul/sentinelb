<?php

class EmployerDepartmentTableSeeder extends Seeder {

      public function run(){

            DB::table('employer_department')->delete();

            EmployerDepartment::create(
                  array(
                        'employer_id' => 1,
                        'label' => 'Kitchen',
                        'description' => 'All foods',
                        'work_type_id' => 1,
                        'employee_h_rate' => 8.50,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.00,
                        'employer_h_rate_currency_code' => 'SGD'
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 1,
                        'label' => 'American kitchen',
                        'description' => 'All american foods',
                        'work_type_id' => 1,
                        'employee_h_rate' => 8.50,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.00,
                        'employer_h_rate_currency_code' => 'SGD',
                        'parent_id' => 1
                  )
            );


            EmployerDepartment::create(
                  array(
                        'employer_id' => 1,
                        'label' => 'Asian kitchen',
                        'description' => 'All asian foods',
                        'work_type_id' => 1,
                        'employee_h_rate' => 8.50,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.00,
                        'employer_h_rate_currency_code' => 'SGD',
                        'parent_id' => 1
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 1,
                        'label' => 'French kitchen',
                        'description' => 'All french foods',
                        'work_type_id' => 1,
                        'employee_h_rate' => 8.50,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.00,
                        'employer_h_rate_currency_code' => 'SGD',
                        'parent_id' => 1
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 1,
                        'label' => 'Groom',
                        'description' => 'grooms',
                        'work_type_id' => 2,
                        'employee_h_rate' => 8.30,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.40,
                        'employer_h_rate_currency_code' => 'SGD',
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 1,
                        'label' => 'Bedroom Groom',
                        'description' => 'bed grooms',
                        'work_type_id' => 2,
                        'employee_h_rate' => 8.30,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.40,
                        'employer_h_rate_currency_code' => 'SGD',
                        'parent_id' => 5
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 1,
                        'label' => 'Hall Groom',
                        'description' => 'hall grooms',
                        'work_type_id' => 2,
                        'employee_h_rate' => 8.30,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.40,
                        'employer_h_rate_currency_code' => 'SGD',
                        'parent_id' => 5
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 2,
                        'label' => 'Kitchen',
                        'description' => 'kitchen',
                        'work_type_id' => 1,
                        'employee_h_rate' => 8.30,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.40,
                        'employer_h_rate_currency_code' => 'SGD',
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 3,
                        'label' => 'Grooms',
                        'description' => 'grooming',
                        'work_type_id' => 2,
                        'employee_h_rate' => 8.30,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.40,
                        'employer_h_rate_currency_code' => 'SGD',
                  )
            );

            EmployerDepartment::create(
                  array(
                        'employer_id' => 3,
                        'label' => 'Bed Grooms',
                        'description' => 'bewd grooming',
                        'work_type_id' => 2,
                        'employee_h_rate' => 8.30,
                        'employee_h_rate_currency_code' => 'SGD',
                        'employer_h_rate' => 9.40,
                        'employer_h_rate_currency_code' => 'SGD',
                        'parent_id' => 9
                  )
            );
    }
}
