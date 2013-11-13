<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmployerdepartmentTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('employer_department', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('employer_id')->unsigned();
            $table->string('label', 100)->default('');
            $table->string('description', 100)->default('');
            $table->integer('work_type_id')->unsigned();
            $table->decimal('employee_hourly_rate', 30, 2)->unsigned();
            $table->string('employee_hourly_rate_currency_code', 3);
            $table->decimal('employer_hourly_rate', 30, 2)->unsigned();
            $table->string('employer_hourly_rate_currency_code', 3);
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
        Schema::drop('employer_department');
    }
}