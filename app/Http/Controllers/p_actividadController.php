<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use DB;
use Illuminate\Support\Facades\Storage;
use sayhuite\Indicadoreducacionece;
use sayhuite\Consulta_siaf;
use View;
use File;
use Response;

class p_actividadController extends Controller
{
  public function inicio()
  {
      // $lec_satisfactorio= DB::select("select * from vw_consulta_siaf");
      //
      // $cuerpo='{
      //   "dataSource": {
      //   "dataSourceType": "json",
      //   "data": ';
      // $fin='},
      //         "slice": {
      //             "reportFilters": [
      //                   {
      //                       "uniqueName": "FASE",
      //                       "filter": {
      //                           "members": [
      //                               "FASE.DEVENGADO"
      //                           ]
      //                       }
      //                   },
      //                   {
      //                       "uniqueName": "TIPO",
      //                       "filter": {
      //                           "members": [
      //                               "TIPO.ACTIVIDAD"
      //                           ]
      //                       }
      //                   }
      //                 ],
      //             "rows": [
      //                 {
      //                     "uniqueName": "UNIDAD EJECUTORA"
      //                 },
      //                 {
      //                     "uniqueName": "GENERICA DE GASTOS"
      //                 },
      //                 {
      //                     "uniqueName": "SUB GENERICA DE GASTOS"
      //                 },
      //                 {
      //                     "uniqueName": "PROGRAMA PRESUPUESTAL"
      //                 },
      //                 {
      //                     "uniqueName": "PRODUCTO"
      //                 },
      //                 {
      //                     "uniqueName": "ACTIVIDAD"
      //                 },
      //                 {
      //                     "uniqueName": "FINANCIAMIENTO"
      //                 },
      //                 {
      //                     "uniqueName": "FUNCION"
      //                 }
      //             ],
      //             "columns": [
      //                 {
      //                     "uniqueName": "Measures"
      //                 }
      //             ],
      //             "measures": [
      //                 {
      //                     "uniqueName": "PIA",
      //                     "formula": "sum(\"PIA\") ",
      //                     "caption": "PIA"
      //                 },
      //                 {
      //                     "uniqueName": "PIM",
      //                     "formula": "sum(\"PIM\") ",
      //                     "caption": "PIM"
      //                 },
      //                 {
      //                     "uniqueName": "EJECUCION",
      //                     "formula": "sum(\"EJECUCION\") ",
      //                     "caption": "EJECUCIÓN",
      //                     "format": "3jxouse1"
      //                 },
      //                 {
      //                     "uniqueName": "Avance %",
      //                     "formula": "if( sum(\"PIM\") == 0,0 ,sum(\"EJECUCION\") / sum(\"PIM\") )",
      //                     "caption": "AVANCE %",
      //                     "format": "3jx51yjk"
      //                 },
      //                 {
      //                     "uniqueName": "Semaforo",
      //                     "formula": "sum(\"Avance %\")*100 - ((100/12)*max(\"MES\"))",
      //                     "caption": "SEMAFORO",
      //                     "format": "3jx5aaa9"
      //                 }
      //             ]
      //         },
      //         "options": {
      //             "grid": {
      //                 "showTotals": "off",
      //                 "showGrandTotals": "on"
      //             }
      //         },
      //         "formats": [
      //             {
      //                 "name": "3jx51yjk",
      //                 "thousandsSeparator": " ",
      //                 "decimalSeparator": ".",
      //                 "decimalPlaces": 2,
      //                 "currencySymbol": "",
      //                 "currencySymbolAlign": "left",
      //                 "nullValue": "0",
      //                 "textAlign": "right",
      //                 "isPercent": true
      //             },
      //             {
      //                 "name": "3jx5aaa9",
      //                 "thousandsSeparator": " ",
      //                 "decimalSeparator": ".",
      //                 "decimalPlaces": 2,
      //                 "currencySymbol": "",
      //                 "currencySymbolAlign": "left",
      //                 "nullValue": "",
      //                 "textAlign": "right",
      //                 "isPercent": false
      //             },
      //             {
      //                 "name": "3jxouse1",
      //                 "thousandsSeparator": " ",
      //                 "decimalSeparator": ".",
      //                 "decimalPlaces": 2,
      //                 "currencySymbol": "",
      //                 "currencySymbolAlign": "left",
      //                 "nullValue": "",
      //                 "textAlign": "right",
      //                 "isPercent": false
      //             }
      //         ],
      //         "tableSizes": {
      //             "columns": [
      //                 {
      //                     "idx": 0,
      //                     "width": 365
      //                 }
      //             ]
      //         },
      //         "localization": "https://raw.githubusercontent.com/WebDataRocks/pivot-localizations/master/es.json"
      //     }';
      //
      // $data=$cuerpo.json_encode($lec_satisfactorio).$fin;
      //
      // $fileName = '.json';
      // File::put(public_path('json/consulta_siaf'.$fileName),$data);

    $fecha=DB::select("select distinct fecha   FROM consulta_siaf");
    return view('actividad/actividad',['fecha'=>$fecha]);
  }

