<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use sayhuite\PipTotalPriori;
use sayhuite\Departamento;
use sayhuite\Dependencia;
use sayhuite\Procompite;
use sayhuite\Provincia;
use sayhuite\Distrito;
use sayhuite\SubEtapa;
use sayhuite\EstAntig;
use sayhuite\MantenimientoVia;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use File;
use DB;

use Validator;

use sayhuite\Logic\Image\ImageRepository;
use sayhuite\Logic\Tools\Tools;

class ProcompiteController extends Controller
{

    protected $controlador = 'procompite';
    protected $searchAlias = [
        'eq' => '=',
        'cn' => 'like',
        'nc' => '<>'
    ];
    protected $orderBy = [];

    public function index() {
        return View::make($this->controlador . '.index');
    }

    public function filterData(Request $request){
        $input = $request->all();
        $page = $input['page']; // get the requested page
        $limit = $input['rows']; // get how many rows we want to have into the grid
        $sidx = $input['sidx']; // get index row - i.e. user click to sort
        $sord = $input['sord']; // get the direction
        $start = $limit*$page - $limit;

        $Procompite = Procompite::select([
            'id',
            'nom_proyec',
            'aeo',
            'cod_unif',
            'nom_prov',
            'u_formul',
            'u_ejec',
            'sector',
            //-- FINANCIERA
            DB::raw('m_pip + contrapartida as monto'),            
            'm_pip',//.
            'est_proyec',//CHANGE est_pry
            DB::raw('(select MAX(anio) from inf_financiera where cod_unif::text = grli_pip_procompite.cod_unif LIMIT 1) as ult_anio'),
            DB::raw('(select girado from grli_pip_total_girado where cod_unif::text = grli_pip_procompite.cod_unif order by anio desc LIMIT 1) as girado'),
            'm_pim',//.
            'm_cert',//
            'm_pimacu',//m_pim_acu
            'm_deveng',//.
            'm_devenacu',//m_deveng_a
            'f_adjudica',
            'f_act',
            'modalidad',
            'f_inicio_obra',
            'f_fin_obra',
            't_ejec_dia',
            'a_fisico',
            'a_financ',
            'estado',
            'situa_pro',
            'fecha_situa',
            'anio',
            'nro_conv',
            'contrapartida',
            'beneficiarios'
        ]);
        $Procompite = $Procompite->orderBy($sidx,$sord )->groupBy(
            'id',
            'nom_proyec',
            'aeo',
            'cod_unif',
            'nom_prov',
            'u_formul',
            'u_ejec',
            'sector',
            //-- FINANCIERA
            'm_pip',//.
            'est_proyec',//CHANGE est_pry
            'm_pim',//.
            'm_cert',//
            'm_pimacu',//m_pim_acu
            'm_deveng',//.
            'm_devenacu',//m_deveng_a
            'f_adjudica',
            'f_act',
            'modalidad',
            'f_inicio_obra',
            'f_fin_obra',
            't_ejec_dia',
            'a_fisico',
            'a_financ',
            'estado',
            'situa_pro',
            'fecha_situa',
            'anio',
            'nro_conv',
            'contrapartida',
            'beneficiarios'
        );

        $legend = $this->countEtapa($Procompite->get());

        //FILTER
        if(isset($input['filters']) and !empty($input['filters'])){
            $input['filters'] = json_decode($input['filters'],true);
            switch($input['filters']['groupOp']){
                case 'AND':

                    foreach($input['filters']['rules'] as $rule){
                        $field = $rule['field'];
                        $operation = $rule['op'];
                        $param = strtoupper($rule['data']);

                        switch($operation){
                            case 'eq':
                                $Procompite = $Procompite->where($field,'=',$param);
                                break;
                            case 'cn':
                                $Procompite = $Procompite->where($field,'like','%'.$param.'%');
                                break;
                            case 'nc':
                                $Procompite = $Procompite->where($field,'not like','%'.$param.'%');
                                break;
                        }

                    }

                    break;
            }
        }
        $count = $Procompite->get()->count();

        $totalpages = ceil($count / $limit);
        $Procompite  = $Procompite->skip($start)->take($limit)->get();

        return Response([
            'rows' => $Procompite->toArray(),
            'page' => $page,
            'total' => $totalpages,
            'records' => $count,
            'legend' => $legend
        ]);

        //filters:{"groupOp":"AND","rules":[{"field":"av_finan","op":"bw","data":"sasdaas"},{"field":"mod_ejec","op":"bw","data":"ddfsdsf"}]}

    }

