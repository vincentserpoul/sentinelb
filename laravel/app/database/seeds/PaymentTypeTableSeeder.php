<?php

class PaymentTypeTableSeeder extends Seeder {

      public function run(){

            DB::table('payment_type')->delete();

            PaymentType::create(
                  array(
                        'label' => 'labour'
                  )
            );

            PaymentType::create(
                  array(
                        'label' => 'others'
                  )
            );
    }
}
