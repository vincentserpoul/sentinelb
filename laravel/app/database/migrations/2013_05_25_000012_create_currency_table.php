<?php

use Illuminate\Database\Migrations\Migration;

class CreateCurrencyTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('currency', function($table)
        {
            $table->engine='InnoDB';
            $table->string('code', 3);
            $table->primary('code');
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
        Schema::drop('currency');
    }
}