<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Library: Import / Export
|--------------------------------------------------------------------------
|
*/
class Image_uploads {

  

	public function _construct() {
        $CI = & get_instance();
               
    }
    
    /**
     * Image upload
     */
    public function uploads($image,$original_path) {

        $allowed  = array('png', 'jpg','jpeg', 'gif');
        $upload_dir = FCPATH.$original_path;
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, TRUE);
        }
        $imagename = rand().$image['name'];
        if(isset($image) && $image['error'] == 0){

            $extension = pathinfo( $imagename, PATHINFO_EXTENSION);

            if(!in_array(strtolower($extension), $allowed)){
                echo false;
                exit();
            }

            if(move_uploaded_file($image['tmp_name'],$upload_dir. $imagename)){
                $img = $imagename;
                return $img;
               }

        }

    }

    public function img_crop($original_path,$new_path,$image,$Thumbheight,$Thumbwidth)
    {
       // echo $original_path.'--',$new_path.'--'.$image;exit();
        require_once APPPATH.'third_party/easyphpthumbnail/example/inc/easyphpthumbnail.class.php';
        $new_path=FCPATH.$new_path;
        if(!is_dir($new_path)){
            mkdir($new_path, 0777, TRUE);
        }
        $thumb = new easyphpthumbnail;
        /*$height=$Thumbheight/2;
        $width=$Thumbwidth/2;*/
        $thumb -> Thumbheight = $Thumbheight;
        $thumb -> Thumbwidth  = $Thumbwidth;
        $thumb -> Thumbsize = 50;
       // $thumb -> Percentage = true;
       // $thumb -> Cropimage = array(2,1,$width,$width,$height,$height);
        $thumb -> Thumblocation = $new_path;
        $thumb -> Thumbfilename = $image;
        $path = FCPATH.$original_path.$image;
        $thumb -> Createthumb($path,'file');

    }



    
}
/*<?php
include_once('inc/easyphpthumbnail.class.php');
$thumb = new easyphpthumbnail;
$thumb -> Thumbsize = 50;
$thumb -> Percentage = true;
$thumb -> Createthumb('gfx/image.jpg');
?>*/