<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Taller_Img extends Model
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'poi_taller_img';
    protected $primaryKey = 'id';
    protected $fillable = [
    				'id',
    				'id_poi_taller_usuario',
    				'url',
    				'nombre',
    				'fecha',
    				'estado',
                    'exif',
                    'exifdata',
                    'imgcdata',
                    'imghash',
                    'semejantes'
    		  ];
}
