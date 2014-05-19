<?php

class EmployeeRemarkTableSeeder extends Seeder {

      public function run(){

            DB::table('employee_remark')->delete();

            EmployeeRemark::create(
                  array(
                        'employee_id' => 1,
                        'remark' => 'je suis une poule de mer'
                  )
            );

            EmployeeRemark::create(
                  array(
                        'employee_id' => 1,
                        'globalevent_period_id' => 1,
                        'remark' => 'He never came!!',
                  )
            );

            EmployeeRemark::create(
                  array(
                        'employee_id' => 2,
                        'remark' => 'Volontiers'
                  )
            );

    }
}
