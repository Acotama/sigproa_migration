<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class ejecucion_financiera extends Model
{
  protected $table = 'grli_pip_seguimiento_ejecucion_financiera';
  protected $primaryKey = 'id';

  protected $fillable = [
    'cod_unif',
    'pia_dia',
    'pim_dia',
    'certificacion_dia',
    'comp_anual_dia',
    'ate_comp_anual_dia',
    'dev_dia',
    'girado_dia',
    'a_financ_dia',
    'fecha',
    'camb_pia_dia',
    'camb_pim_dia',
    'camb_certificacion_dia',
    'camb_comp_anual_dia',
    'camb_ate_comp_anual_dia',
    'camb_dev_dia',
    'camb_girado_dia',
    'camb_a_financ_dia',
    'camb',
    'dif_pia_dia',
    'dif_pim_dia',
    'dif_certificacion_dia',
    'dif_comp_anual_dia',
    'dif_ate_comp_anual_dia',
    'dif_dev_dia',
    'dif_girado_dia',
    'dif_a_financ_dia',
    'reg_ant_dia',
    'primera_aparicion',
    'anio'
  ];

  protected $guarded = [
      'id',
  ];

  public $timestamps = false;
}
