<?php

namespace sayhuite\Http\Controllers;
use DB;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function lista_inversion(Request $request){
        $anio = date('Y');
        $data = DB::table(DB::raw("sp_proyecto(2023)"))->where('nom_prov',"HUARAL")->get();
        return $data;
    }

    public function lista(Request $request){
        $anio = date('Y');
        $data = DB::table(DB::raw("vw_total_proyectos"))->where('cod_unif','!=',"SIN COD.")->get();
        return $data;
    }

    public function lista_total(Request $request){
        $anio = date('Y');
        $data = DB::table(DB::raw("sp_proyecto(2023)"))->get();
        return $data;
    }
}

