<?php
// Handler :'DocumentFile', used to play with uploaded scanned files
class DocumentFile {

    public function docSaved($data)
    {
        Log::info('employeeDocSaved '.$data->toJson());
    }

    public function docDeleted($data)
    {
        /* Create path to image */
        $relativePathToImage = $data->getImagePath().$data->image_name;

        /* Delete file */
        if(!empty($relativePathToImage) && File::exists(public_path().$relativePathToImage)){
            File::delete(public_path().$relativePathToImage);
        }
    }
}
