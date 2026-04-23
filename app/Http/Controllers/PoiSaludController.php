<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use DB;
use File;
use sayhuite\Logic\Tools\Tools;
use sayhuite\Logic\Image\ImageRepository;
use Illuminate\Support\Facades\Storage;


use sayhuite\Usuario;
use sayhuite\Atencion_Img;
use sayhuite\Dependencia;
use sayhuite\ActividadOperativa;
use sayhuite\CadenaFuncional;
use sayhuite\AtencionUsuario;

use sayhuite\Logic\Funcion\Salud;
use Excel;
use PDF;
use Validator;

class PoiSaludController extends Controller
{
    protected $controlador = 'poi.salud';
    protected $num = 10;
    protected $imageDate = '';
    protected $exifdata = "";

    function __construct(){
        $this->Sector = new Salud();
    }    

    public function index(){
        return View($this->controlador . ".intervencion.index");
    }   

    public function programacion() {

        return View::make($this->controlador. '.index');
    }

    public function cartilla($id) {            	       
        //PACIENTE
        $Paciente = DB::table('poi_salud_paciente')        
        ->select([
            'poi_salud_paciente.*',
            DB::raw('EXTRACT( year from  age(poi_salud_paciente.fecha_nac) ) * 12 + EXTRACT( month from  age(poi_salud_paciente.fecha_nac) ) as edad_meses '),
        ])
        ->where('id',$id)
        ->first();

        //CRECIMIENTO
        $Crecimiento = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%crecimiento%')
        ->get();

        $AtencionUsuarioCrecimiento = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%crecimiento%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //CRECIMIENTO #end

        //SUPLEMENTACION CON HIERRO EN GOTAS
        $HierroGotas = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%hierro en gotas%')
        ->get();

        $atHierroGotas = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%hierro en gotas%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //SUPLEMENTACION CON HIERRO EN GOTAS #end


        //MULTIMICRONUTRIENTES
        $Multimicronutrientes = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%Multimicronutrientes%')
        ->get();

        $atMultimicronutrientes = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%Multimicronutrientes%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //MULTIMICRONUTRIENTES #end

        //HEMOGLOBINA
        $Hemoglobina = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%HEMOGLOBINA%')
        ->get();

        $atHemoglobina = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%HEMOGLOBINA%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //HEMOGLOBINA #end

         //vpentavalente
        $Vpentavalente = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%pentavalente%')
        ->get();

        $atVpentavalente = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%pentavalente%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //vpentavalente #end

        //VACUNA IPV
        $Vipv = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%ipv%')
        ->get();

        $atVipv = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%ipv%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //VACUNA IPV #end

        //VACUNA ROTAVIRUS
        $vrotavirus = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%rotavirus%')
        ->get();

        $atvrotavirus = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%rotavirus%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //VACUNA ROTAVIRUS #end

        //VACUNA antipolio
        $vantipolio = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%antipolio%')
        ->get();

        $atvantipolio = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%antipolio%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //VACUNA antipolio #end

        //VACUNA neumococo
        $vneumococo = DB::table('poi_salud_actividad_operativa_programacion')
        ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
        ->where('nombre','ilike','%neumococo%')
        ->get();

        $atvneumococo = AtencionUsuario::select([
                DB::raw('poi_salud_atencion_usuario.id as id_atencion_usuario'),
                'poi_salud_atencion_usuario.observacion',
                'poi_salud_atencion_usuario.estado',
                'poi_salud_atencion_usuario.id_poi_salud_paciente',
                'poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion',
                'poi_salud_atencion_usuario.edad_meses',
                'poi_salud_actividad_operativa_programacion.denom'
                ])
                ->join('poi_salud_actividad_operativa_programacion','poi_salud_actividad_operativa_programacion.id','=','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion')
                ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                ->where('poi_actividad_operativa.nombre','ilike','%neumococo%')
                ->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$id)
                ->get();
        //VACUNA neumococo #end

