<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class CadenaFuncional extends Model
{
    protected $table = "cadena_funcional_programatica";

    protected $fillable = [
		'cod_cat_presupuestal',
		'cat_presupuestal',
		'cod_producto',
		'producto',
		'cod_actividad',
		'act_presupuestal',
		'cod_funcion',
		'funcion',
		'cod_div_funcional',
		'div_funcional',
		'cod_grupo_funcional',
		'grupo_funcional',
		'anio'
	];

	protected $guarded = [
	    'id'
	];

}
