<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('employee', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('title_id')->nullable()->default(NULL)->unsigned();
            $table->string('first_name', 50)->default('');
            $table->string('last_name', 50)->default('');
            $table->integer('sex_id')->default('1')->unsigned();
            $table->string('country_code', 3)->default('');
            $table->date('date_of_birth')->default('0000-00-00');
            $table->string('mobile_phone_number', 40)->default('');
            $table->string('school', 50)->default('');
            $table->dateTime('join_date')->nullable()->default(NULL);
            $table->integer('race_id')->nullable()->default(NULL)->unsigned();
            $table->integer('status_id')->default(0)->unsigned();
            $table->integer('work_pass_type_id')->nullable()->default(0)->unsigned();
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
        Schema::drop('employee');
    }
}