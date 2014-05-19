<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmployeeremarkTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('employee_remark', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('globalevent_period_id')->nullable()->default(NULL)->unsigned();
            $table->string('remark', 5000)->nullable()->default(NULL);
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
        Schema::drop('employee_remark');
    }
}
