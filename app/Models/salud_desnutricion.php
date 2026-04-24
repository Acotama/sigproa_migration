<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class salud_desnutricion extends Model
{
  protected $table = 'salud_desnutricion';
  protected $primaryKey = 'id_desnutricion';

  protected $fillable = [
    'ubigeo',
    'departamento',
    'provincia',
    'distrito',
    'n_evaluados',
    'n_casos',
    'porcentaje',
    'tipo',
    'edad',
    'ambito',
    'years',
    'fuente'
  ];

  protected $guarded = [
      'id_desnutricion',
  ];

  public $timestamps = false;
}
