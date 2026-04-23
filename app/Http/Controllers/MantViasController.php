<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use sayhuite\Logic\Image\ImageRepository;
use sayhuite\PipTotalPriori;
use sayhuite\Departamento;
use sayhuite\Dependencia;
use sayhuite\Provincia;
use sayhuite\Distrito;
use sayhuite\SubEtapa;
use sayhuite\EstAntig;
use sayhuite\MantenimientoVia;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use File;
use sayhuite\Logic\Tools\Tools;
use Validator;
use Illuminate\Support\Facades\DB;

class MantViasController extends Controller
{


    protected $controlador = 'mantvias';
    protected $searchAlias = [
                                'eq' => '=',
                                'cn' => 'like',
                                'nc' => '<>'
                             ];
    protected $orderBy = [];
    //protected $tipo = null;
    //protected $year = null;

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

        $MantVias = MantenimientoVia::select([
            'grli_mantenimiento_via.id',
            //'grli_mantenimiento_via.dep',
            //'grli_mantenimiento_via.cod_dep',
            'grli_mantenimiento_via.prov',
            //'grli_mantenimiento_via.cod_prov',
            'grli_mantenimiento_via.dist',
            //'grli_mantenimiento_via.cod_dist',
            'grli_mantenimiento_via.cod_ruta',
            'grli_mantenimiento_via.activ',
            'grli_mantenimiento_via.tip_activ',
            'grli_mantenimiento_via.tip_mant',
            'grli_mantenimiento_via.mfis_pro',
            'grli_mantenimiento_via.mfin_pro',
            'grli_mantenimiento_via.ejec_fisico',
            'grli_mantenimiento_via.av_fisico',
            'grli_mantenimiento_via.deven_finan',
            'grli_mantenimiento_via.av_finan',
            'grli_mantenimiento_via.f_afinanc',
            'grli_mantenimiento_via.mod_ejec',
            'grli_mantenimiento_via.est',
            'grli_mantenimiento_via.f_estado',
            'grli_mantenimiento_via.anio',
            'grli_mantenimiento_via.est_info',
            'grli_mantenimiento_via.u_medida'
            //'grli_mantenimiento_via.ffoto'
        ]);
        
        $MantVias = $MantVias->orderBy($sidx,$sord )->groupBy(
            'grli_mantenimiento_via.id',
            //'grli_mantenimiento_via.dep',
            //'grli_mantenimiento_via.cod_dep',
            'grli_mantenimiento_via.prov',
            //'grli_mantenimiento_via.cod_prov',
            'grli_mantenimiento_via.dist',
            //'grli_mantenimiento_via.cod_dist',
            'grli_mantenimiento_via.cod_ruta',
            'grli_mantenimiento_via.activ',
            'grli_mantenimiento_via.tip_activ',
            'grli_mantenimiento_via.tip_mant',
            'grli_mantenimiento_via.mfis_pro',
            'grli_mantenimiento_via.mfin_pro',
            'grli_mantenimiento_via.ejec_fisico',
            'grli_mantenimiento_via.av_fisico',
            'grli_mantenimiento_via.deven_finan',
            'grli_mantenimiento_via.av_finan',
            'grli_mantenimiento_via.f_afinanc',
            'grli_mantenimiento_via.mod_ejec',
            'grli_mantenimiento_via.est',
            'grli_mantenimiento_via.f_estado',
            'grli_mantenimiento_via.anio',
            'grli_mantenimiento_via.est_info',
            'grli_mantenimiento_via.u_medida'
            //'grli_mantenimiento_via.ffoto'
        );

