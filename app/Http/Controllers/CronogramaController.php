<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use View;
use sayhuite\Models\Cronograma;
use sayhuite\Models\PipTotalPriori;
use sayhuite\Models\Obras;
use Response;
use sayhuite\Models\Task;
use sayhuite\Models\Link;

class CronogramaController extends Controller
{
    protected $controlador = 'cronograma';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      $Proyecto = PipTotalPriori::find($id);
      $Obras    = Obras::where('idproyecto',$Proyecto->id)
                      ->where('estado', '1')
                      ->get();

      return View::make($this->controlador . '.index')->with([
        "proyecto"=>$Proyecto,
        "obras" =>$Obras
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function get($idProyecto, $idMeta, Request $request){
      $input = $request->all();

      $tasks = new Task();
      $links = new Link();

      return response()->json([
        "data" => $tasks->orderBy('sortorder')->where('idobra',$idMeta)->get(),
        "links" => $links->where('idobra',$idMeta)->get()
      ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*if($data){
            //if not found create a new example task
            $dt = $data->data

        }else {
            $dt = '{"tasks":    [
                  {"id": -1, "name": "Gantt editor", "progress": 0, "progressByWorklog": false, "relevance": 0, "type": "", "typeId": "", "description": "", "code": "", "level": 0, "status": "STATUS_ACTIVE", "depends": "", "canWrite": true, "start": 1396994400000, "duration": 20, "end": 1399586399999, "startIsMilestone": false, "endIsMilestone": false, "collapsed": false, "assigs": [], "hasChild": true}
                ], "selectedRow": 2, "deletedTaskIds": [],
                  "resources": [
                ],
                  "roles":       [
                ], "canWrite":    true, "canWriteOnParent": true, "zoom": "w3"}
            }';
        }*/
        //dd($data->cod_unif);

        /*if ($data->cod_unif != 'SIN COD.')
        {
            $InfFinanciera = InfFinanciera::where('cod_unif','=',$data->cod_unif)->get()->toArray();
        }
        else {
            $InfFinanciera = InfFinanciera::where('cod_unif','=','123456')->get()->toArray();
        }

        $Transferencia = DB::select("select nombre,fecha,definicion,monto from decretoxproyecto INNER JOIN decretos ON decretoxproyecto.iddecreto = decretos.id where decretoxproyecto.idproyecto = " . $id );

        $depCombo = Departamento::all()->pluck('nom_dpto', 'cod_dpto');

        $prov = Provincia::all()->pluck('nom_prov', 'cod_prov')->toArray();
        $provCombo = [0 => "-- Seleccionar --"] + $prov;

        $dist = Distrito::all()->pluck('nom_dist', 'cod_dist')->toArray();
        $disCombo = [0 => "-- Seleccionar --"] + $dist;

        $eta = SubEtapa::all()->pluck('etapa', 'etapa')->toArray();
        $etaCombo = [0 => "-- Seleccionar --"] + $eta;

        $sub = SubEtapa::all()->pluck('sub_etapa', 'sub_etapa')->toArray();
        $subCombo = [0 => "-- Seleccionar --"] + $sub;

        $estAntig = EstAntig::all()->pluck('estado', 'estado')->toArray();
        $estAntigCombo = [0 => "-- Seleccionar --"] + $estAntig;*/

        //return View::make($this->controlador . '.edit')->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
