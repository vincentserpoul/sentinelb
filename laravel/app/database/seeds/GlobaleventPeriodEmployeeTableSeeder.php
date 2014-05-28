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
                        'real_break_duration_s' => '3600',
                        'clvno' => 'HYRFDEYTH',
                        'employee_h_rate' => '10.6',
                        'employee_h_rate_currency_code' => 'SGD',
                        'client_h_rate' => '11.6',
                        'client_h_rate_currency_code' => 'SGD',
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
                        'real_break_duration_s' => '3500',
                        'clvno' => 'HYRFDEYWWTH',
                  )
            );



            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 4,
                        'employee_id' => 1,
                        'real_start_datetime' => '2013-03-01 08:00:00',
                        'real_end_datetime' => '2013-03-01 10:00:00',
                        'real_break_duration_s' => '3600',
                        'clvno' => 'HYRFDEYTHDD',
                  )
            );

            GlobaleventPeriodEmployee::create(
                  array(
                        'globalevent_period_id' => 4,
                        'employee_id' => 2,
                        'real_start_datetime' => '2013-03-01 08:00:00',
                        'real_end_datetime' => '2013-03-01 10:00:00',
                        'real_break_duration_s' => '3200',
                        'clvno' => 'HYRFDEYTWRH',
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
