<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class IndicadorBrechas extends Model
{
    protected $table = 'indicador_brecha';
    protected $primaryKey = 'id_brecha';

    protected $fillable = [
        'numero',
        'funcion',
        'nombre',
        'tipo',
        'valor',
        'nivel',
    ];

    protected $guarded = [
        'id_brecha',
    ];

    public $timestamps = false;
}
