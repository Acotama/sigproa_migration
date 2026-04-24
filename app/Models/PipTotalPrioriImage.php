<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class PipTotalPrioriImage extends Model
{
    protected $table = 'grli_pip_total_priori_img';

    protected $fillable = [
    	'url',
    	'nombre',
    	'tiempo',
    	'fecha',
    	'idproyecto',
    	'created_at',
    	'updated_at',
    	'estado',
        'aprobado',
        'tipo',
        'descripcion',
        'idobra'
    ];

    protected $guarded = [
    	'id'
    ];
}
