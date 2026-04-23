<?php

namespace sayhuite\Http\Controllers;
use sayhuite\pobreza;
use DB;
use Illuminate\Http\Request;

class PobrezaController extends Controller
{
  public function inicio()
  {
    $fuente=pobreza::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=pobreza::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=pobreza::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->orderBy('distrito')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=pobreza::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    return view('indicadores/pobreza/pobreza',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente]);
  }

  public function distrito(Request $request)
  {
        $input  = $request->all();
        $distrito=pobreza::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->where('years','=',$input['years'])->orderBy('distrito')->distinct()->get();
        $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
        return Response($distrito);
  }

  public function data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=pobreza::select(DB::RAW("'REGIONAL' as nombre"),'inferior','superior','promedio','years')
                ->where('resultado','=',$input['regional'])
                ->where('years','=',$input['years'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=pobreza::select('provincia as nombre','inferior','superior','promedio','years')
                    ->where('resultado','=','PROVINCIAL')
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=pobreza::select('provincia as nombre','inferior','superior','promedio','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=pobreza::select('distrito as nombre','inferior','superior','promedio','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('resultado','=','DISTRITAL')
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=pobreza::select('provincia as nombre','inferior','superior','promedio','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=pobreza::select('distrito as nombre','inferior','superior','promedio','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=pobreza::select('distrito as nombre','inferior','superior','promedio','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('years','=',$input['years'])->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function data_grafica(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=pobreza::select(DB::RAW("'REGIONAL' as nombre"),'inferior','superior','promedio','years')
                ->where('resultado','=',$input['regional'])
                ->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=pobreza::select('provincia as nombre','inferior','superior','promedio','years')
                    ->where('resultado','=','PROVINCIAL')
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=pobreza::select('provincia as nombre','inferior','superior','promedio','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=pobreza::select('distrito as nombre','inferior','superior','promedio','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('resultado','=','DISTRITAL')
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=pobreza::select('provincia as nombre','inferior','superior','promedio','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=pobreza::select('distrito as nombre','inferior','superior','promedio','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->get();
                      }
                      else {
                              $data=pobreza::select('distrito as nombre','inferior','superior','promedio','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }
}
