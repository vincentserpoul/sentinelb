<?php

class EmployeeIdentityDocTableSeeder extends Seeder {

      public function run(){

            DB::table('employee_identity_doc')->delete();

            EmployeeIdentityDoc::create(
                  array(
                        'employee_id' => 1,
                        'identity_doc_type_id' => 1,
                        'identity_doc_number' => 'GFRE1234',
                        'identity_doc_validity_start' => '2012-06-01',
                        'identity_doc_validity_end' => '2015-06-01',
                  )
            );

            EmployeeIdentityDoc::create(
                  array(
                        'employee_id' => 2,
                        'identity_doc_type_id' => 1,
                        'identity_doc_number' => 'GFRE12WW4',
                        'identity_doc_validity_start' => '2012-06-01',
                        'identity_doc_validity_end' => '2015-06-01',
                  )
            );            

            EmployeeIdentityDoc::create(
                  array(
                        'employee_id' => 3,
                        'identity_doc_type_id' => 1,
                        'identity_doc_number' => 'GFRE14234',
                        'identity_doc_validity_start' => '2012-06-01',
                        'identity_doc_validity_end' => '2015-06-01',
                  )
            );

    }
}
