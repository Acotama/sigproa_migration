<?php

namespace sayhuite\Logic\Image;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
//use sayhuite\Models\Image;
use Mockery\CountValidator\Exception;
use sayhuite\PipTotalPriori;
use sayhuite\MantenimientoVia;
use Illuminate\Support\Facades\DB;

class ImageRepository
{        
    function deleteImg($imgArr, $path)
    {
      foreach ($imgArr as $key => $file) {
        unlink($path.$file);
      }
    }

    function save($file, $path){
        $manager = new ImageManager();
        $image = $manager->make( $file->getRealPath() )->save($path);

        return $image;
    }

    function copyTo($from, $to){
        /*$manager = new ImageManager();
        $image = $manager->make( $file->getRealPath() )->save($path);*/

        return "";
    }

    function hash($path){
        return "";
    }

    /*function image_fix_orientation($filename, $onserverimg) {        

        $exif = "";
        $exif = @exif_read_data($filename, 'IFD0');

        $this->exifdata = $exif;

        if($exif){
            if(isset($exif["DateTime"])){
                $this->imageDate = date ("Y-m-d H:i:s", strtotime($exif["DateTime"]));
            }else if(isset($exif['DateTimeOriginal'])){
                $this->imageDate = date ("Y-m-d H:i:s", strtotime($exif["DateTimeOriginal"]));
            }                 
        }            
        
        if (!empty($exif['Orientation'])) {            
            $image = imagecreatefromjpeg($filename);            
            switch ($exif['Orientation']) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;

                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;

                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
            }

            imagejpeg($image, $onserverimg, 90);
        }
    }*/

}
