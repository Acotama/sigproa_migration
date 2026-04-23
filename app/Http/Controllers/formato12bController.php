<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class formato12bController extends Controller
{
    public function inicio()
    {
      $fecha = DB::table("formato12b")->max('fecha_subida');
      return view('formato12b.formato12b')->with(['fecha' => $fecha]);
    }

    public function datos(Request $request)
    {
      $input = $request->all();
      if ($input['anio'] == '2026'){
        $formato12b = DB::table("vw_formato12b_proyecto")->get();
      }
      elseif(($input['anio'] == '2025')){
        
        $formato12b = DB::table("vw_formato12b_proyecto_anio_ant")->get();
      }
      
      return Response([
        'data' => $formato12b
      ]);
    }

    public function actualizacion_f12b(Request $request){
      $actualizacion_f12b = DB::select("select 
        (select count(*) from formato12b
        inner join grli_pip_total_priori on formato12b.cod_unif::text=grli_pip_total_priori.cod_unif
        where fecha_subida=(select max(fecha_subida) from formato12b) and tipo_formato!='FUR' and grli_pip_total_priori.m_pim > 0) as factibles,
        (select count(*) from formato12b
        inner join grli_pip_total_priori on formato12b.cod_unif::text=grli_pip_total_priori.cod_unif
        where fecha_subida=(select max(fecha_subida) from formato12b) and tipo_formato!='FUR' and grli_pip_total_priori.m_pim > 0 and fecha_actual is not null) as registrados,
        (select count(*) from formato12b
        inner join grli_pip_total_priori on formato12b.cod_unif::text=grli_pip_total_priori.cod_unif
        where fecha_subida=(select max(fecha_subida) from formato12b) and tipo_formato!='FUR' and grli_pip_total_priori.m_pim > 0 
        and fecha_actual is not null and fecha_actual >= (SELECT CAST((select NOW()) AS DATE) - CAST('30 days' AS INTERVAL))) as actualizados");

      return Response($actualizacion_f12b);
    }

    public function datos_f12b(Request $request)
    {
      $f12b=DB::select("select count(*) as total,formato12b.ger_direc,
        --Para factibilidad
        (select count(*) from vw_formato12b
                inner join vw_grli_pip_seguimiento_ejecucion_financiera on vw_formato12b.cod_unif::text = vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif and pim_dia!=0 
                where tipo_formato!='FUR' and vw_formato12b.ger_direc=formato12b.ger_direc) as factibles,
        --Actualizado y Real
        --Para factibilidad
        (select count(*) from vw_formato12b
                inner join vw_grli_pip_seguimiento_ejecucion_financiera on vw_formato12b.cod_unif::text = vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif and pim_dia!=0 
                where tipo_formato!='FUR' and fecha_actual is not null and  vw_formato12b.ger_direc=formato12b.ger_direc) as registrados,
        --Pim
        sum(pim_dia) as pim,
        sum(dev_dia) as dev_dia,
        round((sum(dev_dia)/sum(pim_dia))*100,1) as avance,
        --Actualizado y Real
        sum(a_enero) as a_enero,sum(a_febrero) as a_febrero,sum(a_marzo) as a_marzo,sum(a_abril) as a_abril,sum(a_mayo) as a_mayo,sum(a_junio) as a_junio,sum(a_julio) as a_julio,sum(a_agosto) as a_agosto,sum(a_setiembre) as a_setiembre,sum(a_octubre) as a_octubre,sum(a_noviembre) as a_noviembre,sum(a_diciembre) as a_diciembre,
        sum(enero) as enero,sum(febrero) as febrero,sum(marzo) as marzo,sum(abril) as abril,sum(mayo) as mayo,sum(junio) as junio,sum(julio) as julio,sum(agosto) as agosto,sum(septiembre) as septiembre,sum(octubre) as octubre,sum(noviembre) as noviembre,sum(diciembre) as diciembre,orden from vw_formato12b as formato12b
        left join (select 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' as ger_direc,etapa,'2016766' as cod_unif,sum(enero) as enero,sum(febrero) as febrero,sum(marzo) as marzo,sum(abril) as abril,sum(mayo) as mayo,sum(junio) as junio,sum(julio) as julio,sum(agosto) as agosto,sum(septiembre) as septiembre,sum(octubre) as octubre,sum(noviembre) as noviembre,sum(diciembre) as diciembre from vw_bi_inf_financiera where etapa='PROCOMPITE' group by ger_direc,etapa 
              union select * from  vw_bi_inf_financiera where etapa!='PROCOMPITE') as inf_financiera on formato12b.cod_unif::text = inf_financiera.cod_unif
        inner join (select 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' as ger_direc,sector,'2016766' as cod_unif,sum(pim_dia) as pim_dia,sum(dev_dia) as dev_dia from vw_grli_pip_seguimiento_ejecucion_financiera where sector='PROCOMPITE' and pim_dia > 0 group by ger_direc,sector
              union select ger_direc,sector,cod_unif,pim_dia,dev_dia from  vw_grli_pip_seguimiento_ejecucion_financiera where sector!='PROCOMPITE' and pim_dia > 0) as grli_pip_seguimiento_ejecucion_financiera on formato12b.cod_unif::text = grli_pip_seguimiento_ejecucion_financiera.cod_unif 
        group by formato12b.ger_direc,orden 
        union		   
        select count(*) as total,'TOTAL' as ger_direc,
        --Para factibilidad
        (select count(*) from vw_formato12b
                inner join vw_grli_pip_seguimiento_ejecucion_financiera on vw_formato12b.cod_unif::text = vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif and pim_dia!=0 
                where tipo_formato!='FUR') as factibles,
        --Actualizado y Real
        --Para factibilidad
        (select count(*) from vw_formato12b
                inner join vw_grli_pip_seguimiento_ejecucion_financiera on vw_formato12b.cod_unif::text = vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif and pim_dia!=0 
                where tipo_formato!='FUR' and fecha_actual is not null) as registrados,
        --Pim
        sum(pim_dia) as pim,
        sum(dev_dia) as dev_dia,
        round((sum(dev_dia)/sum(pim_dia))*100,1) as avance,
        --Actualizado y Real
        sum(a_enero) as a_enero,sum(a_febrero) as a_febrero,sum(a_marzo) as a_marzo,sum(a_abril) as a_abril,sum(a_mayo) as a_mayo,sum(a_junio) as a_junio,sum(a_julio) as a_julio,sum(a_agosto) as a_agosto,sum(a_setiembre) as a_setiembre,sum(a_octubre) as a_octubre,sum(a_noviembre) as a_noviembre,sum(a_diciembre) as a_diciembre,
        sum(enero) as enero,sum(febrero) as febrero,sum(marzo) as marzo,sum(abril) as abril,sum(mayo) as mayo,sum(junio) as junio,sum(julio) as julio,sum(agosto) as agosto,sum(septiembre) as septiembre,sum(octubre) as octubre,sum(noviembre) as noviembre,sum(diciembre) as diciembre,15 from vw_formato12b as formato12b
        left join (select 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' as ger_direc,etapa,'2016766' as cod_unif,sum(enero) as enero,sum(febrero) as febrero,sum(marzo) as marzo,sum(abril) as abril,sum(mayo) as mayo,sum(junio) as junio,sum(julio) as julio,sum(agosto) as agosto,sum(septiembre) as septiembre,sum(octubre) as octubre,sum(noviembre) as noviembre,sum(diciembre) as diciembre from vw_bi_inf_financiera where etapa='PROCOMPITE' group by ger_direc,etapa 
              union select * from  vw_bi_inf_financiera where etapa!='PROCOMPITE') as inf_financiera on formato12b.cod_unif::text = inf_financiera.cod_unif
        inner join (select 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' as ger_direc,sector,'2016766' as cod_unif,sum(pim_dia) as pim_dia,sum(dev_dia) as dev_dia from vw_grli_pip_seguimiento_ejecucion_financiera where sector='PROCOMPITE' and pim_dia > 0 group by ger_direc,sector
              union select ger_direc,sector,cod_unif,pim_dia,dev_dia from  vw_grli_pip_seguimiento_ejecucion_financiera where sector!='PROCOMPITE' and pim_dia > 0) as grli_pip_seguimiento_ejecucion_financiera on formato12b.cod_unif::text = grli_pip_seguimiento_ejecucion_financiera.cod_unif  order by orden");

      return Response($f12b);
    }

    public function reporte(Request $request){
      $registro_formato12b = DB::select("select sum(case when registro_f12b = 'NO' then 1 else 0 end) as no_registro,
      sum(case when registro_f12b = 'SI' then 1 else 0 end) as registrados,
      sum(case when registro_f12b = 'SI' and actualizacion_f12b = 'NO' then 1 else 0 end) as no_actualizado,
      sum(case when registro_f12b = 'SI' and actualizacion_f12b = 'SI' then 1 else 0 end) as actualizados,fecha_subida from vw_reporte_formato12b
      group by fecha_subida");

      $registro_situacion_formato12b = DB::select("select sum(case when reg_situacion = 'NO' then 1 else 0 end) as no_reg_situacion,
      sum(case when reg_situacion = 'SI' then 1 else 0 end) as reg_situacion,
      sum(case when reg_situacion = 'SI' and act_situacion = 'NO' then 1 else 0 end) as no_actual_situacion,
      sum(case when reg_situacion = 'SI' and act_situacion = 'SI' then 1 else 0 end) as actual_situacion,fecha_subida from vw_reporte_formato12b where registro_f12b = 'SI'
      group by fecha_subida");

      $registro_factible_formato12b = DB::select("select sum(case when factible_reg = 'SI' then 1 else 0 end) as factible_reg,
      sum(case when factible_reg = 'SI' and reg_ava_eje = 'NO' then 1 else 0 end) as no_reg_ava_eje,
      sum(case when factible_reg = 'SI' and reg_ava_eje = 'SI'  then 1 else 0 end) as reg_ava_eje,
      sum(case when factible_reg = 'SI' and reg_ava_eje = 'SI' and act_ava_ejec = 'NO' then 1 else 0 end) as no_act_ava_ejec,
      sum(case when factible_reg = 'SI' and reg_ava_eje = 'SI' and act_ava_ejec = 'SI' then 1 else 0 end) as act_ava_ejec,fecha_subida from vw_reporte_formato12b where registro_f12b = 'SI'
      group by fecha_subida");

      $dif_a_fin_a_afis = DB::select("select sum(case when factible_reg = 'SI' then 1 else 0 end) as factible_reg,
      sum(case when factible_reg = 'SI' and dif_a_fin_a_afis = 'NO' then 1 else 0 end) as no_dif_a_fin_a_afis,
      sum(case when factible_reg = 'SI' and dif_a_fin_a_afis = 'SI'  then 1 else 0 end) as dif_a_fin_a_afis,
      sum(case when factible_reg = 'SI' and dif_a_fin_a_afis = 'NO APLICA'  then 1 else 0 end) as no_aplica,fecha_subida from vw_reporte_formato12b where registro_f12b = 'SI'
      group by fecha_subida");

      $et_nvo = DB::select("select count(*) as total, SUM(case when fec_program = 'SI' and fec_actualizada = 'SI' and estado_hito = 'SI' then 1 else 0 end) as cumplido,
      SUM(case when fec_program = 'NO' or fec_actualizada = 'NO' or estado_hito = 'NO' then 1 else 0 end) as no_cumplido
      from tb_expediente_tecnico where tipo = 'NVO' and fecha_subida = (select max(fecha_subida)from tb_expediente_tecnico) and resumen = 'SI'");

      $et_ant = DB::select("select count(*) as total, SUM(case when fec_program = 'SI' and fec_actualizada = 'SI' and fec_final = 'SI' then 1 else 0 end) as cumplido,
      SUM(case when fec_program = 'NO' or fec_actualizada = 'NO' or fec_final = 'NO' then 1 else 0 end) as no_cumplido
      from tb_expediente_tecnico where tipo = 'ANT' and fecha_subida = (select max(fecha_subida)from tb_expediente_tecnico) and resumen = 'SI'");

      // dd($et_ant[0]);

      return view('formato12b.reporteformato12b')->with([
        'dif_a_fin_a_afis' => $dif_a_fin_a_afis[0],
        'registro_factible_formato12b' => $registro_factible_formato12b[0],
        'registro_situacion_formato12b' => $registro_situacion_formato12b[0],
        'registro_formato12b' => $registro_formato12b[0],
        'et_nvo' => $et_nvo[0],
        'et_ant' => $et_ant[0]
      ]);
    }

    public function showpry(Request $request){
      $input = $request->all();
      $fecha = DB::select("select max(fecha_subida) as fecha from vw_reporte_formato12b");
      if ($input['filtro'] == 'no_registro'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim from vw_reporte_formato12b where registro_f12b='NO'");
        $titulo = "N° inversiones pendiente de registro del F12B";
      }elseif($input['filtro'] == 'no_actualizado'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim from vw_reporte_formato12b where registro_f12b='SI' and actualizacion_f12b='NO'");
        $titulo = "N° inversiones con registro del F12B No Actualizado";
      }elseif($input['filtro'] == 'no_reg_situacion'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim from vw_reporte_formato12b where registro_f12b='SI' and reg_situacion='NO'");
        $titulo = "N° inversiones pendientes de registro de situación";
      }elseif($input['filtro'] == 'no_actual_situacion'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim from vw_reporte_formato12b where registro_f12b='SI' and act_situacion='NO'");
        $titulo = "N° inversiones con registro de situación NO actualizado en el mes";
      }elseif($input['filtro'] == 'no_reg_ava_eje'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim from vw_reporte_formato12b where registro_f12b='SI' and factible_reg='SI' and reg_ava_eje='NO'");
        $titulo = "N° inversiones pendientes de registro de avance de ejecución";
      }elseif($input['filtro'] == 'no_act_ava_ejec'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim from vw_reporte_formato12b where registro_f12b='SI' and factible_reg='SI' and reg_ava_eje='SI' and act_ava_ejec='NO'");
        $titulo = "N° inversiones con registro de avance de ejecución NO actualizado en el mes";
      }elseif($input['filtro'] == 'dif_a_fin_a_afis'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim,dif_a_fin_a_afis_pro from vw_reporte_formato12b where registro_f12b='SI' and factible_reg='SI' and dif_a_fin_a_afis = 'SI' order by dif_a_fin_a_afis_pro");
        $titulo = "N° inversiones mayores al 60%";
      }elseif($input['filtro'] == 'no_dif_a_fin_a_afis'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim,dif_a_fin_a_afis_pro from vw_reporte_formato12b where registro_f12b='SI' and factible_reg='SI' and dif_a_fin_a_afis = 'NO' order by dif_a_fin_a_afis_pro");
        $titulo = "N° inversiones menores a 60%";
      }elseif($input['filtro'] == 'no_aplica'){
        $data = DB::select("select cod_unif,nom_proyec,ger_direc,pim_dia,dev_dia,a_financ_a,avance_fisico,fecha_actual,fecha_actual_situacion,fec_declara_estim,dif_a_fin_a_afis_pro from vw_reporte_formato12b where registro_f12b='SI' and factible_reg='SI' and dif_a_fin_a_afis = 'NO APLICA' order by a_financ_a");
        $titulo = "N° inversiones que no aplican menores al 10 % de avance acumulado";
      }
      
      return view('formato12b.modal.show')->with(
        [
          'titulo' => $titulo,
          'data' => $data,
          'fecha' => $fecha[0],
          'filtro' => $input['filtro']
        ]
        )->render();
    }

    public function showpryET(Request $request){
      $input = $request->all();
      $fecha = DB::select("select max(fecha_subida) as fecha from tb_expediente_tecnico");
      if($input['filtro'] == 'nvo'){
        if($input['cond'] == 'si'){
          $data = DB::select("select nom_proyec,* from tb_expediente_tecnico
          inner join vw_total_proyectos on tb_expediente_tecnico.codigo_unico::text  = vw_total_proyectos.cod_unif
          where tipo = 'NVO' and fecha_subida = (select max(fecha_subida)from tb_expediente_tecnico) and
          fec_program = 'SI' and fec_actualizada = 'SI' and estado_hito = 'SI' and resumen = 'SI'");
          $titulo = "ELABORACIÓN DEL ET - APROBACIÓN DEL ET - CUMPLIDOS";
        }else{
          $data = DB::select("select nom_proyec,* from tb_expediente_tecnico
          inner join vw_total_proyectos on tb_expediente_tecnico.codigo_unico::text  = vw_total_proyectos.cod_unif
          where tipo = 'NVO' and fecha_subida = (select max(fecha_subida)from tb_expediente_tecnico) and
          (fec_program = 'NO' or fec_actualizada = 'NO' or estado_hito = 'NO') and resumen = 'SI'");
          $titulo = "ELABORACIÓN DEL ET - APROBACIÓN DEL ET - NO CUMPLIDOS";
        }
      }elseif($input['filtro'] == 'ant'){
        if($input['cond'] == 'si'){
          $data = DB::select("select nom_proyec,* from tb_expediente_tecnico
          inner join vw_total_proyectos on tb_expediente_tecnico.codigo_unico::text  = vw_total_proyectos.cod_unif
          where tipo = 'ANT' and fecha_subida = (select max(fecha_subida) from tb_expediente_tecnico) and 
          fec_program = 'SI' and fec_actualizada = 'SI' and fec_final = 'SI' and resumen = 'SI'");
          $titulo = "ELABORACIÓN DE ET - APROBACIÓN - CUMPLIDOS";
        }else{
          $data = DB::select("select nom_proyec,* from tb_expediente_tecnico
          inner join vw_total_proyectos on tb_expediente_tecnico.codigo_unico::text  = vw_total_proyectos.cod_unif
          where tipo = 'ANT' and fecha_subida = (select max(fecha_subida) from tb_expediente_tecnico) and 
          (fec_program = 'NO' or fec_actualizada = 'NO' or fec_final = 'NO') and resumen = 'SI'");
          $titulo = "ELABORACIÓN DE ET - APROBACIÓN - NO CUMPLIDOS";
        }
      }

      return view('formato12b.modal.show_et')->with(
        [
          'titulo' => $titulo,
          'data' => $data,
          'fecha' => $fecha[0],
          'filtro' => $input['filtro']
        ]
        )->render();
    }

    public function showpryETDetalle(Request $request){

      $input = $request->all();
      $fecha = DB::select("select max(fecha_subida) as fecha from tb_expediente_tecnico");
      $proyecto = DB::table("vw_total_proyectos")->select(DB::raw("cod_unif || ' : ' || nom_proyec as nom_proyec"))
                  ->where("cod_unif",$input['codigo_unico'])->first();
      if($input['tipo'] == 'nvo'){
          $data = DB::select("select nom_proyec,* from tb_expediente_tecnico
          inner join vw_total_proyectos on tb_expediente_tecnico.codigo_unico::text  = vw_total_proyectos.cod_unif
          where tipo = 'NVO' and fecha_subida = (select max(fecha_subida)from tb_expediente_tecnico) and resumen = 'NO' and codigo_unico =". $input['codigo_unico']);
          $titulo = $proyecto->nom_proyec;
      }elseif($input['tipo'] == 'ant'){
        $data = DB::select("select nom_proyec,* from tb_expediente_tecnico
          inner join vw_total_proyectos on tb_expediente_tecnico.codigo_unico::text  = vw_total_proyectos.cod_unif
          where tipo = 'ANT' and fecha_subida = (select max(fecha_subida)from tb_expediente_tecnico) and resumen = 'NO' and codigo_unico =". $input['codigo_unico']);
          $titulo = $proyecto->nom_proyec;
      }

      return view('formato12b.modal.showpryETDetalle')->with(
        [
          'titulo' => $titulo,
          'data' => $data,
          'fecha' => $fecha[0],
          'filtro' => $input['tipo']
        ]
      )->render();
    }

    public function exportar(Request $request){
      $data = DB::select("select * from vw_reporte_formato12b");
      $fecha = DB::select("select max(fecha_subida) as fecha from vw_reporte_formato12b");
      return response()
        ->view("formato12b.template.reportef12b", ['data'=>$data,'fecha'=>$fecha[0]], 200)
        ->header('Content-Description', 'File Transfer')
        ->header('Content-Type', 'text/html; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename=REPORTE FORMATO 12-B.xls')
        ->header('Content-Transfer-Encoding', 'binary')
        ->header('Connection', 'Keep-Alive')
        ->header('Expires', '0')
        ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
        ->header('Pragma', 'public');
    }
}


