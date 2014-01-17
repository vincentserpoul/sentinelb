<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientcontactTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('client_contact', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('title_id')->nullable()->default(NULL)->unsigned();
            $table->string('first_name', 50)->default('');
            $table->string('last_name', 50)->default('');
            $table->integer('sex_id')->default('1')->unsigned();
            $table->string('mobile_phone_number', 40)->default('');
            $table->boolean('primary_contact')->default(false);
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
        Schema::drop('client_contact');
    }
}