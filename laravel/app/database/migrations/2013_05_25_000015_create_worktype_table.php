<?php

use Illuminate\Database\Migrations\Migration;

class CreateWorktypeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('work_type', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
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
        Schema::drop('work_type');
    }
}