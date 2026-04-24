<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class salud extends Model
{
  protected $table = 'salud';
  protected $primaryKey = 'id_salud';

  protected $fillable = [
    'id_salud',
    'region',
    'codigogeo',
    'provincia',
    'distrito',
    'valor',
    'tipo',
    'years',
    'resultado',
    'fuente'
  ];

  protected $guarded = [
      'id_salud',
  ];

  public $timestamps = false;
}
