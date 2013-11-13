<?php

class WorkTypeTableSeeder extends Seeder {

      public function run(){

            DB::table('work_type')->delete();

            WorkType::create(
                  array(
                        'label' => 'Kitchen'
                  )
            );

            WorkType::create(
                  array(
                        'label' => 'Groom'
                  )
            );

    }
}
