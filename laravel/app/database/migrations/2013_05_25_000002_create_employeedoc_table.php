<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmployeedocTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('employee_doc', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('doc_type_id')->nullable()->default(NULL)->unsigned();
            $table->string('image_name', 100)->nullable()->default(NULL);
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
        Schema::drop('employee_doc');
    }
}
