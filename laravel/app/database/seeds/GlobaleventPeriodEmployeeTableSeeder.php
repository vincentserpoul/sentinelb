<?php

class GlobaleventPeriodEmployeeTableSeeder extends Seeder {

      public function run(){

            DB::table('globalevent_period_employee')->delete();

            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 1,
                        'employee_id' => 1,
                        'real_start_datetime' => '2013-02-01 08:04:00',
                        'real_end_datetime' => '2013-02-01 10:08:00',
                  )
            );

            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 1,
                        'employee_id' => 2,
                        'real_start_datetime' => null,
                        'real_end_datetime' => null,
                  )
            );

            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 1,
                        'employee_id' => 3,
                        'real_start_datetime' => '2013-02-01 08:03:00',
                        'real_end_datetime' => '2013-02-01 10:30:00',
                  )
            );



            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 4,
                        'employee_id' => 1,
                        'real_start_datetime' => '2013-03-01 08:00:00',
                        'real_end_datetime' => '2013-03-01 10:00:00',
                  )
            );

            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 4,
                        'employee_id' => 2,
                        'real_start_datetime' => '2013-03-01 08:00:00',
                        'real_end_datetime' => '2013-03-01 10:00:00',
                  )
            );

            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 4,
                        'employee_id' => 3,
                        'real_start_datetime' => null,
                        'real_end_datetime' => null,
                  )
            );

      }
}
