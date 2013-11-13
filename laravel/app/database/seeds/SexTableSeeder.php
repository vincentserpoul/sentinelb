<?php

class SexTableSeeder extends Seeder {

      public function run(){

            DB::table('sex')->delete();

            Sex::create(
                  array(
                        'id'    => 0,
                        'label' => 'Female'
                  )
            );

            Sex::create(
                  array(
                        'id'    => 1,
                        'label' => 'Male'
                  )
            );

    }
}