    public function countEtapa($data){
        $arrNameTipo = ['tdr' => 'TDR',
            'perfil' => 'PERFIL',
            'exptec' => 'EXPEDIENTE TÉCNICO',
            'ejec' => 'EN EJECUCIÓN',
            'liquid' => 'EN LIQUIDACIÓN',
            'transf' => 'EN TRANSFERENCIA',
            'culminado' => 'CULMINADO',
            'cierre' => 'CIERRE'];
        $totalEtapa = 0;
        $resultSet = [];
        foreach($arrNameTipo as $val=>$name){
            $resultSet[$val] = count($data->where('etapa','like',$name)->toArray());
            //dd($val);
            $totalEtapa += count($data->where('etapa','like',$name)->toArray());
        }
        $resultSet['total'] = $totalEtapa;
        $resultSet['totaln'] = $data->count();

        return $resultSet;
    }

    /*//combo
    public function combodistrito($id) {
        $data = Distrito::select('cod_dist', 'nom_dist')
            ->where('cod_prov', '=', $id)->get();

        $combo = '<option value="0"> -- Seleccionar -- </option>';
        foreach ($data as $value) {
            $combo = $combo . ' <option value="' . $value['cod_dist'] . '">' . $value['nom_dist'] . '</option>';
        }
        return $combo;
    }*/

    public function combosubetapa($id) {
        $data = SubEtapa::select('sub_etapa')
            ->where('etapa', '=', $id)->get();

        $combo = '<option value="0"> -- Seleccionar -- </option>';
        foreach ($data as $value) {
            $combo = $combo . ' <option value="' . $value['sub_etapa'] . '">' . $value['sub_etapa'] . '</option>';
        }
        //dd($combo);
        return $combo;
    }


    //Ventana crear
    public function create() {
        $depCombo = Departamento::all()->pluck('nom_dpto', 'cod_dpto');

        $prov = Provincia::all()->pluck('nom_prov', 'cod_prov')->toArray();
        $provCombo = [0 => "-- Seleccionar --"] + $prov;

        $disCombo = [0 => "-- Seleccionar --"];

        $eta = SubEtapa::all()->pluck('etapa', 'etapa')->toArray();
        $etaCombo = [0 => "-- Seleccionar --"] + $eta;

        $subCombo = [0 => "-- Seleccionar --"];

        return View::make($this->controlador . '.create', compact('depCombo', 'provCombo', 'disCombo', 'etaCombo', 'subCombo'));
    }

