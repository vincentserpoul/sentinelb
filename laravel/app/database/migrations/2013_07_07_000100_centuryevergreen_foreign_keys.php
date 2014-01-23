<?php

class CenturyevergreenForeignKeys
{
    /**
    * Make changes to the database.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('employee', function($table)
        {
            // Foreign Keys for table 'employee'
            $table->foreign('title_id')->references('id')->on('title');
            $table->foreign('sex_id')->references('id')->on('sex');
            $table->foreign('country_code')->references('code')->on('country');
            $table->foreign('race_id')->references('id')->on('race');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('work_pass_type_id')->references('id')->on('work_pass_type');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('employee_address', function($table)
        {
            // Foreign Keys for table 'employee_address'

            $table->foreign('employee_id')->references('id')->on('employee');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('employee_identity_doc', function($table)
        {
            // Foreign Keys for table 'employee_identity_doc'

            $table->foreign('employee_id')->references('id')->on('employee');
            $table->foreign('identity_doc_type_id')->references('id')->on('identity_doc_type');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('employee_remarks', function($table)
        {
            // Foreign Keys for table 'employee_remarks'

            $table->foreign('employee_id')->references('id')->on('employee');
            $table->foreign('globalevent_period_id')->references('id')->on('globalevent_period');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('client', function($table)
        {
            // Foreign Keys for table 'client_contact'
            $table->foreign('country_code')->references('code')->on('country');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('client_contact', function($table)
        {
            // Foreign Keys for table 'client_contact'

            $table->foreign('client_id')->references('id')->on('client');
            $table->foreign('title_id')->references('id')->on('title');
            $table->foreign('sex_id')->references('id')->on('sex');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('client_department', function($table)
        {
            // Foreign Keys for table 'client_department'

            $table->foreign('client_id')->references('id')->on('client');
            $table->foreign('work_type_id')->references('id')->on('work_type');
            $table->foreign('parent_id')->references('id')->on('client_department');
            $table->foreign('employee_h_rate_currency_code')->references('code')->on('currency');
            $table->foreign('client_h_rate_currency_code')->references('code')->on('currency');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('globalevent', function($table)
        {
            // Foreign Keys for table 'event'

            $table->foreign('client_department_id')->references('id')->on('client_department');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('globalevent_period', function($table)
        {
            // Foreign Keys for table 'event_period'

            $table->foreign('globalevent_id')->references('id')->on('globalevent');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('globalevent_period_employee', function($table)
        {
            // Foreign Keys for table 'event_period_employee'

            $table->foreign('globalevent_period_id')->references('id')->on('globalevent_period');
            $table->foreign('employee_id')->references('id')->on('employee');
            $table->foreign('employee_h_rate_currency_code', 'gpe_employee_h_rate_currency_code_foreign')->references('code')->on('currency');
            $table->foreign('client_h_rate_currency_code', 'gpe_client_h_rate_currency_code_foreign')->references('code')->on('currency');
            $table->unique('clvno');
            $table->unique(array('employee_id', 'globalevent_period_id'), 'unik_employee_per_geventperiod');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('period_employee_payment', function($table)
        {
            // Foreign Keys for table 'event_period_employee'

            $table->foreign('globalevent_period_employee_id')->references('id')->on('globalevent_period_employee');
            $table->unique('globalevent_period_employee_id');
            $table->foreign('payment_id')->references('id')->on('payment');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
    * Revert the changes to the database.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('employee', function($table)
        {
            // Drop Foreign Keys for table 'employee'
            $table->dropForeign('employee_title_id_foreign');
            $table->dropForeign('employee_sex_id_foreign');
            $table->dropForeign('employee_country_code_foreign');
            $table->dropForeign('employee_race_id_foreign');
            $table->dropForeign('employee_status_id_foreign');
            $table->dropForeign('employee_work_pass_type_id_foreign');
            $table->dropForeign('employee_user_id_foreign');
        });

        Schema::table('employee_address', function($table)
        {
            // Drop Foreign Keys for table 'employee_address'

            $table->dropForeign('employee_address_employee_id_foreign');
            $table->dropForeign('employee_address_user_id_foreign');

        });

        Schema::table('employee_identity_doc', function($table)
        {
            // Drop Foreign Keys for table 'employee_identity_doc'

            $table->dropForeign('employee_identity_doc_employee_id_foreign');
            $table->dropForeign('employee_identity_doc_identity_doc_type_id_foreign');
            $table->dropForeign('employee_identity_doc_user_id_foreign');

        });

        Schema::table('employee_remarks', function($table)
        {
            // Drop Foreign Keys for table 'employee_remarks'

            $table->dropForeign('employee_remarks_employee_id_foreign');
            $table->dropForeign('employee_remarks_globalevent_id_foreign');
            $table->dropForeign('employee_remarks_event_period_id_foreign');
            $table->dropForeign('employee_remarks_user_id_foreign');

        });

        Schema::table('client', function($table)
        {
            // Drop Foreign Keys for table 'client_contact'
            $table->dropForeign('client_country_code');
            $table->dropForeign('user_id_foreign');

        });

        Schema::table('client_contact', function($table)
        {
            // Drop Foreign Keys for table 'client_contact'
            $table->dropForeign('client_contact_title_id');
            $table->dropForeign('client_contact_sex_id');
            $table->dropForeign('client_contact_client_id_foreign');
            $table->dropForeign('client_contact_user_id_foreign');

        });

        Schema::table('client_department', function($table)
        {
            // Drop Foreign Keys for table 'client_department'

            $table->dropForeign('client_department_client_id_foreign');
            $table->dropForeign('client_department_work_type_id_foreign');
            $table->dropForeign('client_department_parent_id_foreign');
            $table->dropForeign('client_department_employee_h_rate_currency_code_foreign');
            $table->dropForeign('client_department_client_h_rate_currency_code_foreign');
            $table->dropForeign('client_department_user_id_foreign');

        });

        Schema::table('globalevent', function($table)
        {
            // Drop Foreign Keys for table 'event'

            $table->dropForeign('globalevent_client_department_id_foreign');
            $table->dropForeign('globalevent_client_department_user_id_foreign');

        });

        Schema::table('globalevent_period', function($table)
        {
            // Drop Foreign Keys for table 'event_period'

            $table->dropForeign('globalevent_period_event_id_foreign');
            $table->dropForeign('globalevent_period_user_id_foreign');


        });

        Schema::table('globalevent_period_employee', function($table)
        {
            // Drop Foreign Keys for table 'event_period_employee'
            $table->dropForeign('globalevent_period_employee_globalevent_period_id_foreign');
            $table->dropForeign('globalevent_period_employee_employee_id_foreign');
            $table->dropForeign('globalevent_period_employee_user_id_foreign');
            $table->dropForeign('gpe_employee_h_rate_currency_code_foreign');
            $table->dropForeign('gpe_client_h_rate_currency_code_foreign');
            $table->dropForeign('globalevent_period_employee_user_id_foreign');
            $table->dropUnique('clvno_unique');
        });

        Schema::table('period_employee_payment', function($table)
        {
            // Foreign Keys for table 'event_period_employee'

            $table->dropForeign('period_employee_payment_globalevent_period_employee_foreign');
            $table->dropUnique('period_employee_payment_globalevent_period_employee_id_unique');
            $table->dropForeign('period_employee_payment_payment_id_foreign')->references('id')->on('payment');
            $table->dropForeign('user_id');
        });

    }
}
