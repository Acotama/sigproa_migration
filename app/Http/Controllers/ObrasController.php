<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\Obras;
use sayhuite\ObrasEstado;
use Illuminate\Support\Facades\Auth;
use sayhuite\Dependencia;
use sayhuite\PipTotalPriori;
use sayhuite\UsuarioObra;
use sayhuite\Usuario;
use sayhuite\PipTotalPrioriImage;

use sayhuite\SubEtapa;
use Validator;
use DB;
use Response;
use Datetime;
use sayhuite\Logic\Tools\Tools;
use Input;
use File;

class ObrasController extends Controller
{

    public function create(Request $request) {

        $id = $request->get('id');

        $PipTP = PipTotalPriori::find($id);

        $arrUnidades = Auth::user()->unidad()->pluck('denom')->toArray();

        $etapas = SubEtapa::whereNotIn('etapa',['PERFIL','CIERRE'])->orderBy(DB::RAW("CASE etapa
         WHEN 'EXPEDIENTE TÉCNICO' THEN 1
         WHEN 'EN EJECUCIÓN' THEN 2
         WHEN 'EN LIQUIDACIÓN' THEN 3
         WHEN 'EN TRANSFERENCIA' THEN 4
         WHEN 'CULMINADO' THEN 5
         WHEN 'CONVENIO' THEN 6
         WHEN 'NO PIP' THEN 7
         ELSE 8
         END"))->pluck('etapa', 'etapa')->toArray();
        $arr = array('NO PIP' => 'IOARR');
        $result = array_replace($etapas,$arr);
        $etapas = $result;

        return view('obra.create')->with('id',$PipTP->id)->with('pInfo',$PipTP)->with('ger',$arrUnidades)->with('etapas',$etapas)->render();
    }

    public function store(Request $request){
        $input = $request->all();
        $input['m_exp_tec']=floatval(str_replace(",",'',$input['m_exp_tec']));
        $input['m_supervision']=floatval(str_replace(",",'',$input['m_supervision']));
        $input['m_vreferencial']=floatval(str_replace(",",'',$input['m_vreferencial']));
        $Proyecto = PipTotalPriori::find($input['idP']);

        /*$porMetas = (int)$Proyecto->cant_meta > 0 ? true : false;

        if($porMetas){
            //VALIDAR CAMPOS - Proyecto por metas
            $validator = Validator::make($input, Obras::$rules);

        } else {
            //VALIDAR CAMPOS - Proyecto sin metas
            $validator = Validator::make($input, Obras::$rules_NoMetas);
        }*/
        if ( $input['tipo'] == 'E' ){
            $validator = Validator::make($input, Obras::$rules_NoMeta);
        } elseif ($input['tipo'] == 'S'){ //No es Meta
            $validator = Validator::make($input, Obras::$rules_otros);
        }else { //No es Meta
            $validator = Validator::make($input, Obras::$rules);
        }


        if ($validator->fails()) {
            $mensaje_error = array();
            $mensajes = $validator->messages();
            //RETORNA ERRORES DE VALIDACION
            return Response($mensajes->all(),400);
        } else {

            /*VALIDAR CANTIDAD DE OBRAS
                //cantidad de metas permitida
                $cantidad_obras_permitida = (int)$Proyecto->cant_meta === 0 ? 1 : (int)$Proyecto->cant_meta;
                //cantidad de metas actuales
                $cant_obras_actuales = Obras::where('idproyecto',$input['idP'])->where('estado', '1')->count();
                //si cantidad de obras actuales == cantidad de obras permitidas RETORNA RESTRINGIDO
                if($cant_obras_actuales >= $cantidad_obras_permitida){
                    return Response(['El proyecto ya cuenta con la cantidad de metas especificada'],400);
                }
                */

            /*if( $input['tipo'] != 'E' ){*/
                if ( $input['tipo'] == 'E' ){
                    //VALIDAR EJECUCION INTEGRAL
                    //Solo puede haber una ejecución integral
                    if(Obras::where('tipo',$input['tipo'])->where('idproyecto',$input['idP'])->where('estado','1')->first()){
                        return Response(['Solo puede haber una ejecución integral, ya se ha agregado una anteriormente'], 400);
                    }
                }
                //VALIDAR DATOS DUPLICIDAD DE OBRAS
                //Numero de obra duplicado //Orden
                // if(Obras::where('nro_meta',$input['nro_meta'])->where('idproyecto',$input['idP'])->where('estado','1')->first()){
                //     return Response(['Ya existe ejecución agregada en ese orden'], 400);
                // }
                //Nombre de obra duplicado
                if(Obras::where('nom_meta',$input['nom_meta'])->where('idproyecto',$input['idP'])->where('estado','1')->first()){
                    return Response(['Ya existe ejecución con ese nombre'], 400);
                }
            /*}*/


            DB::beginTransaction();

            try {

                $Obra = new Obras();

                $Obra->idproyecto     = $input['idP'];

                if( $input['tipo'] != 'E' ){
                    $Obra->nro_meta       = $input['nro_meta'];
                    $Obra->nom_meta       = $input['nom_meta'];
                } else {
                    $ultimo_ejec = Obras::select([
                        DB::raw('max(nro_meta) as nro_meta')
                    ])
                    ->where('idproyecto','=',$Obra->idproyecto)
                    ->first();

                    $Obra->nro_meta       = $ultimo_ejec->nro_meta or 1;
                    $Obra->nom_meta       = ' ';
                }

                $Obra->anio_ejec      = $input['anio_ejec'];
                $Obra->mod_ejec       = $input['mod_ejec'];
                //$Obra->f_adjudicacion = $input['f_adjudicacion'];
                $Obra->m_exp_tec      = $input['m_exp_tec'];
                $Obra->res_exp_tec      = $input['res_exp_tec'];
                $Obra->m_supervision  = $input['m_supervision'];
                $Obra->m_vreferencial = $input['m_vreferencial'];

                $Obra->m_ejecucion = $input['m_ejecucion'];

                $Obra->n_contrato     = $input['n_contrato'];
                $Obra->f_contrato     = $input['f_contrato'];
                $Obra->f_inicio       = $input['f_inicio'];
                $Obra->f_termino      = $input['f_termino'];

                $Obra->f_reinicio       = $input['f_reinicio'];
                $Obra->f_termino_nueva  = $input['f_termino_nueva'];
                $Obra->f_inaug          = $input['f_inaug'];
                $Obra->t_ejec_dias      = $input['t_ejec_dias'];
                $Obra->tipo             = $input['tipo'];
                $Obra->u_ejec           = $input['u_ejec'];
                $Obra->estado           = 1;

                $Obra->save();


                $ObraEstado = new ObrasEstado();

                $ObraEstado->idobra    = $Obra->id;
                $ObraEstado->fecha_act = $input['fecha_act'];
                $ObraEstado->etapa     = $input['etapa'];
                $ObraEstado->sub_etapa = $input['sub_etapa'];
                $ObraEstado->est_situ  = $input['est_situ'];
                $ObraEstado->a_fisico  = $input['a_fisico'];
                $ObraEstado->obs       = $input['obs'];
                $ObraEstado->tipo_obs  = $input['tipo_obs'];
                $ObraEstado->save();


            } catch(Exception $e){
                DB::rollback();
                return Response('Error al Guardar Los Cambios', 500);
            }

            DB::commit();

            //Obtenemos número de orden de la ejecución
            $orden = $Obra->nro_meta;
            //Obtenemos el ultimo orden
            $ultimo_orden = Obras::select([
                DB::raw('max(nro_meta) as nro_meta')
            ])->first();


            PipTotalPriori::updateMasterTB($Proyecto->id);
            //Si la ejecución es la mas reciente
            /*PipTotalPriori::updateMasterTable([
                'etapa'     => $input['etapa'],
                'sub_etapa' => $input['sub_etapa'],
                'est_situ'  => $input['est_situ'],
                'a_fisico'  => $input['a_fisico'],
                'obs'       => $input['obs'],
                'fecha_act' => $input['fecha_act']
            ], $input['idP'], $orden, $ultimo_orden->nro_meta , 'O' );*/


            return Response('Se Agregó la Ejecución del Proyecto',200);
        }
    }

    public function edit(Request $request){
        //idObra
        $id = $request->get('id');

        $Obra = DB::table('grli_obra as o')
            ->select([
                "o.id",
                "o.idproyecto",
                "o.nro_meta",
                "o.nom_meta",
                "o.anio_ejec",
                "o.mod_ejec",
                "o.f_adjudicacion",
                "o.f_contrato",
                "o.m_exp_tec",
                "o.m_vreferencial",
                "o.n_contrato",
                "o.f_inicio",
                "o.f_termino",
                "o.t_ejec_dias",
                "o.res_exp_tec",
                "o.m_supervision",
                "o.f_reinicio",
                "o.f_termino_nueva",
                "o.f_inaug",
                "o.m_ejecucion",
                "grli_obra_estado.etapa",
                "grli_obra_estado.sub_etapa",
                "fecha_act",
                "grli_obra_estado.a_fisico",
                "grli_obra_estado.est_situ",
                "grli_obra_estado.obs",
                "grli_obra_estado.tipo_obs",
                "o.tipo"
            ])
            ->leftJoin("grli_obra_estado","o.id","=", "grli_obra_estado.idobra")
            ->whereRaw("(grli_obra_estado.fecha_act = (select MAX(fecha_act) from grli_obra_estado where idobra = o.id and grli_obra_estado.estado ='1') or fecha_act is null) and o.id = ".$id)
            ->first();

        $PipTP = PipTotalPriori::find($Obra->idproyecto);

        $arrUnidades = Auth::user()->unidad()->pluck('denom','denom')->toArray();
        $arrUnidades = $arrUnidades;

        $eta = SubEtapa::whereNotIn('etapa',['PERFIL','CIERRE'])->orderBy(DB::RAW("CASE etapa
         WHEN 'EXPEDIENTE TÉCNICO' THEN 1
         WHEN 'EN EJECUCIÓN' THEN 2
         WHEN 'EN LIQUIDACIÓN' THEN 3
         WHEN 'EN TRANSFERENCIA' THEN 4
         WHEN 'CULMINADO' THEN 5
         WHEN 'CONVENIO' THEN 6
         WHEN 'NO PIP' THEN 7
         ELSE 8
         END"))->pluck('etapa', 'etapa')->toArray();
        $arr = array('NO PIP' => 'IOARR');
        $result = array_replace($eta,$arr);
        $eta= $result;

        $etaCombo = [0 => "-- Seleccionar --"] + $eta;

        $Sub_Etapa = [];
        if($Obra->etapa){
            $tmpSub_Etapa  = $this->combosubetapa($Obra->etapa);
             foreach ($tmpSub_Etapa as $key => $value) {
                if ($value != $Obra->sub_etapa){
                    $Sub_Etapa += [$key => [ "nombre" => $value, "state" => ""]];
                } else {
                    $Sub_Etapa += [$key => [ "nombre" => $value, "state" => "selected"]];
                }
            }
        }

        return view('obra.edit')->with( 'data',$Obra )->with('pInfo',$PipTP)->with('ger',$arrUnidades)->with('etapas',$etaCombo)->with('SubEtapa', $Sub_Etapa)->render();
    }

    public function combosubetapa($id) {
        $Sub_Etapa = SubEtapa::select('sub_etapa')
                    ->where('etapa', '=', $id)->where('estado','=','1')->orderBy('id','asc')->pluck('sub_etapa', 'sub_etapa')->toArray();
        //dd($Sub_Etapa);
        $Sub_Etapa = [ 0 => '-- Seleccionar --'] + $Sub_Etapa;

        return $Sub_Etapa;
    }

    public function update(Request $request){

        $input = $request->all();
        $input['m_exp_tec']=floatval(str_replace(",",'',$input['m_exp_tec']));
        $input['m_supervision']=floatval(str_replace(",",'',$input['m_supervision']));
        $input['m_vreferencial']=floatval(str_replace(",",'',$input['m_vreferencial']));
        
        //Proyecto por metas?
        $Obra = Obras::find($input['idO']);
        $PipTp = PipTotalPriori::find($Obra->idproyecto);

        if ( $input['tipo'] == 'E' ){
            $validator = Validator::make($input, Obras::$rules_NoMeta);
        } elseif ($input['tipo'] == 'S'){ //No es Meta
            $validator = Validator::make($input, Obras::$rules_otros);
        }else { //No es Meta
            $validator = Validator::make($input, Obras::$rules);
        }

        if ($validator->fails()) {
            $mensaje_error = array();
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                array_push($mensaje_error, $mensaje);
            }
            return Response($mensaje_error,500);
        } else {

            /*if ( $input['tipo'] != 'E' ){*/
                if ( $input['tipo'] == 'E' ){
                    //VALIDAR EJECUCION INTEGRAL
                    //Solo puede haber una ejecución integral
                    $input['nro_meta']=0;
                    if(Obras::where('tipo',$input['tipo'])->where('idproyecto', $PipTp->id)->where('id','!=',$Obra->id)->where('estado','1')->first()){
                        return Response(['Solo puede haber una ejecución integral, ya se ha agregado una anteriormente'], 400);
                    }
                }
                //Numero de obra duplicado
                if ( $input['tipo'] == 'M' ){
                //   if(Obras::where('nro_meta',$input['nro_meta'])->where('idproyecto',$PipTp->id)->where('id' , '<>' , $input['idO'])->where('estado','1')->first()){
                //       return Response(['Ya existe ese numero de Obra'], 400);
                //   }
                  //Nombre de obra duplicado
                  if(Obras::where('nom_meta',$input['nom_meta'])->where('idproyecto',$PipTp->id)->where('id' , '<>' , $input['idO'])->where('estado','1')->first()){
                      return Response(['Ya existe Obra con ese nombre'], 400);
                  }
                }
                //Otros
                if ( $input['tipo'] == 'S' ){
                  $input['nro_meta']=null;
                  //Nombre de obra duplicado
                  if(Obras::where('nom_meta',$input['nom_meta'])->where('idproyecto',$PipTp->id)->where('id' , '<>' , $input['idO'])->where('estado','1')->first()){
                      return Response(['Ya existe Obra con ese nombre'], 400);
                  }
                }
            /*}*/

            DB::beginTransaction();
            $Obra->fill($input);
            $Obra->save();

            $f_lastEstado = DB::select('select MAX(fecha_act) from grli_obra_estado where idobra = '.$Obra->id)[0];

            $fecha = DateTime::createFromFormat('Y-m-d', $input["fecha_act"])->format('Y-m-d');

            if( empty($f_lastEstado->max )  /*or $input['fecha_act'] != date("d-m-Y", strtotime($f_lastEstado->max))*/ ){

                $ObraEstado = new ObrasEstado();

                $ObraEstado->idobra    = $Obra->id;
                $ObraEstado->fecha_act = $input['fecha_act'];
                $ObraEstado->etapa     = $input['etapa'];
                $ObraEstado->sub_etapa = $input['sub_etapa'];
                $ObraEstado->est_situ  = $input['est_situ'];
                $ObraEstado->a_fisico  = $input['a_fisico'];
                $ObraEstado->obs       = $input['obs'];
                $ObraEstado->tipo_obs  = $input['tipo_obs'];

                $ObraEstado->save();
            } else {
                $ObraEstado = ObrasEstado::where( 'fecha_act','=', $fecha )->where('idobra','=',$Obra->id)->first();
                if( $ObraEstado ){
                    $ObraEstado->fecha_act = $input['fecha_act'];
                    $ObraEstado->etapa     = $input['etapa'];
                    $ObraEstado->sub_etapa = $input['sub_etapa'];
                    $ObraEstado->est_situ  = $input['est_situ'];
                    $ObraEstado->a_fisico  = $input['a_fisico'];
                    $ObraEstado->obs       = $input['obs'];
                    $ObraEstado->tipo_obs  = $input['tipo_obs'];
                    $ObraEstado->save();
                } else {

                    $ObraEstado = new ObrasEstado();
                    $ObraEstado->idobra    = $Obra->id;
                    $ObraEstado->fecha_act = $input['fecha_act'];
                    $ObraEstado->etapa     = $input['etapa'];
                    $ObraEstado->sub_etapa = $input['sub_etapa'];
                    $ObraEstado->est_situ  = $input['est_situ'];
                    $ObraEstado->a_fisico  = $input['a_fisico'];
                    $ObraEstado->obs       = $input['obs'];
                    $ObraEstado->tipo_obs  = $input['tipo_obs'];
                    $ObraEstado->save();
                }

            }

            DB::commit();

            //Obtenemos número de orden de la ejecución
            $orden = $Obra->nro_meta;
            //Obtenemos el ultimo orden
            $ultimo_orden = Obras::select([
                DB::raw('max(nro_meta) as nro_meta')
            ])->first();

            PipTotalPriori::updateMasterTB($PipTp->id);
            /* PipTotalPriori::updateMasterTable([
                'etapa'     => $input['etapa'],
                'sub_etapa' => $input['sub_etapa'],
                'est_situ'  => $input['est_situ'],
                'a_fisico'  => $input['a_fisico'],
                'obs'       => $input['obs'],
                'fecha_act' => $input['fecha_act']
            ], $PipTp->id, $orden, $ultimo_orden->nro_meta, 'O' ); */

            return Response('Se Actualizó la Ejecución',200);
        }
    }

    public function filterData(Request $request){

        $isAdmin = Auth::user()->hasRole('admin');

        //UNIDADES A LAS QUE PERTENECE
        if ($isAdmin) {
            $arrUnidades = Dependencia::all()->pluck('denom')->toArray();
            array_push($arrUnidades,'');
        } else {
            $arrUnidades = Auth::user()->unidad()->pluck('denom')->toArray();
        }

        $input = $request->all();
        /*$page = $input['page']; // get the requested page
        $limit = $input['rows']; // get how many rows we want to have into the grid
        $sidx = $input['sidx']; // get index row - i.e. user click to sort
        $sord = $input['sord']; // get the direction
        $start = $limit * $page - $limit;*/

        $Obra = DB::table('vw_grli_obra_list')
                ->where('idproyecto',$input['idproyecto'])
                ->orderBy('nro_meta', 'desc');

        return Response([
            'data' => $Obra->get(),
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        ]);
    }

    public function filterDataEjecucion(Request $request){
        $isAdmin = Auth::user()->hasRole('admin');
        $isSupervisor = Auth::user()->hasRole('supervisor');
        //UNIDADES A LAS QUE PERTENECE
        if ($isAdmin) {
            $arrUnidades = Dependencia::all()->pluck('denom')->toArray();
            array_push($arrUnidades,'');
        } else {
            $arrUnidades = Auth::user()->unidad()->pluck('denom')->toArray();
        }

        $input = $request->all();
        /*$page = $input['page']; // get the requested page
        $limit = $input['rows']; // get how many rows we want to have into the grid
        $sidx = $input['sidx']; // get index row - i.e. user click to sort
        $sord = $input['sord']; // get the direction
        $start = $limit * $page - $limit;*/

        $Obra = DB::table('vw_grli_obra_list')
                    ->select([
                        'vw_grli_obra_list.*',
                        'grli_pip_total_priori.ger_direc',
                        'grli_pip_total_priori.cod_snip'
                    ])
                    ->join('grli_pip_total_priori','grli_pip_total_priori.id','=','vw_grli_obra_list.idproyecto');

        if ( $isSupervisor ) {
            $Asignados = DB::table('grli_pip_usuario_obra')
                            ->where( 'idusuario', Auth::id() )
                            ->where( 'estado', '1' )
                            ->pluck('idobra')
                            ->toArray();

            $Obra = $Obra->whereIn('vw_grli_obra_list.id',$Asignados);
        }

        /*$Obra = $Obra->whereRaw("(vw_grli_obra_list.etapa LIKE '%EN EJECUCIÓN%' OR vw_grli_obra_list.etapa LIKE '%CULMINADO%') and grli_pip_total_priori.estado_pic like 'PRIORIZADO' ");*/
        $Obra = $Obra->whereRaw("(vw_grli_obra_list.etapa LIKE '%EN EJECUCIÓN%' ) and grli_pip_total_priori.estado_pic like 'PRIORIZADO' ");


        $recordsFiltered = $Obra->count();

        $recordsTotal = $Obra->count();

        $start   =  $input['start'];
        $length  =  $input['length'];

        $Obra  = $Obra->skip($start)->take($length);

        return Response([
            'data' => $Obra->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ]);
    }

    public function countEtapa($data){
        $arrNameTipo = ['tdr' => 'TDR',
            'perfil' => 'PERFIL',
            'exptec' => 'EXPEDIENTE TÉCNICO',
            'ejec' => 'EN EJECUCIÓN',
            'liquid' => 'EN LIQUIDACIÓN',
            'transf' => 'EN TRANSFERENCIA',
            'culminado' => 'CULMINADO',
            'cierre' => 'CIERRE'];

        $totalEtapa = 0;
        $resultSet = [];
        foreach($arrNameTipo as $val=>$name){
            $resultSet[$val] = count($data->where('etapa','like',$name)->toArray());
            //dd($val);
            $totalEtapa += count($data->where('etapa','like',$name)->toArray());
        }
        $resultSet['total'] = $totalEtapa;
        $resultSet['totaln'] = $data->count();

        //$SinGer = Obras::where('ger_direc','')/*->whereNotIn('cod_unif',['2001707','2000270','2001621'])*/->count();

        //$resultSet['singerencia'] = $SinGer;

        return $resultSet;
    }

    public function asignarResponsable(Request $request){
        $input = $request->all();

        $Obra = Obras::select([
            'grli_obra.id',
            'grli_obra.nro_meta',
            'grli_obra.nom_meta',
            'grli_obra.anio_ejec',
            'grli_obra.mod_ejec',
            'grli_obra.f_adjudicacion',
            'grli_obra.f_contrato',
            'grli_obra.m_vreferencial',
            'grli_obra.n_contrato',
            'grli_obra.f_inicio',
            'grli_obra.f_termino',
            'grli_obra.t_ejec_dias',
            'grli_obra.f_reinicio',
            'grli_obra.f_termino_nueva',
            'grli_obra.f_inaug',
            'grli_pip_total_priori.nom_proyec'
            ])
            ->join("grli_pip_total_priori","grli_pip_total_priori.id","=","grli_obra.idproyecto")->where('grli_obra.id',$input['id'])->first();

        $Inspector = Usuario::join('grli_pip_usuario_obra','grli_pip_usuario_obra.idusuario','=','usuario.idusuario')->where('idobra',$input['id'])->where('grli_pip_usuario_obra.estado',1)->get();

        return view('obra.asignar')->with('Obra',$Obra)->with("Inspector",$Inspector)->render();
    }

    public function vincularInspector(Request $request){
        $input = $request->all();

        $idusuario = $input['idusuario'];

        $idobra = $input['idobra'];


        $UsuarioObra = UsuarioObra::where('idusuario',$idusuario)->where('idobra',$idobra)->first();

        if($UsuarioObra){
            if($UsuarioObra->estado == "0"){
                $UsuarioObra->estado = 1;
                $UsuarioObra->save();
            } else {
                return Response("failed",400);
            }
        } else {
            $UsuarioObra = new UsuarioObra();

            $UsuarioObra->idusuario = $idusuario;
            $UsuarioObra->idobra = $idobra;
            $UsuarioObra->save();
        }

        return Response("success",200);
    }

    public function desvincularInspector(Request $request){
        $input = $request->all();

        $idusuario = $input['idusuario'];

        $idobra = $input['idobra'];

        $UsuarioObra = UsuarioObra::where('idusuario',$idusuario)->where('idobra',$idobra)->first();

        $UsuarioObra->estado = 0;

        $UsuarioObra->save();


        return Response("success",200);
    }

    public function delete(Request $request){

        $input = $request->all();

        $uid = (int)$input['id'];

        $Obras = Obras::find($uid);

        $Images = PipTotalPrioriImage::where('idobra',$uid)
                  ->where('estado','1')
                  ->get();

        if(count($Images) > 0){
          return Response::json(
              'No se puede borrar la ejecución, tiene imagenes anexadas'
          , 400);
        }

        $Obras->update(['estado' => 0]);

        PipTotalPriori::updateMasterTB($Obras->idproyecto);
    }

    public function show(Request $request){
        //idObra
        $id = $request->get('id');

        $Obra = DB::table('grli_obra as o')
            ->select([
                "o.id",
                "o.idproyecto",
                "o.nro_meta",
                "o.nom_meta",
                "o.anio_ejec",
                "o.mod_ejec",
                "o.m_exp_tec",
                "o.f_adjudicacion",
                "o.f_contrato",
                "o.m_vreferencial",
                "o.n_contrato",
                "o.f_inicio",
                "o.f_termino",
                "o.t_ejec_dias",
                "o.f_reinicio",
                "o.f_termino_nueva",
                "o.f_inaug",
                "o.anio_ejec",
                "o.m_ejecucion",
                "grli_obra_estado.etapa",
                "grli_obra_estado.sub_etapa",
                DB::raw("to_char(grli_obra_estado.fecha_act, 'DD-MM-YYYY') as fecha_act"),
                "grli_obra_estado.a_fisico",
                "grli_obra_estado.est_situ",
                "grli_obra_estado.obs",
                "o.tipo",
                "grli_pip_total_priori.cod_snip",
                "grli_pip_total_priori.nom_proyec",
            ])
            ->leftJoin("grli_obra_estado","o.id","=", "grli_obra_estado.idobra")
            ->whereRaw("(grli_obra_estado.fecha_act = (select MAX(fecha_act) from grli_obra_estado where idobra = o.id) or fecha_act is null) and o.id = ".$id)
            ->join("grli_pip_total_priori","grli_pip_total_priori.id","=","o.idproyecto")
            ->first();

        $Supervisores = Usuario::join('grli_pip_usuario_obra','grli_pip_usuario_obra.idusuario','=','usuario.idusuario')->where('idobra',$id)->where('grli_pip_usuario_obra.estado','1')->get();

        return view('obra.show')->with(['pInfo'=>$Obra, 'supervisores'=>$Supervisores])->render();
    }

    // EVIDENCIA FOTOGRAFICA - COORDINADORES ZONALES
    public function evidenciaIndex(){
        return View("obra.evidencia.index");
    }

    public function evidenciaFilterData(Request $request){
        $isAdmin = Auth::user()->hasRole('admin');
        $isSupervisor = Auth::user()->hasRole('supervisor');
       //UNIDADES A LAS QUE PERTENECE
        /*if ($isAdmin) {
            $arrUnidades = Dependencia::all()->pluck('denom')->toArray();
            array_push($arrUnidades,'');
        } else {
            $arrUnidades = Auth::user()->unidad()->pluck('denom')->toArray();
        }*/
        $input = $request->all();

        $Obra = DB::table('vw_grli_obra_list')
                    ->select([
                        'vw_grli_obra_list.*',
                        'grli_pip_total_priori.ger_direc',
                        'grli_pip_total_priori.cod_snip',
                        DB::raw("(select MAX(grli_pip_total_priori_img.fecha) from grli_pip_total_priori_img where grli_pip_total_priori_img.idobra = vw_grli_obra_list.id and grli_pip_total_priori_img.estado = '1' limit 1 ) as last_fecha_act")
                    ])
                    ->join('grli_pip_total_priori','grli_pip_total_priori.id','=','vw_grli_obra_list.idproyecto');

        if ( isset($input['txtsearch']) and !empty($input['txtsearch']) ) {
            $Obra = $Obra->whereRaw( "( grli_pip_total_priori.cod_snip || ';' || grli_pip_total_priori.cod_unif || ';' || grli_pip_total_priori.nom_proyec ) ilike '%" . $input['txtsearch'] . "%'" );
        }

        if ( isset($input['cboprov']) and !empty($input['cboprov']) ) {
            $Obra = $Obra->whereRaw(
             '(SELECT array_to_string(array_agg(DISTINCT(provincia)), \', \') FROM grli_proyecto_ubicacion where idpi = grli_pip_total_priori.id) ILIKE \'%'. $input['cboprov'] .'%\''
            );
        }



        /*if ( $isSupervisor ) {
            $Asignados = DB::table('grli_pip_usuario_obra')
                            ->where( 'idusuario', Auth::id() )
                            ->where( 'estado', '1' )
                            ->pluck('idobra')
                            ->toArray();

            $Obra = $Obra->whereIn('id',$Asignados);
        }    */

        $Obra = $Obra->whereRaw("( vw_grli_obra_list.etapa LIKE '%EN EJECUCIÓN%' or vw_grli_obra_list.etapa LIKE '%EXPEDIENTE TÉCNICO%' or vw_grli_obra_list.etapa LIKE '%CULMINADO%' ) and grli_pip_total_priori.estado_pic like 'PRIORIZADO' ");

        $recordsFiltered = $Obra->count();

        $recordsTotal = $Obra->count();

        $start   =  $input['start'];
        $length  =  $input['length'];

        $Obra  = $Obra->skip($start)->take($length);

        return Response([
            'data' => $Obra->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ]);
    }

    public function evidenciaCreate(Request $request){
        $fecha = date('Y-m-d',strtotime($request->fecha));

        $Images = PipTotalPrioriImage::where( 'idobra',$request->idobra )
                    ->where( 'fecha', $fecha )
                    ->where('estado','1')
                    ->first();

        return view('obra.evidencia.create')->with([
                                                    'idObra' => $request->id,
                                                    'tiempo' => $request->tiempo,
                                                    'fecha' => $request->fecha,
                                                    'model' => $Images
                                                    ])->render();
    }

    public function evidenciaImageStore(Request $request){

        $input  = $request->all();
        //return $input;
        $fecha  = $input['fecha'];
        $descr  = $input['desc'];
        $obser  = $input['obs'];
        $idObra = $input['uid'];
        $tiempo = $input['tiempo'];
        $tipo   = $input['tipo'];

        $fecha = date('d-m-y',strtotime($input['fecha']));
        //TMP NAME OF IMAGES
        $tmpName = Tools::generateTmpName();
        $fileName = '';
        $lastNumber = 0;

        $arr = [
                    'Fecha' => $fecha,
                    'Descripción' => $descr,
                    'Tiempo' => $tiempo,
                    'Tipo' => $tipo

                  ];
        $rules = [
                    'Fecha' => 'required',
                    'Descripción' => 'required',
                    'Tiempo' => 'required'
                  ];
        $validator = Validator::make($arr, $rules);

        if ($validator->fails()){
             return Response::json([
                    'error' => true,
                    'message' => $validator->messages()->first(),
                    'code' => 400
                ], 400);
        }


        //VALIDATOR>>>>>>>>>>>>
        $file = Input::file('qqfile');

        $arr = ['file' => $file];

        $rules = [
            'file' => 'required|mimes:png,gif,jpeg,jpg,bmp,PNG,JPG,JPEG,BMP,GIF'
        ];

        $messages = [
            'file.mimes' => 'No es el formato de imagen que se admite',
            'file.required' => 'Imagen Requerida'
        ];
        $validator = Validator::make($arr, $rules, $messages);

        if ($validator->fails()) {

            return Response::json([
                'success' => false,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }

        //>>>>>>>>>>>>>>>>>>>>>>

        $Obra     = Obras::find($idObra);
        $Proyecto = PipTotalPriori::find($Obra->idproyecto);

        DB::beginTransaction();

        //OBTENEMOS EL NOMBRE DE LA ULTIMA IMAGEN
        $UltimaImagen = PipTotalPrioriImage::where('idproyecto',$Proyecto->id)
                        ->where('tiempo','ilike', $tiempo)
                        ->orderBy('fecha','desc')
                        ->orderBy('nombre','desc')
                        ->first();
        if ($UltimaImagen) {

            $ultimoIndice = explode('_', $UltimaImagen->nombre);
        }
        else {
            $ultimoIndice = 0;
        }


        $indiceActual = $ultimoIndice[2] + 1;
        $cod_unif     = $Proyecto->cod_unif;
        $nombreFoto   = $Proyecto->cod_unif . '_' . $tiempo . '_' . $indiceActual . '_' . date("d-m-y") . '.' . $file->clientExtension();
        $url          = "images/pip/" . $Proyecto->cod_unif . "/" . $tiempo . "/";

        //GUARDAMOS LA IMAGEN

        //return $request->file('qqfile');
        $request->file('qqfile')->storeAs( "/pip/{$cod_unif}/{$tiempo}", $nombreFoto, 'public_uploads');

        //SAVE IN DATABASE
        try {
            $PipTotalPrioriImage = new PipTotalPrioriImage();

            $PipTotalPrioriImage->url         = $url;
            $PipTotalPrioriImage->nombre      = $nombreFoto;
            $PipTotalPrioriImage->idobra      = $idObra;
            $PipTotalPrioriImage->idproyecto  = $Obra->idproyecto;
            $PipTotalPrioriImage->fecha       = $fecha;
            $PipTotalPrioriImage->tiempo      = $tiempo;

            $PipTotalPrioriImage->save();

        } catch(Exception $ex){
            return Response::json([
                'success' => false,
                'message' => 'Error del servidor',
                'code' => 500
            ], 500);
        }

        DB::commit();

        //ACTUALIZAMOS TODOS LOS REGISTROS RELACIONADOS
        $ImgRegistros = PipTotalPrioriImage::where('idobra', '=', $idObra)
        ->where('fecha', '=', $fecha)
        ->get();

        foreach ($ImgRegistros as $key => $reg) {

            $Registro = PipTotalPrioriImage::find($reg->id);
            $Registro->obs         = $obser;
            $Registro->descripcion = $descr;
            $Registro->tipo        = trim($tipo);
            $Registro->idusuario   = Auth::id();

            $Registro->save();
        }

        DB::commit();

        return Response::json([
            'success' => true
        ], 200);
    }

    public function evidenciaImageGet($idobra, $fecha){

        $images = PipTotalPrioriImage::where( 'idobra','=',$idobra)->where('fecha','=',$fecha)->where('estado','=','1')->get();

        return Response($images);
    }

    public function evidenciaImageDelete(Request $request){
        $id = $request->id;

        $image = PipTotalPrioriImage::find($id);

        $image->estado = '0';

        $image->save();

        return Response('',200);
    }

    public function evidenciaList(Request $request){
        return View("obra.evidencia.list");
    }

    public function evidenciaListFilter(Request $request){
        $input = $request->all();

        $Images = PipTotalPrioriImage::select([
                        'grli_pip_total_priori_img.tipo',
                        'grli_pip_total_priori_img.idobra',
                        'grli_pip_total_priori_img.tiempo',
                        'grli_pip_total_priori_img.descripcion',
                        DB::raw("to_char(grli_pip_total_priori_img.fecha, 'DD-MM-YYYY') as fecha")
                    ])
                    ->where('idobra', $input['id'])
                    ->where('estado','1')
                    ->groupBy('fecha','tipo','idobra','tiempo','descripcion')
                    ->get();

        return Response([
                'data' => $Images
        ]);
    }

    public function evidenciaShowObra(Request $request){
        $input = $request->all();

        $idObra = $input['id'];

        $Obra = DB::table('vw_grli_obra_list')
            ->where('id','=',$idObra)
            ->first();

        $Proyecto = PipTotalPriori::find($Obra->idproyecto);

        $Contratos = DB::table('grli_pip_total_priori_contratos')->where('idproyecto','=',$Proyecto->id)->orderByRaw('contrato_fecha::date desc')->get();

        return view('obra.evidencia.showObra')->with([
                                                        'Obra' => $Obra,
                                                        'Proyecto' => $Proyecto,
                                                        'Contratos' => $Contratos
                                                    ])->render();

    }

}
