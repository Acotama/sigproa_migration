<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class AulasPrefabricadas extends Model
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'grli_aulas_prefabricadas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'provincia',
        'cod_prov',
        'distrito',
        'cod_dist',
        'ugel',
        'cod_modular',
        'cod_local',
        'listado_final',
        'director',
        'nivel',
        'caracteristica',
        'direccion',
        'centro_problado',
        'altitud',
        'alumno',
        'docente',
        'seccion',
        'nro_aula',
        'situacion_actual'
    ];

    protected $guarded = [        
        'id'
    ];

    public $timestamps = false;
    public static $rules = [];
}
