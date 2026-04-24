<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class ContratacionesPS extends Model
{
  protected $table = 'contratacionesps';
  protected $primaryKey = 'idcontrataciones';

  protected $fillable = [
    'tipo',
    'cod_unico',
    'cod_convocatoria',
    'fec_convocatoria',
    'num_contrato',
    'num_item',
    'procedim_selec',
    'tipo_proceso',
    'nomenclatura',
    'des_proceso',
    'ind_paquetes',
    'des_item',
    'fec_hor_convoc',
    'estado',
    'valor_refer',
    'valor_estim',
    'ind_cronog',
    'etapa',
    'fec_inicio',
    'fec_termino',
    'est_cronog',
    'tip_contr_asoc',
    'nom_contratista',
    'ruc_contratista',
    'des_contrato',
    'url_contrato',
    'fec_suscripcion',
    'mto_suscripcion',
    'mto_total',
    'mto_item',
    'ind_contrato',
    'nom_entidad',
    'abrev_entidad',
    'fec_publicac',
    'fec_reinicio',
    'objeto_contratac',
    'des_obj_cont',
    'cod_moneda',
    'des_moneda',
    'url_acciones',
    'ind_acciones',
    'tipo_formato',
    'modal_ejec',
    'nom_ejecutora',
    'modalidad',
    'entidad_contratante',
    'ruc_ent_contratante',
    'num_ruc_postor',
    'mto_contratado',
    'nom_ganador',
    'ind_seace',
    'ind_proc_sel',
    'fecha_act',
  ];

  protected $guarded = [
      'idcontrataciones',
  ];

  public $timestamps = false;
}
