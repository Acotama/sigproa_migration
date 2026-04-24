<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use sayhuite\Models\ContratacionesPS;

class ContratacionesController extends Controller
{
    public function inicio()
    {
      $fecha = ContratacionesPS::max('fecha_act');
      $anio = ContratacionesPS::select(DB::raw("extract(year from fec_convocatoria) as anio"))
      ->groupBy(DB::raw("extract(year from fec_convocatoria)"))
      ->orderBy(DB::raw("extract(year from fec_convocatoria)"),"desc")->get();
      return View('contratatacionesPS.procedimientocs',['fecha' => $fecha,'anio' => $anio]);
    }

    public function data(Request $request)
    {
      $input = $request->all();
      $fecha = ContratacionesPS::max('fecha_act');
      if ($input['filtro']=='EJECUTORA') {
        $filtro = ContratacionesPS::select(DB::raw("grli_pip_total_priori.ger_direc as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->groupBy("ger_direc")->orderBy("total","desc")->get();
      }
      elseif($input['filtro']=='TIPO') {
        $filtro = ContratacionesPS::select(DB::raw("objeto_contratac as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->groupBy("objeto_contratac")->orderBy("total","desc")->get();
      }
      elseif($input['filtro']=='ESTADO') {
        $filtro = ContratacionesPS::select(DB::raw("estado as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->groupBy("estado")->orderBy("total","desc")->get();
      }
      elseif($input['filtro']=='PROYECTO') {
        $filtro = ContratacionesPS::select(DB::raw("grli_pip_total_priori.cod_unif || ' : ' || grli_pip_total_priori.nom_proyec as categoria,max(pim_dia_anio_ant) as pim_dia_anio_ant,max(dev_dia_anio_ant) as dev_dia_anio_ant,max(pim_dia_anio_act) as pim_dia_anio_act,max(dev_dia_anio_act) as dev_dia_anio_act,
        count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_act,dev_dia as dev_dia_anio_act from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now())))::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now())))::text) as py_anio_act"),"py_anio_act.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_ant,dev_dia as dev_dia_anio_ant from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now()))-1)::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now()))-1)::text) as py_anio_ant"),"py_anio_ant.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->groupBy("categoria")->orderBy("total","desc")->get();
      }

      return Response([
        'filtro' => $filtro
      ]);
    }

    public function show(Request $request)
    {
      $input = $request->all();
      $fecha = ContratacionesPS::max('fecha_act');
      if($input['categoria'] == 'EJECUTORA'){
        $consulta_ejecutora = null;

        $consulta_tipo = ContratacionesPS::select(DB::raw("objeto_contratac as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("ger_direc",$input['filtro'])
        ->groupBy("objeto_contratac")->orderBy("total","desc")->get();

        $consulta_estado = ContratacionesPS::select(DB::raw("contratacionesps.estado as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("ger_direc",$input['filtro'])
        ->groupBy("contratacionesps.estado")->orderBy("total","desc")->get();

        $consulta_proyecto = ContratacionesPS::select(DB::raw("grli_pip_total_priori.cod_unif || ' : ' || grli_pip_total_priori.nom_proyec as categoria,max(pim_dia_anio_ant) as pim_dia_anio_ant,max(dev_dia_anio_ant) as dev_dia_anio_ant,max(pim_dia_anio_act) as pim_dia_anio_act,max(dev_dia_anio_act) as dev_dia_anio_act,
        count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_act,dev_dia as dev_dia_anio_act from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now())))::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now())))::text) as py_anio_act"),"py_anio_act.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_ant,dev_dia as dev_dia_anio_ant from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now()))-1)::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now()))-1)::text) as py_anio_ant"),"py_anio_ant.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("ger_direc",$input['filtro'])
        ->groupBy("categoria")->orderBy("total","desc")->get();

        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,contratacionesps.estado,valor_refer"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("ger_direc",$input['filtro'])
        ->orderBy("valor_refer","desc")->get();
      }
      elseif ($input['categoria'] == 'TIPO') {
        $consulta_tipo = null;

        $consulta_ejecutora = ContratacionesPS::select(DB::raw("grli_pip_total_priori.ger_direc as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("objeto_contratac",$input['filtro'])
        ->groupBy("ger_direc")->orderBy("total","desc")->get();

        $consulta_estado = ContratacionesPS::select(DB::raw("contratacionesps.estado as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("objeto_contratac",$input['filtro'])
        ->groupBy("contratacionesps.estado")->orderBy("total","desc")->get();

        $consulta_proyecto = ContratacionesPS::select(DB::raw("grli_pip_total_priori.cod_unif || ' : ' || grli_pip_total_priori.nom_proyec as categoria,max(pim_dia_anio_ant) as pim_dia_anio_ant,max(dev_dia_anio_ant) as dev_dia_anio_ant,max(pim_dia_anio_act) as pim_dia_anio_act,max(dev_dia_anio_act) as dev_dia_anio_act,
        count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_act,dev_dia as dev_dia_anio_act from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now())))::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now())))::text) as py_anio_act"),"py_anio_act.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_ant,dev_dia as dev_dia_anio_ant from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now()))-1)::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now()))-1)::text) as py_anio_ant"),"py_anio_ant.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("objeto_contratac",$input['filtro'])
        ->groupBy("categoria")->orderBy("total","desc")->get();

        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,estado,valor_refer"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("objeto_contratac",$input['filtro'])
        ->orderBy("valor_refer","desc")->get();
      }
      elseif ($input['categoria'] == 'ESTADO') {
        $consulta_estado = null;

        $consulta_ejecutora = ContratacionesPS::select(DB::raw("grli_pip_total_priori.ger_direc as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("contratacionesps.estado",$input['filtro'])
        ->groupBy("ger_direc")->orderBy("total","desc")->get();

        $consulta_tipo = ContratacionesPS::select(DB::raw("objeto_contratac as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("contratacionesps.estado",$input['filtro'])
        ->groupBy("objeto_contratac")->orderBy("total","desc")->get();

        $consulta_proyecto = ContratacionesPS::select(DB::raw("grli_pip_total_priori.cod_unif || ' : ' || grli_pip_total_priori.nom_proyec as categoria,max(pim_dia_anio_ant) as pim_dia_anio_ant,max(dev_dia_anio_ant) as dev_dia_anio_ant,max(pim_dia_anio_act) as pim_dia_anio_act,max(dev_dia_anio_act) as dev_dia_anio_act,
        count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_act,dev_dia as dev_dia_anio_act from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now())))::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now())))::text) as py_anio_act"),"py_anio_act.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->leftjoin(DB::raw("(select cod_unif,pim_dia as pim_dia_anio_ant,dev_dia as dev_dia_anio_ant from grli_pip_seguimiento_ejecucion_financiera where fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera where anio=(extract(year from (select now()))-1)::text) 
        and fuente_financiamiento is null and anio=(extract(year from (select now()))-1)::text) as py_anio_ant"),"py_anio_ant.cod_unif",DB::raw("contratacionesps.cod_unico::text"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("contratacionesps.estado",$input['filtro'])
        ->groupBy("categoria")->orderBy("total","desc")->get();

        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,estado,valor_refer"))
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("contratacionesps.estado",$input['filtro'])
        ->orderBy("valor_refer","desc")->get();
      }
      elseif ($input['categoria'] == 'PROYECTO') {
        $consulta_proyecto = null;

        $consulta_ejecutora = ContratacionesPS::select(DB::raw("grli_pip_total_priori.ger_direc as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("cod_unico",trim(explode(":",$input['filtro'])[0]))
        ->groupBy("ger_direc")->orderBy("total","desc")->get();

        $consulta_tipo = ContratacionesPS::select(DB::raw("objeto_contratac as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("cod_unico",trim(explode(":",$input['filtro'])[0]))
        ->groupBy("objeto_contratac")->orderBy("total","desc")->get();

        $consulta_estado = ContratacionesPS::select(DB::raw("contratacionesps.estado as categoria,count(*) as n_proce,sum(valor_refer) as total"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("cod_unico",trim(explode(":",$input['filtro'])[0]))
        ->groupBy("contratacionesps.estado")->orderBy("total","desc")->get();

        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,contratacionesps.estado,valor_refer"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("cod_unico",trim(explode(":",$input['filtro'])[0]))
        ->orderBy("valor_refer","desc")->get();
      }
      
      return view('contratatacionesPS.show')->with(
        [
            'categoria'  => $input['categoria'],
            'filtro'  => $input['filtro'],
            'anio'  => $input['anio'],
            'consulta_ejecutora' => $consulta_ejecutora,
            'consulta_tipo' => $consulta_tipo,
            'consulta_estado' => $consulta_estado,
            'consulta_proyecto' => $consulta_proyecto,
            'consulta_contrataciones' => $consulta_contrataciones
        ]
      )->render();
    }

    public function showpry(Request $request)
    {
      $input = $request->all();
      $fecha = ContratacionesPS::max('fecha_act');
      
      if($input['f_categoria'] == 'EJECUTORA'){

        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,contratacionesps.estado,valor_refer"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("ger_direc",$input['f_filtro'])
        ->where($input['categoria'],$input['filtro'])
        ->orderBy("valor_refer","desc")->get();

      }
      elseif ($input['f_categoria'] == 'TIPO') {

        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,contratacionesps.estado,valor_refer"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("objeto_contratac",$input['f_filtro'])
        ->where($input['categoria'],$input['filtro'])
        ->orderBy("valor_refer","desc")->get();

      }
      elseif ($input['f_categoria'] == 'ESTADO') {
        
        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,contratacionesps.estado,valor_refer"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("contratacionesps.estado",$input['f_filtro'])
        ->where($input['categoria'],$input['filtro'])
        ->orderBy("valor_refer","desc")->get();

      }
      elseif ($input['f_categoria'] == 'PROYECTO') {
        
        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,contratacionesps.estado,valor_refer"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->whereIn(DB::raw("extract(year from fec_convocatoria)"), $input['anio'] == 'Todas' ? array(DB::raw("select distinct extract(year from fec_convocatoria) from  contratacionesps")) : array($input['anio']))
        ->where("cod_unico",trim(explode(":",$input['f_filtro'])[0]))
        ->where($input['categoria'],$input['filtro'])
        ->orderBy("valor_refer","desc")->get();

      }

      return view('contratatacionesPS.showproyecto')->with(
          [
              'f_categoria'  => $input['f_categoria'],
              'f_filtro'  => $input['f_filtro'],
              'categoria'  => $input['categoria'],
              'filtro'  => $input['filtro'],
              'anio'  => $input['anio'],
              'consulta_contrataciones' => $consulta_contrataciones
          ]
      )->render();
    }
}

