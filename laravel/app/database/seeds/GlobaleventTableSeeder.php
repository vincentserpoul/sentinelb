<?php

class GlobaleventTableSeeder extends Seeder {

      public function run(){

            DB::table('globalevent')->delete();

            Globalevent::create(
                  array(
                        'label' => 'Test kitchen',
                        'client_department_id' => 2,
<<<<<<< HEAD
                        'client_id' => 2,
                        'date' => '2013-09-14',
                        'remark' => 'Kitchen Remark'
=======
>>>>>>> d4249e86c46453c762ffbd6d87c080d0fce62d26
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test Grrom',
                        'client_department_id' => 1,
<<<<<<< HEAD
                        'client_id' => 1,
                        'date' => '2013-09-20',
                        'remark' => 'Groom Remark'
=======
>>>>>>> d4249e86c46453c762ffbd6d87c080d0fce62d26
                  )
            );

            Globalevent::create(
                  array(
                        'label' => 'Test home grooming',
                        'client_department_id' => 3,
<<<<<<< HEAD
                        'client_id' => 3,
                        'date' => '2013-10-23',
                        'remark' => 'Home Grooming Remark'
=======
>>>>>>> d4249e86c46453c762ffbd6d87c080d0fce62d26
                  )
            );

      }
}
