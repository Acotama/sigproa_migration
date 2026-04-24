<?php

namespace sayhuite\Logic\Pdf;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
//use Intervention\Image\ImageManager;
//use sayhuite\Models\Image;
use sayhuite\Models\PipTotalPriori;
use Illuminate\Support\Facades\DB;

class PdfRepository
{
    public function upload( $form_data )
    {
        //ID
        $uid = $form_data['uid'];

        //FLAG UPDATE default is CREATE
        $flagAction = false;

        //EN CASO DE EJECUCION
        $flagTipo = false;
        //TIPO
        $tipo = $form_data["tipo"];
        $arrNameTipo = ['tdr' => 'TDR',
            'perfil' => 'PERFIL',
            'exptec' => 'EXPEDIENTE',
            'ejec' => 'EJECUCION',
            'liquid' => 'LIQUIDACION',
            'transf' => 'TRANSFERENCIA',
            'cierre' => 'CIERRE'];

        //REQUEST DATA
        $avance  = isset($form_data["a_$tipo"]) ? $form_data["a_$tipo"] : 100;
        $fecha   = $form_data["f_$tipo"];

        //EXCEPCION PARA TDR Y PERFIL
        if (isset($form_data[$tipo . "_pdf"])) {
            if ($pdf = $form_data[$tipo . "_pdf"] == '') {
                if ($tipo == 'tdr' || $tipo == 'perfil') {
                    return $this->update($uid, $avance, $fecha, $tipo);
                }
            }
        }
        //UPDATE INFORMATION OF PDF
        if (isset($form_data[$tipo . "_pdf"])) {
            //flag de EJECUCION
            if(empty($form_data[$tipo . "_pdf"]) and $tipo == 'ejec'){
                $fs = scandir('pdf/pip/'.$uid);
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
            $fs = scandir('pdf/pip/'.$uid);
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
        if($flagAction == true){
            return $this->update($uid,$avance,$fecha,$tipo);
        }else{
            return $this->create($uid,$pdf,$avance,$fecha,$tipo,$arrNameTipo);
        }
        //->>>>>>>>>>>>>>>>>>>>>>



    }

    public function create($uid,$pdf,$avance,$fecha,$tipo,$arrNameTipo){
        // CREACION Y GUARDADO DE PDF
        $extension = $pdf->getClientOriginalExtension();
        //validator>>>>>>>>>>
        $arr = ['file' => $pdf,
            'avance' => $avance,
            'fecha' => $fecha];
        $rules = [
            'file' => 'required|mimes:pdf',
            'avance' => 'required',
            'fecha' => 'required',
        ];

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
        $PipTP = PipTotalPriori::where('cod_unif',$uid)->first();

        $PipTP->fill([$tipo."_pdf"=>'SI',"f_$tipo"=>$fecha,"a_$tipo"=>$avance]);

        $PipTP->save();

        //CREATE DIRECTORY
        if(!File::exists('pdf/pip/'.$uid)){
            File::makeDirectory('pdf/pip/' . $uid);
        }

        $lastIndex = 1;

        if($tipo =='ejec'){
            $fs = scandir('pdf/pip/'.$uid);
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
        $path = 'pdf/pip/'.$uid .'/';

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

    private function update($uid,$avance,$fecha,$tipo){
        //validator>>>>>>>>>>
        $arr = ['avance' => $avance,
            'fecha' => $fecha];
        $rules = [
            'avance' => 'required',
            'fecha' => 'required',
        ];
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
        $PipTP = PipTotalPriori::where('cod_unif',$uid)->first();

        $PipTP->fill(["f_$tipo"=>$fecha,"a_$tipo"=>$avance,"$tipo"."_pdf" => "SI"]);
        $PipTP->save();

        DB::commit();
        return Response::json([
            'error' => true,
            'message' => 'Se actualizaron los datos con exito',
            'data' => null
        ], 200);
    }

    public function generateTmpName(){

        $tmpName=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFEGHIJKLMNÑOPQRSTUVWXYZ"), 0, 6);

        return $tmpName;
    }
    public function deleteFile($file, $path)
    {
        unlink($path.$file);
    }

    /**
     * Optimize Original Image
     */
    public function original( $file, $filename,$path)
    {
        $pdf = $file->move($path , $filename);

        return $pdf;
    }

    /**
     * Delete Image From Session folder, based on server created filename
     */
    public function delete( $filename,$uid )
    {
        $real_name = explode('/',$filename);
        $real_name = $real_name[1];

        $full_size_dir = 'images/full_size/'.$uid.'/'.$real_name;
        $icon_size_dir = 'images/icon_size/'.$uid.'/'.$real_name;
        //dd($full_size_dir);
        //$sessionImage = Image::where('filename', 'like', $filename)->first();



        /*if(empty($sessionImage))
        {
            return Response::json([
                'error' => true,
                'code'  => 400
            ], 400);

        }*/

        $full_path1 = $full_size_dir;
        $full_path2 = $icon_size_dir;

        if ( File::exists( $full_path1 ) )
        {
            File::delete( $full_path1 );
        }

        if ( File::exists( $full_path2 ) )
        {
            File::delete( $full_path2 );
        }

        /*if( !empty($sessionImage))
        {
            $sessionImage->delete();
        }*/

        return Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    function multiexplode ($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}
