<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use sayhuite\ProcedimientoSeleccion;
use Validator;

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

    public function guardar_2(Request $request)
    {
        $input=$request->all();
        return $input;
        if($request->hasFile('archivo')){
            $path = $request->file('archivo')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            $heading=$data->getheading();
            // dd($heading);
            if(!empty($data) && $data->count()){
              foreach ($data as $key => $value) {
                $insert[] =
                 [
                   "id_procedimiento_seleccion"=>$value->$heading[0],
                   "nom_pro_seleccion"=>$value->$heading[1],
                   "cod_unif"=>$value->$heading[2],
                   "norma_aplicable"=>$value->$heading[3],
                   "objeto_contratacion"=>$value->$heading[4],
                   "requerimiento_documento"=>$value->$heading[5],
                   "requerimiento_fecha"=>$value->$heading[6],
                   "certificacion_documento"=>$value->$heading[7],
                   "certificacion_fecha"=>$value->$heading[8],
                   "aprob_exp_documento"=>$value->$heading[9],
                   "aprob_exp_fecha"=>$value->$heading[10],
                   "com_sel_documento"=>$value->$heading[11],
                   "com_sel_fecha"=>$value->$heading[12],
                   "com_sel_miembros"=>$value->$heading[13],
                   "aprob_bases_documento"=>$value->$heading[14],
                   "aprob_bases_fecha"=>$value->$heading[15],
                   "fecha_convocatoria"=>$value->$heading[16],
                   "tipo_proc_selec"=>$value->$heading[17],
                   "num_proc_selec"=>$value->$heading[18],
                   "valor_ref_est"=>$value->$heading[19],
                   "estado"=>$value->$heading[20],
                   "estado_fecha"=>$value->$heading[21],
                   "estado_obs"=>$value->$heading[22],
                   "buena_pro_est_fecha"=>$value->$heading[23],
                   "buena_pro_fecha_real"=>$value->$heading[24],
                   "buena_pro_obs"=>$value->$heading[25],
                   "prov_adjudicado"=>$value->$heading[26],
                   "valor_adjudicado"=>$value->$heading[27],
                   "cont_documento"=>$value->$heading[28],
                   "cont_monto"=>$value->$heading[29],
                   "cont_fecha"=>$value->$heading[30],
                   "ano"=>$value->$heading[31],
                   "fech_act"=>date('Y-m-d')
                ];
              }
              if(!empty($insert)){
                DB::table('procedimiento_seleccion')->delete();
                DB::table('procedimiento_seleccion')->insert($insert);
                // dd('Se inserto correctamente');
                return view('procedimiento/subir',['msg'=>'Se inserto correctamente']);
              }
            }
        }
    }

    public function nuevo(Request $request)
    {
      return view('procedimiento/nuevo');
    }

    public function exportar_excel(Request $request)
    {
      $input=$request->all();
      $header=[0=>"A",1=>"B",2=>"C",3=>"D",4=>"E",5=>"F",6=>"G",7=>"H",8=>"I",9=>"J",10=>"K",11=>"L",12=>"M",13=>"N",14=>"O",15=>"P",16=>"Q",17=>"R",18=>"S",19=>"T",20=>"U",21=>"V",22=>"W",23=>"X",24=>"Y",25=>"Z",26=>"AA",27=>"AB",28=>"AC",29=>"AD",30=>"AE",31=>"AF"];
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
        Excel::create('Procedimientos', function ($excel) use ($data,$columna,$header,$campo_tabla) {
            $excel->sheet('Procedimientos', function ($sheet) use ($data,$columna,$header,$campo_tabla) {
              $sheet->getStyle('A')->getAlignment()->setWrapText(true);
              $sheet->setHeight(1, 20);
              // $sheet->setBorder('A1:AG1', 'thin');
              foreach ($columna as $key => $column) {
                $sheet->cell($header[$key].'1', function($cell) use ($column,$key){
                  $cell->setBorder('thin','thin','thin','thin');
                  $cell->setBackground('#87b8e2');
                  $cell->setAlignment('center');
                  $cell->setFontWeight('bold');
                  $cell->setFontSize(12);
                  $cell->setValignment('center');
                  $cell->setValue($column);
                });
              }       
              foreach ($data as $key => $datas) {
                foreach ($header as $indice => $head) {
                  $sheet->cell($header[$indice].($key+2), function($cell) use ($datas,$key,$campo_tabla,$indice,$head) {
                    if ($head=='A') {
                      $cell->setAlignment('left');
                    }else{
                      $cell->setAlignment('center');
                    }
                    $cell->setValignment('center');
                    $cell->setValue($datas[$campo_tabla[$indice]]);
                  });  
                }                
              }
            })->download('xls');
        });
    }
}