  public function datos()
  {
    // $lec_satisfactorio=Consulta_siaf::select(DB::RAW("(select EXTRACT(MONTH FROM now())) as mes,peru_distrito_.nom_prov as provincia, fuente_financiamiento.nombre_f_finan financiamiento,
    //  funcion.nombre_funcion as funcion,producto_proyecto.nombre_p_proy producto, programa_presupuestal.nombre_p_pres as presupuestal, actividad_obra.nombre_ct_obra as actividad,
    //  fase,presupuesto,total_prog as ejecucion, generica_gasto.nombre_g_gastos as gen_gastos,
    //  unidad_ejecutora.nombre ejecutora,pim"))
    // ->join("unidad_ejecutora","ejecutora","=","id")
    // ->join("generica_gasto","generica","=","id_g_gastos")
    // ->join("actividad_obra","act_ai_obra","=","id_act_obra")
    // ->join("programa_presupuestal","programa","=","id_p_pres")
    // ->join("producto_proyecto","prod_pry","=","id_p_proy")
    // ->join("funcion","funcion","=","id_funcion")
    // ->join("fuente_financiamiento","fuente_financ_agregada","=","id_f_finan")
    // ->join("peru_distrito_",DB::RAW("c_provincia::text"),"=","cod_prov")->limit(1);

    $lec_satisfactorio= DB::select("select * from vw_consulta_siaf");

    $cuerpo='{
      "dataSource": {
      "dataSourceType": "json",
      "data": ';
    $fin='},
            "slice": {
                "reportFilters": [
                    {
                        "uniqueName": "fase"
                    }
                ],
                "rows": [
                    {
                        "uniqueName": "ejecutora",
                        "caption": "UNIDAD EJECUTORA"
                    },
                    {
                        "uniqueName": "gen_gastos",
                        "caption": "GENERICA DE GASTOS"
                    },
                    {
                        "uniqueName": "presupuestal",
                        "caption": "PIA"
                    },
                    {
                        "uniqueName": "producto",
                        "caption": "PRODUCTO"
                    },
                    {
                        "uniqueName": "actividad",
                        "caption": "ACTIVIDAD"
                    },
                    {
                        "uniqueName": "financiamiento",
                        "caption": "FINANCIAMIENTO"
                    },
                    {
                        "uniqueName": "funcion",
                        "caption": "FUNCIÓN/SECTOR"
                    },
                    {
                        "uniqueName": "provincia",
                        "caption": "PROVINCIA"
                    }

                ],
                "columns": [
                    {
                        "uniqueName": "Measures"
                    }
                ],
                "measures": [
                    {
                        "uniqueName": "PIA",
                        "formula": "sum(\"presupuesto\") ",
                        "caption": "PIA"
                    },
                    {
                        "uniqueName": "PIM",
                        "formula": "sum(\"pim\") ",
                        "caption": "PIM"
                    },
                    {
                        "uniqueName": "EJECUCION",
                        "formula": "sum(\"ejecucion\") ",
                        "caption": "EJECUCIÓN",
                        "format": "3jxouse1"
                    },
                    {
                        "uniqueName": "Avance %",
                        "formula": "if( sum(\"pim\") == 0,0 ,sum(\"ejecucion\") / sum(\"pim\") )",
                        "caption": "AVANCE %",
                        "format": "3jx51yjk"
                    },
                    {
                        "uniqueName": "Semaforo",
                        "formula": "sum(\"Avance %\") - ((100/12)*max(\"mes\"))",
                        "caption": "SEMAFORO",
                        "format": "3jx5aaa9"
                    }
                ]
            },
            "options": {
                "grid": {
                    "showTotals": "columns",
                    "showGrandTotals": "columns"
                }
            },
            "formats": [
                {
                    "name": "3jx51yjk",
                    "thousandsSeparator": " ",
                    "decimalSeparator": ".",
                    "decimalPlaces": 2,
                    "currencySymbol": "",
                    "currencySymbolAlign": "left",
                    "nullValue": "0",
                    "textAlign": "right",
                    "isPercent": true
                },
                {
                    "name": "3jx5aaa9",
                    "thousandsSeparator": " ",
                    "decimalSeparator": ".",
                    "decimalPlaces": 2,
                    "currencySymbol": "",
                    "currencySymbolAlign": "left",
                    "nullValue": "",
                    "textAlign": "right",
                    "isPercent": false
                },
                {
                    "name": "3jxouse1",
                    "thousandsSeparator": " ",
                    "decimalSeparator": ".",
                    "decimalPlaces": 2,
                    "currencySymbol": "",
                    "currencySymbolAlign": "left",
                    "nullValue": "",
                    "textAlign": "right",
                    "isPercent": false
                }
            ],
            "tableSizes": {
                "columns": [
                    {
                        "idx": 0,
                        "width": 365
                    }
                ]
            },
            "localization": "https://raw.githubusercontent.com/WebDataRocks/pivot-localizations/master/es.json"
        }';

    $data=$cuerpo.json_encode($lec_satisfactorio).$fin;

    $fileName = '.json';
    File::put(public_path('json/consulta_siaf'.$fileName),$data);
  }
}
