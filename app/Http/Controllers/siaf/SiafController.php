<?php

namespace sayhuite\Http\Controllers\siaf;

use Illuminate\Http\Request;
use sayhuite\Http\Controllers\Controller;
// use sayhuite\siaf\db_siaf;
use sayhuite\Models\ejecucion_financiera;
use DB;

class SiafController extends Controller
{
    public function inicio(Request $request)
    {
      return View('siaf.devengados');
    }

    public function ejecucionmeta_proyecto(Request $request){
      $input = $request->all();
      $mes = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
      if($input['pliego'] == "TODOS"){
        $data = DB::select("select vw_pry_dev_proyectos.*,
        case when m_enero is null then 0 else m_enero end as m_enero,
        case when m_febrero is null then 0 else m_febrero end as m_febrero,
        case when m_marzo is null then 0 else m_marzo end as m_marzo,
        case when m_abril is null then 0 else m_abril end as m_abril,
        case when m_mayo is null then 0 else m_mayo end as m_mayo,
        case when m_junio is null then 0 else m_julio end as m_julio,
        case when m_julio is null then 0 else m_enero end as m_enero,
        case when m_agosto is null then 0 else m_agosto end as m_agosto,
        case when m_setiembre is null then 0 else m_setiembre end as m_setiembre,
        case when m_octubre is null then 0 else m_octubre end as m_octubre,
        case when m_noviembre is null then 0 else m_noviembre end as m_noviembre,
        case when m_diciembre is null then 0 else m_diciembre end as m_diciembre,
        (pim_dia - certificacion_dia) as por_certificar
        from vw_pry_dev_proyectos
        left join (select * from meta_mef_proyecto where anio = date_part('year'::text, now())
        and fecha_subida =(select max(fecha_subida) from meta_mef_proyecto where anio = date_part('year'::text, now()))) as meta_mef_proyecto 
        on vw_pry_dev_proyectos.anio=meta_mef_proyecto.anio::text and vw_pry_dev_proyectos.cod_unif=meta_mef_proyecto.codigo_unico  order by " . $mes[(intval($input['mes']) - 1)]. " desc");
      }else{
        $data = DB::select("select vw_pry_dev_proyectos.*,
        case when m_enero is null then 0 else m_enero end as m_enero,
        case when m_febrero is null then 0 else m_febrero end as m_febrero,
        case when m_marzo is null then 0 else m_marzo end as m_marzo,
        case when m_abril is null then 0 else m_abril end as m_abril,
        case when m_mayo is null then 0 else m_mayo end as m_mayo,
        case when m_junio is null then 0 else m_julio end as m_julio,
        case when m_julio is null then 0 else m_enero end as m_enero,
        case when m_agosto is null then 0 else m_agosto end as m_agosto,
        case when m_setiembre is null then 0 else m_setiembre end as m_setiembre,
        case when m_octubre is null then 0 else m_octubre end as m_octubre,
        case when m_noviembre is null then 0 else m_noviembre end as m_noviembre,
        case when m_diciembre is null then 0 else m_diciembre end as m_diciembre,
        (pim_dia - certificacion_dia) as por_certificar
        from vw_pry_dev_proyectos
        left join (select * from meta_mef_proyecto where anio = date_part('year'::text, now())
        and fecha_subida =(select max(fecha_subida) from meta_mef_proyecto where anio = date_part('year'::text, now()))) as meta_mef_proyecto 
        on vw_pry_dev_proyectos.anio=meta_mef_proyecto.anio::text and vw_pry_dev_proyectos.cod_unif=meta_mef_proyecto.codigo_unico
        where ger_direc not in ('DIRECCION REGIONAL DE AGRICULTURA','GERENCIA SUB REGIONAL LIMA SUR')  order by " . $mes[(intval($input['mes']) - 1)]. " desc");
      }
  
      $fecha_financiera = ejecucion_financiera::select('fecha')
      ->where("fecha", "=", DB::raw("(SELECT MAX(fecha) FROM grli_pip_seguimiento_ejecucion_financiera)"))
      ->groupBy("fecha")->first();

      return Response([
        'data' => $data,
        'fecha' => $fecha_financiera
      ]);
    }

    public function ejecucionmeta_proyecto_siaf(Request $request){
      $input = $request->all();
      $mes = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
      $data = DB::select("select vw_pry_dev_proyectos_siaf.*,
        case when m_enero is null then 0 else m_enero end as m_enero,
        case when m_febrero is null then 0 else m_febrero end as m_febrero,
        case when m_marzo is null then 0 else m_marzo end as m_marzo,
        case when m_abril is null then 0 else m_abril end as m_abril,
        case when m_mayo is null then 0 else m_mayo end as m_mayo,
        case when m_junio is null then 0 else m_julio end as m_julio,
        case when m_julio is null then 0 else m_enero end as m_enero,
        case when m_agosto is null then 0 else m_agosto end as m_agosto,
        case when m_setiembre is null then 0 else m_setiembre end as m_setiembre,
        case when m_octubre is null then 0 else m_octubre end as m_octubre,
        case when m_noviembre is null then 0 else m_noviembre end as m_noviembre,
        case when m_diciembre is null then 0 else m_diciembre end as m_diciembre,
        (pim_dia - certificacion_dia) as por_certificar
        from vw_pry_dev_proyectos_siaf
        left join (select * from meta_mef_proyecto where anio = date_part('year'::text, now())
        and fecha_subida =(select max(fecha_subida) from meta_mef_proyecto where anio = date_part('year'::text, now()))) as meta_mef_proyecto 
        on vw_pry_dev_proyectos_siaf.anio=meta_mef_proyecto.anio::text and vw_pry_dev_proyectos_siaf.cod_unif=meta_mef_proyecto.codigo_unico
        where ger_direc not in ('DIRECCION REGIONAL DE AGRICULTURA','GERENCIA SUB REGIONAL LIMA SUR')  order by " . $mes[(intval($input['mes']) - 1)]. " desc");
        $fecha = DB::table("siaf_logs")->max("fecha");
        return Response([
          'data' => $data,
          'fecha' => date("Y-m-d H:i",strtotime($fecha))
        ]);
    }

    public function show(Request $request){
      $input = $request->all();

      $data_pry = DB::select("select * from vw_grli_pip_seguimiento_ejecucion_financiera");
      $data_dev = DB::select("select grli_pip_total_priori.cod_unif,EXTRACT(MONTH FROM fecha_auto) as mes,sum(siaf_expediente_meta_c.monto) as monto,siaf_expediente_meta_c.sec_func from siaf_expediente_meta_c 
      inner join (select * from siaf_expediente_secuencia_c where ano_eje='2022') as siaf_expediente_secuencia_c on siaf_expediente_meta_c.expediente = siaf_expediente_secuencia_c.expediente 
      and siaf_expediente_meta_c.secuencia =siaf_expediente_secuencia_c.secuencia 
      and siaf_expediente_meta_c.correlativ =siaf_expediente_secuencia_c.correlativ 
      inner join siaf_meta_c on siaf_expediente_meta_c.sec_func = siaf_meta_c.sec_func and siaf_meta_c.sec_ejec in ('001027')
      inner join grli_pip_total_priori on siaf_meta_c.act_proy = grli_pip_total_priori.cod_unif
      where  cod_unif ='".$input['filtro']."'
      and siaf_expediente_meta_c.fase ='D' and siaf_expediente_meta_c.ano_eje='2022'
      group by EXTRACT(MONTH FROM fecha_auto),siaf_expediente_meta_c.sec_func,grli_pip_total_priori.cod_unif,grli_pip_total_priori.nom_proyec
      order by cod_unif,EXTRACT(MONTH FROM fecha_auto)");
      
      $data_dev = json_encode($data_dev); 
      $data_dev = json_decode($data_dev,1);  

      $fecha = DB::table("siaf_logs")->max("fecha");
      // in (select cod_unif from vw_grli_pip_seguimiento_ejecucion_financiera)
      // $items_pry= [];
      // foreach ($data_pry as $items){
      //   $ID = $items->cod_unif;
      //   $result = array_filter($data_dev, function ($var) use ($ID) {
      //       return ($var['cod_unif'] == $ID);
      //   });
      //   if (count($result)>0){
      //     // $result = json_encode($result); 
      //     $items_pry[$items->cod_unif] = array("proyecto" => $items, "devengado"=>$result);
      //   }
      // }
      return view('siaf.modal.show')->with(
        [
          'data_dev' => $data_dev,
          'data_pry' => $data_pry,
          'fecha' => date("Y-m-d H:i",strtotime($fecha))
        ]
        )->render();
    }

    public function ejecucionmeta_uei(Request $request){
      $input = $request->all();
      $mes = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
      if($input['pliego'] == "TODOS"){
        $data = DB::select("select count(cod_unif) as n_proy,ger_direc,sum(pim_dia) as pim_dia,sum(certificacion_dia) as certificacion_dia,sum(dev_dia) as dev_dia,sum(dif_dev_dia) as dif_dev_dia,sum(enero) as enero,SUM(febrero) as febrero,SUM(marzo) as marzo,SUM(abril) as abril,SUM(mayo) as mayo,SUM(junio) as junio,SUM(julio) as julio,SUM(agosto) as agosto,SUM(septiembre) as septiembre,SUM(octubre) as octubre,SUM(noviembre) as noviembre,SUM(diciembre) as diciembre,SUM(mes_actual) as mes_actual,SUM(dev_ant) as dev_ant,
        case when sum(m_enero) is null then 0 else sum(m_enero) end as m_enero,
        case when sum(m_febrero) is null then 0 else sum(m_febrero) end as m_febrero,
        case when sum(m_marzo) is null then 0 else sum(m_marzo) end as m_marzo,
        case when sum(m_abril) is null then 0 else sum(m_abril) end as m_abril,
        case when sum(m_mayo) is null then 0 else sum(m_mayo) end as m_mayo,
        case when sum(m_junio) is null then 0 else sum(m_julio) end as m_julio,
        case when sum(m_julio) is null then 0 else sum(m_enero) end as m_enero,
        case when sum(m_agosto) is null then 0 else sum(m_agosto) end as m_agosto,
        case when sum(m_setiembre) is null then 0 else sum(m_setiembre) end as m_setiembre,
        case when sum(m_octubre) is null then 0 else sum(m_octubre) end as m_octubre,
        case when sum(m_noviembre) is null then 0 else sum(m_noviembre) end as m_noviembre,
        case when sum(m_diciembre) is null then 0 else sum(m_diciembre) end as m_diciembre,
        (sum(pim_dia) - sum(certificacion_dia)) as por_certificar,
        round(sum(dev_dia) / sum(pim_dia) * 100::numeric, 1) AS a_fisico,
        case
          when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
          when ger_direc in ('LIQUIDACION DE OBRAS')  then 2
          when ger_direc in ('INICIATIVA A LA COMPETITIVIDAD') then 3
          when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
          when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
          when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
          when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
          when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
          when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
          when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
          when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
          when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
          else 0 end as  orden
        from vw_pry_dev_proyectos
        left join (select * from meta_mef_proyecto where anio = date_part('year'::text, now())
        and fecha_subida =(select max(fecha_subida) from meta_mef_proyecto where anio = date_part('year'::text, now()))) as meta_mef_proyecto 
        on vw_pry_dev_proyectos.anio=meta_mef_proyecto.anio::text and vw_pry_dev_proyectos.cod_unif=meta_mef_proyecto.codigo_unico
        group by ger_direc order by orden," . $mes[(intval($input['mes']) - 1)]. " desc");
      }else{
        $data = DB::select("select count(cod_unif) as n_proy,ger_direc,sum(pim_dia) as pim_dia,sum(certificacion_dia) as certificacion_dia,sum(dev_dia) as dev_dia,sum(dif_dev_dia) as dif_dev_dia,sum(enero) as enero,SUM(febrero) as febrero,SUM(marzo) as marzo,SUM(abril) as abril,SUM(mayo) as mayo,SUM(junio) as junio,SUM(julio) as julio,SUM(agosto) as agosto,SUM(septiembre) as septiembre,SUM(octubre) as octubre,SUM(noviembre) as noviembre,SUM(diciembre) as diciembre,SUM(mes_actual) as mes_actual,SUM(dev_ant) as dev_ant,
        case when sum(m_enero) is null then 0 else sum(m_enero) end as m_enero,
        case when sum(m_febrero) is null then 0 else sum(m_febrero) end as m_febrero,
        case when sum(m_marzo) is null then 0 else sum(m_marzo) end as m_marzo,
        case when sum(m_abril) is null then 0 else sum(m_abril) end as m_abril,
        case when sum(m_mayo) is null then 0 else sum(m_mayo) end as m_mayo,
        case when sum(m_junio) is null then 0 else sum(m_julio) end as m_julio,
        case when sum(m_julio) is null then 0 else sum(m_enero) end as m_enero,
        case when sum(m_agosto) is null then 0 else sum(m_agosto) end as m_agosto,
        case when sum(m_setiembre) is null then 0 else sum(m_setiembre) end as m_setiembre,
        case when sum(m_octubre) is null then 0 else sum(m_octubre) end as m_octubre,
        case when sum(m_noviembre) is null then 0 else sum(m_noviembre) end as m_noviembre,
        case when sum(m_diciembre) is null then 0 else sum(m_diciembre) end as m_diciembre,
        (sum(pim_dia) - sum(certificacion_dia)) as por_certificar,
        round(sum(dev_dia) / sum(pim_dia) * 100::numeric, 1) AS a_fisico,
        case
          when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
          when ger_direc in ('LIQUIDACION DE OBRAS')  then 2
          when ger_direc in ('INICIATIVA A LA COMPETITIVIDAD') then 3
          when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
          when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
          when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
          when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
          when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
          when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
          when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
          when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
          when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
          else 0 end as  orden
        from vw_pry_dev_proyectos
        left join (select * from meta_mef_proyecto where anio = date_part('year'::text, now())
        and fecha_subida =(select max(fecha_subida) from meta_mef_proyecto where anio = date_part('year'::text, now()))) as meta_mef_proyecto 
        on vw_pry_dev_proyectos.anio=meta_mef_proyecto.anio::text and vw_pry_dev_proyectos.cod_unif=meta_mef_proyecto.codigo_unico
        where ger_direc not in ('DIRECCION REGIONAL DE AGRICULTURA','GERENCIA SUB REGIONAL LIMA SUR')
        group by ger_direc order by orden," . $mes[(intval($input['mes']) - 1)]. " desc");
      }
      
      $fecha_financiera = ejecucion_financiera::select('fecha')
      ->where("fecha", "=", DB::raw("(SELECT MAX(fecha) FROM grli_pip_seguimiento_ejecucion_financiera)"))
      ->groupBy("fecha")->first();

      return Response([
        'data' => $data,
        'fecha' => $fecha_financiera
      ]);
    }

    public function ejecucionmeta_uei_siaf(Request $request){
      $input = $request->all();
      $mes = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
      $data = DB::select("select count(cod_unif) as n_proy,ger_direc,sum(pim_dia) as pim_dia,sum(certificacion_dia) as certificacion_dia,sum(dev_dia) as dev_dia,sum(dif_dev_dia) as dif_dev_dia,sum(enero) as enero,SUM(febrero) as febrero,SUM(marzo) as marzo,SUM(abril) as abril,SUM(mayo) as mayo,SUM(junio) as junio,SUM(julio) as julio,SUM(agosto) as agosto,SUM(septiembre) as septiembre,SUM(octubre) as octubre,SUM(noviembre) as noviembre,SUM(diciembre) as diciembre,SUM(dev_ant) as dev_ant,
      case when sum(m_enero) is null then 0 else sum(m_enero) end as m_enero,
      case when sum(m_febrero) is null then 0 else sum(m_febrero) end as m_febrero,
      case when sum(m_marzo) is null then 0 else sum(m_marzo) end as m_marzo,
      case when sum(m_abril) is null then 0 else sum(m_abril) end as m_abril,
      case when sum(m_mayo) is null then 0 else sum(m_mayo) end as m_mayo,
      case when sum(m_junio) is null then 0 else sum(m_julio) end as m_julio,
      case when sum(m_julio) is null then 0 else sum(m_enero) end as m_enero,
      case when sum(m_agosto) is null then 0 else sum(m_agosto) end as m_agosto,
      case when sum(m_setiembre) is null then 0 else sum(m_setiembre) end as m_setiembre,
      case when sum(m_octubre) is null then 0 else sum(m_octubre) end as m_octubre,
      case when sum(m_noviembre) is null then 0 else sum(m_noviembre) end as m_noviembre,
      case when sum(m_diciembre) is null then 0 else sum(m_diciembre) end as m_diciembre,
      (sum(pim_dia) - sum(certificacion_dia)) as por_certificar,
      round(sum(dev_dia) / sum(pim_dia) * 100::numeric, 1) AS a_fisico,
      case
       when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
       when ger_direc in ('LIQUIDACION DE OBRAS')  then 2
       when ger_direc in ('INICIATIVA A LA COMPETITIVIDAD') then 3
       when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
       when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
       when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
       when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
       when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
       when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
       when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
       when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
       when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
       else 0 end as  orden
      from vw_pry_dev_proyectos_siaf
      left join (select * from meta_mef_proyecto where anio = date_part('year'::text, now())
      and fecha_subida =(select max(fecha_subida) from meta_mef_proyecto where anio = date_part('year'::text, now()))) as meta_mef_proyecto 
      on vw_pry_dev_proyectos_siaf.anio=meta_mef_proyecto.anio::text and vw_pry_dev_proyectos_siaf.cod_unif=meta_mef_proyecto.codigo_unico
      where ger_direc not in ('DIRECCION REGIONAL DE AGRICULTURA','GERENCIA SUB REGIONAL LIMA SUR') 
      group by ger_direc order by orden," . $mes[(intval($input['mes']) - 1)]. " desc");
      $fecha = DB::table("siaf_logs")->max("fecha");
      return Response([
        'data' => $data,
        'fecha' => date("Y-m-d H:i",strtotime($fecha))
      ]);
    }
}



