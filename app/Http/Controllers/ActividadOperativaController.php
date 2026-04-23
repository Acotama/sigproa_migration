<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\ActividadOperativa;
use sayhuite\CadenaFuncional;
use DB;

class ActividadOperativaController extends Controller
{
    public function listActividadOperativaxActividad(Request $request){
    	$input  = $request->all();
    	$codigo = $input['idActividad'];
    	//dd($codigo);
    	$ActividadOperativa = CadenaFuncional::select([
    		'poi_actividad_operativa.id',
    		DB::raw('(poi_actividad_operativa.nombre || \' - \' || cadena_funcional_programatica.grupo_funcional) as nombre')
    		])
    		->where('cadena_funcional_programatica.cod_actividad','like',$codigo)
    		->join('poi_actividad_operativa','poi_actividad_operativa.id_cadena','=','cadena_funcional_programatica.id')
    		->pluck('nombre','id')
    		->toArray();

    	return Response($ActividadOperativa);
    }

    public function getResumen(Request $request){        

     
    }
}
