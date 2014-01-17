<?php

class GlobaleventTableSeeder extends Seeder {

      public function run(){

            DB::table('globalevent')->delete();

            Globalevent::create(
                  array(
                        'label' => 'Test kitchen',
                        'client_department_id' => 2,
                        'client_id' => 2,
                        'date' => '2013-09-14'
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test Grrom',
                        'client_department_id' => 1,
                        'client_id' => 1,
                        'date' => '2013-09-20'
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test home grooming',
                        'client_department_id' => 3,
                        'client_id' => 3,
                        'date' => '2013-10-23'
                  )
            );

      }
}
