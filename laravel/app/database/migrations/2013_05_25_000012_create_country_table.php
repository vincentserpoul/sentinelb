<?php

use Illuminate\Database\Migrations\Migration;

class CreateCountryTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('country', function($table)
        {
            $table->engine='InnoDB';
            $table->string('code', 3);
            $table->primary('code');
            $table->string('label', 50);
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
        Schema::drop('country');
    }
}