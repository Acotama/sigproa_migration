<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Consulta_siaf extends Model
{
  protected $table = 'consulta_siaf';
  protected $primaryKey = 'id_consulta_siaf';

  protected $fillable = [
    "id_consulta_siaf",
    "ano_eje",
    "sec_ejec",
    "pliego",
    "ejecutora",
    "sec_func",
    "programa",
    "prod_pry",
    "act_ai_obra",
    "funcion",
    "division_func",
    "grupo_func",
    "meta",
    "finalidad",
    "unidad_medida",
    "cantidad",
    "departamento",
    "provincia",
    "distrito",
    "origen",
    "fuente_financ_agregada",
    "fuente_financ",
    "tipo_recurso",
    "categ_gasto",
    "tipo_transaccion",
    "generica",
    "subgenerica",
    "subgenerica_det",
    "especifica",
    "especifica_det",
    "presupuesto",
    "modificacion",
    "pim",
    "m01",
    "m02",
    "m03",
    "m04",
    "m05",
    "m06",
    "m07",
    "m08",
    "m09",
    "m10",
    "m11",
    "m12",
    "total_prog",
    "saldo",
    "porcentaje",
    "fase",
    "fecha",
    "c_provincia"
  ];

  protected $guarded = [
      'id_consulta_siaf',
  ];

  public $timestamps = false;
}
