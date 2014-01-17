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
            $table->integer('real_break_duration_s')->nullable()->default(0);
            $table->string('clvno', 20)->nullable()->default(null);
            $table->decimal('employee_h_rate', 30, 2)->nullable()->unsigned();
            $table->string('employee_h_rate_currency_code', 3)->nullable();
            $table->decimal('client_h_rate', 30, 2)->nullable()->unsigned();
            $table->string('client_h_rate_currency_code', 3)->nullable();
            $table->integer('user_id')->nullable()->default('1')->unsigned();
            $table->timestamps();
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
