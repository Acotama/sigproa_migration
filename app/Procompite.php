<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Procompite extends Model
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'grli_pip_procompite';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nom_proyec',
        'aeo',

        'f_act',
        'modalidad',
        'f_inicio_obra',
        'f_fin_obra',
        't_ejec_dia',
        'a_fisico',
        'a_financ',
        'b_pogres',
        'autoriz_pdf',
        'f_aut',
        'a_aut',
        'rer_pdf',
        'f_rer',
        'a_rer',
        'pneg_pdf',
        'f_pneg',
        'a_pneg',
        'ejec_pdf',
        'f_ejec',
        'a_ejec',
        'situa_pro',
        'fecha_situa',
        'anio',
        'latitud',
        'longitud',
        'est_proyec',
        'nro_conv',
        'conv_pdf',
        'ffoto',        
        'f_adjudica',
        'contrapartida',
        'beneficiarios'
    ];


    protected $guarded = [
        //AUTOMATED
        'cod_unif',
        'nom_dpto',
        'cod_dpto',
        'nom_prov',
        'cod_prov',
        'nom_dist',
        'cod_dist',
        'nom_cp',
        'u_formul',
        'u_ejec',
        'sector',
        //-- FINANCIERA
        'm_pip',//.
        'est_proyec',//CHANGE est_proyec
        'm_pim'.//.
        'm_cert',//
        'm_pim_acu',//m_pimacu
        'm_deveng',//.
        'm_devenacu'//m_deveng_a
        ];

    public $timestamps = false;
    public static $rules = [];
}
