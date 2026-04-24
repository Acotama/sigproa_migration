<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\Models\InfFinanciera;
use DB;
use sayhuite\Models\PipTotalPriori;
use sayhuite\Models\Procompite;
use Symfony\Component\HttpFoundation\Response;

class InfFinancieraController extends Controller
{

    public function loadPartial(Request $request){

        return view('inffinanciera.'. $request->get('id'))->render();
    }
   public function getResumen(Request $request){

       $input = $request->all();
       $tipos = '';
       $rango = $input['chkrango'];
       $tip_pry = $input['tip_pry'];
       $year_ini = $input['year_ini'];
       $year_fin = $rango === "true" ? $input['year_fin'] : $input['year_ini'];
       $years = '';

        if($year_ini <= $year_fin ){
           for($i = $year_ini;$i<=$year_fin;$i++) {
               if($i == $year_fin){
                   $years .= "'".$i."'";
               } else {
                   $years .= "'".$i."',";
               }

           }
       }
       else{
           $years = htmlentities($year_ini);
       }

       if($tip_pry!= 'pip' and $tip_pry != 'pic' and $tip_pry != 'procompite'){
            $todos = "'PIP','PIC','PROCOMPITE'";
       } else {
           $todos  = htmlentities(strtoupper($tip_pry));
       }

       $result = DB::select("SELECT
                              SUM(pim::NUMERIC(14,2)) as pim,
                              SUM(dev::NUMERIC(14,2)) as dev,
                              ((SUM(dev::NUMERIC(14,2)) / SUM(pim::NUMERIC(14,2)) ) * 100)::NUMERIC(14,2) as ejecutado
                            FROM  inf_financiera
                              WHERE (CASE WHEN (select tipo_pry from grli_pip_total_priori where grli_pip_total_priori.cod_unif = inf_financiera.cod_unif::text) <> ''
                                    THEN (select tipo_pry from grli_pip_total_priori where grli_pip_total_priori.cod_unif = inf_financiera.cod_unif::text)
                                 ELSE 'PROCOMPITE'
                              END) IN(".$todos.") AND inf_financiera.anio_financ IN(".$years.")");

       return Response($result,200);
   }
}
