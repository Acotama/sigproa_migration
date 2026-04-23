<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class ActividadOperativa extends Model
{
    protected $table = 'poi_actividad_operativa';

    protected $fillable = [
     'id',
     'nombre',
     'id_cadena',
     'um',
     'cod_um',
     'resp_institucional',
     'resp_operativo',
     'trazador',
     'estado'
     ];    
    public $timestamps = false;
}
