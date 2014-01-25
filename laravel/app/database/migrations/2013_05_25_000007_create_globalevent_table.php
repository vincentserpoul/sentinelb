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
            $table->integer('client_id')->unsigned();
            $table->integer('client_department_id')->unsigned();
            $table->date('date')->default('0000-00-00');
            $table->timestamps();
            $table->string('remark', 250);
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