        $legend = $this->countEtapa($MantVias->get());

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
                                $MantVias = $MantVias->where($field,'=',$param);
                                break;
                            case 'cn':
                                $MantVias = $MantVias->where($field,'like','%'.$param.'%');
                                break;
                            case 'nc':
                                $MantVias = $MantVias->where($field,'not like','%'.$param.'%');
                                break;
                        }

                    }

                    break;
            }
        }

        $count  = $MantVias->get()->count();
        $totalpages = ceil($count / $limit);
        $MantVias  = $MantVias->skip($start)->take($limit)->get();

        return Response([
            'rows' => $MantVias->toArray(),
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

    public function comboEstAntig($id) {
        $data = EstAntig::select('estado')
            ->where('estado', '=', $id)->get();

        $combo = '<option value="0"> -- Seleccionar -- </option>';
        foreach ($data as $value) {
            $combo = $combo . ' <option value="' . $value['estado'] . '">' . $value['estado'] . '</option>';
        }
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

        $MantVias = PipTotalPriori::find($id);

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
        $input  = $request->all();
        //dd($input);

        $cleanInput = Input::except('_token', 'uid', 'file', 'tipo', 'fecha', 'csrf-token');
        $validator = Validator::make($data = $cleanInput, MantenimientoVia::$rules);


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
            $MantVia = MantenimientoVia::find($input['id']);
            $MantVia->fill($input);
            $MantVia->save();

            return Response(['error' => false],200);
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
        $input = $request->all();
        $val = '';
        $uid = $input['uid'];
        switch($input['st']){
            case 1:
                $val = 'PRIORIZADO';
                break;
            case 0:
                $val = 'NO PRIORIZADO';
                break;
            default:
                return Response(['error' => true],500);
        }

        $PipTP = MantenimientoVia::find($uid);

        $PipTP->update(['est_info'=>$val]);
    }

    public function getPageImageUpload(Request $request)
    {

        $input = $request->all();
        return view($this->controlador.'.image-upload')->with('id',$input['id'])->render();
    }

    public function imgUpload(ImageRepository $image)
    {
        $input = Input::all();
        $MantVias = MantenimientoVia::where('id',$input['uid'])->first();

        $uid = $input['uid'];
        $tipo = $input['tipo'];

        //REFORMAT DATE
        $fecha = date('d-m-y',strtotime($input['fecha']));
        //TMP NAME OF IMAGES
        $tmpName = Tools::generateTmpName();
        $fileName = '';
        $lastNumber = 0;

        //CREATE DIRECTORY
        if(File::exists('images/mantenimiento_vias/'.$uid)){
            $files = scandir('images/mantenimiento_vias/' . $uid . '/' . strtoupper($tipo), 1);
            $files = array_diff($files, array('.', '..'));
            natsort($files);

            if(!empty($files)) {
                $t = explode('_', end($files));
                $lastNumber = $t[2];
            }
        }else{
            File::makeDirectory('images/mantenimiento_vias/' . $uid);

            File::makeDirectory('images/mantenimiento_vias/' . $uid . '/ANTES');
            File::makeDirectory('images/mantenimiento_vias/' . $uid . '/DESPUES');
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
        $tmpPath = 'images/mantenimiento_vias/tmp/'.$tmpName.'/';
        File::makeDirectory($tmpPath);
        foreach ($input['file'] as $key => $file) {
            $lastNumber += $increment;
            //extension de imagen
            $extension = $file->getClientOriginalExtension();
            //nombre de la imagen
            $fileName = $uid . '_' . strtoupper($tipo) . '_' . $lastNumber . '_'. $fecha . '.' . $extension;
            //saving image
            $uploadSuccess = $image->save($file, $tmpPath.$fileName);
            //si falla todo se va ;c
            if(!$uploadSuccess) {
                $image->deleteImg($success,$tmpPath);
                return Response::json([
                    'error' => true,
                    'message' => 'Error del servidor',
                    'code' => 500
                ], 500);
            }
            $success[] = $fileName;
        }

        DB::beginTransaction();
        //SAVE IN DATABASE
        $column = 'ffoto_' . $tipo;

        try{
            $MantVias->fill(["$column"=>$fecha]);

            $MantVias->save();

        } catch(Exception $ex){
            $image->deleteImg($success,$tmpPath);
            return Response::json([
                'error' => true,
                'message' => 'Error del servidor',
                'code' => 500
            ], 500);
        }



        //MOVE TO PATH IF ALL SUCCEDED
        $destinationPath = 'images/mantenimiento_vias/'. $uid . '/' . strtoupper($tipo) . '/';

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

        return Response([
            'error' => true,
            'message' => 'Error del servidor',
            'code' => 500
        ], 500);

    }

    public function getServerImages($uid)
    {
        $ANTES   = [];
        $DURANTE = [];
        $DESPUES = [];

        $folders = scandir('images/mantenimiento_vias/'.$uid, 1);
        $folders = array_diff($folders, array('.', '..'));

        if(!empty($folders)) {
            foreach($folders as $key => $folder){
                $files = scandir('images/mantenimiento_vias/'.$uid. '/' . $folder);
                $files = array_diff($files, array('.', '..'));
                if(!empty($files)) {
                    natsort($files);

                    $lastOne = end($files);
                    $arr = $this->multiexplode(array("_", "."), $lastOne);
                    $lastDate = $arr[3];

                    foreach ($files as $img) {
                        $arr = $this->multiexplode(array("_", "."), $img);
                        $thisDate = $arr[3];
                        if ($thisDate == $lastDate) {
                            switch ($folder) {
                                case 'ANTES':
                                    array_push($ANTES, [
                                        'original' => $img,
                                        'server' => $img,
                                        'size' => File::size('images/mantenimiento_vias/'. $uid .'/ANTES/'. $img),
                                        'url' => '/images/mantenimiento_vias/'. $uid .'/ANTES/'. $img,
                                        'fecha' => $lastDate
                                    ]);
                                    break;
                                case 'DURANTE':
                                    array_push($DURANTE, [
                                        'original' => $uid.'/'.$img,
                                        'server' => $uid.'/'.$img,
                                        'size' => File::size('images/mantenimiento_vias/'. $uid .'/DURANTE/'. $img),
                                        'url' => '/images/mantenimiento_vias/'. $uid .'/DURANTE/'. $img,
                                        'fecha' => $lastDate
                                    ]);
                                    break;
                                case 'DESPUES':
                                    array_push($DESPUES, [
                                        'original' => $uid.'/'.$img,
                                        'server' => $uid.'/'.$img,
                                        'size' => File::size('images/mantenimiento_vias/'. $uid .'/DESPUES/'. $img),
                                        'url' => '/images/mantenimiento_vias/'. $uid .'/DESPUES/'. $img,
                                        'fecha' => $lastDate
                                    ]);
                                    break;
                            }
                        }
                    }
                }

            }
        }

        //$images = Image::get(['original_name', 'filename']);
        $files = scandir('images/mantenimiento_vias/'.$uid, 1);
        $images = array_diff($files, array('.', '..'));
        $imageAnswer = [];


        return response()->json([
            'antes' => $ANTES,
            'durante' => $DURANTE,
            'despues' => $DESPUES
        ]);
    }

    function multiexplode ($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}
