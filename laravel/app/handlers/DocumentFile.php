<?php
// Handler :'DocumentFile', used to play with uploaded scanned files
class DocumentFile {

    public function employeeDocSaved($data)
    {
        Log::info('employeeDocSaved '.$data->toJson());
    }

    public function employeeIdentityDocSaved($data)
    {
        Log::info('employeeIdentityDocSaved '.$data->toJson());
    }

    public function employeeDocDeleted($data)
    {
        Log::info('employeeDocDeleted '.$data->toJson());
    }

    public function employeeIdentityDocDeleted($data)
    {
        Log::info('employeeIdentityDocDeleted  '.$data->toJson());
    }

}
