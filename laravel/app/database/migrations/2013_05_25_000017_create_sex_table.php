<?php

use Illuminate\Database\Migrations\Migration;

class CreateSexTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('sex', function($table)
        {
            $table->engine='InnoDB';
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->string('label', 100)->nullable()->default(NULL);
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
        Schema::drop('sex');
    }
}