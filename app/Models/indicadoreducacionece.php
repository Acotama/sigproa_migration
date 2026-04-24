<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class indicadoreducacionece extends Model
{
  protected $table = 'indicadoreducacionece';
  protected $primaryKey = 'id_ece';

  protected $fillable = [
    'codigogeo',
    'region',
    'provincia',
    'distrito',
    'coberturaie',
    'coberturaest',
    'lec_previoinicio',
    'lec_inicio',
    'lec_enproceso',
    'lec_satisfactorio',
    'mat_previoalinicio',
    'mat_eninicio',
    'mat_proceso',
    'mat_satisfactorio',
    'years',
    'evaluacion',
    'nivel',
    'grado',
    'resultado'
  ];

  protected $guarded = [
      'id_ece',
  ];

  public $timestamps = false;
}
