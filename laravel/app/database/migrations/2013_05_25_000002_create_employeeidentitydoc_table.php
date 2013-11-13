<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmployeeidentitydocTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('employee_identity_doc', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('identity_doc_type_id')->nullable()->default(NULL)->unsigned();
            $table->string('identity_doc_number', 100)->nullable()->default(NULL);
            $table->date('identity_doc_validity_start')->nullable()->default(NULL);
            $table->date('identity_doc_validity_end')->nullable()->default(NULL);
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
        Schema::drop('employee_identity_doc');
    }
}