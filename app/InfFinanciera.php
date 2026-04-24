<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class InfFinanciera extends Model
{
    protected $table = 'inf_financiera';
    
    protected $fillable = [
        'cod_unif',
        'uni_ejec',
        'anio_financ',
        'fuente_financ',
        'pia',
        'dev_ene',
        'dev_feb',
        'dev_mar',
        'dev_abr',
        'dev_may',
        'dev_jun',
        'dev_jul',
        'dev_ago',
        'dev_set',
        'dev_oct',
        'dev_nov',
        'dev_dic',
        'dev',
        'pim',
        'comp_anual',
        'certif'       
        ]; 
            
    protected $guarded = ['id'];



    function getFinancXyear($cod_unif, $year_ini, $year_fin = null){
        $query = $this::where('cod_unif', $cod_unif);

        if (is_null($year_fin) || empty($year_fin)) {
            return $query->where('anio_financ', $year_ini)->get();
        }

        return $query->whereBetween('anio_financ', [$year_ini, $year_fin])->get();
    }

}
