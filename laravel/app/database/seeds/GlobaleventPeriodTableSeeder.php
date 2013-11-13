<?php

class GlobaleventPeriodTableSeeder extends Seeder {

      public function run(){

            DB::table('globalevent_period')->delete();

            GlobaleventPeriod::create(
                  array(
                        'globalevent_id' => 1,
                        'start_datetime' => '2013-02-01 08:00:00',
                        'end_datetime' => '2013-02-01 10:00:00',
                        'number_of_employee_needed' => 20,
                  )
            );

            GlobaleventPeriod::create(
                  array(
                        'globalevent_id' => 1,
                        'start_datetime' => '2013-02-01 12:00:00',
                        'end_datetime' => '2013-02-01 18:00:00',
                        'number_of_employee_needed' => 20,
                  )
            );

            GlobaleventPeriod::create(
                  array(
                        'globalevent_id' => 1,
                        'start_datetime' => '2013-02-03 08:00:00',
                        'end_datetime' => '2013-02-03 10:00:00',
                        'number_of_employee_needed' => 5,
                  )
            );



            GlobaleventPeriod::create(
                  array(
                        'globalevent_id' => 2,
                        'start_datetime' => '2013-03-01 08:00:00',
                        'end_datetime' => '2013-03-01 10:00:00',
                        'number_of_employee_needed' => 5,
                  )
            );

            GlobaleventPeriod::create(
                  array(
                        'globalevent_id' => 2,
                        'start_datetime' => '2013-04-03 12:00:00',
                        'end_datetime' => '2013-04-03 18:00:00',
                        'number_of_employee_needed' => 5,
                  )
            );



            GlobaleventPeriod::create(
                  array(
                        'globalevent_id' => 3,
                        'start_datetime' => '2013-05-01 08:00:00',
                        'end_datetime' => '2013-05-01 10:00:00',
                        'number_of_employee_needed' => 250,
                  )
            );

            GlobaleventPeriod::create(
                  array(
                        'globalevent_id' => 3,
                        'start_datetime' => '2013-06-03 12:00:00',
                        'end_datetime' => '2013-06-03 18:00:00',
                        'number_of_employee_needed' => 1500,
                  )
            );

      }
}
