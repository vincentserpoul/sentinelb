<?php

class DocTypeTableSeeder extends Seeder {

      public function run(){

            DB::table('doc_type')->delete();

            DocType::create(
                  array(
                        'label' => 'Agreement'
                  )
            );
    }
}