    //insertar datos
    public function store() {

        if(Auth::user()->hasRole('consulta')){
            return back();
        }

        $validator = Validator::make($data = Input::except('_token', 'uid', 'file', 'tipo', 'fecha', 'csrf-token'), PipTotalPriori::$rules);

        if ($validator->fails()) {
            $mensaje_error = "";
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . ". <br>";
            }
            return back()->with('mensaje_error', $mensaje_error)->withInput();
        } else {
            $piptotalpriori = new PipTotalPriori;
            $piptotalpriori->insert($data);
            return redirect($this->controlador . '/create')->with('mensaje_exito', 'Los datos se guardaron correctamente');
        }
    }

    /*//ventana mostar
    public function show(Request $request) {

        $id = $request->get('id');

        $PipTP = PipTotalPriori::find($id);

        $infFinanciera = InfFinanciera::where('idpip',$id)->get();

        return view('piptotalpriori.show')->with(
            [
                'data'=>$PipTP,
                'infFinanciera'=>$infFinanciera,
                'menssage'=>'',
                'error'=>'false',
            ]

        )->render();
    }*/

    //ventana editar
    public function edit($id) {
        $data = MantenimientoVia::find($id);

        $depCombo = Departamento::all()->pluck('nom_dpto', 'cod_dpto');

        $prov = Provincia::where('cod_dpto','15')->pluck('nom_prov', 'cod_prov')->toArray();
        $provCombo = [0 => "-- Seleccionar --"] + $prov;

        $dist = Distrito::all()->pluck('nom_dist', 'cod_dist')->toArray();
        $disCombo = [0 => "-- Seleccionar --"] + $dist;

        $eta = SubEtapa::all()->pluck('etapa', 'etapa')->toArray();
        $etaCombo = [0 => "-- Seleccionar --"] + $eta;

        $sub = SubEtapa::all()->pluck('sub_etapa', 'sub_etapa')->toArray();
        $subCombo = [0 => "-- Seleccionar --"] + $sub;

        $estAntig = EstAntig::all()->pluck('estado', 'estado')->toArray();
        $estAntigCombo = [0 => "-- Seleccionar --"] + $estAntig;

        return View::make($this->controlador . '.edit', compact('data', 'depCombo', 'provCombo', 'disCombo', 'etaCombo', 'subCombo','estAntigCombo','InfFinanciera'));
    }

    //actualizar datos
    public function update(Request $request) {

        if(Auth::user()->hasRole('consulta')){
            return back();
        }

        $input  = $request->all();


        $cleanInput = Input::except('_token', 'uid', 'file', 'tipo', 'fecha', 'csrf-token');
        $validator = Validator::make($data = $cleanInput, Procompite::$rules);


        foreach($input as $key => $i){
            empty($i) ? $input[$key] = null : $input[$key] = $i;
        }

        //dd($input);

        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . ". <br>";
            }
            return Response(['error' => $mensaje_error],500);
        } else {
            $Procompite = Procompite::find($input['id']);
            $Procompite->fill($input);
            $Procompite->save();

            //return Response(['alert' => 'Save'],200);
            return Response::json([
            'error' => true,
            'message' => 'Se actualizaron los datos con exito',
            'data' => null
            ], 200);


        }
    }

    public function getSearchOpt(){
        $param = Input::get('param');
        $allowed = ['ger_direc', 'tipo_pry' , 'anio_ini_pry', 'etapa'];
        if(in_array($param,$allowed)){
            $Snipp = PipTotalPriori::select($param)->distinct()->orderBy($param,'desc')->get()->toArray();
            return Response([
                'error' => false,
                'message' => '',
                'data' => $Snipp
            ],200);
        }else {
            return Response([
                'error' => true,
                'message' => ':v',
                'data' => ''
            ],403);
        }


    }


    public function stateSayhuite(Request $request){
        if(Auth::user()->hasRole('consulta')){
            return back();
        }
        $input = $request->all();
        $val = '';
        $uid = $input['uid'];
        switch($input['st']){
            case 1:
                $val = 'COMPLETO';
                break;
            case 0:
                $val = 'INCOMPLETO';
                break;
            default:
                return Response(['error' => true],500);
        }

        $PipTP = Procompite::find($uid);

        $PipTP->update(['estado'=>$val]);
    }

    public function getPageImageUpload(Request $request)
    {

        $input = $request->all();

        $Pro = Procompite::where('id',$input['id'])->first();
        return view($this->controlador.'.image-upload')->with('id',$Pro->id)->render();
    }

    public function imgUpload(ImageRepository $image)
    {
        $categoria = 'procompite';

        $input = Input::all();
        $Procompite = Procompite::where('id',$input['uid'])->first();
        $uid = $input['uid'];

        //dd($uid);
        //REFORMAT DATE
        $fecha = date('d-m-y',strtotime($input['fecha']));
        //LINK OF IMAGES
        $tmpName = Tools::generateTmpName();
        $fileName = '';

        $lastNumber = 0;
        //CREATE DIRECTORY
        if(File::exists('images/procompite/'.$uid)){
            $files = scandir('images/procompite/' . $uid . '/', 1);
            $files = array_diff($files, array('.', '..'));
            natsort($files);

            if(!empty($files)) {
                $t = explode('_', end($files));
                $lastNumber = $t[2];
            }
        }else{
            File::makeDirectory('images/procompite/' . $uid);
        }


        //VALIDATOR>>>>>>>>>>>>
        foreach ($input['file'] as $key => $file) {
            $arr = ['file' => $file];
            $rules = [
                'file' => 'required|mimes:png,gif,jpeg,jpg,bmp,PNG,JPG,JPEG,BMP,GIF'
            ];

            $messages = [
                'file.mimes' => 'No es el formato de imagen que se admite',
                'file.required' => 'Imagen Requerida'
            ];
            $validator = Validator::make($arr, $rules, $messages);

            if ($validator->fails()) {

                return Response::json([
                    'error' => true,
                    'message' => $validator->messages()->first(),
                    'code' => 400
                ], 400);
            }
        }

        //>>>>>>>>>>>>>>>>>>>>>>

        //UPLOAD IMAGES
        $increment = 1;
        $success = [];
        $tmpPath = 'images/procompite/tmp/'.$tmpName . '/';
        File::makeDirectory($tmpPath);
        foreach ($input['file'] as $key => $file) {
            $lastNumber += $increment;
            //extension de imagen
            $extension = $file->getClientOriginalExtension();
            //nombre de la imagen
            $fileName = $uid . '_' . strtoupper($categoria) . '_' . $lastNumber . '_'. $fecha . '.' . $extension;
            //saving image
            $uploadSuccess = $image->save($file, $tmpPath.$fileName);
            //si falla todo se va ;c
            if(!$uploadSuccess) {
                $this->deleteImg($success,$tmpPath);
                return false;
            }
            $success[] = $fileName;
        }

        DB::beginTransaction();
        //SAVE IN DATABASE
        $column = 'ffoto';

        try{
            $Procompite->fill(["$column"=>$fecha]);

            $Procompite->save();

        } catch(Exception $ex){
            $image->deleteImg($success,$tmpPath);
            return Response::json([
                'error' => true,
                'message' => 'Error del servidor (1)',
                'code' => 500
            ], 500);
        }

        //MOVE TO PATH IF ALL SUCCEDED
        $destinationPath = 'images/procompite/'. $uid . '/';

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

            rmdir(rtrim($tmpPath,'/'));
        }

        return Response([
            'error' => true,
            'message' => 'Error del servidor (2)',
            'code' => 500
        ], 500);


    }

    // ============== PDF ======================
    public function getPagePdfUpload(Request $request)
    {
        $input = $request->all();

        $Pro = Procompite::where('id',$input['id'])->first();
        return view($this->controlador.'.pdf-upload')->with('Pro',$Pro)->render();
    }

    public function getServerPdf($uid)
    {

        /*$files = scandir('images/full_size/'.$uid, 1);
        $files = array_diff($files, array('.', '..'));
        if(!empty($files)) {
            $t = explode('_', $files[0]);
            $lastNumber = $t[2] + 1;
        }
        */

        $files = scandir('pdf/procompite/'.$uid, 1);
        $files = array_diff($files, array('.', '..'));

        $resultSet = [];
        $resultSet['file'] = [];
        $arrEjecFiles = [];
        $PipTP = Procompite::where('id',$uid)->first();
        if(!empty($files)) {

            $arrAut = [];
            $arrRer = [];
            $arrPneg = [];
            $arrEjec = [];
            $arrConv = [];

            foreach($files as $file){
                $fileType = $this->multiexplode(['_','.'],$file);
                $fileType = $fileType[1];

                switch($fileType){
                    /*case 'AUTORIZACION':
                        $arrAut['tipo']  = 'aut';
                        $arrAut['fecha']  = $PipTP->f_aut;
                        $arrAut['avance'] = $PipTP->a_aut;
                        $arrAut['file'] = ['pdf/procompite/'.$uid.'/'.$file];
                        break;
                    case 'PLAN':
                        $arrPneg['tipo']  = 'pneg';
                        $arrPneg['fecha']  = $PipTP->f_pneg;
                        $arrPneg['avance'] = $PipTP->a_pneg;
                        $arrPneg['file'] = ['pdf/procompite/'.$uid.'/'.$file];
                        break;
                    case 'RER':
                       $arrRer['tipo']  = 'rer';
                       $arrRer['fecha']  = $PipTP->f_rer;
                       $arrRer['avance'] = $PipTP->a_rer;
                       $arrRer['file'] = ['pdf/procompite/'.$uid.'/'.$file];
                        break;
                    case 'EJECUCION':
                        $arrEjec['tipo']  = 'ejec';
                        $arrEjec['fecha']  = $PipTP->f_ejec;
                        $arrEjec['avance'] = $PipTP->a_ejec;
                        //$arrEjec['file'] = ['pdf/procompite/'.$uid.'/'.$file];
                        array_push($arrEjecFiles,'pdf/procompite/'.$uid.'/'.$file);
                        $arrEjec['file'] = $arrEjecFiles;
                        break;*/
                    case 'CONVENIO':
                        $arrConv['tipo']  = 'conv';
                        $arrConv['nro']   = $PipTP->nro_conv;
                        $arrConv['file']  = ['pdf/procompite/'.$uid.'/'.$file];
                        break;
                }
            }
            /*array_push($resultSet,['aut' => $arrAut]);
            array_push($resultSet,["pneg" => $arrPneg]);
            array_push($resultSet,["rer" => $arrRer]);
            array_push($resultSet,["ejec" => $arrEjec]);*/
            array_push($resultSet,["conv" => $arrConv]);
        }

        //dd($resultSet);
        return response()->json([
            'result' => $resultSet,
        ]);
    }

    public function postUploadPdf()
    {
        if(Auth::user()->hasRole('consulta')){
            return back();
        }

        $pdf = Input::all();
        $response = $this->upload($pdf);
        return $response;
    }

    public function upload( $form_data )
    {
        if(Auth::user()->hasRole('consulta')){
            return back();
        }
        //dd($form_data);
        //ID
        $uid = $form_data['uid'];

        //FLAG UPDATE default is CREATE
        $flagAction = false;

        //EN CASO DE EJECUCION
        $flagTipo = false;
        //TIPO
        $tipo = $form_data["tipo"];
        $arrNameTipo = [/*'aut' => 'AUTORIZACION',
            'pneg' => 'PLAN',
            'rer' => 'RER',
            'ejec' => 'EJECUCION',*/
            'conv' => 'CONVENIO'];

        //REQUEST DATA
        if($tipo != 'conv'){

            $avance  = $form_data["a_$tipo"];
            $fecha   = $form_data["f_$tipo"];
        } else {
            $avance = isset($form_data["nro_conv"]) == true ? $form_data["nro_conv"] : '';
            $fecha = null;
        }
        //UPDATE INFORMATION OF PDF
        if (isset($form_data[$tipo . "_pdf"])) {

            //flag de EJECUCION
            if(empty($form_data[$tipo . "_pdf"]) and $tipo == 'ejec'){
                $fs = scandir('pdf/procompite/'.$uid);
                $fs = array_diff($fs, array('.', '..'));

                foreach($fs as $f){
                    $t = $this->multiexplode(['_','.'],$f);
                    $t = $t[1];
                    if($t == $arrNameTipo[$tipo]){
                        if($t = $t[2] >= 1) {
                            $flagAction = true;//SI EXISTE ENTONCES ES LA EXCEPCION EJECUCION
                        } else {
                            return Response::json([
                                'error' => true,
                                'message' => 'Accion no permitida, comuniquese con el administrador del sistema',
                                'data' => null
                            ], 400);
                        }
                    }
                }
            } else {
                $pdf = $form_data[$tipo . "_pdf"];//SI DATOS DE NUEVO PDF
            }

        } else {//SINO CONSULTO EN BUSCA DE UN PDF DENTRO DEL REPOSITORIO
            $fs = scandir('pdf/procompite/'.$uid);
            $fs = array_diff($fs, array('.', '..'));

            foreach($fs as $f){
                $t = $this->multiexplode(['_','.'],$f);
                $t = $t[1];

                if($t == $arrNameTipo[$tipo]){
                    $flagAction = true;//SI EXISTE ENTONCES SE PUEDE ACTUALIZAR SU INFORMACION
                }
            }
            //SINO, GENERA UN ERROR
            if($flagAction == false){
                return Response::json([
                    'error' => true,
                    'message' => 'Accion no permitida, comuniquese con el administrador del sistema',
                    'data' => null
                ], 400);
            }
        }

        //ACTUALIZACION DE REGISTRO
        //dd($uid);
        if($flagAction == true){
            return $this->pdfUpdate($uid,$avance,$fecha,$tipo);
        }else{
            return $this->pdfCreate($uid,$pdf,$avance,$fecha,$tipo,$arrNameTipo);
        }
        //->>>>>>>>>>>>>>>>>>>>>>
    }

    public function pdfCreate($uid,$pdf,$avance,$fecha,$tipo,$arrNameTipo){  

        if(Auth::user()->hasRole('consulta')){
            return back();
        }      
        // CREACION Y GUARDADO DE PDF
        $extension = $pdf->getClientOriginalExtension();
        //validator>>>>>>>>>>
        if($tipo == 'conv'){
            $arr = ['file' => $pdf,
                'avance' => $avance
                ];
            $rules = [
                'file' => 'required|mimes:pdf',
                'avance' => 'required'
            ];
        } else {
            $arr = ['file' => $pdf,
                'avance' => $avance,
                'fecha' => $fecha];
            $rules = [
                'file' => 'required|mimes:pdf',
                'avance' => 'required',
                'fecha' => 'required',
            ];
        }

        $messages = [
            'file.mimes' => 'No es el formato de archivo que se admite, suba archivos con formato PDF',
            'file.required' => 'El PDF es requerido'
        ];
        $validator = Validator::make($arr, $rules, $messages);

        if ($validator->fails()) {

            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'data' => null
            ], 400);
        }
        //>>>>>>>>>>>>>>>>>>

        //GUARDAR CAMPOS
        DB::beginTransaction();
        //SAVE IN DATABASE
        $PipTP = Procompite::where('id',$uid)->first();

        if($tipo == 'conv') {
            $PipTP->fill([$tipo . "_pdf" => 'SI', "nro_conv" => $avance]);
            $PipTP->save();
        } else {
            $PipTP->fill([$tipo . "_pdf" => 'SI', "f_$tipo" => $fecha, "a_$tipo" => $avance]);
            $PipTP->save();
        }

        //CREATE DIRECTORY
        if(!File::exists('pdf/procompite/'.$uid)){
            File::makeDirectory('pdf/procompite/' . $uid);
        }

        $lastIndex = 1;

        if($tipo =='ejec'){
            $fs = scandir('pdf/procompite/'.$uid);
            $fs = array_diff($fs, array('.', '..'));

            foreach($fs as $f){
                $arrf = $this->multiexplode(['_','.'],$f);
                $t = $arrf[1];
                if($t == $arrNameTipo[$tipo]){
                    $lastIndex = $arrf[2] + 1;
                }
            }
        }

        //UPLOAD FILES
        $path = 'pdf/procompite/'.$uid .'/';

        //nombre del archivo
        $fileName = $uid . '_' . $arrNameTipo[$tipo] .'_'. $lastIndex . '.'.$extension;
        //saving pdf
        $uploadSuccess = $this->original( $pdf, $fileName, $path);

        if(!$uploadSuccess) {
            return Response::json([
                'error' => true,
                'message' => 'Error del servidor',
                'data' => null
            ], 500);
        }
        DB::commit();
        return Response::json([
            'error' => false,
            'message' => 'El archivo ha sido guardado exitosamente en el servidor',
            'data' => null
        ], 200);
    }

    public function original( $file, $filename,$path)
    {
        $pdf = $file->move($path , $filename);

        return $pdf;
    }

    private function pdfUpdate($uid,$avance,$fecha,$tipo){

        if(Auth::user()->hasRole('consulta')){
            return back();
        }
        //validator>>>>>>>>>>
        if($tipo != 'conv'){
            $arr = ['avance' => $avance,
                    'fecha' => $fecha];
            $rules = [
                    'avance' => 'required',
                    'fecha' => 'required',
                    ];
        } else {
            $arr   = ['avance' => $avance];
            $rules = ['avance' => 'required'];
        }
        $validator = Validator::make($arr, $rules);

        if ($validator->fails()) {

            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'data' => null
            ], 400);
        }
        //>>>>>>>>>>>>>>>>>>

        //GUARDAR CAMPOS
        DB::beginTransaction();
        //SAVE IN DATABASE
        $PipTP = Procompite::where('id',$uid)->first();

        if($tipo == 'conv'){
            $PipTP->fill(["nro_conv" => $avance, "$tipo" . "_pdf" => "SI"]);
            $PipTP->save();
        } else {
            $PipTP->fill(["f_$tipo" => $fecha, "a_$tipo" => $avance, "$tipo" . "_pdf" => "SI"]);
            $PipTP->save();
        }

        DB::commit();
        return Response::json([
            'error' => true,
            'message' => 'Se actualizaron los datos con exito',
            'data' => null
        ], 200);
    }


    public function deletePdf(Request $request)
    {
        $pdf = $request->get('pdf');

        $pdfarr = explode('/',$pdf);

        $name = end($pdfarr);

        $namearr = explode('_',$name);

        $uid = $namearr[0];

        $arrNameTipo = [/*'aut' => 'AUTORIZACION',
            'rer' => 'RER',
            'pneg' => 'PLAN',
            'ejec' => 'EJECUCION',*/
            'conv' => 'CONVENIO'];

        $tipo = array_search($namearr[1],$arrNameTipo);

        $id = $request->get('id');
        //$pdf = file_get_contents($pdf, true);
        $location = 'pdf/procompite/'.$uid.'/'.$name;
        $trash = 'pdf/procompite/trash/'.$name;



        try {
            rename($location,$trash);
        }catch (Exception $ex){
            return Response([
                'error' => true,
            ],500);
        }

        $PipTP = Procompite::where('id',$id)->first();
        $PipTP->fill([$tipo."_pdf"=> 'NO','f_'.$tipo => '', "a_".$tipo => '',"nro".$tipo => '']);
        $PipTP->save();

        return Response([
            'error' => false
        ],200);
    }

    //================= FIN PDF =================




    public function getServerImages($uid)
    {
        $PROCOMPITE   = [];

                $files = scandir('images/procompite/'.$uid. '/');
                $files = array_diff($files, array('.', '..'));
                if(!empty($files)) {
                    natsort($files);

                    $lastOne = end($files);
                    $arr = $this->multiexplode(array("_", "."), $lastOne);
                    $lastDate = $arr[3];

                    foreach ($files as $img) {
                        $arr2 = $this->multiexplode(array("_", "."), $img);
                        $thisDate = $arr2[3];
                        if ($thisDate == $lastDate) {
                                    array_push($PROCOMPITE, [
                                        'original' => $img,
                                        'server' => $img,
                                        'size' => File::size('images/procompite/'. $uid .'/'. $img),
                                        'url' => '/images/procompite/'. $uid .'/'. $img,
                                        'fecha' => $lastDate
                                    ]);
                        }
                    }




        }

        //$images = Image::get(['original_name', 'filename']);
        $files = scandir('images/procompite/'.$uid, 1);
        $images = array_diff($files, array('.', '..'));
        $imageAnswer = [];


        return response()->json([
            'procompite' => $PROCOMPITE
        ]);
    }

    //LOCATION
    public function getLocationPage(Request $request){
        $input = $request->all();
        $Pro = Procompite::where('id',$input['id'])->first();
        return view($this->controlador . '.location-upload')->with('data',$Pro)->render();
    }

    public function updateLocationInfo(Request $request){

        $input = $request->all();

        $PipTP = Procompite::where('id',$input['uid'])->first();
        $PipTP->fill(['latitud'=> $input['latitud'],'longitud'=>$input['longitud']]);
        $PipTP->save();

        return Response([
            'error' => false,
            'message' => 'Lo datos fueron guardados correctamente',
            'data' => ''
        ],200);
    }

    public function getLocationInfo(Request $request){

        $input = $request->all();
        //dd($input);
        $data = Procompite::select('latitud','longitud')->where('id',$input['uid'])->first();

        return Response([
            'error' => false,
            'message' => '',
            'data' => $data
        ],200);
    }

    function multiexplode ($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}
