<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use sayhuite\Models\Anulacion; 
use sayhuite\Models\Credito; 
use sayhuite\Models\Detalle_anu_cred; 
use DateTime;
use Excel;

class HabilitadoresController extends Controller
{
    public function inicio(){
        return view('habilitadores.inicio');
    }

    public function anulacion(Request $request){
        $input = $request->all();
        $anulacion = Detalle_anu_cred::select(DB::raw("tb_anulacion.cod_uni,nom_proyec,saldo_anulado,tb_documento_anulacion.nombre_documento,tb_detalle_anu_cred.id_documento "))
        ->join("tb_anulacion","tb_detalle_anu_cred.id_anulacion","tb_anulacion.id_anulacion")
        ->join("tb_documento_anulacion","tb_detalle_anu_cred.id_documento","tb_documento_anulacion.id_documento")
        ->leftjoin("vw_pry_habilitadores_all","vw_pry_habilitadores_all.cod_unif","tb_anulacion.cod_uni")
        ->where("tb_documento_anulacion.anio",$input["anio"])
        ->distinct()->get();

        return Response([
            'data' => $anulacion
        ]);
    }

    public function credito(Request $request){
        $input = $request->all();
        $documento = DB::table("tb_documento_anulacion")->where('id_documento',$input['id_documento'])->first();

        $anulacion = Detalle_anu_cred::select(DB::raw("tb_anulacion.cod_uni,nom_proyec,tb_anulacion.saldo_anulado,m_pip,m_deveng_a,(m_pip - m_deveng_a) as saldo_ejecutar,pia_dia,
        pim_dia,CASE  WHEN m_pip is null or m_pip = 0  then 0 else round((m_deveng_a/m_pip)*100,2) end as avance_finan,tb_documento_anulacion.nombre_documento"))
        ->join("tb_anulacion","tb_detalle_anu_cred.id_anulacion","tb_anulacion.id_anulacion")
        ->join("tb_documento_anulacion","tb_detalle_anu_cred.id_documento","tb_documento_anulacion.id_documento")
        ->leftjoin("vw_pry_habilitadores_all","vw_pry_habilitadores_all.cod_unif","tb_anulacion.cod_uni")
        ->where("tb_detalle_anu_cred.id_documento",$input["id_documento"])
        ->where("tb_documento_anulacion.anio",$input["anio"])
        ->distinct()->get();

        $credito = Detalle_anu_cred::select(DB::raw("tb_credito.cod_uni,nom_proyec,tb_credito.credito,m_pip,m_deveng_a,(m_pip - m_deveng_a) as saldo_ejecutar,pia_dia,
        pim_dia,CASE  WHEN m_pip is null or m_pip = 0  then 0 else round((m_deveng_a/m_pip)*100,2) end as avance_finan,tb_documento_anulacion.nombre_documento"))
        ->join("tb_credito","tb_detalle_anu_cred.id_credito","tb_credito.id_credito")
        ->join("tb_documento_anulacion","tb_detalle_anu_cred.id_documento","tb_documento_anulacion.id_documento")
        ->leftjoin("vw_pry_habilitadores_all","vw_pry_habilitadores_all.cod_unif","tb_credito.cod_uni")
        ->where("tb_detalle_anu_cred.id_documento",$input["id_documento"])
        ->where("tb_documento_anulacion.anio",$input["anio"])
        ->distinct()->get();

        return Response([
            'documento' => $documento->nombre_documento,
            'cod_uni' => $input["cod_uni"],
            'dataanulacion' => $anulacion,
            'datacredito' => $credito
        ]);
    }

    public function agregar(Request $request){
        $input = $request->all();
        if (isset($input['id_documento'])) {
            $anulacion = Detalle_anu_cred::select("nom_proyec","tb_anulacion.cod_uni","tb_anulacion.saldo_anulado","tb_anulacion.n_anulacion")
                        ->join("tb_anulacion","tb_detalle_anu_cred.id_anulacion","tb_anulacion.id_anulacion")
                        ->join("vw_pry_habilitadores_all","tb_anulacion.cod_uni","vw_pry_habilitadores_all.cod_unif")
                        ->where("id_documento",$input['id_documento'])
                        ->distinct()->get();
            $credito = Detalle_anu_cred::select("nom_proyec","tb_credito.cod_uni","tb_credito.credito","tb_credito.saldo_balance","tb_credito.n_credito")
                        ->join("tb_credito","tb_detalle_anu_cred.id_credito","tb_credito.id_credito")
                        ->join("vw_pry_habilitadores_all","tb_credito.cod_uni","vw_pry_habilitadores_all.cod_unif")
                        ->where("id_documento",$input['id_documento'])
                        ->distinct()->get();
            $documento = DB::table("tb_documento_anulacion")->where("id_documento",$input["id_documento"])->first();
            return view('habilitadores.agregar')->with(
            [
                'anulacion' => $anulacion,
                'credito' => $credito,
                'documento' => $documento,
            ])->render();
        }
        return view('habilitadores.agregar')->render();
    }

    public function data(Request $request){
        mb_internal_encoding('UTF8');
        $input = $request->all();
        $data = DB::table('vw_pry_habilitadores_all')->select(DB::raw("vw_pry_habilitadores_all.*,anulacion.n_anulacion,credito.n_credito"))
        ->leftjoin(DB::RAW("(select cod_uni,max(n_anulacion) as n_anulacion from tb_anulacion
        inner join tb_detalle_anu_cred  on tb_anulacion.id_anulacion = tb_detalle_anu_cred.id_anulacion 
        inner join tb_documento_anulacion on tb_detalle_anu_cred.id_documento  = tb_documento_anulacion.id_documento 
        where anio =".$input["anio"]."group by cod_uni) anulacion"),"vw_pry_habilitadores_all.cod_unif","=","anulacion.cod_uni")
        ->leftjoin(DB::RAW("(select cod_uni,max(n_credito) as n_credito from tb_credito
        inner join tb_detalle_anu_cred  on tb_credito.id_credito = tb_detalle_anu_cred.id_credito 
        inner join tb_documento_anulacion on tb_detalle_anu_cred.id_documento  = tb_documento_anulacion.id_documento 
        where anio =".$input["anio"]."group by cod_uni) credito"),"vw_pry_habilitadores_all.cod_unif","=","credito.cod_uni");

        $recordsTotal = $data->get()->count();

        if(!empty($input['search']['value'])){
            $ss = '%'. ($input['search']['value']) .'%';
            $data = $data->whereRaw("( COALESCE(cod_unif::text, '')) ilike ?",$ss);
        }

        $order = $input['order'][0];
        $oColumn = $order['column'];
        $oType   = $order['dir'];

        $recordsFiltered = $data->get()->count();
        if($input['columns'][$oColumn]['name'] != 'accion') {
            $data = $data->orderBy($input['columns'][$oColumn]['name'], "$oType");
        }
        $start   =  $input['start'];
        $length  =  $input['length'];
        $data  = $data->skip($start)->take($length)->get();

        return Response([
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ]);
    }

    public function insertardata(Request $request){
        $now = new DateTime();
        $fecha = $now->format('d-m-Y');

        $input = $request->all();
        $nombre_documento = $input['nombre_documento'];
        $data_habilitador = json_decode($input['data_habilitador']);
        $data_habilitados = json_decode($input['data_habilitados']);
        //Agregar Datos
        if($input["opc"] == 0){
            $documento = DB::table("tb_documento_anulacion")->where("nombre_documento",$nombre_documento)->first();
            if(!empty($documento)){
                return Response(['error' => True],500);
            }else{
                if(!empty($data_habilitador) and !empty($data_habilitados) and !empty($nombre_documento)){
                    //INGRESANDO TB_DOCUMENTO_ANULACION
                    $id_documentacion =  DB::table('tb_documento_anulacion')->insertGetId (["nombre_documento"=>$nombre_documento,"fecha_creacion"=> $fecha,"anio"=> $input["anio"]],"id_documento");
                    $this->guardado($nombre_documento,$id_documentacion,$data_habilitador,$data_habilitados);
                    return Response(['error' => false],200);
                }else{
                    return Response(['error' => True],400);
                }
            }

        }elseif($input["opc"] == 1){  //Actualizar Datos
            $id_documento = $input['id_documento'];
            $documento_n = DB::table("tb_documento_anulacion")->where("id_documento",$id_documento)->value('nombre_documento');
            if($nombre_documento == $documento_n){
                //Ingresar los datos detalle anulacion
                //Eliminamos los datos de la tabla credito y anulacion
                $detalle = Detalle_anu_cred::where('id_documento',$id_documento)->get();
                foreach($detalle as $row){
                    //Eliminar datos del detalle
                    Detalle_anu_cred::where('id_detalle',$row->id_detalle)->delete();
                    //Si el id de la anulacion no esta vacia
                    if(!empty($row->id_anulacion)){
                        Anulacion::where('id_anulacion',$row->id_anulacion)->delete();
                    }
                    //Si el id del credito no esta vacia
                    if(!empty($row->id_credito)){
                        Credito::where('id_credito',$row->id_credito)->delete();
                    }
                }
                //Guardando los Datos
                if(!empty($data_habilitador) and !empty($data_habilitados) and !empty($nombre_documento)){
                    //Actualiza el Nombre del Documento
                    DB::table('tb_documento_anulacion')->where('id_documento', $id_documento)->update(["fecha_creacion"=> $fecha,"anio"=> $input["anio"]]);
                    $this->guardado($nombre_documento,$id_documento,$data_habilitador,$data_habilitados);
                    return Response(['error' => false],200);
                }else{
                    return Response(['error' => true],400);
                }
            }else{
                $documento = DB::table("tb_documento_anulacion")->where("nombre_documento",$nombre_documento)->first();
                if(!empty($documento)){
                    return Response(['error' => True],500);
                }else{
                    //Actualiza el Nombre del Documento
                    DB::table('tb_documento_anulacion')->where('id_documento', $id_documento)->update(['nombre_documento' => $nombre_documento,"fecha_creacion"=> $fecha,"anio"=> $input["anio"]]);
                    //Ingresar los datos detalle
                    $detalle = Detalle_anu_cred::where('id_documento',$id_documento)->get();
                    foreach($detalle as $row){
                        //Eliminar datos del detalle
                        Detalle_anu_cred::where('id_detalle',$row->id_detalle)->delete();
                        //Si el id de la anulacion no esta vacia
                        if(!empty($row->id_anulacion)){
                            Anulacion::where('id_anulacion',$row->id_anulacion)->delete();
                        }
                        //Si el id del credito no esta vacia
                        if(!empty($row->id_credito)){
                            Credito::where('id_credito',$row->id_credito)->delete();
                        }
                    }
                    //Guardando los Datos
                    if(!empty($data_habilitador) and !empty($data_habilitados) and !empty($nombre_documento)){
                        $this->guardado($nombre_documento,$id_documento,$data_habilitador,$data_habilitados);
                        return Response(['error' => false],200);
                    }else{
                        return Response(['error' => true],400);
                    }
                }
            }
        }
    }

    public function guardado($nombre_documento,$id_documentacion,$data_habilitador,$data_habilitados){
        $array_detalle = array();
        //INGRESANDO TB_ANULACION  
        $array_id_anulacion = array();
        foreach($data_habilitador  as $key=>$row ){
            $id_anulacion = Anulacion::insertGetId(
            [
                "cod_uni" =>  empty($row[0])?null:$row[0], //Para COD. UNIF.
                "saldo_anulado" => empty($row[1])?null:$row[1], //Para SALDO ANULADO
                "n_anulacion" => empty($row[2])?null:$row[2], //Para NUMERO DE ANULACION
            ],"id_anulacion"); 
            array_push($array_id_anulacion,$id_anulacion);       
        }
        //INGRESANDO TB_CREDITO
        $array_id_credito = array();
        foreach($data_habilitados  as $key=>$row ){
            $id_credito = Credito::insertGetId(
            [
                "cod_uni" =>  empty($row[0])?null:$row[0], //Para COD. UNIF.
                "credito" => empty($row[1])?null:$row[1], //Para CREDITO
                "saldo_balance" => empty($row[2])?null:$row[2], //Para SALDO BALANCE
                "n_credito" => empty($row[3])?null:$row[3], //Para NUMERO DE CREDITO
                "saldo_balance_informacion" => null
            ],"id_credito");    
            array_push($array_id_credito,$id_credito);         
        }
        
        if(count($array_id_anulacion) != count($array_id_credito)){
            $array_tamaño = count($array_id_anulacion) > count($array_id_credito) ? count($array_id_anulacion) : count($array_id_credito);
        }else{
            $array_tamaño = count($array_id_anulacion);
        }
        for ($i=0; $i < $array_tamaño; $i++) { 
            $insert_detalle [] =[
                "id_anulacion"=> isset($array_id_anulacion[$i])?$array_id_anulacion[$i]:null,
                "id_credito"=> isset($array_id_credito[$i])?$array_id_credito[$i]:null,
                "id_documento"=>$id_documentacion,
            ];
        }
        //Guardado
        Detalle_anu_cred::insert($insert_detalle);
    }

    public function eliminardata(Request $request){
        $input = $request->all();
        $id_documento = $input['id_documento'];
        $detalle = Detalle_anu_cred::where('id_documento',$id_documento)->get();
        foreach($detalle as $row){
            //Eliminar datos del detalle
            Detalle_anu_cred::where('id_detalle',$row->id_detalle)->delete();
            //Si el id de la anulacion no esta vacia
            if(!empty($row->id_anulacion)){
                Anulacion::where('id_anulacion',$row->id_anulacion)->delete();
            }
            //Si el id del credito no esta vacia
            if(!empty($row->id_credito)){
                Credito::where('id_credito',$row->id_credito)->delete();
            }
        }
        DB::table("tb_documento_anulacion")->where("id_documento",$id_documento)->delete();
        return Response(['error' => false],200);
    }
}