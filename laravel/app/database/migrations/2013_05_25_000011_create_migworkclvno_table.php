<?php

use Illuminate\Database\Migrations\Migration;

class CreateMigworkclvnoTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('mig_work_clvno', function($table)
        {
            $table->engine='InnoDB';
            $table->integer('work_id')->unsigned();
            $table->increments('clvno')->unsigned();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('mig_work_clvno');
    }
}