<?php
// Model:'EmployeeDoc' - Database Table: 'employee_doc'

Class EmployeeDoc extends Eloquent
{

    protected $hidden = array('user_id', 'created_at', 'updated_at');
    protected $table = 'employee_doc';

    public function employee()
    {
        return $this->belongsTo('Employee');
    }

    public function doc_type()
    {
        return $this->belongsTo('DocType');
    }

    /**
     * Generate an image name
    **/
    protected function generateImageName(){
        return $this->employee_id.'_'.$this->doc_type_id.'_'.$this->id.'_'.mt_rand();
    }

    /**
     * Save the image file and update the db accordingly
    **/
    public function saveImage($image)
    {

        /* Get image extension */
        $imageExt = File::extension($image['file']['name']);
        /* Create image name */
        $imageName = $this->generateImageName().'.'.$imageExt;

        /* decode image data after removing prepended data */
        $img = base64_decode(preg_replace('#^data:image/[^;]+;base64,#', '', $image['dataURL']));
        /* Create path to images */
        $relativePathToImage = $this->getImagePath().$imageName;

        /* Create folder */
        if(!File::isDirectory(public_path().$this->getImagePath())){
            File::makeDirectory(public_path().$this->getImagePath(), 0777, true);
        }

        /* Write file */
        File::put(public_path().$relativePathToImage, $img);

        /* set the image name */
        $this->image_name = $imageName;

        $this->save();
    }

    /**
     * Get the file directory path inside the public folder
    **/
    public function getImagePath()
    {
        return '/images/employee_docs/';
    }

}
