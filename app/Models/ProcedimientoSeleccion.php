<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class ProcedimientoSeleccion extends Model
{
  protected $table = 'procedimiento_seleccion';
  protected $primaryKey = 'id_procedimiento_seleccion';

  protected $fillable = [
     'id_procedimiento_seleccion',
     'nom_pro_seleccion',
     'cod_unif',
     'norma_aplicable',
     'objeto_contratacion',
     'requerimiento_documento',
     'requerimiento_fecha',
     'certificacion_documento',
     'certificacion_fecha',
     'aprob_exp_documento',
     'aprob_exp_fecha',
     'com_sel_documento',
     'com_sel_fecha',
     'com_sel_miembros',
     'aprob_bases_documento',
     'aprob_bases_fecha',
     'fecha_convocatoria',
     'tipo_proc_selec',
     'num_proc_selec',
     'valor_ref_est',
     'estado',
     'estado_fecha',
     'estado_obs',
     'buena_pro_est_fecha',
     'buena_pro_fecha_real',
     'buena_pro_obs',
     'prov_adjudicado',
     'valor_adjudicado',
     'cont_documento',
     'cont_monto',
     'cont_fecha',
     'ano',
     'fech_act'
  ];

  protected $guarded = [
      'id_procedimiento_seleccion',
  ];

  public $timestamps = false;
}
