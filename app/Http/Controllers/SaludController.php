<?php

namespace sayhuite\Http\Controllers;
use sayhuite\salud;
use sayhuite\salud_desnutricion;
use sayhuite\salud_anemia;
use sayhuite\salud_sis;
use sayhuite\salud_hemoglobina;
use sayhuite\salud_seguro;
use DB;
use Illuminate\Http\Request;

class SaludController extends Controller
{
  public function inicio()
  {
    $fuente=salud::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=salud::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=salud::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->orderBy('distrito')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=salud::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    $tipo=salud::select('tipo')->whereNotNull ('tipo')->distinct()->orderBy('tipo','desc')->get();
    $tipo=$tipo->pluck('tipo', 'tipo')->toArray();
    return view('indicadores/salud/salud',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente,'tipo'=> $tipo]);
  }

  public function distrito(Request $request)
  {
    $input  = $request->all();

    if (isset($input['opc'])) {
      if ($input['opc']=='desnutricion') {
        $distrito=salud_desnutricion::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
        $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
      }
      elseif ($input['opc']=='anemia') {
        $distrito=salud_anemia::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
        $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
      }
      elseif ($input['opc']=='sis') {
        $distrito=salud_sis::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
        $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
      }
      elseif ($input['opc']=='hemoglobina') {
        $distrito=salud_hemoglobina::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
        $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
      }
      elseif ($input['opc']=='seguro') {
        $distrito=salud_hemoglobina::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
        $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
      }
    }
    else {
      $distrito=salud::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->where('provincia','=',$input['provincial'])->orderBy('distrito')->distinct()->get();
      $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    }
    return Response($distrito);
  }

  public function data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud::select(DB::RAW("'REGIONAL' as nombre"),'tipo','valor','years')
                ->where('resultado','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('years','=',$input['years'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud::select('provincia as nombre','tipo','valor','years')
                    ->where('resultado','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud::select('provincia as nombre','tipo','valor','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud::select('distrito as nombre','tipo','valor','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('resultado','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud::select('provincia as nombre','tipo','valor','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('resultado','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud::select('distrito as nombre','tipo','valor','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('resultado','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=salud::select('distrito as nombre','tipo','valor','years')
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

  public function desnutricion()
  {
    $fuente=salud_desnutricion::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=salud_desnutricion::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=salud_desnutricion::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=salud_desnutricion::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    $tipo=salud_desnutricion::select('tipo')->whereNotNull ('tipo')->distinct()->orderBy('tipo','desc')->get();
    $tipo=$tipo->pluck('tipo', 'tipo')->toArray();
    $edad=salud_desnutricion::select('edad')->whereNotNull ('edad')->distinct()->orderBy('edad','desc')->get();
    $edad=$edad->pluck('edad', 'edad')->toArray();
    return view('indicadores/salud/desnutricion',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente,'tipo'=> $tipo,'edad'=> $edad]);
  }

  public function desnutricionyears(Request $request)
  {
        $input = $request->all();
        $years = salud_desnutricion::select('years')->where('tipo','=',$input['tipo'])->where('edad','=',$input['edad'])->distinct()->get();
        $years = $years->pluck('years', 'years')->toArray();
        return Response($years);
  }

  public function desnutricion_data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_desnutricion::select(DB::RAW("'REGIONAL' as nombre"),'n_evaluados','n_casos','porcentaje','tipo','years')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('years','=',$input['years'])
                ->where('edad','=',$input['edad'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_desnutricion::select('provincia as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('years','=',$input['years'])
                    ->where('edad','=',$input['edad'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_desnutricion::select('provincia as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('years','=',$input['years'])
                      ->where('edad','=',$input['edad'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_desnutricion::select('distrito as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('years','=',$input['years'])
                    ->where('edad','=',$input['edad'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_desnutricion::select('provincia as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('years','=',$input['years'])
                      ->where('edad','=',$input['edad'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_desnutricion::select('distrito as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('years','=',$input['years'])
                                    ->where('edad','=',$input['edad'])->get();
                      }
                      else {
                              $data=salud_desnutricion::select('distrito as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('years','=',$input['years'])
                                    ->where('edad','=',$input['edad'])->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function desnutricion_grafica(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_desnutricion::select(DB::RAW("'REGIONAL' as nombre"),'n_evaluados','n_casos','porcentaje','tipo','years')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('edad','=',$input['edad'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_desnutricion::select('provincia as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_desnutricion::select('provincia as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_desnutricion::select('distrito as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_desnutricion::select('provincia as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_desnutricion::select('distrito as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])->get();
                      }
                      else {
                              $data=salud_desnutricion::select('distrito as nombre','n_evaluados','n_casos','porcentaje','tipo','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function anemia()
  {
    $fuente=salud_anemia::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=salud_anemia::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=salud_anemia::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=salud_anemia::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    $tipo=salud_anemia::select('tipo')->whereNotNull ('tipo')->distinct()->orderBy('tipo','desc')->get();
    $tipo=$tipo->pluck('tipo', 'tipo')->toArray();
    $edad=salud_anemia::select('edad')->whereNotNull ('edad')->distinct()->orderBy('edad','desc')->get();
    $edad=$edad->pluck('edad', 'edad')->toArray();
    return view('indicadores/salud/anemia',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente,'tipo'=> $tipo,'edad'=> $edad]);
  }

  public function anemia_data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_anemia::select(DB::RAW("'REGIONAL' as nombre"),'n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('edad','=',$input['edad'])
                ->where('years','=',$input['years'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->where('years','=',$input['years'])->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function anemia_grafica(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_anemia::select(DB::RAW("'REGIONAL' as nombre"),'n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('edad','=',$input['edad'])
                ->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->get();
                      }
                      else {
                              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function sis()
  {
    $fuente=salud_sis::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=salud_sis::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=salud_sis::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=salud_sis::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    $tipo=salud_sis::select('tipo')->whereNotNull ('tipo')->distinct()->orderBy('tipo','desc')->get();
    $tipo=$tipo->pluck('tipo', 'tipo')->toArray();
    $edad=salud_sis::select('edad')->whereNotNull ('edad')->distinct()->orderBy('edad','desc')->get();
    $edad=$edad->pluck('edad', 'edad')->toArray();
    return view('indicadores/salud/sis',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente,'tipo'=> $tipo,'edad'=> $edad]);
  }

  public function sis_data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_sis::select(DB::RAW("'REGIONAL' as nombre"),'ninos_dni','por_ninos_dni','ninos_supl','por_ninos_supl','ninos_atencion','por_ninos_atencion','ninos_vac_neumococo','por_ninos_vac_neumococo','ninos_vac_rotavirus',
          'por_ninos_vac_rotavirus','ninos_vac_rotneu','por_ninos_vac_rotneu','ninos_fed','por_ninos_fed','years','tipo')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('edad','=',$input['edad'])
                ->where('years','=',$input['years'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_sis::select('provincia as nombre','ninos_dni','por_ninos_dni','ninos_supl','por_ninos_supl','ninos_atencion','por_ninos_atencion','ninos_vac_neumococo','por_ninos_vac_neumococo','ninos_vac_rotavirus',
              'por_ninos_vac_rotavirus','ninos_vac_rotneu','por_ninos_vac_rotneu','ninos_fed','por_ninos_fed','years','tipo')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_sis::select('provincia as nombre','ninos_dni','por_ninos_dni','ninos_supl','por_ninos_supl','ninos_atencion','por_ninos_atencion','ninos_vac_neumococo','por_ninos_vac_neumococo','ninos_vac_rotavirus',
                'por_ninos_vac_rotavirus','ninos_vac_rotneu','por_ninos_vac_rotneu','ninos_fed','por_ninos_fed','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_sis::select('distrito as nombre','ninos_dni','por_ninos_dni','ninos_supl','por_ninos_supl','ninos_atencion','por_ninos_atencion','ninos_vac_neumococo','por_ninos_vac_neumococo','ninos_vac_rotavirus',
              'por_ninos_vac_rotavirus','ninos_vac_rotneu','por_ninos_vac_rotneu','ninos_fed','por_ninos_fed','years','tipo')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_sis::select('provincia as nombre','ninos_dni','por_ninos_dni','ninos_supl','por_ninos_supl','ninos_atencion','por_ninos_atencion','ninos_vac_neumococo','por_ninos_vac_neumococo','ninos_vac_rotavirus',
                'por_ninos_vac_rotavirus','ninos_vac_rotneu','por_ninos_vac_rotneu','ninos_fed','por_ninos_fed','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_sis::select('distrito as nombre','ninos_dni','por_ninos_dni','ninos_supl','por_ninos_supl','ninos_atencion','por_ninos_atencion','ninos_vac_neumococo','por_ninos_vac_neumococo','ninos_vac_rotavirus',
                              'por_ninos_vac_rotavirus','ninos_vac_rotneu','por_ninos_vac_rotneu','ninos_fed','por_ninos_fed','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=salud_sis::select('distrito as nombre','ninos_dni','por_ninos_dni','ninos_supl','por_ninos_supl','ninos_atencion','por_ninos_atencion','ninos_vac_neumococo','por_ninos_vac_neumococo','ninos_vac_rotavirus',
                              'por_ninos_vac_rotavirus','ninos_vac_rotneu','por_ninos_vac_rotneu','ninos_fed','por_ninos_fed','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->where('years','=',$input['years'])->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function sis_grafica(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_anemia::select(DB::RAW("'REGIONAL' as nombre"),'n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('edad','=',$input['edad'])
                ->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_anemia::select('provincia as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->get();
                      }
                      else {
                              $data=salud_anemia::select('distrito as nombre','n_evaluados','n_casos_total','porc_total','n_casos_leve','porc_leve','n_casos_moderada','porc_moderada','n_casos_severa','porc_severa','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function hemoglobina()
  {
    $fuente=salud_hemoglobina::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=salud_hemoglobina::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=salud_hemoglobina::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=salud_hemoglobina::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    $tipo=salud_hemoglobina::select('tipo')->whereNotNull ('tipo')->distinct()->orderBy('tipo','desc')->get();
    $tipo=$tipo->pluck('tipo', 'tipo')->toArray();
    $edad=salud_hemoglobina::select('edad')->whereNotNull ('edad')->distinct()->orderBy('edad','desc')->get();
    $edad=$edad->pluck('edad', 'edad')->toArray();
    return view('indicadores/salud/hemoglobina',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente,'tipo'=> $tipo,'edad'=> $edad]);
  }

  public function hemoglobina_data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_hemoglobina::select(DB::RAW("'REGIONAL' as nombre"),'resultado', 'n_prueba','years','tipo')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('edad','=',$input['edad'])
                ->where('years','=',$input['years'])->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_hemoglobina::select('provincia as nombre','resultado', 'n_prueba','years','tipo')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_hemoglobina::select('provincia as nombre','resultado', 'n_prueba','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_hemoglobina::select('distrito as nombre','resultado', 'n_prueba','years','tipo')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_hemoglobina::select('provincia as nombre','resultado', 'n_prueba','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_hemoglobina::select('distrito as nombre','resultado', 'n_prueba','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=salud_hemoglobina::select('distrito as nombre','resultado', 'n_prueba','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->where('years','=',$input['years'])->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function hemoglobina_grafica(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_hemoglobina::select(DB::RAW("'REGIONAL' as nombre"),'resultado', 'n_prueba','years','tipo')
                ->where('ambito','=',$input['regional'])
                ->where('tipo','=',$input['tipo'])
                ->where('edad','=',$input['edad'])
                ->get();

    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_hemoglobina::select('provincia as nombre','resultado', 'n_prueba','years','tipo')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_hemoglobina::select('provincia as nombre','resultado', 'n_prueba','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_hemoglobina::select('distrito as nombre','resultado', 'n_prueba','years','tipo')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('tipo','=',$input['tipo'])
                    ->where('edad','=',$input['edad'])
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_hemoglobina::select('provincia as nombre','resultado', 'n_prueba','years','tipo')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('tipo','=',$input['tipo'])
                      ->where('edad','=',$input['edad'])
                      ->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_hemoglobina::select('distrito as nombre','resultado', 'n_prueba','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->get();
                      }
                      else {
                              $data=salud_hemoglobina::select('distrito as nombre','resultado', 'n_prueba','years','tipo')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('distrito','=',$input['distrital'])
                                    ->where('tipo','=',$input['tipo'])
                                    ->where('edad','=',$input['edad'])
                                    ->get();
                      }
                }
          }
          //FIN DISTRITO
      }
    return $data;
  }

  public function seguro()
  {
    $fuente=salud_seguro::select('fuente')->distinct()->first();
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=salud_seguro::select('provincia')->whereNotNull ('provincia')->where('provincia','!=','')->orderBy('provincia')->distinct()->get();
    $provincia=$provincia->pluck('provincia', 'provincia')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA",'' => "TODOS"] + $provincia;
    $distrito=salud_seguro::select('distrito')->whereNotNull ('distrito')->where('distrito','!=','')->distinct()->get();
    $distrito=$distrito->pluck('distrito', 'distrito')->toArray();
    $years=salud_seguro::select('years')->whereNotNull ('years')->distinct()->orderBy('years','desc')->get();
    $years=$years->pluck('years', 'years')->toArray();
    return view('indicadores/salud/seguro',['provincia'=> $provincia,'distrito'=> $distrito,'years'=> $years,'nivel'=> $nivel,'fuente'=> $fuente]);
  }

  public function seguro_data(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_seguro::select(DB::RAW("'REGIONAL' as nombre"),'total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                ->where('ambito','=',$input['regional'])
                ->where('years','=',$input['years'])->get();
    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_seguro::select('provincia as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                    ->where('ambito','=','PROVINCIAL')
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_seguro::select('provincia as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('years','=',$input['years'])->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_seguro::select('distrito as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->where('years','=',$input['years'])->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_seguro::select('provincia as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->where('years','=',$input['years'])->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_seguro::select('distrito as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->where('years','=',$input['years'])->get();
                      }
                      else {
                              $data=salud_seguro::select('distrito as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
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

  public function seguro_grafica(Request $request)
  {
    $input  = $request->all();

    if ($input['regional']=='REGIONAL') {
          $data=salud_seguro::select(DB::RAW("'REGIONAL' as nombre"),'total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                ->where('ambito','=',$input['regional'])
                ->get();
    }
    elseif ($input['regional']=='PROVINCIAL') {
              $data=salud_seguro::select('provincia as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                    ->where('ambito','=','PROVINCIAL')
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_seguro::select('provincia as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->get();
          }
          //FIN DISTRITO
    }
    elseif ($input['regional']=='DISTRITAL') {
              $data=salud_seguro::select('distrito as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                    ->whereNotNull ('distrito')->where('distrito','!=','')
                    ->where('ambito','=','DISTRITAL')
                    ->get();
          // DISTRITO
          if (!empty($input['provincial'])) {
                $data=salud_seguro::select('provincia as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                      ->whereNotNull ('provincia')->where('provincia','!=','')
                      ->where('ambito','=','PROVINCIAL')
                      ->where('provincia','=',$input['provincial'])
                      ->get();
                if (!empty($input['distrital'])) {
                      if ($input['distrital']=='TODOS') {
                              $data=salud_seguro::select('distrito as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
                                    ->where('provincia','=',$input['provincial'])
                                    ->get();
                      }
                      else {
                              $data=salud_seguro::select('distrito as nombre','total','essalud','ffaapnp','seg_privado','sis','otro','no_tiene','years')
                                    ->whereNotNull ('distrito')->where('distrito','!=','')
                                    ->where('ambito','=','DISTRITAL')
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
