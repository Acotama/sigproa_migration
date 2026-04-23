<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\indicadoreducacionece;
use DB;
class IndicadoreseducacioneceController extends Controller
{
  public function inicio()
  {
    $fuente=indicadoreducacionece::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=indicadoreducacionece::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=indicadoreducacionece::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->orderBy('distrito')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    // $years=indicadoreducacionece::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    // $years=$years->pluck('years', 'years')->toArray();
    return view('indicadores/educacion/ece',['provincia'=> $provincia,'distrito'=> $distrito,'nivel'=> $nivel,'fuente'=> $fuente]);
  }

  public function distrito(Request $request)
  {
        $input  = $request->all();
        $distrito=indicadoreducacionece::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
        $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
        return Response($distrito);
  }

  public function grado(Request $request)
  {
        $input  = $request->all();
        $grado=indicadoreducacionece::select('grado')->where('nivel','=',$input['nivel'])->distinct()->get();
        $grado=$grado->pluck('grado', 'grado')->toArray();
        return Response($grado);
  }

  public function competencia(Request $request)
  {
        $input  = $request->all();
        $competencia=indicadoreducacionece::select('competencia')->where('nivel','=',$input['nivel'])->where('grado','=',$input['grado'])->distinct()->get();
        $competencia=$competencia->pluck('competencia', 'competencia')->toArray();
        return Response($competencia);
  }

  public function years(Request $request)
  {
        $input = $request->all();
        $years = indicadoreducacionece::select('years')->where('nivel','=',$input['nivel'])->where('grado','=',$input['grado'])->where('competencia','=',$input['competencia'])->distinct()->get();
        $years = $years->pluck('years', 'years')->toArray();
        return Response($years);
  }

  public function data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=indicadoreducacionece::select(DB::RAW("'REGIONAL' as nombre"),'satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                ->where('resultado','=',$input['regional'])
                ->where('nivel','=',$input['nivel'])
                ->where('grado','=',$input['grado'])
                ->where('competencia','=',$input['competencia'])
                ->where('years','=',$input['years'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                    ->where('resultado','=','PROVINCIAL')
                    ->where('nivel','=',$input['nivel'])
                    ->where('grado','=',$input['grado'])
                    ->where('competencia','=',$input['competencia'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('nivel','=',$input['nivel'])
                      ->where('grado','=',$input['grado'])
                      ->where('competencia','=',$input['competencia'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=indicadoreducacionece::select('distrito as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('resultado','=','DISTRITAL')
                    ->where('nivel','=',$input['nivel'])
                    ->where('grado','=',$input['grado'])
                    ->where('competencia','=',$input['competencia'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('nivel','=',$input['nivel'])
                      ->where('grado','=',$input['grado'])
                      ->where('competencia','=',$input['competencia'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=indicadoreducacionece::select('distrito as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('nivel','=',$input['nivel'])
                                    ->where('grado','=',$input['grado'])
                                    ->where('competencia','=',$input['competencia'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=indicadoreducacionece::select('distrito as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('nivel','=',$input['nivel'])
                                    ->where('grado','=',$input['grado'])
                                    ->where('competencia','=',$input['competencia'])
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
          $data=indicadoreducacionece::select(DB::RAW("'REGIONAL' as nombre"),'satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                ->where('resultado','=',$input['regional'])
                ->where('nivel','=',$input['nivel'])
                ->where('grado','=',$input['grado'])
                ->where('competencia','=',$input['competencia'])
                ->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                    ->where('resultado','=','PROVINCIAL')
                    ->where('nivel','=',$input['nivel'])
                    ->where('grado','=',$input['grado'])
                    ->where('competencia','=',$input['competencia'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('nivel','=',$input['nivel'])
                      ->where('grado','=',$input['grado'])
                      ->where('competencia','=',$input['competencia'])
                      ->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=indicadoreducacionece::select('distrito as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('resultado','=','DISTRITAL')
                    ->where('nivel','=',$input['nivel'])
                    ->where('grado','=',$input['grado'])
                    ->where('competencia','=',$input['competencia'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('nivel','=',$input['nivel'])
                      ->where('grado','=',$input['grado'])
                      ->where('competencia','=',$input['competencia'])
                      ->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=indicadoreducacionece::select('distrito as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('nivel','=',$input['nivel'])
                                    ->where('grado','=',$input['grado'])
                                    ->where('competencia','=',$input['competencia'])
                                    ->get();
                      }
                      else {
                              $data=indicadoreducacionece::select('distrito as nombre','satisfactorio as satisfactorio','enproceso as proceso','inicio as inicio','previoinicio as previo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('nivel','=',$input['nivel'])
                                    ->where('grado','=',$input['grado'])
                                    ->where('competencia','=',$input['competencia'])
                                    ->get();
                      }
                }
          }
          //FIN DISTRITO
      }

    return $data;
  }
}
