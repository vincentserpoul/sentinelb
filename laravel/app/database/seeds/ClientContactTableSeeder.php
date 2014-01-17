<?php

class ClientContactTableSeeder extends Seeder {

      public function run(){

            DB::table('client_contact')->delete();

            ClientContact::create(
                  array(
                        'client_id' => 1,
                        'title_id' => 1,
                        'first_name' => 'Jean',
                        'last_name' => 'Michel',
                        'sex_id' => 1,
                        'mobile_phone_number' => '+6598745563',
                        'primary_contact' => true
                  )
            );

            ClientContact::create(
                  array(
                        'client_id' => 1,
                        'title_id' => 2,
                        'first_name' => 'Merlu',
                        'last_name' => 'Lampoin',
                        'sex_id' => 0,
                        'mobile_phone_number' => '+6598749876',
                        'primary_contact' => false
                  )
            );

            ClientContact::create(
                  array(
                        'client_id' => 2,
                        'title_id' => 2,
                        'first_name' => 'Pol',
                        'last_name' => 'Polluxc',
                        'sex_id' => 1,
                        'mobile_phone_number' => '+6598749875',
                        'primary_contact' => true
                  )
            );

    }
}
