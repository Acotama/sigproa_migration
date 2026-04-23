<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class MantCanales extends Model
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'grli_canales_nuevo';
    protected $primaryKey = 'id';

    protected $fillable = [

        'nom_dpto',
        'cod_dpto',
        'nom_prov',
        'cod_prov',
        'nom_dist',
        'cod_dist',
        'nombre',
        'monto_ejec',
        'meta_programada',
        'meta_ejec',
        'meta_porejec',
        'avance_ejec',
        'beneficiarios',
        'hect_riego',
        'cemento_entreg',
        'anio',
        'estado',
        'nro_conv',
        'ffoto',
        'latitud',
        'longitud'
    ];

    protected $guarded = ['id'];

    public $timestamps = false;
    public static $rules = [];
}
