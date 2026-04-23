<?php

namespace sayhuite\Http\Controllers;
use sayhuite\vivienda;
use Illuminate\Http\Request;

class ViviendaController extends Controller
{
  public function inicio()
  {
    $fuente=vivienda::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=vivienda::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=vivienda::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->orderBy('distrito')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=vivienda::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    return view('indicadores/salud/salud',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente]);
  }

  public function distrito(Request $request)
  {
    $input  = $request->all();


      $distrito=vivienda::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
      $distrito=$distrito->pluck('distrito', 'distrito')->toArray();

      return Response($distrito);
  }

  public function data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=vivienda::select(DB::RAW("'REGIONAL' as nombre"),'total_vivienda','total_hogar','total_pob_resi','casa_independiente','departamento_edificio','vivienda_quinta','vivienda_casa_vecindad','choza','vivienda_improvisada','otro','years')
                ->where('resultado','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('years','=',$input['years'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=vivienda::select('provincia as nombre','total_vivienda','total_hogar','total_pob_resi','casa_independiente','departamento_edificio','vivienda_quinta','vivienda_casa_vecindad','choza','vivienda_improvisada','otro','years')
                    ->where('resultado','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=vivienda::select('provincia as nombre','total_vivienda','total_hogar','total_pob_resi','casa_independiente','departamento_edificio','vivienda_quinta','vivienda_casa_vecindad','choza','vivienda_improvisada','otro','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=vivienda::select('distrito as nombre','total_vivienda','total_hogar','total_pob_resi','casa_independiente','departamento_edificio','vivienda_quinta','vivienda_casa_vecindad','choza','vivienda_improvisada','otro','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('resultado','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=vivienda::select('provincia as nombre','total_vivienda','total_hogar','total_pob_resi','casa_independiente','departamento_edificio','vivienda_quinta','vivienda_casa_vecindad','choza','vivienda_improvisada','otro','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=vivienda::select('distrito as nombre','total_vivienda','total_hogar','total_pob_resi','casa_independiente','departamento_edificio','vivienda_quinta','vivienda_casa_vecindad','choza','vivienda_improvisada','otro','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=vivienda::select('distrito as nombre','total_vivienda','total_hogar','total_pob_resi','casa_independiente','departamento_edificio','vivienda_quinta','vivienda_casa_vecindad','choza','vivienda_improvisada','otro','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
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
          $data=salud::select(DB::RAW("'REGIONAL' as nombre"),'tipo','valor','years')
                ->where('resultado','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud::select('provincia as nombre','tipo','valor','years')
                    ->where('resultado','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud::select('provincia as nombre','tipo','valor','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud::select('distrito as nombre','tipo','valor','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('resultado','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud::select('provincia as nombre','tipo','valor','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud::select('distrito as nombre','tipo','valor','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->get();
                      }
                      else {
                              $data=salud::select('distrito as nombre','tipo','valor','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

}
