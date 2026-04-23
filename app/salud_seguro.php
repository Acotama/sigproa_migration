<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class salud_seguro extends Model
{
  protected $table = 'salud_seguro';
  protected $primaryKey = 'id_seguro';

  protected $fillable = [
    'ubigeo',
    'departamento',
    'provincia',
    'distrito',
    'total',
    'essalud',
    'ffaapnp',
    'seg_privado',
    'sis',
    'otro',
    'no_tiene',
    'years',
    'ambito',
    'fuente'
  ];

  protected $guarded = [
      'id_seguro',
  ];

  public $timestamps = false;
}
