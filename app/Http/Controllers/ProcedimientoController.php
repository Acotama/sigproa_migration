<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use sayhuite\Models\ProcedimientoSeleccion;
use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProcedimientoController extends Controller
{
    public function inicio()
    {
      return view('procedimiento/procedimiento');
    }

    public function resumen()
    {
      return view('procedimiento/resumen');
    }

    public function datos(Request $request)
    {
      $procedimiento= DB::select("select * from procedimiento_seleccion");
      return Response([
        'data' => $procedimiento
      ]);
    }

    public function datosjson(Request $request)
    {
      $procedimiento = ProcedimientoSeleccion::orderBy("id_procedimiento_seleccion")->where('estado_borrado','!=',0)->get();
      $procedimiento_resumen = ProcedimientoSeleccion::select(DB::raw("grli_pip_total_priori.ger_direc,count(distinct procedimiento_seleccion.cod_unif) as proyecto,
      count(procedimiento_seleccion.cod_unif) as requerimiento,
      count(certificacion_fecha) as certificacion,
      count(aprob_exp_fecha) as aprob_expediente,
      count(com_sel_fecha) as comite_seleccion,
      count(aprob_bases_fecha) as aprob_bases,
      count(cont_fecha) as contrato,
      sum(valor_ref_est) as valor_ref_est,
      sum(valor_adjudicado) as valor_adjudicado"))
      ->join('grli_pip_total_priori',DB::raw('procedimiento_seleccion.cod_unif::text'),'=','grli_pip_total_priori.cod_unif')
      ->where('estado_borrado','!=',0)
      ->groupBy('ger_direc')->get();

      return Response([
        'resumen' => $procedimiento_resumen,
        'data' => $procedimiento
      ]);
    }

    public function datosproyecto(Request $request)
    {
      $input = $request->all();

      $proyecto_resumen = ProcedimientoSeleccion::select(DB::raw("procedimiento_seleccion.cod_unif,grli_pip_total_priori.nom_proyec,count(distinct procedimiento_seleccion.cod_unif) as proyecto,
      count(procedimiento_seleccion.cod_unif) as requerimiento,
      count(certificacion_fecha) as certificacion,
      count(aprob_exp_fecha) as aprob_expediente,
      count(com_sel_fecha) as comite_seleccion,
      count(aprob_bases_fecha) as aprob_bases,
      count(cont_fecha) as contrato,
      sum(valor_ref_est) as valor_ref_est,
      sum(valor_adjudicado) as valor_adjudicado"))
      ->join('grli_pip_total_priori',DB::raw('procedimiento_seleccion.cod_unif::text'),'=','grli_pip_total_priori.cod_unif')->where('ger_direc','=',$input['gerencia'])
      ->where('estado_borrado','!=',0)
      ->groupBy('procedimiento_seleccion.cod_unif')
      ->groupBy('nom_proyec')->get();

      return Response([
        'proyecto' => $proyecto_resumen
      ]);
    }

    public function datosrequerimientos(Request $request)
    {
      $input = $request->all();

      $requerimiento_resumen = ProcedimientoSeleccion::select(DB::raw("procedimiento_seleccion.*"))
      ->join('grli_pip_total_priori',DB::raw('procedimiento_seleccion.cod_unif::text'),'=','grli_pip_total_priori.cod_unif')->where('ger_direc','=',$input['gerencia'])
      ->where('estado_borrado','!=',0)
      ->orderBy('id_procedimiento_seleccion')->get();

      return Response([
        'requerimiento' => $requerimiento_resumen
      ]);
    }

    public function datosrequerimientosfiltro(Request $request)
    {
      $input = $request->all();

      $requerimiento_resumen = ProcedimientoSeleccion::select(DB::raw("procedimiento_seleccion.*"))
      ->join('grli_pip_total_priori',DB::raw('procedimiento_seleccion.cod_unif::text'),'=','grli_pip_total_priori.cod_unif')->where('procedimiento_seleccion.cod_unif','=',$input['gerencia'])
      ->orderBy('id_procedimiento_seleccion')->get();

      return Response([
        'requerimiento' => $requerimiento_resumen
      ]);
    }

    public function subir(Request $request)
    {
        return view('procedimiento/subir');
    }

    public function guardar(Request $request)
    {
      $input=$request->all();
      $data = json_decode($input['data']);
      $rules =
        [
          'cod_unif'   => 'nullable|numeric',
          'fech_act' => 'nullable|date',
          'requerimiento_fecha' => 'nullable|date',
          'certificacion_fecha' => 'nullable|date',
          'aprob_exp_fecha' => 'nullable|date',
          'com_sel_fecha' => 'nullable|date',
          'aprob_bases_fecha' => 'nullable|date',
          'fecha_convocatoria' => 'nullable|date',
          'estado_fecha' => 'nullable|date',
          'buena_pro_est_fecha' => 'nullable|date',
          'buena_pro_fecha_real' => 'nullable|date',
          'estado_fecha' => 'nullable|date',
          'cont_fecha' => 'nullable|date',      
          'valor_ref_est'   => 'nullable|numeric',
          'valor_adjudicado'   => 'nullable|numeric',
          'cont_monto'   => 'nullable|numeric',
          'ano'   => 'nullable|numeric',
        ];

      $max= ProcedimientoSeleccion::max('id_procedimiento_seleccion') + 1; 
      if (empty($max)) {
        $max=1;
      }  

      foreach ($data as $key => $value) {
          $insert[] =
                [
                   "id_procedimiento_seleccion"=>$max + $key,
                   "nom_pro_seleccion"=>empty($value[0])?null:$value[0],
                   "cod_unif"=> empty($value[1])?null:$value[1],
                   "norma_aplicable"=>empty($value[2])?null:$value[2],
                   "objeto_contratacion"=>empty($value[3])?null:$value[3],
                   "requerimiento_documento"=>empty($value[4])?null:$value[4],
                   "requerimiento_fecha"=>empty($value[5])?null:$value[5],
                   "certificacion_documento"=>empty($value[6])?null:$value[6],
                   "certificacion_fecha"=>empty($value[7])?null:$value[7],
                   "aprob_exp_documento"=>empty($value[8])?null:$value[8],
                   "aprob_exp_fecha"=>empty($value[9])?null:$value[9],
                   "com_sel_documento"=>empty($value[10])?null:$value[10],
                   "com_sel_fecha"=>empty($value[11])?null:$value[11],
                   "com_sel_miembros"=>empty($value[12])?null:$value[12],
                   "aprob_bases_documento"=>empty($value[13])?null:$value[13],
                   "aprob_bases_fecha"=>empty($value[14])?null:$value[14],
                   "fecha_convocatoria"=>empty($value[15])?null:$value[15],
                   "tipo_proc_selec"=>empty($value[16])?null:$value[16],
                   "num_proc_selec"=>empty($value[17])?null:$value[17],
                   "valor_ref_est"=>empty($value[18])?null:$value[18],
                   "estado"=>empty($value[19])?null:$value[19],
                   "estado_fecha"=>empty($value[20])?null:$value[20],
                   "estado_obs"=>empty($value[21])?null:$value[21],
                   "buena_pro_est_fecha"=>empty($value[22])?null:$value[22],
                   "buena_pro_fecha_real"=>empty($value[23])?null:$value[23],
                   "buena_pro_obs"=>empty($value[24])?null:$value[24],
                   "prov_adjudicado"=>empty($value[25])?null:$value[25],
                   "valor_adjudicado"=>empty($value[26])?null:$value[26],
                   "cont_documento"=>empty($value[27])?null:$value[27],
                   "cont_monto"=>empty($value[28])?null:$value[28],
                   "cont_fecha"=>empty($value[29])?null:$value[29],
                   "ano"=>empty($value[30])?null:$value[30],
                   "fech_act"=>date('Y-m-d'),
                   "estado_borrado"=>1
                ];
      }
      if(!empty($insert)){
        foreach($insert as $ins){
          $validator = Validator::make($ins, $rules);
          if ($validator->fails()){
            $mensajes = $validator->messages();
            return Response(['error'=> true,'messages'=> $mensajes->all()],400);
          }
        }
        DB::table('procedimiento_seleccion')->update(['estado_borrado' => 0]);
        DB::table('procedimiento_seleccion')->insert($insert);
        return Response(['error' => false,'messages'=>count($insert)],200);
      }
    }
    
    public function guardar_formulario(Request $request)
    {
        $input=$request->all();
        $data=$input;
        $data["id_procedimiento_seleccion"]= ProcedimientoSeleccion::max('id_procedimiento_seleccion') + 1;
        $data["estado_borrado"]=1;
        $data["cod_unif"]= empty($data["cod_unif"])?null:$data["cod_unif"];
        $data["requerimiento_fecha"]=empty($data["requerimiento_fecha"])?null:$data["requerimiento_fecha"];
        $data["certificacion_fecha"]=empty($data["certificacion_fecha"])?null:$data["certificacion_fecha"];
        $data["aprob_exp_fecha"]=empty($data["aprob_exp_fecha"])?null:$data["aprob_exp_fecha"];
        $data["com_sel_fecha"]=empty($data["com_sel_fecha"])?null:$data["com_sel_fecha"];
        $data["aprob_bases_fecha"]=empty($data["aprob_bases_fecha"])?null:$data["aprob_bases_fecha"];
        $data["fecha_convocatoria"]=empty($data["fecha_convocatoria"])?null:$data["fecha_convocatoria"];
        $data["estado_fecha"]=empty($data["estado_fecha"])?null:$data["estado_fecha"];
        $data["buena_pro_est_fecha"]=empty($data["buena_pro_est_fecha"])?null:$data["buena_pro_est_fecha"];
        $data["buena_pro_fecha_real"]=empty($data["buena_pro_fecha_real"])?null:$data["buena_pro_fecha_real"];
        $data["cont_fecha"]=empty($data["cont_fecha"])?null:$data["cont_fecha"];
        $data["fech_act"]=date('Y-m-d');
        $data["valor_adjudicado"]=empty($data["valor_adjudicado"])?null:$data["valor_adjudicado"];
        $data["cont_monto"]=empty($data["cont_monto"])?null:$data["cont_monto"];
        $data["valor_ref_est"]=empty($data["valor_ref_est"])?null:$data["valor_ref_est"];

        
        if(!empty($data)){
            DB::table('procedimiento_seleccion')->insert($data);
            return Response(['error' => false,'messages'=>'Se inserto correctamente'],200);
        }
    }


    public function nuevo(Request $request)
    {
      return view('procedimiento/nuevo');
    }

    public function exportar_excel(Request $request)
    {
      $columna = 
        [ 
          0 => "NOMENCLATURA DEL PROCEDIMIENTO DE SELECCIÓN",
          1 => "CÓDIGO UNIFICADO",
          2 => "NORMATIVIDAD APLICABLE",
          3 => "OBJETO DE LA CONTRATACIÓN",
          4 => "REQUERIMIENTO (DOCUMENTO)",
          5 => "REQUERIMIENTO (FECHA)",
          6 => "CERTIFICACIÓN (DOCUMENTO)",
          7 => "CERTIFICACION (FECHA)",
          8 => "APROBACION DE EXPEDIENTE (DOCUMENTO)",
          9 => "APROBACION DE EXPEDIENTE (FECHA)",
          10 => "COMITE DE SELECCION (DOCUMENTO)",
          11 => "COMITE DE SELECCION (FECHA)",
          12 => "COMITE DE SELECCION (MIEMBROS)",
          13 => "APROBACION DE BASES  (DOCUMENTO)",
          14 => "APROBACION DE BASES  (FECHA)",
          15 => "FECHA DE CONVOCATORIA",
          16 => "TIPO DE PROCEDIMIENTOS DE SELECCIÓN",
          17 => "NÚMERO DE PROCEDIMIENTOS DE SELECCIÓN",
          18 => "VALOR REFERENCIAL / ESTIMADO",
          19 => "ESTADO",
          20 => "ESTADO (FECHA)",
          21 => "ESTADO(OBSERVACIÓN)",
          22 => "BUENO PRO ESTIMADA FECHA",
          23 => "FECHA REAL DE LA BUENA PRO",
          24 => "OBSERVACION DE LA BUENA PRO",
          25 => "PROVEEDOR ADJUJICADO",
          26 => "VALOR ADJUDICADO",
          27 => "CONTRATO U ORDEN (DOCUMENTO)",
          28 => "CONTRATO U ORDEN (MONTO)",
          29 => "CONTRATO U ORDEN (FECHA)",
          30 => "AÑO",
          31 => "FECHA ACTUALIZACIÓN"
        ];
      $campo_tabla = [0=>"nom_pro_seleccion",1=>"cod_unif",2=>"norma_aplicable",3=>"objeto_contratacion",4=>"requerimiento_documento",5=>"requerimiento_fecha",6=>"certificacion_documento",7=>"certificacion_fecha",8=>"aprob_exp_documento",9=>"aprob_exp_fecha",10=>"com_sel_documento",11=>"com_sel_fecha",12=>"com_sel_miembros",13=>"aprob_bases_documento",14=>"aprob_bases_fecha",15=>"fecha_convocatoria",16=>"tipo_proc_selec",17=>"num_proc_selec",18=>"valor_ref_est",19=>"estado",20=>"estado_fecha",21=>"estado_obs",22=>"buena_pro_est_fecha",23=>"buena_pro_fecha_real",24=>"buena_pro_obs",25=>"prov_adjudicado",26=>"valor_adjudicado",27=>"cont_documento",28=>"cont_monto",29=>"cont_fecha",30=>"ano",31=>"fech_act"];
      $data =  ProcedimientoSeleccion::select('nom_pro_seleccion','cod_unif','norma_aplicable','objeto_contratacion','requerimiento_documento','requerimiento_fecha','certificacion_documento','certificacion_fecha','aprob_exp_documento','aprob_exp_fecha','com_sel_documento','com_sel_fecha','com_sel_miembros','aprob_bases_documento','aprob_bases_fecha','fecha_convocatoria','tipo_proc_selec','num_proc_selec','valor_ref_est','estado','estado_fecha','estado_obs','buena_pro_est_fecha','buena_pro_fecha_real','buena_pro_obs','prov_adjudicado','valor_adjudicado','cont_documento','cont_monto','cont_fecha','ano','fech_act')->orderBy("id_procedimiento_seleccion")->where('estado_borrado','!=',0)->get();

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setTitle('Procedimientos');

      $sheet->fromArray(array_values($columna), null, 'A1');
      $sheet->getStyle('A1:AF1')->getFont()->setBold(true)->setSize(12);
      $sheet->getStyle('A1:AF1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
      $sheet->getStyle('A1:AF1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('87B8E2');
      $sheet->getRowDimension(1)->setRowHeight(20);

      $rowNumber = 2;
      foreach ($data as $item) {
        $row = [];
        foreach ($campo_tabla as $key) {
          $row[] = isset($item[$key]) ? $item[$key] : '';
        }
        $sheet->fromArray($row, null, 'A' . $rowNumber);
        $rowNumber++;
      }

      $lastRow = max(2, $rowNumber - 1);
      $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
      $sheet->getStyle('B2:AF' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle('A1:AF' . $lastRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);

      foreach (range('A', 'Z') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
      }
      foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension('A' . $col)->setAutoSize(true);
      }

      $tempFile = tempnam(sys_get_temp_dir(), 'xlsx_');
      $writer = new Xlsx($spreadsheet);
      $writer->save($tempFile);

      return response()->download($tempFile, 'Procedimientos.xlsx')->deleteFileAfterSend(true);
    }
}
