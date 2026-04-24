<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class vivienda extends Model
{
  protected $table = 'vivienda';
  protected $primaryKey = 'id_vivienda';

  protected $fillable = [
    'ubigeo',
    'departamento',
    'provincia',
    'distrito',
    'total_vivienda',
    'total_hogar',
    'total_pob_resi',
    'casa_independiente',
    'departamento_edificio',
    'vivienda_quinta',
    'vivienda_casa_vecindad',
    'choza',
    'vivienda_improvisada',
    'otro',
    'years',
    'ambito',
    'fuente'
  ];

  protected $guarded = [
      'id_vivienda',
  ];

  public $timestamps = false;
}
