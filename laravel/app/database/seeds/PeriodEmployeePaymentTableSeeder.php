<?php

class PeriodEmployeePaymentTableSeeder extends Seeder {

      public function run(){

            DB::table('period_employee_payment')->delete();

            PeriodEmployeePayment::create(
                  array(
                        'globalevent_period_employee_id' => 1,
                        'payment_id' => 1,
                  )
            );

            PeriodEmployeePayment::create(
                  array(
                        'globalevent_period_employee_id' => 4,
                        'payment_id' => 1,
                  )
            );

            PeriodEmployeePayment::create(
                  array(
                        'globalevent_period_employee_id' => 3,
                        'payment_id' => 2,
                  )
            );

      }            
}
