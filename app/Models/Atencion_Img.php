<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Atencion_Img extends Model
{

	protected $table = "poi_salud_atencion_usuario_img";
	protected $fillable = [		
		'id_poi_salud_atencion_usuario',
		'url',
		'nombre',
		'fecha',
		'estado',
		'exif',
		'exifdata',
		'created_at',
		'updated_at',
		'imgcdata',
		'imghash'
	];

	protected $guarded = [ 'id' ];
    
}
