<?php

namespace sayhuite\Http\Controllers;
use sayhuite\Distrito;
use sayhuite\indicadoreducacionece;
use sayhuite\pobreza;
use sayhuite\salud;
use DB;
use Illuminate\Http\Request;

class ReportegeneralController extends Controller
{
  public function inicio()
  {
    $nivel=['REGIONAL' => "REGIONAL",'PROVINCIAL' => "PROVINCIAL",'DISTRITAL' => "DISTRITAL"];
    $provincia=Distrito::select('nom_prov')->whereNotNull ('nom_prov')->where('nom_prov','!=','')->orderBy('nom_prov')->distinct()->get();
    $provincia=$provincia->pluck('nom_prov', 'nom_prov')->toArray();
    $provincia = ['' => "SELECCIONAR PROVINCIA"] + $provincia;
    $distrito=Distrito::select(DB::RAW('UPPER(nom_dist) as nom_dist'))->whereNotNull ('nom_dist')->where('nom_dist','!=','')->orderBy('nom_dist')->distinct()->get();
    $distrito=$distrito->pluck('nom_dist', 'nom_dist')->toArray();
    return view('indicadores/reporte_general',['provincia'=> $provincia,'distrito'=> $distrito,'nivel'=> $nivel]);
  }

  public function distrito(Request $request)
  {
        $input  = $request->all();
        $distrito=Distrito::select(DB::RAW('UPPER(nom_dist) as nom_dist'))->whereNotNull ('nom_dist')->where('nom_dist','!=','')->where('nom_prov','=',$input['provincial'])->orderBy('nom_dist')->distinct()->get();
        $distrito=$distrito->pluck('nom_dist', 'nom_dist')->toArray();
        return Response($distrito);
  }

