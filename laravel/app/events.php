<?php

/*
|--------------------------------------------------------------------------
| Application Event Subscribing
|--------------------------------------------------------------------------
*/
Event::listen('laravel.query', function($sql) {
  log::info('haaaaaaaaaaaaaa');
});

Event::listen('employee.saved', function()
{
    log::info('haaaaaaaaaaaaaa');
});
// Save file after DB saved a document
Event::listen('saved', 'DocumentFile@employeeDocSaved');

// Save file after DB created an identity document
Event::listen('EmployeeIdentityDoc.saved', 'DocumentFile@employeeIdentityDocSaved');

// delete file after doc file ref deleted in DB
Event::listen('EmployeeDoc.deleted', 'DocumentFile@employeeDocDeleted');

// delete file after identity doc file ref deleted in DB
Event::listen('EmployeeIdentityDoc.deleted', 'DocumentFile@employeeIdentityDocDeleted');
