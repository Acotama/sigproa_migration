<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\ActaSeguimiento;
use sayhuite\ActaAcuerdoSeguimiento;
use sayhuite\PipTotalPriori;
use DB;

class ActaController extends Controller
{
    public function inicio(Request $request){
        $acta_seguimiento = ActaSeguimiento::select('id','nombre','orden')
        ->join('grli_pip_total_priori',DB::RAW('acta_acuerdo.cod_unif::text'),'grli_pip_total_priori.cod_unif')
        ->where('anio',2020)
        ->where('num_acta',DB::RAW('(select max(num_acta) from acta_acuerdo)'))
        ->orderBy('orden')->distinct()->get();
        
        $acta = ActaSeguimiento::select('agenda','otros_acuerdos','num_acta')
        ->where('anio',2020)
        ->where('num_acta',DB::RAW('(select max(num_acta) from acta_acuerdo)'))
        ->first();

        return View('actas.inicio')->with(['acta_seguimiento'=>$acta_seguimiento,'num_acta'=>$acta->num_acta,'agenda'=>explode(";",$acta->agenda),'otros_acuerdos'=>explode(";",$acta->otros_acuerdos)]);

    }
    
    public function acuerdos(Request $request){
        $input = $request->all();
        $cod_unif = PipTotalPriori::select('cod_unif')->where('id',$input['id'])->first();
        $acuerdo = ActaAcuerdoSeguimiento::select(DB::RAW('problematica'),'acuerdo','entregable','responsable' ,'fecha_entrega' ,'estado')
        ->join('acta_acuerdo','acta_acuerdo_detalle.id_acta','acta_acuerdo.id_acta')
        ->where('anio',2020)
        ->where('num_acta',DB::RAW('(select max(num_acta) from acta_acuerdo)'))
        ->where('cod_unif',"=",$cod_unif->cod_unif)->get();
        
        return view('actas.acuerdos')->with(
            [
                'acuerdos'=>$acuerdo,
            ]
        )->render();

    }
}
