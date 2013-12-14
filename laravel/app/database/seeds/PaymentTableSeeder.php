<?php

class PaymentTableSeeder extends Seeder {

      public function run(){

            DB::table('payment')->delete();

            Payment::create(
                  array(
                        'extra_amount' => 10.5,
                        'currency_code' => 'SGD'
                  )
            );

            Payment::create(
                  array(
                        'extra_amount' => 22.4,
                        'currency_code' => 'SGD'
                  )
            );

    }
}
