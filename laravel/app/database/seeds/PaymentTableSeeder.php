<?php

class PaymentTableSeeder extends Seeder {

      public function run(){

            DB::table('payment')->delete();

            Payment::create(
                  array(
                        'payment_type_id' => 1,
                        'amount' => 10.5,
                        'currency_code' => 'SGD',
                        'employee_id' => 1
                  )
            );

            Payment::create(
                  array(
                        'payment_type_id' => 1,
                        'amount' => 22.4,
                        'currency_code' => 'SGD',
                        'employee_id' => 1
                  )
            );

            Payment::create(
                  array(
                        'payment_type_id' => 2,
                        'amount' => 22.4,
                        'currency_code' => 'SGD',
                        'employee_id' => 2
                  )
            );

    }
}
