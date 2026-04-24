<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use sayhuite\ObrasEstado;
use sayhuite\SubEtapa;
use sayhuite\ObraEstadoImg;
use DateTime;
use Illuminate\Support\Facades\Auth;
use sayhuite\Logic\Tools\Tools;
use File;
use sayhuite\Logic\Image\ImageRepository;
use Validator;
use sayhuite\PipTotalPriori;
use sayhuite\Obras;

class ObrasEstadoController extends Controller
{
	protected $controller = "obra.estado";
    protected $imageDate = "";    

    public function index(){
    	return View("obra.index");
    }

    public function filterData(Request $request){

        $input = $request->all();

        $canChangeEjecucion = ( Auth::user()->hasRole('admin') or Auth::user()->hasRole('resp_proyectos') );

        if (!$canChangeEjecucion){
            $Obras = DB::table('vw_grli_obra_list_estado')->where('idobra',$input['id'])->where('estado',1)->whereIn('etapa',['EN EJECUCIÓN','CULMINADO'])->orderBy('fecha_act','desc')->get();
        } else {
            $Obras = DB::table('vw_grli_obra_list_estado')->where('idobra',$input['id'])->where('estado',1)->orderBy('fecha_act','desc')->get();
        }
    	

        return Response([
            'data' => $Obras,
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        ]);
    }

    //Guardar Nuevo estado de Obra
    public function create(Request $request){
    	$input = $request->all();


        $canChangeEtapa = Auth::user()->hasRole('admin') or Auth::user()->hasRole('resp_proyectos');
        $isSupervisor   = Auth::user()->hasRole('supervisor');
    
        //Formateamos la Fecha
    	$fecha = DateTime::createFromFormat('Y-m-d', $input["fecha"])->format('Y-m-d');
    	
        //Buscamos si la obra tiene estados registrados con esa misma fecha
    	$ObraEstado = ObrasEstado::where("grli_obra_estado.fecha_act", $fecha)
                ->where("grli_obra_estado.idobra",$input["idobra"])
                ->first();

        //Si la obra no tiene estados registrados en esa fecha
    	if( count($ObraEstado) == 0 ) {
    		$ObraEstado = new ObrasEstado();
            // La obra siempre tendrá el estado de "EN EJECUCIÓN" O "CULMINADO"
            // Si es un supervisor
            if ( $canChangeEtapa ){
                $ObraEstado->etapa = "EN EJECUCIÓN";
            }
            
	    	$ObraEstado->fecha_act = $input['fecha'];
	    	$ObraEstado->idobra = $input['idobra'];

	    	$ObraEstado->save();
    	}
        //De lo contrario se envia el estado que se encontró

    	return Response([
            'success' => true,
            'estado' => $ObraEstado->id
        ],200);
    }

    //Agregar estado de obra
    public function add(Request $request){
        $input = $request->all();
        $canChangeEtapa = Auth::user()->hasRole('admin') or Auth::user()->hasRole('resp_proyectos');
        $isSupervisor   = Auth::user()->hasRole('supervisor');

        $id = $input['idEstado'];

        $ObraEstado = ObrasEstado::find($id);

        if ( $canChangeEtapa ){
            $ObraEstado->etapa = $input['cboEtapa'];
        } else {
            $ObraEstado->etapa = "EN EJECUCIÓN";
        }

        $ObraEstado->sub_etapa = $input['cboSubEtapa'];
        $ObraEstado->est_situ = $input['txtdescripcion'];
        $ObraEstado->obs = $input['txtobservacion'];
        $ObraEstado->a_fisico = $input['txtafisico'];

        $ObraEstado->save();

        $Obra = Obras::find($ObraEstado->idobra);

        PipTotalPriori::updateMasterTB($Obra->idproyecto);

        return Response("Se guardó la valorización",200);

    }

    //Vista de formulario para editar estado de obra
    public function edit(Request $request){
    	$input = $request->all();

        $canChangeEjecucion = Auth::user()->hasRole('admin') or Auth::user()->hasRole('resp_proyectos');

    	$ObraEstado = ObrasEstado::select("grli_obra_estado.*","grli_pip_total_priori.nom_proyec")
        ->join("grli_obra","grli_obra.id","=","grli_obra_estado.idobra")
    	->join("grli_pip_total_priori","grli_pip_total_priori.id","=","grli_obra.idproyecto")
    	->where("grli_obra_estado.id","=", $input['id'])
    	->first();

        //dd($ObraEstado);

        /*if ($canChangeEjecucion) {
            
        } else {
            $tmpEtapa = SubEtapa::orderBy('id','asc')->whereIn('etapa',['EN EJECUCIÓN','CULMINADO'])->pluck('etapa', 'etapa')->toArray();
        }*/

        $tmpEtapa = SubEtapa::orderBy('id','asc')->whereNotIn('etapa',['PERFIL','CIERRE'])->pluck('etapa', 'etapa')->toArray();

        
        $tmpEtapa = [0 => "-- Seleccionar --"] + $tmpEtapa;        

        $Etapa = [];

            foreach ($tmpEtapa as $key => $value) {
                if ($value != $ObraEstado->etapa){
                    $Etapa += [$key => [ "nombre" => $value, "state" => ""]];
                } else {
                    $Etapa += [$key => [ "nombre" => $value, "state" => "selected"]];
                }
            }

            $Sub_Etapa = [];
            if($ObraEstado->etapa){
                $tmpSub_Etapa  = $this->combosubetapa($ObraEstado->etapa);

                 foreach ($tmpSub_Etapa as $key => $value) {
                    if ($value != $ObraEstado->sub_etapa){
                        $Sub_Etapa += [$key => [ "nombre" => $value, "state" => ""]];
                    } else {
                        $Sub_Etapa += [$key => [ "nombre" => $value, "state" => "selected"]];
                    }
                }
            }

        return view($this->controller.'.edit')->with('ObraEstado', $ObraEstado)->with('Etapa', $Etapa)->with('SubEtapa', $Sub_Etapa)->with('canChangeEjecucion', $canChangeEjecucion)->render();
    }

