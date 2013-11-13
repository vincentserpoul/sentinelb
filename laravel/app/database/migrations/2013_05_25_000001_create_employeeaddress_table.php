<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmployeeaddressTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('employee_address', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('address_line', 100)->default('');
            $table->string('zipcode', 20)->default('');
            $table->string('city', 40)->default('');
            $table->string('country', 3)->default('');
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
        Schema::drop('employee_address');
    }
}