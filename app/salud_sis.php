<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class salud_sis extends Model
{
  protected $table = 'salud_sis';
  protected $primaryKey = 'id_sis';

  protected $fillable = [
    'ubigeo',
    'departamento',
    'provincia',
    'distrito',
    'ninos_dni',
    'por_ninos_dni',
    'ninos_supl',
    'por_ninos_supl',
    'ninos_atencion',
    'por_ninos_atencion',
    'ninos_vac_neumococo',
    'por_ninos_vac_neumococo',
    'ninos_vac_rotavirus',
    'por_ninos_vac_rotavirus',
    'ninos_vac_rotneu',
    'por_ninos_vac_rotneu',
    'ninos_fed',
    'por_ninos_fed',
    'tipo',
    'edad',
    'years',
    'ambito',
    'fuente'
  ];

  protected $guarded = [
      'id_sis',
  ];

  public $timestamps = false;
}
