<?php

class GlobaleventTableSeeder extends Seeder {

      public function run(){

            DB::table('globalevent')->delete();

            Globalevent::create(
                  array(
                        'label' => 'Test kitchen',
                        'client_department_id' => 2,
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test Grrom',
                        'client_department_id' => 1,
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test home grooming',
                        'client_department_id' => 3,
                  )
            );

      }
}
