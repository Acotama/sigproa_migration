<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class MantenimientoVia extends Model
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'grli_mantenimiento_via';
    protected $primaryKey = 'id';

    protected $fillable = ['cod_ruta',
                            'activ',
                            'tip_activ',
                            'tip_mant',
                            'mfis_pro',
                            'mfin_pro',
                            'ejec_fisico',
                            'av_fisico',
                            'deven_finan',
                            'av_finan',
                            'f_afinanc',
                            'mod_ejec',
                            'est',                            
                            'f_estado',
                            'est_info',
                            'anio',
                            'ffoto_antes',
                            'ffoto_despues',
                            'u_medida'];

    protected $guarded = ['id','dep','cod_dep','prov','cod_prov','dist','cod_dist'];

    public $timestamps = false;
    public static $rules = [];

}
