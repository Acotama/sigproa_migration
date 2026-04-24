<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class AtencionUsuario extends Model
{

    protected $table = 'poi_salud_atencion_usuario';
    protected $primaryKey = 'id';

    protected $fillable = [
        'observacion',
        'estado',
        'meses',
        'id_poi_salud_paciente',
        'id_poi_salud_actividad_operativa_programacion'
    ];

    protected $guarded = [        
        'id'
    ];    
}
