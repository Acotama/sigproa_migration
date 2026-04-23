<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class salud_hemoglobina extends Model
{

  protected $table = 'salud_hemoglobina';
  protected $primaryKey = 'id_hemoglobina';

  protected $fillable = [
    'ubigeo',
    'departamento',
    'provincia',
    'distrito',
    'resultado',
    'n_prueba',
    'tipo',
    'edad',
    'ambito',
    'years',
    'fuente'
  ];

  protected $guarded = [
      'id_hemoglobina',
  ];

  public $timestamps = false;
}
