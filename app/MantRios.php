<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class MantRios extends Model
{

    protected $table = 'grli_mantenimiento_rios';
    protected $primaryKey = 'id';

    protected $fillable = [
                           'activ',
                           'mf_ficha',
                           'mt_ficha',
                           'meta_ficha',
                           'mf_exp',
                           'mt_exp',
                           'meta_exp',
                           'mpro',
                           'meje',
                           'adic',
                           'ejecadi',
                           'est',
                           'anio'
                           ];

    protected $guarded = ['id','dep','cod_dep','prov','cod_prov','dist','cod_dist'];

    public $timestamps = false;
    public static $rules = [];
}
