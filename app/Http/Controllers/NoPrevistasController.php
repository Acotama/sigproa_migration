<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use sayhuite\Models\PipTotalPriori;
use sayhuite\Http\Controllers\ModificacionPresupuestalController;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use sayhuite\Models\IndicadorBrechas;

class NoPrevistasController extends Controller
{
    public function inicio(){
        return view('no_previstas.inicio');
    }

    public function noprevistas(Request $request){
        $input = $request->all();
        $data = DB::table('pry_no_previstas')->select("id","cod_unif","nombre_inversion","monto_ejecucion" ,"pim","monto_anio_0","monto_anio_1","monto_anio_2","monto_anio_3")
        ->join("vw_cartera_pmi","pry_no_previstas.cod_unif","=","vw_cartera_pmi.codigo_unico")
        ->where("pry_no_previstas.anio",$input["anio"])
        ->get();

        return Response([
            'data' => $data
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
        if(empty($input['id'])){
            return view('no_previstas.agregar')->with(
            [
                'anio' => $input["anio"]
            ])->render();
        }else{
            $data = DB::table('pry_no_previstas')->where("id",$input["id"])->first();
            return view('no_previstas.agregar')->with(
            [
                'data'  => $data,
                'anio'  => $input["anio"]
            ])->render();
        }
        
    }

    public function data(Request $request){

        $input = $request->all();
        $siet = PipTotalPriori::select('exptec_pdf','f_exptec')->where('cod_unif',$input['id'])->first();
        if(!empty($siet) && $siet->exptec_pdf != "SIN ET"){
            $expediente_tecnico =  array('nombre' => trim($siet->exptec_pdf),'fecha'  => $siet->f_exptec);
        }else{
            $et = new ModificacionPresupuestalController();
            $expediente_tecnico = $et->data_et($input['id']);
        }

        $data = array ('id' => $input['id'], 'tipo' => 'SIAF');
        $data = http_build_query($data);

        $opciones = array(
            'http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen($data)."\r\n".
                            "User-Agent:MyAgent/1.0\r\n",
                'method'  => "POST",
                'content' => $data,
            ),
        );

        $contexto = stream_context_create($opciones);
        $response = file_get_contents("https://ofi5.mef.gob.pe/inviertews/Dashboard/traeDetInvSSI",false, $contexto);

        $response_brecha = file_get_contents("https://ofi5.mef.gob.pe/invierte/ejecucion/verFichaEjecucion/".$input['id'],false);

        $mystring = $response_brecha;
        $cantidad = strlen($mystring);
        $findme   = "Articulación con el programa multianual de inversiones (PMI)";
        $inicio = strpos($mystring, $findme);
        $tabla = null;
        $data_brecha = [];
        if ($inicio !== false) {
            $cortado = substr($mystring,$inicio,$cantidad);
            $cortado_cantidad = strlen($cortado);
            $inicio_tabla = strpos($cortado, "<table");
            $fin_tabla = strpos($cortado, "</table");
            $tabla = substr($cortado,$inicio_tabla,$fin_tabla - $inicio_tabla + 10);
            $DOM = new \DOMDocument();
            $DOM->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $tabla);
            $tbody = $DOM->getElementsByTagName('tbody');
            $tr = $tbody[0]->getElementsByTagName('tr');
            $td = $tr[0]->getElementsByTagName('td');
            $brecha = trim($td[1]->textContent);
            $funcion = "";
            if (count($response) > 0) {
                foreach(json_decode($response,true) as $row){
                    $funcion = $row["FUNCION"];
                }
            }
            if (!empty($funcion)) {
                $IndicadorBrechas = IndicadorBrechas::where("funcion",$funcion)
                ->where("nombre",$brecha)->first();
            }else{
                $IndicadorBrechas = IndicadorBrechas::where("nombre",$brecha)->first();
            }
            if (count($IndicadorBrechas) >0 ){
                $text= true;
            }else{
                $text= false;
            }
            $data_brecha[] =  array($text,trim($td[0]->textContent),trim($td[1]->textContent),trim($td[2]->textContent),trim($td[3]->textContent),trim($td[4]->textContent),$funcion);
        }



        $data_pmi = array ('txtCodigoUnico' => $input['id'], 'ddlSector' => '');
        $data_pmi = http_build_query($data_pmi);
        $opciones_pmi = array(
            'http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen($data_pmi)."\r\n".
                            "User-Agent:MyAgent/1.0\r\n",
                'method'  => "POST",
                'content' => $data_pmi,
            ),
        );

        $contexto_pmi = stream_context_create($opciones_pmi);
        $response_pmi = file_get_contents("http://ofi5.mef.gob.pe/invierte/Pmi/traeListaCarteraSector",false, $contexto_pmi);

        $proyecto = DB::table('vw_grli_pip_seguimiento_ejecucion_financiera')->select('pia_dia','pim_dia')->where('cod_unif',$input['id'])->first();

        return Response([
            'ssi' => json_decode($response, true),
            'et' => $expediente_tecnico,
            'brechas' => $data_brecha,
            'pmi' => json_decode($response_pmi, true),
            'proyecto' => $proyecto
        ]);

    }


    public function insertardata(Request $request){
        $now = new DateTime();
        $fecha = $now->format('d-m-Y');

        $input = $request->all();
        $codigo = $input["codigo"];
        $monto = $input["monto"];
        $estado = $input["estado"];
        $modalidad = $input["modalidad"];
        $anio = $input['anio'];
        //Agregar Datos
        if($input["opc"] == 0){
            try {
                DB::table('pry_no_previstas')->insert(["cod_unif"=>$codigo,"estado"=> $estado,"anio"=> $anio,"monto_ejecucion"=> $monto,"modalidad"=> $modalidad]);
                return Response(['error' => false],200);
            } catch (MiExcepción $e) {
                return Response(['error' => True],400);    
            }
        }elseif($input["opc"] == 1){  //Actualizar Datos
            try {
                DB::table('pry_no_previstas')->where('id', $input["id"])->update(["cod_unif"=>$codigo,"estado"=> $estado,"anio"=> $anio,"monto_ejecucion"=> $monto,"modalidad"=> $modalidad]);
                return Response(['error' => false],200);
            } catch (MiExcepción $e) {
                return Response(['error' => True],400);    
            }
        }
    }

    public function eliminardata(Request $request){
        $input = $request->all();
        $id = $input['id'];
        try {
            DB::table("pry_no_previstas")->where("id",$id)->delete();
            return Response(['error' => false],200);
        } catch (MiExcepción $e) {
            return Response(['error' => True],400);    
        }
        return Response(['error' => false],200);
    }
}
