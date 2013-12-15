<?php

/*
|--------------------------------------------------------------------------
| Application Event Subscribing
|--------------------------------------------------------------------------
*/

// Save file after DB saved a document
//Event::listen('eloquent.saved: EmployeeDoc', 'DocumentFile@employeeDocSaved');

// Save file after DB created an identity document
//Event::listen('eloquent.saved: EmployeeIdentityDoc', 'DocumentFile@employeeIdentityDocSaved');

// delete file after doc file ref deleted in DB
Event::listen('eloquent.deleted: EmployeeDoc', 'DocumentFile@docDeleted');

// delete file after identity doc file ref deleted in DB
Event::listen('eloquent.deleted: EmployeeIdentityDoc', 'DocumentFile@docDeleted');
