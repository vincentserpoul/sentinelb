<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientdepartmentTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('client_department', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->string('label', 100)->default('');
            $table->string('description', 100)->default('');
            $table->integer('work_type_id')->unsigned();
            $table->decimal('employee_h_rate', 30, 2)->unsigned();
            $table->string('employee_h_rate_currency_code', 3);
            $table->decimal('client_h_rate', 30, 2)->unsigned();
            $table->string('client_h_rate_currency_code', 3);
            $table->integer('parent_id')->nullable()->default(NULL)->unsigned();
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
        Schema::drop('client_department');
    }
}
