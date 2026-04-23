<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\PipTotalPriori;
use Illuminate\Support\Facades\DB;
use Response;
use Faker\Provider\DateTime;
use sayhuite\Taller_Usuario;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PrincipalController extends Controller
{
    protected  $year = '';
    protected  $dailyaudit = [];
    protected  $cantidad = [];
    protected  $talleres = [];

    public function __CONSTRUCT(Request $request)
    {
        $input = $request->all();
        $this->year = isset($input['year']) ? $input['year'] : '';
    }

    public function index()
    {

        $proyectosPorGer = $this->proyectosPorGerencia();

        //$actualizacionUsuarioxSemana = $this->actualizacionUsuarioxSemana();

        //$actualizacionGerenciaxSemana = $this->actualizacionGerenciaxSemana();



        // Get team
        $r = DB::select("select
        a.id,
        p.nom_proyec ,
        p.id as idpry,
        p.cod_unif,
        p.cod_snip,
        a.new,
        (((u.apellidos)::text || ', '::text) || (u.nombres)::text) AS actualizado_por,
        (SELECT d.sigla FROM (usuario_dependencia ud JOIN dependencia d ON ((ud.iddependencia = d.iddependencia)))
        WHERE
        (ud.idusuario = u.idusuario) LIMIT 1) AS gerencia, a.created_at AS actualizado_el
        FROM ((audits a JOIN grli_pip_total_priori p ON ((p.id = a.auditable_id)))
        JOIN usuario u ON ((u.idusuario = (a.user_id)::integer))) WHERE ((((a.auditable_type)::text ~~ '%PipTotalPriori'::text)
        AND ((a.user_id)::integer <> 1)) AND ((a.user_id)::integer <> 2) AND ((a.user_id)::integer <> 49)) ORDER BY actualizado_el DESC LIMIT 20");

        $r = collect($r);
        /*$r->map(function($r){
            $r['auditable_reg'] = PipTotalPriori::where('id',$r->auditable_id)->first();
            return $r;
        });*/
        $r->map(function ($r) {

            $url = "'piptotalpriori/show','full-width','1',{id: '" . $r->id . "',idproyecto: '" . $r->idpry . "' }";

            $this->dailyaudit[$r->id] =
                ' <br> <span>C. SNIP: ' . $r->cod_snip
                . ' </span> - <span> C. Unificado: ' . $r->cod_unif . ' </span>'
                . '<b>' . $r->nom_proyec . '</b>'
                . utf8_encode(' ACTUALIZADO POR ')
                . '<br><b>(' . $r->gerencia . ')</b> <span class="text-primary">' . $r->actualizado_por . '</span>'
                . ' <br> <span class="text-danger">' . $this->time_elapsed_string($r->actualizado_el) . '</span>'
                . ' <a href="#" onclick="loadModal(' . $url . ')">Ver <i class="fa fa-eye"></i></a>';
        });

        //dd($HistoryFinance);
        return response()->json([
            'pxg' => $proyectosPorGer,
            'dailyaudit' => $this->dailyaudit
            //'auxs' => $actualizacionUsuarioxSemana,
            //'agxs' => $actualizacionGerenciaxSemana
        ], 200);
    }

    public function financeDiario(Request $request)
    {
        $input = $request->all();

        // Verificar si la fecha está establecida
        if (!isset($input['fecha'])) {
            return response()->json(['error' => 'La fecha es requerida.'], 400);
        }

        try {
            $fechaSeleccionada = $input['fecha'];
            $anioSeleccionado = date('Y', strtotime($fechaSeleccionada));

            // Consulta principal para obtener los datos financieros
            $HistoryFinance = DB::select("
            SELECT *, to_char(pia_dia, '999,999,990.99') as pia_dia,
            to_char(pim_dia, '999,999,990.99') as pim_dia,
            to_char(certificacion_dia, '999,999,990.99') as certificacion_dia,
            to_char(comp_anual_dia, '999,999,990.99') as comp_anual_dia,
            to_char(ate_comp_anual_dia, '999,999,990.99') as ate_comp_anual_dia,
            to_char(dev_dia, '999,999,990.99') as dev_dia,
            to_char(girado_dia, '999,999,990.99') as girado_dia,
            a_financ_dia
            FROM grli_pip_seguimiento_ejecucion_financiera gpsef
            INNER JOIN (
                SELECT cod_unif, nom_proyec, tipo_pry, sector, ger_direc
                FROM grli_pip_total_priori
                UNION
                SELECT cod_unif, nom_proyec, 'PROCOMPITE' AS tipo_pry, sector, 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' AS ger_direc
                FROM grli_pip_procompite
            ) AS plist ON plist.cod_unif = gpsef.cod_unif::text
            WHERE fecha = ? AND anio = ? AND fuente_financiamiento IS NULL
            ORDER BY gpsef.id ASC", [$fechaSeleccionada, $anioSeleccionado]);

            // Si no hay datos en HistoryFinance, retornar un mensaje
            if (empty($HistoryFinance)) {
                return response()->json(['message' => 'No hay datos disponibles para la fecha seleccionada.'], 200);
            }

            // Consulta para los encabezados
            $Headers = DB::select("
            SELECT
                COUNT(cod_unif) as cant_proyectos,
                to_char(SUM(pia_dia), '999,999,990.99') as pia_dia,
                to_char(SUM(pim_dia), '999,999,990.99') as pim_dia,
                to_char(SUM(certificacion_dia), '999,999,990.99') as certificacion_dia,
                to_char(SUM(comp_anual_dia), '999,999,990.99') as comp_anual_dia,
                to_char(SUM(ate_comp_anual_dia), '999,999,990.99') as ate_comp_anual_dia,
                to_char(SUM(dev_dia), '999,999,990.99') as dev_dia,
                to_char(SUM(girado_dia), '999,999,990.99') as girado_dia,
                to_char(SUM(dif_pia_dia), '999,999,990.99') as dif_pia_dia,
                to_char(SUM(dif_pim_dia), '999,999,990.99') as dif_pim_dia,
                to_char(SUM(dif_certificacion_dia), '999,999,990.99') as dif_certificacion_dia,
                to_char(SUM(dif_comp_anual_dia), '999,999,990.99') as dif_comp_anual_dia,
                to_char(SUM(dif_ate_comp_anual_dia), '999,999,990.99') as dif_ate_comp_anual_dia,
                to_char(SUM(dif_dev_dia), '999,999,990.99') as dif_dev_dia,
                to_char(SUM(dif_girado_dia), '999,999,990.99') as dif_girado_dia,
                (SUM(dev_dia) / NULLIF(SUM(pim_dia), 0) * 100) as avance_total,
                COALESCE(SUM(CASE WHEN primera_aparicion = '1' THEN 1 END), 0) as nuevos,
                fecha
            FROM grli_pip_seguimiento_ejecucion_financiera gpsef
            WHERE fecha = ? AND anio = ? AND fuente_financiamiento IS NULL
            GROUP BY fecha", [$fechaSeleccionada, $anioSeleccionado]);

            // Si no hay datos en Headers, retornar un mensaje de error
            if (empty($Headers)) {
                return response()->json(['message' => 'No se encontraron encabezados para la fecha seleccionada.'], 200);
            }

            // Consulta para el Ranking
            $Ranking = DB::select("
            SELECT puesto
            FROM inf_financiera_rank
            WHERE fecha = (SELECT MAX(fecha) FROM inf_financiera_rank) AND cod = '463'");

            // Validación en caso de que no haya datos de Ranking
            $rankingData = !empty($Ranking) ? $Ranking[0] : ['puesto' => 'Sin datos'];

            // Retornar la respuesta JSON
            return response()->json([
                'data' => $HistoryFinance,
                'headers' => $Headers[0],
                'rank' => $rankingData
            ], 200);
        } catch (\Exception $e) {
            // Captura cualquier error inesperado y lo retorna en la respuesta
            return response()->json([
                'error' => 'Ocurrió un error al procesar la solicitud.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportFinanceDiario(Request $request)
    {
        $fecha = $request->input('fecha');
        if (!$fecha) {
            return redirect()->back()->with('error', 'Debe proporcionar una fecha.');
        }

        $anio = date('Y', strtotime($fecha));

        // 1️⃣ Consulta principal con join y formato limpio
        $data = DB::select("
        SELECT
            gpsef.cod_unif,
            plist.nom_proyec,
            gpsef.pia_dia,
            gpsef.pim_dia,
            gpsef.certificacion_dia,
            gpsef.comp_anual_dia,
            gpsef.ate_comp_anual_dia,
            gpsef.dev_dia,
            gpsef.girado_dia,
            gpsef.a_financ_dia
        FROM grli_pip_seguimiento_ejecucion_financiera gpsef
        INNER JOIN (
            SELECT cod_unif, nom_proyec, tipo_pry, sector, ger_direc
            FROM grli_pip_total_priori
            UNION
            SELECT cod_unif, nom_proyec, 'PROCOMPITE' AS tipo_pry, sector, 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' AS ger_direc
            FROM grli_pip_procompite
        ) plist ON plist.cod_unif = gpsef.cod_unif::text
        WHERE fecha = ? AND anio = ? AND fuente_financiamiento IS NULL
        ORDER BY gpsef.id ASC
        ", [$fecha, $anio]);

        if (empty($data)) {
            return redirect()->back()->with('error', 'No hay datos para exportar.');
        }

        // 2️⃣ Fila de totales (headers)
        $totales = DB::selectOne("
        SELECT
            SUM(pia_dia) as pia_dia,
            SUM(pim_dia) as pim_dia,
            SUM(certificacion_dia) as certificacion_dia,
            SUM(comp_anual_dia) as comp_anual_dia,
            SUM(ate_comp_anual_dia) as ate_comp_anual_dia,
            SUM(dev_dia) as dev_dia,
            SUM(girado_dia) as girado_dia,
            (SUM(dev_dia) / NULLIF(SUM(pim_dia), 0)) * 100 as a_financ_dia
        FROM grli_pip_seguimiento_ejecucion_financiera
        WHERE fecha = ? AND anio = ? AND fuente_financiamiento IS NULL
        ", [$fecha, $anio]);

        // 3️⃣ Preparar datos para Excel
        $rows = array_map(function ($item) {
            return (array) $item;
        }, $data);

        // 5️⃣ Encabezado personalizado
        $headers = [
            'Código',
            'Proyecto',
            'PIA',
            'PIM',
            'Certificado',
            'Compromiso Anual',
            'Atención Compromiso',
            'Devengado',
            'Girado',
            'Avance %'
        ];

        return Excel::create('reporte_financiero_' . $fecha, function ($excel) use ($rows, $headers, $fecha, $totales) {
            $excel->sheet('Financiero Diario', function ($sheet) use ($rows, $headers, $fecha, $totales) {

                // 🟩 1. Título principal
                $sheet->mergeCells('A1:J1');
                $sheet->row(1, ['CONSULTA AMIGABLE CON FECHA ' . date('d-m-Y', strtotime($fecha))]);
                $sheet->cells('A1:J1', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setFontSize(14);
                });

                // 🟦 2. Encabezados
                $sheet->row(3, $headers);
                $sheet->cells('A3:J3', function ($cells) {
                    $cells->setBackground('#d9d9d9');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });

                // Establecer anchos fijos para todas las columnas excepto B
                $columnWidths = [
                    'A' => 12,
                    'B' => 50,
                    'C' => 18,
                    'D' => 18,
                    'E' => 18,
                    'F' => 22,
                    'G' => 25,
                    'H' => 18,
                    'I' => 18,
                    'J' => 12,
                ];

                foreach ($columnWidths as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
                }

                // Aplicar estilos

                // 🟨 3. Datos
                $startRow = 4;
                foreach ($rows as $index => $row) {
                    $sheet->row($startRow + $index, [
                        $row['cod_unif'],
                        $row['nom_proyec'],
                        $row['pia_dia'],
                        $row['pim_dia'],
                        $row['certificacion_dia'],
                        $row['comp_anual_dia'],
                        $row['ate_comp_anual_dia'],
                        $row['dev_dia'],
                        $row['girado_dia'],
                        round($row['a_financ_dia'], 2) . '%'
                    ]);
                }

                // 🟥 4. Formato columnas numéricas
                $lastDataRow = $startRow + count($rows) - 1;
                $columnasNumericas = ['C', 'D', 'E', 'F', 'G', 'H', 'I'];

                foreach ($columnasNumericas as $col) {
                    // Alineación a la derecha
                    $sheet->getStyle($col . '4:' . $col . $lastDataRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setWrapText(true);

                    // Formato numérico
                    $sheet->getStyle($col . '4:' . $col . $lastDataRow)
                        ->getNumberFormat()
                        ->setFormatCode('#,##0.00');
                }

                // Alinear columna de porcentaje
                $sheet->getStyle('J4:J' . $lastDataRow)
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // 🟩 5. Totales
                $sheet->row($lastDataRow + 1, [
                    count($rows),
                    'TOTALES',
                    $totales->pia_dia,
                    $totales->pim_dia,
                    $totales->certificacion_dia,
                    $totales->comp_anual_dia,
                    $totales->ate_comp_anual_dia,
                    $totales->dev_dia,
                    $totales->girado_dia,
                    round($totales->a_financ_dia, 2) . '%'
                ]);

                // 🟦 6. Estilo de totales
                $sheet->cells('A' . ($lastDataRow + 1) . ':J' . ($lastDataRow + 1), function ($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setBackground('#f2f2f2');
                    $cells->setAlignment('right');
                });

                $sheet->cells('B' . ($lastDataRow + 1), function ($cells) {
                    $cells->setAlignment('left');
                });

                $sheet->cells('A' . ($lastDataRow + 1), function ($cells) {
                    $cells->setAlignment('center');
                });

                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
    }

    public function proyectosPorGerencia()
    {

        $f_today = date('Y-m-d', strtotime('-40 days'));

        $this->cantidad['t'] = PipTotalPriori::select(DB::raw("COUNT(case WHEN ger_direc IS NULL THEN 'OTROS' ELSE grli_pip_total_priori.ger_direc END), 
            case WHEN ger_direc IS NULL THEN 'OTROS' ELSE grli_pip_total_priori.ger_direc END AS c, sum(case when estado_pic = 'PRIORIZADO' then 1 else 0 end) as p"))
            ->join('grli_pip_seguimiento_ejecucion_financiera', 'grli_pip_total_priori.cod_unif', "=", DB::raw('grli_pip_seguimiento_ejecucion_financiera.cod_unif::text'))
            ->where('grli_pip_total_priori.id', '<>', 1000)
            ->where("fecha", "=", DB::raw('(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera)'))
            ->where("anio", "=", DB::raw('(select EXTRACT(YEAR FROM now())::text)'))
            ->whereNull("grli_pip_seguimiento_ejecucion_financiera.fuente_financiamiento")
            ->groupBy('ger_direc')
            ->orderBy('count', 'desc')->get();

        $this->cantidad['p'] = DB::select("select COUNT(DISTINCT(a.auditable_id)) count,pt.ger_direc from audits a
            INNER JOIN grli_pip_total_priori pt ON a.auditable_id = pt.id
            inner join grli_pip_seguimiento_ejecucion_financiera  on pt.cod_unif=grli_pip_seguimiento_ejecucion_financiera.cod_unif::text
            WHERE ((a.auditable_type)::text ~~ '%PipTotalPriori'::text)
            and pt.id<>1000 and fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera)
            and anio=(select EXTRACT(YEAR FROM now())::text) 
            and grli_pip_seguimiento_ejecucion_financiera.fuente_financiamiento is null
            AND pt.estado_pic = 'PRIORIZADO' AND  a.created_at >= '$f_today'
            AND (a.user_id)::integer <> 2 AND (a.user_id)::integer <> 49 GROUP BY pt.ger_direc;");



        $this->cantidad['t']->map(function ($cuantity) {

            foreach ($this->cantidad['p'] as $cantidadp) {
                $cuantity['pri'] = "0";
                if ($cuantity->c == $cantidadp->ger_direc) {
                    $cuantity['pri'] = $cantidadp->count;

                    break;
                }
            }
            return $cuantity;
        });

        //dd($this->cantidad['t']);
        //return $cantidad;
        return ($this->cantidad);
    }

    public function actualizacionUsuarioxSemana()
    {
        $f_today = date('Y-m-d', strtotime('-17 days'));

        $r = DB::select("select
        COUNT(a.user_id) as cuenta,
        (((u.apellidos)::text || ', '::text) || (u.nombres)::text) AS actualizado_por,
        (SELECT d.sigla FROM (usuario_dependencia ud JOIN dependencia d ON ((ud.iddependencia = d.iddependencia)))
        WHERE
        (ud.idusuario = u.idusuario) LIMIT 1) AS gerencia
        FROM ((audits a JOIN grli_pip_total_priori p ON ((p.id = a.auditable_id)))
        JOIN usuario u ON ((u.idusuario = (a.user_id)::integer))) WHERE ((((a.auditable_type)::text ~~ '%PipTotalPriori'::text)
        AND ((a.user_id)::integer <> 1)) AND ((a.user_id)::integer <> 2)) AND a.created_at >= '$f_today' GROUP BY u.apellidos,u.nombres,u.idusuario");

        return $r;
    }

    public function actualizacionGerenciaxSemana()
    {
        $f_today = date('Y-m-d', strtotime('-17 days'));

        $r = DB::select("select
        COUNT(a.user_id) as cuenta,
        (SELECT d.sigla FROM (usuario_dependencia ud JOIN dependencia d ON ((ud.iddependencia = d.iddependencia)))
        WHERE
        (ud.idusuario = u.idusuario) LIMIT 1) AS gerencia
        FROM ((audits a JOIN grli_pip_total_priori p ON ((p.id = a.auditable_id)))
        JOIN usuario u ON ((u.idusuario = (a.user_id)::integer))) WHERE ((((a.auditable_type)::text ~~ '%PipTotalPriori'::text)
        AND ((a.user_id)::integer <> 1)) AND ((a.user_id)::integer <> 2) AND ((a.user_id)::integer <> 49)) AND a.created_at >= '$f_today' GROUP BY gerencia");

        return $r;
    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'año',
            'm' => 'mes',
            'w' => 'semana',
            'd' => 'día',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                if ($v == 'mes') {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 'es' : '');
                } else {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                }
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? 'hace ' . implode(', ', $string) : 'hace un momento';
    }


    public function talleres()
    {
        $Talleres = Taller_Usuario::all();
        $today = date('Y-m-d H:i:s', strtotime('-7 days'));

        // Get team
        $r = DB::select("select
                        poi_taller_usuario.id,
                        poi_taller_usuario.hora,
                        poi_taller_usuario.fecha,
                        poi_taller.nombre,
                        (usuario.apellidos|| ', ' || usuario.nombres) as n_user,
                        (SELECT array_to_string( (array_agg(sigla))[1:2], ',' ) FROM usuario_dependencia INNER JOIN dependencia ON usuario_dependencia.iddependencia = dependencia.iddependencia where usuario_dependencia.idusuario::int = poi_taller_usuario.id_usuario::int) AS ejecutora
                        FROM poi_taller_usuario
                            INNER JOIN poi_taller ON poi_taller.id = poi_taller_usuario.id_poi_taller
                            INNER JOIN usuario ON usuario.idusuario = poi_taller_usuario.id_usuario
                        where poi_taller_usuario.fecha > '$today'
                        and poi_taller_usuario.estado = '1'
                        order by poi_taller_usuario.fecha desc
                        ");

        $r = collect($r);
        $r->map(function ($r) {
            $i = count($this->talleres);
            //$url = "'piptotalpriori/show','full-width','1',{id: '" .$r->id."',idproyecto: '".$r->idpry."' }";
            $this->talleres[$i] =
                '<br> <span style="color:black">' . $r->nombre . '</span> <br>'
                . '<span> Programado para: ' . $r->fecha . ' ' . $r->hora . ' </span> <br>'
                . '<b>(' . $r->ejecutora . ')</b> <span class="text-primary">' . $r->n_user . '</span> <br>'
                . '<a href="#" onclick="">Ver <i class="fa fa-eye"></i></a>';
        });

        return Response([
            'talleres' => $this->talleres
        ]);
    }

    public function dashSearch(Request $request)
    {
        $input = $request->all();

        $Provincia        = trim($input['cboProv']);
        $Tipo             = trim($input['cboTipo']);
        $AnioEjectFinanc  = trim($input['cboAnioEjecFinanc']);
        $Snip             = trim($input['txtSnip']);
        $Unificado        = trim($input['txtUnif']);
        $UE               = trim($input['cboUE']);
        $Nombre           = trim($input['txtSearch']);

        $PipTotalPriori = PipTotalPriori::select([
            "*"
        ]);


        if (isset($Provincia) && !empty($Provincia)) {
            $PipTotalPriori = $PipTotalPriori->whereRaw(" (SELECT array_to_string(array_agg(DISTINCT(provincia)), ',') FROM grli_proyecto_ubicacion where idpi = grli_pip_total_priori.id) ilike '%" . $Provincia . "%' ");
        }
        if (isset($Tipo) && !empty($Tipo)) {
            $PipTotalPriori = $PipTotalPriori->where('tipo_pry', '=', $Tipo);
        }
        if (isset($AnioEjectFinanc) && !empty($AnioEjectFinanc)) {
            $PipTotalPriori = $PipTotalPriori->where('ult_anio_ejec_pry_financ', '=', $AnioEjectFinanc);
        }
        if (isset($Snip) && !empty($Snip)) {
            $PipTotalPriori = $PipTotalPriori->where('cod_snip', '=', $Snip);
        }
        if (isset($Nombre) && !empty($Nombre)) {
            $PipTotalPriori = $PipTotalPriori->whereRaw(" (grli_pip_total_priori.nom_proyec || ';' || grli_pip_total_priori.cod_unif || ';' || grli_pip_total_priori.cod_snip) ilike '%" . $Nombre . "%'");
        }
        if (isset($Unificado) && !empty($Unificado)) {
            $PipTotalPriori = $PipTotalPriori->where('grli_pip_total_priori.cod_unif', '=', $Unificado);
        }
        if (isset($UE) && !empty($UE)) {

            switch ($UE) {
                case 'GRI':
                    $UE = 'GERENCIA REGIONAL DE INFRAESTRUCTURA';
                    break;
                case 'DRA':
                    $UE = 'DIRECCION REGIONAL DE AGRICULTURA';
                    break;
                case 'DRTC':
                    $UE = 'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES';
                    break;
                case 'DRE':
                    $UE = 'DIRECCION REGIONAL DE EDUCACIï¿½N';
                    break;
                case 'DIRESA':
                    $UE = 'DIRECCION REGIONAL DE SALUD';
                    break;
                case 'GRDS':
                    $UE = 'GERENCIA REGIONAL DE DESARROLLO SOCIAL';
                    break;
                case 'GSRLS':
                    $UE = 'SUB GERENCIA REGIONAL LIMA SUR';
                    break;
                case 'GRDE':
                    $UE = 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO';
                case 'GRRNGMA':
                    $UE = 'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE';
                    break;
            }

            $PipTotalPriori = $PipTotalPriori->whereRaw("grli_pip_total_priori.ger_direc ilike '%" . $UE . "%'");
        }

        $onRoadPiptotal = $PipTotalPriori;
        $PipTotalPriori = $PipTotalPriori->get();

        $Resumen = "";
        $Graphs  = "";

        if (count($PipTotalPriori) == 1) {
            $Resumen = $this->getPipResumen($PipTotalPriori);
            $Graphs  = $this->getPipGraphs($PipTotalPriori);
        } else if (count($PipTotalPriori) > 1) {
            $Resumen = $this->getPipsResumen($onRoadPiptotal, $AnioEjectFinanc);
            $Graphs  = $this->getPipsGraphs($onRoadPiptotal, $AnioEjectFinanc);
        }

        return Response([
            'Resumen' => $Resumen,
            'Graphs' => $Graphs
        ]);
    }

    public function getPipResumen($pip)
    {
        $Pip        = $pip->first();
        $Proyecto   = $Pip;
        $Obras      = DB::table('vw_grli_obra_list')->where('idproyecto', '=', $Pip->id)->get();
        $Contratos  = DB::table('grli_pip_total_priori_contratos')->where('idproyecto', '=', $Pip->id)->get();
        $Alcance    = DB::table('grli_proyecto_ubicacion')->where('idpi', '=', $Pip->id)->get();

        return view('principal.dash.one.info')->with([
            'obras' => $Obras,
            'proyecto' => $Proyecto,
            'contratos' => $Contratos,
            'alcance' => $Alcance
        ])->render();
    }

    public function getPipGraphs($pip)
    {
        return View::make('principal.dash.one.graphs');
    }

    public function getPipsResumen($pips, $year)
    {

        $Proyectos = $pips->join('grli_pip_total_girado', function ($join) use ($year) {
            $join->on('grli_pip_total_girado.cod_unif', '=', 'grli_pip_total_priori.cod_unif')
                ->where('grli_pip_total_girado.anio', '=', $year);
        })
            ->get();

        $resumen = [
            'PIM_ACUMULADO' => 0.0,
            'DEVENGADO_ACUMULADO' => 0.0,
            'AVANCE_FINANCIERO_ACUMULADO' => 0.0,
            'PIM_ACTUAL' => 0.0,
            'DEVENGADO_ACTUAL' => 0.0,
            'GIRADO_ACTUAL' => 0.0,
            'AVANCE_FINANCIERO_ACTUAL' => 0.0
        ];

        foreach ($Proyectos as $key => $value) {
            $resumen['PIM_ACUMULADO'] += $value['m_pim_acu'];
            $resumen['DEVENGADO_ACUMULADO'] += $value['m_deveng_a'];
            //$resumen['AVANCE_FINANCIERO_ACUMULADO'] += $value['a_financ_a'];
            $resumen['PIM_ACTUAL'] += $value['m_pim'];
            $resumen['DEVENGADO_ACTUAL'] += $value['m_deveng'];
            $resumen['GIRADO_ACTUAL'] += $value['girado'];
            $resumen['AVANCE_FINANCIERO_ACTUAL'] += $value['a_financ'];
        }

        return view('principal.dash.more.info')->with([
            'proyectos' => $Proyectos,
            'resumen' => $resumen
        ])->render();
    }

    public function getPipsGraphs($pips)
    {
        return View::make('principal.dash.more.graphs');
    }
}
