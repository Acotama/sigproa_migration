<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use sayhuite\MantCanales;
use sayhuite\PipTotalPriori;
use sayhuite\Departamento;
use sayhuite\Dependencia;
use sayhuite\Provincia;
use sayhuite\Distrito;
use sayhuite\SubEtapa;
use sayhuite\EstAntig;


use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use File;
use Validator;
use DB;

use sayhuite\Logic\Image\ImageRepository;
use sayhuite\Logic\Tools\Tools;
use sayhuite\AulasPrefabricadas_ds;

class AulasPrefDSController extends Controller
{

    protected $controlador = 'mantaulaspre_ds';
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

        $AP = AulasPrefabricadas_ds::select([
            'grli_aulas_pre_grds.id',
            'grli_aulas_pre_grds.nom_activ',
            'grli_aulas_pre_grds.pob_benef',
            'grli_aulas_pre_grds.situacion',
            'grli_aulas_pre_grds.f_inicio',
            'grli_aulas_pre_grds.f_fin',
            'grli_aulas_pre_grds.u_medida',
            'grli_aulas_pre_grds.cantidad',
            'grli_aulas_pre_grds.ctotal',
            'grli_aulas_pre_grds.a_financ',
            'grli_aulas_pre_grds.a_fisico',
            'grli_aulas_pre_grds.a_ejec_fis',
            'grli_aulas_pre_grds.a_ejec_financ'
        ]);
        $count = $AP->count();
        $AP = $AP->orderBy($sidx,$sord )->groupBy(
            'grli_aulas_pre_grds.id',
            'grli_aulas_pre_grds.nom_activ',
            'grli_aulas_pre_grds.pob_benef',
            'grli_aulas_pre_grds.situacion',
            'grli_aulas_pre_grds.f_inicio',
            'grli_aulas_pre_grds.f_fin',
            'grli_aulas_pre_grds.u_medida',
            'grli_aulas_pre_grds.cantidad',
            'grli_aulas_pre_grds.ctotal',
            'grli_aulas_pre_grds.a_financ',
            'grli_aulas_pre_grds.a_fisico',
            'grli_aulas_pre_grds.a_ejec_fis',
            'grli_aulas_pre_grds.a_ejec_financ'
        );

        $legend = '';//$this->countEtapa($AP->get());

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
                                $AP = $AP->where($field,'=',$param);
                                break;
                            case 'cn':
                                $AP = $AP->where($field,'like','%'.$param.'%');
                                break;
                            case 'nc':
                                $AP = $AP->where($field,'not like','%'.$param.'%');
                                break;
                        }

                    }

                    break;
            }
        }

        $totalpages = ceil($count / $limit);
        $AP  = $AP->skip($start)->take($limit)->get();

        return Response([
            'rows' => $AP->toArray(),
            'page' => $page,
            'total' => $totalpages,
            'records' => $count,
            'legend' => $legend
        ]);

        //filters:{"groupOp":"AND","rules":[{"field":"av_finan","op":"bw","data":"sasdaas"},{"field":"mod_ejec","op":"bw","data":"ddfsdsf"}]}

    }

    public function getPageImageUpload(Request $request)
    {

        $input = $request->all();
        return view($this->controlador . '.image-upload')->with('id', $input['id'])->render();
    }

    public function update(Request $request) {
        $input  = $request->all();


        $cleanInput = Input::except('_token', 'uid', 'file', 'tipo', 'fecha', 'csrf-token');
        $validator = Validator::make($data = $cleanInput, AulasPrefabricadas_ds::$rules);


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
            $AulasPref = AulasPrefabricadas_ds::find($input['id']);
            $AulasPref->fill($input);
            $AulasPref->save();

            return Response(['error' => false],200);
        }
    }

    public function getServerImages($uid){

        $aulas_ds   = [];

        $files = scandir('images/aulas_pre_ds/'.$uid. '/');
        $files = array_diff($files, array('.', '..'));
        if(!empty($files)) {
            natsort($files);

            foreach ($files as $img) {

                array_push($aulas_ds, [
                   'original' => $img,
                   'server' => $img,
                   'size' => File::size('images/aulas_pre_ds/'. $uid .'/'. $img),
                   'url' => '/images/aulas_pre_ds/'. $uid .'/'. $img
                ]);
            }
        }

        return response()->json([
            'aulas_pre' => $aulas_ds
        ]);
    }

    public function imgUpload(ImageRepository $image)
    {
        $categoria = 'aulas_pre_ds';

        $input = Input::all();
        $AulasPre = AulasPrefabricadas_ds::where('id',$input['uid'])->first();

        $uid = $input['uid'];
        //REFORMAT DATE
        $fecha = date('d-m-y',strtotime($input['fecha']));
        //LINK OF IMAGES
        $tmpName = Tools::generateTmpName();
        $fileName = '';

        $lastNumber = 0;
        //CREATE DIRECTORY
        if(File::exists('images/aulas_pre_ds/'.$uid)){
            $files = scandir('images/aulas_pre_ds/' . $uid . '/', 1);
            $files = array_diff($files, array('.', '..'));
            natsort($files);

            if(!empty($files)) {
                $t = explode('.', end($files));
                $lastNumber = $t[0];
            }
        }else{
            File::makeDirectory('images/aulas_pre_ds/' . $uid);
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
        $tmpPath = 'images/aulas_pre_ds/tmp/'.$tmpName . '/';
        File::makeDirectory($tmpPath);
        foreach ($input['file'] as $key => $file) {
            $lastNumber += $increment;
            //extension de imagen
            $extension = $file->getClientOriginalExtension();
            //nombre de la imagen
            $fileName = $lastNumber .'.'. $extension;
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

        //MOVE TO PATH IF ALL SUCCEDED
        $destinationPath = 'images/aulas_pre_ds/'. $uid . '/';

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
}
