<?php

class IdentityDocTypeTableSeeder extends Seeder {

      public function run(){

            DB::table('identity_doc_type')->delete();

            IdentityDocType::create(
                  array(
                        'label' => 'Singapore IC'
                  )
            );

            IdentityDocType::create(
                  array(
                        'label' => 'Passport'
                  )
            );            

            IdentityDocType::create(
                  array(
                        'label' => 'Singapore employment pass'
                  )
            );

    }
}
