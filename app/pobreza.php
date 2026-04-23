<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class pobreza extends Model
{
  protected $table = 'pobreza';
  protected $primaryKey = 'id_pobresa';

  protected $fillable = [
    'id_pobresa',
    'region',
    'codigogeo',
    'provincia',
    'distrito',
    'inferior',
    'superior',
    'promedio',
    'years',
    'resultado',
    'fuente'
  ];

  protected $guarded = [
      'id_pobresa',
  ];

  public $timestamps = false;
}
