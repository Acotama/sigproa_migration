<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\Models\PipTotalPriori;
use sayhuite\Models\MantenimientoVia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $columns = [
        'nom_proyec' => 'Nombre del Proyecto',
        'cod_snip' => 'Código SNIP',
        'cod_unif' => 'Código Unificado',
        'nom_prov' => 'Nombre Provincia',
        'nom_dist' => 'Nombre Distrito',
        'nom_cp' => 'Nombre Centro Poblado',
        'u_formul' => 'Unidad Formuladora',
        'u_ejec' => 'Unidad Ejecutora',
        'ger_direc' => 'Gerencia/Dirección',
        'sector' => 'Sector',
        'progr' => 'Programa',
        'sub_progr' => 'Sub-Programa',
        'm_pip' => 'Monto PIP',
        'm_viab' => 'Monto Viable',
        'm_exptec' => 'Monto Expediente Técnico',
        'etapa' => 'Etapa',
        'sub_etapa' => 'Sub-Etapa',
        'est_pry' => 'Estado del Proyecto',
        'situa_pro' => 'Siatuación del proyecto',
        'f_etapsub' => 'Fecha de Estado',
        'cant_meta' => 'Cantidad de metas',
        'meta_actual' => 'Meta Actual',
        'm_pim' => 'PIM',
        'm_pim_acu' => 'PIM acumulado',
        'm_deveng' => 'Devengado',
        'm_deveng_a' => 'Devengado acumulado',
        'f_deveng_a' => 'Fecha de actualización Financiera',
        'f_adjudica' => 'Fecha Adjudicación',
        'm_ejec' => 'Monto Ejecutado',
        'nro_contrato' => 'Número de contrato',
        'f_i_obra' => 'Fecha Inicio de obra',
        'f_f_obra' => 'Fecha Fin de obra',
        't_ejec_dia' => 'Total ejecutado Diario',
        'a_fisico' => 'Avance Fisico',
        'f_afisico' => 'Fecha avance físico',
        'a_financ' => 'Avance Financiero',
        'anio_ini_pry' => 'Año del Proyecto',
        'anio_pic' => 'Año PIC',
        'estado_pic' => 'Estado del PIC',
        'tipo_pry' => 'Tipo de proyecto',
        'ult_anio_ejec_pry' => 'Ultimo año de ejecución del proyecto',
        'fech_reinico_obra' => 'Fecha de reinicio de obra',
        'nuev_fech_termino' => 'Nueva fecha de termino',
        'estado_antiguedad_pry' => 'Estado Antiguedad del proyecto',
        'tipo_ejec' => 'Tipo de Ejecución'
    ];

    public function index()
    {
        return view('export.index');
    }


    public function exportar($tipo)
    {
        $path = "export.template.$tipo";
        switch ($tipo) {
            case 'piptotalpriori_priorizados':
                $Proyectos  = PipTotalPriori::select([
                    'id',
                    'nom_proyec',
                    'cod_snip',
                    'cod_unif',
                    'nom_prov',
                    'a_fisico',
                    'ger_direc',
                    'f_etapsub',
                    'etapa',
                    'sub_etapa',
                    'situa_pro',
                    'ffoto_durante',
                    'ffoto_despues',
                    'tipo_pry'

                ])
                    ->where('grli_pip_total_priori.estado', '1')
                    ->where('estado_pic', '=', 'PRIORIZADO')
                    ->get();

                $data = $Proyectos;

                break;

            case (preg_match('/piptotalpriori.*/', $tipo) ? true : false):
                //$data = DB::table('vw_estado_situacional_proyecto')->where('id','!=','1000')->get();
                $dependencias = DB::table('dependencia')
                    ->join('usuario_dependencia', 'usuario_dependencia.iddependencia', '=', 'dependencia.iddependencia')
                    ->where('usuario_dependencia.idusuario', '=', Auth::user()->idusuario)
                    ->pluck('denom');

                $Proyectos  = PipTotalPriori::select([
                    'id',
                    'nom_proyec',
                    'cod_snip',
                    'cod_unif',
                    //'cod_dpto',
                    //'nom_dpto',
                    //'cod_prov',
                    'nom_prov',
                    //'cod_dist',
                    //'nom_dist',
                    //'u_formul',
                    //'u_ejec',
                    'ger_direc',
                    //'sector',
                    //'progr',
                    //'sub_progr',
                    //'m_pip',
                    //'m_viab',
                    //'m_exptec',
                    'etapa',
                    'sub_etapa',
                    //'m_pim',
                    //'m_pim_acu',
                    //'m_deveng',
                    //'m_deveng_a',
                    //'f_deveng_a',
                    //'f_adjudica',
                    //'t_ejec_dia',
                    //'a_fisico',
                    //'a_financ',
                    //'latitud',
                    //'longitud',
                    //'anio_ini_pry',
                    //'anio_pic',
                    //'mpp_pic',
                    //'macr_pic',
                    //'nacuerdo_pic',
                    //'mpia_pic',
                    //'estado_pic',
                    //'ffoto_antes',
                    'ffoto_durante',
                    'ffoto_despues',
                    'tipo_pry',
                    //'ult_anio_ejec_pry',
                    //'estado_antiguedad_pry',
                    //'beneficiarios',
                    //'a_financ_a',
                    //'tipo_ejecucion',
                    //'inaugurado',
                    //'f_inaugurado',
                    'ult_anio_ejec_pry_financ',
                    //'m_deveng_a_todas_ue',
                    //'m_pim_a_todas_ue',
                    //'obs',
                    //'marcas',
                    DB::raw('(select gse.tag from grli_sub_etapa gse where gse.etapa like grli_pip_total_priori.etapa and gse.sub_etapa like grli_pip_total_priori.sub_etapa limit 1) as etapa_main')
                    // DB::raw('(select gse.tag from grli_sub_etapa gse where gse.etapa like grli_pip_total_priori.etapa and gse.sub_etapa like grli_pip_total_priori.sub_etapa limit 1) as subetapa_main')
                ])
                    //->where('grli_pip_total_priori.ult_anio_ejec_pry_financ','2018')
                    ->where('grli_pip_total_priori.id', '!=', '1000')->orderBy('ult_anio_ejec_pry_financ', 'desc')->orderBy('ger_direc', 'desc')
                    // ->where('grli_pip_total_priori.estado','1')
                    // ->where('tipo_pry', '!=' ,'NO PIP')
                    //->where('estado_pic', '=' ,'PRIORIZADO')
                    //->where("ger_direc", '!=', '')
                    //->where("ger_direc", 'like', 'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES')
                    //->where("ger_direc", 'like', 'GERENCIA SUB REGIONAL LIMA SUR')
                    //->where("ger_direc", 'like', 'GERENCIA REGIONAL DE DESARROLLO SOCIAL')
                    //->where("ger_direc", 'like', 'GERENCIA REGIONAL DE INFRAESTRUCTURA')
                    //->where("ger_direc", 'like', 'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE')
                    //->whereIn("ger_direc", $dependencias)
                    //->limit(5)
                    ->get();

                $Proyectos->transform(function ($item, $key) {
                    $item['obras'] = DB::table("vw_grli_obra_list as go")
                        ->select([
                            'nro_meta',
                            'nom_meta',
                            'anio_ejec',
                            'mod_ejec',
                            'f_inicio',
                            'f_termino',
                            't_ejec_dias',
                            'f_reinicio',
                            'f_termino_nueva',
                            'f_inaug',
                            't_ejec_dias',
                            'est_situ',
                            'a_fisico',
                            'fecha_act',
                            'etapa',
                            'sub_etapa',
                            DB::raw('(select gse.tag from grli_sub_etapa gse where gse.etapa like go.etapa and gse.sub_etapa like go.sub_etapa limit 1) as etapa_main')
                        ])
                        ->where("idproyecto", $item->id)
                        ->orderBy('nro_meta', 'asc')
                        ->get();

                    /*$item['estado_proyecto'] = DB::table('grli_pip_total_priori_estado as gptpe')
                                        ->select([
                                            '*',
                                            DB::raw('(select gse.tag from grli_sub_etapa gse where gse.etapa like gptpe.etapa and gse.sub_etapa like gptpe.sub_etapa limit 1) as etapa_main')
                                            ])
                                        ->where('idproyecto',$item->id)
                                        ->orderBy('fecha_act','desc')
                                        ->where('estado',1)->first();*/
                    return $item;
                });

                $data = $Proyectos;
                break;

            case 'procompite':
                $data = DB::table('vw_grli_pip_procompite')
                    ->orderBy('anio')
                    ->where('id', '!=', '1000')
                    ->get();
                break;
            case 'canales':
                $data = DB::table('vw_grli_canales_nuevo')
                    ->orderBy('anio')
                    ->get();
                break;
            case 'vias':
                $data = MantenimientoVia::where('estado', '1')
                    ->orderBy('anio')
                    ->get();
                break;
        }

        return response()
            ->view($path, ['data' => $data], 200)
            ->header('Content-Description', 'File Transfer')
            //->header('Content-Type', 'text/html; charset=latin-1')
            ->header('Content-Type', 'text/html; charset=utf-8')
            //->header('charset=utf-8')

            ->header('Content-Disposition', 'attachment; filename=proyectos.xls')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Connection', 'Keep-Alive')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');

    }

    public function exportar_proyecto(Request $request)
    {
        $anio = (int)$request['anio'];
        $proyecto = collect(DB::select("select * from sp_proyecto(?)", [$anio]));


        return response()
            ->view("export.template.proyecto", ['data' => $proyecto, 'filtro' => $request['filtro'], 'anio' => $request['anio']], 200)
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=proyecto_' . $request['filtro'] . '.xls')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Connection', 'Keep-Alive')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');
    }

    public function exportar_pmi(Request $request)
    {

        $pmi = DB::table("vw_cartera_pmi")->get();

        return response()
            ->view("export.template.pmi", ['data' => $pmi, 'filtro' => $request['filtro']], 200)
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=pmi_' . $request['filtro'] . '.xls')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Connection', 'Keep-Alive')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');
    }

    public function exportar_proyecto_ff(Request $request)
    {
        $ff = DB::table("vwo_grli_pip_seguimiento_ejecucion_financiera_ff")->get();
        $ff_ger = DB::table("vwo_grli_pip_seguimiento_ejecucion_financiera_ff")->select(DB::RAW("ger_direc,fuente_financiamiento,ff,sum(pia_dia) as pia_dia,SUM(pim_dia) as pim_dia,SUM(certificacion_dia) as certificacion_dia,SUM(comp_anual_dia) as comp_anual_dia,SUM(ate_comp_anual_dia) as ate_comp_anual_dia,SUM(dev_dia) as dev_dia,SUM(girado_dia) as girado_dia"))
            ->groupBy("ger_direc")
            ->groupBy("fuente_financiamiento")
            ->groupBy("ff")
            ->orderBy("pim_dia", "desc")->get();
        $ff_total = DB::table("vwo_grli_pip_seguimiento_ejecucion_financiera_ff")->select(DB::RAW("sum(pia_dia) as pia_dia,SUM(pim_dia) as pim_dia,SUM(certificacion_dia) as certificacion_dia,SUM(comp_anual_dia) as comp_anual_dia,SUM(ate_comp_anual_dia) as ate_comp_anual_dia,SUM(dev_dia) as dev_dia,SUM(girado_dia) as girado_dia"))->get();

        return response()
            ->view("export.template.inversiones_ff", ['data' => $ff, 'data_ff' => $ff_ger, 'data_total' => $ff_total], 200)
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=INVERSIONES_FF.xls')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Connection', 'Keep-Alive')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');
    }

    public function reporte_diario(Request $request)
    {
        $data = DB::table("vw_pry_dev_ejecutoras_total")->select(DB::RAW("sum(cantida) as cantida,
            sum(pim_dia) as pim_dia,
            sum(certificacion_dia) as certificacion_dia,
            sum(dev_dia) as dev_dia,
            sum(dif_dev_dia) as dif_dev_dia,
            sum(girado_dia) as girado_dia,
            sum(a_fisico) as a_fisico,
            sum(enero) as enero,
            sum(febrero) as febrero,
            sum(marzo) as marzo,
            sum(abril) as abril,
            sum(mayo) as mayo,
            sum(junio) as junio,
            sum(julio) as julio,
            sum(agosto) as agosto,
            sum(septiembre) as septiembre,
            sum(octubre) as octubre,
            sum(noviembre) as noviembre,
            sum(diciembre) as diciembre,
            sum(comp_anual_dia) as comp_anual_dia,
            sum(ate_comp_anual_dia) as ate_comp_anual_dia,
            sum(dev_dia_real) as dev_dia_real,
            sum(mes_actual) as mes_actual,
            sum(dev_ant) as dev_ant,
            sum(pia_dia) as pia_dia,
            sum(m_enero) as m_enero,
            sum(m_febrero) as m_febrero,
            sum(m_marzo) as m_marzo,
            sum(m_abril) as m_abril,
            sum(m_mayo) as m_mayo,
            sum(m_junio) as m_junio,
            sum(m_julio) as m_julio,
            sum(m_agosto) as m_agosto,
            sum(m_setiembre) as m_setiembre,
            sum(m_octubre) as m_octubre,
            sum(m_noviembre) as m_noviembre,
            sum(m_diciembre) as m_diciembre"))
            ->leftJoin(DB::RAW("(select * from meta_mef where fecha_subida = (select max(fecha_subida) from meta_mef)) as meta_mef"), function ($join) {
                $join->on("vw_pry_dev_ejecutoras_total.anio", '=', DB::RAW("meta_mef.anio::text"))->on("vw_pry_dev_ejecutoras_total.ger_direc", '=', "direc_uei");
            })->first();

        $data_metas = DB::table("vw_pry_dev_ejecutoras_2")->select(DB::RAW("vw_pry_dev_ejecutoras_2.*,m_enero,m_febrero,m_marzo,m_abril,m_mayo,m_junio,m_julio,m_agosto,m_setiembre,m_octubre,m_noviembre,m_diciembre,
                cant_enero,cant_febrero,cant_marzo,cant_abril,cant_mayo,cant_junio,cant_julio,cant_agosto,cant_setiembre,cant_octubre,cant_noviembre,cant_diciembre,(pim_dia - certificacion_dia) as por_certificar,
                case
                when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
                when ger_direc in ('LIQUIDACION DE OBRAS') then 2
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
                else 0 end as  orden,m_enero - enero as pen_enero,m_febrero - febrero as pen_febrero,m_marzo - marzo as pen_marzo,
                m_abril - abril as pen_abril,m_mayo - mayo as pen_mayo,m_junio - junio as pen_junio,
                m_julio - julio as pen_julio,m_agosto - agosto as pen_agosto,m_setiembre - septiembre as pen_setiembre,
                m_octubre - octubre as pen_octubre,m_noviembre - noviembre as pen_noviembre,m_diciembre - diciembre as pen_diciembre"))
            ->leftJoin(DB::RAW("(select anio,ger_direc as direc_uei,sum(m_enero) as m_enero,sum(m_febrero) as m_febrero,sum(m_marzo) as m_marzo,sum(m_abril) as m_abril,sum(m_mayo) as m_mayo,sum(m_junio) as m_junio,
                sum(m_julio) as m_julio,sum(m_agosto) as m_agosto,sum(m_setiembre) as m_setiembre,sum(m_octubre) as m_octubre,sum(m_noviembre) as m_noviembre,sum(m_diciembre) as m_diciembre,
                sum(case when m_enero = 0 or m_enero is null then 0 else 1 end) as cant_enero,sum(case when m_febrero = 0 or m_febrero is null then 0 else 1 end) as cant_febrero,
                sum(case when m_marzo = 0 or m_marzo is null then 0 else 1 end) as cant_marzo,sum(case when m_abril = 0 or m_abril is null then 0 else 1 end) as cant_abril,
                sum(case when m_mayo = 0 or m_mayo is null then 0 else 1 end) as cant_mayo,sum(case when m_junio = 0 or m_junio is null then 0 else 1 end) as cant_junio,
                sum(case when m_julio = 0 or m_julio is null then 0 else 1 end) as cant_julio,sum(case when m_agosto = 0 or m_agosto is null then 0 else 1 end) as cant_agosto,
                sum(case when m_setiembre = 0 or m_setiembre is null then 0 else 1 end) as cant_setiembre,sum(case when m_octubre = 0 or m_octubre is null then 0 else 1 end) as cant_octubre,
                sum(case when m_noviembre = 0 or m_noviembre is null then 0 else 1 end) as cant_noviembre,sum(case when m_diciembre = 0 or m_diciembre is null then 0 else 1 end) as cant_diciembre
                from meta_mef_proyecto					
                inner join vw_total_proyectos on meta_mef_proyecto.codigo_unico = vw_total_proyectos.cod_unif 
                where fecha_subida = (select max(fecha_subida) from meta_mef_proyecto)
                group by anio,ger_direc) as meta_mef"), function ($join) {
                $join->on("vw_pry_dev_ejecutoras_2.anio", '=', DB::RAW("meta_mef.anio::text"))->on("vw_pry_dev_ejecutoras_2.ger_direc", '=', "direc_uei");
            })->orderBy('orden')->get();

        $data_dia = DB::table("vw_proyectos_diario")->select()->get();
        $data_hoy = DB::table("vw_proyectos_diario")->select()->where('fecha', DB::RAW("(select max(fecha) from vw_proyectos_diario)"))->orderBy("meta_mes", "desc")->orderBy("dev_mes", "desc")->get();
        $data_dev_acum = DB::table("vw_proyectos_diario_dev_acu")->select()->get();

        $resumen_pliego = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->select(DB::RAW("count(*) as cantidad,ger_direc,sum(pim_dia) as pim,sum(dev_dia) as dev_dia,case when sum(pim_dia)>0 then sum(dev_dia)*100/sum(pim_dia) else 0 end avance,
        sum(certificacion_dia) as certificado,case when sum(pim_dia)>0 then sum(certificacion_dia)*100/sum(pim_dia) else 0 end avance_certificado,
        case
            when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
            when ger_direc in ('LIQUIDACION DE OBRAS') then 2
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
        else 0 end as  orden"))->groupBy("ger_direc")->orderBy("orden")->get();

        $resumen_pliego_total = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->select(DB::RAW("count(*) as total_pry, sum(pim_dia) as pim,sum(dev_dia) as dev_dia,case when sum(pim_dia)>0 then sum(dev_dia)*100/sum(pim_dia) else 0 end avance,
        sum(certificacion_dia) as certificado,case when sum(pim_dia)>0 then sum(certificacion_dia)*100/sum(pim_dia) else 0 end avance_certificado"))
            ->first();

        $historial_mensual = DB::table("vw_bi_inf_financiera_2")->select(DB::RAW("sum(enero) AS enero, sum(febrero) AS febrero, sum(marzo) AS marzo, sum(abril) AS abril, sum(mayo) AS mayo,
        sum(junio) AS junio, sum(julio) AS julio, sum(agosto) AS agosto,
        sum(septiembre) AS septiembre, sum(octubre) AS octubre, sum(noviembre) AS noviembre, sum(diciembre) AS diciembre"))->first();

        $historial_mensual_meta = DB::table("meta_mef")->select(DB::RAW("'MEF' as info,sum(m_enero) as m_enero,sum(m_febrero) as m_febrero,sum(m_marzo) as m_marzo,sum(m_abril) as m_abril,sum(m_mayo) as m_mayo,
        sum(m_junio) as m_junio,sum(m_julio) as m_julio,sum(m_agosto) as m_agosto,sum(m_setiembre) as m_setiembre,sum(m_octubre) as m_octubre,
        sum(m_noviembre) as m_noviembre,sum(m_diciembre) as m_diciembre"))
            ->where("fecha_subida", "=", DB::RAW("(select max(fecha_subida) from meta_mef where anio=date_part('year'::text, now()))"))->first();

        $mef = DB::table("meta_mef")->select(DB::RAW("'MEF' as info,sum(m_enero) as m_enero,sum(m_febrero) as m_febrero,sum(m_marzo) as m_marzo,sum(m_abril) as m_abril,sum(m_mayo) as m_mayo,
        sum(m_junio) as m_junio,sum(m_julio) as m_julio,sum(m_agosto) as m_agosto,sum(m_setiembre) as m_setiembre,sum(m_octubre) as m_octubre,
        sum(m_noviembre) as m_noviembre,sum(m_diciembre) as m_diciembre"))
            ->where("fecha_subida", "=", DB::RAW("(select max(fecha_subida) from meta_mef where anio=date_part('year'::text, now()))"));

        $mefvs_formato12b = DB::table("vw_formato12b_proyecto")->select(DB::RAW("'FORMATO 12-B' as info,sum(a_enero) as a_enero,sum(a_febrero) as a_febrero,sum(a_marzo) as a_marzo,sum(a_abril) as a_abril,sum(a_mayo) as a_mayo,
        sum(a_junio) as a_junio,sum(a_julio) as a_julio,sum(a_agosto) as a_agosto,sum(a_setiembre) as a_setiembre,sum(a_octubre) as a_octubre,
        sum(a_noviembre) as a_noviembre,sum(a_diciembre) as a_diciembre"))
            ->union($mef)->get();

        $fecha = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->select(DB::RAW("max(fecha) as fecha"))->first();
        $fecha_acu = DB::table("vw_proyectos_diario_dev_acu")->select(DB::RAW("max(fecha_max) as fecha"))->first();
        $filename = "Reporte Diario " . $fecha->fecha . ".xls";
        return response()
            ->view("export.template.reporte_diario", [
                'data' => $data,
                'data_metas' => $data_metas,
                'data_dia' => $data_dia,
                'data_hoy' => $data_hoy,
                'data_dev_acum' => $data_dev_acum,
                'resumen_pliego' => $resumen_pliego,
                'resumen_pliego_total' => $resumen_pliego_total,
                'historial_mensual' => $historial_mensual,
                'historial_mensual_meta' => $historial_mensual_meta,
                'mefvs_formato12b' => $mefvs_formato12b,
                'fecha' => $fecha,
                'fecha_acu' => $fecha_acu
            ], 200)
            // ->header('Content-Description', 'File Transfer')
            // ->header('Content-Type', 'application/vnd.ms-excel')
            // ->header('Content-Disposition', 'attachment; filename=reportediario.xls')
            // ->header('Content-Transfer-Encoding', 'binary')
            // ->header('Connection', 'Keep-Alive')
            // ->header('Expires', '0')
            // ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            // ->header('Pragma', 'public');
            // ->header("Content-type","application/vnd.ms-excel")
            // ->header("Content-Disposition","attachment; filename=\"$filename\"")
            // ->header("Expires","0")
            // ->header("Cache-Control","must-revalidate", "post-check=0","pre-check=0")
            // ->header("Pragma", "public");
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename=' . basename($filename))
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate')
            ->header('Pragma', 'public');
        // ->header('Content-Length','' . filesize($filename));


        // header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        // header('Content-Disposition: attachment; filename=' . basename($file));
        // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate');
        // header('Pragma: public');
        // header('Content-Length:' . filesize($file));



    }

    public function reporte_diario_f12(Request $request)
    {
        $data = DB::table("vw_pry_dev_ejecutoras_2")->select(DB::RAW("*,
            case
            when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
            when ger_direc in ('LIQUIDACION DE OBRAS') then 2
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
            else 0 end as  orden"))
            ->leftjoin(DB::RAW("(select ger_direc as uei,sum(a_enero) as a_enero, sum(a_febrero) as a_febrero,sum(a_marzo) as a_marzo,sum(a_abril) as a_abril,sum(a_mayo) as a_mayo,sum(a_junio) as a_junio,sum(a_julio) as a_julio,
            sum(a_agosto) as a_agosto,sum(a_setiembre) as a_setiembre,sum(a_octubre) as a_octubre,sum(a_noviembre) as a_noviembre,sum(a_diciembre) as a_diciembre,
            sum(case when a_enero > 0 then 1 else 0 end) as can_enero,sum(case when a_febrero > 0 then 1 else 0 end) as can_febrero,sum(case when a_marzo > 0 then 1 else 0 end) as can_marzo,
            sum(case when a_abril > 0 then 1 else 0 end) as can_abril,sum(case when a_mayo > 0 then 1 else 0 end) as can_mayo,sum(case when a_junio > 0 then 1 else 0 end) as can_junio,
            sum(case when a_julio > 0 then 1 else 0 end) as can_julio,sum(case when a_agosto > 0 then 1 else 0 end) as can_agosto,sum(case when a_setiembre > 0 then 1 else 0 end) as can_setiembre,
            sum(case when a_octubre > 0 then 1 else 0 end) as can_octubre,sum(case when a_noviembre > 0 then 1 else 0 end) as can_noviembre,sum(case when a_diciembre > 0 then 1 else 0 end) as can_diciembre
            from vw_formato12b_proyecto group by ger_direc) as formato_12"), "vw_pry_dev_ejecutoras_2.ger_direc", "formato_12.uei")->orderBy("orden")->get();

        $data_dia = DB::table("vw_proyectos_diario_f12")->select()->get();
        $data_hoy = DB::table("vw_proyectos_diario_f12")->select()->where('fecha', DB::RAW("(select max(fecha) from vw_proyectos_diario_f12)"))->orderBy("meta_mes", "desc")->orderBy("dev_mes", "desc")->get();
        $data_dev_acum = DB::table("vw_proyectos_diario_dev_acu")->select()->get();
        $fecha = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->select(DB::RAW("max(fecha) as fecha"))->first();

        return response()
            ->view("export.template.reporte_diario_f12", ['data' => $data, 'data_dia' => $data_dia, 'data_hoy' => $data_hoy, 'data_dev_acum' => $data_dev_acum, 'fecha' => $fecha], 200)
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=REPORTE_DIARIO_F12.xls')
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Connection', 'Keep-Alive')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'public');
    }

    public function reporte_diario_data_exportar()
    {
        $anioActual = date('Y');
        //  Obtener la última fecha de subida de `meta_mef` en una consulta separada
        $ultimaFechaSubida = DB::table("meta_mef")
            ->whereRaw("anio = EXTRACT(YEAR FROM NOW())")
            ->max("fecha_subida");

        //  Consultar los datos optimizados
        $data = DB::table("vw_pry_dev_ejecutoras_total")
            ->select([
                DB::raw("SUM(cantida) AS cantida"),
                DB::raw("SUM(pim_dia) AS pim_dia"),
                DB::raw("SUM(certificacion_dia) AS certificacion_dia"),
                DB::raw("SUM(dev_dia) AS dev_dia"),
                DB::raw("SUM(dif_dev_dia) AS dif_dev_dia"),
                DB::raw("SUM(girado_dia) AS girado_dia"),
                DB::raw("SUM(a_fisico) AS a_fisico"),
                DB::raw("SUM(enero) AS enero"),
                DB::raw("SUM(febrero) AS febrero"),
                DB::raw("SUM(marzo) AS marzo"),
                DB::raw("SUM(abril) AS abril"),
                DB::raw("SUM(mayo) AS mayo"),
                DB::raw("SUM(junio) AS junio"),
                DB::raw("SUM(julio) AS julio"),
                DB::raw("SUM(agosto) AS agosto"),
                DB::raw("SUM(septiembre) AS septiembre"),
                DB::raw("SUM(octubre) AS octubre"),
                DB::raw("SUM(noviembre) AS noviembre"),
                DB::raw("SUM(diciembre) AS diciembre"),
                DB::raw("SUM(comp_anual_dia) AS comp_anual_dia"),
                DB::raw("SUM(ate_comp_anual_dia) AS ate_comp_anual_dia"),
                DB::raw("SUM(dev_dia_real) AS dev_dia_real"),
                DB::raw("SUM(mes_actual) AS mes_actual"),
                DB::raw("SUM(dev_ant) AS dev_ant"),
                DB::raw("SUM(pia_dia) AS pia_dia"),
                DB::raw("SUM(m_enero) AS m_enero"),
                DB::raw("SUM(m_febrero) AS m_febrero"),
                DB::raw("SUM(m_marzo) AS m_marzo"),
                DB::raw("SUM(m_abril) AS m_abril"),
                DB::raw("SUM(m_mayo) AS m_mayo"),
                DB::raw("SUM(m_junio) AS m_junio"),
                DB::raw("SUM(m_julio) AS m_julio"),
                DB::raw("SUM(m_agosto) AS m_agosto"),
                DB::raw("SUM(m_setiembre) AS m_setiembre"),
                DB::raw("SUM(m_octubre) AS m_octubre"),
                DB::raw("SUM(m_noviembre) AS m_noviembre"),
                DB::raw("SUM(m_diciembre) AS m_diciembre")
            ])
            ->leftJoin("meta_mef", function ($join) use ($ultimaFechaSubida) {
                $join->on("vw_pry_dev_ejecutoras_total.anio", "=", DB::raw("meta_mef.anio::text"))
                    ->on("vw_pry_dev_ejecutoras_total.ger_direc", "=", "meta_mef.direc_uei")
                    ->where("meta_mef.fecha_subida", "=", $ultimaFechaSubida);
            })
            ->first();


        //  Obtener la última fecha de subida antes de la consulta
        $ultimaFechaSubidaProyecto = DB::table("meta_mef_proyecto")
            ->max("fecha_subida");

        //  Obtener datos agregados de `meta_mef_proyecto`
        $metaData = DB::table("meta_mef_proyecto")
            ->select([
                "anio",
                DB::raw("ger_direc as direc_uei"),
                DB::raw("SUM(m_enero) as m_enero"),
                DB::raw("SUM(m_febrero) as m_febrero"),
                DB::raw("SUM(m_marzo) as m_marzo"),
                DB::raw("SUM(m_abril) as m_abril"),
                DB::raw("SUM(m_mayo) as m_mayo"),
                DB::raw("SUM(m_junio) as m_junio"),
                DB::raw("SUM(m_julio) as m_julio"),
                DB::raw("SUM(m_agosto) as m_agosto"),
                DB::raw("SUM(m_setiembre) as m_setiembre"),
                DB::raw("SUM(m_octubre) as m_octubre"),
                DB::raw("SUM(m_noviembre) as m_noviembre"),
                DB::raw("SUM(m_diciembre) as m_diciembre"),
                DB::raw("SUM(CASE WHEN m_enero > 0 THEN 1 ELSE 0 END) as cant_enero"),
                DB::raw("SUM(CASE WHEN m_febrero > 0 THEN 1 ELSE 0 END) as cant_febrero"),
                DB::raw("SUM(CASE WHEN m_marzo > 0 THEN 1 ELSE 0 END) as cant_marzo"),
                DB::raw("SUM(CASE WHEN m_abril > 0 THEN 1 ELSE 0 END) as cant_abril"),
                DB::raw("SUM(CASE WHEN m_mayo > 0 THEN 1 ELSE 0 END) as cant_mayo"),
                DB::raw("SUM(CASE WHEN m_junio > 0 THEN 1 ELSE 0 END) as cant_junio"),
                DB::raw("SUM(CASE WHEN m_julio > 0 THEN 1 ELSE 0 END) as cant_julio"),
                DB::raw("SUM(CASE WHEN m_agosto > 0 THEN 1 ELSE 0 END) as cant_agosto"),
                DB::raw("SUM(CASE WHEN m_setiembre > 0 THEN 1 ELSE 0 END) as cant_setiembre"),
                DB::raw("SUM(CASE WHEN m_octubre > 0 THEN 1 ELSE 0 END) as cant_octubre"),
                DB::raw("SUM(CASE WHEN m_noviembre > 0 THEN 1 ELSE 0 END) as cant_noviembre"),
                DB::raw("SUM(CASE WHEN m_diciembre > 0 THEN 1 ELSE 0 END) as cant_diciembre")
            ])
            ->join("vw_total_proyectos", "meta_mef_proyecto.codigo_unico", "=", "vw_total_proyectos.cod_unif")
            ->where("fecha_subida", "=", $ultimaFechaSubidaProyecto)
            ->groupBy("anio", "ger_direc")
            ->get()
            ->keyBy("direc_uei"); // Agrupar por clave para acceso rápido

        //  Obtener datos principales sin `CASE WHEN`
        $dataMetas = DB::table("vw_pry_dev_ejecutoras_2")
            ->select("vw_pry_dev_ejecutoras_2.*", DB::raw("(pim_dia - certificacion_dia) as por_certificar"))
            ->get();

        //  Mapeo de orden en PHP (más eficiente que `CASE WHEN` en SQL)
        $ordenGerencias = [
            'ESTUDIOS DE PRE-INVERSION' => 1,
            'LIQUIDACION DE OBRAS' => 2,
            'INICIATIVA A LA COMPETITIVIDAD' => 3,
            'GERENCIA REGIONAL DE INFRAESTRUCTURA' => 4,
            'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES' => 5,
            'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE' => 6,
            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' => 7,
            'GERENCIA REGIONAL DE DESARROLLO SOCIAL' => 8,
            'DIRECCION REGIONAL DE AGRICULTURA' => 9,
            'GERENCIA SUB REGIONAL LIMA SUR' => 10,
            'DIRECCION REGIONAL DE SALUD' => 11,
            'DIRECCION REGIONAL DE EDUCACION' => 12
        ];

        //  Aplicar `LEFT JOIN` en PHP para mayor eficiencia
        $dataMetas->transform(function ($item) use ($metaData, $ordenGerencias) {
            // Buscar la metadata correspondiente
            $meta = isset($metaData[$item->ger_direc]) ? $metaData[$item->ger_direc] : null;

            // Asignar valores si existen, sino poner 0
            if ($meta) {
                foreach (
                    [
                        "m_enero",
                        "m_febrero",
                        "m_marzo",
                        "m_abril",
                        "m_mayo",
                        "m_junio",
                        "m_julio",
                        "m_agosto",
                        "m_setiembre",
                        "m_octubre",
                        "m_noviembre",
                        "m_diciembre",
                        "cant_enero",
                        "cant_febrero",
                        "cant_marzo",
                        "cant_abril",
                        "cant_mayo",
                        "cant_junio",
                        "cant_julio",
                        "cant_agosto",
                        "cant_setiembre",
                        "cant_octubre",
                        "cant_noviembre",
                        "cant_diciembre"
                    ]
                    as $campo
                ) {
                    $item->$campo = isset($meta->$campo) ? $meta->$campo : 0;
                }

                // Calcular diferencias
                foreach (
                    [
                        "enero",
                        "febrero",
                        "marzo",
                        "abril",
                        "mayo",
                        "junio",
                        "julio",
                        "agosto",
                        "septiembre",
                        "octubre",
                        "noviembre",
                        "diciembre"
                    ]
                    as $campo
                ) {
                    $metaCampo = "m_" . $campo;
                    $item->{"pen_" . $campo} = isset($meta->$metaCampo) ? $meta->$metaCampo - $item->$campo : 0;
                }
            }

            // Asignar orden según el array en PHP
            $item->orden = isset($ordenGerencias[$item->ger_direc]) ? $ordenGerencias[$item->ger_direc] : 0;

            return $item;
        });

        //  Ordenar en PHP después de traer los datos
        $data_metas  = $dataMetas->sortBy("orden")->values();

        $data_dia = DB::table("vw_proyectos_diario")->get();

        //  Obtener la última fecha de manera eficiente
        $ultimaFecha = DB::table("vw_proyectos_diario")->max("fecha");

        //  Aplicar la fecha en la consulta principal
        $data_hoy = DB::table("vw_proyectos_diario")
            ->where("fecha", $ultimaFecha) // ✅ Usamos la variable en lugar de una subconsulta
            ->orderBy("meta_mes", "desc")
            ->orderBy("dev_mes", "desc")
            ->get();

        $data_dev_acum = DB::table("vw_proyectos_diario_dev_acu")->get();


        $resumenData = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")
            ->select([
                DB::raw("COUNT(*) as cantidad"),
                "ger_direc",
                DB::raw("SUM(pia_dia) as pia"),
                DB::raw("SUM(pim_dia) as pim"),
                DB::raw("SUM(dev_dia) as dev_dia"),
                DB::raw("CASE WHEN SUM(pim_dia) > 0 THEN (SUM(dev_dia) * 100 / SUM(pim_dia)) ELSE 0 END as avance"),
                DB::raw("SUM(certificacion_dia) as certificado"),
                DB::raw("CASE WHEN SUM(pim_dia) > 0 THEN (SUM(certificacion_dia) * 100 / SUM(pim_dia)) ELSE 0 END as avance_certificado")
            ])
            ->groupBy("ger_direc")
            ->get();

        //  Aplicar orden en PHP
        $resumen_pliego = $resumenData->map(function ($item) use ($ordenGerencias) {
            $item->orden = isset($ordenGerencias[$item->ger_direc]) ? $ordenGerencias[$item->ger_direc] : 0;
            return $item;
        })->sortBy("orden")->values();

        //  Obtener el total en una consulta separada (evita doble procesamiento)
        $resumen_pliego_total = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")
            ->select([
                DB::raw("COUNT(*) as total_pry"),
                DB::raw("SUM(pia_dia) as pia"),
                DB::raw("SUM(pim_dia) as pim"),
                DB::raw("SUM(dev_dia) as dev_dia"),
                DB::raw("CASE WHEN SUM(pim_dia) > 0 THEN (SUM(dev_dia) * 100 / SUM(pim_dia)) ELSE 0 END as avance"),
                DB::raw("SUM(certificacion_dia) as certificado"),
                DB::raw("CASE WHEN SUM(pim_dia) > 0 THEN (SUM(certificacion_dia) * 100 / SUM(pim_dia)) ELSE 0 END as avance_certificado")
            ])
            ->first();

        $historial_mensual = DB::table("vw_bi_inf_financiera_2")
            ->select([
                DB::raw("SUM(enero) AS enero"),
                DB::raw("SUM(febrero) AS febrero"),
                DB::raw("SUM(marzo) AS marzo"),
                DB::raw("SUM(abril) AS abril"),
                DB::raw("SUM(mayo) AS mayo"),
                DB::raw("SUM(junio) AS junio"),
                DB::raw("SUM(julio) AS julio"),
                DB::raw("SUM(agosto) AS agosto"),
                DB::raw("SUM(septiembre) AS septiembre"),
                DB::raw("SUM(octubre) AS octubre"),
                DB::raw("SUM(noviembre) AS noviembre"),
                DB::raw("SUM(diciembre) AS diciembre")
            ])
            ->first();


        //  Consulta optimizada
        $historial_mensual_meta = DB::table("meta_mef")
            ->select([
                DB::raw("'MEF' as info"), // ✅ Valor estático en la consulta
                DB::raw("SUM(m_enero) as m_enero"),
                DB::raw("SUM(m_febrero) as m_febrero"),
                DB::raw("SUM(m_marzo) as m_marzo"),
                DB::raw("SUM(m_abril) as m_abril"),
                DB::raw("SUM(m_mayo) as m_mayo"),
                DB::raw("SUM(m_junio) as m_junio"),
                DB::raw("SUM(m_julio) as m_julio"),
                DB::raw("SUM(m_agosto) as m_agosto"),
                DB::raw("SUM(m_setiembre) as m_septiembre"),
                DB::raw("SUM(m_octubre) as m_octubre"),
                DB::raw("SUM(m_noviembre) as m_noviembre"),
                DB::raw("SUM(m_diciembre) as m_diciembre")
            ])
            ->where("fecha_subida", "=", $ultimaFechaSubida) // ✅ Se usa la variable en vez de una subconsulta
            ->first();


        //  Primera consulta: `meta_mef`
        $mef = DB::table("meta_mef")
            ->select([
                DB::raw("'MEF' as info"),
                DB::raw("SUM(m_enero) as enero"),
                DB::raw("SUM(m_febrero) as febrero"),
                DB::raw("SUM(m_marzo) as marzo"),
                DB::raw("SUM(m_abril) as abril"),
                DB::raw("SUM(m_mayo) as mayo"),
                DB::raw("SUM(m_junio) as junio"),
                DB::raw("SUM(m_julio) as julio"),
                DB::raw("SUM(m_agosto) as agosto"),
                DB::raw("SUM(m_setiembre) as setiembre"),
                DB::raw("SUM(m_octubre) as octubre"),
                DB::raw("SUM(m_noviembre) as noviembre"),
                DB::raw("SUM(m_diciembre) as diciembre")
            ])
            ->where("fecha_subida", "=", $ultimaFechaSubida);

        //  Segunda consulta: `vw_formato12b_proyecto`
        $mefvs_formato12b = DB::table("vw_formato12b_proyecto")
            ->select([
                DB::raw("'FORMATO 12-B' as info"),
                DB::raw("SUM(a_enero) as a_enero"),
                DB::raw("SUM(a_febrero) as a_febrero"),
                DB::raw("SUM(a_marzo) as a_marzo"),
                DB::raw("SUM(a_abril) as a_abril"),
                DB::raw("SUM(a_mayo) as a_mayo"),
                DB::raw("SUM(a_junio) as a_junio"),
                DB::raw("SUM(a_julio) as a_julio"),
                DB::raw("SUM(a_agosto) as a_agosto"),
                DB::raw("SUM(a_setiembre) as a_setiembre"),
                DB::raw("SUM(a_octubre) as a_octubre"),
                DB::raw("SUM(a_noviembre) as a_noviembre"),
                DB::raw("SUM(a_diciembre) as a_diciembre")
            ])
            ->union($mef) // ✅ Se une con la consulta de `meta_mef`
            ->get();

        $fecha = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")
            ->max("fecha");

        $fecha_acu = DB::table("vw_proyectos_diario_dev_acu")
            ->max("fecha_max");

        $data_ranking = DB::select("
            SELECT puesto, gore, (avance / 100.0) AS avance
            FROM inf_financiera_rank
            WHERE fecha = (SELECT MAX(fecha) FROM inf_financiera_rank WHERE anio=?)
            AND categoria='PLIEGO' 
            AND anio = ?
            ORDER BY avance ASC
        ", [$anioActual, $anioActual]);

        $goreEspecifico = 'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LIMA';

        $data_ranking_lima = DB::select("
            SELECT puesto
            FROM inf_financiera_rank
            WHERE fecha = (SELECT MAX(fecha) FROM inf_financiera_rank WHERE anio= ?)
            AND categoria='PLIEGO' 
            AND anio = ?
            AND gore = ?
        ", [$anioActual, $anioActual, $goreEspecifico]);

        return  [
            'data' => $data,
            'data_metas' => $data_metas,
            'data_dia' => $data_dia,
            'data_hoy' => $data_hoy,
            'data_dev_acum' => $data_dev_acum,
            'resumen_pliego' => $resumen_pliego,
            'resumen_pliego_total' => $resumen_pliego_total,
            'historial_mensual' => $historial_mensual,
            'historial_mensual_meta' => $historial_mensual_meta,
            'mefvs_formato12b' => $mefvs_formato12b,
            'fecha' => $fecha,
            'fecha_acu' => $fecha_acu,
            'data_ranking' => $data_ranking,
            'data_ranking_lima' => $data_ranking_lima
        ];
    }

    //  Función para aplicar formato a cada mes
    private function aplicarFormatoHistorial($sheet, $colInicio, $colEtiqueta, $colMonto, $rowDev, $rowProg, $mes, $historial_mensual, $historial_mensual_meta)
    {
        $anio = date("Y");
        // Fusionar celdas para el nombre del mes
        $sheet->mergeCells("{$colInicio}$rowDev:{$colInicio}$rowProg");
        $sheet->setCellValue("{$colInicio}$rowDev", strtoupper($mes));

        // Encabezados de columnas
        $sheet->setCellValue("{$colEtiqueta}$rowDev", "DEVENGADO");
        $sheet->setCellValue("{$colEtiqueta}$rowProg", "PROGRAMACION");

        // Datos de devengado y programación
        if($anio == 2026 ){
            $valor_corregido = 2733898;
            if($mes == "enero"){
                $sheet->setCellValue("{$colMonto}$rowDev", $historial_mensual->$mes - $valor_corregido);
            } elseif($mes == "febrero") {
                $sheet->setCellValue("{$colMonto}$rowDev", $historial_mensual->$mes + $valor_corregido);
            }else{
                $sheet->setCellValue("{$colMonto}$rowDev", $historial_mensual->$mes);
            }
        } else {
            $sheet->setCellValue("{$colMonto}$rowDev", $historial_mensual->$mes);
        }
        $sheet->setCellValue("{$colMonto}$rowProg", $historial_mensual_meta->{"m_" . $mes});


        //  Aplicar estilos
        $sheet->getStyle("{$colInicio}$rowDev:{$colMonto}$rowProg")->applyFromArray([
            'font' => ['bold' => true, 'size' => 22],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ]);

        //  Formato de número
        $sheet->getStyle("{$colMonto}$rowDev:{$colMonto}$rowProg")->getNumberFormat()->setFormatCode('#,##0');

        //  Color de fondo en el nombre del mes
        $sheet->getStyle("{$colInicio}$rowDev:{$colInicio}$rowProg")->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
        ]);
    }

    public function reporte_prueba(Request $request)
    {
        $data_reporte = $this->reporte_diario_data_exportar();

        // Informacion 
        $data = $data_reporte['data'];
        $fecha = strtotime($data_reporte['fecha']);
        $fecha = date('d/m/Y', $fecha);
        $resumen_pliego = $data_reporte['resumen_pliego'];
        $resumen_pliego_total = $data_reporte['resumen_pliego_total'];
        $data_metas = $data_reporte['data_metas'];
        $historial_mensual = $data_reporte['historial_mensual'];
        $historial_mensual_meta = $data_reporte['historial_mensual_meta'];
        $mefvs_formato12b = $data_reporte['mefvs_formato12b'];
        $data_hoy = $data_reporte['data_hoy'];
        $data_dia = $data_reporte['data_dia'];
        $data_dev_acum = $data_reporte['data_dev_acum'];
        $data_ranking = $data_reporte['data_ranking'];
        $data_ranking_lima = $data_reporte['data_ranking_lima'];
        $puestoLima = count($data_ranking_lima) > 0 ? $data_ranking_lima[0]->puesto : '';
        $logoPath = public_path('logo_opmi.png');
        //Variables por Gerencias
        $mes = date("n");
        $meses = array(
            1 => "ENERO",
            2 => "FEBRERO",
            3 => "MARZO",
            4 => "ABRIL",
            5 => "MAYO",
            6 => "JUNIO",
            7 => "JULIO",
            8 => "AGOSTO",
            9 => "SEPTIEMBRE",
            10 => "OCTUBRE",
            11 => "NOVIEMBRE",
            12 => "DICIEMBRE"
        );
        $mes_nombre = isset($meses[$mes]) ? $meses[$mes] : '';
        $anio = date("Y");
        // Inicialización de variables sin cambiar nombres
        $meta_certificado = 238081559;
        $meta_devengado = isset($data->m_abril) ? $data->m_abril : 0;
        $meta_mes = 0;
        $lunes = 0;
        $martes = 0;
        $miercoles = 0;
        $jueves = 0;
        $viernes = 0;
        $total_semana = 0;
        $dev_mes_acum = 0;
        $t_1_meta_mes = 0;
        $t_1_devengado_mes = 0;
        $total_pen_dev_acu_2 = 0;
        $t_1_cantidad = 0;
        $cod_unif = 0;
        $meta_mes_2 = 0;
        $dev_mes_2 = 0;
        $pen_dev_acu_2 = 0;
        $total_meta = 0;
        $fila_inicio = 0;
        $t_cantidad = 0;
        $t_programacion = 0;
        $t_ejecucion = 0;
        $t_mes_acumalativo = 0;
        $t_lunes = 0;
        $t_martes = 0;
        $t_miercoles = 0;
        $t_jueves = 0;
        $t_viernes = 0;
        $t_semana_total = 0;
        $rowIndex = 0;
        //Fin

        //  Definir abreviaturas para nombres largos
        $abreviaturas = [
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AMAZONAS' => 'AMAZONAS',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE JUNIN' => 'JUNIN',
            'MUNICIPALIDAD METROPOLITANA DE LIMA' => 'LIMA METRO.',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE HUANCAVELICA' => 'HUANCAVELICA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LIMA' => 'LIMA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE TACNA' => 'TACNA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE ICA' => 'ICA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE SAN MARTIN' => 'SAN MARTIN',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PUNO' => 'PUNO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PIURA' => 'PIURA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LORETO' => 'LORETO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE CAJAMARCA' => 'CAJAMARCA',
            'GOBIERNO REGIONAL DE LA PROVINCIA CONSTITUCIONAL DEL CALLAO' => 'CALLAO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AYACUCHO' => 'AYACUCHO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE MOQUEGUA' => 'MOQUEGUA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE MADRE DE DIOS' => 'MADRE DE DIOS',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE UCAYALI' => 'UCAYALI',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AREQUIPA' => 'AREQUIPA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE ANCASH' => 'ANCASH',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE CUSCO' => 'CUSCO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE TUMBES' => 'TUMBES',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LAMBAYEQUE' => 'LAMBAYEQUE',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LA LIBERTAD' => 'LA LIBERTAD',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PASCO' => 'PASCO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE APURIMAC' => 'APURIMAC',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE HUANUCO' => 'HUANUCO'
        ];

        // UEI
        $uei = array(
            'ESTUDIOS DE PRE-INVERSION',
            'GERENCIA REGIONAL DE INFRAESTRUCTURA',
            'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES',
            'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE',
            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
            'GERENCIA REGIONAL DE DESARROLLO SOCIAL',
            'DIRECCION REGIONAL DE AGRICULTURA',
            'GERENCIA SUB REGIONAL LIMA SUR',
            'SIN UEI'
        );
        // Fin UEI
        //  Mapear el mes con los campos correspondientes
        $mapaMes = array(
            1 => ["m_enero", "cant_enero", "enero", "enero_certificado"],
            2 => ["m_febrero", "cant_febrero", "febrero", "febrero_certificado"],
            3 => ["m_marzo", "cant_marzo", "marzo", "marzo_certificado"],
            4 => ["m_abril", "cant_abril", "abril", "abril_certificado"],
            5 => ["m_mayo", "cant_mayo", "mayo", "mayo_certificado"],
            6 => ["m_junio", "cant_junio", "junio", "junio_certificado"],
            7 => ["m_julio", "cant_julio", "julio", "julio_certificado"],
            8 => ["m_agosto", "cant_agosto", "agosto", "agosto_certificado"],
            9 => ["m_setiembre", "cant_setiembre", "septiembre", "septiembre_certificado"],
            10 => ["m_octubre", "cant_octubre", "octubre", "octubre_certificado"],
            11 => ["m_noviembre", "cant_noviembre", "noviembre", "noviembre_certificado"],
            12 => ["m_diciembre", "cant_diciembre", "diciembre", "diciembre_certificado"]
        );

        //  Inicializar acumuladores
        $t_1_meta_mes = 0;
        $t_1_cantidad = 0;
        $t_1_devengado_mes = 0;
        $t_1_certificado_mes = 0;

        //  Verificar si el mes tiene asignación válida
        if (isset($mapaMes[$mes])) {
            $campo_meta = $mapaMes[$mes][0];
            $campo_cantidad = $mapaMes[$mes][1];
            $campo_devengado = $mapaMes[$mes][2];
            $campo_certificado = $mapaMes[$mes][3];

            //  Sumar valores usando el mapeo dinámico
            foreach ($data_metas as $row) {
                $t_1_meta_mes += isset($row->$campo_meta) ? $row->$campo_meta : 0;
                $t_1_cantidad += isset($row->$campo_cantidad) ? $row->$campo_cantidad : 0;
                $t_1_devengado_mes += isset($row->$campo_devengado) ? $row->$campo_devengado : 0;
                $t_1_certificado_mes += isset($row->$campo_certificado) ? $row->$campo_certificado : 0;
            }
        }
        // Fin Informacion
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet(); // Usar hoja predeterminada
        $sheet->setTitle('Reporte Diario'); // Renombrar la hoja

        // Tamaño de las columnas
        $columnWidths = [
            'A' => 9,
            'B' => 25,
            'C' => 34,
            'D' => 36,
            'E' => 28,
            'F' => 35,
            'G' => 36,
            'H' => 36,
            'I' => 31,
            'J' => 34,
            'K' => 34,
            'L' => 35,
            'M' => 36,
            'N' => 25,
            'O' => 27,
            'P' => 27
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        //Fin

        // Tamaño de las columnas de Filas
        $rowHeights = [
            1 => 15,
            2 => 33,
            3 => 62,
            4 => 15,
            5 => 60,
            6 => 15,
            7 => 63,
            8 => 37,
            9 => 37,
            10 => 55,
            11 => 63,
            12 => 55,
            13 => 37,
            14 => 37,
            15 => 37,
            16 => 63,
            17 => 36,
            18 => 15,
            19 => 60,
            20 => 15,
            21 => 63,
            22 => 37,
            23 => 37,
            24 => 37,
            25 => 63,
            26 => 37,
            27 => 37,
            28 => 37,
            29 => 37,
            30 => 63,
            31 => 36,
            32 => 15,
            33 => 60,
            34 => 15,
            35 => 34,
            36 => 58,
            37 => 15,
            38 => 34,
            39 => 58,
            40 => 15,
            41 => 60,
            42 => 15,
            43 => 26,
            44 => 32,
            45 => 32,
            46 => 15
        ];

        foreach ($rowHeights as $row => $height) {
            $sheet->getRowDimension($row)->setRowHeight($height);
        }
        // Fin

        // Insertar imagen
        //  Convertir cm a píxeles (1 cm ≈ 37.8 px)
        $anchoPx = round(5 * 37.8); // 5.3 cm → píxeles
        $altoPx = round(3.8 * 37.8);    // 4 cm → píxeles
        $logoPath = public_path('logo_opmi.png');
        $drawing = new Drawing();
        $drawing->setPath($logoPath);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(20);
        $drawing->setOffsetY(10);
        $drawing->setWidth($anchoPx);
        $drawing->setHeight($altoPx);
        $drawing->setWorksheet($sheet);
        // Fin

        $sheet->mergeCells('A1:P1');
        // Insertar fecha
        $sheet->setCellValue('C2', "ACTUALIZADO AL");
        $sheet->mergeCells('C2:D2');
        $sheet->getStyle('C2:D2')->getAlignment()->setWrapText(true);
        // Aplicar estilos
        $sheet->getStyle('C2:D2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 26
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        $sheet->setCellValue('C3', $fecha);
        $sheet->mergeCells('C3:D3');
        // Aplicar estilos
        $sheet->getStyle('C3:D3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 48
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Insertar título
        $sheet->setCellValue('E2', "SEGUIMIENTO DE INVERSIONES " . $anio);
        $sheet->mergeCells('E2:M3');
        $sheet->getStyle('E2:M3')->getAlignment()->setWrapText(true);
        $sheet->getStyle('E2:M3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 72
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Ranking
        $sheet->setCellValue('N2', "RANKING");
        $sheet->mergeCells('N2:P2');
        $sheet->getStyle('N2:P2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('N2:P2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 26
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->mergeCells('N3:P3');
        $sheet->setCellValue('N3', $puestoLima . "°");
        $sheet->getStyle('N3:P3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 48
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // GRUPO 1
        // Fusionar celdas y establecer valores
        $sheet->mergeCells('A4:L4');
        $sheet->mergeCells('A5:L5');
        $sheet->setCellValue('A5', "RESUMEN GORE LIMA");

        // Aplicar estilos a la celda A5
        $sheet->getStyle('A5:L5')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 48
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->mergeCells('A6:L6');

        // Establecer encabezados
        $sheet->setCellValue('B7', "N°");
        $sheet->mergeCells('C7:E7');
        $sheet->setCellValue('C7', "UNIDADES EJECUTORAS");
        $sheet->setCellValue('F7', "PIA");
        $sheet->setCellValue('G7', "PIM");
        $sheet->setCellValue('H7', "DEVENGADO");
        $sheet->setCellValue('I7', "PENDIENTE DEVENGADO");
        $sheet->setCellValue('J7', "AVANCE DEVENGADO(%)");
        $sheet->setCellValue('K7', "CERTIFICADO");
        $sheet->setCellValue('L7', "AVANCE CERTIFICADO(%)");

        // Habilitar el ajuste de texto en las celdas
        $sheet->getStyle('B7:L7')->getAlignment()->setWrapText(true);

        // Aplicar estilos a los encabezados
        $sheet->getStyle('B7:L7')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $fila_inicio = 8;

        foreach ($resumen_pliego as $key => $row) {
            $fila = $fila_inicio + $key;

            //  Asignar valores a las celdas
            $sheet->setCellValue("B$fila", $row->cantidad);
            $sheet->mergeCells("C$fila:E$fila");
            $sheet->setCellValue("C$fila", $row->ger_direc);
            $sheet->setCellValue("F$fila", $row->pia);
            $sheet->setCellValue("G$fila", $row->pim);
            $sheet->setCellValue("H$fila", $row->dev_dia);
            $sheet->setCellValue("I$fila", $row->pim - $row->dev_dia);
            $sheet->setCellValue("J$fila", $row->avance);
            $sheet->setCellValue("K$fila", $row->certificado);
            $sheet->setCellValue("L$fila", $row->avance_certificado);

            //  Formato de número en columnas monetarias y porcentajes
            $columnas_monetarias = ["F", "G", "H", "I", "K"];
            foreach ($columnas_monetarias as $col) {
                $sheet->getStyle("$col$fila")->getNumberFormat()->setFormatCode('#,##0');
            }

            $columnas_porcentajes = ["J", "L"];
            foreach ($columnas_porcentajes as $col) {
                $sheet->getStyle("$col$fila")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            }

            //  Estilos generales para toda la fila
            $sheet->getStyle("B$fila:L$fila")->applyFromArray([
                'font' => ['bold' => true, 'size' => 24],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ],
            ]);

            //  Alinear el texto de la columna `C` a la izquierda y permitir salto de línea
            $sheet->getStyle("C$fila")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setWrapText(true);
        }

        //  Total General
        $fila_total = $fila_inicio + count($resumen_pliego);
        $sheet->setCellValue("B$fila_total", $resumen_pliego_total->total_pry);
        $sheet->mergeCells("C$fila_total:E$fila_total");
        $sheet->setCellValue("C$fila_total", "TOTAL");
        $sheet->setCellValue("F$fila_total", $resumen_pliego_total->pia);
        $sheet->setCellValue("G$fila_total", $resumen_pliego_total->pim);
        $sheet->setCellValue("H$fila_total", $resumen_pliego_total->dev_dia);
        $sheet->setCellValue("I$fila_total", $resumen_pliego_total->pim - $resumen_pliego_total->dev_dia);
        $sheet->setCellValue("J$fila_total", $resumen_pliego_total->avance);
        $sheet->setCellValue("K$fila_total", $resumen_pliego_total->certificado);
        $sheet->setCellValue("L$fila_total", $resumen_pliego_total->avance_certificado);

        //  Formatos para la fila total
        $columnas_monetarias = ["F", "G", "H", "I", "K"];
        foreach ($columnas_monetarias as $col) {
            $sheet->getStyle("$col$fila_total")->getNumberFormat()->setFormatCode('#,##0');
        }

        $columnas_porcentajes = ["J", "L"];
        foreach ($columnas_porcentajes as $col) {
            $sheet->getStyle("$col$fila_total")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        }

        //  Estilos de la fila total
        $sheet->getStyle("B$fila_total:L$fila_total")->applyFromArray([
            'font' => ['bold' => true, 'size' => 26],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ],
        ]);
        // Fin GRUPO 1

        $nombreImagen = $this->generarImagenRanking();
        $rutaImagen = storage_path("app/public/{$nombreImagen}");

        $anchoPx = round(21.19 * 37.8); // ≈ 810 px
        $altoPx  = round(41.62 * 37.8); // ≈ 1518 px

        $drawing = new Drawing();
        $drawing->setPath($rutaImagen);
        $drawing->setCoordinates('M5');
        $drawing->setOffsetX(2);
        $drawing->setOffsetY(0);
        $drawing->setWidth($anchoPx); // Usa solo uno
        $drawing->setHeight($altoPx);
        $drawing->setWorksheet($sheet);

        // GRUPO 2
        // Fusionar celdas
        $sheet->mergeCells('A18:L18');
        $sheet->mergeCells('A19:L19');

        // Asignar valor a la celda A19
        $sheet->setCellValue('A19', "RESUMEN DE EJECUCION POR UNIDAD EJECUTORA AL MES DE " . $mes_nombre . " - MEF");

        // Aplicar formato
        $sheet->getStyle('A19:L19')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 48
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Fusionar la fila 20 de A a L
        $sheet->mergeCells('A20:L20');

        // Asignar valores a las celdas de la fila 21
        $sheet->setCellValue('B21', "N°");
        $sheet->mergeCells('C21:F21');
        $sheet->setCellValue('C21', "UNIDADES EJECUTORAS");
        $sheet->setCellValue('G21', "PROGRAMACION");
        $sheet->setCellValue('H21', "EJECUCION");
        $sheet->setCellValue('I21', "PENDIENTE DEVENGADO");
        $sheet->setCellValue('J21', "DEVENGADO AVANCE(%)");
        $sheet->setCellValue('K21', "CERTIFICADO");

        // Aplicar ajuste de texto en las celdas B21:K21
        $sheet->getStyle('B21:K21')->getAlignment()->setWrapText(true);

        // Aplicar formato a la fila 21
        $sheet->getStyle('B21:K21')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        $fila_inicio = 22;
        // Iterar sobre los datos
        foreach ($data_metas as $key => $row) {
            // Variables de mes
            $meses = [
                1 => ['m' => 'm_enero', 'c' => 'cant_enero', 'd' => 'enero', 'cert' => 'enero_certificado', 'pen' => []],
                2 => ['m' => 'm_febrero', 'c' => 'cant_febrero', 'd' => 'febrero', 'cert' => 'febrero_certificado', 'pen' => ['pen_enero']],
                3 => ['m' => 'm_marzo', 'c' => 'cant_marzo', 'd' => 'marzo', 'cert' => 'marzo_certificado', 'pen' => ['pen_enero', 'pen_febrero']],
                4 => ['m' => 'm_abril', 'c' => 'cant_abril', 'd' => 'abril', 'cert' => 'abril_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo']],
                5 => ['m' => 'm_mayo', 'c' => 'cant_mayo', 'd' => 'mayo', 'cert' => 'mayo_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril']],
                6 => ['m' => 'm_junio', 'c' => 'cant_junio', 'd' => 'junio', 'cert' => 'junio_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril', 'pen_mayo']],
                7 => ['m' => 'm_julio', 'c' => 'cant_julio', 'd' => 'julio', 'cert' => 'julio_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril', 'pen_mayo', 'pen_junio']],
                8 => ['m' => 'm_agosto', 'c' => 'cant_agosto', 'd' => 'agosto', 'cert' => 'agosto_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril', 'pen_mayo', 'pen_junio', 'pen_julio']],
                9 => ['m' => 'm_setiembre', 'c' => 'cant_setiembre', 'd' => 'septiembre', 'cert' => 'septiembre_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril', 'pen_mayo', 'pen_junio', 'pen_julio', 'pen_agosto']],
                10 => ['m' => 'm_octubre', 'c' => 'cant_octubre', 'd' => 'octubre', 'cert' => 'octubre_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril', 'pen_mayo', 'pen_junio', 'pen_julio', 'pen_agosto', 'pen_setiembre']],
                11 => ['m' => 'm_noviembre', 'c' => 'cant_noviembre', 'd' => 'noviembre', 'cert' => 'noviembre_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril', 'pen_mayo', 'pen_junio', 'pen_julio', 'pen_agosto', 'pen_setiembre', 'pen_octubre']],
                12 => ['m' => 'm_diciembre', 'c' => 'cant_diciembre', 'd' => 'diciembre', 'cert' => 'diciembre_certificado', 'pen' => ['pen_enero', 'pen_febrero', 'pen_marzo', 'pen_abril', 'pen_mayo', 'pen_junio', 'pen_julio', 'pen_agosto', 'pen_setiembre', 'pen_octubre', 'pen_noviembre']]
            ];

            // Obtener valores del objeto
            $meta_mes_2 = isset($row->{$meses[$mes]['m']}) ? $row->{$meses[$mes]['m']} : 0;
            $cantidad = isset($row->{$meses[$mes]['c']}) ? $row->{$meses[$mes]['c']} : 0;
            $dev_mes_2 = isset($row->{$meses[$mes]['d']}) ? $row->{$meses[$mes]['d']} : 0;
            $certificado_mes_2 = isset($row->{$meses[$mes]['cert']}) ? $row->{$meses[$mes]['cert']} : 0;

            // Acumulador de pendientes
            $pen_dev_acu_2 = array_reduce($meses[$mes]['pen'], function ($carry, $pen) use ($row) {
                return isset($row->$pen) ? $carry + $row->$pen : $carry;
            }, 0);

            $total_pen_dev_acu_2 += $pen_dev_acu_2;

            // Escribir datos en la hoja
            $fila = $fila_inicio + $key;
            $sheet->setCellValue("B$fila", $cantidad);
            $sheet->mergeCells("C$fila:F$fila");
            $sheet->setCellValue("C$fila", $row->ger_direc);
            $sheet->setCellValue("G$fila", $meta_mes_2);
            $sheet->setCellValue("H$fila", $dev_mes_2);
            $sheet->setCellValue("I$fila", $meta_mes_2 - $dev_mes_2);
            $sheet->setCellValue("J$fila", $meta_mes_2 == 0 ? 0 : ($dev_mes_2 * 100 / $meta_mes_2));
            $sheet->setCellValue("K$fila", $certificado_mes_2);

            //  Formato de número
            $columnas_monetarias = ["G", "H", "I", "K"];
            foreach ($columnas_monetarias as $col) {
                $sheet->getStyle("$col$fila")->getNumberFormat()->setFormatCode('#,##0');
            }

            $columnas_porcentajes = ["J"];
            foreach ($columnas_porcentajes as $col) {
                $sheet->getStyle("$col$fila")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
            }

            //  Estilos generales
            $sheet->getStyle("B$fila:K$fila")->applyFromArray([
                'font' => ['bold' => true, 'size' => 24],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ],
            ]);

            //  Alinear el texto de la columna `C` a la izquierda
            $styleC = $sheet->getStyle("C$fila")->getAlignment();
            $styleC->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $styleC->setWrapText(true);
        }

        //  Asignar valores a las celdas
        $sheet->setCellValue('B30', $t_1_cantidad);
        $sheet->mergeCells('C30:F30');
        $sheet->setCellValue('C30', 'TOTAL');
        $sheet->setCellValue('G30', $t_1_meta_mes);
        $sheet->setCellValue('H30', $t_1_devengado_mes);
        $sheet->setCellValue('I30', $t_1_meta_mes - $t_1_devengado_mes);

        // Manejar porcentaje
        $porcentaje = ($t_1_meta_mes != 0) ? ($t_1_devengado_mes * 100 / $t_1_meta_mes) : 0;
        $sheet->setCellValue('J30', $porcentaje);

        // Asignar valor a la columna K30
        $sheet->setCellValue('K30', $t_1_certificado_mes);

        //  Formato de número en columnas monetarias y porcentajes
        $columnas_monetarias = ["G30", "H30", "I30", "K30"];
        foreach ($columnas_monetarias as $col) {
            $sheet->getStyle($col)->getNumberFormat()->setFormatCode('#,##0');
        }

        // Aplicar formato de porcentaje con dos decimales
        $sheet->getStyle('J30')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

        //  Aplicar estilos a la fila TOTAL
        $sheet->getStyle('B30:K30')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 26
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        //FIN GRUPO 2
        //GRUPO 3
        $sheet->mergeCells('A32:P32');
        $sheet->mergeCells('A33:P33');
        $sheet->setCellValue('A33', "HISTORIAL DE DEVENGADOS");

        //  Aplicar estilos al título
        $sheet->getStyle('A33:P33')->applyFromArray([
            'font' => ['bold' => true, 'size' => 48],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'A9D08E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ]);

        $sheet->mergeCells('A34:P34');

        //  Llamadas a la función modular
        $this->aplicarFormatoHistorial($sheet, 'C', 'D', 'E', 35, 36, 'enero',   $historial_mensual , $historial_mensual_meta);
        $this->aplicarFormatoHistorial($sheet, 'G', 'H', 'I', 35, 36, 'febrero',   $historial_mensual , $historial_mensual_meta);
        $this->aplicarFormatoHistorial($sheet, 'K', 'L', 'M', 35, 36, 'marzo', $historial_mensual, $historial_mensual_meta);
        $this->aplicarFormatoHistorial($sheet, 'C', 'D', 'E', 38, 39, 'abril', $historial_mensual, $historial_mensual_meta);
        $this->aplicarFormatoHistorial($sheet, 'G', 'H', 'I', 38, 39, 'mayo', $historial_mensual, $historial_mensual_meta);
        $this->aplicarFormatoHistorial($sheet, 'K', 'L', 'M', 38, 39, 'junio', $historial_mensual, $historial_mensual_meta);
        $fila_inicio = 40;
        $rowHeights = [
            47 => 60,
            48 => 15,
            49 => 27,
            50 => 54
        ];

        foreach ($rowHeights as $row => $height) {
            $sheet->getRowDimension($row)->setRowHeight($height);
        }

        // Si el mes actual es mayor a 6, incluir los meses siguientes
        if ($mes > 6) {
            $fila_inicio = 46;
            $sheet->mergeCells('A40:N40');
            $this->aplicarFormatoHistorial($sheet, 'C', 'D', 'E', 41, 42, 'julio', $historial_mensual, $historial_mensual_meta);
            $this->aplicarFormatoHistorial($sheet, 'G', 'H', 'I', 41, 42, 'agosto', $historial_mensual, $historial_mensual_meta);
            $this->aplicarFormatoHistorial($sheet, 'K', 'L', 'M', 41, 42, 'septiembre', $historial_mensual, $historial_mensual_meta);
            $this->aplicarFormatoHistorial($sheet, 'C', 'D', 'E', 44, 45, 'octubre', $historial_mensual, $historial_mensual_meta);
            $this->aplicarFormatoHistorial($sheet, 'G', 'H', 'I', 44, 45, 'noviembre', $historial_mensual, $historial_mensual_meta);
            $this->aplicarFormatoHistorial($sheet, 'K', 'L', 'M', 44, 45, 'diciembre', $historial_mensual, $historial_mensual_meta);

            //  Ajuste de altura de filas (PhpSpreadsheet usa `setRowHeight`)
            $rowHeights = [
                41 => 34,
                42 => 58,
                43 => 15,
                44 => 34,
                45 => 58,
                46 => 15
            ];

            foreach ($rowHeights as $row => $height) {
                $sheet->getRowDimension($row)->setRowHeight($height);
            }
        }

        //FIN GRUPO 3

        // GRUPO 4
        $sheet->mergeCells("A{$fila_inicio}:P{$fila_inicio}");
        $sheet->mergeCells("A" . ($fila_inicio + 1) . ":P" . ($fila_inicio + 1));
        $sheet->setCellValue("A" . ($fila_inicio + 1), "PROGRAMACION MEF vs FORMATO 12-B");

        // Aplicar estilos
        $sheet->getStyle("A" . ($fila_inicio + 1) . ":P" . ($fila_inicio + 1))->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 48
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->mergeCells("A" . ($fila_inicio + 2) . ":P" . ($fila_inicio + 2));

        $meses = [
            'C' => 'ENERO',
            'D' => 'FEBRERO',
            'E' => 'MARZO',
            'F' => 'ABRIL',
            'G' => 'MAYO',
            'H' => 'JUNIO',
            'I' => 'JULIO',
            'J' => 'AGOSTO',
            'K' => 'SEPTIEMBRE',
            'L' => 'OCTUBRE',
            'M' => 'NOVIEMBRE',
            'N' => 'DICIEMBRE',
            'O' => 'TOTAL'
        ];

        foreach ($meses as $col => $nombre) {
            $sheet->setCellValue("{$col}" . ($fila_inicio + 3), $nombre);
        }

        // Aplicar estilos a los encabezados
        $sheet->getStyle("C" . ($fila_inicio + 3) . ":O" . ($fila_inicio + 3))->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 20
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'BDD7EE']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        foreach ($mefvs_formato12b as $key => $row) {
            // Calcular la suma total de todas las columnas de meses
            $total_meta = array_sum([
                $row->a_enero,
                $row->a_febrero,
                $row->a_marzo,
                $row->a_abril,
                $row->a_mayo,
                $row->a_junio,
                $row->a_julio,
                $row->a_agosto,
                $row->a_setiembre,
                $row->a_octubre,
                $row->a_noviembre,
                $row->a_diciembre
            ]);

            // Definir la fila actual
            $fila = $fila_inicio + $key + 4;

            // Asignar valores a las celdas
            $sheet->mergeCells("A" . $fila . ":B" . $fila);
            $sheet->setCellValue("A$fila", $row->info);

            $meses = [
                'C' => 'a_enero',
                'D' => 'a_febrero',
                'E' => 'a_marzo',
                'F' => 'a_abril',
                'G' => 'a_mayo',
                'H' => 'a_junio',
                'I' => 'a_julio',
                'J' => 'a_agosto',
                'K' => 'a_setiembre',
                'L' => 'a_octubre',
                'M' => 'a_noviembre',
                'N' => 'a_diciembre',
                'O' => 'total_meta'
            ];

            foreach ($meses as $col => $mes) {
                $sheet->setCellValue("{$col}$fila", ($mes === 'total_meta') ? $total_meta : $row->$mes);
            }

            // Aplicar formato a la fila
            $sheet->getStyle("A$fila:O$fila")->applyFromArray([
                'font' => ['bold' => true, 'size' => 24],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ],
            ]);

            // Ajustar tamaño de fuente en la columna A
            $sheet->getStyle("A$fila")->getFont()->setSize(20);

            // Formato de número para valores monetarios
            $sheet->getStyle("B$fila:O$fila")->getNumberFormat()->setFormatCode('#,##0');
        }

        //FIN GRUPO 4

        //GRUPO 5
        $fila_inicio += 6; // Incrementar el inicio de fila correctamente

        // Fusionar celdas para el título
        $sheet->mergeCells("A{$fila_inicio}:P{$fila_inicio}");
        $sheet->mergeCells("A" . ($fila_inicio + 1) . ":P" . ($fila_inicio + 1));

        // Insertar el título con el nombre del mes
        $sheet->setCellValue("A" . ($fila_inicio + 1), "RESUMEN DE EJECUCION POR PROYECTO AL MES DE " . strtoupper($mes_nombre));

        // Aplicar estilos al título
        $sheet->getStyle("A" . ($fila_inicio + 1) . ":P" . ($fila_inicio + 1))->applyFromArray([
            'font' => ['bold' => true, 'size' => 48],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9D08E']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ],
        ]);

        // Fusionar celdas para la cabecera de la tabla
        $sheet->mergeCells("A" . ($fila_inicio + 2) . ":N" . ($fila_inicio + 2));
        $sheet->mergeCells("A" . ($fila_inicio + 3) . ":A" . ($fila_inicio + 4));
        $sheet->mergeCells("B" . ($fila_inicio + 3) . ":B" . ($fila_inicio + 4));
        $sheet->mergeCells("C" . ($fila_inicio + 3) . ":E" . ($fila_inicio + 4));
        $sheet->mergeCells("F" . ($fila_inicio + 3) . ":H" . ($fila_inicio + 3));
        $sheet->mergeCells("I" . ($fila_inicio + 3) . ":N" . ($fila_inicio + 3));

        // Establecer el texto de las celdas
        $sheet->setCellValue("A" . ($fila_inicio + 3), "N°");
        $sheet->setCellValue("B" . ($fila_inicio + 3), "CUI");
        $sheet->setCellValue("C" . ($fila_inicio + 3), "PROYECTO");
        $sheet->setCellValue("F" . ($fila_inicio + 3), "EJECUCION REAL");
        $sheet->setCellValue("F" . ($fila_inicio + 4), "PROGRAMACION");
        $sheet->setCellValue("G" . ($fila_inicio + 4), "EJECUCION");
        $sheet->setCellValue("H" . ($fila_inicio + 4), "AVANCE(%)");
        $sheet->setCellValue("I" . ($fila_inicio + 3), "DEVENGADO AL " . $fecha);
        $sheet->setCellValue("I" . ($fila_inicio + 4), "LUN");
        $sheet->setCellValue("J" . ($fila_inicio + 4), "MAR");
        $sheet->setCellValue("K" . ($fila_inicio + 4), "MIE");
        $sheet->setCellValue("L" . ($fila_inicio + 4), "JUE");
        $sheet->setCellValue("M" . ($fila_inicio + 4), "VIE");
        $sheet->setCellValue("N" . ($fila_inicio + 4), "DEVENGADO SEMANAL");
        $sheet->getStyle("N" . ($fila_inicio + 4))->getAlignment()->setWrapText(true);
        // Aplicar estilos a la cabecera
        $sheet->getStyle("A" . ($fila_inicio + 3) . ":N" . ($fila_inicio + 4))->applyFromArray([
            'font' => ['bold' => true, 'size' => 20],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3EBF7']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ],
        ]);

        // Ajustar filas para repetir en la impresión
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($fila_inicio + 3, $fila_inicio + 4);

        // Incrementar la fila para la siguiente sección
        $fila_inicio += 5;

        foreach ($uei as $item) {
            $data_hoy_a = $data_hoy->where('ger_direc', '=', $item);
            $data_hoy_meta = $data_hoy->where('ger_direc', '=', $item)->where('meta_mes', '!=', 0);
            $data_hoy_adicional = $data_hoy->where('ger_direc', '=', $item)->where('meta_mes', '=', 0);
            $i = 0;
            $total_pry_ger = 0;
            $total_semana_t = 0;
            $lunes_t = 0;
            $martes_t = 0;
            $miercoles_t = 0;
            $jueves_t = 0;
            $viernes_t = 0;
            $dev_mes_acum_t = 0;
            $programacion_t = 0;
            $ejecucion_t = 0;

            if (count($data_hoy_a) > 0) {
                foreach ($data_hoy_a as $key => $row) {
                    $cod_unif = $row->cod_unif;
                    $total_pry_ger = count($data_hoy_meta);
                    $total_semana_t = 0;
                    $programacion_t += $row->meta_mes;
                    $ejecucion_t += $row->dev_mes;

                    $lunes = $data_dia->where('cod_unif', '=', $cod_unif)->where('dia', '=', '2')->first();
                    $martes = $data_dia->where('cod_unif', '=', $cod_unif)->where('dia', '=', '3')->first();
                    $miercoles = $data_dia->where('cod_unif', '=', $cod_unif)->where('dia', '=', '4')->first();
                    $jueves = $data_dia->where('cod_unif', '=', $cod_unif)->where('dia', '=', '5')->first();
                    $viernes = $data_dia->where('cod_unif', '=', $cod_unif)->where('dia', '=', '6')->first();
                    $dev_mes_acum = $data_dev_acum->where('cod_unif', '=', $cod_unif)->first();

                    $lunes_t += !empty($lunes) ? $lunes->dif_dev_dia : 0;
                    $martes_t += !empty($martes) ? $martes->dif_dev_dia : 0;
                    $miercoles_t += !empty($miercoles) ? $miercoles->dif_dev_dia : 0;
                    $jueves_t += !empty($jueves) ? $jueves->dif_dev_dia : 0;
                    $viernes_t += !empty($viernes) ? $viernes->dif_dev_dia : 0;
                    $dev_mes_acum_t += !empty($dev_mes_acum) ? $dev_mes_acum->dev_mes_acu : 0;

                    $total_semana_t += $lunes_t + $martes_t + $miercoles_t + $jueves_t + $viernes_t;
                }

                $t_programacion += $programacion_t;
                $t_ejecucion += $ejecucion_t;
                $t_mes_acumalativo += $dev_mes_acum_t;
                $t_lunes += $lunes_t;
                $t_martes += $martes_t;
                $t_miercoles += $miercoles_t;
                $t_jueves += $jueves_t;
                $t_viernes += $viernes_t;
                $t_semana_total += $total_semana_t;

                $sheet->setCellValue("A{$fila_inicio}", $total_pry_ger);
                $sheet->mergeCells("B{$fila_inicio}:E{$fila_inicio}");
                $sheet->setCellValue("B{$fila_inicio}", $item);
                $sheet->setCellValue("F{$fila_inicio}", $programacion_t);
                $sheet->setCellValue("G{$fila_inicio}", $ejecucion_t);
                $sheet->setCellValue("H{$fila_inicio}", $programacion_t > 0 ? ($ejecucion_t * 100 / $programacion_t) : 0);
                $sheet->setCellValue("I{$fila_inicio}", $lunes_t);
                $sheet->setCellValue("J{$fila_inicio}", $martes_t);
                $sheet->setCellValue("K{$fila_inicio}", $miercoles_t);
                $sheet->setCellValue("L{$fila_inicio}", $jueves_t);
                $sheet->setCellValue("M{$fila_inicio}", $viernes_t);
                $sheet->setCellValue("N{$fila_inicio}", $total_semana_t);

                $sheet->getStyle("A{$fila_inicio}:N{$fila_inicio}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 20],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '9BC2E6']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                ]);

                $sheet->getStyle("F{$fila_inicio}:G{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("H{$fila_inicio}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                $sheet->getStyle("I{$fila_inicio}:N{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getRowDimension($fila_inicio)->setRowHeight(35);
                foreach ($data_hoy_meta as $key => $row) {
                    $i += 1;
                    $total_semana = 0;
                    $cod_unif = $row->cod_unif;
                    $meta_mes = $row->meta_mes;

                    // Obtener valores de cada día
                    $lunes = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '2')->first();
                    $martes = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '3')->first();
                    $miercoles = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '4')->first();
                    $jueves = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '5')->first();
                    $viernes = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '6')->first();
                    $dev_mes_acum = collect($data_dev_acum)->where('cod_unif', '=', $cod_unif)->first();

                    // Incrementar la fila solo una vez
                    $fila_inicio++;

                    // Asignar valores a las celdas
                    $sheet->setCellValue("A{$fila_inicio}", $i);
                    $sheet->setCellValue("B{$fila_inicio}", $cod_unif);
                    $sheet->mergeCells("C{$fila_inicio}:E{$fila_inicio}");
                    $sheet->setCellValue("C{$fila_inicio}", $row->nom_proyec);
                    $sheet->setCellValue("F{$fila_inicio}", $meta_mes);
                    $sheet->setCellValue("G{$fila_inicio}", $row->dev_mes);
                    $sheet->setCellValue("H{$fila_inicio}", ($meta_mes > 0) ? round(($row->dev_mes * 100) / $meta_mes, 2) : 0);

                    // Obtener valores semanales
                    $valoresDias = [
                        'I' => $lunes ? $lunes->dif_dev_dia : 0,
                        'J' => $martes ? $martes->dif_dev_dia : 0,
                        'K' => $miercoles ? $miercoles->dif_dev_dia : 0,
                        'L' => $jueves ? $jueves->dif_dev_dia : 0,
                        'M' => $viernes ? $viernes->dif_dev_dia : 0
                    ];

                    // Calcular el total de la semana
                    $total_semana = array_sum($valoresDias);

                    // Asignar valores diarios
                    foreach ($valoresDias as $col => $valor) {
                        $sheet->setCellValue("{$col}{$fila_inicio}", $valor);
                    }

                    // Asignar el total de la semana
                    $sheet->setCellValue("N{$fila_inicio}", $total_semana);

                    // Aplicar formato de números
                    $sheet->getStyle("F{$fila_inicio}:G{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->getStyle("H{$fila_inicio}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                    $sheet->getStyle("I{$fila_inicio}:N{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');

                    // Ajustar altura de la fila
                    $sheet->getRowDimension($fila_inicio)->setRowHeight(80);

                    // Aplicar estilos a la fila
                    $sheet->getStyle("A{$fila_inicio}:N{$fila_inicio}")->applyFromArray([
                        'font' => ['bold' => false, 'size' => 20],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                    ]);

                    // Ajustar el texto de la columna C
                    $sheet->getStyle("C{$fila_inicio}")->getAlignment()->setWrapText(true);
                    $sheet->getStyle("C{$fila_inicio}")->applyFromArray([
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_LEFT]
                    ]);
                }

                $fila_inicio++;
            }
            // Procesar datos adicionales
            if (count($data_hoy_adicional) > 0) {
                $sheet->mergeCells("A{$fila_inicio}:N{$fila_inicio}");
                $sheet->setCellValue("A{$fila_inicio}", "DEVENGADOS NO PROGRAMADOS");
                $sheet->getStyle("A{$fila_inicio}:N{$fila_inicio}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 18],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C4D79B']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                ]);

                $sheet->getRowDimension($fila_inicio)->setRowHeight(30);
                $fila_inicio++;

                foreach ($data_hoy_adicional as $key => $row) {
                    $total_semana = 0;
                    $cod_unif = $row->cod_unif;
                    $meta_mes = $row->meta_mes;

                    // Obtener valores diarios
                    $lunes = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '2')->first();
                    $martes = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '3')->first();
                    $miercoles = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '4')->first();
                    $jueves = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '5')->first();
                    $viernes = collect($data_dia)->where('cod_unif', '=', $cod_unif)->where('dia', '=', '6')->first();
                    $dev_mes_acum = collect($data_dev_acum)->where('cod_unif', '=', $cod_unif)->first();

                    $sheet->setCellValue("B{$fila_inicio}", $cod_unif);
                    $sheet->mergeCells("C{$fila_inicio}:E{$fila_inicio}");
                    $sheet->setCellValue("C{$fila_inicio}", $row->nom_proyec);
                    $sheet->setCellValue("F{$fila_inicio}", $meta_mes);
                    $sheet->setCellValue("G{$fila_inicio}", $row->dev_mes);
                    $sheet->setCellValue("H{$fila_inicio}", ($meta_mes > 0) ? round(($row->dev_mes * 100) / $meta_mes, 2) : 0);

                    // Calcular valores diarios y total de la semana
                    $valoresDias = [
                        'I' => $lunes ? $lunes->dif_dev_dia : 0,
                        'J' => $martes ? $martes->dif_dev_dia : 0,
                        'K' => $miercoles ? $miercoles->dif_dev_dia : 0,
                        'L' => $jueves ? $jueves->dif_dev_dia : 0,
                        'M' => $viernes ? $viernes->dif_dev_dia : 0
                    ];

                    $total_semana = array_sum($valoresDias);

                    // Asignar valores a las celdas de los días
                    foreach ($valoresDias as $col => $valor) {
                        $sheet->setCellValue("{$col}{$fila_inicio}", $valor);
                    }

                    // Total de la semana
                    $sheet->setCellValue("N{$fila_inicio}", $total_semana);

                    // Formato de números
                    $sheet->getStyle("F{$fila_inicio}:G{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->getStyle("H{$fila_inicio}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                    $sheet->getStyle("I{$fila_inicio}:N{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');

                    // Altura de fila
                    $sheet->getRowDimension($fila_inicio)->setRowHeight(80);

                    // Aplicar estilos generales
                    $sheet->getStyle("A{$fila_inicio}:N{$fila_inicio}")->applyFromArray([
                        'font' => ['bold' => false, 'size' => 20],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
                    ]);

                    // Ajustar texto en la columna C
                    $sheet->getStyle("C{$fila_inicio}")->getAlignment()->setWrapText(true);
                    $sheet->getStyle("C{$fila_inicio}")->applyFromArray([
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_LEFT]
                    ]);

                    // Incrementar la fila
                    $fila_inicio++;
                }
            }
        }

        $t_cantidad = collect($data_hoy)->where('meta_mes', '!=', 0)->count();
        $sheet->setCellValue("A{$fila_inicio}", $t_cantidad);
        $sheet->mergeCells("B{$fila_inicio}:E{$fila_inicio}");
        $sheet->setCellValue("B{$fila_inicio}", 'TOTAL');
        $sheet->setCellValue("F{$fila_inicio}", $t_programacion);
        $sheet->setCellValue("G{$fila_inicio}", $t_ejecucion);
        $sheet->setCellValue("H{$fila_inicio}", $t_programacion > 0 ? ($t_ejecucion * 100 / $t_programacion) : 0);
        $sheet->setCellValue("I{$fila_inicio}", $t_lunes);
        $sheet->setCellValue("J{$fila_inicio}", $t_martes);
        $sheet->setCellValue("K{$fila_inicio}", $t_miercoles);
        $sheet->setCellValue("L{$fila_inicio}", $t_jueves);
        $sheet->setCellValue("M{$fila_inicio}", $t_viernes);
        $sheet->setCellValue("N{$fila_inicio}", $t_semana_total);

        $sheet->getStyle("A{$fila_inicio}:N{$fila_inicio}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 20],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'A9D08E']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ]);

        $sheet->getStyle("F{$fila_inicio}:G{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("H{$fila_inicio}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
        $sheet->getStyle("I{$fila_inicio}:N{$fila_inicio}")->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getRowDimension($fila_inicio)->setRowHeight(40);

        $sheet->getStyle("A{$fila_inicio}:N{$fila_inicio}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 22],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ]);

        //FIN GRUPO 5

        // Ajustar la impresión
        // Establecer área de impresión
        $sheet->getPageSetup()->setPrintArea('A1:P' . $fila_inicio);

        // Configurar orientación y tamaño del papel
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A3);

        // Ajuste de impresión
        $sheet->getPageSetup()->setFitToHeight(0);

        // Configurar márgenes de la página
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.25);
        $sheet->getPageMargins()->setLeft(0.25);
        $sheet->getPageMargins()->setBottom(0.25);
        $sheet->getPageSetup()->setFitToWidth(1);

        $fecha = date('d-m-Y');
        $nombreArchivo = "{$fecha}.xlsx";

        // Crear archivo Excel
        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);

        // Guardar en archivo temporal
        $filePath = tempnam(sys_get_temp_dir(), 'reporte_diario_') . '.xlsx';
        $writer->save($filePath);

        // Descargar y eliminar
        return response()->download($filePath, $nombreArchivo)->deleteFileAfterSend(true);
    }



    public function reporte_diario_fin_mes(Request $request)
    {

        $mes = $request['mes'];


        $data = DB::table("vw_pry_dev_ejecutoras_total")->select(DB::RAW("sum(cantida) as cantida,
            sum(pim_dia) as pim_dia,
            sum(certificacion_dia) as certificacion_dia,
            sum(dev_dia) as dev_dia,
            sum(dif_dev_dia) as dif_dev_dia,
            sum(girado_dia) as girado_dia,
            sum(a_fisico) as a_fisico,
            sum(enero) as enero,
            sum(febrero) as febrero,
            sum(marzo) as marzo,
            sum(abril) as abril,
            sum(mayo) as mayo,
            sum(junio) as junio,
            sum(julio) as julio,
            sum(agosto) as agosto,
            sum(septiembre) as septiembre,
            sum(octubre) as octubre,
            sum(noviembre) as noviembre,
            sum(diciembre) as diciembre,
            sum(comp_anual_dia) as comp_anual_dia,
            sum(ate_comp_anual_dia) as ate_comp_anual_dia,
            sum(dev_dia_real) as dev_dia_real,
            sum(mes_actual) as mes_actual,
            sum(dev_ant) as dev_ant,
            sum(pia_dia) as pia_dia,
            sum(m_enero) as m_enero,
            sum(m_febrero) as m_febrero,
            sum(m_marzo) as m_marzo,
            sum(m_abril) as m_abril,
            sum(m_mayo) as m_mayo,
            sum(m_junio) as m_junio,
            sum(m_julio) as m_julio,
            sum(m_agosto) as m_agosto,
            sum(m_setiembre) as m_setiembre,
            sum(m_octubre) as m_octubre,
            sum(m_noviembre) as m_noviembre,
            sum(m_diciembre) as m_diciembre"))
            ->leftJoin(DB::RAW("(select * from meta_mef where fecha_subida = (select max(fecha_subida) from meta_mef)) as meta_mef"), function ($join) {
                $join->on("vw_pry_dev_ejecutoras_total.anio", '=', DB::RAW("meta_mef.anio::text"))->on("vw_pry_dev_ejecutoras_total.ger_direc", '=', "direc_uei");
            })->first();

        $data_metas = DB::table("vw_pry_dev_ejecutoras_2")->select(DB::RAW("vw_pry_dev_ejecutoras_2.*,m_enero,m_febrero,m_marzo,m_abril,m_mayo,m_junio,m_julio,m_agosto,m_setiembre,m_octubre,m_noviembre,m_diciembre,
                cant_enero,cant_febrero,cant_marzo,cant_abril,cant_mayo,cant_junio,cant_julio,cant_agosto,cant_setiembre,cant_octubre,cant_noviembre,cant_diciembre,(pim_dia - certificacion_dia) as por_certificar,
                case
                when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
                when ger_direc in ('LIQUIDACION DE OBRAS') then 2
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
                else 0 end as  orden,m_enero - enero as pen_enero,m_febrero - febrero as pen_febrero,m_marzo - marzo as pen_marzo,
                m_abril - abril as pen_abril,m_mayo - mayo as pen_mayo,m_junio - junio as pen_junio,
                m_julio - julio as pen_julio,m_agosto - agosto as pen_agosto,m_setiembre - septiembre as pen_setiembre,
                m_octubre - octubre as pen_octubre,m_noviembre - noviembre as pen_noviembre,m_diciembre - diciembre as pen_diciembre"))
            ->leftJoin(DB::RAW("(select anio,ger_direc as direc_uei,sum(m_enero) as m_enero,sum(m_febrero) as m_febrero,sum(m_marzo) as m_marzo,sum(m_abril) as m_abril,sum(m_mayo) as m_mayo,sum(m_junio) as m_junio,
                sum(m_julio) as m_julio,sum(m_agosto) as m_agosto,sum(m_setiembre) as m_setiembre,sum(m_octubre) as m_octubre,sum(m_noviembre) as m_noviembre,sum(m_diciembre) as m_diciembre,
                sum(case when m_enero = 0 or m_enero is null then 0 else 1 end) as cant_enero,sum(case when m_febrero = 0 or m_febrero is null then 0 else 1 end) as cant_febrero,
                sum(case when m_marzo = 0 or m_marzo is null then 0 else 1 end) as cant_marzo,sum(case when m_abril = 0 or m_abril is null then 0 else 1 end) as cant_abril,
                sum(case when m_mayo = 0 or m_mayo is null then 0 else 1 end) as cant_mayo,sum(case when m_junio = 0 or m_junio is null then 0 else 1 end) as cant_junio,
                sum(case when m_julio = 0 or m_julio is null then 0 else 1 end) as cant_julio,sum(case when m_agosto = 0 or m_agosto is null then 0 else 1 end) as cant_agosto,
                sum(case when m_setiembre = 0 or m_setiembre is null then 0 else 1 end) as cant_setiembre,sum(case when m_octubre = 0 or m_octubre is null then 0 else 1 end) as cant_octubre,
                sum(case when m_noviembre = 0 or m_noviembre is null then 0 else 1 end) as cant_noviembre,sum(case when m_diciembre = 0 or m_diciembre is null then 0 else 1 end) as cant_diciembre
                from meta_mef_proyecto					
                inner join vw_total_proyectos on meta_mef_proyecto.codigo_unico = vw_total_proyectos.cod_unif 
                where fecha_subida = (select max(fecha_subida) from meta_mef_proyecto)
                group by anio,ger_direc) as meta_mef"), function ($join) {
                $join->on("vw_pry_dev_ejecutoras_2.anio", '=', DB::RAW("meta_mef.anio::text"))->on("vw_pry_dev_ejecutoras_2.ger_direc", '=', "direc_uei");
            })->orderBy('orden')->get();

        // $data_dia = DB::table("vw_proyectos_diario")->select()->get();

        // $data_hoy = DB::table("vw_proyectos_diario")->select()->where('fecha',DB::RAW("(select max(fecha) from vw_proyectos_diario)"))->orderBy("meta_mes","desc")->orderBy("dev_mes","desc")->get();
        $data_dev_acum = DB::table("vw_proyectos_diario_dev_acu")->select()->get();

        // dd($data_hoy);
        $data_dia = collect(DB::select("
            SELECT * 
            FROM sp_proyectos_por_mes(?) AS (
                dia TEXT,
                num_semana DOUBLE PRECISION,
                fecha_real TIMESTAMP,
                cod_unif VARCHAR,
                dev_dia NUMERIC,
                dev_mes DOUBLE PRECISION,
                nom_proyec TEXT,
                meta_mes NUMERIC,
                adicional TEXT,
                considerar TEXT,
                ger_direc TEXT,
                fecha date,
                dif_dev_dia numeric
            )
        ", [$mes]));

        $data_hoy = collect(DB::select("
            SELECT *
            FROM (
                SELECT * 
                FROM sp_proyectos_por_mes(?) AS (
                    dia TEXT,
                    num_semana DOUBLE PRECISION,
                    fecha_real TIMESTAMP,
                    cod_unif VARCHAR,
                    dev_dia NUMERIC,
                    dev_mes DOUBLE PRECISION,
                    nom_proyec TEXT,
                    meta_mes NUMERIC,
                    adicional TEXT,
                    considerar TEXT,
                    ger_direc TEXT,
                    fecha date,
                    dif_dev_dia numeric
                )
            ) subquery
            WHERE fecha = (SELECT MAX(fecha) FROM (
                SELECT * 
                FROM sp_proyectos_por_mes(?) AS (
                    dia TEXT,
                    num_semana DOUBLE PRECISION,
                    fecha_real TIMESTAMP,
                    cod_unif VARCHAR,
                    dev_dia NUMERIC,
                    dev_mes DOUBLE PRECISION,
                    nom_proyec TEXT,
                    meta_mes NUMERIC,
                    adicional TEXT,
                    considerar TEXT,
                    ger_direc TEXT,
                    fecha date,
                    dif_dev_dia numeric
                )
            ) max_fecha)
            ORDER BY meta_mes DESC, dev_mes DESC
        ", [$mes, $mes]));



        // $resumen_pliego = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->select(DB::RAW("count(*) as cantidad,ger_direc,sum(pim_dia) as pim,sum(dev_dia) as dev_dia,case when sum(pim_dia)>0 then sum(dev_dia)*100/sum(pim_dia) else 0 end avance,
        //     sum(certificacion_dia) as certificado,case when sum(pim_dia)>0 then sum(certificacion_dia)*100/sum(pim_dia) else 0 end avance_certificado,
        //     case
        //         when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
        //         when ger_direc in ('LIQUIDACION DE OBRAS') then 2
        //         when ger_direc in ('INICIATIVA A LA COMPETITIVIDAD') then 3
        //         when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
        //         when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
        //         when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
        //         when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
        //         when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
        //         when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
        //         when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
        //         when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
        //         when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
        //     else 0 end as  orden"))->groupBy("ger_direc")->orderBy("orden")->get();

        $query_pliego = "
            WITH fecha_calculada AS (
                SELECT sp_min_fecha_por_mes(?) AS fecha_minima
            )
            SELECT  
                COUNT(*) AS cantidad,
                ger_direc,
                SUM(pim_dia) AS pim,
                SUM(dev_dia) AS dev_dia,
                CASE 
                    WHEN SUM(pim_dia) > 0 THEN SUM(dev_dia) * 100 / SUM(pim_dia) 
                    ELSE 0 
                END AS avance,
                SUM(certificacion_dia) AS certificado,
                CASE 
                    WHEN SUM(pim_dia) > 0 THEN SUM(certificacion_dia) * 100 / SUM(pim_dia) 
                    ELSE 0 
                END AS avance_certificado,
                CASE
                    WHEN ger_direc IN ('ESTUDIOS DE PRE-INVERSION') THEN 1
                    WHEN ger_direc IN ('LIQUIDACION DE OBRAS') THEN 2
                    WHEN ger_direc IN ('INICIATIVA A LA COMPETITIVIDAD') THEN 3
                    WHEN ger_direc IN ('GERENCIA REGIONAL DE INFRAESTRUCTURA') THEN 4
                    WHEN ger_direc IN ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') THEN 5
                    WHEN ger_direc IN ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') THEN 6
                    WHEN ger_direc IN ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') THEN 7
                    WHEN ger_direc IN ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') THEN 8
                    WHEN ger_direc IN ('DIRECCION REGIONAL DE AGRICULTURA') THEN 9
                    WHEN ger_direc IN ('GERENCIA SUB REGIONAL LIMA SUR') THEN 10
                    WHEN ger_direc IN ('DIRECCION REGIONAL DE SALUD') THEN 11
                    WHEN ger_direc IN ('DIRECCION REGIONAL DE EDUCACION') THEN 12
                    ELSE 0 
                END AS orden
            FROM grli_pip_seguimiento_ejecucion_financiera
            INNER JOIN vw_total_proyectos 
                ON vw_total_proyectos.cod_unif = grli_pip_seguimiento_ejecucion_financiera.cod_unif
            CROSS JOIN fecha_calculada
            WHERE fecha = fecha_calculada.fecha_minima
            AND fuente_financiamiento IS NULL
            GROUP BY ger_direc
        ";

        // Ejecutar la consulta y pasar el parámetro del mes
        // $resumen_pliego = collect(DB::select($query_pliego, [$mes]));
        $resumen_pliego = collect(DB::select($query_pliego, [$mes]))->map(function ($item) {
            return (array) $item;
        });

        // dd($resumen_pliego);


        // $resumen_pliego_total = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->select(DB::RAW("count(*) as total_pry, sum(pim_dia) as pim,sum(dev_dia) as dev_dia,case when sum(pim_dia)>0 then sum(dev_dia)*100/sum(pim_dia) else 0 end avance,
        // sum(certificacion_dia) as certificado,case when sum(pim_dia)>0 then sum(certificacion_dia)*100/sum(pim_dia) else 0 end avance_certificado"))
        // ->first();

        $query_pliego_total = "
            WITH fecha_calculada AS (
                SELECT sp_min_fecha_por_mes(?) AS fecha_minima
            )
            SELECT 
                count(*) AS total_pry, 
                sum(pim_dia) AS pim, 
                sum(dev_dia) AS dev_dia, 
                CASE WHEN sum(pim_dia) > 0 THEN sum(dev_dia) * 100 / sum(pim_dia) ELSE 0 END AS avance,
                sum(certificacion_dia) AS certificado,
                CASE WHEN sum(pim_dia) > 0 THEN sum(certificacion_dia) * 100 / sum(pim_dia) ELSE 0 END AS avance_certificado
            FROM grli_pip_seguimiento_ejecucion_financiera
            CROSS JOIN fecha_calculada
            WHERE fecha = fecha_calculada.fecha_minima
            AND fuente_financiamiento IS NULL
            AND anio = date_part('year', CURRENT_DATE)::text;
        ";


        $resumen_pliego_total = collect(DB::select($query_pliego_total, [$mes]))->first();


        // dd($resumen_pliego_total->total_pry);


        // dd($resumen_pliego);

        $historial_mensual = DB::table("vw_bi_inf_financiera_2")->select(DB::RAW("sum(enero) AS enero, sum(febrero) AS febrero, sum(marzo) AS marzo, sum(abril) AS abril, sum(mayo) AS mayo,
        sum(junio) AS junio, sum(julio) AS julio, sum(agosto) AS agosto,
        sum(septiembre) AS septiembre, sum(octubre) AS octubre, sum(noviembre) AS noviembre, sum(diciembre) AS diciembre"))->first();

        $historial_mensual_meta = DB::table("meta_mef")->select(DB::RAW("'MEF' as info,sum(m_enero) as m_enero,sum(m_febrero) as m_febrero,sum(m_marzo) as m_marzo,sum(m_abril) as m_abril,sum(m_mayo) as m_mayo,
        sum(m_junio) as m_junio,sum(m_julio) as m_julio,sum(m_agosto) as m_agosto,sum(m_setiembre) as m_setiembre,sum(m_octubre) as m_octubre,
        sum(m_noviembre) as m_noviembre,sum(m_diciembre) as m_diciembre"))
            ->where("fecha_subida", "=", DB::RAW("(select max(fecha_subida) from meta_mef where anio=date_part('year'::text, now()))"))->first();

        $mef = DB::table("meta_mef")->select(DB::RAW("'MEF' as info,sum(m_enero) as m_enero,sum(m_febrero) as m_febrero,sum(m_marzo) as m_marzo,sum(m_abril) as m_abril,sum(m_mayo) as m_mayo,
        sum(m_junio) as m_junio,sum(m_julio) as m_julio,sum(m_agosto) as m_agosto,sum(m_setiembre) as m_setiembre,sum(m_octubre) as m_octubre,
        sum(m_noviembre) as m_noviembre,sum(m_diciembre) as m_diciembre"))
            ->where("fecha_subida", "=", DB::RAW("(select max(fecha_subida) from meta_mef where anio=date_part('year'::text, now()))"));

        $mefvs_formato12b = DB::table("vw_formato12b_proyecto")->select(DB::RAW("'FORMATO 12-B' as info,sum(a_enero) as a_enero,sum(a_febrero) as a_febrero,sum(a_marzo) as a_marzo,sum(a_abril) as a_abril,sum(a_mayo) as a_mayo,
        sum(a_junio) as a_junio,sum(a_julio) as a_julio,sum(a_agosto) as a_agosto,sum(a_setiembre) as a_setiembre,sum(a_octubre) as a_octubre,
        sum(a_noviembre) as a_noviembre,sum(a_diciembre) as a_diciembre"))
            ->union($mef)->get();

        $fecha = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->select(DB::RAW("max(fecha) as fecha"))->first();
        $fecha_acu = DB::table("vw_proyectos_diario_dev_acu")->select(DB::RAW("max(fecha_max) as fecha"))->first();
        $filename = "Reporte Diario " . $fecha->fecha . ".xls";
        return response()
            ->view("export.template.reporte_diario_fin_mes", [
                'data' => $data,
                'data_metas' => $data_metas,
                'data_dia' => $data_dia,
                'data_hoy' => $data_hoy,
                'data_dev_acum' => $data_dev_acum,
                'resumen_pliego' => $resumen_pliego,
                'resumen_pliego_total' => $resumen_pliego_total,
                'historial_mensual' => $historial_mensual,
                'historial_mensual_meta' => $historial_mensual_meta,
                'mefvs_formato12b' => $mefvs_formato12b,
                'fecha' => $fecha,
                'fecha_acu' => $fecha_acu,
                'mes' => $mes
            ], 200)
            // ->header('Content-Description', 'File Transfer')
            // ->header('Content-Type', 'application/vnd.ms-excel')
            // ->header('Content-Disposition', 'attachment; filename=reportediario.xls')
            // ->header('Content-Transfer-Encoding', 'binary')
            // ->header('Connection', 'Keep-Alive')
            // ->header('Expires', '0')
            // ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            // ->header('Pragma', 'public');
            // ->header("Content-type","application/vnd.ms-excel")
            // ->header("Content-Disposition","attachment; filename=\"$filename\"")
            // ->header("Expires","0")
            // ->header("Cache-Control","must-revalidate", "post-check=0","pre-check=0")
            // ->header("Pragma", "public");
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename=' . basename($filename))
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate')
            ->header('Pragma', 'public');
        // ->header('Content-Length','' . filesize($filename));


        // header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        // header('Content-Disposition: attachment; filename=' . basename($file));
        // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate');
        // header('Pragma: public');
        // header('Content-Length:' . filesize($file));



    }

    public function reporte_grafico(Request $request)
    {
        //  Consulta SQL: Se convierte "avance" en decimal (0.25 en vez de 25%)
        $data = DB::select("
            SELECT puesto, gore, (avance / 100.0) AS avance
            FROM inf_financiera_rank
            WHERE fecha = (SELECT MAX(fecha) FROM inf_financiera_rank WHERE anio='2025')
            AND categoria='PLIEGO' 
            AND anio ='2025' 
            ORDER BY avance ASC
        ");

        //  Definir abreviaturas para nombres largos
        $abreviaturas = [
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AMAZONAS' => 'AMAZONAS',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE JUNIN' => 'JUNIN',
            'MUNICIPALIDAD METROPOLITANA DE LIMA' => 'LIMA METROPOLITANA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE HUANCAVELICA' => 'HUANCAVELICA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LIMA' => 'LIMA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE TACNA' => 'TACNA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE ICA' => 'ICA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE SAN MARTIN' => 'SAN MARTIN',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PUNO' => 'PUNO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PIURA' => 'PIURA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LORETO' => 'LORETO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE CAJAMARCA' => 'CAJAMARCA',
            'GOBIERNO REGIONAL DE LA PROVINCIA CONSTITUCIONAL DEL CALLAO' => 'CALLAO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AYACUCHO' => 'AYACUCHO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE MOQUEGUA' => 'MOQUEGUA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE MADRE DE DIOS' => 'MADRE DE DIOS',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE UCAYALI' => 'UCAYALI',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AREQUIPA' => 'AREQUIPA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE ANCASH' => 'ANCASH',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE CUSCO' => 'CUSCO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE TUMBES' => 'TUMBES',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LAMBAYEQUE' => 'LAMBAYEQUE',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LA LIBERTAD' => 'LA LIBERTAD',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PASCO' => 'PASCO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE APURIMAC' => 'APURIMAC',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE HUANUCO' => 'HUANUCO'
        ];

        $spreadsheet = new Spreadsheet();

        //  Crear la hoja "Datos" y llenarla con información
        $dataSheet = $spreadsheet->createSheet();
        $dataSheet->setTitle('Datos');
        $spreadsheet->setActiveSheetIndexByName('Datos');

        // Encabezados
        $dataSheet->setCellValue('A1', 'Puesto');
        $dataSheet->setCellValue('B1', 'Abreviatura');
        $dataSheet->setCellValue('C1', 'Avance');

        // Insertar datos en la hoja "Datos"
        $row = 2;
        foreach ($data as $registro) {
            $abreviatura = isset($abreviaturas[$registro->gore]) ? $abreviaturas[$registro->gore] : $registro->gore;
            $dataSheet->setCellValue("A$row", $registro->puesto);
            $dataSheet->setCellValue("B$row", "{$registro->puesto}. {$abreviatura}");
            $dataSheet->setCellValue("C$row", $registro->avance);
            $dataSheet->getStyle("C$row")->getNumberFormat()->setFormatCode('0.00%'); // Formato porcentaje
            $row++;
        }

        // Ocultar la hoja de datos
        $dataSheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);

        //  Crear la hoja del gráfico
        $spreadsheet->setActiveSheetIndex(0);
        $chartSheet = $spreadsheet->getActiveSheet();
        // --
        $chartSheet->setTitle("Ranking 2025");
        $chartSheet->setShowGridlines(false); // Ocultar cuadrículas

        // Configurar los valores del gráfico
        $lastRow = $row - 1;
        $yAxisTickValues = [new DataSeriesValues('String', "'Datos'!\$B\$2:\$B\$" . $lastRow, null, $lastRow - 1)];
        $xAxisDataValues = [new DataSeriesValues('Number', "'Datos'!\$C\$2:\$C\$" . $lastRow, null, $lastRow - 1)];

        // Crear la serie del gráfico
        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($xAxisDataValues) - 1),
            [],
            $yAxisTickValues,
            $xAxisDataValues
        );
        $series->setPlotDirection(DataSeries::DIRECTION_BAR); // Barras horizontales

        // Configurar el gráfico
        $plotArea = new PlotArea(null, [$series]);
        $chart = new Chart('', null, null, $plotArea);

        // Posicionar el gráfico
        $chart->setTopLeftPosition('M5');
        $chart->setBottomRightPosition('Q' . ($lastRow + 5));
        $chartSheet->addChart($chart);

        // Guardar el archivo en un temporal
        $tempFile = tempnam(sys_get_temp_dir(), 'reporte_ranking_') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);
        $writer->save($tempFile);

        // Enviar el archivo al navegador
        return response()->download($tempFile, 'reporte_ranking_grafico.xlsx')->deleteFileAfterSend(true);
    }

    public function generarImagenRanking()
    {
        //  Consulta SQL: Se convierte "avance" en decimal (0.25 en vez de 25%)
        $anioActual = date('Y');

        $data = DB::select("
            SELECT puesto, gore, (avance / 100.0) AS avance
            FROM inf_financiera_rank
            WHERE fecha = (
                SELECT MAX(fecha)
                FROM inf_financiera_rank
                WHERE anio = ?
            )
            AND categoria = 'PLIEGO'
            AND anio = ?
            ORDER BY avance ASC
        ", [$anioActual, $anioActual]);


        //  Definir abreviaturas para nombres largos
        $abreviaturas = [
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AMAZONAS' => 'AMAZONAS',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE JUNIN' => 'JUNIN',
            'MUNICIPALIDAD METROPOLITANA DE LIMA' => 'LIMA METRO.',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE HUANCAVELICA' => 'HUANCAVELICA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LIMA' => 'LIMA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE TACNA' => 'TACNA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE ICA' => 'ICA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE SAN MARTIN' => 'SAN MARTIN',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PUNO' => 'PUNO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PIURA' => 'PIURA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LORETO' => 'LORETO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE CAJAMARCA' => 'CAJAMARCA',
            'GOBIERNO REGIONAL DE LA PROVINCIA CONSTITUCIONAL DEL CALLAO' => 'CALLAO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AYACUCHO' => 'AYACUCHO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE MOQUEGUA' => 'MOQUEGUA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE MADRE DE DIOS' => 'MADRE DE DIOS',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE UCAYALI' => 'UCAYALI',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE AREQUIPA' => 'AREQUIPA',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE ANCASH' => 'ANCASH',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE CUSCO' => 'CUSCO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE TUMBES' => 'TUMBES',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LAMBAYEQUE' => 'LAMBAYEQUE',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE LA LIBERTAD' => 'LA LIBERTAD',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE PASCO' => 'PASCO',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE APURIMAC' => 'APURIMAC',
            'GOBIERNO REGIONAL DEL DEPARTAMENTO DE HUANUCO' => 'HUANUCO'
        ];

        // Ordenar de mayor a menor
        usort($data, function ($a, $b) {
            if ($a->avance == $b->avance) return 0;
            return ($a->avance < $b->avance) ? 1 : -1;
        });

        // Tamaño exacto A4 vertical en píxeles
        $anchoPx = round(21 * 37.8); // ≈ 811 px
        $altoPx  = round(40.18 * 37.8); // ≈ 1518 px
        $image = \Intervention\Image\ImageManagerStatic::canvas($anchoPx, $altoPx, '#ffffff');

        // Configuración
        $fontSize = 22;
        $barColor = '#4F81BD';
        $highlightColor = '#386294'; // Para LIMA
        $maxWidth = 500;
        $margenSuperior = 30;
        $margenInferior = 30;

        // Calcular avance máximo
        // Longitud máxima para 100%
        $maxWidth = 500; // píxeles

        // Distribución vertical
        $totalItems = count($data);
        $alturaDisponible = $altoPx - $margenSuperior - $margenInferior;
        $espacioEntreLineas = floor($alturaDisponible / $totalItems);
        $y = $margenSuperior + floor($espacioEntreLineas / 2);

        foreach ($data as $registro) {
            $abreviatura = isset($abreviaturas[$registro->gore]) ? $abreviaturas[$registro->gore] : $registro->gore;
            $texto = "{$registro->puesto}. {$abreviatura}";
            $porcentajeTexto = round($registro->avance * 100, 1) . '%';

            // Escalar directamente al 100%
            $barLength = $registro->avance * $maxWidth;

            // Etiqueta de texto
            $image->text($texto, 20, $y, function ($font) use ($fontSize) {
                $font->file(public_path('fonts/arialbd.ttf'));
                $font->size($fontSize);
                $font->color('#000000');
            });

            $color = ($abreviatura === 'LIMA') ? $highlightColor : $barColor;

            // Dibujar barra
            $image->rectangle(300, $y - 15, 300 + $barLength, $y + 5, function ($draw) use ($color) {
                $draw->background($color);
            });

            // Etiqueta porcentaje
            $posXPorcentaje = min(310 + $barLength, $anchoPx - 60);
            $image->text($porcentajeTexto, $posXPorcentaje, $y, function ($font) use ($fontSize) {
                $font->file(public_path('fonts/arialbd.ttf'));
                $font->size($fontSize);
                $font->color('#000000');
            });

            $y += $espacioEntreLineas;
        }
        // Guardar imagen
        $fechaActual = date('Ymd_His');
        $nombreArchivo = "ranking_{$fechaActual}.png";
        $ruta = storage_path("app/public/{$nombreArchivo}");
        $image->save($ruta);

        return $nombreArchivo;
    }
}
