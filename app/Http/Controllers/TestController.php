<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(){
        $posiX =    400;
        $posiY = 150;
        
        $fondo = 'https://inversiones.regionlima.gob.pe/storage/rer.jpg';


        // dd($fondo);

        $logo = 'https://inversiones.regionlima.gob.pe/storage/firma.jpg';
       
        // $fondo = asset('public/storage/original.jpg');

        // dd(asset('public/storage/original.jpg')); 

        $this->foto($fondo, $logo, $posiX, $posiY);
    }

    function foto($img_original, $marcadeagua, $posiX, $posiY){
        //Crear el destino (fondo)
        if (preg_match("/\.jpe?g$/i", $img_original)) { //simplifiqué el regex
            $imgm = imagecreatefromjpeg($img_original);
        }
        elseif (preg_match("/\.png$/i", $img_original)) {
            $imgm = imagecreatefrompng($img_original);
        }
        elseif (preg_match("/\.gif$/i", $img_original)) {
            $imgm = imagecreatefromgif($img_original);
        }
    
        //tomar el origen (logo)
        $marcadeagua= imagecreatefrompng($marcadeagua);
    
        //las posiciones en donde ubicar - se reciben por POST (hardcoddeadas en este ejemplo)
        $xmarcaagua = $posiX;
        $ymarcaagua = $posiY;
        //se obtiene el ancho y el largo del logo
        $ximagen = imagesx($marcadeagua);
        $yimagen = imagesy($marcadeagua);
    
        //COPIAR (observar las variables que se usan)
        imagecopy($imgm, $marcadeagua, 
                  $xmarcaagua, $ymarcaagua,
                  0, 0,
                  $ximagen, $yimagen);
    
    
        //Generar el archivo
        imagejpeg($imgm, 'storage/originalrand.jpg');
    
    
        //faltaba destruirla (hay que ser prolijos)
        imagedestroy( $imgm );
    }

        // imagejpeg($imgm, asset('public/storage/originalrand.jpg'));

    function urls(){

        // $consulta_ssi = Http::connectTimeout(60)->withOptions(['verify' => true])->post('https://ofi5.mef.gob.pe/inviertews/Dashboard/traeDetInvSSI', [
        //     'id' => $codigo,
        //     'tipo' => 'SIAF',
        // ]);

        $codigo= "2492443";

        $client = new Client();
        $response = $client->request('POST', 'https://ofi5.mef.gob.pe/inviertews/Dashboard/traeDetInvSSI', [
            'form_params' => [
                'id' => $codigo,
                'tipo' => 'SIAF',
            ],
            'verify' => false
        ]);

        // dd($response->getBody());
        return response()->json(json_decode($response->getBody(), true));
        
    }

    public function insertMetaData()
    {
        
        $data = [
            [
                "anio" => 2024,
                "direc_uei" => "ESTUDIOS DE PRE-INVERSION",
                "m_enero" => 50000.0000000,
                "m_febrero" => 50000.0000000,
                "m_marzo" => 98069.0000000,
                "m_abril" => 242276.0000000,
                "m_mayo" => 130115.0000000,
                "m_junio" => 172018.0000000,
                "m_julio" => 133480.0000000,
                "m_agosto" => 133480.0000000,
                "m_setiembre" => 151221.0000000,
                "m_octubre" => 151222.0000000,
                "m_noviembre" => 151222.0000000,
                "m_diciembre" => 151223.0000000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ],
            [
                "anio" => 2024,
                "direc_uei" => "GERENCIA REGIONAL DE INFRAESTRUCTURA",
                "m_enero" => 0E-7,
                "m_febrero" => 1896599.0000000,
                "m_marzo" => 7451090.0000000,
                "m_abril" => 6630753.0000000,
                "m_mayo" => 10510322.0000000,
                "m_junio" => 13407998.0000000,
                "m_julio" => 19221948.0000000,
                "m_agosto" => 25173481.0000000,
                "m_setiembre" => 12898322.0000000,
                "m_octubre" => 42752153.0000000,
                "m_noviembre" => 24773048.0000000,
                "m_diciembre" => 107279557.3000000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ],
            [
                "anio" => 2024,
                "direc_uei" => "DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES",
                "m_enero" => 170000.0000000,
                "m_febrero" => 1747227.0000000,
                "m_marzo" => 1531895.0000000,
                "m_abril" => 1809679.0000000,
                "m_mayo" => 2721699.0000000,
                "m_junio" => 3470021.0000000,
                "m_julio" => 5611974.0000000,
                "m_agosto" => 8104084.0000000,
                "m_setiembre" => 5162892.0000000,
                "m_octubre" => 4786186.0000000,
                "m_noviembre" => 9665972.0000000,
                "m_diciembre" => 12223304.0000000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ],
            [
                "anio" => 2024,
                "direc_uei" => "GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE",
                "m_enero" => 0E-7,
                "m_febrero" => 57387.0000000,
                "m_marzo" => 0E-7,
                "m_abril" => 87400.0000000,
                "m_mayo" => 120195.0000000,
                "m_junio" => 30000.0000000,
                "m_julio" => 489941.0000000,
                "m_agosto" => 51100.0000000,
                "m_setiembre" => 90700.0000000,
                "m_octubre" => 59000.0000000,
                "m_noviembre" => 12217018.0000000,
                "m_diciembre" => 1705524.0000000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ],
            [
                "anio" => 2024,
                "direc_uei" => "GERENCIA REGIONAL DE DESARROLLO ECONOMICO",
                "m_enero" => 5000.0000000,
                "m_febrero" => 35000.0000000,
                "m_marzo" => 354182.0000000,
                "m_abril" => 610645.0000000,
                "m_mayo" => 2266971.0000000,
                "m_junio" => 2272604.0000000,
                "m_julio" => 2163426.0000000,
                "m_agosto" => 2194037.0000000,
                "m_setiembre" => 1406138.0000000,
                "m_octubre" => 1855039.0000000,
                "m_noviembre" => 4731425.0000000,
                "m_diciembre" => 2536243.0000000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ],
            [
                "anio" => 2024,
                "direc_uei" => "GERENCIA REGIONAL DE DESARROLLO SOCIAL",
                "m_enero" => 0E-7,
                "m_febrero" => 0E-7,
                "m_marzo" => 549000.0000000,
                "m_abril" => 471732.0000000,
                "m_mayo" => 185366.0000000,
                "m_junio" => 560747.0000000,
                "m_julio" => 204466.0000000,
                "m_agosto" => 65883.0000000,
                "m_setiembre" => 14534.0000000,
                "m_octubre" => 3070662.0000000,
                "m_noviembre" => 2489767.0000000,
                "m_diciembre" => 14810511.0000000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ],
            [
                "anio" => 2024,
                "direc_uei" => "GERENCIA SUB REGIONAL LIMA SUR",
                "m_enero" => 0E-7,
                "m_febrero" => 676427.0000000,
                "m_marzo" => 10733441.0000000,
                "m_abril" => 3410887.0000000,
                "m_mayo" => 4916050.0000000,
                "m_junio" => 2840048.0000000,
                "m_julio" => 2327853.0000000,
                "m_agosto" => 2047913.0000000,
                "m_setiembre" => 2615992.0200000,
                "m_octubre" => 2241529.0000000,
                "m_noviembre" => 10103352.0000000,
                "m_diciembre" => 6220163.1500000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ],
            [
                "anio" => 2024,
                "direc_uei" => "DIRECCION REGIONAL DE AGRICULTURA",
                "m_enero" => 0E-7,
                "m_febrero" => 1537984.0000000,
                "m_marzo" => 3317224.0000000,
                "m_abril" => 3503084.0000000,
                "m_mayo" => 4824000.0000000,
                "m_junio" => 3185420.0000000,
                "m_julio" => 6790049.0000000,
                "m_agosto" => 10997541.0000000,
                "m_setiembre" => 7069312.0000000,
                "m_octubre" => 12293261.0000000,
                "m_noviembre" => 13056181.0000000,
                "m_diciembre" => 17672122.0000000,
                "fecha_subida" => "2024-10-04",
                "tipo" => "MEF"
            ]
            ];
        
        

        // Inserta los datos en la base de datos
        // DB::table('meta_mef')->insert($data);

        return redirect()->back()->with('success', 'Datos insertados correctamente.');
    }
    
}
