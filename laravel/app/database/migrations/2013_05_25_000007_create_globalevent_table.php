<?php

use Illuminate\Database\Migrations\Migration;

class CreateGlobaleventTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('globalevent', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('label', 200);
            $table->integer('employer_id')->unsigned();
            $table->integer('employer_department_id')->unsigned();
            $table->date('date')->default('0000-00-00');
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
        Schema::drop('Globalevent');
    }
}