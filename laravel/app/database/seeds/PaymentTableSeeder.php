<?php

class PaymentTableSeeder extends Seeder {

      public function run(){

            DB::table('payment')->delete();

            Payment::create(
                  array(
                        'amount' => 10.5,
                        'currency_code' => 'SGD'
                  )
            );

            Payment::create(
                  array(
                        'amount' => 22.4,
                        'currency_code' => 'SGD'
                  )
            );          

    }
}
