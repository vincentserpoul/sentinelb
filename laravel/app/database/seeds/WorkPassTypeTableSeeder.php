<?php

class WorkPassTypeTableSeeder extends Seeder {

      public function run(){

            DB::table('work_pass_type')->delete();

            WorkPassType::create(
                  array(
                        'label' => 'EP1'
                  )
            );

            WorkPassType::create(
                  array(
                        'label' => 'EP2'
                  )
            );            

            WorkPassType::create(
                  array(
                        'label' => 'S-Pass'
                  )
            );

    }
}
