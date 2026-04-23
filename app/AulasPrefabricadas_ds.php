<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class AulasPrefabricadas_ds extends Model
{

    protected $table = 'grli_aulas_pre_grds';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nom_activ',
        'pob_benef',
        'situacion',
        'f_inicio',
        'f_fin',
        'u_medida',
        'cantidad',
        'ctotal',
        'a_financ',
        'a_fisico',
        'a_ejec_fis',
        'a_ejec_financ'
    ];

    protected $guarded = [
        'nom_prov',
        'cod_prov',
        'nom_dist',
        'cod_dist'
    ];

    public $timestamps = false;
    public static $rules = [];
}
