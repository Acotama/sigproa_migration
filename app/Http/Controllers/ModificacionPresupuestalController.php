<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Excel;
use sayhuite\PipTotalPriori;
use GuzzleHttp\Client;

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

        //Recorrer Filas Horizontal Habilitador
        // $data1 = array(
        //     array("GRI",2223388,"MEJORAMIENTO DE LOS SERVICIOS DEL CENTRO DE SALUD DE QUILMANA DEL, DISTRITO DE QUILMANA - CANETE - LIMA",19501675.05,2342266,6773027.29,10386381.76,11298602,4462071,0,    0,    "N° 033-2020-GRL-GRI(28/05/2020)",    11257530.8,    41071.199999999,    "3000000",    5901878.25,    8298602,    "SI",    "PIP",    "ACTIVO",    "VIABLE",    "METAS",    "SI CUMPLE",    12782338,    "SI CUMPLE",    "2012-12-28",    "SI CUMPLE",    "SI CUMPLE",    46.741079197707,    "SI CUMPLE",    "https://ofi5.mef.gob.pe/invierte/general/downloadArchivo?idArchivo=ac79b7b9-77e2-4f3a-8bb8-444ad8c997f2.pdf",    "NO APLICA",    "NO APLICA",    "NO CUMPLE",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "EN PROCESO"),
        //     array("GRI",2223388,"MEJORAMIENTO DE LOS SERVICIOS DEL CENTRO DE SALUD DE QUILMANA DEL, DISTRITO DE QUILMANA - CANETE - LIMA",19501675.05,2342266,6773027.29,10386381.76,11298602,4462071,0,    0,    "N° 033-2020-GRL-GRI(28/05/2020)",    11257530.8,    41071.199999999,    "3000000",    5901878.25,    8298602,    "SI",    "PIP",    "ACTIVO",    "VIABLE",    "METAS",    "SI CUMPLE",    12782338,    "SI CUMPLE",    "2012-12-28",    "SI CUMPLE",    "SI CUMPLE",    46.741079197707,    "SI CUMPLE",    "https://ofi5.mef.gob.pe/invierte/general/downloadArchivo?idArchivo=ac79b7b9-77e2-4f3a-8bb8-444ad8c997f2.pdf",    "NO APLICA",    "NO APLICA",    "NO CUMPLE",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "EN PROCESO"),
        // );

        // $data2 = array(
        //     array("GRI",2223388,"MEJORAMIENTO DE LOS SERVICIOS DEL CENTRO DE SALUD DE QUILMANA DEL, DISTRITO DE QUILMANA - CANETE - LIMA",19501675.05,2342266,6773027.29,10386381.76,11298602,4462071,0,    0,    "N° 033-2020-GRL-GRI(28/05/2020)",    11257530.8,    41071.199999999,    "3000000",    5901878.25,    8298602,    "SI",    "PIP",    "ACTIVO",    "VIABLE",    "METAS",    "SI CUMPLE",    12782338,    "SI CUMPLE",    "2012-12-28",    "SI CUMPLE",    "SI CUMPLE",    46.741079197707,    "SI CUMPLE",    "https://ofi5.mef.gob.pe/invierte/general/downloadArchivo?idArchivo=ac79b7b9-77e2-4f3a-8bb8-444ad8c997f2.pdf",    "NO APLICA",    "NO APLICA",    "NO CUMPLE",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "EN PROCESO"),
        //     array("GRI",2223388,"MEJORAMIENTO DE LOS SERVICIOS DEL CENTRO DE SALUD DE QUILMANA DEL, DISTRITO DE QUILMANA - CANETE - LIMA",19501675.05,2342266,6773027.29,10386381.76,11298602,4462071,0,    0,    "N° 033-2020-GRL-GRI(28/05/2020)",    11257530.8,    41071.199999999,    "3000000",    5901878.25,    8298602,    "SI",    "PIP",    "ACTIVO",    "VIABLE",    "METAS",    "SI CUMPLE",    12782338,    "SI CUMPLE",    "2012-12-28",    "SI CUMPLE",    "SI CUMPLE",    46.741079197707,    "SI CUMPLE",    "https://ofi5.mef.gob.pe/invierte/general/downloadArchivo?idArchivo=ac79b7b9-77e2-4f3a-8bb8-444ad8c997f2.pdf",    "NO APLICA",    "NO APLICA",    "NO CUMPLE",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "NO APLICA",    "EN PROCESO"),
        // );

        Excel::create('MOD ART 13 - HABILITAR RECURSOS PARA FINANCIAR EJECUCION DE CUI '.implode(" - ", $cui), function($excel ) use ($data1,$data2,$nombre_informe) {
            // Set the title
            $excel->setTitle('Our new awesome title');

            // Chain the setters
            $excel->setCreator('Javier Ramirez Azañero')
                ->setCompany('OPMI');

            // Call them separately
            $excel->setDescription('Habilitadores - Habilitado');
        // ART 13 
            $excel->sheet('ART 13', function($sheet) use ($data1,$data2,$nombre_informe) {
                $anio = date("Y");
                $fila_habilitador = count($data1);
                $fila_habilitado = count($data2);
                
                $columnas = array(null,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
                $sheet->setHeight(array(
                    1 => 35,
                    2 => 40,
                    3 => 32,
                    4 => 90,
                    5 => 15,
                    6 => 15,
                    7 => 15,
                    8 => 25,
                    9 => 15,
                    10 => 15,
                    11 => 15,
                    12 => 15,
                    13 => 15,
                    14 => 15,
                    15 => 23,
                    16 => 28,
                    17 => 17,
                    18 => 40,
                    19 => 30,
                    20 => 22,
                    21 => 26,
                    22 => 100,
                    23 => 52,
                    24 => 52,
                    25 => 52,
                    26 => 40,
                    27 => 40,
                    28 => 56,
                    29 => 56,
                    30 => 38,
                    31 => 50,
                    32 => 154
                ));
                $sheet->setWidth(array(
                    'A' => 20,
                    'B' => 15,
                    'C' => 8,
                    'D' => 20
                ));
                $sheet->mergeCells('A1:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'1');
                $sheet->cell('A1', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('ANEXO N°01 MODIFICACION PRESUPUESTARIA ENTRE INVERSIONES');
                });
                $sheet->mergeCells('A2:D2');
                $sheet->mergeCells('A3:D3');
                $sheet->setBorder('A3:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'32', 'thin');
                $sheet->getStyle('A3:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'32' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                $sheet->setBorder('E2:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'2', 'thin');
                $sheet->cell('A3', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('DATOS GENERALES');
                });
                $sheet->mergeCells('A4:D4');
                $sheet->cell('A4', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('NOMBRE');
                });
                $sheet->mergeCells('A5:D5');
                $sheet->cell('A5', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('CUI');
                });
                $sheet->mergeCells('A6:D6');
                $sheet->cell('A6', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('PIP / IOARR');
                });
                $sheet->mergeCells('A7:D7');
                $sheet->cell('A7', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('MONTO ACTUALIZADO');
                });
                $sheet->mergeCells('A8:D8');
                $sheet->cell('A8', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('POTENCIAL DE RECURSOS DISPONIBLES');
                });
                $sheet->mergeCells('A9:D9');
                $sheet->cell('A9', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('ESTADO');
                });
                $sheet->mergeCells('A10:D10');
                $sheet->cell('A10', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('SITUACION');
                });
                $sheet->mergeCells('A11:D11');
                $sheet->cell('A11', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#9bbb59');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('ETAPA / META');
                });
                $sheet->mergeCells('A12:D12');
                $sheet->cell('A12', function($cell) use ($anio) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#c5d9f1');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('PIM '. $anio);
                });
                $sheet->mergeCells('A13:D13');
                $sheet->cell('A13', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#eeece1');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('MONTO ANULACION');
                });
                $sheet->mergeCells('A14:D14');
                $sheet->cell('A14', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#e4dfec');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('MONTO CREDITO');
                });
                $sheet->mergeCells('A15:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'15');
                $sheet->cell('A15', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#f3e812');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('CRITERIOS DE MODIFICACION');
                });
                $sheet->mergeCells('A16:C16');
                $sheet->cell('A16', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#ffc000');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('Item');
                });
                $sheet->cell('D16', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#ffc000');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('VERIFICACION');
                });
                $sheet->mergeCells('A17:A32');
                $sheet->cell('A17', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#b7dee8');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '18',
                        'bold'       =>  true,
                    ));
                    $cell->setTextRotation(90);
                    $cell->setValue('R.D N°022-2021-EF/50.01 (Aprueban Lineamientos sobre modificaciones presupuestarias para la ejecucion del gasto en inversiones y proyectos de las Entidades Publicas, con cargo al Presupuesto del Sector Publico para el año Fiscal 2022)');
                });
                $sheet->cells('B17:D32', function($cells) {
                    $cells->setBackground('#ffffcc');
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                });
                $sheet->mergeCells('B17:B20');
                $sheet->cell('B17', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (a)');
                });
                $sheet->mergeCells('B21:B22');
                $sheet->cell('B21', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.1 (b-anulacion) 5.3 (a-credito)');
                });
                $sheet->cell('B23', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (b)');
                });
                $sheet->cell('B24', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (c)');
                });
                $sheet->cell('B25', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (d)');
                });
                $sheet->cell('B26', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (e-credito)');
                });
                $sheet->cell('B27', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('6.2 (a-anulacion)');
                });
                $sheet->cell('B28', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (f)');
                });
                $sheet->cell('B29', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (g)');
                });
                $sheet->cell('B30', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (h)');
                });
                $sheet->cell('B31', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('5.2 (i)');
                });
                $sheet->cell('B32', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('6.2 (a)');
                });
                $sheet->mergeCells('C17:C25');
                $sheet->cell('C17', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('OPMI');
                });
                $sheet->mergeCells('C26:C27');
                $sheet->cell('C26', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('OPRE');
                });
                $sheet->mergeCells('C28:C32');
                $sheet->cell('C28', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('OPMI');
                });
                $sheet->mergeCells('D17:D18');
                $sheet->cell('D17', function($cell) use ($anio) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿ESTA EN EL PMI '.$anio.'-'.($anio+3).'?');
                });
                $sheet->cell('D19', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿ESTA VIABLE O APROBADA?');
                });
                $sheet->cell('D20', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿ESTA ACTIVO?');
                });
                $sheet->cell('D21', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿ESTA EN ETAPA DE EJECUCION?');
                });
                $sheet->cell('D22', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿CUENTA CON EXPEDIENTE TECNICO O DOCUMENTO EQUIVALENTE APROBADO Y REGISTRADO?');
                });
                $sheet->cell('D23', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿RESPETA LOS CRITERIOS DE CONTINUIDAD?');
                });
                $sheet->cell('D24', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿TIENE PENDIENTE PROCESO DE CAMBIO DE UNIDAD EJECUTORA?');
                });
                $sheet->cell('D25', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿TIENE FORMATO 12-B REGISTRADO Y ACTUALIZADO?');
                });
                $sheet->cell('D26', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('MONTO DE CREDITO NO DEBE EXCEDER AL MONTO ANULADO');
                });
                $sheet->cell('D27', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('MONTO ANULADO NO SUPERA EL MAX. ANULADO');
                });
                $sheet->cell('D28', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('NO PRESENTA DUPLICIDAD DE INVERSIONES');
                });
                $sheet->cell('D29', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿CUENTA CON SANEAMIENTO FISICO LEGAL O ARREGLOS INSTITUCIONALES?');
                });
                $sheet->cell('D30', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('INTERVENCION INTEGRAL, NO FRACCIONAMIENTO');
                });
                $sheet->cell('D31', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('¿ENTIDAD EJECUTORA CUENTA CON LAS COMPETENCIAS CORRESPONDIENTES?');
                });
                $sheet->cell('D32', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setValue('EXISTE IMPEDIMENTO COMPROBABLE QUE RETRASE/INVIABLE O SE ENCUENTRE CULMINADA');
                });

                // Habilitadores
                if($fila_habilitador > 0){
                    $total_anulacion = 0;
                    // ESTILOS
                    $sheet->cell('E3:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'14', function($cell) {
                        $cell->setAlignment('center');
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '9',
                        ));
                    });
                    
                    // POTENCIAL DE RECURSOS DISPONIBLES
                    $sheet->mergeCells('E8:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'8');
                    $sheet->cell('E8', function($cell) use ($nombre_informe) {
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '11',
                            'bold'       =>  true,
                        ));
                        $cell->setValue($nombre_informe);
                    });
                    
                    $sheet->cell('E16:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2 + 4].'32', function($cell) {
                        $cell->setAlignment('center');
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '8',
                        ));
                    });
                    $i = 5;
                    foreach($data1  as $index => $fila){
                        $fila_inicio = $i + $index; 
                        $sheet->setColumnFormat(array(
                        'E7:'.$columnas[$fila_habilitador*2 + $fila_habilitado*2].'7' => '"S/." #,##0.00'
                    ));
                        // Formatear Celdas
                        $sheet->setColumnFormat(array(
                  
                            $columnas[$fila_inicio].'7' => '"S/." #,##0.00',
                            $columnas[$fila_inicio].'12' => '"S/." #,##0.00',
                            $columnas[$fila_inicio].'13' => '"S/." #,##0.00',
                            $columnas[$fila_inicio + 1].'18' => '"S/." #,##0.00',
                            $columnas[$fila_inicio + 1].'21' => '#,##0.00 "%"',
                            $columnas[$fila_inicio + 1].'25' => '"S/." #,##0.00',
                        ));
                        // UEI
                        $sheet->setWidth($columnas[$fila_inicio], 16);
                        $sheet->setWidth($columnas[$fila_inicio + 1], 26);
                        $sheet->mergeCells($columnas[$fila_inicio].'2:'.$columnas[$fila_inicio + 1].'2');
                        $sheet->cell($columnas[$fila_inicio].'2', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#c4d79b');
                            $cell->setFont(array(
                                'family'     => 'Calibri',
                                'size'       => '11',
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[0]);
                        });
                        //DATOS GENERALES
                        $sheet->mergeCells($columnas[$fila_inicio].'3:'.$columnas[$fila_inicio + 1].'3');
                        $sheet->cell($columnas[$fila_inicio].'3', function($cell) use ($fila,$index) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#eeece1');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue('INVERSION HABILITADOR ('.($index + 1).')');
                        });
                        //NOMBRE
                        $sheet->mergeCells($columnas[$fila_inicio].'4:'.$columnas[$fila_inicio + 1].'4');
                        $sheet->cell($columnas[$fila_inicio].'4', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[2]);
                        });
                        //CUI
                        $sheet->mergeCells($columnas[$fila_inicio].'5:'.$columnas[$fila_inicio + 1].'5');
                        $sheet->cell($columnas[$fila_inicio].'5', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[1]);
                        });
                        //PIP / IOARR
                        $sheet->mergeCells($columnas[$fila_inicio].'6:'.$columnas[$fila_inicio + 1].'6');
                        $sheet->cell($columnas[$fila_inicio].'6', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[18]);
                        });
                        //MONTO ACTUALIZADO
                        $sheet->mergeCells($columnas[$fila_inicio].'7:'.$columnas[$fila_inicio + 1].'7');
                        $sheet->cell($columnas[$fila_inicio].'7', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[3]);
                        });
                        //ESTADO
                        $sheet->mergeCells($columnas[$fila_inicio].'9:'.$columnas[$fila_inicio + 1].'9');
                        $sheet->cell($columnas[$fila_inicio].'9', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[19]);
                        });
                        //SITUACION
                        $sheet->mergeCells($columnas[$fila_inicio].'10:'.$columnas[$fila_inicio + 1].'10');
                        $sheet->cell($columnas[$fila_inicio].'10', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[20]);
                        });
                        //METAS
                        $sheet->mergeCells($columnas[$fila_inicio].'11:'.$columnas[$fila_inicio + 1].'11');
                        $sheet->cell($columnas[$fila_inicio].'11', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[21]);
                        });
                        //PIM
                        $sheet->mergeCells($columnas[$fila_inicio].'12:'.$columnas[$fila_inicio + 1].'12');
                        $sheet->cell($columnas[$fila_inicio].'12', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[7]);
                        });
                        //MONTO ANULADO
                        $sheet->mergeCells($columnas[$fila_inicio].'13:'.$columnas[$fila_inicio + 1].'13');
                        $sheet->cell($columnas[$fila_inicio].'13', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[14]);
                        });
                        // ================================================================================
                        //MONTO CREDITO
                        $sheet->mergeCells($columnas[$fila_inicio].'14:'.$columnas[$fila_inicio + 1].'14');
                        $sheet->cell($columnas[$fila_inicio].'14', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#002060');
                        });
                        //COLUMNA CRITERIO
                        $sheet->cell($columnas[$fila_inicio].'16', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#ffc000');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue('CRITERIO');
                        });
                        //COLUMNA COMENTARIO
                        $sheet->cell($columnas[$fila_inicio + 1].'16', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#ffc000');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue('COMENTARIO');
                        });
                        //¿ESTA EN EL PMI 2021-2023?
                        $sheet->mergeCells($columnas[$fila_inicio].'17:'.$columnas[$fila_inicio].'18');
                        $sheet->cell($columnas[$fila_inicio].'17', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[22]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'17', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setFont(array(
                                'size'       => '11',
                                'bold'       =>  true,
                            ));
                            $cell->setValue(date("Y"));
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'18', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[23]);
                        });
                        //¿ESTA VIABLE O APROBADA?
                        $sheet->cell($columnas[$fila_inicio].'19', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[24]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'19', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[25]);
                        });
                        //¿ESTA ACTIVO?
                        $sheet->mergeCells($columnas[$fila_inicio].'20:'.$columnas[$fila_inicio + 1].'20');
                        $sheet->cell($columnas[$fila_inicio].'20', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[26]);
                        });
                        //¿ESTA EN ETAPA DE EJECUCION?
                        $sheet->cell($columnas[$fila_inicio].'21', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[27]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'21', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setFont(array(
                                'size'       => '11',
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[28]);
                        });
                        //¿CUENTA CON EXPEDIENTE TECNICO O DOCUMENTO EQUIVALENTE APROBADO Y REGISTRADO?
                        $sheet->cell($columnas[$fila_inicio].'22', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[29]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'22', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[11]);
                        });
                        $sheet->getCell($columnas[$fila_inicio + 1].'22')->getHyperlink()->setUrl($fila[30]);
                        //¿RESPETA LOS CRITERIOS DE CONTINUIDAD?
                        $sheet->mergeCells($columnas[$fila_inicio].'23:'.$columnas[$fila_inicio + 1].'23');
                        $sheet->cell($columnas[$fila_inicio].'23', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[31]);
                        });
                        // ¿TIENE PENDIENTE PROCESO DE CAMBIO DE UNIDAD EJECUTORA?
                        $sheet->mergeCells($columnas[$fila_inicio].'24:'.$columnas[$fila_inicio + 1].'24');
                        $sheet->cell($columnas[$fila_inicio].'24', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[32]);
                        });
                        //¿TIENE FORMATO 12-B REGISTRADO Y ACTUALIZADO?
                        $sheet->cell($columnas[$fila_inicio].'25', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[33]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'25', function($cell) use ($fila) {
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[16]);
                        });
                        //MONTO DE CREDITO NO DEBE EXCEDER AL MONTO ANULADO 
                        $sheet->mergeCells($columnas[$fila_inicio].'26:'.$columnas[$fila_inicio + 1].'26');
                        $sheet->cell($columnas[$fila_inicio].'26', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[34]);
                        });
                        //MONTO ANULADO NO SUPERA EL MAX.ANULADO
                        $sheet->mergeCells('E27:'.$columnas[$fila_habilitador*2 + 4].'27');
                        $sheet->cell('E27', function($cell) use ($fila) {
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[35]);
                        });
                        //NO PRESENTA DUPLICIDAD DE INVERSIONES
                        $sheet->mergeCells($columnas[$fila_inicio].'28:'.$columnas[$fila_inicio + 1].'28');
                        $sheet->cell($columnas[$fila_inicio].'28', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[36]);
                        });
                        //¿CUENTA CON SANEAMIENTO FISICO LEGAL O ARREGLOS INSTITUCIONALES?
                        $sheet->mergeCells($columnas[$fila_inicio].'29:'.$columnas[$fila_inicio + 1].'29');
                        $sheet->cell($columnas[$fila_inicio].'29', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[37]);
                        });
                        //INTERVENCION INTEGRAL, NO FRACCIONAMIENTO.
                        $sheet->mergeCells($columnas[$fila_inicio].'30:'.$columnas[$fila_inicio + 1].'30');
                        $sheet->cell($columnas[$fila_inicio].'30', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[38]);
                        });
                        //¿ENTIDAD EJECUTORA CUENTA CON LAS COMPETENCIAS CORRESPONDIENTES?
                        $sheet->mergeCells($columnas[$fila_inicio].'31:'.$columnas[$fila_inicio + 1].'31');
                        $sheet->cell($columnas[$fila_inicio].'31', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[39]);
                        });
                        //EXISTE IMPEDIMENTO COMPROBABLE QUE RETRASE/INVIABLE O SE ENCUENTRE CULMINADA
                        $sheet->mergeCells($columnas[$fila_inicio].'32:'.$columnas[$fila_inicio + 1].'32');
                        $sheet->cell($columnas[$fila_inicio].'32', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#fafa00');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[40]);
                        });
                        $i += 1;
                    }

                }

                //Habilitados
                if($fila_habilitado > 0){
                    $i = $fila_habilitador*2 + 5;
                    $total_credito = 0;
                    foreach($data2  as $index => $fila){
                        $fila_inicio = $i + $index; 
                        // Formatear Celdas
                        $sheet->setColumnFormat(array(
                            $columnas[$fila_inicio].'7' => '"S/." #,##0.00',
                            $columnas[$fila_inicio].'12' => '"S/." #,##0.00',
                            $columnas[$fila_inicio].'14' => '"S/." #,##0.00',
                            $columnas[$fila_inicio + 1].'18' => '"S/." #,##0.00',
                            $columnas[$fila_inicio + 1].'21' => '#,##0.00 "%"',
                            $columnas[$fila_inicio + 1].'25' => '"S/." #,##0.00',
                        ));
                        // UEI
                        $sheet->setWidth($columnas[$fila_inicio], 16);
                        $sheet->setWidth($columnas[$fila_inicio + 1], 26);
                        $sheet->mergeCells($columnas[$fila_inicio].'2:'.$columnas[$fila_inicio + 1].'2');
                        $sheet->cell($columnas[$fila_inicio].'2', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#c4d79b');
                            $cell->setFont(array(
                                'family'     => 'Calibri',
                                'size'       => '11',
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[0]);
                        });
                        //DATOS GENERALES
                        $sheet->mergeCells($columnas[$fila_inicio].'3:'.$columnas[$fila_inicio + 1].'3');
                        $sheet->cell($columnas[$fila_inicio].'3', function($cell) use ($fila,$index) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#eeece1');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue('INVERSION HABILITADO ('.($index + 1).')');
                        });
                        //NOMBRE
                        $sheet->mergeCells($columnas[$fila_inicio].'4:'.$columnas[$fila_inicio + 1].'4');
                        $sheet->cell($columnas[$fila_inicio].'4', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[2]);
                        });
                        //CUI
                        $sheet->mergeCells($columnas[$fila_inicio].'5:'.$columnas[$fila_inicio + 1].'5');
                        $sheet->cell($columnas[$fila_inicio].'5', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[1]);
                        });
                        //PIP / IOARR
                        $sheet->mergeCells($columnas[$fila_inicio].'6:'.$columnas[$fila_inicio + 1].'6');
                        $sheet->cell($columnas[$fila_inicio].'6', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[18]);
                        });
                        //MONTO ACTUALIZADO
                        $sheet->mergeCells($columnas[$fila_inicio].'7:'.$columnas[$fila_inicio + 1].'7');
                        $sheet->cell($columnas[$fila_inicio].'7', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[3]);
                        });
                        //ESTADO
                        $sheet->mergeCells($columnas[$fila_inicio].'9:'.$columnas[$fila_inicio + 1].'9');
                        $sheet->cell($columnas[$fila_inicio].'9', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[19]);
                        });
                        //SITUACION
                        $sheet->mergeCells($columnas[$fila_inicio].'10:'.$columnas[$fila_inicio + 1].'10');
                        $sheet->cell($columnas[$fila_inicio].'10', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[20]);
                        });
                        //METAS
                        $sheet->mergeCells($columnas[$fila_inicio].'11:'.$columnas[$fila_inicio + 1].'11');
                        $sheet->cell($columnas[$fila_inicio].'11', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[21]);
                        });
                        //PIM
                        $sheet->mergeCells($columnas[$fila_inicio].'12:'.$columnas[$fila_inicio + 1].'12');
                        $sheet->cell($columnas[$fila_inicio].'12', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[7]);
                        });
                        // ================================================================================
                        //MONTO ANULADO
                        $sheet->mergeCells($columnas[$fila_inicio].'13:'.$columnas[$fila_inicio + 1].'13');
                        $sheet->cell($columnas[$fila_inicio].'13', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#002060');
                        });
                        // ================================================================================
                        //MONTO CREDITO
                        $sheet->mergeCells($columnas[$fila_inicio].'14:'.$columnas[$fila_inicio + 1].'14');
                        $sheet->cell($columnas[$fila_inicio].'14', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[14]);
                        });
                        //COLUMNA CRITERIO
                        $sheet->cell($columnas[$fila_inicio].'16', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#ffc000');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue('CRITERIO');
                        });
                        //COLUMNA COMENTARIO
                        $sheet->cell($columnas[$fila_inicio + 1].'16', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#ffc000');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue('COMENTARIO');
                        });
                        //¿ESTA EN EL PMI 2021-2023?
                        $sheet->mergeCells($columnas[$fila_inicio].'17:'.$columnas[$fila_inicio].'18');
                        $sheet->cell($columnas[$fila_inicio].'17', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[22]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'17', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setFont(array(
                                'size'       => '11',
                                'bold'       =>  true,
                            ));
                            $cell->setValue(date("Y"));
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'18', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[23]);
                        });
                        //¿ESTA VIABLE O APROBADA?
                        $sheet->cell($columnas[$fila_inicio].'19', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[24]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'19', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[25]);
                        });
                        //¿ESTA ACTIVO?
                        $sheet->mergeCells($columnas[$fila_inicio].'20:'.$columnas[$fila_inicio + 1].'20');
                        $sheet->cell($columnas[$fila_inicio].'20', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[26]);
                        });
                        //¿ESTA EN ETAPA DE EJECUCION?
                        $sheet->cell($columnas[$fila_inicio].'21', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[27]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'21', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setFont(array(
                                'size'       => '11',
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[28]);
                        });
                        //¿CUENTA CON EXPEDIENTE TECNICO O DOCUMENTO EQUIVALENTE APROBADO Y REGISTRADO?
                        $sheet->cell($columnas[$fila_inicio].'22', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[29]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'22', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[11]);
                        });
                        $sheet->getCell($columnas[$fila_inicio + 1].'22')->getHyperlink()->setUrl($fila[30]);
                        //¿RESPETA LOS CRITERIOS DE CONTINUIDAD?
                        $sheet->mergeCells($columnas[$fila_inicio].'23:'.$columnas[$fila_inicio + 1].'23');
                        $sheet->cell($columnas[$fila_inicio].'23', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[31]);
                        });
                        // ¿TIENE PENDIENTE PROCESO DE CAMBIO DE UNIDAD EJECUTORA?
                        $sheet->mergeCells($columnas[$fila_inicio].'24:'.$columnas[$fila_inicio + 1].'24');
                        $sheet->cell($columnas[$fila_inicio].'24', function($cell) use ($fila) {;
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#fafa00');
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setValue($fila[32]);
                        });
                        //¿TIENE FORMATO 12-B REGISTRADO Y ACTUALIZADO?
                        $sheet->cell($columnas[$fila_inicio].'25', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[33]);
                        });
                        $sheet->cell($columnas[$fila_inicio + 1].'25', function($cell) use ($fila) {
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[16]);
                        });
                        //MONTO DE CREDITO NO DEBE EXCEDER AL MONTO ANULADO 
                        $sheet->mergeCells($columnas[$fila_inicio].'26:'.$columnas[$fila_inicio + 1].'26');
                        $sheet->cell($columnas[$fila_inicio].'26', function($cell) use ($fila) {
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[34]);
                        });
                        //MONTO ANULADO NO SUPERA EL MAX.ANULADO
                        $sheet->mergeCells($columnas[$fila_inicio].'27:'.$columnas[$fila_inicio + 1].'27');
                        $sheet->cell($columnas[$fila_inicio].'27', function($cell) use ($fila) {
                            $cell->setBackground('#b7dee8');
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[35]);
                        });
                        //NO PRESENTA DUPLICIDAD DE INVERSIONES
                        $sheet->mergeCells($columnas[$fila_inicio].'28:'.$columnas[$fila_inicio + 1].'28');
                        $sheet->cell($columnas[$fila_inicio].'28', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[36]);
                        });
                        //¿CUENTA CON SANEAMIENTO FISICO LEGAL O ARREGLOS INSTITUCIONALES?
                        $sheet->mergeCells($columnas[$fila_inicio].'29:'.$columnas[$fila_inicio + 1].'29');
                        $sheet->cell($columnas[$fila_inicio].'29', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[37]);
                        });
                        //INTERVENCION INTEGRAL, NO FRACCIONAMIENTO.
                        $sheet->mergeCells($columnas[$fila_inicio].'30:'.$columnas[$fila_inicio + 1].'30');
                        $sheet->cell($columnas[$fila_inicio].'30', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[38]);
                        });
                        //¿ENTIDAD EJECUTORA CUENTA CON LAS COMPETENCIAS CORRESPONDIENTES?
                        $sheet->mergeCells($columnas[$fila_inicio].'31:'.$columnas[$fila_inicio + 1].'31');
                        $sheet->cell($columnas[$fila_inicio].'31', function($cell) use ($fila) {
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setValue($fila[39]);
                        });
                        //EXISTE IMPEDIMENTO COMPROBABLE QUE RETRASE/INVIABLE O SE ENCUENTRE CULMINADA
                        $sheet->mergeCells($columnas[$fila_inicio].'32:'.$columnas[$fila_inicio + 1].'32');
                        $sheet->cell($columnas[$fila_inicio].'32', function($cell) use ($fila) {
                            $cell->setFont(array(
                                'bold'       =>  true,
                            ));
                            $cell->setAlignment('center');
                            $cell->setValignment('center');
                            $cell->setBackground('#b7dee8');
                            $cell->setValue($fila[40]);
                        });
                        $i += 1;


                    }                  
                }
            });
        // INV-INFORMACION  
            $excel->sheet('INV-INFORMACION', function($sheet) use ($data1,$data2) {
                $anio = date("Y");
                $sheet->cells('A1:Q100', function($cells) {
                    $cells->setValignment('center');
                });
                $sheet->setWidth(array(
                    'A' =>  7,
                    'B' => 12,
                    'C' => 30,
                    'D' => 15,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
                    'H' => 15,
                    'I' => 15,
                    'J' => 15,
                    'K' => 15,
                    'L' => 20,
                    'M' => 15,
                    'N' => 15,
                    'O' => 15,
                    'P' => 15,
                    'Q' => 15,
                ));
                $sheet->setHeight(array(
                    2 => 30,
                    3 => 40,
                ));
                $sheet->mergeCells('A2:G2');
                $sheet->setBorder('A2:K2', 'thin');
                $sheet->cell('A2', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setFontColor('#dd4b39');
                    $cell->setBackground('#fde9d9');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('HABILITADOR');
                });

                $sheet->getStyle('A3:Q3' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                $sheet->setBorder('A3:Q3', 'thin');
                $sheet->cells('A3:Q3', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBackground('#f3e812');
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '8',
                        'bold'       =>  true,
                    ));
                });
                $sheet->cells('A4:Q4', function($cells) {
                    $cells->setBackground('#DDEBF7');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true,
                    ));
                });
                $sheet->setBorder('A4'.':Q4', 'thin');

                $sheet->cell('A3', function($cell) {
                    $cell->setValue('UEI');
                });
                $sheet->cell('B3', function($cell) {
                    $cell->setValue('CUI');
                });
                $sheet->cell('C3', function($cell) {
                    $cell->setValue('NOMBRE DE LA INVERSION');
                });
                $sheet->cell('D3', function($cell) use ($anio) {
                    $cell->setValue('COSTO DE INVERSION ACTUALIZADO '. ($anio));
                });
                $sheet->mergeCells('A4:C4');
                $sheet->cell('D4', function($cell){
                    $cell->setValue('A');
                });
                $sheet->cell('E3', function($cell) use ($anio) {
                    $cell->setValue('DEVENGADO ACUMULADO (AL 31 DIC. '. ($anio - 1) .')');
                });
                $sheet->cell('E4', function($cell){
                    $cell->setValue('B');
                });
                $sheet->cell('F3', function($cell) use ($anio) {
                    $cell->setValue('DEVENGADO '. ($anio));
                });
                $sheet->cell('F4', function($cell){
                    $cell->setValue('C');
                });
                $sheet->cell('G3', function($cell) use ($anio) {
                    $cell->setValue('SALDO POR EJECUTAR '. ($anio));
                });
                $sheet->cell('G4', function($cell){
                    $cell->setValue('D=(A-B-C)');
                });
                $sheet->cells('I3:K3', function($cells) {
                    $cells->setBackground('#f2dbdb');
                });
                $sheet->mergeCells('H2:K2');
                $sheet->cell('H2', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#f3e812');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('PROGRAMACION MULTIANUAL - CARTERA GRL');
                });
                $sheet->cell('H3', function($cell) use ($anio) {
                    $cell->setValue('PIM '. ($anio));
                });
                $sheet->cell('H4', function($cell){
                    $cell->setValue('E');
                });
                $sheet->cell('I3', function($cell) use ($anio) {
                    $cell->setValue('PMI '. ($anio + 1));
                });
                $sheet->cell('I4', function($cell){
                    $cell->setValue('F');
                });
                $sheet->cell('J3', function($cell) use ($anio) {
                    $cell->setValue('PMI '. ($anio + 2));
                });
                $sheet->cell('J4', function($cell){
                    $cell->setValue('G');
                });
                $sheet->cell('K3', function($cell) use ($anio) {
                    $cell->setValue('PMI '. ($anio + 3));
                });
                $sheet->cell('K4', function($cell){
                    $cell->setValue('H');
                });
                $sheet->cell('L3', function($cell) {
                    $cell->setValue('EXPEDIENTE TECNICO N°');
                });
                $sheet->cell('L4', function($cell){
                    $cell->setValue('I');
                });
                $sheet->cell('M3', function($cell) use ($anio) {
                    $cell->setValue('COMPROMISOS A REALIZAR '. ($anio));
                });
                $sheet->cell('M4', function($cell){
                    $cell->setValue('J');
                });
                $sheet->cell('N3', function($cell) use ($anio) {
                    $cell->setValue('SALDO DEL PIM '. ($anio));
                });
                $sheet->cell('N4', function($cell){
                    $cell->setValue('K=(E-J)');
                });
                $sheet->cell('O3', function($cell) {
                    $cell->setValue('SOLICITUD DE ANULACION');
                });
                $sheet->cell('O4', function($cell){
                    $cell->setValue('L');
                });
                $sheet->cell('P3', function($cell) {
                    $cell->setValue('NUEVO SALDO DE INVERSION');
                });
                $sheet->cell('P4', function($cell){
                    $cell->setValue('M=(A-B-J)');
                });
                $sheet->cell('Q3', function($cell) use ($anio) {
                    $cell->setValue('PIM '. ($anio).' MODIFICADO');
                });
                $sheet->cell('Q4', function($cell){
                    $cell->setValue('N=(E-L)');
                });

                //Recorrer Filas Habilitador
                $fila_habilitador = count($data1);
                if($fila_habilitador > 0){
                    $total_anulacion = 0;
                    $numero_empieza_habilitador=5;
                    foreach($data1  as $index => $fila)
                    {
                        $total_anulacion += $fila[14];
                        $fila_inicio = $numero_empieza_habilitador + $index;
                        $sheet->getStyle('C'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                        $sheet->getStyle('L'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                        $sheet->cells('A5'.':Q'.$fila_inicio, function($cells) {
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setFont(array(
                                'family'     => 'Calibri',
                                'size'       => '9',
                            ));
                        });
                        $sheet->setBorder('A5'.':Q'.$fila_inicio, 'thin');
                        $sheet->cell('M'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#0070c0');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        });
                        $sheet->cell('N'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#00b050');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        }); 
                        $sheet->cell('O'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#ff0000');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        }); 
                        $sheet->cell('P'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#7030a0');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        }); 
                        $sheet->setColumnFormat(array(
                            'D4:K'.$fila_inicio => '"S/." #,##0.00',
                            'M4:Q'.$fila_inicio => '"S/." #,##0.00',
                        ));
                        if($fila[17] == 'SI'){
                            $sheet->row($fila_inicio, array(
                                $fila[0], $fila[1],$fila[2], $fila[3],$fila[4], $fila[5],$fila[6],$fila[7],$fila[8],$fila[9],$fila[10],$fila[11],$fila[12],$fila[13],-$fila[14],$fila[15],$fila[16]
                            ));
                        }elseif($fila[17] == '7D'){
                            $sheet->getStyle('I'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);;
                            $sheet->mergeCells('I'.$fila_inicio.':K'.$fila_inicio);
                            $sheet->cells('I'.$fila_inicio, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                            $sheet->row($fila_inicio, array(
                                $fila[0], $fila[1],$fila[2], $fila[3],$fila[4], $fila[5],$fila[6], $fila[7],'LA INVERSIÓN CORRESPONDE A UN DECRETO DE EMERGENCIA','','',$fila[11],$fila[12],$fila[13],-$fila[14],$fila[15],$fila[16]
                            ));
                        }
                        else{
                            $sheet->getStyle('I'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);;
                            $sheet->mergeCells('I'.$fila_inicio.':K'.$fila_inicio);
                            $sheet->cells('I'.$fila_inicio, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                            $sheet->row($fila_inicio, array(
                                $fila[0], $fila[1],$fila[2], $fila[3],$fila[4], $fila[5],$fila[6], $fila[7],'NO SE ENCUENTRA EN EL PMI','','',$fila[11],$fila[12],$fila[13],-$fila[14],$fila[15],$fila[16]
                            ));
                        }
                        $sheet->getCell('L'.$fila_inicio)->getHyperlink()->setUrl($fila[30]);
                    }
                    $sheet->mergeCells('B'.($fila_habilitador + $numero_empieza_habilitador).':N'.($fila_habilitador + $numero_empieza_habilitador));
                    $sheet->setBorder('B'.($fila_habilitador + $numero_empieza_habilitador).':O'.($fila_habilitador + $numero_empieza_habilitador), 'thin');
                    $sheet->setHeight(($fila_habilitador + $numero_empieza_habilitador), 40);
                    $sheet->cell('B'.($fila_habilitador + $numero_empieza_habilitador), function($cell) {
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '8',
                            'bold'       =>  true
                        ));
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setValue('TOTAL DEL MONTO DE SOLICITUD  DE CERTIFICACION PRESUPUESTAL ');
                    });
                    $sheet->setColumnFormat(array(
                        'O'.($fila_habilitador + $numero_empieza_habilitador) => '"S/." #,##0.00',
                    ));
                    $sheet->cell('O'.($fila_habilitador + $numero_empieza_habilitador), function($cell) use ($total_anulacion) {
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '9',
                            'bold'       =>  true
                        ));
                        $cell->setBackground('#f3e812');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setValue(-$total_anulacion);
                    });
                }

                $sheet->setHeight(($fila_habilitador + 6), 30);
                $sheet->setHeight(array(
                    ($fila_habilitador + 7) => 30,
                    ($fila_habilitador + 8) => 40,
                ));
                $sheet->mergeCells('A'.($fila_habilitador + 7).':G'.($fila_habilitador + 7));
                $sheet->setBorder('A'.($fila_habilitador + 7).':K'.($fila_habilitador + 7), 'thin');  
                $sheet->cell('A'.($fila_habilitador + 7), function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setFontColor('#0070c0');
                    $cell->setBackground('#dce6f1');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('HABILITADO');
                });
                $sheet->getStyle('A'.($fila_habilitador + 8).':Q'.($fila_habilitador + 8) , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                $sheet->setBorder('A'.($fila_habilitador + 8).':Q'.($fila_habilitador + 8), 'thin');
                $sheet->cells('A'.($fila_habilitador + 8).':Q'.($fila_habilitador + 8), function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBackground('#f3e812');
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '8',
                        'bold'       =>  true,
                    ));
                });
                $sheet->cell('A'.($fila_habilitador + 9).':Q'.($fila_habilitador + 9), function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBackground('#DDEBF7');
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true,
                    ));
                });
                $sheet->setBorder('A'.($fila_habilitador + 9).':Q'.($fila_habilitador + 9), 'thin');

                $sheet->cell('A'.($fila_habilitador + 8), function($cell) {
                    $cell->setValue('UEI');
                });
                $sheet->cell('B'.($fila_habilitador + 8), function($cell) {
                    $cell->setValue('CUI');
                });
                $sheet->cell('C'.($fila_habilitador + 8), function($cell) {
                    $cell->setValue('NOMBRE DE LA INVERSION');
                });
                $sheet->cell('D'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('COSTO DE INVERSION ACTUALIZADO '. ($anio));
                });
                $sheet->cell('D'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('A');
                });
                $sheet->cell('E'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('DEVENGADO ACUMULADO (AL 31 DIC. '. ($anio - 1) .')');
                });
                $sheet->cell('E'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('B');
                });
                $sheet->cell('F'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('DEVENGADO '. ($anio));
                });
                $sheet->cell('F'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('C');
                });
                $sheet->cell('G'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('SALDO POR EJECUTAR '. ($anio));
                });
                $sheet->cell('G'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('D=(A-B-C)');
                });
                $sheet->mergeCells('H'.($fila_habilitador + 7).':K'.($fila_habilitador + 7));
                $sheet->cell('H'.($fila_habilitador + 7), function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#f3e812');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '9',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('PROGRAMACION MULTIANUAL - CARTERA GRL');
                });
                $sheet->cell('H'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('PIM '. ($anio));
                });
                $sheet->cell('H'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('E');
                });
                $sheet->cells('I'.($fila_habilitador + 8).':K'.($fila_habilitador + 7), function($cells) {
                    $cells->setBackground('#f2dbdb');
                });
                $sheet->cell('I'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('PMI '. ($anio + 1));
                });
                $sheet->cell('I'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('F');
                });
                $sheet->cell('J'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('PMI '. ($anio + 2));
                });
                $sheet->cell('J'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('G');
                });
                $sheet->cell('K'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('PMI '. ($anio + 3));
                });
                $sheet->cell('K'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('H');
                });
                $sheet->cell('L'.($fila_habilitador + 8), function($cell) {
                    $cell->setValue('EXPEDIENTE TECNICO N°');
                });
                $sheet->cell('L'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('I');
                });
                $sheet->cell('M'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('COMPROMISOS A REALIZAR '. ($anio));
                });
                $sheet->cell('M'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('J');
                });
                $sheet->cell('N'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('DEFICIT '. ($anio));
                });
                $sheet->cell('N'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('K=(E-J)');
                });
                $sheet->cell('O'.($fila_habilitador + 8), function($cell) {
                    $cell->setValue('SOLICITUD DE CREDITO');
                });
                $sheet->cell('O'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('L');
                });
                $sheet->cell('P'.($fila_habilitador + 8), function($cell) {
                    $cell->setValue('NUEVO SALDO DE INVERSION');
                });
                $sheet->cell('P'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('M=(A-B-J)');
                });
                $sheet->cell('Q'.($fila_habilitador + 8), function($cell) use ($anio) {
                    $cell->setValue('PIM '. ($anio).' MODIFICADO');
                });
                $sheet->cell('Q'.($fila_habilitador + 9), function($cell) {
                    $cell->setValue('N=(E-L)');
                });

                //Recorrer Filas Habilitado
                $fila_habilitado = count($data2);
                if($fila_habilitado > 0){
                    $total_credito = 0;
                    $fila_index_habilitado = 10;
                    foreach($data2  as $index => $fila)
                    {
                        $total_credito += $fila[14];
                        $fila_inicio = $fila_habilitador + $fila_index_habilitado + $index;
                        $sheet->getStyle('C'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                        $sheet->getStyle('L'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                        $sheet->cells('A'.$fila_inicio.':Q'.$fila_inicio, function($cells) {
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setFont(array(
                                'family'     => 'Calibri',
                                'size'       => '9',
                            ));
                        });
                        $sheet->setBorder('A'.$fila_inicio.':Q'.$fila_inicio, 'thin');
                        $sheet->cell('M'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#0070c0');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        });
                        $sheet->cell('N'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#00b050');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        }); 
                        $sheet->cell('O'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#ff0000');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        }); 
                        $sheet->cell('P'.$fila_inicio, function($cell) {
                            $cell->setFontColor('#7030a0');
                            $cell->setFont(array(
                                'bold'       =>  true
                            ));
                        }); 
                        $sheet->setColumnFormat(array(
                            'D4:K'.$fila_inicio => '"S/." #,##0.00',
                            'M4:Q'.$fila_inicio => '"S/." #,##0.00',
                        ));
                        if($fila[17] == 'SI'){
                            
                            $sheet->row($fila_inicio, array(
                                $fila[0], $fila[1],$fila[2], $fila[3],$fila[4], $fila[5],$fila[6], $fila[7],$fila[8],$fila[9],$fila[10],$fila[11],$fila[12],$fila[13],-$fila[14],$fila[15],$fila[16]
                            ));
                        }elseif($fila[17] == '7D'){
                            $sheet->getStyle('I'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                            $sheet->mergeCells('I'.$fila_inicio.':K'.$fila_inicio);
                            $sheet->cells('I'.$fila_inicio, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                            $sheet->row($fila_inicio, array(
                                $fila[0], $fila[1],$fila[2], $fila[3],$fila[4], $fila[5],$fila[6], $fila[7],'LA INVERSIÓN CORRESPONDE A UN DECRETO DE EMERGENCIA','','',$fila[11],$fila[12],$fila[13],-$fila[14],$fila[15],$fila[16]
                            ));
                        }else{
                            $sheet->getStyle('I'.$fila_inicio , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                            $sheet->mergeCells('I'.$fila_inicio.':K'.$fila_inicio);
                            $sheet->cells('I'.$fila_inicio, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                            $sheet->row($fila_inicio, array(
                                $fila[0], $fila[1],$fila[2], $fila[3],$fila[4], $fila[5],$fila[6], $fila[7],'NO SE ENCUENTRA EN EL PMI','','',$fila[11],$fila[12],$fila[13],-$fila[14],$fila[15],$fila[16]
                            ));
                        }
                        $sheet->getCell('L'.$fila_inicio)->getHyperlink()->setUrl($fila[30]);
                    }
                    $sheet->mergeCells('B'.($fila_habilitador + $fila_index_habilitado + $fila_habilitado).':N'.($fila_habilitador + $fila_index_habilitado + $fila_habilitado));
                    $sheet->setBorder('B'.($fila_habilitador + $fila_index_habilitado + $fila_habilitado).':O'.($fila_habilitador + $fila_index_habilitado + $fila_habilitado), 'thin');
                    $sheet->setHeight(($fila_habilitador + $fila_index_habilitado + $fila_habilitado), 40);
                    $sheet->cell('B'.($fila_habilitador + $fila_index_habilitado + $fila_habilitado), function($cell) {
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '8',
                            'bold'       =>  true
                        ));
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setValue('TOTAL DE MONTO DE CREDITO PRESUPUESTAL');
                    });
                    $sheet->setColumnFormat(array(
                        'O'.($fila_habilitador + $fila_index_habilitado + $fila_habilitado) => '"S/." #,##0.00',
                    ));
                    $sheet->cell('O'.($fila_habilitador + $fila_index_habilitado + $fila_habilitado), function($cell) use ($total_credito) {
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '9',
                            'bold'       =>  true
                        ));
                        $cell->setBackground('#f3e812');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setValue($total_credito);
                    });
                }

            });
        // FORMATO-12B
            $excel->sheet('FORMATO-12B', function($sheet) use ($data1,$data2) {
                $anio = date("Y");
                $fila_habilitador = count($data1);
                $fila_habilitado = count($data2);
                $sheet->setWidth(array(
                    'B' => 6,
                    'C' => 9,
                    'D' => 45,
                    'E' => 16,
                    'F' => 17,
                    'G' => 17,
                    'H' => 17,
                    'I' => 17,
                    'J' => 17,
                    'K' => 17,
                ));
                $sheet->setHeight(array(
                    2 => 30,
                    3 => 46,
                    (7 + $fila_habilitador) => 30,
                    (8 + $fila_habilitador) => 46,

                ));
                // Recorrer Filas Habilitador
                $numero_empieza_habilitador = 4; //Contar de B2
                $sheet->cells('B2:K'. (9 + $fila_habilitador + $fila_habilitado), function($cells) {
                    $cells->setValignment('center');
                    $cells->setAlignment('center');
                });
                $sheet->getStyle('B2:K'. (9 + $fila_habilitador + $fila_habilitado) , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                $sheet->setBorder('B2:K'. (3 + $numero_empieza_habilitador - 2), 'thin');
                $sheet->mergeCells('B2:J2');
                $sheet->cell('B2', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#E4DFEC');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('INVERSION HABILITADOR - ANULACION');
                });
                $sheet->cell('B3:J3', function($cell) {
                    $cell->setBackground('#FCD5B4');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                });
                $sheet->cell('B4:K4', function($cell) {
                    $cell->setBackground('#DDEBF7');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                });
                $sheet->cell('B3', function($cell) {
                    $cell->setValue('Nº');
                });
                $sheet->mergeCells('B4:D4');
                $sheet->cell('C3', function($cell) {
                    $cell->setValue('CODIGO');
                });
                $sheet->cell('D3', function($cell) {
                    $cell->setValue('NOMBRE DE PROYECTO');
                });
                $sheet->cell('E3', function($cell) {
                    $cell->setValue('COSTO ACTUALIZADO');
                });
                $sheet->cell('E4', function($cell) {
                    $cell->setValue('A');
                });
                $sheet->cell('F3', function($cell) use ($anio) {
                    $cell->setValue('DEVENGADO ACUMULADO AL '.$anio);
                });
                $sheet->cell('F4', function($cell) {
                    $cell->setValue('B');
                });
                $sheet->cell('G3', function($cell) {
                    $cell->setValue('SALDO POR EJECUTAR');
                });
                $sheet->cell('G4', function($cell) {
                    $cell->setValue('(A - B)');
                });
                $sheet->cells('H3', function($cell) use ($anio) {
                    $cell->setValue('PIM '.$anio);
                });
                $sheet->cells('I3', function($cell) {
                    $cell->setValue('MONTO ANULACION');
                });
                $sheet->cell('I4', function($cell) {
                    $cell->setValue('C');
                });
                $sheet->cells('J3', function($cell) {
                    $cell->setValue('F12-B ACTUALIZADO');
                });
                $sheet->cell('J4', function($cell) {
                    $cell->setValue('D');
                });
                $sheet->mergeCells('K2:K3');
                $sheet->cells('K2', function($cell) {
                    $cell->setValignment('center');
                    $cell->setAlignment('center');
                    $cell->setBackground('#DDD9C4');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '8',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('MONTO EL CUAL DEBERA SER ACTUALIZADO EN EL FOMATO 12-B ');
                });
                $sheet->cell('K4', function($cell) {
                    $cell->setValue('(D - C)');
                });
                
                if($fila_habilitador > 0){
                    $total_anulacion = 0;
                    $sheet->setColumnFormat(array(
                        'E5:K'.($fila_habilitador + $numero_empieza_habilitador) => '"S/." #,##0.00',
                    ));
                    $sheet->cells('B12', function($cell) use ($fila_habilitador, $numero_empieza_habilitador)  {
                        $cell->setValue( 'E5:K'.($fila_habilitador + $numero_empieza_habilitador));
                    });
                    $sheet->cells('B5:K'.($fila_habilitador + $numero_empieza_habilitador) , function($cells) {
                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '9',
                        ));
                    });
                    $sheet->cells('G5:G'.($fila_habilitador + $numero_empieza_habilitador) , function($cells) {
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('H5:H'.($fila_habilitador + $numero_empieza_habilitador) , function($cells) {
                        $cells->setFontColor('#0070c0');
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('I5:I'.($fila_habilitador + $numero_empieza_habilitador) , function($cells) {
                        $cells->setFontColor('#ff0000');
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('J5:J'.($fila_habilitador + $numero_empieza_habilitador) , function($cells) {
                        $cells->setFontColor('#7030a0');
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('K5:K'.($fila_habilitador + $numero_empieza_habilitador) , function($cells) {
                        $cells->setFontColor('#00b050');
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $fila_index_habilitador = 5; //Contar de B1
                    foreach($data1  as $index => $fila)
                    {
                        $total_anulacion += $fila[14];
                        $fila_inicio = $fila_index_habilitador + $index;
                        $sheet->setHeight(($fila_inicio), 75);
                        $sheet->row($fila_inicio, array(
                            null,$index + 1,$fila[1],$fila[2],$fila[3],$fila[41],$fila[6],$fila[7],-$fila[14],$fila[12],$fila[16]
                        ));
                    }
                    $sheet->mergeCells('B'.($fila_habilitador + $fila_index_habilitador).':H'.($fila_habilitador + $fila_index_habilitador));
                    $sheet->setBorder('B'.($fila_habilitador + $fila_index_habilitador).':I'.($fila_habilitador + $fila_index_habilitador), 'thin');
                    $sheet->setHeight(($fila_habilitador + $fila_index_habilitador), 21);
                    $sheet->cell('B'.($fila_habilitador + $fila_index_habilitador).':I'.($fila_habilitador + $fila_index_habilitador), function($cell) {
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '11',
                            'bold'       =>  true
                        ));
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setBackground('#E4DFEC');
                    });
                    $sheet->setColumnFormat(array(
                        'I'.($fila_habilitador + $fila_index_habilitador) => '"S/." #,##0.00',
                    ));
                    $sheet->cell('B'.($fila_habilitador + $fila_index_habilitador), function($cell) {
                        $cell->setValue('TOTAL');
                    });
                    $sheet->cell('I'.($fila_habilitador + $fila_index_habilitador), function($cell) use ($total_anulacion) {
                        $cell->setValue(-$total_anulacion);
                    });
                 }

                // Recorrer Filas Habilitado
                $numero_empieza_habilitado = 8;
                $sheet->setBorder('B'.($numero_empieza_habilitado - 1 + $fila_habilitador).':K'. ($numero_empieza_habilitado + $fila_habilitador + $fila_habilitado + 1), 'thin');
                $sheet->mergeCells('B'.($numero_empieza_habilitado - 1 + $fila_habilitador).':J'.($numero_empieza_habilitado - 1 + $fila_habilitador));
                $sheet->cell('B'.($numero_empieza_habilitado - 1 + $fila_habilitador), function($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                    $cell->setBackground('#D8E4BC');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('INVERSION HABILITADO - CREDITO');
                });
                $sheet->cell('B'.($numero_empieza_habilitado + $fila_habilitador).':J'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setBackground('#FCD5B4');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                });
                $sheet->cell('B'.($numero_empieza_habilitado + $fila_habilitador + 1).':K'.($numero_empieza_habilitado + $fila_habilitador + 1), function($cell) {
                    $cell->setBackground('#DDEBF7');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '11',
                        'bold'       =>  true,
                    ));
                });
                $sheet->cell('B'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setValue('Nº');
                });
                $sheet->mergeCells('B'.($numero_empieza_habilitado + $fila_habilitador + 1).':D'.($numero_empieza_habilitado + $fila_habilitador + 1));
                $sheet->cell('C'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setValue('CODIGO');
                });
                $sheet->cell('D'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setValue('NOMBRE DE PROYECTO');
                });
                $sheet->cell('E'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setValue('COSTO ACTUALIZADO');
                });
                $sheet->cell('E'.($numero_empieza_habilitado + $fila_habilitador + 1), function($cell) {
                    $cell->setValue('A');
                });
                $sheet->cell('F'.($numero_empieza_habilitado + $fila_habilitador), function($cell) use ($anio) {
                    $cell->setValue('DEVENGADO ACUMULADO AL '.$anio);
                });
                $sheet->cell('F'.($numero_empieza_habilitado + $fila_habilitador + 1), function($cell) {
                    $cell->setValue('B');
                });
                $sheet->cell('G'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setValue('SALDO POR EJECUTAR');
                });
                $sheet->cell('G'.($numero_empieza_habilitado + $fila_habilitador + 1), function($cell) {
                    $cell->setValue('(A - B)');
                });
                $sheet->cells('H'.($numero_empieza_habilitado + $fila_habilitador), function($cell) use ($anio) {
                    $cell->setValue('PIM '.$anio);
                });
                $sheet->cells('I'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setValue('CREDITO');
                });
                $sheet->cell('I'.($numero_empieza_habilitado + $fila_habilitador + 1), function($cell) {
                    $cell->setValue('C');
                });
                $sheet->cells('J'.($numero_empieza_habilitado + $fila_habilitador), function($cell) {
                    $cell->setValue('F12-B ACTUALIZADO');
                });
                $sheet->cell('J'.($numero_empieza_habilitado + $fila_habilitador + 1), function($cell) {
                    $cell->setValue('D');
                });
                $sheet->mergeCells('K'.($numero_empieza_habilitado - 1 + $fila_habilitador).':K'.($numero_empieza_habilitado + $fila_habilitador));
                $sheet->cell('K'.($numero_empieza_habilitado + $fila_habilitador + 1), function($cell) {
                    $cell->setValue('(D + C)');
                });
                $sheet->cells('K'.($numero_empieza_habilitado - 1 + $fila_habilitador), function($cell) {
                    $cell->setValignment('center');
                    $cell->setAlignment('center');
                    $cell->setBackground('#DDD9C4');
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '8',
                        'bold'       =>  true,
                    ));
                    $cell->setValue('MONTO EL CUAL DEBERA SER ACTUALIZADO EN EL FOMATO 12 B ');
                });
                if($fila_habilitado > 0){
                    $total_credito = 0;
                    $sheet->setColumnFormat(array(
                        'E'.($numero_empieza_habilitado + 2 + $fila_habilitador).':K'.($fila_habilitador + $fila_habilitado + 9) => '"S/." #,##0.00',
                    ));
                    $sheet->cells('B'.($numero_empieza_habilitado + 2 + $fila_habilitador).':K'.($fila_habilitador + $fila_habilitado + 9) , function($cells) {
                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '9',
                        ));
                    });
                    $sheet->cells('G'.($numero_empieza_habilitado + 2 + $fila_habilitador).':G'.($fila_habilitador + $fila_habilitado + 9) , function($cells) {
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('H'.($numero_empieza_habilitado + 2 + $fila_habilitador).':H'.($fila_habilitador + $fila_habilitado + 9) , function($cells) {
                        $cells->setFontColor('#0070c0');
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('I'.($numero_empieza_habilitado + 2 + $fila_habilitador).':I'.($fila_habilitador + $fila_habilitado + 9) , function($cells) {
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('J'.($numero_empieza_habilitado + 2 + $fila_habilitador).':J'.($fila_habilitador + $fila_habilitado + 9) , function($cells) {
                        $cells->setFontColor('#7030a0');
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $sheet->cells('K'.($numero_empieza_habilitado + 2 + $fila_habilitador).':K'.($fila_habilitador + $fila_habilitado + 9) , function($cells) {
                        $cells->setFontColor('#00b050');
                        $cells->setFont(array(
                            'bold'       =>  true,
                        ));
                    });
                    $fila_index_habilitado = 10; //Contar de B1
                    foreach($data2  as $index => $fila)
                    {
                        $total_credito += $fila[14];
                        $fila_inicio = $fila_index_habilitado + $fila_habilitador + $index;
                        $sheet->setHeight(($fila_inicio), 75);
                        $sheet->row($fila_inicio, array(
                            null,$index + 1,$fila[1],$fila[2],$fila[3],$fila[41],$fila[6],$fila[7],$fila[14],$fila[12],$fila[16]
                        ));
                    }
                    $sheet->mergeCells('B'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado).':H'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado));
                    $sheet->setBorder('B'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado).':I'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado), 'thin');
                    $sheet->setHeight(($fila_habilitador + $fila_habilitado + $fila_index_habilitado), 21);
                    $sheet->cell('B'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado).':I'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado), function($cell) {
                        $cell->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '11',
                            'bold'       =>  true
                        ));
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setBackground('#D8E4BC');
                    });
                    $sheet->setColumnFormat(array(
                        'I'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado) => '"S/." #,##0.00',
                    ));
                    $sheet->cell('B'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado), function($cell) {
                        $cell->setValue('TOTAL');
                    });
                    $sheet->cell('I'.($fila_habilitador + $fila_habilitado + $fila_index_habilitado), function($cell) use ($total_credito) {
                        $cell->setValue($total_credito);
                    });
                }
           
            });
        })->export('xls');
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
            // \Config::set('excel.import.startRow', 5);
            $data_verificar =  Excel::selectSheets('MP')->load($request->file('file')->getRealPath(), function ($reader){
            });
            if(count($data_verificar->toArray()) > 5){
                \Config::set('excel.import.startRow', 5);
                $data_excel =  Excel::selectSheets('MP')->load($request->file('file')->getRealPath(), function ($reader){
                });
                
                // Columnas
                $headerRow = $data_excel->first()->keys()->toArray();
                $resultado = array_diff($formato_excel, $headerRow);
                $data = [];
                $grupo = [];
                if(count($resultado) == 0){
                    foreach ($data_excel->toArray() as $key => $row) {
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
                            foreach ($data_excel->toArray() as $key => $row) {
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
