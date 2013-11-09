<?php

use Illuminate\Database\Migrations\Migration;

class CreateDoctypeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('doc_type', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
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
        Schema::drop('doc_type');
    }
}