        return View::make($this->controlador. '.control')->with([
            'Paciente' => $Paciente,
            'crecimiento' => $Crecimiento,
            'atcrecimiento' => $AtencionUsuarioCrecimiento,
            'hierrogotas' => $HierroGotas,
            'athierrogotas' => $atHierroGotas,
            'multimicronutrientes' => $Multimicronutrientes,
            'atmultimicronutrientes' => $atMultimicronutrientes,
            'hemoglobina' => $Hemoglobina,
            'athemoglobina' => $atHemoglobina,
            'vpentavalente' => $Vpentavalente,
            'atvpentavalente' => $atVpentavalente,
            'vipv' => $Vipv,
            'atvipv' => $atVipv,
            'vrotavirus' => $vrotavirus,
            'atvrotavirus' => $atvrotavirus,
            'vantipolio' => $vantipolio,
            'atvantipolio' => $atvantipolio,
            'vneumococo' => $vneumococo,
            'atvneumococo' => $atvneumococo
            ]);
    }

    public function filter(Request $request, $seccion){
        $input = $request->all();

        switch ($seccion) {
            case 'programacion':
                return $this->Sector->programacionFilter($input);
                break;
            case 'intervenciones':
                return Response($this->Sector->intervencionFilter($input));
                break;
            case 'resumen':
                return $this->Sector->resumenFilter($input);
                break;
            default:
                # code...
                break;
        }        
    }

    public function intervencion(Request $request){

    	$input = $request->all();

    	$Paciente = DB::table('poi_salud_paciente')->where('id',$input['id'])->first();

    	/*$Edad = $Paciente->meses;*/

    	//$Dosis = DB::table('poi_salud_atencion_usuario')->whereRaw('')->get();

    	return Response([
    			'paciente' => $Paciente
    	],200);
    }

    public function dosis(Request $request){

    	$input = $request->all();

        $idPaciente = $input['idpaciente'];
        $idActOp = $input['id'];

    	$Dosis = DB::table('poi_salud_actividad_operativa_programacion')                
            ->select([
                "id",
                DB::raw("denom || ' - Año ' || year || ' - Mes ' || mes as denom")
                ])
            ->where('id_poi_actividad_operativa', $idActOp)            
            ->whereRaw("orden::int >  coalesce( (  select max(orden) from poi_salud_atencion_usuario 
                        inner join 
                            poi_salud_actividad_operativa_programacion on poi_salud_actividad_operativa_programacion.id = poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion
                        where poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa = $idActOp
                        and poi_salud_atencion_usuario.estado not like 'aplazado' and poi_salud_atencion_usuario.id_poi_salud_paciente = $idPaciente )::int, 0 )  ")
            ->get()->toArray();
            

    	return Response($Dosis, 200);
    }

    public function save(Request $request){

    	$input = $request->all();

        $rules = [
            'cboIntervencion' => 'bail|required',
            'txtFecha' => 'required',
            'cboDosis' => 'required',
            'txtYears' => 'required|numeric',
            'txtMeses' => 'required|numeric',
            'optEstado' => 'required',
            'txtPeso' => 'nullable|numeric',
            'txtTalla' => 'nullable|numeric'
        ];

        $attributeNames = [
            'cboIntervencion' => 'Intervención',
            'txtFecha' => 'Fecha de Intervención',
            'cboDosis' => 'Dosis',
            'txtYears' => 'Años',
            'txtMeses' => 'Meses',
            'optEstado' => 'Estado',
            'txtPeso' => 'Peso',
            'txtTalla' => 'Talla'

        ];


        $validator = Validator::make($input, $rules);
        $validator->setAttributeNames($attributeNames); 
        if ($validator->fails()) {
            $mensaje_error = [];
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                array_push($mensaje_error, $mensaje);
            }
            return Response([
                    'error' => 1,
                    'messages' => $mensaje_error,
                    'data' => ""
            ],400);
        } else {
             DB::beginTransaction();

            try{

                /*$Dosis = DB::table("poi_salud_actividad_operativa_programacion")->select("id")
                ->where("id_poi_actividad_operativa",$input['cboIntervencion'])
                ->where("denom",'like',$input['txtDosis'])
                ->first();*/                

                $AtencionUsuario = new AtencionUsuario();
                
                $AtencionUsuario->observacion = $input['txtObservacion'];
                $AtencionUsuario->estado = $input['optEstado'];
                $AtencionUsuario->edad_meses = (int)($input['txtYears'] * 12) + (int)$input['txtMeses'];
                $AtencionUsuario->years = $input['txtYears'];

                $AtencionUsuario->peso = $input['txtPeso'] == "" ? 0 :  $input['txtPeso'];
                $AtencionUsuario->talla = $input['txtTalla'] == "" ? 0 : $input['txtTalla'];

                $AtencionUsuario->fecha_intervencion = $input['txtFecha'];
                $AtencionUsuario->meses = $input['txtMeses'];
                $AtencionUsuario->id_poi_salud_paciente = $input['txtidPaciente'];
                $AtencionUsuario->id_poi_salud_actividad_operativa_programacion = $input['cboDosis'];

                $AtencionUsuario->save();
               
            } catch(Exception $e){
                DB::rollback();
                return Response('Error al Guardar',500);
            }

            DB::commit();

            return Response([
                    'message' => 'Ahora Registre Evidencia Fotográfica',
                    'data' => $AtencionUsuario->id
                ],200);
        }

    	return Response([
    			'input' => $input
    		],200);
    }

    public function show(Request $request){   

        $input = $request->all();

        $Actividades_Operativas = DB::table('poi_actividad_operativa')
        ->select('poi_actividad_operativa.*')
        ->join('cadena_funcional_programatica','poi_actividad_operativa.id_cadena', '=', 'cadena_funcional_programatica.id')
        ->where('cadena_funcional_programatica.funcion','ilike','%salud%')
        ->get();

        $id = $input['id_atencion'];

        $Atencion = AtencionUsuario::select('poi_salud_atencion_usuario.*','poi_salud_actividad_operativa_programacion.*','poi_actividad_operativa.*')
                        ->join('poi_salud_actividad_operativa_programacion','poi_salud_atencion_usuario.id_poi_salud_actividad_operativa_programacion','=','poi_salud_actividad_operativa_programacion.id')
                        ->join('poi_actividad_operativa', 'poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
                        ->where('poi_salud_atencion_usuario.id',$id)
                        ->first();

        $Selected = DB::table('poi_salud_actividad_operativa_programacion')->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')->where('poi_salud_actividad_operativa_programacion.id','=',$Atencion->id_poi_salud_actividad_operativa_programacion)->first();

        $Paciente = DB::table('poi_salud_paciente')->find($Atencion->id_poi_salud_paciente);
        
        return view($this->controlador.'.intervencion.show')
                ->with([
                    'act_op' => $Actividades_Operativas,
                    'Paciente' => $Paciente,
                    'Atencion' => $Atencion
                ])->render();
    }

    public function formImg(Request $request){

        $Actividades_Operativas = DB::table('poi_actividad_operativa')
        ->select('poi_actividad_operativa.*')
        ->join('cadena_funcional_programatica','poi_actividad_operativa.id_cadena', '=', 'cadena_funcional_programatica.id')
        ->where('cadena_funcional_programatica.funcion','ilike','%salud%')
        ->get()
        ->toArray();

        $input = $request->all();    
        $id = $input['id'];

        $Paciente = DB::table('poi_salud_paciente')->find($id);
        
        return view($this->controlador.'.create')
                ->with([
                    'act_op' => $Actividades_Operativas,
                    'Paciente' => $Paciente
                    ])->render();
    }


    //EDIT INTERVENCION
    public function edit(Request $request){

        $input = $request->all();

        $Actividades_Operativas = DB::table('poi_actividad_operativa')
        ->select('poi_actividad_operativa.*')
        ->join('cadena_funcional_programatica','poi_actividad_operativa.id_cadena', '=', 'cadena_funcional_programatica.id')
        ->where('cadena_funcional_programatica.funcion','ilike','%salud%')
        ->get();

        $id = $input['id'];

        $Atencion = AtencionUsuario::find($id);

        $Selected = DB::table('poi_salud_actividad_operativa_programacion')
            ->join('poi_actividad_operativa','poi_actividad_operativa.id','=','poi_salud_actividad_operativa_programacion.id_poi_actividad_operativa')
            ->where('poi_salud_actividad_operativa_programacion.id','=',$Atencion->id_poi_salud_actividad_operativa_programacion)
            ->first();

        $Actividades_Operativas->transform(function ($item, $key) use ($Selected) {
            if ( $item->nombre == $Selected->nombre ){
                $item->selected = true;
            } else {
                $item->selected = false;
            }

            return $item;
        });

        $Dosis = DB::table('poi_salud_actividad_operativa_programacion')
            ->select([
                DB::raw("denom || ' - Año ' || year || ' - Mes ' || mes as denom"),
                'id'
            ])                
            ->where('id_poi_actividad_operativa', $Selected->id)
            ->get();

        $Dosis->transform(function ($item, $key) use ($Selected) {
            if ( $item->id == $Selected->id ){
                $item->selected = true;
            } else {
                $item->selected = false;
            }

            return $item;
        }); 

        $Paciente = DB::table('poi_salud_paciente')->find($Atencion->id_poi_salud_paciente);       
        
        return view($this->controlador.'.intervencion.edit')
                ->with([
                    'act_op' => $Actividades_Operativas,
                    'dosis' => $Dosis,
                    'Paciente' => $Paciente,
                    'Atencion' => $Atencion
                ])->render();
    }

    private function image_fix_orientation($filename, $onserverimg) {

        $exif = "";
        $exif = @exif_read_data($filename, 'IFD0');

        $this->exifdata = $exif;

        if($exif){
            if(isset($exif["DateTime"])){
                $this->imageDate = date ("Y-m-d H:i:s", strtotime($exif["DateTime"]));
            }else if(isset($exif['DateTimeOriginal'])){
                $this->imageDate = date ("Y-m-d H:i:s", strtotime($exif["DateTimeOriginal"]));
            }                 
        }            
        
        if (!empty($exif['Orientation'])) {
            $image = imagecreatefromjpeg($filename);
            switch ($exif['Orientation']) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;

                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;

                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
            }

            imagejpeg($image, $onserverimg, 90);
        }
    }

    public function upload(Request $request,ImageRepository $image){
        /*
        * Vars
        */
        $input = $request->all();

        $idAtencion = $input['uid'];
        $fecha = $input['fecha'];
        $fecha = date ("d-m-Y", strtotime($fecha));
        $exif = 0;

        $idUsuario =  Auth::user()->id;
        //$Taller = Taller_Usuario::where('id',$idAtencion)->first();
        //$Taller = DB::table('vw_poi_taller_usuario_detail')->where('id',$idAtencion)->first();

        //dd($Taller);

        /*if( $Taller->fecha > date('Y-m-d')  ){
            return Response([
                'error' => true,
                'messages' => ["Aún no puede subir foto alguna"],
                'code' => 400
            ], 400);
        }
        else if( $Taller->fecha < date('Y-m-d', strtotime(date('Y-m-d'). ' + 2 days'))  ){
            return Response([
                'error' => true,
                'messages' => ["Ya no puede subir foto alguna"],
                'code' => 400
            ], 400);
        }*/

        $input = $request->all();

        //TMP NAME OF IMAGES
        $tmpName = Tools::generateTmpName();
        $fileName = '';
        $lastNumber = 0;
        
        //CREATE DIRECTORY
        if(File::exists('images/poi_salud/'.$idAtencion)){
            $files = scandir('images/poi_salud/' . $idAtencion, 1);
            $files = array_diff($files, array('.', '..'));
            natsort($files);

            if(!empty($files)) {
                $t = explode('_', end($files));
                $lastNumber = $t[1];
            }
        } else {
            File::makeDirectory('images/poi_salud/' . $idAtencion);
        }
        
        //VALIDATOR>>>>>>>>>>>>
        foreach ($input['file'] as $key => $file) {
            $arr = ['file' => $file];
            $rules = [
                'file' => 'required|mimes:png,gif,jpeg,jpg,bmp,PNG,JPG,JPEG,BMP,GIF,mp4,MP4,mkv,MKV,avi,AVI'
            ];

            $messages = [
                'file.mimes' => 'No es el formato de imagen que se admite',
                'file.required' => 'Imagen Requerida'
            ];
            $validator = Validator::make($arr, $rules, $messages);

            if ($validator->fails()) {
                return Response([
                    'error' => true,
                    'messages' => $validator->messages()->first(),
                    'code' => 400
                ], 400);
            }
        }

        $mime = File::mimeType($input['file'][0]);
        
        if(strstr($mime, "video/")){
            dd("video");
        }else if(strstr($mime, "image/")){
            //>>>>>>>>>>>>>>>>>>>>>> IMAGE
            DB::beginTransaction();
            //UPLOAD IMAGES
            $increment = 1;
            $success = [];
            $tmpPath = 'images/poi_salud/tmp/'.$tmpName.'/';
            File::makeDirectory($tmpPath);
            foreach ($input['file'] as $key => $file) {
                $lastNumber += $increment;
                //extension de imagen
                $extension = $file->getClientOriginalExtension();
                //nombre de la imagen
                $fileName = $idAtencion . '_' . $lastNumber . '.' . $extension;
                //saving image
                $uploadSuccess = $image->save($file, $tmpPath.$fileName);
                //si falla todo se va ;c
                if(!$uploadSuccess) {
                    $image->deleteImg($success,$tmpPath);
                    return Response([
                        'error' => true,
                        'message' => ['Error del servidor'],
                        'code' => 500
                    ], 500);
                }
                $success[] = $fileName;

                
                $this->image_fix_orientation($file, $tmpPath.$fileName);                       

                //TIENE METADATO DE CAMARA
                if($this->imageDate != ""){
                    $exit = 1;
                }
                //SAVE IN DATABASE
                try{
                    $Atencion_Img = new Atencion_Img();
                    $Atencion_Img->id_poi_salud_atencion_usuario = $idAtencion;
                    $Atencion_Img->url = '/poi_salud/'.$idAtencion;
                    $Atencion_Img->nombre = $fileName;
                    $Atencion_Img->fecha = $this->imageDate == "" ? $fecha : $this->imageDate;
                    $Atencion_Img->estado = 1;
                    $Atencion_Img->exif   = $exif;
                    $Atencion_Img->exifdata   = json_encode($this->exifdata);
                    $Atencion_Img->imgcdata   = $input['cdata'];

                    $Atencion_Img->save();

                } catch(Exception $ex){

                    $image->deleteImg($success,$tmpPath);
                    return Response([
                        'error' => true,
                        'message' => ['Error del servidor'],
                        'code' => 500
                    ], 500);
                }

            }

            //MOVE TO PATH IF ALL SUCCEDED
            $destinationPath = 'images/poi_salud/'. $idAtencion . '/';

            $files = scandir($tmpPath);
            $files = array_diff($files, array('.', '..'));

            $success= [];
            $failed = [];
            foreach ($files as $key => $file) {
                if (copy($tmpPath.$file, $destinationPath.$file)) {
                    $success[] = $file;
                } else {
                    $failed[] = $file;
                }
            }

            if(empty($success)){
                DB::rollback();
                $image->deleteImg($failed,$destinationPath);
            } elseif(empty($failed)) {
                $image->deleteImg($success,$tmpPath);
                //chmod(rtrim($tmpPath,'/'), 0777);
                rmdir(rtrim($tmpPath,'/'));
                DB::commit();
                return Response([
                    'error' => false,
                    'code'  => 200,
                    'filename' => $fileName
                ], 200);
            } else {
                DB::rollback();
                $image->deleteImg($failed,$destinationPath);
                $image->deleteImg($success,$tmpPath);
                //chmod(rtrim($tmpPath,'/'), 0777);
                rmdir(rtrim($tmpPath,'/'));
            }    
        }        

        return Response([
            'error' => true,
            'message' => 'Error del servidor',
            'code' => 500
        ], 500);
    }

    public function getServerImg($id){
        $Atencion_Img = Atencion_Img::select('id','url','created_at','nombre')->where('poi_salud_atencion_usuario_img.id_poi_salud_atencion_usuario',$id)->where('estado',1)->get()->toArray();

        return Response([
                            "atencion_img" => $Atencion_Img
                        ]);
    }

    public function formImgLogicDelete(Request $request){
        $input = $request->all();
        
        $uid = (int)$input['id'];

        $Intervencion_Image = Atencion_img::find($uid);
        
        $Intervencion_Image->estado = 0;
        $Intervencion_Image->save();
    }

}
