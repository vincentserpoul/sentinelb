<?php

use Illuminate\Database\Migrations\Migration;

class CreateGlobaleventperiodTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('globalevent_period', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('globalevent_id')->unsigned();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->integer('number_of_employee_needed')->default('0');
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
        Schema::drop('globalevent_period');
    }
}