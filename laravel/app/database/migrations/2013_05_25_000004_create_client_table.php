<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('client', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('address', 150)->default('');
            $table->string('city', 150)->default('');
            $table->string('postcode', 20)->default('');
            $table->string('country_code', 3);
            $table->string('phone_number', 20)->default('');
            $table->string('fax_number', 20)->default('');
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
        Schema::drop('client');
    }
}