<?php

class StatusTableSeeder extends Seeder {

      public function run(){

            DB::table('status')->delete();

            Status::create(
                  array(
                        'label' => 'Active'
                  )
            );

            Status::create(
                  array(
                        'label' => 'Inactive'
                  )
            );

            Status::create(
                  array(
                        'label' => 'Banned'
                  )
            );


    }
}
