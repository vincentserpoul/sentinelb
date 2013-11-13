<?php

class RaceTableSeeder extends Seeder {

      public function run(){

            DB::table('race')->delete();

            Race::create(
                  array(
                        'label' => 'Caucasian'
                  )
            );

            Race::create(
                  array(
                        'label' => 'Indian'
                  )
            );

            Race::create(
                  array(
                        'label' => 'Chinese'
                  )
            );

    }
}
