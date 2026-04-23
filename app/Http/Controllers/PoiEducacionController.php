<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use DB;
use File;
use sayhuite\Logic\Tools\Tools;
use sayhuite\Logic\Image\ImageRepository;
use Illuminate\Support\Facades\Storage;

use sayhuite\Taller;
use sayhuite\Taller_Usuario;
use sayhuite\Taller_Usuario_Reprogramacion;
use sayhuite\Usuario;
use sayhuite\Taller_Img;
use sayhuite\Dependencia;
use sayhuite\ActividadOperativa;
use sayhuite\CadenaFuncional;

use sayhuite\Logic\Funcion\Educacion;

use Jenssegers\ImageHash\ImageHash;


use Excel;
use PDF;

use Datetime;

class PoiEducacionController extends Controller
{
    protected $imageDate = "";
    protected $controlador = 'poi/educacion';
    protected $num = 10;

    protected $exifdata = "";

    function __construct(){
        $this->objEducacion = new Educacion();
    }

    public function index() {
        return View::make($this->controlador. '.educacion.index');
    }

    public function filter(Request $request, $seccion){
        $input = $request->all();

        switch ($seccion) {
            case 'programacion':
                return $this->objEducacion->programacionFilter($input);
                break;
            case 'seguimiento':
                return Response($this->objEducacion->seguimientoFilter($input));
                break;
            case 'resumen':
                return $this->objEducacion->resumenFilter($input);
                break;
            case 'observados':
                return $this->objEducacion->observadosFilter($input);
                break;
            default:
                # code...
                break;
        }
    }

    public function addTaller(Request $request) {
        $input = $request->all();
        
        return $this->objEducacion->add($input);
    }

    public function showTaller(Request $request){
        $input = $request->all();
        $id = $input['id'];

        return $this->objEducacion->show($id);
    }

    public function editTaller(Request $request){
        $input = $request->all();
        $id = $input['id'];

        return $this->objEducacion->edit($id);
    }

    public function reprogramarTaller(Request $request){
        $input = $request->all();

        return $this->objEducacion->reprogramar($input);
    }

    public function deleteTaller(Request $request){
        $input = $request->all();
        $id = $input['id'];

        $Taller = DB::table('vw_poi_taller_usuario_educacion_detail')
                    ->where('id',$id)->first();

        return view($this->controlador.'.delete')
        ->with('Taller', $Taller)
        ->render();
    }

    public function destroyTaller(Request $request){
        $input = $request->all();
        $id = $input['id'];

        $rules = [
            'txtRazon' => 'required|string|max:250'
        ];

        $attributeNames = [
            'txtRazon' => 'Razón'
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

            $Taller_Reprogramacion = new Taller_Usuario_Reprogramacion();

            $Taller_Reprogramacion->accion = 'Eliminar';
            $Taller_Reprogramacion->observacion = $input['txtRazon'];
            $Taller_Reprogramacion->idtaller = $input['id'];
            $Taller_Reprogramacion->save();

            $Taller = Taller_Usuario::find($id);
            
            $Taller->update([
                'estado' => 0
            ]);

            return Response('Se eliminó la actividad',200);
        }
    }

    public function formImg(Request $request){

        $input = $request->all();
        $id = $input['id'];

        $Taller_Usuario = Taller_Usuario::select(DB::raw('poi_actividad_operativa.nombre'),
                                                 'poi_taller_usuario.id',
                                                 DB::raw('to_char(poi_taller_usuario.fecha, \'DD-MM-YYYY\') as f_fecha'),
                                                 'poi_taller_usuario.fecha',
                                                 'poi_taller_usuario.hora',
                                                 'poi_taller_usuario.observacion',
                                                 'poi_taller_usuario.nro_participantes'
                                                 )
        ->join('poi_actividad_operativa','poi_taller_usuario.id_act_operativa','=','poi_actividad_operativa.id')
        ->join('cadena_funcional_programatica','poi_actividad_operativa.id_cadena','=','cadena_funcional_programatica.id')
        ->where('poi_taller_usuario.id' , $id)->get();


        $Taller_Usuario = $this->objEducacion->defineState($Taller_Usuario);

        $Taller_Usuario = $Taller_Usuario->first();

        $arrOptions = [];

        foreach ($Taller_Usuario['observacionOptions']['educacion'] as $key => $value) {
            $state = $Taller_Usuario->observacion == $value ? 'selected' : '';
            $tmpArr = array( 'value' => $value,'state'=> $state );
            $arrOptions[$key]=$tmpArr;
        }

        return view($this->controlador.'.frmImg')->with([
                                                        'taller'=>$Taller_Usuario,
                                                        'options'=> $arrOptions
                                                        ])->render();
    }

