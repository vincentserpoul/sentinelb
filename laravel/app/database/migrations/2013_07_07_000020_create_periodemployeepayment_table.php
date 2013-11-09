<?php

use Illuminate\Database\Migrations\Migration;

class CreatePeriodemployeepaymentTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('period_employee_payment', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('globalevent_period_employee_id')->unsigned();
            $table->integer('payment_id')->unsigned();    
            $table->timestamps();
            $table->integer('user_id')->nullable()->default('1')->unsigned();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('period_employee_payment');
    }
}