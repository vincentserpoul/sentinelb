<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmployeeremarksTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('employee_remarks', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('globalevent_period_id')->nullable()->default(NULL)->unsigned();
            $table->string('remark', 1000)->nullable()->default(NULL);
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
        Schema::drop('employee_remarks');
    }
}