  public function data(Request $request)
  {
    $datos=[];
    $val_provincia=0;
    $nom_provincia;
    $val_distrito=0;
    $nom_distrito;
    $input  = $request->all();
    $ece_grupo=indicadoreducacionece::select('nivel', 'grado', 'competencia')->orderBy('nivel')->orderBy('grado')->orderBy('competencia')->distinct()->get();
    foreach ($ece_grupo as $key => $value) {
      $years=indicadoreducacionece::where('nivel','=',$value->nivel)->where('grado','=',$value->grado)->where('competencia','=',$value->competencia)->max('years');

      if ($input['regional']=='REGIONAL') {
            $data=indicadoreducacionece::select(DB::RAW("'REGIONAL' as nombre"),'satisfactorio as satisfactorio','years','nivel', 'grado', 'competencia')
                  ->where('resultado','=','REGIONAL')
                  ->where('nivel','=',$value->nivel)
                  ->where('grado','=',$value->grado)
                  ->where('competencia','=',$value->competencia)
                  ->where('years','=',$years)->first();
            array_push($datos,["regional"=>$data->nombre,
                              "nivel"=>$value->nivel,
                              "grado"=>$value->grado,
                              "years"=>$years,
                              "competencia"=>$value->competencia,
                              "satisfactorio_reg"=>$data->satisfactorio]);
      }
      elseif ($input['regional']=='PROVINCIAL' && !empty($input['provincial'])) {
            // DISTRITO
            $regional=indicadoreducacionece::select(DB::RAW("'REGIONAL' as nombre"),'satisfactorio as satisfactorio')
                  ->where('resultado','=','REGIONAL')
                  ->where('nivel','=',$value->nivel)
                  ->where('grado','=',$value->grado)
                  ->where('competencia','=',$value->competencia)
                  ->where('years','=',$years)->first();

            if (!empty($input['provincial'])) {
                  $data=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','years','nivel', 'grado', 'competencia')
                        ->whereNotNull ('provincia')->where('provincia','!=','')
                        ->where('resultado','=','PROVINCIAL')
                        ->where('provincia','=',$input['provincial'])
                        ->where('nivel','=',$value->nivel)
                        ->where('grado','=',$value->grado)
                        ->where('competencia','=',$value->competencia)
                        ->where('years','=',$years)->first();
            }
            else {
              $data="";
            }

            array_push($datos,["provincia"=>$data->nombre,
                              "nivel"=>$value->nivel,
                              "grado"=>$value->grado,
                              "years"=>$years,
                              "competencia"=>$value->competencia,
                              "satisfactorio_prov"=>$data->satisfactorio,
                              "regional"=>$regional->nombre,
                              "satisfactorio_reg"=>$regional->satisfactorio]);

            //FIN DISTRITO
      }
      elseif ($input['regional']=='DISTRITAL' && !empty($input['provincial'])) {

            $regional=indicadoreducacionece::select(DB::RAW("'REGIONAL' as nombre"),'satisfactorio as satisfactorio')
                  ->where('resultado','=','REGIONAL')
                  ->where('nivel','=',$value->nivel)
                  ->where('grado','=',$value->grado)
                  ->where('competencia','=',$value->competencia)
                  ->where('years','=',$years)->first();
            $provincia=indicadoreducacionece::select('provincia as nombre','satisfactorio as satisfactorio','years','nivel', 'grado', 'competencia')
                  ->whereNotNull ('provincia')->where('provincia','!=','')
                  ->where('resultado','=','PROVINCIAL')
                  ->where('provincia','=',$input['provincial'])
                  ->where('nivel','=',$value->nivel)
                  ->where('grado','=',$value->grado)
                  ->where('competencia','=',$value->competencia)
                  ->where('years','=',$years)->first();
            // DISTRITO
                if (!empty($input['distrital'])) {
                      $data=indicadoreducacionece::select('distrito as nombre','satisfactorio as satisfactorio','years','nivel', 'grado', 'competencia')
                            ->whereNotNull ('distrito')->where('distrito','!=','')
                            ->where('resultado','=','DISTRITAL')
                            ->where('provincia','=',$input['provincial'])
                            ->where('distrito','=',$input['distrital'])
                            ->where('nivel','=',$value->nivel)
                            ->where('grado','=',$value->grado)
                            ->where('competencia','=',$value->competencia)
                            ->where('years','=',$years)->first();
                }
                else {
                  $data="";
                }
            //FIN DISTRITO
            if (!isset($data->satisfactorio) && !isset($data->nombre)) {
                $val_distrito=0;
                $nom_distrito=$input['distrital'];
            }
            else {
                $val_distrito=$data->satisfactorio;
                $nom_distrito=$data->nombre;
            }
            array_push($datos,["nivel"=>$value->nivel,
                              "grado"=>$value->grado,
                              "years"=>$years,
                              "competencia"=>$value->competencia,
                              "regional"=>$regional->nombre,
                              "satisfactorio_reg"=>$regional->satisfactorio,
                              "provincia"=>$provincia->nombre,
                              "satisfactorio_prov"=>$provincia->satisfactorio,
                              "distrito"=>$nom_distrito,
                              "satisfactorio_dist"=>$val_distrito]);
        }
        else {
          $datos="";
        }
    }
    return $datos;
  }
  public function data_pobreza(Request $request)
  {
    $datos=[];
    $val_provincia=0;
    $nom_provincia;
    $val_distrito=0;
    $nom_distrito;
    $input  = $request->all();

    $years=pobreza::max('years');

      if ($input['regional']=='REGIONAL') {
            $data=pobreza::select(DB::RAW("'REGIONAL' as nombre"),'promedio')
            ->where('resultado','=','REGIONAL')
            ->where('years','=',$years)->first();
            array_push($datos,["years"=>$years,
                              "promedio_reg"=>$data->promedio,
                              "regional"=>$data->nombre]);
      }
      elseif ($input['regional']=='PROVINCIAL' && !empty($input['provincial'])) {
            // DISTRITO
            $regional=pobreza::select(DB::RAW("'REGIONAL' as nombre"),'promedio')
            ->where('resultado','=','REGIONAL')
            ->where('years','=',$years)->first();

            if (!empty($input['provincial'])) {
                  $data=pobreza::select('provincia as nombre','promedio')
                        ->whereNotNull ('provincia')->where('provincia','!=','')
                        ->where('resultado','=','PROVINCIAL')
                        ->where('provincia','=',$input['provincial'])
                        ->where('years','=',$years)->first();
            }
            else {
              $data="";
            }

            if (!isset($data->promedio) && !isset($data->nombre)) {
                $val_provincia=0;
                $nom_provincia=$input['provincial'];
            }
            else {
                $val_provincia=$data->promedio;
                $nom_provincia=$data->nombre;
            }
            array_push($datos,["years"=>$years,
                              "regional"=>$regional->nombre,
                              "promedio_reg"=>$regional->promedio,
                              "provincia"=>$nom_provincia,
                              "promedio_prov"=>$val_provincia]);
            //FIN DISTRITO
      }
      elseif ($input['regional']=='DISTRITAL' && !empty($input['provincial'])) {

            $regional=pobreza::select(DB::RAW("'REGIONAL' as nombre"),'promedio')
            ->where('resultado','=','REGIONAL')
            ->where('years','=',$years)->first();

            $provincia=pobreza::select('provincia as nombre','promedio')
                  ->whereNotNull ('provincia')->where('provincia','!=','')
                  ->where('resultado','=','PROVINCIAL')
                  ->where('provincia','=',$input['provincial'])
                  ->where('years','=',$years)->first();
            // DISTRITO
                if (!empty($input['distrital'])) {
                      $data=pobreza::select('provincia as nombre','promedio')
                            ->whereNotNull ('distrito')->where('distrito','!=','')
                            ->where('resultado','=','DISTRITAL')
                            ->where('provincia','=',$input['provincial'])
                            ->where('distrito','=',$input['distrital'])
                            ->where('years','=',$years)->first();
                }
                else {
                  $data="";
                }

            if (!isset($provincia->promedio) && !isset($provincia->nombre)) {
                $val_provincia=0;
                $nom_provincia=$input['provincial'];
            }
            else {
                $val_provincia=$provincia->promedio;
                $nom_provincia=$provincia->nombre;
            }
            //FIN DISTRITO
            if (!isset($data->promedio) && !isset($data->nombre)) {
                $val_distrito=0;
                $nom_distrito=$input['distrital'];
            }
            else {
                $val_distrito=$data->promedio;
                $nom_distrito=$data->nombre;
            }
            array_push($datos,["years"=>$years,
                              "regional"=>$regional->nombre,
                              "promedio_reg"=>$regional->promedio,
                              "provincia"=>$nom_provincia,
                              "promedio_prov"=>$val_provincia,
                              "distrito"=>$nom_distrito,
                              "promedio_dist"=>$val_distrito]);
        }

    return $datos;
  }
  public function data_salud(Request $request)
  {
    $datos=[];
    $val_provincia=0;
    $nom_provincia;
    $val_distrito=0;
    $nom_distrito;
    $input  = $request->all();
    $salud_grupo=salud::select('tipo')->orderBy('tipo')->distinct()->get();
    foreach ($salud_grupo as $key => $value) {
      $years=salud::where('tipo','=',$value->tipo)->max('years');

      if ($input['regional']=='REGIONAL') {
            $data=salud::select(DB::RAW("'REGIONAL' as nombre"),'valor')
            ->where('resultado','=','REGIONAL')
            ->where('tipo','=',$value->tipo)
            ->where('years','=',$years)->first();
            array_push($datos,["years"=>$years,
                              "valor_reg"=>$data->valor,
                              "tipo"=>$value->tipo,
                              "regional"=>$data->nombre]);
      }
      elseif ($input['regional']=='PROVINCIAL' && !empty($input['provincial'])) {

            $regional=salud::select(DB::RAW("'REGIONAL' as nombre"),'valor')
            ->where('resultado','=','REGIONAL')
            ->where('tipo','=',$value->tipo)
            ->where('years','=',$years)->first();

            if (!empty($input['provincial'])) {
                  $data=salud::select('provincia as nombre','valor')
                        ->whereNotNull ('provincia')->where('provincia','!=','')
                        ->where('resultado','=','PROVINCIAL')
                        ->where('tipo','=',$value->tipo)
                        ->where('provincia','=',$input['provincial'])
                        ->where('years','=',$years)->first();
            }
            else {
              $data="";
            }

            if (!isset($data->valor) && !isset($data->nombre)) {
                $val_provincia=0;
                $nom_provincia=$input['provincial'];
            }
            else {
                $val_provincia=$data->valor;
                $nom_provincia=$data->nombre;
            }
            array_push($datos,["years"=>$years,
                              "regional"=>$regional->nombre,
                              "tipo"=>$value->tipo,
                              "valor_reg"=>$regional->valor,
                              "provincia"=>$nom_provincia,
                              "valor_prov"=>$val_provincia]);
            //FIN DISTRITO
      }
      elseif ($input['regional']=='DISTRITAL' && !empty($input['provincial'])) {

            $regional=salud::select(DB::RAW("'REGIONAL' as nombre"),'valor')
            ->where('resultado','=','REGIONAL')
            ->where('tipo','=',$value->tipo)
            ->where('years','=',$years)->first();

            $provincia=salud::select('provincia as nombre','valor')
                  ->whereNotNull ('provincia')->where('provincia','!=','')
                  ->where('resultado','=','PROVINCIAL')
                  ->where('provincia','=',$input['provincial'])
                  ->where('tipo','=',$value->tipo)
                  ->where('years','=',$years)->first();;
            // DISTRITO
                if (!empty($input['distrital'])) {
                      $data=salud::select('provincia as nombre','valor')
                            ->whereNotNull ('distrito')->where('distrito','!=','')
                            ->where('resultado','=','DISTRITAL')
                            ->where('provincia','=',$input['provincial'])
                            ->where('distrito','=',$input['distrital'])
                            ->where('tipo','=',$value->tipo)
                            ->where('years','=',$years)->first();
                }
                else {
                  $data="";
                }

            if (!isset($provincia->valor) && !isset($provincia->nombre)) {
                $val_provincia=0;
                $nom_provincia=$input['provincial'];
            }
            else {
                $val_provincia=$provincia->valor;
                $nom_provincia=$provincia->nombre;
            }
            //FIN DISTRITO
            if (!isset($data->valor) && !isset($data->nombre)) {
                $val_distrito=0;
                $nom_distrito=$input['distrital'];
            }
            else {
                $val_distrito=$data->valor;
                $nom_distrito=$data->nombre;
            }
            array_push($datos,["years"=>$years,
                              "tipo"=>$value->tipo,
                              "regional"=>$regional->nombre,
                              "valor_reg"=>$regional->valor,
                              "provincia"=>$nom_provincia,
                              "valor_prov"=>$val_provincia,
                              "distrito"=>$nom_distrito,
                              "valor_dist"=>$val_distrito]);
        }
    }
    return $datos;
  }
}
