<?php

class TitleTableSeeder extends Seeder {

      public function run(){

            DB::table('title')->delete();

            Title::create(
                  array(
                        'label' => 'Mr'
                  )
            );

            Title::create(
                  array(
                        'label' => 'Mrs'
                  )
            );


            Title::create(
                  array(
                        'label' => 'Miss'
                  )
            );

            Title::create(
                  array(
                        'label' => 'None'
                  )
            );



    }
}
