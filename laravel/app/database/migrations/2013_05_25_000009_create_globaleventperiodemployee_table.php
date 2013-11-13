<?php

use Illuminate\Database\Migrations\Migration;

class CreateGlobaleventperiodemployeeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('globalevent_period_employee', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('globalevent_period_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->dateTime('real_start_datetime')->nullable()->default(NULL);
            $table->dateTime('real_end_datetime')->nullable()->default(NULL);
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
        Schema::drop('globalevent_period_employee');
    }
}