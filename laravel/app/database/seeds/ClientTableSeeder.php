<?php

class ClientTableSeeder extends Seeder {

      public function run(){

            DB::table('client')->delete();

            Client::create(
                  array(
                        'name' => 'MBS', 
                        'address' => '1 marina parade',
                        'city' => 'Singapore',
                        'postcode' => '159960',
                        'country_code' => 'SGP',
                        'phone_number' => '+6593412294',
                  )
            );

            Client::create(
                  array(
                        'name' => 'Mandarin Oriental', 
                        'address' => '1 mandarine parade',
                        'city' => 'Singapore',
                        'postcode' => '154789',
                        'country_code' => 'SGP',
                        'phone_number' => '+6593415568',
                  )
            );

            Client::create(
                  array(
                        'name' => 'Hilton', 
                        'address' => '1 orchard road',
                        'city' => 'Singapore',
                        'postcode' => '458963',
                        'country_code' => 'SGP',
                        'phone_number' => '+6565449875',
                  )
            );

    }
}
