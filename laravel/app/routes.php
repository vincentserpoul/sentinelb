<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::controller('auth', 'AuthController');
/*
Route::get('expiry', function(){
    return Response::json(array('message' => 'Your session has expired, please log in'), 401);
})
*/

// Route group for API versioning
Route::group(array('prefix' => 'api/v1', 'before' => 'auth'), function()
{
    Route::resource('url', 'UrlController');
});

// Route group for API versioning
Route::group(array('prefix' => 'api/v1', 'before' => 'auth'), function()
{
    // Allow CORS
    // header('Access-Control-Allow-Origin: *');
    // ?
    // header('Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since');
    // Allow different methods
    // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

    // Employee
    Route::options('employee', function(){return null;});
    Route::options('employee/{id}', function(){return null;});
    Route::resource('employee', 'EmployeeController');
    Route::options('employee/{employee_id}/globalevent_period', function(){return null;});
    Route::get('employee/{employee_id}/globalevent_period', 'EmployeeController@globalevent_period');
    Route::options('employee/{employee_id}/unpaid_globalevent_period', function(){return null;});
    Route::get('employee/{employee_id}/unpaid_globalevent_period', 'EmployeeController@unpaid_globalevent_period');
    Route::options('employee/{employee_id}/possible_globalevent_period/{event_id}', function(){return null;});
    Route::get('employee/{employee_id}/possible_globalevent_period/{event_id}', 'EmployeeController@possible_globalevent_period');
    Route::options('employee/all_possible_globalevent_period/{event_id}', function(){return null;});
    Route::get('employee/all_possible_globalevent_period/{event_id}', 'EmployeeController@all_possible_globalevent_period');
    Route::options('employee/assigned_employees/{globalevent_period_id}', function(){return null;});
    Route::get('employee/assigned_employees/{globalevent_period_id}', 'EmployeeController@assigned_employees');

    // Employer
    Route::options('employer', function(){return null;});
    Route::options('employer/{id}', function(){return null;});
    Route::resource('employer', 'EmployerController');

    // EmployerContact
    Route::options('employer_contact', function(){return null;});
    Route::options('employer_contact/{id}', function(){return null;});
    Route::resource('employer_contact', 'EmployerContactController');

    // Payment
    Route::options('payment', function(){return null;});
    Route::options('payment/{id}', function(){return null;});
    Route::resource('payment', 'PaymentController');


    // EmployerDepartment
    Route::options('employer_department', function(){return null;});
    Route::options('employer_department/{id}', function(){return null;});
    Route::resource('employer_department', 'EmployerDepartmentController');

    // Event
    Route::options('globalevent', function(){return null;});
    Route::options('globalevent/{id}', function(){return null;});
    Route::resource('globalevent', 'GlobaleventController');

    // EventPeriod
    Route::options('globalevent_period', function(){return null;});
    Route::options('globalevent_period/{id}', function(){return null;});
    Route::resource('globalevent_period', 'GlobaleventPeriodController');

    // EventPeriodEmployee
    Route::options('globalevent_period_employee', function(){return null;});
    Route::options('globalevent_period_employee/{id}', function(){return null;});
    Route::resource('globalevent_period_employee', 'GlobaleventPeriodEmployeeController');

    // Model static labels
    Route::options('modelstaticlabels', function(){return null;});
    Route::options('modelstaticlabels/{id}', function(){return null;});
    Route::resource('modelstaticlabels', 'ModelStaticLabelController');

    // Model iso labels
    Route::options('modelisolabels', function(){return null;});
    Route::options('modelisolabels/{id}', function(){return null;});
    Route::resource('modelisolabels', 'ModelIsoLabelController');

    //Users
    Route::options('users', function(){return null;});
    Route::options('users/id', function(){return null;});
    Route::resource('users', 'UsersController');

    //Groups
    Route::options('groups', function(){return null;});
    Route::options('groups/id', function(){return null;});
    Route::resource('groups', 'GroupsController');

    //Permissions
    Route::options('permissions', function(){return null;});
    Route::options('permissions/id', function(){return null;});
    Route::resource('permissions', 'PermissionsController');
});