    public function combosubetapa($id) {
        $Sub_Etapa = SubEtapa::select('sub_etapa')
                    ->where('etapa', '=', $id)->orderBy('id','asc')->pluck('sub_etapa', 'sub_etapa')->toArray();
        
        $Sub_Etapa = [ 0 => '-- Seleccionar --'] + $Sub_Etapa;

        return $Sub_Etapa;
    }

    public function listEstados(Request $request){
    	$input = $request->all();

    	return view($this->controller.'.listestado')->render();
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

    public function imgUpload(Request $request, ImageRepository $image){
         /*
        * Vars
        */
        $input = $request->all();

        $idValorizacion = $input['uid'];
        $fecha = $input['fecha'];
        $fecha = date ("d-m-Y", strtotime($fecha));
        $exif = 0;

        $idUsuario =  Auth::user()->id;
        
        //$Taller = DB::table('vw_poi_taller_usuario_detail')->where('id',$idTaller)->first();       

        $input = $request->all();

        //TMP NAME OF IMAGES
        $tmpName = Tools::generateTmpName();
        $fileName = '';
        $lastNumber = 0;
        
        //CREATE DIRECTORY
        if(File::exists('images/valorizacion/'.$idValorizacion)){
            $files = scandir('images/valorizacion/' . $idValorizacion, 1);
            $files = array_diff($files, array('.', '..'));
            natsort($files);

            if(!empty($files)) {
                $t = explode('_', end($files));
                $lastNumber = $t[1];
            }
        } else {
            File::makeDirectory('images/valorizacion/' . $idValorizacion);
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
            return Response([
                'error' => true,
                'message' => ['No se admite carga de video en este módulo'],
                'code' => 422
            ], 422);
        }else if(strstr($mime, "image/")){
            //>>>>>>>>>>>>>>>>>>>>>> IMAGE
            DB::beginTransaction();
            //UPLOAD IMAGES
            $increment = 1;
            $success = [];
            $tmpPath = 'images/valorizacion/tmp/'.$tmpName.'/';
            File::makeDirectory($tmpPath);
            foreach ($input['file'] as $key => $file) {
                $lastNumber += $increment;
                //extension de imagen
                $extension = $file->getClientOriginalExtension();
                //nombre de la imagen
                $fileName = $idValorizacion . '_' . $lastNumber . '.' . $extension;
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
                    $Taller_Img = new ObraEstadoImg();
                    $Taller_Img->id_grli_obra_estado = $idValorizacion;
                    $Taller_Img->url = '/valorizacion/'.$idValorizacion;
                    $Taller_Img->nombre = $fileName;
                    //$Taller_Img->fecha = $this->imageDate == "" ? $fecha : $this->imageDate;
                    $Taller_Img->estado = 1;
                    //$Taller_Img->exif   = $exif;
                    $Taller_Img->metadata   = json_encode($this->exifdata);
                    //$Taller_Img->imgcdata   = $input['cdata'];

                    $Taller_Img->save();

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
            $destinationPath = 'images/valorizacion/'. $idValorizacion . '/';

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

    /*public function imgGet($id){
        $ObraEstadoImg = ObraEstadoImg::select('id','url','created_at','nombre')->where('id_grli_obra_estado',$id)->where('estado',1)->get()->toArray();

        return Response([
                            "taller_img" => $ObraEstadoImg
                        ]);
    }*/

    /*public function imgDelete(Request $request){
        $input = $request->all();
        
        $uid = (int)$input['id'];

        $Taller = ObraEstadoImg::find($uid);
        
        $Taller->update(['estado'=>0]);
    }*/

    public function delete(Request $request){
        $input = $request->all();
        
        $uid = (int)$input['id'];

        $ObraEstado = ObrasEstado::find($uid);        
        $ObraEstado->update(['estado'=>0]);

        $Obra = Obras::find($ObraEstado->idobra);

        PipTotalPriori::updateMasterTB($Obra->idproyecto);        
    }


}