    private function image_fix_orientation( $filename ) {

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

        /*try{
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
        catch(Exception $e){};*/
    }

    public function uploadImg(Request $request,ImageRepository $image){
        /*
        * Vars
        */
        $input = $request->all();

        $idTaller = $input['uid'];
        $fecha = $input['fecha'];
        $fecha = date ("d-m-Y", strtotime($fecha));

        $exif = 0;

        $idUsuario =  Auth::user()->id;

        $Taller = DB::table('vw_poi_taller_usuario_detail')->where('id',$idTaller)->first();

        //VALIDATOR>>>>>>>>>>>>

        $arr = ['file' => Input::file('qqfile') ];
        $rules = [
          'file' => 'required|mimes:png,gif,jpeg,jpg,bmp,PNG,JPG,JPEG,BMP,GIF,mp4,MP4,mkv,MKV,avi,AVI'
        ];

        $messages = [
            'file.mimes' => 'No es el formato de imagen que se admite',
            'file.required' => 'Imagen Requerida'
        ];
        $validator = Validator::make($arr, $rules, $messages);

        if ( $validator->fails() ) {
            return Response([
                'error' => true,
                'messages' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }

        $mime = File::mimeType( Input::file('qqfile') );

        if(strstr($mime, "video/")){
            dd("video");
        }else if(strstr($mime, "image/")){
            //>>>>>>>>>>>>>>>>>>>>>> IMAGE
            DB::beginTransaction();
            //UPLOAD IMAGES
            $lastImage =
            $lastNumber = 1;

            $lastUploaded = Taller_Img::where( 'id_poi_taller_usuario', $idTaller )->orderBy('created_at', 'desc')->first();

            if ( $lastUploaded ){
              $arrFileName = explode( "_" , $lastUploaded->nombre );
              $lastNumber  = (int)(explode( "." , $arrFileName[1] )[0]) + 1;
            }

            //extension de imagen
            $extension = Input::file('qqfile')->clientExtension();

            //nombre de la imagen
            $fileName = $idTaller . '_' . $lastNumber . '.' . $extension;

            $this->image_fix_orientation( Input::file('qqfile') );

            //Guardamos la imagen
            $request->file('qqfile')->storeAs( "/poi/{$idTaller}", $fileName, 'public_uploads');
            //Hash de imagen
            $hasher = new ImageHash;
            $hash  = $hasher->hash( public_path() . "/images/poi/$idTaller/$fileName" );

            //TIENE METADATO DE CAMARA
            if($this->exifdata != 0 or json_encode($this->exifdata) != false or json_encode($this->exifdata) != '' ){
                $exif = 1;
            }
            //SAVE IN DATABASE
            try {
                $Taller_Img = new Taller_Img();
                $Taller_Img->id_poi_taller_usuario = $idTaller;
                $Taller_Img->url                   = '/poi/'.$idTaller;
                $Taller_Img->nombre                = $fileName;
                $Taller_Img->fecha                 = $this->imageDate == "" ? $fecha : $this->imageDate;
                $Taller_Img->estado                = 1;
                $Taller_Img->exif                  = $exif;
                $Taller_Img->exifdata              = json_encode($this->exifdata);
                $Taller_Img->imgcdata              = $input['cdata'];
                $Taller_Img->imghash               = $hash;

            } catch(Exception $ex){
                return Response([
                    'error' => true,
                    'message' => ['Error del servidor'],
                    'code' => 500
                ], 500);
            }

            //DUPLICADA?
            //Buscamos si la imagen esta duplicada y la observamos
            $hasher = new ImageHash;

            $dbImages = Taller_Img::select('id' ,'imghash')->where( 'estado','=', '1' )->where('id_poi_taller_usuario','!=', $idTaller)->get();

            $duplicadas = array();
            foreach ($dbImages as $key => $value) {

                $thisHash = $value['imghash'];

                $distance = $hasher->distance($hash, $thisHash);

                if ( $distance <= 1 ){
                  array_push( $duplicadas, $value['id'] );
                }
            }

            if ( !empty($duplicadas) ){

              $Taller_Img->semejantes = json_encode($duplicadas);
              $Taller_Img->save();
              DB::commit();

              return Response([
                  'success' => true,
                  'code' => 200,
                  'observada' => true
              ], 200);
            }

            $Taller_Img->save();
            DB::commit();

            return Response([
                'success' => true,
                'code' => 200,
                'observada' => false
            ], 200);

        }
    }

    /*
     * MOSTRAR INFORMACION DE IMAGEN
     */
    public function getServerImg($id){
        $Taller_Img = Taller_Img::select('id','url','created_at','nombre')->where('id_poi_taller_usuario',$id)->where('estado',1)->get()->toArray();

        return Response([
                            "taller_img" => $Taller_Img
                        ]);
    }

    public function showMeta(Request $request){
        $input = $request->all();

        $uid = (int)$input['id'];
        $ImgTaller = Taller_Img::find($uid);

        return view($this->controlador.'.img.imgMeta')->with('taller',$ImgTaller)->render();
    }

    /*
     * BORRADO LOGICO DE IMAgEN
     */
    public function formImgLogicDelete(Request $request){
        $input = $request->all();

        $uid = (int)$input['id'];

        $Taller = Taller_Img::find($uid);

        $Taller->update([
            'estado' => 0
        ]);

        $Taller_Imgs = Taller_Img::where('semejantes', 'like', '%'. $uid .'%' )
                      ->get();

        foreach ($Taller_Imgs as $Img) {
            $newArray = array_diff( json_decode($Img->semejantes) , [ $uid ] );

            $Taller_Img = Taller_Img::find($Img->id);
            $Taller_Img->semejantes = json_encode( $newArray );
            $Taller_Img->save();
        }

        return Response('OK',200);
    }

    /*
     * PUBLICAR EN CAPA DE SAYHUITE
     */
    public function publicar(Request $request){

        $input = $request->all();
        $val = '';
        $uid = (int)$input['uid'];

        $Taller_Img = Taller_Img::where('id_poi_taller_usuario',$uid)->get()->toArray();

        if(empty($Taller_Img)){
            return Response(["message" => "No puede publicar información incompleta (faltan fotos)"],403);
        }

        switch($input['st']){
            case 1:
                $val = "1";
                break;
            case 0:
                $val = "0";
                break;
            default:
                return Response(['error' => true],500);
        }

        $Taller = Taller_Usuario::find($uid);

        $Taller->update(['publicada'=>$val]);
    }

    public function getPoiUserByDNI($dni){
        $Usuario = Usuario::select([
            'usuario.idusuario',
            'usuario.nombres',
            'usuario.apellidos',
            'usuario.intervencion',
            DB::raw('(SELECT array_to_string( (array_agg(sigla))[1:2], \',\' ) FROM usuario_dependencia INNER JOIN dependencia ON usuario_dependencia.iddependencia = dependencia.iddependencia where usuario_dependencia.idusuario::int = usuario.idusuario::int) AS ejecutora')
        ])
        ->where('usuario.dni','=',$dni)
        ->where('usuario.poi','=','1')
        ->first();

        $mUsuario = Usuario::find($Usuario['idusuario']);

        $userDependencies = $Usuario->unidad()->pluck('sector')->first();

        $Actividad = CadenaFuncional::select('cod_actividad','act_presupuestal')
        ->where('estado','=','1')
        ->where('cadena_funcional_programatica.funcion', 'ilike', '%'.$userDependencies.'%')
        ->distinct('cod_actividad');

        //MODAL DROPDOWN
        $Actividad = $Actividad->pluck('act_presupuestal','cod_actividad')->toArray();

        return Response([
            'usuario' => $Usuario,
            'actividad' => $Actividad
        ]);
    }

    public function saveObservation(Request $request){

        $input = $request->all();

        $id = $input['id'];
        $obs = $input['obs'];
        //$nro_participantes = $input['nro_participantes'];


        $Taller_Usuario = Taller_Usuario::find($id);

        $Taller_Usuario->observacion       = $Taller_Usuario['observacionOptions']['educacion'][$obs];
        //$Taller_Usuario->nro_participantes = $nro_participantes;

        $Taller_Usuario->save();

        return Response('OK',200);
    }

    public function seguimiento(){
        return View::make($this->controlador. '.seguimiento.index');
    }
    public function programacion(){
        return View::make($this->controlador. '.programacion.index');
    }
    public function resumen( $pp, $tipo ){
        return View::make($this->controlador. '.resumen.'. $pp . '.' . $tipo.'_'.$pp);
    }
    public function resumenFilter( $pp, $tipo, Request $request ){
        $request = $request->all();
        switch ($pp) {            
            case '090':
                switch ($tipo){                    
                    case 'acomp_taller':
                        return Response($this->objEducacion->resumenxAcompFilter_90($request));
                        break;
                    case 'espec_taller':
                        return Response($this->objEducacion->resumenxEspecFilter_90($request));
                        break;
                    case 'dm_taller':
                        return Response($this->objEducacion->resumenxDmFilter_90($request));
                        break;
                    case 'acomp_tallerxdia':
                        return Response($this->objEducacion->resumenxDia_90($request));
                        break;
                    case 'espec_tallerxdia':
                        return Response($this->objEducacion->resumenEspecxDia_90($request));
                        break;
                    case 'dm_tallerxdia':
                        return Response($this->objEducacion->resumenDmxDia_90($request));
                        break;
                    case 'acomp_tallerxugel':
                        return Response($this->objEducacion->resumenxUgel_90($request));
                        break;
                    case 'espec_tallerxugel':
                        return Response($this->objEducacion->resumenEspecxUgel_90($request));
                        break;
                    case 'dm_tallerxugel':
                        return Response($this->objEducacion->resumenDmxUgel_90($request));
                        break;
                    case 'acomp_tallerxugeldia':
                        return Response($this->objEducacion->resumenxUgelDia_90($request));
                        break;
                    case 'espec_tallerxugeldia':
                        return Response($this->objEducacion->resumenEspecxUgelDia_90($request));
                        break;
                    case 'dm_tallerxugeldia':
                        return Response($this->objEducacion->resumenDmxUgelDia_90($request));
                        break;
                }
            case '106':
                switch($tipo){
                    case 'activ_op_personal':
                        return Response($this->objEducacion->activ_op_personal_106($request));
                        break;
                    case 'activ_op_ugel':
                        return Response($this->objEducacion->activ_op_ugel_106($request));
                        break;
                    case 'det_avan_persona':
                        return Response($this->objEducacion->det_avan_persona_106($request));
                        break;
                    case 'taller_x_dia':
                        return Response($this->objEducacion->taller_x_dia_106($request));
                        break;
                    case 'taller_x_ugel':
                        return Response($this->objEducacion->taller_x_ugel_106($request));
                        break;
                }
            case '068':
                switch($tipo){
                    case 'activ_op_personal':
                        return Response($this->objEducacion->activ_op_personal_068($request));
                        break;
                    case 'activ_op_ugel':
                        return Response($this->objEducacion->activ_op_ugel_068($request));
                        break;
                    case 'det_avan_persona':
                        return Response($this->objEducacion->det_avan_persona_068($request));
                        break;
                    case 'taller_x_dia':
                        return Response($this->objEducacion->taller_x_dia_068($request));
                        break;
                    case 'taller_x_ugel':
                        return Response($this->objEducacion->taller_x_ugel_068($request));
                        break;
                }
                break;
            case '051':
                switch($tipo){
                    case 'activ_op_personal':
                        return Response($this->objEducacion->activ_op_personal_051($request));
                        break;
                    case 'activ_op_ugel':
                        return Response($this->objEducacion->activ_op_ugel_051($request));
                        break;
                    case 'det_avan_persona':
                        return Response($this->objEducacion->det_avan_persona_051($request));
                        break;
                    case 'taller_x_dia':
                        return Response($this->objEducacion->taller_x_dia_051($request));
                        break;
                    case 'taller_x_ugel':
                        return Response($this->objEducacion->taller_x_ugel_051($request));
                        break;
                }
                break;
            case 'all':
                switch($tipo){
                    case 'activ_op':
                        return Response($this->objEducacion->resumenxActividadOperativaFilter($request));
                    break;
                }                
                break;            
            default:
                # code...
                break;
        }
    }

    public function exportExcel($pp, $tipo, Request $request){
        $input = $request->all();

        $excelViews = "poi.educacion.resumen.$pp.excel.$tipo"."_$pp";
        $data = "";

        switch ($pp) {
            case '090':
                switch ($tipo){
                    case 'activ_op':
                        $data = $this->objEducacion->resumenxActividadOperativaFilter_90($input)['data'];
                        break;
                    case 'acomp_taller':
                        $data = $this->objEducacion->resumenxAcompFilter_90($input)['data'];
                        break;
                    case 'espec_taller':
                        $data = $this->objEducacion->resumenxEspecFilter_90($input)['data'];
                        break;
                    case 'dm_taller':
                        $data = $this->objEducacion->resumenxDmFilter_90($input)['data'];
                        break;
                    case 'acomp_tallerxdia':
                        $data = $this->objEducacion->resumenxDia_90($input)['data'];
                        break;
                    case 'espec_tallerxdia':
                        $data = $this->objEducacion->resumenEspecxDia_90($input)['data'];
                        break;
                    case 'dm_tallerxdia':
                        $data = $this->objEducacion->resumenDmxDia_90($input)['data'];
                        break;
                    case 'acomp_tallerxugel':
                        $data = $this->objEducacion->resumenxUgel_90($input)['data'];
                        break;
                    case 'espec_tallerxugel':
                        $data = $this->objEducacion->resumenEspecxUgel_90($input)['data'];
                        break;
                    case 'dm_tallerxugel':
                        $data = $this->objEducacion->resumenDmxUgel_90($input)['data'];
                        break;
                    case 'acomp_tallerxugeldia':
                        $data = $this->objEducacion->resumenxUgelDia_90($input)['data'];
                        break;
                    case 'espec_tallerxugeldia':
                        $data = $this->objEducacion->resumenEspecxUgelDia_90($input)['data'];
                        break;
                    case 'dm_tallerxugeldia':
                        $data = $this->objEducacion->resumenDmxUgelDia_90($input)['data'];
                        break;
                }
            case 'all':
                switch ($tipo){
                    case 'seguimiento':
                        $data = $this->objEducacion->seguimientoFilter($input,true)['data'];
                    break;
                }

            default:
                # code...
                break;
        }

        return Excel::create('Sayhuite', function($excel) use ($data,$excelViews) {
            $excel->sheet('Sayhuite', function($sheet) use ($data,$excelViews){
                $sheet->setOrientation('landscape');
                $sheet->loadView($excelViews, array('data' => $data));
            });
        })->download('xlsx');
    }

    public function exportPdf(Request $request){

        $input = $request->all();
        $pdfViews = "poi.educacion.resumen.pdf.";
        switch ($input['type']) {
            case 'tallerxdia':

                $data = $this->objEducacion->resumenxDia_90($input)['data'];
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView($pdfViews."tallerxdia", compact('data'));

                return $pdf->stream( $input['fecha'].'.pdf');

                break;

            default:
                # code...
                break;
        }

    }

    public function observados(){
      return View::make($this->controlador. '.observados.index');
    }

    public function observadosDetail(Request $request){

        $input = $request->all();

        $Imagen = Taller_Img::select([
                        'poi_taller_img.*',
                        'poi_taller_usuario.fecha as fecha_programacion',
                        'poi_taller_usuario.ie',
                        'poi_taller_usuario.codigo_taller',
                        'poi_taller_usuario.docente',
                        'usuario.username',
                        'usuario.email',
                        'usuario.dni',
                        'usuario.apellidos',
                        'usuario.nombres',
                        'usuario.celular',
                        'dependencia.sigla'
                      ])
                      ->join('poi_taller_usuario','poi_taller_usuario.id','=','poi_taller_img.id_poi_taller_usuario')
                      ->join('usuario','usuario.idusuario','=','poi_taller_usuario.id_usuario')
                      ->join('usuario_dependencia','usuario_dependencia.idusuario', '=','usuario.idusuario')
                      ->join('dependencia','dependencia.iddependencia', '=' ,'usuario_dependencia.iddependencia')
                      ->where('poi_taller_img.id', $input['id'])
                      ->first();


      return view($this->controlador. '.observados.detail')->with([
            'Imagen' => $Imagen
        ])->render();
    }

    public function getImgCoincidencias($id)
    {
        $Imagen = Taller_Img::find($id);


        $Semejantes = Taller_Img::select([
                        'poi_taller_img.*',
                        'poi_taller_usuario.fecha as fecha_programacion',
                        'poi_taller_usuario.ie',
                        'poi_taller_usuario.codigo_taller',
                        'poi_taller_usuario.docente',
                        'usuario.username',
                        'usuario.email',
                        'usuario.celular',
                        'usuario.dni',
                        'usuario.apellidos',
                        'usuario.nombres',
                        'dependencia.sigla'
                      ])
                      ->join('poi_taller_usuario','poi_taller_usuario.id','=','poi_taller_img.id_poi_taller_usuario')
                      ->join('usuario','usuario.idusuario','=','poi_taller_usuario.id_usuario')
                      ->join('usuario_dependencia','usuario_dependencia.idusuario', 'usuario.idusuario')
                      ->join('dependencia','dependencia.iddependencia', 'usuario_dependencia.iddependencia')
                      ->where( 'poi_taller_img.estado', '1' )
                      ->whereIn( 'poi_taller_img.id', json_decode( $Imagen->semejantes ) )
                      ->get();

        return Response(
            [
                'semejantes' => $Semejantes
            ], 200);
    }

    public function borrarRelacion(Request $request){
        $input = $request->all();

        $Taller_Img = Taller_Img::find($input['id']);
        $Taller_Img->semejantes = json_encode(array());
        $Taller_Img->save();

        return Response('OK',200);

    }

    public function quitarImagen(Request $request){
        $input = $request->all();

        $Taller_Img = Taller_Img::where('semejantes', 'like', '%'.$input['id'].'%' )
                      ->get();

        foreach ($Taller_Img as $Img) {
            $newArray = array_diff( json_decode($Img->semejantes) , [ $input['id'] ] );

            $Taller_Img = Taller_Img::find($Img->id);
            $Taller_Img->semejantes = json_encode( $newArray );
            $Taller_Img->save();
        }

        return Response('OK',200);

    }

    public function reporte(Request $request){
        $input = $request->all();

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $Taller = DB::table('vw_poi_taller_usuario_educacion')
                    ->where('estado','1');
        
        mb_internal_encoding("UTF-8");

        //TALLERES QUE LE CORRESPONDEN
        if (!$isAdmin) {
            $Taller = $Taller->where('id_usuario', '=' , Auth::id());
        }

        $recordsTotal = $Taller->count();

        if( ( isset($input['txtRptFechaIni']) and !empty($input['txtRptFechaIni']) ) and ( !isset($input['txtRptFechaFin']) or empty($input['txtRptFechaFin']) ) ){
            $Taller = $Taller->where( 'fecha', '=' , $input['txtRptFechaIni'] );
        }

        if( ( isset($input['txtRptFechaIni']) and !empty($input['txtRptFechaIni']) ) and ( isset($input['txtRptFechaFin']) and !empty($input['txtRptFechaFin']) ) ){
            $Taller = $Taller->where("fecha",">=",$input['txtRptFechaIni'])->where("fecha","<=",$input['txtRptFechaFin']);
        }

        $TallerInProcess = $Taller;

        $Taller = $Taller->get();
        
        $TipoActividad = $TallerInProcess->select('tipo_activ_operativa')->distinct('tipo_activ_operativa')->get();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Adding an empty Section to the document...
        $section = $phpWord->addSection(
            array(
                'marginLeft'   => 1200,
                'marginRight'  => 500,
                'marginTop'    => 400,
                'marginBottom' => 400,
                'headerHeight' => 400,
                'footerHeight' => 400,
            )
        );
        
        // PAGE CONFIG
            //HEADER
        // Add header for first page
        $header = $section->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        
        $table->addCell(4500)->addImage( public_path('images/sys/sayhuite.png') , array('width' => 120, 'height' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        $table->addCell(4500)->addImage( public_path('images/sys/logo1.gif') , array('width' => 130, 'height' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        $table->addCell(4500)->addImage( public_path('images/sys/slogan2.gif') , array('width' => 140, 'height' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
        $table->addRow();
        $table->addCell(4500,[ 'gridspan' => 3 ] )->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END ])->addText( $Taller[0]->ejecutora .' - ' . mb_strtoupper( $Taller[0]->nombre_usuario ) );
        // Add header for all other pages
        $subsequentHeader = $section->addHeader();
        $table = $subsequentHeader->addTable();
        $table->addRow();
        $table->addCell(4500)->addImage( public_path('images/sys/sayhuite.png') , array('width' => 120, 'height' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        $table->addCell(4500)->addImage( public_path('images/sys/logo1.gif') , array('width' => 130, 'height' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        $table->addCell(4500)->addImage( public_path('images/sys/slogan2.gif') , array('width' => 140, 'height' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
        $table->addRow();
        $table->addCell(4500,[ 'gridspan' => 3 ] )->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END ])->addText( $Taller[0]->ejecutora .' - ' . mb_strtoupper( $Taller[0]->nombre_usuario ) );
            //FOOTER
        // Add footer for first page
        $footer = $section->addFooter();
        $footer->firstPage();
        $table = $footer->addTable();
        $table->addRow();
        $table->addCell(4500)->addText('Programa Presupuestal '. $Taller[0]->cod_cat_presupuestal, null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        if( !empty( $input["txtRptFechaFin"] ) ){
            $table->addCell(4500)->addText('Actividades del '. $input["txtRptFechaIni"] . "al " . $input["txtRptFechaFin"]  , null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        } else {
            $table->addCell(4500)->addText('Actividades del '. $input["txtRptFechaIni"] , null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        }
        $table->addCell(4500)->addPreserveText('Página {PAGE} de {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
        // Add footer for all other pages
        $subsequentFooter = $section->addFooter();
        $table = $subsequentFooter->addTable();
        $table->addRow();
        $table->addCell(4500)->addText('Programa Presupuestal '. $Taller[0]->cod_cat_presupuestal, null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));
        if( !empty( $input["txtRptFechaFin"] ) ){
            $table->addCell(4500)->addText('Actividades del '. $input["txtRptFechaIni"] . "al " . $input["txtRptFechaFin"]  , null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        } else {
            $table->addCell(4500)->addText('Actividades del '. $input["txtRptFechaIni"] , null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        }
        $table->addCell(4500)->addPreserveText('Página {PAGE} de {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));

        
        // PAGE CONFIG #end

        // TABLE STYLE
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = [
            'borderSize' => 10,
            'borderColor' => '00000',
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
        ];
        $fancyTableFirstRowStyle = [
            //'borderBottomSize' => 2,
            //'borderBottomColor' => '0000FF',
            //'bgColor' => '66BBFF'
        ];
        $fancyTableCellStyle = [
            'valign' => 'center'
        ];

        $fancyTableCellBtlrStyle = [
            'valign' => 'center',
            'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR
        ];
        $fancyTableFontStyle = [
            'bold' => true
        ];

        $phpWord->addTableStyle(
            $fancyTableStyleName,
            $fancyTableStyle,
            $fancyTableFirstRowStyle
        );
        // TABLE STYLE #end

        // HEAD TABLE
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow();
        $table->addCell(5000, [
            'valign' => 'center',
            'gridSpan' => 5,
            'bgColor' => '3C8DBC'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( 'Resumen', [
            'bold'=> true,
            'color' => 'FFFFFF'
        ]);
        
        $table->addRow();

        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => '3C8DBC'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( 'Actividad', [
            'bold'=> true,
            'color' => 'FFFFFF'
        ]);

        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => '3C8DBC'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( 'Completo', [
            'bold'=> true,
            'color' => 'FFFFFF'
        ]);

        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => '3C8DBC'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( 'Incompleto', [
            'bold'=> true,
            'color' => 'FFFFFF'
        ]);

        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => '3C8DBC'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( 'Planificadas', [
            'bold'=> true,
            'color' => 'FFFFFF'
        ]);

        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => '3C8DBC'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( 'Total', [
            'bold'=> true,
            'color' => 'FFFFFF'
        ]);

        $tCompletos    = 0;
        $tIncompletos  = 0;
        $tPlanificados = 0;
        $tTotal = 0;

        foreach($TipoActividad as $Tipo){
            
            $table->addRow();
            
            $table->addCell(2000, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( $Tipo->tipo_activ_operativa , [
                'bold'=> true
            ]);

            $completos = 0;
            $incompletos = 0;
            $planificados = 0;

            foreach ( $Taller as $t ) {
                if ( $t->tipo_activ_operativa == $Tipo->tipo_activ_operativa ){
                    switch ( $t->state ) {
                        case 'complete':
                                $completos+=1;
                            break;
                        case 'passed':
                                $incompletos+=1;
                            break;
                        case 'programmed':
                                $planificados+=1;
                            break;
                    }
                }
            }

            $total = $completos + $incompletos + $planificados;

            $tCompletos += $completos;
            $tIncompletos += $incompletos;
            $tPlanificados += $planificados;
            $tTotal += $total;

            $table->addCell(2000, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( $completos , [
                'bold'=> true
            ]);

            $table->addCell(2000, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( $incompletos , [
                'bold'=> true
            ]);

            $table->addCell(2000, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( $planificados , [
                'bold'=> true
            ]);

            $table->addCell(2000, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( $total , [
                'bold'=> true
            ]);
            
        }

        $table->addRow();
            
        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => 'D2D6DE'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( 'Total General' , [
            'bold'=> true
        ]);

        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => 'D2D6DE'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( $tCompletos , [
            'bold'=> true
        ]);
        
        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => 'D2D6DE'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( $tIncompletos , [
            'bold'=> true
        ]);
        
        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => 'D2D6DE'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( $tPlanificados , [
            'bold'=> true
        ]);

        $table->addCell(2000, [
            'valign' => 'center',
            'bgColor' => 'D2D6DE'
        ])
        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
        ->addText( $tTotal , [
            'bold'=> true
        ]);

        $section->addTextBreak();

        // HEAD TABLE #end

        // PAGE BODY
        foreach($Taller as $t){
            $images = Taller_Img::where('id_poi_taller_usuario','=',$t->id)
                    ->where('estado','=','1')
                    ->get();

            // MAIN TABLE
            $table = $section->addTable($fancyTableStyleName);
            $table->addRow( null, [ 'cantSplit'=> true ] );
            $table->addCell(2200, [
                'valign' => 'center',
                'bgColor' => '3C8DBC'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( 'Actividad:', [
                'bold'=> true,
                'color' => 'FFFFFF'
            ]);

            $table->addCell(2800, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( $t->tipo_activ_operativa );

            $table->addCell(2200, [
                'bgColor' => '3C8DBC',
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( 'Participante(s)', [
                'bold'=> true,
                'color' => 'FFFFFF'
            ]);
            
            $table->addCell(2800, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( mb_strtoupper( $t->docente ) );
            
            $table->addRow( null, [ 'cantSplit'=> true ] );

            $table->addCell(2200, [
                'valign' => 'center',
                'bgColor' => '3C8DBC'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( 'Lugar:', [
                'bold'=> true,
                'color' => 'FFFFFF'
            ]);

            $table->addCell(2800, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( mb_strtoupper( $t->ie ) );

            $table->addCell(2200, [
                'bgColor' => '3C8DBC',
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( 'Fecha:', [
                'bold'=> true,
                'color' => 'FFFFFF'
            ]);

            $table->addCell(2800, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText($t->fecha);
            
            $table->addRow( null, [ 'cantSplit'=> true ] );

            $table->addCell(2200, [
                'valign' => 'center',
                'bgColor' => '3C8DBC'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( 'Distrito:', [
                'bold'=> true,
                'color' => 'FFFFFF'
            ]);

            $table->addCell(2800, [
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( mb_strtoupper( $t->nom_dist ) );

            $table->addCell(2200, [
                'bgColor' => '3C8DBC',
                'valign' => 'center'
            ])
            ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
            ->addText( 'Estado:', [
                'bold'=> true,
                'color' => 'FFFFFF'
            ]);

            switch ($t->state) {
                case 'complete':
                        $table->addCell(2800, [
                            'bgColor' => '00A65A'
                        ])
                        ->addTextRun( ['valign' => 'center','alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
                        ->addText( 'COMPLETO', [
                            'bold'=>true,
                            'color' => 'FFFFFF'
                        ] );
                    break;
                case 'passed':
                        $table->addCell(2800, [
                            'bgColor' => 'DD4B39'
                        ])
                        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
                        ->addText( 'INCOMPLETO', [
                            'bold' => true,
                            'color' => 'FFFFFF'
                        ]);
                    break;
                case 'programmed':
                        $table->addCell(2800, [
                            'bgColor' => 'F39C12'
                        ])
                        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
                        ->addText( 'PLANIFICADO', [
                            'bold' => true,
                            'color' => 'FFFFFF'
                        ]);
                    break;
                case 'noprogrammed':
                        $table->addCell(2800, [
                            'bgColor' => 'DD4B39'
                        ])
                        ->addTextRun( ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER] )
                        ->addText( 'NO PROGRAMADO', [
                            'bold' => true,
                            'color' => 'FFFFFF'
                        ]);
                    break;
                default:
                        //
                    break;
            }

            // MAIN TABLE #end
            if ( count($images) > 0 ) {
                //$table = $section->addTable($fancyTableStyleName);
                $table->addRow( null, [ 'cantSplit'=> true ] );
                
                $eachTwo = 2;
                foreach ( $images as $image ) {
                    $eachTwo--;
                    if ( $eachTwo == -1 ) {
                        $eachTwo = 2;
                        $table->addRow();
                    }
                    $table->addCell(4500,['gridSpan' => 2])->addImage( public_path('images'.$image->url.'/'.$image->nombre) , array('width' => 200, 'height' => 200, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
                }
            }

            $section->addTextBreak();
        }

        try {
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        } catch(Exception $e) {}
        
        $idUsuario = Auth::id();
        $docx_name = $idUsuario . '_' . uniqid()  . ".docx";

        try {
            $objWriter->save( public_path() . "/tmp/" . $docx_name );
        } catch (Exception $e) {}
        
        return response()->download( public_path() . "/tmp/" . $docx_name );
    }

    
}

