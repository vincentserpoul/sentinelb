<?php

class GlobaleventTableSeeder extends Seeder {

      public function run(){

            DB::table('globalevent')->delete();

            Globalevent::create(
                  array(
                        'label' => 'Test kitchen',
                        'employer_department_id' => 2,
                        'employer_id' => 2,
                        'date' => '2013-09-14'
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test Grrom',
                        'employer_department_id' => 1,
                        'employer_id' => 1,
                        'date' => '2013-09-20'
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test home grooming',
                        'employer_department_id' => 3,
                        'employer_id' => 3,
                        'date' => '2013-10-23'
                  )
            );

      }
}
