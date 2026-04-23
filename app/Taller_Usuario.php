<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

use sayhuite\Taller_Img;

class Taller_Usuario extends Model
{

    protected $table = 'poi_taller_usuario';
    protected $primaryKey = 'id';
    protected $fillable = [
    				'id_usuario',
    				'id_poi_taller',
    				'fecha',
    				'hora',
    				'descripcion',
    				'publicada',
                    'estado',
                    'docente',
                    'dni_docente',
                    'reprogramada',
                    'id_distrito',
                    'codigo_taller',
                    'resp_institucional',
                    'observacion',
                    'nro_participantes'
    				];

    protected $observacionOptions= [
    	'educacion' => [	
    						0 => 'Todo bien',
    						1 => 'No se Encontró Persona Asignada',
    						3 => 'Persona asignada se resistió al acompañamiento'/*,
    						4 => 'Reprogramación de actividad',
                            5 => 'Cambió Persona Asignada'*/
    					],
    	'salud'		=> []
    ];

    protected $guarded = ['id'];

    public static function tallerEstado($x){

        //@return green || yellow || red
        mb_internal_encoding('UTF-8');

        $photos = Taller_Img::where('id_poi_taller_usuario',$x->id)->where('estado',1)->get()->toArray();
        $date = date('Y-m-d');
        $date_arr=explode('-',$date);
        $datem1 = Date("Y-m-d",mktime(0,0,0,$date_arr[1],$date_arr[2]-1,$date_arr[0]));
        /*if( $x->publicada == 1 ){
            return "published";
        }else if( $x->fecha < $date ){
            return "passed";
        }else if( $x->fecha == $date ){
            return "executing";*/            
        if(  $datem1 > $x->fecha  and empty($photos) ){
            return "passed";
        } else if ( $date >= $x->fecha  and count($photos) >= 1 ) {
            return "complete";
        } else if ( $date <= $x->fecha and $x->reprogramada == '1' ) {
            return "reprogramed";
        } else if ( $date <= $x->fecha ) {
            return "planned";
        }


    }
}
