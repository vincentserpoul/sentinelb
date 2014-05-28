<?php

use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('payment', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->decimal('amount', 30, 2)->unsigned();
            $table->string('currency_code', 3);
            $table->integer('payment_type_id')->nullable()->default(NULL)->unsigned();
            $table->integer('employee_id')->unsigned();;
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
        Schema::drop('payment');
    }
}
