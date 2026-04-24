<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use sayhuite\Models\PipTotalPriori;
use GuzzleHttp\Client;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ModificacionPresupuestalController extends Controller
{
    public function modificacion_presupuestal(Request $request){
        return view('modificacion_presupuestal.index');
    }

    public function data_analisis(Request $request){

        $input=$request->all();
        $codigo = array_unique($input['id']);
        $data_validacion =  array();
        if(!empty($codigo)){
            foreach($codigo as $key=>$value){
                $data = array ('id' => $value, 'tipo' => 'SIAF');
                $data = http_build_query($data);
                $opciones = array(
                    'http' => array(
                        'header' => "Content-Type:application/x-www-form-urlencoded; charset=UTF-8\r\n".
                                    "Content-Length: ".strlen($data)."\r\n".
                                    "User-Agent:Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36 OPR/77.0.4054.277\r\n".
                                    "Host: www.regionlima.gob.pe\r\n".
                                    "Origin: http://ofi5.mef.gob.pe",
                        'method'  => "POST",
                        'content' => $data,
                    ),
                    'ssl'=>array(
                        'verify_peer'=>false,
                        'verify_peer_name'=>false,
                    ),
                );
                $contexto = stream_context_create($opciones);
                $response = file_get_contents("https://ofi5.mef.gob.pe/inviertews/Dashboard/traeDetInvSSI",false, $contexto);
                $response = json_decode($response, true);

                if(count($response) <= 0){
                    $data_validacion[]= $value;
                }
            }
        }
        return Response([
            'ssi' => $data_validacion,
            // 'brechas' => html_entity_decode($tabla),
            // 'pmi' => json_decode($response_pmi, true),
            // 'proyecto' => $proyecto,
            // 'f12b' => json_decode($response_f12b, true),
        ]);

        // $data_pmi = array ('txtCodigoUnico' => $codigo, 'ddlSector' => '');
        // $data_pmi = http_build_query($data_pmi);
        // $opciones_pmi = array(
        //     'http' => array(
        //         'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
        //                     "Content-Length: ".strlen($data_pmi)."\r\n".
        //                     "User-Agent:MyAgent/1.0\r\n",
        //         'method'  => "POST",
        //         'content' => $data_pmi,
        //     ),
        // );

        // $contexto_pmi = stream_context_create($opciones_pmi);
        // $response_pmi = file_get_contents("http://ofi5.mef.gob.pe/invierte/Pmi/traeListaCarteraSector",false, $contexto_pmi);

        // $proyecto = DB::table('vw_grli_pip_seguimiento_ejecucion_financiera')->select('pia_dia','pim_dia')->where('cod_unif',$codigo)->first();

        // $data_f12b = array ('id' => $codigo);
        // $data_f12b = http_build_query($data_f12b);
        // $opciones_f12b = array(
        //     'http' => array(
        //         'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
        //                     "Content-Length: ".strlen($data_f12b)."\r\n".
        //                     "User-Agent:MyAgent/1.0\r\n",
        //         'method'  => "POST",
        //         'content' => $data_f12b,
        //     ),
        // );

        // $contexto_f12b = stream_context_create($opciones_f12b);
        // $response_f12b = file_get_contents("http://ofi5.mef.gob.pe/inviertews/Dashboard/traeInformF12B_CU",false, $contexto_f12b);

        // $response = json_decode($response, true);
        // $response_pmi = json_decode($response_pmi, true);
        // $response_f12b = json_decode($response_f12b, true);
        // $data1 = array ();
        // $monto_anulado = empty($anulacion)? 0 : $anulacion;
        // $monto_credito = empty($credito)? 0 : $credito;
        // foreach($response as $data){
        //     $pmi = "SI";
        //     $devengado_acumulado = 0;
        //     $programacion_anio_1 = 0;
        //     $programacion_anio_2 = 0;
        //     $programacion_anio_3 = 0;
        //     $total_actualizadof12 = 0;
        //     if(count($response_pmi) == 1){
        //         foreach($response_pmi as $pmi){
        //             $devengado_acumulado = $pmi['DEVENGADO_ACUMULADO'];
        //             $programacion_anio_1 = $pmi['PROGRAMACION_INVERSION_ANIO1'];
        //             $programacion_anio_2 = $pmi['PROGRAMACION_INVERSION_ANIO2'];
        //             $programacion_anio_3 = $pmi['PROGRAMACION_INVERSION_ANIO3'];
        //         }
        //         $pmi = "SI";
        //     }else{
        //         $devengado_acumulado = $data['DEV_ACUMULADO'];
        //         $pmi = "NO";
        //     }

        //     if(count($response_f12b) == 1){
        //         foreach($response_f12b as $f12b){
        //             $total_actualizadof12 = $f12b['MONTO_ACTUALIZADO_1'] + $f12b['MONTO_ACTUALIZADO_2'] + $f12b['MONTO_ACTUALIZADO_3'] + $f12b['MONTO_ACTUALIZADO_4'] + $f12b['MONTO_ACTUALIZADO_5'] + $f12b['MONTO_ACTUALIZADO_6'] + $f12b['MONTO_ACTUALIZADO_7'] + $f12b['MONTO_ACTUALIZADO_8'] + $f12b['MONTO_ACTUALIZADO_9'] + $f12b['MONTO_ACTUALIZADO_10'] + $f12b['MONTO_ACTUALIZADO_11'] + $f12b['MONTO_ACTUALIZADO_12'];
        //         }
        //     }

        //     // if ($monto_anulado != 0 ){
        //     //     $data1 = array (
        //     //         $this->uei($data['DES_UNIDAD_UEI']),
        //     //         $data['CODIGO_UNICO'],
        //     //         $data['NOMBRE_INVERSION'],
        //     //         $data['COSTO_ACTUALIZADO'],
        //     //         $devengado_acumulado,
        //     //         $data['DEV_ANO_VIGENTE'],
        //     //         $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $data['DEV_ANO_VIGENTE'],
        //     //         $data['PIM_ANO_VIGENTE'],
        //     //         $programacion_anio_1,
        //     //         $programacion_anio_2,
        //     //         $programacion_anio_3,
        //     //         date('Y-m-d', (filter_var($data['FECHA_ET'], FILTER_SANITIZE_NUMBER_INT))/1000),
        //     //         $total_actualizadof12,
        //     //         $data['PIM_ANO_VIGENTE'] - $total_actualizadof12,
        //     //         $monto_anulado,
        //     //         $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $total_actualizadof12,
        //     //         $data['PIM_ANO_VIGENTE'] - $monto_anulado,
        //     //         $pmi,
        //     //     );
        //     // }else{
        //     //     $data1 = array (
        //     //         $this->uei($data['DES_UNIDAD_UEI']),
        //     //         $data['CODIGO_UNICO'],
        //     //         $data['NOMBRE_INVERSION'],
        //     //         $data['COSTO_ACTUALIZADO'],
        //     //         $devengado_acumulado,
        //     //         $data['DEV_ANO_VIGENTE'],
        //     //         $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $data['DEV_ANO_VIGENTE'],
        //     //         $data['PIM_ANO_VIGENTE'],
        //     //         $programacion_anio_1,
        //     //         $programacion_anio_2,
        //     //         $programacion_anio_3,
        //     //         date('Y-m-d', (filter_var($data['FECHA_ET'], FILTER_SANITIZE_NUMBER_INT))/1000),
        //     //         $total_actualizadof12,
        //     //         $data['PIM_ANO_VIGENTE'] - $total_actualizadof12,
        //     //         $monto_credito,
        //     //         $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $total_actualizadof12,
        //     //         $data['PIM_ANO_VIGENTE'] - $monto_anulado,
        //     //         $pmi,
        //     //     );
        //     // }
        // }]
        // return $data1;

    }

    public function uei($unidad_ejecutora){
        
        $uei = "";
        $auei = "";
        if(strpos($unidad_ejecutora,'INFRAESTRUCTURA') > 0){
            $uei = 'GERENCIA REGIONAL DE INFRAESTRUCTURA';
            $auei = 'GRI';
        }else if(strpos($unidad_ejecutora,'TRANSPORTES Y COMUNICACIONES') > 0){
            $uei = 'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES';
            $auei = 'DRTC';
        }else if(strpos($unidad_ejecutora,'RECURSOS NATURALES') > 0){
            $uei = 'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE';
            $auei = 'GRRNGMA';
        }else if(strpos($unidad_ejecutora,'ECONOMICO') > 0){
            $uei = 'GERENCIA REGIONAL DE DESARROLLO ECONOMICO';
            $auei = 'GRDE';
        }else if(strpos($unidad_ejecutora,'SOCIAL') > 0){
            $uei = 'GERENCIA REGIONAL DE DESARROLLO SOCIAL';
            $auei = 'GRDS';
        }else if(strpos($unidad_ejecutora,'AGRICULTURA') > 0){
            $uei = 'DIRECCION REGIONAL DE AGRICULTURA';
            $auei = 'DRAL';
        }else if(strpos($unidad_ejecutora,'LIMA SUR') > 0){
            $uei = 'GERENCIA SUB REGIONAL LIMA SUR';
            $auei = 'GSRLS';
        }else{
            $uei = 'SIN UEI';
            $auei = 'SIN UEI';
        }    
        return $auei;
    }

    public function data_et($codigo){
        $opciones = array(
           'http' => array(
                        'method'  => "GET",
                        'ignore_errors' => true
                    ),
            'ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
            ),
        );
        $context  = stream_context_create($opciones);
        $response_brecha = file_get_contents("https://ofi5.mef.gob.pe/invierte/ejecucion/verFichaEjecucion/".$codigo,false,$context);
        $mystring = $response_brecha;
        $cantidad = strlen($mystring);
        $findme   = "C. Datos de la fase de Ejecución; durante la ejecución física";
        $inicio = strpos($mystring, $findme);
        $tabla = null;
        $tabla_b = null;
        $findme_b  = ["B. Datos en la fase de Ejecución","B. Datos de la fase de Ejecución"];
        if(strpos($mystring, $findme_b[0]) !== false){
            $inicio_b = strpos($mystring, $findme_b[0]);
        }else if (strpos($mystring, $findme_b[1]) !== false){
            $inicio_b = strpos($mystring, $findme_b[1]);
        }else{
            $inicio_b = false;
        }

        if ($inicio !== false) {
            $cortado = substr($mystring,$inicio,$cantidad);
            $cortado_cantidad = strlen($cortado);
            $inicio_tabla = strpos($cortado, "<table");
            $fin_tabla = strpos($cortado, "</table");
            $tabla = substr($cortado,$inicio_tabla,$fin_tabla - $inicio_tabla + 10);
            if ($inicio_b !== false) {
                $cortado = substr($mystring,$inicio_b,$cantidad);
                $cortado_cantidad = strlen($cortado);
                $inicio_tabla = strpos($cortado, "<table");
                $fin_tabla = strpos($cortado, "</table");
                $tabla_b = substr($cortado,$inicio_tabla,$fin_tabla - $inicio_tabla + 10);
            }
            $text= "Cuenta con ET";
        } else {
            if ($inicio_b !== false) {
                $cortado = substr($mystring,$inicio_b,$cantidad);
                $cortado_cantidad = strlen($cortado);
                $inicio_tabla = strpos($cortado, "<table");
                $fin_tabla = strpos($cortado, "</table");
                $tabla_b = substr($cortado,$inicio_tabla,$fin_tabla - $inicio_tabla + 10);
            }else{
                $text= "No cuenta con ET";
            }
        }
        
        $et=[];
        $et = $this->expediente($tabla,12,8);
        if($et['et'] == 'SIN ET'){
            $et = $this->expediente($tabla_b,9,3);
        }
        return ($et);
    }

    public function expediente($tabla,$colHeader,$colFooter){
        if (!empty($tabla)) {
            $DOM = new \DOMDocument();
            $DOM->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $tabla);
            $tr = $DOM->getElementsByTagName('tr');

            // $Detail = $DOM->getElementsByTagName('td');
            // $td = $tr[4]->getElementsByTagName('td');
            $Detail = [];
            $Footer = [];
            $aDataTableHeaderHTML = $colHeader;
            $aDataTableFooterHTML = $colFooter;
    
            foreach($tr as $key=>$Nodetr){
                if($Nodetr->getElementsByTagName('td')->length == $aDataTableHeaderHTML){
                    $Detail[] = $Nodetr->getElementsByTagName('td');
                }else if($Nodetr->getElementsByTagName('td')->length == $aDataTableFooterHTML){
                    $Footer[] = $Nodetr->getElementsByTagName('td');
                }
            }

            $i = 0;
            $j = 0;
            $aDataTableDetailHTML = [];        
            foreach($Detail as $sNodeDetail){
                foreach($sNodeDetail as $item){
                    $er = $item->getElementsByTagName('a');
                    if($er->length > 0 && $er[0]->hasAttribute('href')){ 
                        $ed = $er[0]->getAttribute('href');
                        $aDataTableDetailHTML[$j][] = trim("https://ofi5.mef.gob.pe".$ed)."||".trim($item->textContent);
                    }else{
                        $aDataTableDetailHTML[$j][] = trim($item->textContent);
                    }
                    $i = $i + 1;
                    $j = $i % $aDataTableHeaderHTML == 0 ? $j + 1 : $j;
                }
                
            }
            
            $i = 0;
            $j = 0;
            $aDataTablePieHTML = [];
            foreach($Footer as $sNodeFooter){
                foreach($sNodeFooter as $item){
                    $er = $item->getElementsByTagName('a');
                    if($er->length > 0 && $er[0]->hasAttribute('href')){ 
                        $ed = $er[0]->getAttribute('href');
                        $aDataTablePieHTML[$j][] = trim("https://ofi5.mef.gob.pe".$ed)."||".trim($item->textContent);
                    }else{
                        $aDataTablePieHTML[$j][] = trim($item->textContent);
                    }
                    $i = $i + 1;
                    $j = $i % $aDataTableFooterHTML == 0 ? $j + 1 : $j;
                }
            }

            //Obtemos Nombre y Enlace
            $array_et = [];
            if (count($aDataTableDetailHTML) > 0){
                foreach($aDataTableDetailHTML as $row){
                    if(isset($row[$colHeader-1])){
                        $array_et[]  = trim($row[$colHeader-1]);
                    }
                }
            }

            if (count($aDataTablePieHTML) > 0){
                foreach($aDataTablePieHTML as $row){
                    if(isset($row[$colFooter-1])){
                        $array_et[]  = trim($row[$colFooter-1]);
                    }
                }
            }

            $array_et_conjunto = []; // array a probar
            $resultado = array_filter(array_unique($array_et));
            $et_final = [];
            if (count($resultado) > 0){
                foreach($resultado as $key=>$row){
                    $url = explode('||',$row)[0];
                    $nombre_et = explode('||',$row)[1];
                    $fecha = str_replace("/","-",rtrim(explode('(',trim($nombre_et))[1],')'));
                    $nombre = explode('(',trim($nombre_et))[0];
                    $fecha = new DateTime($fecha);
                    $fecha = $fecha->format('Y-m-d');  
                    $array_et_conjunto[] =  array('et' => trim($nombre_et),'nombre' => trim($nombre),'fecha'  => $fecha,'id'  => $key,'url'  => $url);
                }
                $re = '/(?:(?:(\AR.{1,})[\s\S](N(°|º))[\s\S]|(\AN(°|º))[\s\S])(\d{1,})(.)(\d{1,})|(?:(\AR.{1,})|(\A\d{1,})(.)(\d{1,})))/i';
                $count_et = [];
                foreach($array_et_conjunto as $key=>$row){
                    $string = $row['et'];
                    $res = preg_match($re, $string, $matches);
                    if($res > 0){
                        $count_et[] = $key;
                    }
                }
                if(count($count_et) > 1){
                    $array = [];
                    foreach($count_et as $key=>$row){
                        $array [] = $array_et_conjunto[$row];
                    }
                    usort($array, function ($a, $b) {
                        return strcmp($a["fecha"], $b["fecha"]);
                    });
                    // $et_final = end($array)['et'];
                    $et_final = array('et' => end($array)['et'],'nombre' => end($array)['nombre'],'fecha'  => end($array)['fecha'],'url'  => end($array)['url']);
                }elseif(count($count_et) == 1){
                    $et_final = array('et' => $array_et_conjunto[$count_et[0]]['et'],'nombre' => $array_et_conjunto[$count_et[0]]['nombre'],'fecha'  => $array_et_conjunto[$count_et[0]]['fecha'],'url'  => $array_et_conjunto[$count_et[0]]['url']);
                }else{
                    $et_final = array('et' => "SIN ET");
                }
            }else{
                $et_final = array('et' => "SIN ET");
            }
            return $et_final;
        }else{
            $et=[];
            $et = array('et' => "SIN ET");
            return $et;
        }
    }

    public function data_mp($codigo,$anulacion,$credito,$nombre_informe){

        // Dato del SSI
        $data = array ('id' => $codigo, 'tipo' => 'SIAF');
        $data = http_build_query($data);
        $opciones = array(
            'http' => array(
                'header' => "Content-Type:application/x-www-form-urlencoded; charset=UTF-8\r\n".
                            "Content-Length: ".strlen($data)."\r\n".
                            "User-Agent:Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36 OPR/77.0.4054.277\r\n".
                            "Host: www.regionlima.gob.pe\r\n".
                            "Origin: http://ofi5.mef.gob.pe",
                'method'  => "POST",
                'content' => $data,
            ),
            'ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
            ),
        );
        $contexto = stream_context_create($opciones);
        $response = file_get_contents("https://ofi5.mef.gob.pe/inviertews/Dashboard/traeDetInvSSI",false, $contexto);

        // Dato del PMI
        $data_pmi = array ('txtCodigoUnico' => $codigo, 'ddlSector' => '');
        $data_pmi = http_build_query($data_pmi);
        $opciones_pmi = array(
            'http' => array(
                'header' => "Content-Type:application/x-www-form-urlencoded; charset=UTF-8\r\n".
                            "Content-Length: ".strlen($data_pmi)."\r\n".
                            "User-Agent:Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36 OPR/77.0.4054.277\r\n".
                            "Host: www.regionlima.gob.pe\r\n".
                            "Origin: http://ofi5.mef.gob.pe",
                'method'  => "POST",
                'content' => $data_pmi,
            ),
            'ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
            ),
        );
        $contexto_pmi = stream_context_create($opciones_pmi);
        $response_pmi = file_get_contents("http://ofi5.mef.gob.pe/invierte/Pmi/traeListaCarteraSector",false, $contexto_pmi);
        
        // Formato 12B
        $data_f12b = array ('id' => $codigo);
        $data_f12b = http_build_query($data_f12b);
        $opciones_f12b = array(
            'http' => array(
                'header' => "Content-Type:application/x-www-form-urlencoded; charset=UTF-8\r\n".
                            "Content-Length: ".strlen($data_f12b)."\r\n".
                            "User-Agent:Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36 OPR/77.0.4054.277\r\n".
                            "Host: www.regionlima.gob.pe\r\n".
                            "Origin: http://ofi5.mef.gob.pe",
                'method'  => "POST",
                'content' => $data_f12b,
            ),
            'ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
            ),
        );
        $contexto_f12b = stream_context_create($opciones_f12b);
        $response_f12b = file_get_contents("http://ofi5.mef.gob.pe/inviertews/Dashboard/traeInformF12B_CU",false, $contexto_f12b);
        
        // A JSON
        $response = json_decode($response, true);
        $response_pmi = json_decode($response_pmi, true);
        $response_f12b = json_decode($response_f12b, true);

        $dataPry = array ();
        $monto_anulado = empty($anulacion)? 0 : $anulacion;
        $monto_credito = empty($credito)? 0 : $credito;
        
        foreach($response as $data){
            $devengado_acumulado = 0;
            $programacion_anio_0 = 0;
            $programacion_anio_1 = 0;
            $programacion_anio_2 = 0;
            $programacion_anio_3 = 0;
            $total_actualizadof12 = 0;
            //PMI
            $pmi = "SI";
            $res_pmi = "SI";
            if(count($response_pmi) == 1){
                foreach($response_pmi as $pmi){
                    $devengado_acumulado = $pmi['DEVENGADO_ACUMULADO'];
                    $programacion_anio_0 = $pmi['PROGRAMACION_INVERSION_ANIO0'];
                    $programacion_anio_1 = $pmi['PROGRAMACION_INVERSION_ANIO1'];
                    $programacion_anio_2 = $pmi['PROGRAMACION_INVERSION_ANIO2'];
                    $programacion_anio_3 = $pmi['PROGRAMACION_INVERSION_ANIO3'];
                }
                $pmi = "SI";
                $res_pmi = "SI CUMPLE";
            }else{
                $devengado_acumulado = $data['DEV_ACUMULADO'];
                $pmi = "NO";
                $res_pmi = "NO CUMPLE";
            }

            //FORMATO 12B Y //¿TIENE FORMATO 12-B REGISTRADO Y ACTUALIZADO?
            $etapa = "";
            $res_f12b = "SI CUMPLE";
            $res_monto = 0;
            if(count($response_f12b) == 1){
                foreach($response_f12b as $f12b){
                    $total_actualizadof12 = $f12b['MONTO_ACTUALIZADO_1'] + $f12b['MONTO_ACTUALIZADO_2'] + $f12b['MONTO_ACTUALIZADO_3'] + $f12b['MONTO_ACTUALIZADO_4'] + $f12b['MONTO_ACTUALIZADO_5'] + $f12b['MONTO_ACTUALIZADO_6'] + $f12b['MONTO_ACTUALIZADO_7'] + $f12b['MONTO_ACTUALIZADO_8'] + $f12b['MONTO_ACTUALIZADO_9'] + $f12b['MONTO_ACTUALIZADO_10'] + $f12b['MONTO_ACTUALIZADO_11'] + $f12b['MONTO_ACTUALIZADO_12'];
                    if(count($f12b['listaDEV']) >= 2){
                        $etapa = "METAS";
                    }else{
                        $etapa = "INTEGRAL";
                    }
                    $date = strftime("%Y-%m-%d",$f12b['FECHA_ULT_ACT_F12B']/1000);
                    $mes = date("m");
                    $mes_f12b = date("m",strtotime($date)); 
                    if($mes_f12b ==  $mes){
                        $res_f12b = "SI CUMPLE";
                    }else{
                        $res_f12b = "NO CUMPLE";
                    }
                    
                }
            }else{
                $res_f12b = "NO CUMPLE";
            }
            //TIPO DE INVERSION
            $tipo_proyecto = '';
            $anio_et_vigencia = 0;
            if($data['TIPO_FORMATO'] == 'PROYECTO DE INVERSION'){
                $tipo_proyecto = 'PIP';
                $anio_et_vigencia = 3;
            }else if($data['TIPO_FORMATO'] == 'IOARR'){
                $tipo_proyecto = 'IOARR';
                $anio_et_vigencia = 1;
            }else if($data['TIPO_FORMATO'] == 'NO PIP'){
                $tipo_proyecto = 'NO PIP';
            }else if($data['TIPO_FORMATO'] == 'RCC'){
                $tipo_proyecto = 'RCC';
            }

            if($data['TIP_EMERGENCIA'] == "7D EMERGENCIA NACIONAL"){
                $tipo_proyecto=$tipo_proyecto . " - 7D";
                $pmi = "7D";
                $res_pmi = "SI CUMPLE";
            }

            //¿ESTA VIABLE O APROBADA?
            $res_viable = 'SI CUMPLE';
            $fecha_viable = null; 
            if ($data['SITUACION'] == 'VIABLE' || $data['SITUACION'] == 'APROBADA') {
                $res_viable = 'SI CUMPLE';
                $fecha_viable = date('Y-m-d', (filter_var($data['FEC_VIABLE'], FILTER_SANITIZE_NUMBER_INT))/1000);
            } else {
                $res_viable = 'NO CUMPLE';
            }

            //¿ESTA ACTIVO?
            $res_activo = 'SI CUMPLE';
            if ($data['ESTADO'] == 'ACTIVO') {
                $res_viable = 'SI CUMPLE';
            } else {
                $res_activo = 'NO CUMPLE';
            }

            //¿ESTA EN ETAPA DE EJECUCION?
            $res_ejecucion = 'SI CUMPLE';
            $avance = 0; 
            if($data['COSTO_ACTUALIZADO'] != 0){
                $avance = ($data['DEV_ACUMULADO']/$data['COSTO_ACTUALIZADO'])*100;
            }
            if ($data['ET_REGISTRADO'] == 'SI') {
                $res_ejecucion = 'SI CUMPLE';
            }else {
                if ($avance >= 10) {
                    $res_ejecucion = 'SI CUMPLE';
                }else{
                    $res_ejecucion = 'NO CUMPLE';
                }
            }

            //¿CUENTA CON EXPEDIENTE TECNICO O DOCUMENTO EQUIVALENTE APROBADO Y REGISTRADO? MODIFICAR
            $siet = PipTotalPriori::select('exptec_pdf','f_exptec')->where('cod_unif',$codigo)->first();
            if(!empty($siet) && $siet->exptec_pdf != "SIN ET"){
                $et =  array('et' => trim($siet->exptec_pdf) . " (" . $siet->f_exptec .")",'fecha'  => $siet->f_exptec);
            }else{
                $et = $this->data_et($codigo);
            }

            $url_et = Null;
            $res_et = 'SI CUMPLE';
            $nombre_resolucion_et = null;
            if($et['et'] != "SIN ET"){
                $res_et = 'SI CUMPLE';
                $nombre_resolucion_et = $et['et'];
                $url_et = "https://ofi5.mef.gob.pe/invierte/ejecucion/verFichaEjecucion/" . $codigo;
                $fecha = date( $et['fecha']);
                $fecha_actual = date("Y-m-d");
                $fecha_vencimiento = date("Y-m-d",strtotime($fecha."+ ".$anio_et_vigencia." year"));
                if($fecha_actual > $fecha_vencimiento){
                    $res_et = 'NO CUMPLE';
                }else{
                    $res_et = 'SI CUMPLE';
                }
            }else{
                $res_et = 'NO CUMPLE';
            }

            //¿RESPETA LOS CRITERIOS DE CONTINUIDAD? 
            $res_continuidad = 'SI CUMPLE';
            if($programacion_anio_2 > 0){
                $res_continuidad = 'SI CUMPLE';
            }else{
                $res_continuidad = 'NO CUMPLE';
            }
            
            //¿TIENE PENDIENTE PROCESO DE CAMBIO DE UNIDAD EJECUTORA?
            if ($monto_anulado != 0 ){
                $dataPry = array (
                    $this->uei($data['DES_UNIDAD_UEI']), //UNIDAD EJECUTO 0
                    $data['CODIGO_UNICO'], //CODIGO UNICO 1
                    $data['NOMBRE_INVERSION'], //NOMBRE DE INVERSION 2
                    $data['COSTO_ACTUALIZADO'], //COSTO ACTUALIZADO 3
                    $devengado_acumulado, //DEVENGADO ACUMULADO 4
                    $data['DEV_ANO_VIGENTE'], //DEVENGADO AÑO FISCAL 5
                    $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $data['DEV_ANO_VIGENTE'], //SALDO POR EJECUTAR AÑO FISCAL 6
                    $data['PIM_ANO_VIGENTE'], //PIM AÑO FISCAL 7
                    $programacion_anio_1, //MONTO PMI 2022 8
                    $programacion_anio_2, //MONTO PMI 2023 9
                    $programacion_anio_3, //MONTO PMI 2024 10
                    $nombre_resolucion_et, //NOMBRE EXPEDIENTE TECNICO 11
                    $total_actualizadof12, //COMPROMISOS A REALIZAR AÑO FISCAL(MONTO TOTAL PROGRAMADO F12B) 12
                    $data['PIM_ANO_VIGENTE'] - $total_actualizadof12, //SALDO DEL PIM AÑO FISCAL 13
                    $monto_anulado, //MONTO ANULADO 14
                    $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $total_actualizadof12, //NUEVO SALDO DE INVERSION  15
                    $data['PIM_ANO_VIGENTE'] - $monto_anulado, //PIM AÑO FISCAL MODIFICADO 16
                    $pmi, //SE ENCUENTRA EN LA CARTERA DEL PMI 17
                    $tipo_proyecto, //TIPO DE PROYECTO 18
                    $data['ESTADO'], //ESTADO ACTIVO O NO 19
                    $data['SITUACION'], //SITUACION VIABLE O NO 20
                    $etapa, //METAS O INTEGRAL 21
                    $res_pmi, //¿ESTA EN EL PMI 2021-2023?  22
                    $programacion_anio_0, //MONTO AÑO FISCAL PMI 23
                    $res_viable, //¿ESTA VIABLE O APROBADA? 24
                    $fecha_viable, //FECHA DE VIABILIDAD 25
                    $res_activo, //¿ESTA ACTIVO? 26
                    $res_ejecucion, //¿ESTA EN ETAPA DE EJECUCION? 27
                    $avance, //AVANCE 28
                    $res_et, //¿CUENTA CON EXPEDIENTE TECNICO O DOCUMENTO EQUIVALENTE APROBADO Y REGISTRADO? 29
                    $url_et, //URL EXPEDIENTE TECNICO 30
                    "NO APLICA", //¿RESPETA LOS CRITERIOS DE CONTINUIDAD? 31
                    "NO APLICA", //¿TIENE PENDIENTE PROCESO DE CAMBIO DE UNIDAD EJECUTORA? 32
                    $res_f12b, //¿TIENE FORMATO 12-B REGISTRADO Y ACTUALIZADO? 33
                    "NO APLICA", //MONTO DE CREDITO NO DEBE EXCEDER AL MONTO ANULADO 34
                    $nombre_informe, //MONTO ANULADO NO SUPERA EL MAX.ANULADO 35
                    "NO APLICA", //NO PRESENTA DUPLICIDAD DE INVERSIONES. 36
                    "NO APLICA", //¿CUENTA CON SANEAMIENTO FISICO LEGAL O ARREGLOS INSTITUCIONALES? 37
                    "NO APLICA", //INTERVENCION INTEGRAL, NO FRACCIONAMIENTO. 38
                    "NO APLICA", //¿ENTIDAD EJECUTORA CUENTA CON LAS COMPETENCIAS CORRESPONDIENTES? 39
                    "VERIFICAR POR EL USUARIO", //EXISTE IMPEDIMENTO COMPROBABLE QUE RETRASE/INVIABLE O SE ENCUENTRE CULMINADA 40
                    $data['DEV_ACUMULADO'] //DEVENGADO ACUMULADO SSI 41
                );
            }else{
                $dataPry = array (
                    $this->uei($data['DES_UNIDAD_UEI']), //UNIDAD EJECUTO 0
                    $data['CODIGO_UNICO'], //CODIGO UNICO 1
                    $data['NOMBRE_INVERSION'], //NOMBRE DE INVERSION 2
                    $data['COSTO_ACTUALIZADO'], //COSTO ACTUALIZADO 3
                    $devengado_acumulado, //DEVENGADO ACUMULADO 4
                    $data['DEV_ANO_VIGENTE'], //DEVENGADO AÑO FISCAL 5
                    $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $data['DEV_ANO_VIGENTE'], //SALDO POR EJECUTAR AÑO FISCAL 6
                    $data['PIM_ANO_VIGENTE'], //PIM AÑO FISCAL 7
                    $programacion_anio_1, //MONTO PMI 2022 8
                    $programacion_anio_2, //MONTO PMI 2023 9
                    $programacion_anio_3, //MONTO PMI 2024 10
                    $nombre_resolucion_et, //NOMBRE EXPEDIENTE TECNICO 11
                    $total_actualizadof12, //COMPROMISOS A REALIZAR AÑO FISCAL(MONTO TOTAL PROGRAMADO F12B) 12
                    $data['PIM_ANO_VIGENTE'] - $total_actualizadof12, //SALDO DEL PIM AÑO FISCAL 13
                    $monto_credito,  //MONTO DE CREDITO 14
                    $data['COSTO_ACTUALIZADO'] - $devengado_acumulado - $total_actualizadof12, //NUEVO SALDO DE INVERSION  15
                    $data['PIM_ANO_VIGENTE'] + $monto_credito, //PIM AÑO FISCAL MODIFICADO 16
                    $pmi, //SE ENCUENTRA EN LA CARTERA DEL PMI 17
                    $tipo_proyecto, //TIPO DE PROYECTO 18
                    $data['ESTADO'], //ESTADO ACTIVO O NO 19
                    $data['SITUACION'], //SITUACION VIABLE O NO 20
                    $etapa, //METAS O INTEGRAL 21
                    $res_pmi, //¿ESTA EN EL PMI 2021-2023?  22
                    $programacion_anio_0, //MONTO AÑO FISCAL PMI 23
                    $res_viable, //¿ESTA VIABLE O APROBADA? 24
                    $fecha_viable, //FECHA DE VIABILIDAD 25
                    $res_activo, //¿ESTA ACTIVO? 26
                    $res_ejecucion, //¿ESTA EN ETAPA DE EJECUCION? 27
                    $avance, //AVANCE 28
                    $res_et, //¿CUENTA CON EXPEDIENTE TECNICO O DOCUMENTO EQUIVALENTE APROBADO Y REGISTRADO? 29
                    $url_et, //URL EXPEDIENTE TECNICO 30
                    $res_continuidad, //¿RESPETA LOS CRITERIOS DE CONTINUIDAD? 31
                    "VERIFICAR POR EL USUARIO", //¿TIENE PENDIENTE PROCESO DE CAMBIO DE UNIDAD EJECUTORA? 32
                    $res_f12b, //¿TIENE FORMATO 12-B REGISTRADO Y ACTUALIZADO? 33
                    $nombre_informe, //MONTO DE CREDITO NO DEBE EXCEDER AL MONTO ANULADO 34
                    "NO APLICA", //MONTO ANULADO NO SUPERA EL MAX.ANULADO 35
                    "SI CUMPLE", //NO PRESENTA DUPLICIDAD DE INVERSIONES. 36
                    "SI CUMPLE", //¿CUENTA CON SANEAMIENTO FISICO LEGAL O ARREGLOS INSTITUCIONALES? 37
                    "SI CUMPLE", //INTERVENCION INTEGRAL, NO FRACCIONAMIENTO. 38
                    "SI CUMPLE", //¿ENTIDAD EJECUTORA CUENTA CON LAS COMPETENCIAS CORRESPONDIENTES? 39
                    "NO APLICA", //EXISTE IMPEDIMENTO COMPROBABLE QUE RETRASE/INVIABLE O SE ENCUENTRE CULMINADA 40
                    $data['DEV_ACUMULADO'] //DEVENGADO ACUMULADO SSI 41
                );
            }         
        }
        return $dataPry;

        // return Response([
        //     'ssi' => json_decode($response, true),
        //     // 'brechas' => html_entity_decode($tabla),
        //     'pmi' => json_decode($response_pmi, true),
        //     'proyecto' => $proyecto,
        //     'f12b' => json_decode($response_f12b, true),
        // ]);

    }

    public function exportar(Request $request){
        $input = $request->all();
        $nombre_informe = $input['nombre_informe'];
        $data1 = array();
        if(!empty($input['field_name'])){
            foreach($input['field_name'] as $key=>$value){
                $data = array();
                $data = $this->data_mp($value,str_replace(",", "", $input['field_name_anulacion'][$key]),0,$nombre_informe);
                array_push($data1,$data);
            }
        }

        $data2 = array();
        $cui = array();
        if(!empty($input['field_name_credito'])){
            foreach($input['field_name_credito'] as $key=>$value){
                $data = array();
                $data = $this->data_mp($value,0,str_replace(",", "", $input['field_name_monto_credito'][$key]),$nombre_informe);
                array_push($data2,$data);
                array_push($cui,$value);
            }
        }

        // Exportación simplificada para compatibilidad Laravel 6 sin maatwebsite/excel 2.x
        return $this->exportarModificacionSimple($data1, $data2, $cui);
    }

    public function lista(Request $request){
        return view('modificacion_presupuestal.lista_modificacion_presupuestaria');
    }

    // Agregar Modificacion Presupuestal
    public function inicio(){
        return view('modificacion_presupuestal.inicio');
    }

    public function modal_importar(Request $request){
        return view('modificacion_presupuestal.importar')->render();
    }

    function number_exists($table,$id,$data) {
        $cantidad = DB::table($table)->select()->where($id,$data)->count();
        return $cantidad;
    }

    public function importar(Request $request){
        $msg = [];
        $input = $request->all();
        $anio = $input['anio'];
        $formato_excel= ["id_a","ue_a","nombre_pry_a","ff_a","cui_a","tipo_a","costo_actualizacion_a","devengado_acu_a","saldo_ejec_a","pia_a","pim_a","id_doc","memo_grppat","doc_opmi","memo_uei","saldo_anu_a","pim_modificado_a","id_c","ue_c","nombre_pry_c","cui_c","tipo_c","costo_actualizacion_c","devengado_acu_c","saldo_ejec_c","pia_c","pim_c","credito_c","certificacion_c","saldo_balance_c","pim_modificado_c","fecha"];
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data_excel = $this->loadSheetRowsWithHeading($path, 'MP', 5);
            if(count($data_excel) > 0){
                // Columnas
                $headerRow = array_keys($data_excel[0]);
                $resultado = array_diff($formato_excel, $headerRow);
                $data = [];
                $grupo = [];
                if(count($resultado) == 0){
                    foreach ($data_excel as $key => $row) {
                        if(!empty(trim($row['id_doc']))){
                            $grupo[] = trim($row['id_doc']);
                        }
                    }
                    if(count($grupo) == count(array_unique($grupo))){
                        $data=[];
                        foreach ($grupo as $key => $row) {
                            $data_array_anulacion=[];
                            $data_array_credito=[];
                            $data_array_documento=[];
                            $id_r = $row;
                            foreach ($data_excel as $key => $row) {
                                $id_a = trim($row['id_a']);
                                $id_c = trim($row['id_c']);
                                $id_documento = trim($row['id_doc']);
                                if($id_r == $id_a){
                                    $data_a['ue_a'] = trim($row['ue_a']);
                                    $data_a['nombre_pry_a'] = trim($row['nombre_pry_a']);
                                    $data_a['ff_a'] = trim($row['ff_a']);
                                    $data_a['cui_a'] = trim($row['cui_a']);
                                    $data_a['tipo_a'] = trim($row['tipo_a']);
                                    $data_a['costo_actualizacion_a'] = trim($row['costo_actualizacion_a']);
                                    $data_a['devengado_acu_a'] = trim($row['devengado_acu_a']);
                                    $data_a['saldo_ejec_a'] = trim($row['saldo_ejec_a']);
                                    $data_a['pia_a'] = trim($row['pia_a']);
                                    $data_a['pim_a'] = trim($row['pim_a']);
                                    $data_a['saldo_anu_a'] = trim($row['saldo_anu_a']);
                                    $data_a['pim_modificado_a'] = trim($row['pim_modificado_a']);
                                    $data_a['anio'] = $anio;
                                    array_push($data_array_anulacion,$data_a);
                                }
                                if($id_r == $id_c){
                                    $data_c['ue_c'] = trim($row['ue_c']);
                                    $data_c['nombre_pry_c'] = trim($row['nombre_pry_c']);
                                    $data_c['cui_c'] = trim($row['cui_c']);
                                    $data_c['tipo_c'] = trim($row['tipo_c']);
                                    $data_c['costo_actualizacion_c'] = trim($row['costo_actualizacion_c']);
                                    $data_c['devengado_acu_c'] = trim($row['devengado_acu_c']);
                                    $data_c['saldo_ejec_c'] = trim($row['saldo_ejec_c']);
                                    $data_c['pia_c'] = trim($row['pia_c']);
                                    $data_c['pim_c'] = trim($row['pim_c']);
                                    $data_c['credito_c'] = trim($row['credito_c']);
                                    $data_c['certificacion_c'] = trim($row['certificacion_c']);
                                    $data_c['saldo_balance_c'] = trim($row['saldo_balance_c']);
                                    $data_c['pim_modificado_c'] = trim($row['pim_modificado_c']);
                                    $data_c['anio'] = $anio;
                                    array_push($data_array_credito,$data_c);
                                }
                                if($id_r == $id_documento){
                                    $data_doc['memo_grppat'] = trim($row['memo_grppat']);
                                    $data_doc['doc_opmi'] = trim($row['doc_opmi']);
                                    $data_doc['memo_uei'] = trim($row['memo_uei']);
                                    $data_doc['fecha'] = trim($row['fecha']);
                                    $data_doc['anio'] = $anio;
                                    array_push($data_array_documento,$data_doc);
                                }
                            }
                            array_push($data,["anulacion"=>$data_array_anulacion,"credito"=>$data_array_credito,"documento"=>$data_array_documento]);
                        }
                    }
                    //Guardando Informacion
                    foreach ($data as $key => $row) {
                        $data_anulado=$this->array_obj($row["anulacion"]);
                        $data_credito=$this->array_obj($row["credito"]);
                        $data_documento=$row["documento"];
                        if(count($data_anulado) > 0 and count($data_credito) > 0 and count($data_documento) > 0){
                            $doc_OPMI = strtoupper($data_documento[0]["doc_opmi"]);
                            $memo_GRPPAT = strtoupper($data_documento[0]["memo_grppat"]);
                            $memo_UEI = strtoupper($data_documento[0]["memo_uei"]);
                            $fecha = $data_documento[0]["fecha"];
                            $documento = DB::table("tb_mod_documento")->where("doc_opmi",$doc_OPMI)->where("anio",$anio)->first();
                            if(!empty($documento)){
                                array_push($msg,"Documento " . $doc_OPMI . " ya existe.");
                                // return Response(['error' => false,'msg' => $msg],200);
                            }else{
                                //INGRESANDO tb_mod_documento
                                $id = DB::table('tb_mod_documento')->max("id_doc") + 1;
                                $id_documentacion = DB::table('tb_mod_documento')
                                                    ->insertGetId ([
                                                        "id_doc"=>$id,
                                                        "memo_grppat"=>$memo_GRPPAT,
                                                        "doc_opmi"=>$doc_OPMI,
                                                        "memo_uei"=>$memo_UEI,
                                                        "fecha"=> $fecha,
                                                        "anio"=> $anio],"id_doc"
                                                    );
                                $this->guardar_anu_cre($id_documentacion,$data_anulado,$data_credito,$anio);
                                array_push($msg,"Documento " . $doc_OPMI . " Guardado.");
                                // return Response(['error' => false,'msg' => $msg],200);
                            }
                        }else{
                            array_push($msg,"Credito,Anulacion o Documento vacios o erroneos Verificar!.");
                            return Response(['error' => True,'msg' => $msg],500);
                        }
                    }
                    return Response(['error' => false,'msg' => $msg],200);
                    // $array_msg = array_unique($msg);
                    // return Response(['error' => True,'msg' => $msg],500);
                }else{
                    array_push($msg,"Formato Incorrecto");
                    return Response(['error' => True,'msg' => $msg],500);
                }
            }else{
                array_push($msg,"No tiene dato o Hoja invalida, nombrar la hoja a MP");
                return Response(['error' => True,'msg' => $msg],500);
            }
        }else{
            return Response([
                'msg' => $msg,
            ]);
        }
        
    }

    public function array_obj($array){
        $object = json_encode($array);
        $object1 = json_decode($object);
        return $object1;
    }

    private function exportarModificacionSimple(array $data1, array $data2, array $cui)
    {
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Anulacion');
        $sheet1->fromArray([[
            'ue', 'cui', 'nombre_proyecto', 'monto_total', 'devengado', 'saldo_ejec', 'anulacion'
        ]], null, 'A1');
        $row = 2;
        foreach ($data1 as $item) {
            $sheet1->fromArray([[
                isset($item[0]) ? $item[0] : '',
                isset($item[1]) ? $item[1] : '',
                isset($item[2]) ? $item[2] : '',
                isset($item[3]) ? $item[3] : '',
                isset($item[5]) ? $item[5] : '',
                isset($item[7]) ? $item[7] : '',
                isset($item[14]) ? $item[14] : '',
            ]], null, 'A' . $row);
            $row++;
        }

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Credito');
        $sheet2->fromArray([[
            'ue', 'cui', 'nombre_proyecto', 'monto_total', 'devengado', 'saldo_ejec', 'credito'
        ]], null, 'A1');
        $row = 2;
        foreach ($data2 as $item) {
            $sheet2->fromArray([[
                isset($item[0]) ? $item[0] : '',
                isset($item[1]) ? $item[1] : '',
                isset($item[2]) ? $item[2] : '',
                isset($item[3]) ? $item[3] : '',
                isset($item[5]) ? $item[5] : '',
                isset($item[7]) ? $item[7] : '',
                isset($item[14]) ? $item[14] : '',
            ]], null, 'A' . $row);
            $row++;
        }

        foreach ([$sheet1, $sheet2] as $sheet) {
            foreach (range('A', 'G') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        $nombreArchivo = 'MOD_ART13_' . implode('-', $cui) . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $nombreArchivo)->deleteFileAfterSend(true);
    }

    private function loadSheetRowsWithHeading($path, $sheetName, $headingRow)
    {
        $reader = IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);

        if (method_exists($reader, 'setLoadSheetsOnly')) {
            $reader->setLoadSheetsOnly([$sheetName]);
        }

        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getSheetByName($sheetName);
        if (!$worksheet) {
            return [];
        }

        $highestRow = (int) $worksheet->getHighestDataRow();
        $highestColumn = $worksheet->getHighestDataColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        if ($highestRow <= $headingRow || $highestColumnIndex < 1) {
            return [];
        }

        $headers = [];
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $header = trim((string) $worksheet->getCellByColumnAndRow($col, $headingRow)->getValue());
            $header = $this->normalizeSpreadsheetHeader($header);
            if ($header === '') {
                $header = 'col_' . $col;
            }
            $headers[$col] = $header;
        }

        $rows = [];
        for ($row = $headingRow + 1; $row <= $highestRow; $row++) {
            $item = [];
            foreach ($headers as $col => $key) {
                $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $item[$key] = is_null($value) ? '' : $value;
            }
            $rows[] = $item;
        }

        return $rows;
    }

    private function normalizeSpreadsheetHeader($header)
    {
        $header = strtolower(trim($header));
        $header = preg_replace('/[^a-z0-9]+/', '_', $header);
        return trim($header, '_');
    }

    public function consulta_modificacion(Request $request){
        $input = $request->all();

        $inversion = DB::table("vw_inversiones_modificado")
                            ->join("vw_grli_pip_seguimiento_ejecucion_financiera","vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif","vw_inversiones_modificado.cod_unif")
                            ->where('vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif',$input['cod_unif'])
                            ->where("vw_grli_pip_seguimiento_ejecucion_financiera.anio",$input['anio'])->get();

        $doc = DB::table('tb_mod_detalle')->select(DB::RAW("tb_mod_detalle.id_doc"))
                    ->join("tb_mod_anulacion","tb_mod_detalle.id_a","tb_mod_anulacion.id_a")
                    ->join("tb_mod_credito","tb_mod_detalle.id_c","tb_mod_credito.id_c")
                    ->where("cui_a",$input['cod_unif'])
                    ->Orwhere("cui_c",$input['cod_unif'])->first();

        $anulacion = DB::table('tb_mod_anulacion')->select(DB::RAW("tb_mod_credito.*,tb_mod_anulacion.*,tb_mod_documento.*,fecha::date as fecha_doc"))
                    ->join("tb_mod_detalle","tb_mod_anulacion.id_a","tb_mod_detalle.id_a")
                    ->join("tb_mod_documento","tb_mod_detalle.id_doc","tb_mod_documento.id_doc")
                    ->join("tb_mod_credito","tb_mod_detalle.id_c","tb_mod_credito.id_c")
                    ->where("tb_mod_detalle.id_doc",$doc->id_doc)
                    ->where("tb_mod_anulacion.anio",$input['anio'])->OrderBy('doc_opmi')->OrderBy('fecha')->get();

        $credito = DB::table('tb_mod_credito')->select(DB::RAW("tb_mod_anulacion.*,tb_mod_credito.*,tb_mod_documento.*,fecha::date as fecha_doc"))
                    ->join("tb_mod_detalle","tb_mod_credito.id_c","tb_mod_detalle.id_c")
                    ->join("tb_mod_documento","tb_mod_detalle.id_doc","tb_mod_documento.id_doc")
                    ->join("tb_mod_anulacion","tb_mod_detalle.id_a","tb_mod_anulacion.id_a")
                    ->where("tb_mod_detalle.id_doc",$doc->id_doc)
                    ->where("tb_mod_credito.anio",$input['anio'])->OrderBy('doc_opmi')->OrderBy('fecha')->get();

        return Response([
            'anulacion' => $anulacion,
            'credito' => $credito,
            'inversion' => $inversion
        ]);
    }

    public function exportarreporte(Request $request){
        $input = $request->all();

        if(isset($input['tipo'])){
            $inversion = DB::table("vw_inversiones_modificado")
                            ->join("vw_grli_pip_seguimiento_ejecucion_financiera","vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif","vw_inversiones_modificado.cod_unif")
                            ->where('vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif',$input['cod_unif_mod'])
                            ->where("vw_grli_pip_seguimiento_ejecucion_financiera.anio",$input['anio_mod'])
                            ->get();
            

            $anulacion = DB::table('tb_mod_anulacion')->select(DB::RAW("tb_mod_credito.*,tb_mod_anulacion.*,tb_mod_documento.*,fecha::date as fecha_doc"))
                            ->join("tb_mod_detalle","tb_mod_anulacion.id_a","tb_mod_detalle.id_a")
                            ->join("tb_mod_documento","tb_mod_detalle.id_doc","tb_mod_documento.id_doc")
                            ->join("tb_mod_credito","tb_mod_detalle.id_c","tb_mod_credito.id_c")
                            ->where("cui_a",$input['cod_unif_mod'])
                            ->where("tb_mod_anulacion.anio",$input['anio_mod'])->OrderBy('doc_opmi')->OrderBy('fecha')->get();
        
            $credito = DB::table('tb_mod_credito')->select(DB::RAW("tb_mod_anulacion.*,tb_mod_credito.*,tb_mod_documento.*,fecha::date as fecha_doc"))
                            ->join("tb_mod_detalle","tb_mod_credito.id_c","tb_mod_detalle.id_c")
                            ->join("tb_mod_documento","tb_mod_detalle.id_doc","tb_mod_documento.id_doc")
                            ->join("tb_mod_anulacion","tb_mod_detalle.id_a","tb_mod_anulacion.id_a")
                            ->where("cui_c",$input['cod_unif_mod'])
                            ->where("tb_mod_credito.anio",$input['anio_mod'])->OrderBy('doc_opmi')->OrderBy('fecha')->get();
        }
        else{
            $inversion = DB::table("vw_inversiones_modificado")
                            ->join("vw_grli_pip_seguimiento_ejecucion_financiera","vw_grli_pip_seguimiento_ejecucion_financiera.cod_unif","vw_inversiones_modificado.cod_unif")
                            ->where("vw_grli_pip_seguimiento_ejecucion_financiera.anio",$input['anio_mod'])
                            ->OrderBy('tipo','desc')
                            ->OrderBy('vw_inversiones_modificado.cod_unif','asc')
                            ->get();
            $anulacion = DB::table('tb_mod_anulacion')->select(DB::RAW("tb_mod_credito.*,tb_mod_anulacion.*,tb_mod_documento.*,fecha::date as fecha_doc"))
                        ->join("tb_mod_detalle","tb_mod_anulacion.id_a","tb_mod_detalle.id_a")
                        ->join("tb_mod_documento","tb_mod_detalle.id_doc","tb_mod_documento.id_doc")
                        ->join("tb_mod_credito","tb_mod_detalle.id_c","tb_mod_credito.id_c")
                        ->where("tb_mod_anulacion.anio",$input['anio_mod'])->OrderBy('doc_opmi')->OrderBy('fecha')->get();

            $credito = DB::table('tb_mod_credito')->select(DB::RAW("tb_mod_anulacion.*,tb_mod_credito.*,tb_mod_documento.*,fecha::date as fecha_doc"))
                        ->join("tb_mod_detalle","tb_mod_credito.id_c","tb_mod_detalle.id_c")
                        ->join("tb_mod_documento","tb_mod_detalle.id_doc","tb_mod_documento.id_doc")
                        ->join("tb_mod_anulacion","tb_mod_detalle.id_a","tb_mod_anulacion.id_a")
                        ->where("tb_mod_credito.anio",$input['anio_mod'])->OrderBy('doc_opmi')->OrderBy('fecha')->get();
        }

        return response()
        ->view("modificacion_presupuestal.template.mod_presupuestal", ['anulacion'=>$anulacion,'credito'=>$credito,'inversion'=>$inversion], 200)
        ->header('Content-Description', 'File Transfer')
        ->header('Content-Type', 'text/html; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename=INVERSIONES_FF.xls')
        ->header('Content-Transfer-Encoding', 'binary')
        ->header('Connection', 'Keep-Alive')
        ->header('Expires', '0')
        ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
        ->header('Pragma', 'public');

    }

    public function buscarproyecto(Request $request){
        $input = $request->all();
        $cod_unif = $input['codigo_unif'];
        $proyecto = DB::table("vw_total_proyectos_mp")->where("cod_unif",$cod_unif)->first();
        return Response([
            'proyecto' => $proyecto,
        ]);
    }

    public function guardar(Request $request){
        $input = $request->all();
        $doc_OPMI = strtoupper($input['doc_OPMI']);
        $memo_GRPPAT = strtoupper($input['memo_GRPPAT']);
        $memo_UEI = $input['memo_UEI'];
        $fecha = $input['fecha'];
        $anio = $input['anio'];
        $data_anulado = json_decode($input['data_anulado']);
        $data_credito = json_decode($input['data_credito']);
        $opcion= $input['opcion'];
        $id_documento= $input['id_documento'];

        if($opcion=="GUARDAR"){
            $documento = DB::table("tb_mod_documento")->where("doc_opmi",$doc_OPMI)->where("anio",$anio)->first();
            if(!empty($documento)){
                return Response(['error' => True,'msg' => "Documento OPMI ya esta registrado"],500);
            }else{
                //INGRESANDO tb_mod_documento
                $id = DB::table('tb_mod_documento')->max("id_doc") + 1;
                $id_documentacion = DB::table('tb_mod_documento')
                                    ->insertGetId ([
                                        "id_doc"=>$id,
                                        "memo_grppat"=>$memo_GRPPAT,
                                        "doc_opmi"=>$doc_OPMI,
                                        "memo_uei"=>$memo_UEI,
                                        "fecha"=> $fecha,
                                        "anio"=> $anio],"id_doc"
                                    );
                $this->guardar_anu_cre($id_documentacion,$data_anulado,$data_credito,$anio);
                return Response(['error' => false],200);
            }
        }else{
            $documento = DB::table("tb_mod_documento")->where("id_doc",$id_documento)->value("doc_opmi");
            if($doc_OPMI == $documento){
                //Eliminamos los datos de la tabla credito y anulacion
                $tb_mod_detalle = DB::table("tb_mod_detalle")->where("id_doc",$id_documento)->get();
                foreach($tb_mod_detalle as $row){
                    //Eliminar datos del detalle
                    DB::table("tb_mod_detalle")->where("id_detalle",$row->id_detalle)->delete();
                    //Si el id de la anulacion no esta vacia
                    if(!empty($row->id_a)){
                        DB::table("tb_mod_anulacion")->where("id_a",$row->id_a)->delete();
                    }
                    //Si el id del credito no esta vacia
                    if(!empty($row->id_c)){
                        DB::table("tb_mod_credito")->where('id_c',$row->id_c)->delete();
                    }
                }
                //Guardando los Datos
                //Actualiza el Nombre del Documento
                DB::table("tb_mod_documento")->where("id_doc", $id_documento)->update([
                    "memo_grppat"=>$memo_GRPPAT,
                    "doc_opmi"=>$doc_OPMI,
                    "memo_uei"=>$memo_UEI,
                    "fecha"=> $fecha,
                    "anio"=> $anio]);
                $this->guardar_anu_cre($id_documento,$data_anulado,$data_credito,$anio);
                return Response(['error' => false],200);
            }else{
                $documento = DB::table("tb_mod_documento")->where("doc_opmi",$doc_OPMI)->where("anio",$anio)->first();
                if(!empty($documento)){
                    return Response(['error' => True,'msg' => "Documento OPMI ya esta registrado"],500);
                }else{
                    //INGRESANDO tb_mod_documento
                    $id = DB::table('tb_mod_documento')->max("id_doc") + 1;
                    $id_documentacion = DB::table('tb_mod_documento')
                                        ->insertGetId ([
                                            "id_doc"=>$id,
                                            "memo_grppat"=>$memo_GRPPAT,
                                            "doc_opmi"=>$doc_OPMI,
                                            "memo_uei"=>$memo_UEI,
                                            "fecha"=> $fecha,
                                            "anio"=> $anio],"id_doc"
                                        );
                    $this->guardar_anu_cre($id_documentacion,$data_anulado,$data_credito,$anio);
                    return Response(['error' => false],200);
                }
            }
        }
    }

    public function guardar_anu_cre($id_documentacion,$data_anulado,$data_credito,$anio){
        $array_detalle = array();
        //INGRESANDO tb_mod_anulacion  
        $array_id_anulacion = array();
        foreach($data_anulado  as $key=>$row ){
            $id_a = DB::table('tb_mod_anulacion')->max("id_a") + 1;
            $tipo_proyecto= null;
            if(!empty($row->tipo_a)){
                if($row->tipo_a = "PIP"){
                    $tipo_proyecto= "PROYECTO DE INVERSION";
                }else{
                    $tipo_proyecto= $row->tipo_a;
                }
            }else{
                $tipo_proyecto= null;
            }
            $id_anulacion = DB::table('tb_mod_anulacion')->insertGetId(
            [
                "id_a" => $id_a,
                "ue_a" => empty($row->ue_a) ? null : $row->ue_a,
                "nombre_pry_a" => empty($row->nombre_pry_a) ? null : strtoupper($row->nombre_pry_a),
                "ff_a" => empty($row->ff_a) ? null : $row->ff_a,
                "cui_a" => empty($row->cui_a) ? null : $row->cui_a,
                "tipo_a" => $tipo_proyecto,
                "costo_actualizacion_a" => empty($row->costo_actualizacion_a) ? 0 : $row->costo_actualizacion_a,
                "devengado_acu_a" => empty($row->devengado_acu_a) ? 0 : $row->devengado_acu_a,
                "saldo_ejec_a" => empty($row->saldo_ejec_a) ? 0 : $row->saldo_ejec_a,
                "pia_a" => empty($row->pia_a) ? 0 : $row->pia_a,
                "pim_a" => empty($row->pim_a) ? 0 : $row->pim_a,
                "saldo_anu_a" => empty($row->saldo_anu_a) ? 0 : $row->saldo_anu_a,
                "pim_modificado_a" => empty($row->pim_modificado_a) ? 0 : $row->pim_modificado_a,
                "anio" => empty($anio) ? null : $anio,
            ],"id_a");   
            array_push($array_id_anulacion,$id_anulacion);     
        }
        //INGRESANDO tb_mod_credito  
        $array_id_credito = array();
        foreach($data_credito  as $key=>$row ){
            $tipo_proyecto= null;
            $id_c = DB::table('tb_mod_credito')->max("id_c") + 1;
            if(!empty($row->tipo_c)){
                if($row->tipo_c = "PIP"){
                    $tipo_proyecto= "PROYECTO DE INVERSION";
                }else{
                    $tipo_proyecto= $row->tipo_a;
                }
            }else{
                $tipo_proyecto= null;
            }
            $id_credito = DB::table('tb_mod_credito')->insertGetId(
            [
                "id_c" => $id_c,
                "ue_c" => empty($row->ue_c) ? null : $row->ue_c,
                "nombre_pry_c" => empty($row->nombre_pry_c) ? null : strtoupper($row->nombre_pry_c),
                "cui_c" => empty($row->cui_c) ? null : $row->cui_c,
                "tipo_c" => $tipo_proyecto,
                "costo_actualizacion_c" => empty($row->costo_actualizacion_c) ? 0 : $row->costo_actualizacion_c,
                "devengado_acu_c" => empty($row->devengado_acu_c) ? 0 : $row->devengado_acu_c,
                "saldo_ejec_c" => empty($row->saldo_ejec_c) ? 0 : $row->saldo_ejec_c,
                "pia_c" => empty($row->pia_c) ? 0 : $row->pia_c,
                "pim_c" => empty($row->pim_c) ? 0 : $row->pim_c,
                "credito_c" => empty($row->credito_c) ? 0 : $row->credito_c,
                "certificacion_c" => empty($row->certificacion_c) ? 0 : $row->certificacion_c,
                "saldo_balance_c" => empty($row->saldo_balance_c) ? 0 : $row->saldo_balance_c,
                "pim_modificado_c" => empty($row->pim_modificado_c) ? 0 : $row->pim_modificado_c,
                "anio" => empty($anio) ? null : $anio,
            ],"id_c");   
            array_push($array_id_credito,$id_credito);         
        }
        //INGRESANDO tb_mod_detalle  
        if(count($array_id_anulacion) != count($array_id_credito)){
            $array_tamaño = count($array_id_anulacion) > count($array_id_credito) ? count($array_id_anulacion) : count($array_id_credito);
        }else{
            $array_tamaño = count($array_id_anulacion);
        }
        for ($i=0; $i < $array_tamaño; $i++) { 
            $insert_detalle [] =[
                "id_a"=> isset($array_id_anulacion[$i])?$array_id_anulacion[$i]:null,
                "id_c"=> isset($array_id_credito[$i])?$array_id_credito[$i]:null,
                "id_doc"=>$id_documentacion,
            ];
        }
        //Guardado
        DB::table('tb_mod_detalle')->insert($insert_detalle);
    }

    public function buscardocumento(Request $request){
        if(!isset($_POST['searchTerm'])){
            $tb_mod_documento = DB::table("tb_mod_documento")->orderBy("doc_opmi")->limit(5)->get();
        }else{
            $search = strtoupper($_POST['searchTerm']);
            $tb_mod_documento = DB::table("tb_mod_documento")->where("doc_opmi", "like", "%".$search."%")->orderBy('anio')->orderBy('doc_opmi')->limit(5)->get();
        }

        $old_anio = '';
        $results = array();
        $i = -1;
        foreach ($tb_mod_documento as $row) {
            if ($row->anio != $old_anio) {
                $i++;
                $results[$i]['text'] = $row->anio;
                $old_anio = $row->anio;
                $c = 0;
            }
            $results[$i]['children'][$c]['id'] = $row->id_doc;
            $results[$i]['children'][$c]['text'] = $row->doc_opmi;
            $c++;
        }
        return json_encode($results);
    }

    public function ver_modificacion(Request $request){
        $input = $request->all();
        $id_doc = $input["id_doc"];
        $tb_mod_documento = DB::table("tb_mod_documento")->where("id_doc",$id_doc)->first();
        $tb_mod_detalle = DB::table("tb_mod_detalle")->where("id_doc",$id_doc)->get();
        $id_a=[];
        $id_c=[];
        foreach($tb_mod_detalle as $row){
            array_push($id_a,$row->id_a);
            array_push($id_c,$row->id_c);
        }
        $tb_mod_anulacion = DB::table("tb_mod_anulacion")->whereIn("id_a",$id_a)->get();
        $tb_mod_credito = DB::table("tb_mod_credito")->whereIn("id_c",$id_c)->get();

        return Response([
            'anulacion' => $tb_mod_anulacion,
            'credito' => $tb_mod_credito,
            'documento' => $tb_mod_documento
        ]);
    }

    public function eliminar(Request $request){
        $input = $request->all();
        $id_documento = $input["id_doc"];
        $tb_mod_detalle = DB::table("tb_mod_detalle")->where("id_doc",$id_documento)->get();
        foreach($tb_mod_detalle as $row){
            //Eliminar datos del detalle
            DB::table("tb_mod_detalle")->where("id_detalle",$row->id_detalle)->delete();
            //Si el id de la anulacion no esta vacia
            if(!empty($row->id_a)){
                DB::table("tb_mod_anulacion")->where("id_a",$row->id_a)->delete();
            }
            //Si el id del credito no esta vacia
            if(!empty($row->id_c)){
                DB::table("tb_mod_credito")->where('id_c',$row->id_c)->delete();
            }
        }
        DB::table("tb_mod_documento")->where("id_doc",$id_documento)->delete();
        return Response(['error' => false],200);
    }
}
