<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Mockery\CountValidator\Exception;
use sayhuite\Logic\Pdf\PdfRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use sayhuite\PipTotalPriori;

//use sayhuite\Models\Image;

class PdfController extends Controller
{
    protected $pdf;

    public function __construct(PdfRepository $pdfRepository)
    {
        $this->pdf = $pdfRepository;
    }


    public function postUpload()
    {

        $pdf = request()->all();
        $response = $this->pdf->upload($pdf);
        return $response;
    }

    public function deletePdf(Request $request)
    {
        $pdf = $request->get('pdf');

        $pdfarr = explode('/',$pdf);

        $name = end($pdfarr);

        $namearr = explode('_',$name);

        $uid = $namearr[0];

        $arrNameTipo = ['tdr' => 'TDR',
            'perfil' => 'PERFIL',
            'exptec' => 'EXPEDIENTE',
            'ejec' => 'EJECUCION',
            'liquid' => 'LIQUIDACION',
            'transf' => 'TRANSFERENCIA',
            'cierre' => 'CIERRE'];

        //dd($request->all());

        $tipo = array_search($namearr[1],$arrNameTipo);

        $id = $request->get('id');
        //$pdf = file_get_contents($pdf, true);
        $location = 'pdf/pip/'.$uid.'/'.$name;
        $trash = 'pdf/pip/trash/'.$name;



        try {
            rename($location,$trash);
        }catch (Exception $ex){
            return Response([
                'error' => true,
            ],500);
        }

        $PipTP = PipTotalPriori::where('id',$id)->first();
        $PipTP->fill([$tipo."_pdf"=> 'NO','f_'.$tipo => '', "a_".$tipo => '']);
        $PipTP->save();

        return Response([
            'error' => false
        ],200);
    }

    /**
     * Part 2 - Display already uploaded images in Dropzone
     */

    public function getServerImagesPage()
    {
        //return view('Images')->with('uid',1234);
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

        $files = scandir('pdf/pip/'.$uid, 1);
        $files = array_diff($files, array('.', '..'));

        $resultSet = [];
        $resultSet['file'] = [];
        $arrEjecFiles = [];
        $PipTP = PipTotalPriori::where('cod_unif',$uid)->first();

        $arrTdr = [];
        $arrPerfil = [];
        $arrExpTec = [];
        $arrEjec = [];
        $arrLiquid = [];
        $arrTransf = [];
        $arrCierre = [];



        $arrTdr['tipo']  = 'tdr';
        $arrTdr['fecha']  = $PipTP->f_tdr;
        $arrTdr['avance'] = $PipTP->a_tdr;
        $arrTdr['file'] = [''];


        $arrPerfil['tipo']  = 'perfil';
        $arrPerfil['fecha']  = $PipTP->f_perfil;
        $arrPerfil['avance'] = $PipTP->a_perfil;
        $arrPerfil['file'] = [''];




        if(!empty($files)) {

            foreach($files as $file){
                $fileType = $this->multiexplode(['_','.'],$file);
                $fileType = $fileType[1];

                switch($fileType){
                    case 'TDR':
                        $arrTdr['tipo']  = 'tdr';
                        $arrTdr['fecha']  = $PipTP->f_tdr;
                        $arrTdr['avance'] = $PipTP->a_tdr;
                        $arrTdr['file'] = ['pdf/pip/'.$uid.'/'.$file];
                        break;
                    case 'PERFIL':
                        $arrPerfil['tipo']  = 'perfil';
                        $arrPerfil['fecha']  = $PipTP->f_perfil;
                        $arrPerfil['avance'] = $PipTP->a_perfil;
                        $arrPerfil['file'] = ['pdf/pip/'.$uid.'/'.$file];
                        break;
                    case 'EXPEDIENTE':
                        $arrExpTec['tipo']  = 'exptec';
                        $arrExpTec['fecha']  = $PipTP->f_exptec;
                        $arrExpTec['avance'] = $PipTP->a_exptec;
                        $arrExpTec['file'] = ['pdf/pip/'.$uid.'/'.$file];
                        break;
                    case 'EJECUCION':
                        $arrEjec['tipo']  = 'ejec';
                        $arrEjec['fecha']  = $PipTP->f_ejec;
                        $arrEjec['avance'] = $PipTP->a_ejec;
                        //$arrEjec['file'] = ['pdf/pip/'.$uid.'/'.$file];
                        array_push($arrEjecFiles,'pdf/pip/'.$uid.'/'.$file);
                        $arrEjec['file'] = $arrEjecFiles;
                        break;
                    case 'LIQUIDACION':
                        $arrLiquid['tipo']  = 'liquid';
                        $arrLiquid['fecha']  = $PipTP->f_liquid;
                        $arrLiquid['avance'] = $PipTP->a_liquid;
                        $arrLiquid['file']   = ['pdf/pip/'.$uid.'/'.$file];
                        break;
                    case 'TRANSFERENCIA':
                        $arrTransf['tipo']  = 'transf';
                        $arrTransf['fecha']  = $PipTP->f_transf;
                        $arrTransf['avance'] = $PipTP->a_transf;
                        $arrTransf['file']   = ['pdf/pip/'.$uid.'/'.$file];
                        break;
                    case 'CIERRE':
                        $arrCierre['tipo']  = 'cierre';
                        $arrCierre['fecha']  = $PipTP->f_cierre;
                        $arrCierre['avance'] = $PipTP->a_cierre;
                        $arrCierre['file']   = ['pdf/pip/'.$uid.'/'.$file];
                        break;
                }
            }
            array_push($resultSet,['tdr' => $arrTdr]);
            array_push($resultSet,["perfil" => $arrPerfil]);
            array_push($resultSet,["exptec" => $arrExpTec]);
            array_push($resultSet,["ejec" => $arrEjec]);
            array_push($resultSet,["liquid" => $arrLiquid]);
            array_push($resultSet,["transf" => $arrTransf]);
            array_push($resultSet,["cierre" => $arrCierre]);
        }

        //dd($resultSet);
        return response()->json([
            'result' => $resultSet,
        ]);
    }

    function multiexplode ($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
}
