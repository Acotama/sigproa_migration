<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class salud_anemia extends Model
{
  protected $table = 'salud_anemia';
  protected $primaryKey = 'id_anemia';

  protected $fillable = [
    'ubigeo',
    'departamento',
    'provincia',
    'distrito',
    'n_evaluados',
    'n_casos_total',
    'porc_total',
    'n_casos_leve',
    'porc_leve',
    'n_casos_moderada',
    'porc_moderada',
    'n_casos_severa',
    'porc_severa',
    'tipo',
    'edad',
    'ambito',
    'years',
    'fuente'
  ];

  protected $guarded = [
      'id_anemia',
  ];

  public $timestamps = false;
}
