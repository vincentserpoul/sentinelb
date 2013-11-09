<?php

class EmployeeDocTableSeeder extends Seeder {

      public function run(){

            DB::table('employee_doc')->delete();

            EmployeeDoc::create(
                  array(
                        'employee_id' => 1,
                        'doc_type_id' => 1,
                  )
            );

            EmployeeDoc::create(
                  array(
                        'employee_id' => 2,
                        'doc_type_id' => 1,
                  )
            );            

            EmployeeDoc::create(
                  array(
                        'employee_id' => 3,
                        'doc_type_id' => 1,
                  )
            );

    }
}
