<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use sayhuite\Models\ejecucion_financiera;
use sayhuite\Models\InfFinanciera;
use sayhuite\Models\Obras;
use Illuminate\Support\Facades\DB;
use sayhuite\procedures\sp_Procedures;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProyectoController extends Controller
{
  protected $sp_Procedures;
  protected $unidad;
  protected $rol;
  protected $roles_acceso_total;
  protected $gerencia;

  // CONSTRUCTOR
  public function __construct(sp_Procedures $sp_Procedures)
  {
    $this->sp_Procedures = $sp_Procedures;

    // Usamos middleware para asegurar que Auth::user() ya esté disponible
    $this->middleware(function ($request, $next) {
      $unidad = Auth::user()->unidad->first();
      $roles  = Auth::user()->roles->first();

      $this->unidad   = $unidad;
      $this->rol      = $roles ? strtoupper($roles->display_name) : 'SIN ROL';
      $this->gerencia = $unidad ? $unidad->denom : null;

      $this->roles_acceso_total = [
        'OPMI',
        'PRESUPUESTO',
        'ADMINISTRADOR',
        'ALTA DIRECCIÓN'
      ];

      // Si quieres, las compartes con todas las vistas
      view()->share([
        'unidad' => $this->unidad,
        'rol' => $this->rol,
        'gerencia' => $this->gerencia,
        'roles_acceso_total' => $this->roles_acceso_total,
      ]);

      return $next($request);
    });
  }
  // FIN PROCEDURES

  public function index()
  {

    $fecha_financiera = ejecucion_financiera::select('fecha')
      ->where("fecha", "=", DB::raw("(SELECT MAX(fecha) FROM grli_pip_seguimiento_ejecucion_financiera)"))
      ->groupBy("fecha")->first();

    return View('proyecto.grupoproyecto', ['fecha_financiera' => $fecha_financiera]);
  }

  public function table_financiera(Request $request)
  {
    $input = $request->all();

    // if ($input['anio']=="2018") {
    //   $fecha_data=ejecucion_financiera::select(DB::raw('(SELECT MAX(fecha) FROM grli_pip_seguimiento_ejecucion_financiera) as fecha'))->where("anio","=",$input['anio'])->whereNull("fuente_financiamiento")->first();
    //   $fecha=$fecha_data->fecha;
    // }else {
    //   $fecha_data=ejecucion_financiera::select(DB::raw('(SELECT MAX(fecha) FROM grli_pip_seguimiento_ejecucion_financiera) as fecha'))->where("anio","=",$input['anio'])->whereNull("fuente_financiamiento")->first();
    //   $fecha=$fecha_data->fecha;
    // }
    $fecha = ejecucion_financiera::where("anio", "=", $input['anio'])->whereNull("fuente_financiamiento")->max('fecha');

    if ($input['ambito'] == 'EJECUTORA') {
      $ger_direc = ejecucion_financiera::select("ger_direc", "orden", DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pia_dia) as pia_dia,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
               cod_unif,
               case when ger_direc is null then 'OTROS' else ger_direc end as ger_direc,
               case
                 when nom_proyec in ('ESTUDIOS DE PRE-INVERSION') and ger_direc is null then 1
                 when nom_proyec in ('LIQUIDACION DE OBRAS') and ger_direc is null then 2
                 when nom_proyec in ('INICIATIVA A LA COMPETITIVIDAD') and ger_direc is null then 3
                 when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
                 when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
                 when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
                 when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
                 when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
                 when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
                 when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
                 when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
                 when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
                 else 0 end as  orden,
                 m_pip,
                 m_deveng_a,
                 a_fisico
              FROM
               grli_pip_total_priori
              UNION
              SELECT
               cod_unif,
               'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
               7,0,0,0
              FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->groupBy('ger_direc')
        ->groupBy('orden');
      $uesede = ejecucion_financiera::select(DB::raw("'UE SEDE' as ger_direc, -1 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                  SUM(pia_dia) as pia_dia,
                  SUM(pim_dia) as pim_dia,
                  SUM(certificacion_dia) as certificacion_dia,
                  SUM(comp_anual_dia) as comp_anual_dia,
                  SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                  SUM(dev_dia) as dev_dia,
                  SUM(girado_dia) as girado_dia,
                  SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                  SUM(m_deveng_a) as m_deveng_a,
                  SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("( SELECT
                   cod_unif,
                   case when ger_direc is null then 'OTROS' else ger_direc end as ger_direc,
                   m_pip,
                   m_deveng_a,
                   a_fisico
                  FROM
                   grli_pip_total_priori
                  UNION
                  SELECT
                   cod_unif,
                   'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',0,0,0
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'DIRECCION REGIONAL DE EDUCACION', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA']);

      $gob_reg = $ger_direc->union($uesede)->orderBy('orden')->get();
    } elseif ($input['ambito'] == 'PROVINCIA') {
      $ger_direc = ejecucion_financiera::select("nom_prov as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pia_dia) as pia_dia,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
                 cod_unif as cod_unif,
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                 m_pip,
                 m_deveng_a,
                 a_fisico
                FROM
                 grli_pip_total_priori
                UNION
                SELECT
                 cod_unif as cod_unif,
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                 0,0,0
              FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->groupBy('nom_prov')
        ->orderBy('pim_dia', 'desc');

      $gob_reg = $ger_direc->get();
    } elseif ($input['ambito'] == 'ETAPA') {
      $ger_direc = ejecucion_financiera::select("etapa as ger_direc", DB::raw("-2 as orden,orden as ord,COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pia_dia) as pia_dia,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
             cod_unif ,
             CASE
             WHEN grli_pip_total_priori.etapa is not null THEN etapa 
             ELSE 'OTROS'::text
             END AS etapa,
              case
                when etapa in ('CERRADO') then '1'
                when etapa in ('EN PROCESO DE LIQUIDACION') then '2'
                when etapa in ('CULMINADO') then '3'
                when etapa in ('EJECUCION FISICA') then '4'
                when etapa in ('EXPEDIENTE TECNICO') then '5'
                when etapa in ('PARALIZADO') then '6'
                when etapa in ('VIABLE') then '7'
                when etapa in ('APROBADO') then '8'
                when etapa in ('OTROS') then '9'
                else 10 end as  orden,
               m_pip,
               m_deveng_a,
               a_fisico
            FROM
             grli_pip_total_priori
            UNION
            SELECT
             cod_unif,
             'PROCOMPITE',
             '8',0,0,0
            FROM
            grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->groupBy('etapa')
        ->groupBy('orden')
        ->orderBy('ord');

      $gob_reg = $ger_direc->get();
    } elseif ($input['ambito'] == 'SECTOR') {
      $ger_direc = ejecucion_financiera::select("sector as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pia_dia) as pia_dia,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
               cod_unif,
               case when sector is null then 'OTROS' else sector end as sector,
               m_pip,
               m_deveng_a,
               a_fisico
               FROM
                grli_pip_total_priori
               UNION
               SELECT
               cod_unif,
               'PROCOMPITE',
               0,0,0
               FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->groupBy('sector')
        ->orderBy('pim_dia', 'desc');

      $gob_reg = $ger_direc->get();
    } elseif ($input['ambito'] == 'FUENTE') {
      $ger_direc = ejecucion_financiera::select("fuente_financiamiento as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pia_dia) as pia_dia,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
               cod_unif,
               m_pip,
               m_deveng_a,
               a_fisico
               FROM
                grli_pip_total_priori
               UNION
               SELECT
                  cod_unif,
                  m_pip,m_devenacu,a_fisico::numeric
                  FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->whereNotNull("fuente_financiamiento")
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->groupBy('fuente_financiamiento')
        ->orderBy('pim_dia', 'desc');

      $gob_reg = $ger_direc->get();
    } else {
      // if ($input['anio'] == '2023') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion");
      // } 
      // elseif ($input['anio'] == '2022') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2022");
      // }
      // elseif ($input['anio'] == '2021') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2021");
      // }elseif ($input['anio'] == '2020') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2020");
      // } elseif ($input['anio'] == '2019') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2019");
      // } elseif ($input['anio'] == '2018') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2018");
      // } elseif ($input['anio'] == '2017') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2017");
      // } elseif ($input['anio'] == '2016') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2016");
      // } elseif ($input['anio'] == '2015') {
      //   $gob_reg = DB::select("select * from vw_data_clasificacion_2015");
      // }

      $gob_reg = DB::select("select * from sp_proyecto(" . (int)$input['anio'] . ")");


      // $gob_reg = DB::select("select * from vw_data_clasificacion2 where fecha='".$fecha."'");
    }

    $Headers = ejecucion_financiera::select(DB::raw("
          COUNT(plist.cod_unif) as cant_proyectos,
          SUM(pia_dia) as pia_dia,
          SUM(pim_dia) as pim_dia,
          SUM(certificacion_dia) as certificacion_dia,
          SUM(comp_anual_dia) as comp_anual_dia,
          SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
          SUM(dev_dia) as dev_dia,
          SUM(girado_dia) as girado_dia,
          SUM(dif_pia_dia) as dif_pia_dia,
          SUM(dif_pim_dia) as dif_pim_dia,
          SUM(dif_certificacion_dia) as dif_certificacion_dia,
          SUM(dif_comp_anual_dia) as dif_comp_anual_dia,
          SUM(dif_ate_comp_anual_dia) as dif_ate_comp_anual_dia,
          SUM(dif_dev_dia) as dif_dev_dia,
          SUM(dif_girado_dia) as dif_girado_dia,
          COALESCE(SUM(case when primera_aparicion = 1::bit then 1 end),0) as nuevos,
          SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
          SUM(m_deveng_a) as m_deveng_a,
          SUM(a_fisico) as a_fisico,
          fecha"))
      ->join(DB::raw("(SELECT
           cod_unif,
             m_pip,
             m_deveng_a,
             a_fisico
          FROM
           grli_pip_total_priori
          UNION
          SELECT
           cod_unif,
           m_pip,m_devenacu,a_fisico::numeric
          FROM
           grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
      ->where("fecha", "=", $fecha)
      ->where("anio", "=", $input['anio'])
      ->whereNull("fuente_financiamiento")
      ->groupBy("fecha")->first();



    return Response([
      'gob_reg' => $gob_reg,
      'Headers' => $Headers,
      'fecha_financiera'   => $fecha

    ]);
  }

  public function table_financiera_exportar(Request $request)
  {
    $input = $request->all();
    $data = $this->table_financiera($request);
    $data = collect(json_decode($data->getContent()));
    $gob_reg = $data['gob_reg'];
    $headers = $data['Headers'];
    $fecha = $data['fecha_financiera'];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('First sheet');

    $anio = date('Y');
    $sheet->mergeCells('A1:N1');
    $sheet->setCellValue('A1', 'PROYECTOS DE INVERSION PUBLICA DEL GOBIERNO REGIONAL DE LIMA - POR UNIDAD EJECUTORA');
    $sheet->getStyle('A1:N1')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
    $sheet->getStyle('A1:N1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');

    $headers = [
      'N°',
      'UNIDAD EJECUTORA',
      'MONTO INV. ACT.',
      'DEVEN. ACUM. ACT.',
      'AVANCE ACUM. ACT.',
      'PIA ' . $anio,
      'PIM ' . $anio,
      'CERTIF ' . $anio,
      'COMP. ANUAL ' . $anio,
      'COMP. MENSUAL ' . $anio,
      'DEVENGADO ' . $anio,
      'GIRADO ' . $anio,
      'AVANCE ' . $anio,
      'AVANCE FISICO',
    ];
    $sheet->fromArray($headers, null, 'A3');
    $sheet->getStyle('A3:N3')->getFont()->setBold(true)->setSize(11);
    $sheet->getStyle('A3:N3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6');
    $sheet->getStyle('A3:N3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

    $columnWidths = [
      'A' => 5.86,
      'B' => 45,
      'C' => 17,
      'D' => 12,
      'E' => 17,
      'F' => 17,
      'G' => 17,
      'H' => 17,
      'I' => 17,
      'J' => 17,
      'K' => 17,
      'L' => 17,
      'M' => 11,
      'N' => 11,
    ];
    foreach ($columnWidths as $col => $width) {
      $sheet->getColumnDimension($col)->setWidth($width);
    }
    $sheet->getRowDimension(1)->setRowHeight(25.50);
    $sheet->getRowDimension(2)->setRowHeight(9.75);
    $sheet->getRowDimension(3)->setRowHeight(40);

    $fila = 4;
    foreach ($gob_reg as $value) {
      if ($value->ger_direc == "UE SEDE") {
        continue;
      }
      $avanceAcum = ($value->m_pip == 0 || $value->m_pip === null) ? 0 : round($value->dev_dia / $value->m_pip, 2);
      $sheet->fromArray([
        $value->cant_proyectos,
        $value->ger_direc,
        $value->m_pip,
        $value->dev_dia,
        $avanceAcum,
        $value->pia_dia,
        $value->pim_dia,
      ], null, 'A' . $fila);
      $sheet->getRowDimension($fila)->setRowHeight(40);
      $fila++;
    }

    $totalFila = max(4, $fila - 1);
    $sheet->getStyle('A3:N' . $totalFila)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    $sheet->getStyle('C4:G' . $totalFila)->getNumberFormat()->setFormatCode('#,##0.00');

    $filename = 'Filename.xlsx';
    $tempFile = tempnam(sys_get_temp_dir(), 'xlsx_');
    $writer = new Xlsx($spreadsheet);
    $writer->save($tempFile);

    return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
  }
  public function table_mes_financiera(Request $request)
  {
    $input = $request->all();

    if ($input['ambito'] == 'EJECUTORA') {
      $ger_direc_mes = DB::table('vw_bi_inf_financiera_2')->select(DB::raw("plist.ger_direc,COUNT(plist.cod_unif) as cant_proyectos,sum(enero::numeric(10,2)) enero ,sum(febrero::numeric(10,2)) febrero ,sum(marzo::numeric(10,2)) marzo,
              sum(abril::numeric(10,2)) abril ,sum(mayo::numeric(10,2)) mayo ,sum(junio::numeric(10,2)) junio,
              sum(julio::numeric(10,2)) julio ,sum(agosto::numeric(10,2)) agosto ,sum(septiembre::numeric(10,2)) septiembre,
              sum(octubre::numeric(10,2)) octubre ,sum(noviembre::numeric(10,2)) noviembre ,sum(diciembre::numeric(10,2)) diciembre,orden"))
        ->join(DB::raw("( SELECT
               cod_unif,
               case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
               case
               when nom_proyec in ('ESTUDIOS DE PRE-INVERSION') and ger_direc is null then 1
               when nom_proyec in ('LIQUIDACION DE OBRAS') and ger_direc is null then 2
               when nom_proyec in ('INICIATIVA A LA COMPETITIVIDAD') and ger_direc is null then 3
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
              FROM
               grli_pip_total_priori
              UNION
              SELECT
               cod_unif,
               'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
               7
              FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('vw_bi_inf_financiera_2.cod_unif::text'))
        ->groupBy('plist.ger_direc')
        ->groupBy('orden');
      $uesede_mes = DB::table('vw_bi_inf_financiera_2')->select(DB::raw("'UE SEDE' as ger_direc,COUNT(plist.cod_unif) as cant_proyectos,sum(enero::numeric(10,2)) enero ,sum(febrero::numeric(10,2)) febrero ,sum(marzo::numeric(10,2)) marzo,
              sum(abril::numeric(10,2)) abril ,sum(mayo::numeric(10,2)) mayo ,sum(junio::numeric(10,2)) junio,
              sum(julio::numeric(10,2)) julio ,sum(agosto::numeric(10,2)) agosto ,sum(septiembre::numeric(10,2)) septiembre,
              sum(octubre::numeric(10,2)) octubre ,sum(noviembre::numeric(10,2)) noviembre ,sum(diciembre::numeric(10,2)) diciembre,-1 as orden"))
        ->join(DB::raw("( SELECT
                 cod_unif,
                 case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                FROM
                 grli_pip_total_priori
                UNION
                SELECT
                 cod_unif,
                 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                FROM
                 grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('vw_bi_inf_financiera_2.cod_unif::text'))
        ->whereNotIn('plist.ger_direc', ['DIRECCION REGIONAL DE SALUD', 'DIRECCION REGIONAL DE EDUCACION', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA']);
      $gob_reg = $ger_direc_mes->union($uesede_mes)->orderBy('orden')->get();
    } elseif ($input['ambito'] == 'PROVINCIA') {
      $ger_direc_mes = DB::table('vw_bi_inf_financiera_2')->select(DB::raw("nom_prov as ger_direc,COUNT(plist.cod_unif) as cant_proyectos,sum(enero::numeric(10,2)) enero ,sum(febrero::numeric(10,2)) febrero ,sum(marzo::numeric(10,2)) marzo,
              sum(abril::numeric(10,2)) abril ,sum(mayo::numeric(10,2)) mayo ,sum(junio::numeric(10,2)) junio,
              sum(julio::numeric(10,2)) julio ,sum(agosto::numeric(10,2)) agosto ,sum(septiembre::numeric(10,2)) septiembre,
              sum(octubre::numeric(10,2)) octubre ,sum(noviembre::numeric(10,2)) noviembre ,sum(diciembre::numeric(10,2)) diciembre,-2 as orden"))
        ->join(DB::raw("(SELECT
                 cod_unif as cod_unif,
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov
                FROM
                 grli_pip_total_priori
                UNION
                SELECT
                 cod_unif as cod_unif,
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov
              FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('vw_bi_inf_financiera_2.cod_unif::text'))
        ->groupBy('nom_prov')
        ->orderBy('nom_prov', 'asc');

      $gob_reg = $ger_direc_mes->get();
    } elseif ($input['ambito'] == 'ETAPA') {
      $ger_direc_mes = InfFinanciera::select(DB::raw("etapa as ger_direc,COUNT(plist.cod_unif) as cant_proyectos,sum(dev_ene::numeric(10,2)) enero ,sum(dev_feb::numeric(10,2)) febrero ,sum(dev_mar::numeric(10,2)) marzo,
              sum(dev_abr::numeric(10,2)) Abril ,sum(dev_may::numeric(10,2)) Mayo ,sum(dev_jun::numeric(10,2)) Junio,
              sum(dev_jul::numeric(10,2)) Julio ,sum(dev_ago::numeric(10,2)) Agosto ,sum(dev_set::numeric(10,2)) Septiembre,
              sum(dev_oct::numeric(10,2)) Octubre ,sum(dev_nov::numeric(10,2)) Noviembre ,sum(dev_dic::numeric(10,2)) Diciembre,-2 orden"))
        ->join(DB::raw("( select
               cod_unif,
               CASE
              WHEN grli_pip_total_priori.etapa is not null THEN etapa 
              ELSE 'OTROS'::text
              END AS etapa,
                case
                when etapa in ('CERRADO') then '1'
                when etapa in ('EN PROCESO DE LIQUIDACION') then '2'
                when etapa in ('CULMINADO') then '3'
                when etapa in ('EJECUCION FISICA') then '4'
                when etapa in ('EXPEDIENTE TECNICO') then '5'
                when etapa in ('PARALIZADO') then '6'
                when etapa in ('VIABLE') then '7'
                when etapa in ('APROBADO') then '8'
                when etapa in ('OTROS') then '9'
                else 10 end as  orden
              FROM
               grli_pip_total_priori
              UNION
              SELECT
                 cod_unif,
                 'PROCOMPITE',
                 '8'
              FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('inf_financiera.cod_unif::text'))
        ->where("anio_financ", "=", $input['anio'])
        ->where(DB::RAW("pim::numeric"), "!=", 0)
        ->groupBy('etapa')
        ->groupBy('orden')
        ->orderBy('ord');

      $gob_reg = $ger_direc_mes->get();
    } elseif ($input['ambito'] == 'SECTOR') {
      $ger_direc_mes = InfFinanciera::select(DB::raw("sector as ger_direc,COUNT(plist.cod_unif) as cant_proyectos,sum(dev_ene::numeric(10,2)) enero ,sum(dev_feb::numeric(10,2)) febrero ,sum(dev_mar::numeric(10,2)) marzo,
              sum(dev_abr::numeric(10,2)) Abril ,sum(dev_may::numeric(10,2)) Mayo ,sum(dev_jun::numeric(10,2)) Junio,
              sum(dev_jul::numeric(10,2)) Julio ,sum(dev_ago::numeric(10,2)) Agosto ,sum(dev_set::numeric(10,2)) Septiembre,
              sum(dev_oct::numeric(10,2)) Octubre ,sum(dev_nov::numeric(10,2)) Noviembre ,sum(dev_dic::numeric(10,2)) Diciembre,sum(pim::numeric(10,2)) pim,-2 as orden"))
        ->join(DB::raw("(SELECT
                cod_unif,
                case when sector is null then 'OTROS' else sector end as sector
                FROM
                 grli_pip_total_priori
                UNION
                SELECT
                cod_unif,
                'PROCOMPITE'
              FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('inf_financiera.cod_unif::text'))
        ->where("anio_financ", "=", $input['anio'])
        ->where(DB::RAW("pim::numeric"), "!=", 0)
        ->groupBy('sector')
        ->orderBy('pim', 'desc');
      $gob_reg = $ger_direc_mes->get();
    } else {
      $ger_direc_mes = InfFinanciera::select(DB::raw("fuente_financ as ger_direc,COUNT(plist.cod_unif) as cant_proyectos,sum(dev_ene::numeric(10,2)) enero ,sum(dev_feb::numeric(10,2)) febrero ,sum(dev_mar::numeric(10,2)) marzo,
              sum(dev_abr::numeric(10,2)) Abril ,sum(dev_may::numeric(10,2)) Mayo ,sum(dev_jun::numeric(10,2)) Junio,
              sum(dev_jul::numeric(10,2)) Julio ,sum(dev_ago::numeric(10,2)) Agosto ,sum(dev_set::numeric(10,2)) Septiembre,
              sum(dev_oct::numeric(10,2)) Octubre ,sum(dev_nov::numeric(10,2)) Noviembre ,sum(dev_dic::numeric(10,2)) Diciembre,sum(pim::numeric(10,2)) pim,-2 as orden"))
        ->join(DB::raw("(SELECT
                cod_unif
                FROM
                 grli_pip_total_priori
                UNION
                SELECT
                cod_unif
              FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('inf_financiera.cod_unif::text'))
        ->where("anio_financ", "=", $input['anio'])
        ->where(DB::RAW("pim::numeric"), "!=", 0)
        ->groupBy('fuente_financ')
        ->orderBy('pim', 'desc');;
      $gob_reg = $ger_direc_mes->get();
    }

    $Headers = DB::table('vw_bi_inf_financiera_2')->select(DB::raw("
            COUNT(cod_unif) as cant_proyectos,sum(enero::numeric(10,2)) enero ,sum(febrero::numeric(10,2)) febrero ,sum(marzo::numeric(10,2)) marzo,
            sum(abril::numeric(10,2)) abril ,sum(mayo::numeric(10,2)) mayo ,sum(junio::numeric(10,2)) junio,
            sum(julio::numeric(10,2)) julio ,sum(agosto::numeric(10,2)) agosto ,sum(septiembre::numeric(10,2)) septiembre,
            sum(octubre::numeric(10,2)) octubre ,sum(noviembre::numeric(10,2)) noviembre ,sum(diciembre::numeric(10,2)) diciembre"))->first();

    return Response([
      'gob_reg' => $gob_reg,
      'Headers' => $Headers
    ]);
  }

  public function ejecucionmeta(Request $request)
  {

    $input = $request->all();
    $mes = $input['mes'];
    // if ($mes > 4 ){
    $rol    = $this->rol;
    $roles_acceso_total    = $this->roles_acceso_total;
    $gerencia = $this->gerencia;
    if (in_array($rol, $roles_acceso_total)) {
      // Usuario tiene acceso total: no filtramos por gerencia
      $data = DB::select("
        SELECT 
            vw_pry_dev_ejecutoras_2.*,
            m_enero, m_febrero, m_marzo, m_abril, m_mayo, m_junio,
            m_julio, m_agosto, m_setiembre, m_octubre, m_noviembre, m_diciembre,
            (pim_dia - certificacion_dia) as por_certificar,
            CASE
                WHEN ger_direc = 'ESTUDIOS DE PRE-INVERSION' THEN 1
                WHEN ger_direc = 'LIQUIDACION DE OBRAS' THEN 2
                WHEN ger_direc = 'INICIATIVA A LA COMPETITIVIDAD' THEN 3
                WHEN ger_direc = 'GERENCIA REGIONAL DE INFRAESTRUCTURA' THEN 4
                WHEN ger_direc = 'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES' THEN 5
                WHEN ger_direc = 'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE' THEN 6
                WHEN ger_direc = 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' THEN 7
                WHEN ger_direc = 'GERENCIA REGIONAL DE DESARROLLO SOCIAL' THEN 8
                WHEN ger_direc = 'DIRECCION REGIONAL DE AGRICULTURA' THEN 9
                WHEN ger_direc = 'GERENCIA SUB REGIONAL LIMA SUR' THEN 10
                WHEN ger_direc = 'DIRECCION REGIONAL DE SALUD' THEN 11
                WHEN ger_direc = 'DIRECCION REGIONAL DE EDUCACION' THEN 12
                ELSE 0
            END AS orden
        FROM vw_pry_dev_ejecutoras_2
        LEFT JOIN (
            SELECT * FROM meta_mef 
            WHERE fecha_subida = (SELECT MAX(fecha_subida) FROM meta_mef)
        ) AS meta_mef 
            ON vw_pry_dev_ejecutoras_2.anio = meta_mef.anio::text 
            AND vw_pry_dev_ejecutoras_2.ger_direc = direc_uei
        LEFT JOIN meta_grl 
            ON vw_pry_dev_ejecutoras_2.anio = meta_grl.anio::text 
            AND vw_pry_dev_ejecutoras_2.ger_direc = ger_direc_uei
        ORDER BY orden
    ");
    } else {
      // Usuario común: filtrar por gerencia
      $data = DB::select("
        SELECT 
            vw_pry_dev_ejecutoras_2.*,
            m_enero, m_febrero, m_marzo, m_abril, m_mayo, m_junio,
            m_julio, m_agosto, m_setiembre, m_octubre, m_noviembre, m_diciembre,
            (pim_dia - certificacion_dia) as por_certificar,
            CASE
                WHEN ger_direc = 'ESTUDIOS DE PRE-INVERSION' THEN 1
                WHEN ger_direc = 'LIQUIDACION DE OBRAS' THEN 2
                WHEN ger_direc = 'INICIATIVA A LA COMPETITIVIDAD' THEN 3
                WHEN ger_direc = 'GERENCIA REGIONAL DE INFRAESTRUCTURA' THEN 4
                WHEN ger_direc = 'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES' THEN 5
                WHEN ger_direc = 'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE' THEN 6
                WHEN ger_direc = 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' THEN 7
                WHEN ger_direc = 'GERENCIA REGIONAL DE DESARROLLO SOCIAL' THEN 8
                WHEN ger_direc = 'DIRECCION REGIONAL DE AGRICULTURA' THEN 9
                WHEN ger_direc = 'GERENCIA SUB REGIONAL LIMA SUR' THEN 10
                WHEN ger_direc = 'DIRECCION REGIONAL DE SALUD' THEN 11
                WHEN ger_direc = 'DIRECCION REGIONAL DE EDUCACION' THEN 12
                ELSE 0
            END AS orden
        FROM vw_pry_dev_ejecutoras_2
        LEFT JOIN (
            SELECT * FROM meta_mef 
            WHERE fecha_subida = (SELECT MAX(fecha_subida) FROM meta_mef)
        ) AS meta_mef 
            ON vw_pry_dev_ejecutoras_2.anio = meta_mef.anio::text 
            AND vw_pry_dev_ejecutoras_2.ger_direc = direc_uei
        LEFT JOIN meta_grl 
            ON vw_pry_dev_ejecutoras_2.anio = meta_grl.anio::text 
            AND vw_pry_dev_ejecutoras_2.ger_direc = ger_direc_uei
        WHERE vw_pry_dev_ejecutoras_2.ger_direc = ?
        ORDER BY orden
      ", [$gerencia]);
    }

    // }
    // else
    // {
    //   $data = DB::select("select vw_pry_dev_ejecutoras.*,m_enero,m_febrero,m_marzo,m_abril,m_mayo,m_junio,m_julio,m_agosto,m_setiembre,m_octubre,m_noviembre,m_diciembre,(pim_dia - certificacion_dia) as por_certificar,
    //     grl_enero, grl_febrero, grl_marzo, grl_abril, grl_mayo, grl_junio, grl_julio, grl_agosto, grl_setiembre, grl_octubre, grl_noviembre, grl_diciembre,
    //       case
    //       when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 1
    //       when ger_direc in ('LIQUIDACION DE OBRAS') then 2
    //       when ger_direc in ('INICIATIVA A LA COMPETITIVIDAD') then 3
    //       when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
    //       when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
    //       when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
    //       when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
    //       when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
    //       when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
    //       when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
    //       when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
    //       when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
    //       else 0 end as  orden
    //   from vw_pry_dev_ejecutoras
    //   inner join meta_mef on vw_pry_dev_ejecutoras.anio=meta_mef.anio::text and vw_pry_dev_ejecutoras.ger_direc=direc_uei
    //   left join meta_grl on vw_pry_dev_ejecutoras.anio=meta_grl.anio::text and vw_pry_dev_ejecutoras.ger_direc=ger_direc_uei order by orden");
    // }

    // $fecha_devengado_real = DB::table('mpp_16_ejec_marco_mensual')->max("fecha");
    $fecha_devengado_real = DB::table('grli_pip_seguimiento_ejecucion_financiera')->where('anio', date("Y"))->max('fecha');
    $pia = DB::select('select sum(pia_dia) as pia_dia from vw_grli_pip_seguimiento_ejecucion_financiera');
    return Response([
      'data' => $data,
      'fecha' => $fecha_devengado_real,
      'pia' => $pia
    ]);
  }

  public function ejecucionmeta_proyecto(Request $request)
  {
    $data = DB::select("select vw_pry_dev_proyectos.*,m_enero,m_febrero,m_marzo,m_abril,m_mayo,m_junio,m_julio,m_agosto,m_setiembre,m_octubre,m_noviembre,m_diciembre,
                (pim_dia - certificacion_dia) as por_certificar
                from vw_pry_dev_proyectos
                left join meta_mef_proyecto on vw_pry_dev_proyectos.anio=meta_mef_proyecto.anio::text and vw_pry_dev_proyectos.cod_unif=meta_mef_proyecto.codigo_unico");

    return Response([
      'data' => $data
    ]);
  }

  public function lineFinanciera(Request $request)
  {

    $input = $request->all();
    $cboselect = !isset($input['cboselect']) ? '' : $input['cboselect'];
    $ambito = !isset($input['gambito']) ? '' : $input['gambito'];
    $anio = !isset($input['ganio']) ? '' : $input['ganio'];
    $InfFinancieraDev = [];
    $certificado = [];
    $Pim = [];
    // $response = $this->financPerYear($cboselect,$ambito);
    $response = $this->sp_Procedures->sp_inf_fianciera($ambito, $cboselect, $anio);
    foreach ($response as $key => $data) {
      array_push($InfFinancieraDev, $data->dev);
      array_push($certificado, $data->acu);
      array_push($Pim, $data->pim);
    }

    if (end($InfFinancieraDev) == 0) {
      array_pop($InfFinancieraDev);
    }
    if (end($Pim) == 0) {
      array_pop($Pim);
    }
    if (end($certificado) == 0) {
      array_pop($certificado);
    }
    return [
      "devengado"      => $InfFinancieraDev,
      "pim"            => $Pim,
      "devengadoAcumulado" => $certificado
    ];
  }

  public function financPerYear($cboselect, $ambito)
  {
    $mes = date("m");
    $InfFinancieraDev = [];
    $certificado = [];
    $Pim = [];
    $Months = [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre"
    ];
    $dia = 1;
    $years = date("Y");
    if ($ambito == 'EJECUTORA') {
      if (!empty($cboselect)) {
        if ($cboselect == 'UE SEDE') {
          for ($i = 2; $i <= $mes + 1; $i++) {
            $m = $i;
            if ($mes + 1 == $i) {
              $dia = date("d");
              $years = date("Y");
              $m = $mes;
            }
            $dev = ejecucion_financiera::select(DB::RAW('SUM(dev_dia::float)'))
              ->join(DB::raw("(SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       tipo_pry,
                       sector,
                       case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                      FROM
                       grli_pip_total_priori
                      UNION
                      SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       'PROCOMPITE',
                       sector,
                       'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                    FROM
                     grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
              ->where("anio", "=", date("Y"))
              ->whereNull("fuente_financiamiento")
              ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
              ->first();

            $cert = ejecucion_financiera::select(DB::RAW('SUM(certificacion_dia::float)'))
              ->join(DB::raw("(SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       tipo_pry,
                       sector,
                       case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                      FROM
                       grli_pip_total_priori
                      UNION
                      SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       'PROCOMPITE',
                       sector,
                       'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                    FROM
                     grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
              ->where("anio", "=", date("Y"))
              ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
              ->first();

            $pm = ejecucion_financiera::select(DB::RAW('SUM(pim_dia::float)'))
              ->join(DB::raw("(SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       tipo_pry,
                       sector,
                       case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                      FROM
                       grli_pip_total_priori
                      UNION
                      SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       'PROCOMPITE',
                       sector,
                       'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                    FROM
                     grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
              ->where("anio", "=", date("Y"))
              ->whereNull("fuente_financiamiento")
              ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
              ->first();

            if (!empty($dev->sum)) {
              $dev = $dev->sum;
            } else {
              $dev = "0";
            }
            if (!empty($cert->sum)) {
              $cert = $cert->sum;
            } else {
              $cert = "0";
            }
            if (!empty($pm->sum)) {
              $pm = $pm->sum;
            } else {
              $pm = "0";
            }
            array_push($InfFinancieraDev, $dev);
            array_push($certificado, $cert);
            array_push($Pim, $pm);
          }
        } else {
          for ($i = 2; $i <= $mes + 1; $i++) {
            $m = $i;
            if ($mes + 1 == $i) {
              $dia = date("d");
              $years = date("Y");
              $m = $mes;
            }
            $dev = ejecucion_financiera::select(DB::RAW('SUM(dev_dia::float)'))
              ->join(DB::raw("(SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       tipo_pry,
                       sector,
                       case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                      FROM
                       grli_pip_total_priori
                      UNION
                      SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       'PROCOMPITE',
                       sector,
                       'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                    FROM
                     grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
              ->where("anio", "=", date("Y"))
              ->whereNull("fuente_financiamiento")
              ->where("ger_direc", "=", $cboselect)
              ->first();

            $cert = ejecucion_financiera::select(DB::RAW('SUM(certificacion_dia::float)'))
              ->join(DB::raw("(SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       tipo_pry,
                       sector,
                       case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                      FROM
                       grli_pip_total_priori
                      UNION
                      SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       'PROCOMPITE',
                       sector,
                       'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                    FROM
                     grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
              ->where("anio", "=", date("Y"))
              ->whereNull("fuente_financiamiento")
              ->where("ger_direc", "=", $cboselect)
              ->first();

            $pm = ejecucion_financiera::select(DB::RAW('SUM(pim_dia::float)'))
              ->join(DB::raw("(SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       tipo_pry,
                       sector,
                       case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                      FROM
                       grli_pip_total_priori
                      UNION
                      SELECT
                       cod_unif as cod_unif,
                       nom_proyec,
                       'PROCOMPITE',
                       sector,
                       'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                    FROM
                     grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
              ->where("anio", "=", date("Y"))
              ->whereNull("fuente_financiamiento")
              ->where("ger_direc", "=", $cboselect)
              ->first();

            if (!empty($dev->sum)) {
              $dev = $dev->sum;
            } else {
              $dev = "0";
            }
            if (!empty($cert->sum)) {
              $cert = $cert->sum;
            } else {
              $cert = "0";
            }
            if (!empty($pm->sum)) {
              $pm = $pm->sum;
            } else {
              $pm = "0";
            }
            array_push($InfFinancieraDev, $dev);
            array_push($certificado, $cert);
            array_push($Pim, $pm);
          }
        }
      } else {

        for ($i = 2; $i <= $mes + 1; $i++) {
          $m = $i;
          if ($mes + 1 == $i) {
            $dia = date("d");
            $years = date("Y");
            $m = $mes;
          }
          $dev = ejecucion_financiera::select(DB::RAW('SUM(dev_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->first();

          $cert = ejecucion_financiera::select(DB::RAW('SUM(certificacion_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->first();

          $pm = ejecucion_financiera::select(DB::RAW('SUM(pim_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     case when ger_direc is null then nom_proyec else ger_direc end as ger_direc
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     'GERENCIA REGIONAL DE DESARROLLO ECONOMICO'
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->first();

          if (!empty($dev->sum)) {
            $dev = $dev->sum;
          } else {
            $dev = "0";
          }
          if (!empty($cert->sum)) {
            $cert = $cert->sum;
          } else {
            $cert = "0";
          }
          if (!empty($pm->sum)) {
            $pm = $pm->sum;
          } else {
            $pm = "0";
          }
          array_push($InfFinancieraDev, $dev);
          array_push($certificado, $cert);
          array_push($Pim, $pm);
        }
      }
    } else {
      if (!empty($cboselect)) {
        for ($i = 2; $i <= $mes + 1; $i++) {
          $m = $i;
          if ($mes + 1 == $i) {
            $dia = date("d");
            $years = date("Y");
            $m = $mes;
          }
          $dev = ejecucion_financiera::select(DB::RAW('SUM(dev_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     nom_prov
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     nom_prov
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->where("nom_prov", "=", $cboselect)
            ->first();

          $cert = ejecucion_financiera::select(DB::RAW('SUM(certificacion_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     nom_prov
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     nom_prov
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->where("nom_prov", "=", $cboselect)
            ->first();

          $pm = ejecucion_financiera::select(DB::RAW('SUM(pim_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     nom_prov
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     nom_prov
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->where("nom_prov", "=", $cboselect)
            ->first();

          if (!empty($dev->sum)) {
            $dev = $dev->sum;
          } else {
            $dev = "0";
          }
          if (!empty($cert->sum)) {
            $cert = $cert->sum;
          } else {
            $cert = "0";
          }
          if (!empty($pm->sum)) {
            $pm = $pm->sum;
          } else {
            $pm = "0";
          }
          array_push($InfFinancieraDev, $dev);
          array_push($certificado, $cert);
          array_push($Pim, $pm);
        }
      } else {

        for ($i = 2; $i <= $mes + 1; $i++) {
          $m = $i;
          if ($mes + 1 == $i) {
            $dia = date("d");
            $years = date("Y");
            $m = $mes;
          }
          $dev = ejecucion_financiera::select(DB::RAW('SUM(dev_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     nom_prov
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     nom_prov
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->first();

          $cert = ejecucion_financiera::select(DB::RAW('SUM(certificacion_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     nom_prov
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     nom_prov
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->first();

          $pm = ejecucion_financiera::select(DB::RAW('SUM(pim_dia::float)'))
            ->join(DB::raw("(SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     tipo_pry,
                     sector,
                     nom_prov
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     cod_unif as cod_unif,
                     nom_proyec,
                     'PROCOMPITE',
                     sector,
                     nom_prov
                  FROM
                   grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->whereRaw("EXTRACT(DAY FROM fecha)=" . $dia . " and EXTRACT(MONTH FROM fecha)=" . $m . " and EXTRACT(YEAR FROM fecha)=" . $years)
            ->where("anio", "=", date("Y"))
            ->whereNull("fuente_financiamiento")
            ->first();

          if (!empty($dev->sum)) {
            $dev = $dev->sum;
          } else {
            $dev = "0";
          }
          if (!empty($cert->sum)) {
            $cert = $cert->sum;
          } else {
            $cert = "0";
          }
          if (!empty($pm->sum)) {
            $pm = $pm->sum;
          } else {
            $pm = "0";
          }

          array_push($InfFinancieraDev, $dev);
          array_push($certificado, $cert);
          array_push($Pim, $pm);
        }
      }
    }

    if (end($InfFinancieraDev) == 0) {
      array_pop($InfFinancieraDev);
    }
    if (end($Pim) == 0) {
      array_pop($Pim);
    }
    if (end($certificado) == 0) {
      array_pop($certificado);
    }
    return [
      "devengado"      => $InfFinancieraDev,
      "pim"            => $Pim,
      "devengadoAcumulado" => $certificado
    ];
  }

  public function show(Request $request)
  {
    $input = $request->all();
    $fecha = ejecucion_financiera::where("anio", "=", $input['anio'])->whereNull("fuente_financiamiento")->max('fecha');
    $filtrar = "";
    if ($input['ambito'] == 'EJECUTORA') {
      $filtrar = "ger_direc";
      $consulta_etapa = "(SELECT
                   cod_unif ,
                   case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                   CASE
                    WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                    ELSE 'OTROS'::text
                    END AS etapa,
                      case
                      when etapa in ('CERRADO') then '1'
                      when etapa in ('EN PROCESO DE LIQUIDACION') then '2'
                      when etapa in ('CULMINADO') then '3'
                      when etapa in ('EJECUCION FISICA') then '4'
                      when etapa in ('EXPEDIENTE TECNICO') then '5'
                      when etapa in ('PARALIZADO') then '6'
                      when etapa in ('VIABLE') then '7'
                      when etapa in ('APROBADO') then '8'
                      when etapa in ('OTROS') then '9'
                      else 10 end as  orden,
                     m_pip,
                     m_deveng_a,
                     a_fisico
                  FROM
                   grli_pip_total_priori
                  UNION
                  SELECT
                   cod_unif,
                   'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                   'PROCOMPITE',
                   '8',0,0,0
                  FROM
                  grli_pip_procompite ) AS plist";
      $consulta_provincia = "(SELECT
           cod_unif as cod_unif,
           case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
           m_pip,
           m_deveng_a,
           a_fisico
          FROM
           grli_pip_total_priori
          UNION
          SELECT
           cod_unif as cod_unif,
           'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
           0,0,0
          FROM
           grli_pip_procompite ) AS plist";
      $consulta_sector = "(SELECT
         cod_unif,
         case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
         case when sector is null then 'OTROS' else sector end as sector,
         m_pip,
         m_deveng_a,
         a_fisico
         FROM
          grli_pip_total_priori
         UNION
         SELECT
         cod_unif,
         'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
         'PROCOMPITE',
         0,0,0
         FROM
         grli_pip_procompite ) AS plist";
      $consulta_header = "(SELECT
             cod_unif ,
             case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
             m_pip,
             m_deveng_a,
             a_fisico
            FROM
             grli_pip_total_priori
            UNION
            SELECT
             cod_unif,
             'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',0,0,0
            FROM
            grli_pip_procompite ) AS plist";
    } elseif ($input['ambito'] == 'PROVINCIA') {
      $filtrar = "nom_prov";
      $consulta_etapa = "(SELECT
                   cod_unif ,
                   case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                   CASE
                  WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                  ELSE 'OTROS'::text
                  END AS etapa,
                    case
                    when etapa in ('CERRADO') then '1'
                    when etapa in ('EN PROCESO DE LIQUIDACION') then '2'
                    when etapa in ('CULMINADO') then '3'
                    when etapa in ('EJECUCION FISICA') then '4'
                    when etapa in ('EXPEDIENTE TECNICO') then '5'
                    when etapa in ('PARALIZADO') then '6'
                    when etapa in ('VIABLE') then '7'
                    when etapa in ('APROBADO') then '8'
                    when etapa in ('OTROS') then '9'
                    else 10 end as  orden,
                     m_pip,
                     m_deveng_a,
                     a_fisico
                  FROM
                   grli_pip_total_priori
                  UNION
                  SELECT
                   cod_unif,
                   nom_prov,
                   'PROCOMPITE',
                   '8',0,0,0
                  FROM
                  grli_pip_procompite ) AS plist";
      $consulta_ejecutora = "( SELECT
           cod_unif,
           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
           case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
           case
           when nom_proyec in ('ESTUDIOS DE PRE-INVERSION') and ger_direc is null then 1
           when nom_proyec in ('LIQUIDACION DE OBRAS') and ger_direc is null then 2
           when nom_proyec in ('INICIATIVA A LA COMPETITIVIDAD') and ger_direc is null then 3
           when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
           when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
           when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
           when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
           when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
           when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
           when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
           else 0 end as  orden,
           m_pip,
           m_deveng_a,
           a_fisico
          FROM
           grli_pip_total_priori
          UNION
          SELECT
           cod_unif,
           nom_prov,
           'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
           7,0,0,0
          FROM
           grli_pip_procompite ) AS plist";
      $consulta_ejecutora_sede = "( SELECT
            cod_unif,
            case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
            case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            nom_prov,
            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
            0,0,0
           FROM
            grli_pip_procompite ) AS plist";
      $consulta_sector = "(SELECT
           cod_unif,
           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
           case when sector is null then 'OTROS' else sector end as sector,
           m_pip,
           m_deveng_a,
           a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
           cod_unif,
           nom_prov,
           'PROCOMPITE',
           0,0,0
           FROM
           grli_pip_procompite ) AS plist";
      $consulta_header = "(SELECT
            cod_unif ,
            case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            nom_prov,0,0,0
           FROM
           grli_pip_procompite ) AS plist";
    } elseif ($input['ambito'] == 'ETAPA') {
      $filtrar = "etapa";
      $consulta_ejecutora = "( SELECT
           cod_unif,
           CASE
              WHEN grli_pip_total_priori.etapa is not null THEN etapa 
              ELSE 'OTROS'::text
              END AS etapa,
           case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
           case
           when nom_proyec in ('ESTUDIOS DE PRE-INVERSION') and ger_direc is null then 1
           when nom_proyec in ('LIQUIDACION DE OBRAS') and ger_direc is null then 2
           when nom_proyec in ('INICIATIVA A LA COMPETITIVIDAD') and ger_direc is null then 3
           when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
           when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
           when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
           when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
           when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
           when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
           when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
           else 0 end as  orden,
           m_pip,
           m_deveng_a,
           a_fisico
          FROM
           grli_pip_total_priori
          UNION
          SELECT
           cod_unif,
           'PROCOMPITE',
           'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
           7,0,0,0
          FROM
           grli_pip_procompite ) AS plist";
      $consulta_ejecutora_sede = "( SELECT
            cod_unif,
            CASE
              WHEN grli_pip_total_priori.etapa is not null THEN etapa 
              ELSE 'OTROS'::text
              END AS etapa,
            case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            'PROCOMPITE',
            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
            0,0,0
           FROM
            grli_pip_procompite ) AS plist";
      $consulta_provincia = "(SELECT
           cod_unif as cod_unif,
           CASE
              WHEN grli_pip_total_priori.etapa is not null THEN etapa 
              ELSE 'OTROS'::text
              END AS etapa,
           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
           m_pip,
           m_deveng_a,
           a_fisico
          FROM
           grli_pip_total_priori
          UNION
          SELECT
           cod_unif as cod_unif,
           'PROCOMPITE',
           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
           0,0,0
          FROM
           grli_pip_procompite ) AS plist";
      $consulta_sector = "(SELECT
           cod_unif,
           CASE
              WHEN grli_pip_total_priori.etapa is not null THEN etapa 
              ELSE 'OTROS'::text
              END AS etapa,
           case when sector is null then 'OTROS' else sector end as sector,
           m_pip,
           m_deveng_a,
           a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
           cod_unif,
           'PROCOMPITE',
           'PROCOMPITE',
           0,0,0
           FROM
           grli_pip_procompite ) AS plist";
      $consulta_header = "(SELECT
            cod_unif ,
            CASE
            WHEN grli_pip_total_priori.etapa is not null THEN etapa 
            ELSE 'OTROS'::text
            END AS etapa,
              m_pip,
              m_deveng_a,
              a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            'PROCOMPITE',0,0,0
           FROM
           grli_pip_procompite ) AS plist";
    } elseif ($input['ambito'] == 'SECTOR') {
      $filtrar = "sector";
      $consulta_etapa = "(SELECT
                   cod_unif ,
                   case when sector is null then 'OTROS' else sector end as sector,
                   CASE
                  WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                  ELSE 'OTROS'::text
                  END AS etapa,
                    case
                    when etapa in ('CERRADO') then '1'
                    when etapa in ('EN PROCESO DE LIQUIDACION') then '2'
                    when etapa in ('CULMINADO') then '3'
                    when etapa in ('EJECUCION FISICA') then '4'
                    when etapa in ('EXPEDIENTE TECNICO') then '5'
                    when etapa in ('PARALIZADO') then '6'
                    when etapa in ('VIABLE') then '7'
                    when etapa in ('APROBADO') then '8'
                    when etapa in ('OTROS') then '9'
                    else 10 end as  orden,
                     m_pip,
                     m_deveng_a,
                     a_fisico
                  FROM
                   grli_pip_total_priori
                  UNION
                  SELECT
                   cod_unif,
                   'PROCOMPITE',
                   'PROCOMPITE',
                   '8',0,0,0
                  FROM
                  grli_pip_procompite ) AS plist";
      $consulta_ejecutora = "( SELECT
           cod_unif,
           case when sector is null then 'OTROS' else sector end as sector,
           case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
           case
           when nom_proyec in ('ESTUDIOS DE PRE-INVERSION') and ger_direc is null then 1
           when nom_proyec in ('LIQUIDACION DE OBRAS') and ger_direc is null then 2
           when nom_proyec in ('INICIATIVA A LA COMPETITIVIDAD') and ger_direc is null then 3
           when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
           when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
           when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
           when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
           when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
           when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
           when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
           else 0 end as  orden,
           m_pip,
           m_deveng_a,
           a_fisico
          FROM
           grli_pip_total_priori
          UNION
          SELECT
           cod_unif,
           'PROCOMPITE',
           'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
           7,0,0,0
          FROM
           grli_pip_procompite ) AS plist";
      $consulta_ejecutora_sede = "( SELECT
            cod_unif,
            case when sector is null then 'OTROS' else sector end as sector,
            case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            'PROCOMPITE',
            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
            0,0,0
           FROM
            grli_pip_procompite ) AS plist";
      $consulta_provincia = "(SELECT
            cod_unif as cod_unif,
            case when sector is null then 'OTROS' else sector end as sector,
            case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif as cod_unif,
            'PROCOMPITE',
            case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
            0,0,0
           FROM
            grli_pip_procompite ) AS plist";
      $consulta_header = "(SELECT
            cod_unif ,
            case when sector is null then 'OTROS' else sector end as sector,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            'PROCOMPITE',
            0,0,0
           FROM
           grli_pip_procompite ) AS plist";
    } elseif ($input['ambito'] == 'FUENTE') {
      $filtrar = "fuente_financiamiento";
      $consulta_etapa = "(SELECT
                   cod_unif ,
                   case when sector is null then 'OTROS' else sector end as sector,
                   CASE
                  WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                  ELSE 'OTROS'::text
                  END AS etapa,
                    case
                    when etapa in ('CERRADO') then '1'
                    when etapa in ('EN PROCESO DE LIQUIDACION') then '2'
                    when etapa in ('CULMINADO') then '3'
                    when etapa in ('EJECUCION FISICA') then '4'
                    when etapa in ('EXPEDIENTE TECNICO') then '5'
                    when etapa in ('PARALIZADO') then '6'
                    when etapa in ('VIABLE') then '7'
                    when etapa in ('APROBADO') then '8'
                    when etapa in ('OTROS') then '9'
                    else 10 end as  orden,
                     m_pip,
                     m_deveng_a,
                     a_fisico
                  FROM
                   grli_pip_total_priori
                  UNION
                  SELECT
                   cod_unif,
                   'PROCOMPITE',
                   'PROCOMPITE',
                   '8',0,0,0
                  FROM
                  grli_pip_procompite ) AS plist";
      $consulta_sector = "(SELECT
           cod_unif,
           CASE
              WHEN grli_pip_total_priori.etapa is not null THEN etapa 
              ELSE 'OTROS'::text
              END AS etapa,
           case when sector is null then 'OTROS' else sector end as sector,
           m_pip,
           m_deveng_a,
           a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
           cod_unif,
           'PROCOMPITE',
           'PROCOMPITE',
           0,0,0
           FROM
           grli_pip_procompite ) AS plist";

      $consulta_ejecutora = "( SELECT
           cod_unif,
           case when sector is null then 'OTROS' else sector end as sector,
           case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
           case
           when nom_proyec in ('ESTUDIOS DE PRE-INVERSION') and ger_direc is null then 1
           when nom_proyec in ('LIQUIDACION DE OBRAS') and ger_direc is null then 2
           when nom_proyec in ('INICIATIVA A LA COMPETITIVIDAD') and ger_direc is null then 3
           when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 4
           when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 5
           when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 6
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 7
           when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 8
           when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then 9
           when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 10
           when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 11
           when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 12
           else 0 end as  orden,
           m_pip,
           m_deveng_a,
           a_fisico
          FROM
           grli_pip_total_priori
          UNION
          SELECT
           cod_unif,
           'PROCOMPITE',
           'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
           7,0,0,0
          FROM
           grli_pip_procompite ) AS plist";
      $consulta_ejecutora_sede = "( SELECT
            cod_unif,
            case when sector is null then 'OTROS' else sector end as sector,
            case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            'PROCOMPITE',
            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
            0,0,0
           FROM
            grli_pip_procompite ) AS plist";
      $consulta_provincia = "(SELECT
            cod_unif as cod_unif,
            case when sector is null then 'OTROS' else sector end as sector,
            case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif as cod_unif,
            'PROCOMPITE',
            case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
            0,0,0
           FROM
            grli_pip_procompite ) AS plist";
      $consulta_header = "(SELECT
            cod_unif ,
            case when sector is null then 'OTROS' else sector end as sector,
            m_pip,
            m_deveng_a,
            a_fisico
           FROM
            grli_pip_total_priori
           UNION
           SELECT
            cod_unif,
            'PROCOMPITE',
            0,0,0
           FROM
           grli_pip_procompite ) AS plist";
    }

    if ($input['ambito'] == 'EJECUTORA' && $input['filtro'] == 'UE SEDE') {
      //EJECUTORA
      $gob_reg_ejecutora = null;
      // ETAPA
      $ger_direc_etapa = ejecucion_financiera::select("etapa as ger_direc", DB::raw("-2 as orden,orden as ord,COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
             cod_unif,
             case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
             case
                when tipo_pry in ('NO PIP') or tipo_pry is null  then 'IOARR'
                when etapa in ('PERFIL') then 'PERFIL'
                when etapa in ('EXPEDIENTE TÉCNICO') then 'EXPEDIENTE TÉCNICO'
                when etapa in ('EN EJECUCIÓN') and sub_etapa in ('PARALIZADO') then 'PARALIZADO'
                when etapa in ('EN EJECUCIÓN','CONVENIO') then 'EN EJECUCIÓN'
                when etapa in ('CULMINADO','EN TRANSFERENCIA','CIERRE','EN LIQUIDACIÓN') then 'EN LIQUIDACIÓN'
                when nom_proyec in ('ESTUDIOS DE PRE-INVERSION','LIQUIDACION DE OBRAS','INICIATIVA A LA COMPETITIVIDAD') then 'SIN ETAPA'
                else 'OTROS' end as  etapa,
             case
                when tipo_pry in ('NO PIP') or tipo_pry is null  then '7'
                when etapa in ('PERFIL') then '1'
                when etapa in ('EXPEDIENTE TÉCNICO') then '2'
                when etapa in ('EN EJECUCIÓN') and sub_etapa in ('PARALIZADO') then '4'
                when etapa in ('EN EJECUCIÓN','CONVENIO') then '3'
                when etapa in ('CULMINADO','EN TRANSFERENCIA','CIERRE','EN LIQUIDACIÓN') then '5'
                when nom_proyec in ('ESTUDIOS DE PRE-INVERSION','LIQUIDACION DE OBRAS','INICIATIVA A LA COMPETITIVIDAD')  then '9'
                else 0 end as  orden,
               m_pip,
               m_deveng_a,
               a_fisico
            FROM
             grli_pip_total_priori
            UNION
            SELECT
             cod_unif,
             'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
             'PROCOMPITE',
             '8',0,0,0
            FROM
            grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
        ->groupBy('etapa')
        ->groupBy('orden')
        ->orderBy('ord');

      $gob_reg_etapa = $ger_direc_etapa->get();

      // PROVINCIA
      $ger_direc_provincia = ejecucion_financiera::select("nom_prov as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                   SUM(pim_dia) as pim_dia,
                   SUM(certificacion_dia) as certificacion_dia,
                   SUM(comp_anual_dia) as comp_anual_dia,
                   SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                   SUM(dev_dia) as dev_dia,
                   SUM(girado_dia) as girado_dia,
                   SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                   SUM(m_deveng_a) as m_deveng_a,
                   SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
                      cod_unif as cod_unif,
                      case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                      case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                      m_pip,
                      m_deveng_a,
                      a_fisico
                     FROM
                      grli_pip_total_priori
                     UNION
                     SELECT
                      cod_unif as cod_unif,
                      'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                      case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                      0,0,0
                   FROM
                    grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
        ->groupBy('nom_prov')
        ->orderBy('pim_dia', 'desc');

      $gob_reg_provincia = $ger_direc_provincia->get();

      // SECTOR
      $ger_direc_sector = ejecucion_financiera::select("sector as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
               cod_unif,
               case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
               case when sector is null then 'OTROS' else sector end as sector,
               m_pip,
               m_deveng_a,
               a_fisico
               FROM
                grli_pip_total_priori
               UNION
               SELECT
               cod_unif,
               'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
               'PROCOMPITE',
                0,0,0
               FROM
               grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
        ->groupBy('sector')
        ->orderBy('pim_dia', 'desc');

      $gob_reg_sector = $ger_direc_sector->get();

      // PROYECTO
      $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,plist.cod_unif as cant_proyectos,cod_snip,
              plist.m_pip,plist.m_deveng_a, plist.a_fisico,
              SUM(pim_dia) as pim_dia,
              SUM(dev_dia) as dev_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(girado_dia) as girado_dia,
              CASE
		            WHEN pic.cod_unif IS NULL THEN NULL::text
		            ELSE 'PIC'::text
		          END AS pic"))
        ->join(DB::raw("(SELECT
               id,
               cod_unif,
               case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
               case
                when tipo_pry in ('NO PIP') or tipo_pry is null  then 'IOARR'
                when etapa in ('PERFIL') then 'PERFIL'
                when etapa in ('EXPEDIENTE TÉCNICO') then 'EXPEDIENTE TÉCNICO'
                when etapa in ('EN EJECUCIÓN') and sub_etapa in ('PARALIZADO') then 'PARALIZADO'
                when etapa in ('EN EJECUCIÓN','CONVENIO') then 'EN EJECUCIÓN'
                when etapa in ('CULMINADO','EN TRANSFERENCIA','CIERRE','EN LIQUIDACIÓN') then 'EN LIQUIDACIÓN'
                when nom_proyec in ('ESTUDIOS DE PRE-INVERSION','LIQUIDACION DE OBRAS','INICIATIVA A LA COMPETITIVIDAD') then 'SIN ETAPA'
                else 'OTROS' end as  etapa,
                 nom_proyec,
                 case when sector is null then 'OTROS' else sector end as sector,
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                 m_pip,
                 m_deveng_a,
                 a_fisico,
                 cod_snip
              FROM
               grli_pip_total_priori
              UNION
              SELECT
               id,
               cod_unif,
               'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
               'PROCOMPITE',
               nom_proyec,
               'PROCOMPITE',
               case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
               0,0,0,'SIN COD.'
              FROM
              grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->leftJoin("pic", DB::raw("grli_pip_seguimiento_ejecucion_financiera.cod_unif::text"), "=", DB::raw("pic.cod_unif::text and pic.anio =" . $input['anio']))
        ->where("fecha", "=", $fecha)
        ->where("grli_pip_seguimiento_ejecucion_financiera.anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
        ->groupBy('nom_proyec')
        ->groupBy('etapa')
        ->groupBy('nom_prov')
        ->groupBy('sector')
        ->groupBy('plist.id')
        ->groupBy('plist.cod_unif')
        ->groupBy('cod_snip')
        ->groupBy('plist.m_pip')
        ->groupBy('plist.m_deveng_a')
        ->groupBy('plist.a_fisico')
        ->groupBy('pic.cod_unif')
        ->orderBy('pim_dia', 'desc');

      $gob_reg_proyecto = $ger_direc_proyecto->get();
      // FUENTE FINANCIAMIENTO
      $ger_direc_fuente_financiamiento = ejecucion_financiera::select("fuente_financiamiento as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
              SUM(pim_dia) as pim_dia,
              SUM(certificacion_dia) as certificacion_dia,
              SUM(comp_anual_dia) as comp_anual_dia,
              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
              SUM(dev_dia) as dev_dia,
              SUM(girado_dia) as girado_dia,
              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
              SUM(m_deveng_a) as m_deveng_a,
              SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
                     id,
                     cod_unif,
                     case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                     CASE
                      WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                      ELSE 'OTROS'::text
                      END AS etapa,
                       nom_proyec,
                       case when sector is null then 'OTROS' else sector end as sector,
                       case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                       m_pip,
                       m_deveng_a,
                       a_fisico
                    FROM
                     grli_pip_total_priori
                    UNION
                    SELECT
                     id,
                     cod_unif,
                     'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                     'PROCOMPITE',
                     nom_proyec,
                     'PROCOMPITE',
                     case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                     0,0,0
                    FROM
                    grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNotNull("fuente_financiamiento")
        ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
        ->groupBy('fuente_financiamiento')
        ->orderBy('pim_dia', 'desc');

      $gob_reg_fuente_financiamiento = $ger_direc_fuente_financiamiento->get();
      //CABEZERA
      $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                      SUM(pim_dia) as pim_dia,
                      SUM(certificacion_dia) as certificacion_dia,
                      SUM(comp_anual_dia) as comp_anual_dia,
                      SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                      SUM(dev_dia) as dev_dia,
                      SUM(girado_dia) as girado_dia,
                      SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                      SUM(m_deveng_a) as m_deveng_a,
                      SUM(a_fisico) as a_fisico"))
        ->join(DB::raw("(SELECT
                         cod_unif as cod_unif,
                         case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                         nom_prov,
                         m_pip,
                         m_deveng_a,
                         a_fisico
                        FROM
                         grli_pip_total_priori
                        UNION
                        SELECT
                         cod_unif as cod_unif,
                         'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                         nom_prov,0,0,0
                      FROM
                       grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
        ->where("fecha", "=", $fecha)
        ->where("anio", "=", $input['anio'])
        ->whereNull("fuente_financiamiento")
        ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
        ->first();
    } else {
      if ($input['ambito'] != 'FUENTE') {
        // EJECUTORA
        if ($input['ambito'] != 'EJECUTORA') {
          $ger_direc_ejecutora = ejecucion_financiera::select("ger_direc as ger_direc", DB::raw("orden,COUNT(plist.cod_unif) as cant_proyectos,
                    SUM(pim_dia) as pim_dia,
                    SUM(certificacion_dia) as certificacion_dia,
                    SUM(comp_anual_dia) as comp_anual_dia,
                    SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                    SUM(dev_dia) as dev_dia,
                    SUM(girado_dia) as girado_dia,
                    SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                    SUM(m_deveng_a) as m_deveng_a,
                    SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_ejecutora), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('ger_direc')
            ->groupBy('orden');

          $uesede = ejecucion_financiera::select(DB::raw("'UE SEDE' as ger_direc, -1 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                              SUM(pim_dia) as pim_dia,
                              SUM(certificacion_dia) as certificacion_dia,
                              SUM(comp_anual_dia) as comp_anual_dia,
                              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                              SUM(dev_dia) as dev_dia,
                              SUM(girado_dia) as girado_dia,
                              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                              SUM(m_deveng_a) as m_deveng_a,
                              SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_ejecutora_sede), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
            ->where($filtrar, "=", $input['filtro']);

          $gob_reg_ejecutora = $ger_direc_ejecutora->union($uesede)->orderBy('orden')->get();
        } else {
          $gob_reg_ejecutora = null;
        }
        // ETAPA
        if ($input['ambito'] != 'ETAPA') {
          $ger_direc_etapa = ejecucion_financiera::select("etapa as ger_direc", DB::raw("-2 as orden,orden as ord,COUNT(plist.cod_unif) as cant_proyectos,
                    SUM(pim_dia) as pim_dia,
                    SUM(certificacion_dia) as certificacion_dia,
                    SUM(comp_anual_dia) as comp_anual_dia,
                    SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                    SUM(dev_dia) as dev_dia,
                    SUM(girado_dia) as girado_dia,
                    SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                    SUM(m_deveng_a) as m_deveng_a,
                    SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_etapa), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('etapa')
            ->groupBy('orden')
            ->orderBy('ord');

          $gob_reg_etapa = $ger_direc_etapa->get();
        } else {
          $gob_reg_etapa = null;
        }
        // PROVINCIA
        if ($input['ambito'] != 'PROVINCIA') {
          $ger_direc_provincia = ejecucion_financiera::select("nom_prov as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                        SUM(pim_dia) as pim_dia,
                        SUM(certificacion_dia) as certificacion_dia,
                        SUM(comp_anual_dia) as comp_anual_dia,
                        SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                        SUM(dev_dia) as dev_dia,
                        SUM(girado_dia) as girado_dia,
                        SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                        SUM(m_deveng_a) as m_deveng_a,
                        SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_provincia), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('nom_prov')
            ->orderBy('pim_dia', 'desc');

          $gob_reg_provincia = $ger_direc_provincia->get();
        } else {
          $gob_reg_provincia = null;
        }
        // SECTOR
        if ($input['ambito'] != 'SECTOR') {
          $ger_direc_sector = ejecucion_financiera::select("sector as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                    SUM(pim_dia) as pim_dia,
                    SUM(certificacion_dia) as certificacion_dia,
                    SUM(comp_anual_dia) as comp_anual_dia,
                    SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                    SUM(dev_dia) as dev_dia,
                    SUM(girado_dia) as girado_dia,
                    SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                    SUM(m_deveng_a) as m_deveng_a,
                    SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_sector), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('sector')
            ->orderBy('pim_dia', 'desc');

          $gob_reg_sector = $ger_direc_sector->get();
        } else {
          $gob_reg_sector = null;
        }
        // PROYECTO
        $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,plist.cod_unif as cant_proyectos,cod_snip,
                plist.m_pip,plist.m_deveng_a, plist.a_fisico,
                SUM(pim_dia) as pim_dia,
                SUM(dev_dia) as dev_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(girado_dia) as girado_dia,
                CASE
		            WHEN pic.cod_unif IS NULL THEN NULL::text
		            ELSE 'PIC'::text
		            END AS pic"))
          ->join(DB::raw("(SELECT
                id,
                cod_unif,
                case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                CASE
                  WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                  ELSE 'OTROS'::text
                  END AS etapa,
                  nom_proyec,
                  case when sector is null then 'OTROS' else sector end as sector,
                  case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                  m_pip,
                  m_deveng_a,
                  a_fisico,
                  cod_snip
                FROM
                grli_pip_total_priori
                UNION
                SELECT
                id,
                cod_unif,
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                'PROCOMPITE',
                nom_proyec,
                'PROCOMPITE',
                case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                0,0,0,'SIN COD.'
                FROM
                grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->leftJoin("pic", DB::raw("grli_pip_seguimiento_ejecucion_financiera.cod_unif::text"), "=", DB::raw("pic.cod_unif::text and pic.anio =" . $input['anio']))
          ->where("fecha", "=", $fecha)
          ->where("grli_pip_seguimiento_ejecucion_financiera.anio", "=", $input['anio'])
          ->whereNull("fuente_financiamiento")
          ->where($filtrar, "=", $input['filtro'])
          ->groupBy('nom_proyec')
          ->groupBy('etapa')
          ->groupBy('nom_prov')
          ->groupBy('sector')
          ->groupBy('plist.id')
          ->groupBy('plist.cod_unif')
          ->groupBy('cod_snip')
          ->groupBy('plist.m_pip')
          ->groupBy('plist.m_deveng_a')
          ->groupBy('plist.a_fisico')
          ->groupBy('pic.cod_unif')
          ->orderBy('pim_dia', 'desc');

        $gob_reg_proyecto = $ger_direc_proyecto->get();
        // FUENTE FINANCIAMIENTO
        $ger_direc_fuente_financiamiento = ejecucion_financiera::select("fuente_financiamiento as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                SUM(pim_dia) as pim_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(dev_dia) as dev_dia,
                SUM(girado_dia) as girado_dia,
                SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                SUM(m_deveng_a) as m_deveng_a,
                SUM(a_fisico) as a_fisico"))
          ->join(DB::raw("(SELECT
                id,
                cod_unif,
                case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                CASE
                WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                ELSE 'OTROS'::text
                END AS etapa,
                  nom_proyec,
                  case when sector is null then 'OTROS' else sector end as sector,
                  case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                  m_pip,
                  m_deveng_a,
                  a_fisico
                FROM
                grli_pip_total_priori
                UNION
                SELECT
                id,
                cod_unif,
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                'PROCOMPITE',
                nom_proyec,
                'PROCOMPITE',
                case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                0,0,0
                FROM
                grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->where("fecha", "=", $fecha)
          ->where("anio", "=", $input['anio'])
          ->whereNotNull("fuente_financiamiento")
          ->where($filtrar, "=", $input['filtro'])
          ->groupBy('fuente_financiamiento')
          ->orderBy('pim_dia', 'desc');

        $gob_reg_fuente_financiamiento = $ger_direc_fuente_financiamiento->get();

        $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                SUM(pim_dia) as pim_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(dev_dia) as dev_dia,
                SUM(girado_dia) as girado_dia,
                SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                SUM(m_deveng_a) as m_deveng_a,
                SUM(a_fisico) as a_fisico"))
          ->join(DB::raw($consulta_header), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->where("fecha", "=", $fecha)
          ->where("anio", "=", $input['anio'])
          ->whereNull("fuente_financiamiento")
          ->where($filtrar, "=", $input['filtro'])
          ->first();
      } else {
        // EJECUTORA
        if ($input['ambito'] != 'EJECUTORA') {
          $ger_direc_ejecutora = ejecucion_financiera::select("ger_direc as ger_direc", DB::raw("orden,COUNT(plist.cod_unif) as cant_proyectos,
                    SUM(pim_dia) as pim_dia,
                    SUM(certificacion_dia) as certificacion_dia,
                    SUM(comp_anual_dia) as comp_anual_dia,
                    SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                    SUM(dev_dia) as dev_dia,
                    SUM(girado_dia) as girado_dia,
                    SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                    SUM(m_deveng_a) as m_deveng_a,
                    SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_ejecutora), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNotNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('ger_direc')
            ->groupBy('orden');

          $uesede = ejecucion_financiera::select(DB::raw("'UE SEDE' as ger_direc, -1 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                              SUM(pim_dia) as pim_dia,
                              SUM(certificacion_dia) as certificacion_dia,
                              SUM(comp_anual_dia) as comp_anual_dia,
                              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                              SUM(dev_dia) as dev_dia,
                              SUM(girado_dia) as girado_dia,
                              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                              SUM(m_deveng_a) as m_deveng_a,
                              SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_ejecutora_sede), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNotNull("fuente_financiamiento")
            ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
            ->where($filtrar, "=", $input['filtro']);
          $gob_reg_ejecutora = $ger_direc_ejecutora->union($uesede)->orderBy('orden')->get();
        } else {
          $gob_reg_ejecutora = null;
        }
        // ETAPA
        if ($input['ambito'] != 'ETAPA') {
          $ger_direc_etapa = ejecucion_financiera::select("etapa as ger_direc", DB::raw("-2 as orden,orden as ord,COUNT(plist.cod_unif) as cant_proyectos,
                    SUM(pim_dia) as pim_dia,
                    SUM(certificacion_dia) as certificacion_dia,
                    SUM(comp_anual_dia) as comp_anual_dia,
                    SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                    SUM(dev_dia) as dev_dia,
                    SUM(girado_dia) as girado_dia,
                    SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                    SUM(m_deveng_a) as m_deveng_a,
                    SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_etapa), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNotNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('etapa')
            ->groupBy('orden')
            ->orderBy('ord');
          $gob_reg_etapa = $ger_direc_etapa->get();
        } else {
          $gob_reg_etapa = null;
        }
        // PROVINCIA
        if ($input['ambito'] != 'PROVINCIA') {
          $ger_direc_provincia = ejecucion_financiera::select("nom_prov as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                        SUM(pim_dia) as pim_dia,
                        SUM(certificacion_dia) as certificacion_dia,
                        SUM(comp_anual_dia) as comp_anual_dia,
                        SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                        SUM(dev_dia) as dev_dia,
                        SUM(girado_dia) as girado_dia,
                        SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                        SUM(m_deveng_a) as m_deveng_a,
                        SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_provincia), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNotNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('nom_prov')
            ->orderBy('pim_dia', 'desc');

          $gob_reg_provincia = $ger_direc_provincia->get();
        } else {
          $gob_reg_provincia = null;
        }
        // SECTOR
        if ($input['ambito'] != 'SECTOR') {
          $ger_direc_sector = ejecucion_financiera::select("sector as ger_direc", DB::raw("-2 as orden,COUNT(plist.cod_unif) as cant_proyectos,
                    SUM(pim_dia) as pim_dia,
                    SUM(certificacion_dia) as certificacion_dia,
                    SUM(comp_anual_dia) as comp_anual_dia,
                    SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                    SUM(dev_dia) as dev_dia,
                    SUM(girado_dia) as girado_dia,
                    SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                    SUM(m_deveng_a) as m_deveng_a,
                    SUM(a_fisico) as a_fisico"))
            ->join(DB::raw($consulta_sector), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNotNull("fuente_financiamiento")
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('sector')
            ->orderBy('pim_dia', 'desc');

          $gob_reg_sector = $ger_direc_sector->get();
        } else {
          $gob_reg_sector = null;
        }
        // PROYECTO
        $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,plist.cod_unif as cant_proyectos,cod_snip,
                plist.m_pip,plist.m_deveng_a, plist.a_fisico,
                SUM(pim_dia) as pim_dia,
                SUM(dev_dia) as dev_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(girado_dia) as girado_dia,
                CASE
		            WHEN pic.cod_unif IS NULL THEN NULL::text
		            ELSE 'PIC'::text
		            END AS pic"))
          ->join(DB::raw("(SELECT
                id,
                cod_unif,
                case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                case
                    when tipo_pry in ('NO PIP') or tipo_pry is null  then 'IOARR'
                    when etapa in ('PERFIL') then 'PERFIL'
                    when etapa in ('EXPEDIENTE TÉCNICO') then 'EXPEDIENTE TÉCNICO'
                    when etapa in ('EN EJECUCIÓN') and sub_etapa in ('PARALIZADO') then 'PARALIZADO'
                    when etapa in ('EN EJECUCIÓN','CONVENIO') then 'EN EJECUCIÓN'
                    when etapa in ('CULMINADO','EN TRANSFERENCIA','CIERRE','EN LIQUIDACIÓN') then 'EN LIQUIDACIÓN'
                    when nom_proyec in ('ESTUDIOS DE PRE-INVERSION','LIQUIDACION DE OBRAS','INICIATIVA A LA COMPETITIVIDAD') then 'SIN ETAPA'
                    else 'OTROS' end as  etapa,
                  nom_proyec,
                  case when sector is null then 'OTROS' else sector end as sector,
                  case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                  m_pip,
                  m_deveng_a,
                  a_fisico,
                  cod_snip
                FROM
                grli_pip_total_priori
                UNION
                SELECT
                id,
                cod_unif,
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                'PROCOMPITE',
                nom_proyec,
                'PROCOMPITE',
                case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                0,0,0,'SIN COD.'
                FROM
                grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->leftJoin("pic", DB::raw("grli_pip_seguimiento_ejecucion_financiera.cod_unif::text"), "=", DB::raw("pic.cod_unif::text and pic.anio =" . $input['anio']))
          ->where("fecha", "=", $fecha)
          ->where("grli_pip_seguimiento_ejecucion_financiera.anio", "=", $input['anio'])
          ->whereNotNull("fuente_financiamiento")
          ->where($filtrar, "=", $input['filtro'])
          ->groupBy('nom_proyec')
          ->groupBy('etapa')
          ->groupBy('nom_prov')
          ->groupBy('sector')
          ->groupBy('plist.id')
          ->groupBy('plist.cod_unif')
          ->groupBy('cod_snip')
          ->groupBy('plist.m_pip')
          ->groupBy('plist.m_deveng_a')
          ->groupBy('plist.a_fisico')
          ->groupBy('pic.cod_unif')
          ->orderBy('pim_dia', 'desc');

        $gob_reg_proyecto = $ger_direc_proyecto->get();
        $gob_reg_fuente_financiamiento = null;
        $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                SUM(pim_dia) as pim_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(dev_dia) as dev_dia,
                SUM(girado_dia) as girado_dia,
                SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                SUM(m_deveng_a) as m_deveng_a,
                SUM(a_fisico) as a_fisico"))
          ->join(DB::raw($consulta_header), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->where("fecha", "=", $fecha)
          ->where("anio", "=", $input['anio'])
          ->whereNotNull("fuente_financiamiento")
          ->where($filtrar, "=", $input['filtro'])
          ->first();
      }
    }

    return view('proyecto.show')->with(
      [
        'ambito'  => $input['ambito'],
        'filtro'  => $input['filtro'],
        'anio'  => $input['anio'],
        'gob_reg_ejecutora' => $gob_reg_ejecutora,
        'gob_reg_etapa' => $gob_reg_etapa,
        'gob_reg_provincia' => $gob_reg_provincia,
        'gob_reg_sector' => $gob_reg_sector,
        'gob_reg_proyecto' => $gob_reg_proyecto,
        'gob_reg_fuente_financiamiento' => $gob_reg_fuente_financiamiento,
        'Headers' => $Headers,
      ]
    )->render();
  }

  public function showpry(Request $request)
  {

    $input = $request->all();
    $fecha = ejecucion_financiera::where("anio", "=", $input['anio'])->whereNull("fuente_financiamiento")->max('fecha');
    $filtrar = "";
    $ue_sede = "";
    if ($input['p_ambito'] == 'EJECUTORA') {
      $filtrar = "ger_direc";
    } elseif ($input['p_ambito'] == 'PROVINCIA') {
      $filtrar = "nom_prov";
    } elseif ($input['p_ambito'] == 'ETAPA') {
      $filtrar = "etapa";
    } elseif ($input['p_ambito'] == 'SECTOR') {
      $filtrar = "sector";
    } elseif ($input['p_ambito'] == 'FUENTE') {
      $filtrar = "fuente_financiamiento";
    }

    if (isset($input['opc'])) {
      if ($input['opc'] == 1 || $input['opc'] == 2) {
        $ue_sede = "UE SEDE";
      }
    } else {
      $ue_sede = "";
    }

    if ($ue_sede == 'UE SEDE') {
      if ($input['ambito'] == 'fuente_financiamiento') {
        $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,(plist.cod_unif) as cant_proyectos,cod_snip,
                plist.m_pip,plist.m_deveng_a, plist.a_fisico,
                SUM(pim_dia) as pim_dia,
                SUM(dev_dia) as dev_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(girado_dia) as girado_dia"))
          ->join(DB::raw("(SELECT
               id,
               cod_unif,
               case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
               CASE
              WHEN grli_pip_total_priori.etapa is not null THEN etapa 
              ELSE 'OTROS'::text
              END AS etapa,
               nom_proyec,
               case when sector is null then 'OTROS' else sector end as sector,
               case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
               m_pip,
               m_deveng_a,
               a_fisico,
               cod_snip
              FROM
               grli_pip_total_priori
              UNION
              SELECT
               id,
               cod_unif,
               'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
               'PROCOMPITE',
               nom_proyec,
               'PROCOMPITE',
               case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
               0,0,0,'SIN COD.'
              FROM
              grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->where("fecha", "=", $fecha)
          ->where("anio", "=", $input['anio'])
          ->where("pim_dia", "!=", 0)
          ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
          ->where($input['ambito'], "=", $input['ger_direc'])
          ->groupBy('nom_proyec')
          ->groupBy('etapa')
          ->groupBy('nom_prov')
          ->groupBy('sector')
          ->groupBy('plist.id')
          ->groupBy('plist.cod_unif')
          ->groupBy('cod_snip')
          ->groupBy('plist.m_pip')
          ->groupBy('plist.m_deveng_a')
          ->groupBy('plist.a_fisico')
          ->orderBy('pim_dia', 'desc');

        $gob_reg_proyecto = $ger_direc_proyecto->get();
        $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                          SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                          SUM(m_deveng_a) as m_deveng_a,
                          SUM(certificacion_dia) as certificacion_dia,
                          SUM(a_fisico) as a_fisico,
                          SUM(pim_dia) as pim_dia,
                          SUM(dev_dia) as dev_dia,
                          SUM(comp_anual_dia) as comp_anual_dia,
                          SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                          SUM(girado_dia) as girado_dia"))
          ->join(DB::raw("(SELECT
                         cod_unif,
                         case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                         CASE
                         WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                         ELSE 'OTROS'::text
                         END AS etapa,
                           nom_proyec,
                           case when sector is null then 'OTROS' else sector end as sector,
                           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                           m_pip,
                           m_deveng_a,
                           a_fisico
                        FROM
                         grli_pip_total_priori
                        UNION
                        SELECT
                         cod_unif,
                         'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                         'PROCOMPITE',
                         nom_proyec,
                         'PROCOMPITE',
                         case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                         0,0,0
                        FROM
                        grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->where("fecha", "=", $fecha)
          ->where("anio", "=", $input['anio'])
          ->where("pim_dia", "!=", 0)
          ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
          ->where($input['ambito'], "=", $input['ger_direc'])
          ->first();
      } else {
        if (isset($input['opc']) && $input['opc'] == 1) {
          $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,(plist.cod_unif) as cant_proyectos,
                  plist.m_pip,plist.m_deveng_a, plist.a_fisico,
                  SUM(pim_dia) as pim_dia,
                  SUM(dev_dia) as dev_dia,
                  SUM(certificacion_dia) as certificacion_dia,
                  SUM(comp_anual_dia) as comp_anual_dia,
                  SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                  SUM(girado_dia) as girado_dia"))
            ->join(DB::raw("(SELECT
                 id,
                 cod_unif,
                 case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                 CASE
                 WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                 ELSE 'OTROS'::text
                 END AS etapa,
                   nom_proyec,
                 case when sector is null then 'OTROS' else sector end as sector,
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                 m_pip,
                 m_deveng_a,
                 a_fisico
                FROM
                 grli_pip_total_priori
                UNION
                SELECT
                 id,
                 cod_unif,
                 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                 'PROCOMPITE',
                 nom_proyec,
                 'PROCOMPITE',
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                 0,0,0
                FROM
                grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where("pim_dia", "!=", 0)
            ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
            ->where($filtrar, "=", $input['filtro'])
            ->groupBy('nom_proyec')
            ->groupBy('etapa')
            ->groupBy('nom_prov')
            ->groupBy('sector')
            ->groupBy('plist.id')
            ->groupBy('plist.cod_unif')
            ->groupBy('plist.m_pip')
            ->groupBy('plist.m_deveng_a')
            ->groupBy('plist.a_fisico')
            ->orderBy('pim_dia', 'desc');

          $gob_reg_proyecto = $ger_direc_proyecto->get();

          $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                          SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                          SUM(m_deveng_a) as m_deveng_a,
                          SUM(certificacion_dia) as certificacion_dia,
                          SUM(a_fisico) as a_fisico,
                          SUM(pim_dia) as pim_dia,
                          SUM(dev_dia) as dev_dia,
                          SUM(comp_anual_dia) as comp_anual_dia,
                          SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                          SUM(girado_dia) as girado_dia"))
            ->join(DB::raw("(SELECT
                         cod_unif,
                         case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                         CASE
                          WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                          ELSE 'OTROS'::text
                          END AS etapa,
                           nom_proyec,
                           case when sector is null then 'OTROS' else sector end as sector,
                           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                           m_pip,
                           m_deveng_a,
                           a_fisico
                        FROM
                         grli_pip_total_priori
                        UNION
                        SELECT
                         cod_unif,
                         'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                         'PROCOMPITE',
                         nom_proyec,
                         'PROCOMPITE',
                         case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                         0,0,0
                        FROM
                        grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where("pim_dia", "!=", 0)
            ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
            ->where($filtrar, "=", $input['filtro'])
            ->first();
        } else {
          $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,(plist.cod_unif) as cant_proyectos,
                  plist.m_pip,plist.m_deveng_a, plist.a_fisico,
                  SUM(pim_dia) as pim_dia,
                  SUM(dev_dia) as dev_dia,
                  SUM(certificacion_dia) as certificacion_dia,
                  SUM(comp_anual_dia) as comp_anual_dia,
                  SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                  SUM(girado_dia) as girado_dia"))
            ->join(DB::raw("(SELECT
                 id,
                 cod_unif,
                 case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                 CASE
                  WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                  ELSE 'OTROS'::text
                  END AS etapa,
                 nom_proyec,
                 case when sector is null then 'OTROS' else sector end as sector,
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                 m_pip,
                 m_deveng_a,
                 a_fisico
                FROM
                 grli_pip_total_priori
                UNION
                SELECT
                 id,
                 cod_unif,
                 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                 'PROCOMPITE',
                 nom_proyec,
                 'PROCOMPITE',
                 case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                 0,0,0
                FROM
                grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where("pim_dia", "!=", 0)
            ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
            ->where($input['ambito'], "=", $input['ger_direc'])
            ->groupBy('nom_proyec')
            ->groupBy('etapa')
            ->groupBy('nom_prov')
            ->groupBy('sector')
            ->groupBy('plist.id')
            ->groupBy('plist.cod_unif')
            ->groupBy('plist.m_pip')
            ->groupBy('plist.m_deveng_a')
            ->groupBy('plist.a_fisico')
            ->orderBy('pim_dia', 'desc');

          $gob_reg_proyecto = $ger_direc_proyecto->get();
          $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                          SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                          SUM(m_deveng_a) as m_deveng_a,
                          SUM(certificacion_dia) as certificacion_dia,
                          SUM(a_fisico) as a_fisico,
                          SUM(pim_dia) as pim_dia,
                          SUM(dev_dia) as dev_dia,
                          SUM(comp_anual_dia) as comp_anual_dia,
                          SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                          SUM(girado_dia) as girado_dia"))
            ->join(DB::raw("(SELECT
                         cod_unif,
                         case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                         CASE
                          WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                          ELSE 'OTROS'::text
                          END AS etapa,
                           nom_proyec,
                           case when sector is null then 'OTROS' else sector end as sector,
                           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                           m_pip,
                           m_deveng_a,
                           a_fisico
                        FROM
                         grli_pip_total_priori
                        UNION
                        SELECT
                         cod_unif,
                         'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                         'PROCOMPITE',
                         nom_proyec,
                         'PROCOMPITE',
                         case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                         0,0,0
                        FROM
                        grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNull("fuente_financiamiento")
            ->where("pim_dia", "!=", 0)
            ->whereNotIn('ger_direc', ['DIRECCION REGIONAL DE SALUD', 'GERENCIA SUB REGIONAL LIMA SUR', 'DIRECCION REGIONAL DE AGRICULTURA'])
            ->where($input['ambito'], "=", $input['ger_direc'])
            ->first();
        }
      }
    } else {
      if ($input['ambito'] == 'fuente_financiamiento') {
        $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,(plist.cod_unif) as cant_proyectos,cod_snip,
               plist.m_pip,plist.m_deveng_a, plist.a_fisico,
               SUM(pim_dia) as pim_dia,
               SUM(dev_dia) as dev_dia,
               SUM(certificacion_dia) as certificacion_dia,
               SUM(comp_anual_dia) as comp_anual_dia,
               SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
               SUM(girado_dia) as girado_dia"))
          ->join(DB::raw("(SELECT
               id,
               cod_unif,
               case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
               CASE
                WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                ELSE 'OTROS'::text
                END AS etapa,
                 nom_proyec,
               case when sector is null then 'OTROS' else sector end as sector,
               case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
               m_pip,
               m_deveng_a,
               a_fisico,
               cod_snip
              FROM
               grli_pip_total_priori
              UNION
              SELECT
               id,
               cod_unif,
               'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
               'PROCOMPITE',
               nom_proyec,
               'PROCOMPITE',
               case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
               0,0,0,'SIN COD.'
              FROM
              grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->where("fecha", "=", $fecha)
          ->where("anio", "=", $input['anio'])
          ->where($filtrar, "=", $input['filtro'])
          ->where($input['ambito'], "=", $input['ger_direc'])
          ->where("pim_dia", "!=", 0)
          ->groupBy('nom_proyec')
          ->groupBy('etapa')
          ->groupBy('nom_prov')
          ->groupBy('sector')
          ->groupBy('plist.id')
          ->groupBy('plist.cod_unif')
          ->groupBy('cod_snip')
          ->groupBy('plist.m_pip')
          ->groupBy('plist.m_deveng_a')
          ->groupBy('plist.a_fisico')
          ->orderBy('pim_dia', 'desc');

        $gob_reg_proyecto = $ger_direc_proyecto->get();
        $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                            SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                            SUM(m_deveng_a) as m_deveng_a,
                            SUM(a_fisico) as a_fisico,
                            SUM(pim_dia) as pim_dia,
                            SUM(dev_dia) as dev_dia,
                            SUM(comp_anual_dia) as comp_anual_dia,
                            SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                            SUM(girado_dia) as girado_dia"))
          ->join(DB::raw("(SELECT
                           cod_unif,
                           case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                           CASE
                            WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                            ELSE 'OTROS'::text
                            END AS etapa,
                             nom_proyec,
                             case when sector is null then 'OTROS' else sector end as sector,
                             case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                             m_pip,
                             m_deveng_a,
                             a_fisico
                          FROM
                           grli_pip_total_priori
                          UNION
                          SELECT
                           cod_unif,
                           'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                           'PROCOMPITE',
                           nom_proyec,
                           'PROCOMPITE',
                           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                           0,0,0
                          FROM
                          grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
          ->where("fecha", "=", $fecha)
          ->where("anio", "=", $input['anio'])
          ->where($filtrar, "=", $input['filtro'])
          ->where($input['ambito'], $input['ger_direc'])
          ->where("pim_dia", "!=", 0)
          ->first();
      } else {
        if ($input['p_ambito'] == 'FUENTE') {
          $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,(plist.cod_unif) as cant_proyectos,
                plist.m_pip,plist.m_deveng_a, plist.a_fisico,
                SUM(pim_dia) as pim_dia,
                SUM(dev_dia) as dev_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(girado_dia) as girado_dia"))
            ->join(DB::raw("(SELECT
                id,
                cod_unif,
                case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                CASE
                WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                ELSE 'OTROS'::text
                END AS etapa,
                  nom_proyec,
                case when sector is null then 'OTROS' else sector end as sector,
                case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                m_pip,
                m_deveng_a,
                a_fisico
                FROM
                grli_pip_total_priori
                UNION
                SELECT
                id,
                cod_unif,
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                'PROCOMPITE',
                nom_proyec,
                'PROCOMPITE',
                case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                0,0,0
                FROM
                grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNotNull("fuente_financiamiento")
            ->where("pim_dia", "!=", 0)
            ->where($filtrar, "=", $input['filtro'])
            ->where($input['ambito'], "=", $input['ger_direc'])
            ->groupBy('nom_proyec')
            ->groupBy('etapa')
            ->groupBy('nom_prov')
            ->groupBy('sector')
            ->groupBy('plist.id')
            ->groupBy('plist.cod_unif')
            ->groupBy('plist.m_pip')
            ->groupBy('plist.m_deveng_a')
            ->groupBy('plist.a_fisico')
            ->orderBy('pim_dia', 'desc');

          $gob_reg_proyecto = $ger_direc_proyecto->get();

          $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                            SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                            SUM(m_deveng_a) as m_deveng_a,
                            SUM(certificacion_dia) as certificacion_dia,
                            SUM(a_fisico) as a_fisico,
                            SUM(pim_dia) as pim_dia,
                            SUM(dev_dia) as dev_dia,
                            SUM(comp_anual_dia) as comp_anual_dia,
                            SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                            SUM(girado_dia) as girado_dia"))
            ->join(DB::raw("(SELECT
                           cod_unif,
                           case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                           CASE
                            WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                            ELSE 'OTROS'::text
                            END AS etapa,
                             nom_proyec,
                             case when sector is null then 'OTROS' else sector end as sector,
                             case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                             m_pip,
                             m_deveng_a,
                             a_fisico
                          FROM
                           grli_pip_total_priori
                          UNION
                          SELECT
                           cod_unif,
                           'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                           'PROCOMPITE',
                           nom_proyec,
                           'PROCOMPITE',
                           case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                           0,0,0
                          FROM
                          grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where("fecha", "=", $fecha)
            ->where("anio", "=", $input['anio'])
            ->whereNotNull("fuente_financiamiento")
            ->where("pim_dia", "!=", 0)
            ->where($filtrar, "=", $input['filtro'])
            ->where($input['ambito'], $input['ger_direc'])
            ->first();
        } else {
          if ($input['ger_direc'] == 'PROCOMPITE' || $input['filtro'] == 'PROCOMPITE') {
            $ger_direc_proyecto = ejecucion_financiera::select(DB::raw("plist.id,nom_proyec as ger_direc,'PROCOMPITE' as  etapa,case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
               'PROCOMPITE' as sector,-2 as orden,(plist.cod_unif) as cant_proyectos,case when plist.m_pip is null then 0 else plist.m_pip end as m_pip,
               0 as m_deveng_a,case when plist.a_fisico is null then '0' else plist.a_fisico end as a_fisico,
               SUM(pim_dia) as pim_dia,
               SUM(dev_dia) as dev_dia,
               SUM(certificacion_dia) as certificacion_dia,
               SUM(comp_anual_dia) as comp_anual_dia,
               SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
               SUM(girado_dia) as girado_dia"))
              ->join(DB::raw("grli_pip_procompite as  plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->where("fecha", "=", $fecha)
              ->where("grli_pip_seguimiento_ejecucion_financiera.anio", "=", $input['anio'])
              ->whereNull("fuente_financiamiento")
              ->where("pim_dia", "!=", 0)
              ->groupBy('nom_proyec')
              ->groupBy('etapa')
              ->groupBy('nom_prov')
              ->groupBy('sector')
              ->groupBy('plist.id')
              ->groupBy('plist.cod_unif')
              ->groupBy('plist.m_pip')
              ->groupBy('plist.a_fisico')
              ->orderBy('pim_dia', 'desc');

            $gob_reg_proyecto = $ger_direc_proyecto->get();

            $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                              SUM(case when m_pip is null then 0 else m_pip end) as m_pip,
                              0 as m_deveng_a,
                              SUM(certificacion_dia) as certificacion_dia,
                              SUM((case when a_fisico is null then '0' else a_fisico end)::int) as a_fisico,
                              SUM(pim_dia) as pim_dia,
                              SUM(dev_dia) as dev_dia,
                              SUM(comp_anual_dia) as comp_anual_dia,
                              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                              SUM(girado_dia) as girado_dia"))
              ->join(DB::raw("grli_pip_procompite as  plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->where("fecha", "=", $fecha)
              ->where("grli_pip_seguimiento_ejecucion_financiera.anio", "=", $input['anio'])
              ->whereNull("fuente_financiamiento")
              ->where("pim_dia", "!=", 0)
              ->first();
          } else {
            $ger_direc_proyecto = ejecucion_financiera::select("plist.id", "nom_proyec as ger_direc", "etapa", "nom_prov", "sector", DB::raw("-2 as orden,(plist.cod_unif) as cant_proyectos,
                plist.m_pip,plist.m_deveng_a, plist.a_fisico,
                SUM(pim_dia) as pim_dia,
                SUM(dev_dia) as dev_dia,
                SUM(certificacion_dia) as certificacion_dia,
                SUM(comp_anual_dia) as comp_anual_dia,
                SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                SUM(girado_dia) as girado_dia"))
              ->join(DB::raw("(SELECT
                id,
                cod_unif,
                case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                CASE
                WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                ELSE 'OTROS'::text
                END AS etapa,
                  nom_proyec,
                case when sector is null then 'OTROS' else sector end as sector,
                case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                m_pip,
                m_deveng_a,
                a_fisico
                FROM
                grli_pip_total_priori
                UNION
                SELECT
                id,
                cod_unif,
                'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                'PROCOMPITE',
                nom_proyec,
                'PROCOMPITE',
                case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                0,0,0
                FROM
                grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->where("fecha", "=", $fecha)
              ->where("anio", "=", $input['anio'])
              ->whereNull("fuente_financiamiento")
              ->where("pim_dia", "!=", 0)
              ->where($filtrar, "=", $input['filtro'])
              ->where($input['ambito'], "=", $input['ger_direc'])
              ->groupBy('nom_proyec')
              ->groupBy('etapa')
              ->groupBy('nom_prov')
              ->groupBy('sector')
              ->groupBy('plist.id')
              ->groupBy('plist.cod_unif')
              ->groupBy('plist.m_pip')
              ->groupBy('plist.m_deveng_a')
              ->groupBy('plist.a_fisico')
              ->orderBy('pim_dia', 'desc');

            $gob_reg_proyecto = $ger_direc_proyecto->get();

            $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                              SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                              SUM(m_deveng_a) as m_deveng_a,
                              SUM(certificacion_dia) as certificacion_dia,
                              SUM(a_fisico) as a_fisico,
                              SUM(pim_dia) as pim_dia,
                              SUM(dev_dia) as dev_dia,
                              SUM(comp_anual_dia) as comp_anual_dia,
                              SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                              SUM(girado_dia) as girado_dia"))
              ->join(DB::raw("(SELECT
                            cod_unif,
                            case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                            CASE
                            WHEN grli_pip_total_priori.etapa is not null THEN etapa 
                            ELSE 'OTROS'::text
                            END AS etapa,
                              nom_proyec,
                              case when sector is null then 'OTROS' else sector end as sector,
                              case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                              m_pip,
                              m_deveng_a,
                              a_fisico
                            FROM
                            grli_pip_total_priori
                            UNION
                            SELECT
                            cod_unif,
                            'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                            'PROCOMPITE',
                            nom_proyec,
                            'PROCOMPITE',
                            case when nom_prov is null then 'OTROS' else nom_prov end as nom_prov,
                            0,0,0
                            FROM
                            grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
              ->where("fecha", "=", $fecha)
              ->where("anio", "=", $input['anio'])
              ->whereNull("fuente_financiamiento")
              ->where("pim_dia", "!=", 0)
              ->where($filtrar, "=", $input['filtro'])
              ->where($input['ambito'], $input['ger_direc'])
              ->first();
          }
        }
      }
    }

    return view('proyecto.showproyecto')->with(
      [
        'filtro'  => $input['filtro'],
        'anio'  => $input['anio'],
        'ambito'  => $input['ambito'],
        'ger_direc'  => $input['ger_direc'],
        'gob_reg_proyecto' => $gob_reg_proyecto,
        'Headers' => $Headers,
      ]
    )->render();
  }

  public function abrirproyecto(Request $request)
  {
    $input = $request->all();
    return redirect()->action('PipTotalPrioriController@index', ['id' => $input['id'], 'accion' => 1, 'tipopry' => $input['tipopry']]);
  }

  public function showMeta(Request $request)
  {

    $input = $request->all();
    // $fecha=ejecucion_financiera::where("anio","=",$input['anio'])->whereNull("fuente_financiamiento")->max('fecha');
    $Obras = Obras::select(DB::raw("grli_obra.id,nro_meta,nom_meta,tipo,anio_ejec,grli_obra.m_ejecucion,grli_obra.m_supervision, grli_obra_estado.etapa,grli_obra_estado.sub_etapa,grli_obra_estado.a_fisico,
                    grli_obra_estado.fecha_act,grli_obra_estado.est_situ"))
      ->join("grli_pip_total_priori", "grli_obra.idproyecto", "=", "grli_pip_total_priori.id")
      ->join("grli_obra_estado", "grli_obra.id", "=", "grli_obra_estado.idobra")
      ->where("grli_pip_total_priori.cod_unif", "=", $input['cod_unif'])
      ->where("fecha_act", "=", DB::raw("(select max(fecha_act) from grli_obra_estado where idobra=grli_obra.id)"))
      ->orderBy("nro_meta")
      ->get();

    return view('proyecto.showmeta')->with(
      [
        // 'filtro'  => $input['filtro'],
        // 'anio'  => $input['anio'],
        // 'ambito'  => $input['ambito'],
        'nombre'  => $input['nombre'],
        'gob_reg_meta' => $Obras,
        'Headers' => null,
      ]

    )->render();
  }

  public function showFuente(Request $request)
  {

    $input = $request->all();
    $fecha = ejecucion_financiera::where("anio", "=", $input['anio'])->whereNull("fuente_financiamiento")->max('fecha');
    // FUENTE FINANCIAMIENTO
    $ger_direc_fuente_financiamiento = ejecucion_financiera::select("fuente_financiamiento as ger_direc", DB::raw("-2 as orden,COUNT(cod_unif) as cant_proyectos,
            SUM(pim_dia) as pim_dia,
            SUM(certificacion_dia) as certificacion_dia,
            SUM(comp_anual_dia) as comp_anual_dia,
            SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
            SUM(dev_dia) as dev_dia,
            SUM(girado_dia) as girado_dia"))
      ->where("fecha", "=", $fecha)
      ->where("anio", "=", $input['anio'])
      ->whereNotNull("fuente_financiamiento")
      ->where("pim_dia", "!=", 0)
      ->where("cod_unif", "=", $input['cod_unif'])
      ->groupBy('fuente_financiamiento')
      ->orderBy('pim_dia', 'desc');

    $gob_reg_fuente_financiamiento = $ger_direc_fuente_financiamiento->get();
    //CABEZERA
    $Headers = ejecucion_financiera::select(DB::raw("COUNT(plist.cod_unif) as cant_proyectos,
                            SUM(pim_dia) as pim_dia,
                            SUM(certificacion_dia) as certificacion_dia,
                            SUM(comp_anual_dia) as comp_anual_dia,
                            SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
                            SUM(dev_dia) as dev_dia,
                            SUM(girado_dia) as girado_dia,
                            SUM(case when m_pip = 0 or m_pip is null  then round((m_deveng_a - dev_dia) + pim_dia,0) else round(m_pip,0) end) as m_pip,
                            SUM(m_deveng_a) as m_deveng_a,
                            SUM(a_fisico) as a_fisico"))
      ->join(DB::raw("(SELECT
                               cod_unif as cod_unif,
                               case when ger_direc is null then nom_proyec else ger_direc end as ger_direc,
                               nom_prov,
                               m_pip,
                               m_deveng_a,
                               a_fisico
                              FROM
                               grli_pip_total_priori
                              UNION
                              SELECT
                               cod_unif as cod_unif,
                               'GERENCIA REGIONAL DE DESARROLLO ECONOMICO',
                               nom_prov,0,0,0
                            FROM
                             grli_pip_procompite ) AS plist"), "plist.cod_unif", "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
      ->where("fecha", "=", $fecha)
      ->where("anio", "=", $input['anio'])
      ->whereNotNull("fuente_financiamiento")
      ->where("pim_dia", "!=", 0)
      ->where("plist.cod_unif", "=", $input['cod_unif'])
      ->first();

    return view('proyecto.showFuente')->with(
      [
        'filtro'  => $input['nombre'],
        'anio'  => $input['anio'],
        'ambito'  => $input['ambito'],
        'nombre'  => $input['nombre'],
        'gob_reg_fuente_financiamiento' => $gob_reg_fuente_financiamiento,
        'Headers' => $Headers,
      ]
    )->render();
  }


  public function showprydev(Request $request)
  {
    $input = $request->all();
    $data = DB::select("select * from vw_grli_pip_seguimiento_ejecucion_financiera where dev_mensual != 0 and ger_direc ='" . $input['filtro'] . "'
                      union
                      select * from vw_grli_pip_seguimiento_ejecucion_financiera where meta_mensual != 0 and ger_direc ='" . $input['filtro'] . "'
                      order by dif_dev_dia desc");
    $data_headers = DB::select(DB::raw("
        SELECT 
            COUNT(*) AS cantidad,
            SUM(m_pip) AS m_pip,
            SUM(pim_dia) AS pim_dia,
            SUM(m_deveng_a) AS m_deveng_a,
            SUM(dev_dia) AS dev_dia,
            SUM(certificacion_dia) AS certificacion_dia,
            SUM(dif_dev_dia) AS dif_dev_dia,
            CASE WHEN SUM(dev_mensual) IS NULL THEN 0 ELSE SUM(dev_mensual) END AS dev_mensual,
            CASE WHEN SUM(meta_mensual) IS NULL THEN 0 ELSE SUM(meta_mensual) END AS meta_mensual
        FROM (
            SELECT * 
            FROM vw_grli_pip_seguimiento_ejecucion_financiera 
            WHERE dev_mensual != 0 AND ger_direc = :filtro
            UNION 
            SELECT * 
            FROM vw_grli_pip_seguimiento_ejecucion_financiera 
            WHERE meta_mensual != 0 AND ger_direc = :filtro
        ) AS combined_data
        ORDER BY dif_dev_dia DESC
    "), ['filtro' => $input['filtro']]);

    return view('principal.modal.show')->with(
      [
        'anio'  => date("Y"),
        'filtro'  => $input['filtro'],
        'data' => $data,
        'Headers' => $data_headers
      ]
    )->render();
  }

  public function reporte_inversiones(Request $request)
  {
    $reporte_ejec_1 = DB::select(" select sum(pim_dia)/1000000 as pim ,sum(dev_dia)/1000000 as ejec_general ,sum(octubre)/1000000 as ejec_mes,fecha-1 as fecha from vw_grli_pip_seguimiento_ejecucion_financiera
        left join vw_bi_inf_financiera_2  on vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif = vw_bi_inf_financiera_2.cod_unif
                        group by fecha");

    $reporte_ejec_2 = DB::select("select * from vw_ejecucionalmes order by anio");

    $reporte_ejec_3 = DB::select("select vw_pry_dev_ejecutoras_2.*,m_enero,m_febrero,m_marzo,m_abril,m_mayo,m_junio,m_agosto,m_agosto,m_setiembre,m_octubre,m_noviembre,m_diciembre,(pim_dia - certificacion_dia) as por_certificar,
                        grl_enero, grl_febrero, grl_marzo, grl_abril, grl_mayo, grl_junio, grl_agosto, grl_agosto, grl_setiembre, grl_octubre, grl_noviembre, grl_diciembre,
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
                          else 0 end as  orden,
                          case
                          when ger_direc in ('ESTUDIOS DE PRE-INVERSION') then 'EP'
                          when ger_direc in ('LIQUIDACION DE OBRAS') then 'LIQUIDACION DE OBRAS'
                          when ger_direc in ('INICIATIVA A LA COMPETITIVIDAD') then 'INICIATIVA A LA COMPETITIVIDAD'
                          when ger_direc in ('GERENCIA REGIONAL DE INFRAESTRUCTURA') then 'GRI'
                          when ger_direc in ('DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES') then 'GRTC'
                          when ger_direc in ('GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE') then 'GRRNGMA'
                          when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO ECONOMICO') then 'GRDE'
                          when ger_direc in ('GERENCIA REGIONAL DE DESARROLLO SOCIAL') then 'GRDS'
                          when ger_direc in ('DIRECCION REGIONAL DE AGRICULTURA') then  'DRA'
                          when ger_direc in ('GERENCIA SUB REGIONAL LIMA SUR') then 'GSRLS'
                          when ger_direc in ('DIRECCION REGIONAL DE SALUD') then 'DIRECCION REGIONAL DE SALUD'
                          when ger_direc in ('DIRECCION REGIONAL DE EDUCACION') then 'DIRECCION REGIONAL DE EDUCACION'
                          else '' end as  abreviatura
                        from vw_pry_dev_ejecutoras_2
                        inner join (select * from meta_mef where fecha_subida = (select max(fecha_subida) from meta_mef)) as meta_mef on vw_pry_dev_ejecutoras_2.anio=meta_mef.anio::text and vw_pry_dev_ejecutoras_2.ger_direc=direc_uei
                        left join meta_grl on vw_pry_dev_ejecutoras_2.anio=meta_grl.anio::text and vw_pry_dev_ejecutoras_2.ger_direc=ger_direc_uei order by orden");

    return Response([
      "reporte_ejec_1" => $reporte_ejec_1,
      "reporte_ejec_2" => $reporte_ejec_2,
      "reporte_ejec_3" => $reporte_ejec_3
    ]);
  }

  public function historia_anio(Request $request)
  {
    $input = $request->all();
    if ($input['anio'] == date("Y")) {
      $data = ejecucion_financiera::select(DB::RAW("count(cod_unif) as proyecto, sum(pia_dia) as pia_dia , sum(pim_dia) as pim_dia ,sum(dev_dia) as dev_dia"))
        ->where(DB::RAW("anio::text"), $input['anio'])
        ->whereNull('fuente_financiamiento')
        ->where('fecha', '=', DB::RAW("(SELECT max(grli_pip_seguimiento_ejecucion_financiera.fecha) AS max FROM grli_pip_seguimiento_ejecucion_financiera where anio::text ='" . $input['anio'] . "')"))
        ->where('pim_dia', '>', 0)->first();
    } else {
      $data = ejecucion_financiera::select(DB::RAW("count(cod_unif) as proyecto, sum(pia_dia) as pia_dia , sum(pim_dia) as pim_dia ,sum(dev_dia) as dev_dia"))
        ->where(DB::RAW("anio::text"), $input['anio'])
        ->whereNull('fuente_financiamiento')
        ->where('fecha', '=', DB::RAW("(SELECT max(grli_pip_seguimiento_ejecucion_financiera.fecha) AS max FROM grli_pip_seguimiento_ejecucion_financiera where anio::text ='" . $input['anio'] . "')"))
        ->first();
    }
    return Response([
      "data" => $data
    ]);
  }

  public function lista_proyecto(Request $request)
  {
    $rol    = $this->rol;
    $roles_acceso_total    = $this->roles_acceso_total;
    $esuei = 1;
    if (in_array($rol, $roles_acceso_total)) {
        $esuei = 0;
    }
    return View('proyecto.listaproyecto')->with('esuei',$esuei);
  }

  public function lista_proyecto_data(Request $request)
  {
    $input = $request->input();
    $anio = (int)$input['anio'];
    $fecha_financiera = ejecucion_financiera::where('anio', $input['anio'])->max('fecha');
    $rol    = $this->rol;
    $roles_acceso_total    = $this->roles_acceso_total;
    $gerencia = $this->gerencia;
    $esuei = 1;
    if (in_array($rol, $roles_acceso_total)) {
      $gob_reg = DB::select("select * from sp_proyecto(?)", [$anio]);
      $esuei = 0;
    }else{
      $gob_reg = DB::select("    select *  from sp_proyecto(?) where ger_direc = ?", [$anio, $gerencia]);
    }

    return Response([
      'gob_reg' => $gob_reg,
      'fecha_financiera'   => $fecha_financiera,
      'esuei' => $esuei,
    ]);
  }
}
