<?php

namespace sayhuite\Logic\Funcion;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;

use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\DB;
use sayhuite\Taller_Usuario;
use sayhuite\Taller_Usuario_Reprogramacion;
use sayhuite\Taller_Img;
use sayhuite\Usuario;
use sayhuite\ActividadOperativa;
use Auth;
use Datetime;
use Excel;

class Educacion
{

    protected $controlador = 'poi';

    protected  $uarr = [
            1 => 'UGEL 08',
            2 => 'UGEL 09',
            3 => 'UGEL 10',
            4 => 'UGEL 11',
            5 => 'UGEL 12',
            6 => 'UGEL 13',
            7 => 'UGEL 14',
            8 => 'UGEL 15',
            9 => 'UGEL 16'
        ];

    function filter($input){

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isEspecialista = ( Auth::user()->hasRole('especialista_poi') );

        $Taller = DB::table('vw_poi_taller_usuario_educacion');

        //TALLERES QUE LE CORRESPONDEN
        if (!$isAdmin) {
            $Taller = $Taller->where('id_usuario', '=' , Auth::id());
        }

        /*if (!$isEspecialista) {
            $Taller = $Taller->where('id_usuario', '=' , Auth::id());
        }*/

        $recordsTotal = $Taller->count();

        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( !isset($input['fin']) or empty($input['fin']) ) ){
            $Taller = $Taller->where( 'fecha', '=' , $input['inicio'] );
        }

        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( isset($input['fin']) and !empty($input['fin']) ) ){
            $Taller = $Taller->where("fecha",">=",$input['inicio'])->where("fecha","<=",$input['fin']);
        }

        if( isset($input['estado']) ){
            switch ($input['estado']) {
                case '1':
                    $Taller = $Taller->where('state','complete');
                    break;
                case '2':
                    $Taller = $Taller->where('state','passed');
                    break;
                case '3':
                    $Taller = $Taller->where('state','programmed');
                    break;
                case '4':
                    $Taller = $Taller->where('state','noprogrammed');
                    break;
                default:
                    break;
            }
        }

        if(!empty($input['search']['value'])){
            $ss = '%'. ($input['search']['value']) .'%';
            $Taller = $Taller->whereRaw("( COALESCE(nombres, '') || COALESCE(apellidos,'') || COALESCE(nom_dist,'')  || COALESCE(dni,'') || COALESCE(intervencion,'') || COALESCE(activ_operativa,'') || COALESCE(grupo_funcional,'') || COALESCE(codigo_taller,'') || COALESCE(ejecutora,'') ) ilike ?",$ss);
        }

        //dd($Taller->get()->toArray(),$input['search']['value']);

        $order = $input['order'][0];
        $oColumn = $order['column'];
        $oType   = $order['dir'];

        $recordsFiltered = $Taller->count();
        if($input['columns'][$oColumn]['name'] != 'accion') {
            $Taller = $Taller->orderBy($input['columns'][$oColumn]['name'], "$oType")/*->groupBy('activ_operativa','grupo_funcional','poi_taller_usuario.fecha','poi_taller_usuario.hora','poi_taller_usuario.id','poi_taller_usuario.descripcion','poi_taller_usuario.created_at','poi_taller_usuario.updated_at','poi_taller_usuario.publicada','usuario.apellidos','usuario.nombres','ejecutora','nom_dist','codigo_taller','reprogramada')*/;
        }



        $start   =  $input['start'];
        $length  =  $input['length'];
        $Taller  = $Taller->skip($start)->take($length)->get();
        $Taller  = $this->defineState($Taller);
        //$param = 'complete';
        //dd($Taller);
        /*$Taller = $Taller->filter(function ($item) use ($param) {
            return $item['state'] == 'complete';
                //dd($item['state'] , 'complete');

        })->all();*/

        //$Taller  = $Taller->where('state','ilike','complete');


        return Response([
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ]);
    }

    function programacionFilter($input){
        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isRCI = ( Auth::user()->hasRole('edu_rci_poi') );

        $Taller = DB::table('vw_poi_taller_usuario_educacion')->where('estado','1');

        if ($isRCI) {
            $userDependencie = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where('ejecutora', 'ilike' , $userDependencie)->where('cod_cat_presupuestal', '=' , '0090');
        }

        //TALLERES QUE LE CORRESPONDEN
        if (!$isAdmin and !$isRCI) {
            $Taller = $Taller->where('id_usuario', '=' , Auth::id());
        }

        $recordsTotal = $Taller->count();

        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( !isset($input['fin']) or empty($input['fin']) ) ){
            $Taller = $Taller->where( 'fecha', '=' , $input['inicio'] );
        }

        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( isset($input['fin']) and !empty($input['fin']) ) ){
            $Taller = $Taller->where("fecha",">=",$input['inicio'])->where("fecha","<=",$input['fin']);
        }

        if( isset($input['estado']) ){
            switch ($input['estado']) {
                case '1':
                    $Taller = $Taller->where('state','complete');
                    break;
                case '2':
                    $Taller = $Taller->where('state','passed');
                    break;
                case '3':
                    $Taller = $Taller->where('state','programmed');
                    break;
                case '4':
                    $Taller = $Taller->where('state','noprogrammed');
                    break;
                default:
                    break;
            }
        }

        if(!empty($input['search']['value'])){
            $ss = '%'. ($input['search']['value']) .'%';
            $Taller = $Taller->whereRaw("( COALESCE(nombres, '') || COALESCE(apellidos,'') || COALESCE(nom_dist,'')  || COALESCE(dni,'') || COALESCE(intervencion,'') || COALESCE(activ_operativa,'') || COALESCE(grupo_funcional,'') || COALESCE(codigo_taller,'') || COALESCE(ejecutora,'') || COALESCE(docente,'') || COALESCE(ie,'') ) ilike ?",$ss);
        }

        $order = $input['order'][0];
        $oColumn = $order['column'];
        $oType   = $order['dir'];

        //return $input;

        $recordsFiltered = $Taller->count();
        
        $Taller = $Taller->orderBy($input['columns'][$oColumn]['name'], "$oType");
        
        $start   =  $input['start'];
        $length  =  $input['length'];
        $Taller  = $Taller->skip($start)->take($length);
        //$Taller  = $this->defineState($Taller);

        return Response([
            'data' => $Taller->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ]);
    }

    function seguimientoFilter($input,$export=false){

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table('vw_poi_taller_usuario_educacion')->where('estado','1');

        //TALLERES QUE LE CORRESPONDEN
        if (!$isAdmin) {
            if ( $isGesDirRCI ) {
                $userDependencie = Auth::user()->unidad()->pluck('sigla')->first();
                $Taller = $Taller->where('ejecutora', 'ilike' , $userDependencie);
            } else if( $isEspecialista ){
                $dni =  Auth::user()->dni;

                $Taller = $Taller->whereRaw("trim(split_part(resp_institucional,'/', 1)) ilike '" . $dni ."'");
            }
        }

        $recordsTotal = $Taller->count();
        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( !isset($input['fin']) or empty($input['fin']) ) ){
            $Taller = $Taller->where( 'fecha', '=' , $input['inicio'] );
        }

        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( isset($input['fin']) and !empty($input['fin']) ) ){
            $Taller = $Taller->where("fecha",">=",$input['inicio'])->where("fecha","<=",$input['fin']);
        }

        if( isset($input['estado']) ){
            switch ($input['estado']) {
                case '1':
                    $Taller = $Taller->where('state','complete');
                    break;
                case '2':
                    $Taller = $Taller->where('state','passed');
                    break;
                case '3':
                    $Taller = $Taller->where('state','programmed');
                    break;
                case '4':
                    $Taller = $Taller->where('state','noprogrammed');
                    break;
                default:
                    break;
            }
        }

        if( isset($input['tipact'] ) ){
            if( !empty($input['tipact'] ) ){
                $Taller = $Taller->where("tipo_activ_operativa","like",$input['tipact']);
            }
        }

        if( $isAdmin ){

            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){

                $Taller = $Taller->where('ejecutora','ilike',$this->uarr[$input['ugel']]);
            }
        }

        if(!empty($input['search']['value'])){
            $ss = '%'. ($input['search']['value']) .'%';
            $Taller = $Taller->whereRaw("( COALESCE(nombres, '') || COALESCE(apellidos,'') || COALESCE(nom_dist,'')  || COALESCE(dni,'') || COALESCE(intervencion,'') || COALESCE(activ_operativa,'') || COALESCE(grupo_funcional,'') || COALESCE(codigo_taller,'') || COALESCE(ejecutora,'') || COALESCE(docente,'')  ) ilike ?",$ss);
        }

        $recordsFiltered = $Taller->count();
        $legend  = $this->listLegend($Taller->get());
        if(!$export){

            $order = $input['order'][0];
            $oColumn = $order['column'];
            $oType   = $order['dir'];

            
            $Taller = $Taller->orderBy($input['columns'][$oColumn]['name'], "$oType");
            

            $start   =  $input['start'];
            $length  =  $input['length'];
            $Taller  = $Taller->skip($start)->take($length);
        }
        //$Taller  = $this->defineState($Taller);

        return [
            'data' => $Taller->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'legend' => $legend
        ];
    }

    function observadosFilter($input){

        //id	estado	id_usuario	fecha	ie	docente	codigo_taller	descripcion	reprogramada	nom_dist	cod_cat_presupuestal	funcion	grupo_funcional	activ_operativa	tipo_activ_operativa	nombre_usuario	apellidos	nombres	cargo	intervencion	dni	resp_institucional	nombre	today	ejecutora	state
      $Taller = Taller_Img::select([
                DB::raw('poi_taller_img.id as idimg'),
                'poi_taller_img.url',
                'poi_taller_img.nombre',
                'poi_taller_img.fecha',
                'poi_taller_img.estado',
                'poi_taller_img.exif',
                'poi_taller_img.exifdata',
                'poi_taller_img.created_at',
                'poi_taller_img.updated_at',
                'poi_taller_img.imgcdata',
                'poi_taller_img.imghash',
                'poi_taller_img.semejantes',
                'vw_poi_taller_usuario_educacion.id_usuario',
                'vw_poi_taller_usuario_educacion.tipo_activ_operativa',
                'vw_poi_taller_usuario_educacion.ejecutora',
                'vw_poi_taller_usuario_educacion.nombre_usuario',
                'vw_poi_taller_usuario_educacion.dni'
              ])
              ->whereRaw("poi_taller_img.semejantes != '[]' ")
              ->where("poi_taller_img.estado", "!=", '0')
              ->leftJoin('vw_poi_taller_usuario_educacion', 'poi_taller_img.id_poi_taller_usuario', '=', 'vw_poi_taller_usuario_educacion.id');
    
      $recordsTotal = $Taller->count();

      $order = $input['order'][0];
      $oColumn = $order['column'];
      $oType   = $order['dir'];

      if( isset($input['tipact'] ) ){
        if( !empty($input['tipact'] ) ){
            $Taller = $Taller->where("tipo_activ_operativa","like",$input['tipact']);
        }
      }

      if ( isset($input['ugel']) ){
        if( !empty($input['ugel'] ) and $input['ugel'] != 0 ){
          $Taller = $Taller->where('ejecutora','ilike',$this->uarr[$input['ugel']]);
        }
      }

      if(!empty($input['search']['value'])){
        $ss = '%'. ($input['search']['value']) .'%';
        $Taller = $Taller->whereRaw("( COALESCE(nombre_usuario, '') || COALESCE(dni,'') || COALESCE(docente,'')  ) ilike ?",$ss);
      }

      $recordsFiltered = $Taller->count();
      if($input['columns'][$oColumn]['name'] != 'accion') {
        $Taller = $Taller->orderBy($input['columns'][$oColumn]['name'], "$oType");
      }

      $start   =  $input['start'];
      $length  =  $input['length'];
      $Taller  = $Taller->skip($start)->take($length);

      return Response([
          'data' => $Taller->get(),
          'recordsTotal' => $recordsTotal,
          'recordsFiltered' => $recordsFiltered
      ]);
    }

    function listLegend( $data ){
        $totalEtapa = 0;
        $resultSet = [];

        $arrNameTipo = [
            'completos' => 'complete',
            'incompletos' => 'passed',
            'planificados' => 'programmed',
        ];

        foreach($arrNameTipo as $val=>$name){
            $resultSet[$val] = count($data->where('state','like',$name)->toArray());
            $totalEtapa += count($data->where('state','like',$name)->toArray());
        }

        return $resultSet;
    }

    function export($input){

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table('vw_poi_taller_usuario_educacion');

        //TALLERES QUE LE CORRESPONDEN
        if (!$isAdmin) {
            if ( $isGesDirRCI ) {
                $userDependencie = Auth::user()->unidad()->pluck('sigla')->first();
                $Taller = $Taller->where('ejecutora', 'ilike' , $userDependencie);
            } else if( $isEspecialista ){
                $dni =  Auth::user()->dni;

                $Taller = $Taller->whereRaw("trim(split_part(resp_institucional,'/', 1)) ilike '" . $dni ."'");
            }
        }

        $recordsTotal = $Taller->count();
        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( !isset($input['fin']) or empty($input['fin']) ) ){
            $Taller = $Taller->where( 'fecha', '=' , $input['inicio'] );
        }

        if( ( isset($input['inicio']) and !empty($input['inicio']) ) and ( isset($input['fin']) and !empty($input['fin']) ) ){
            $Taller = $Taller->where("fecha",">=",$input['inicio'])->where("fecha","<=",$input['fin']);
        }

        if( isset($input['estado']) ){
            switch ($input['estado']) {
                case '1':
                    $Taller = $Taller->where('state','complete');
                    break;
                case '2':
                    $Taller = $Taller->where('state','passed');
                    break;
                case '3':
                    $Taller = $Taller->where('state','programmed');
                    break;
                case '4':
                    $Taller = $Taller->where('state','noprogrammed');
                    break;
                default:
                    break;
            }
        }

        if( $isAdmin ){

            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){

                $Taller = $Taller->where('ejecutora','ilike',$this->uarr[$input['ugel']]);
            }
        }

        if(!empty($input['search'])){
            $ss = '%'. ($input['search']) .'%';
            $Taller = $Taller->whereRaw("( COALESCE(nombres, '') || COALESCE(apellidos,'') || COALESCE(nom_dist,'')  || COALESCE(dni,'') || COALESCE(intervencion,'') || COALESCE(activ_operativa,'') || COALESCE(grupo_funcional,'') || COALESCE(codigo_taller,'') || COALESCE(ejecutora,'') ) ilike ?",$ss);
        }

        $tTaller = $Taller->get()->toArray();
        $tTaller= json_decode( json_encode($tTaller), true);

        return Excel::create('Sayhuite', function($excel) use ($tTaller) {
            $excel->sheet('Sayhuite', function($sheet) use ($tTaller)
                {
                    $sheet->fromArray($tTaller);
                    $sheet->setOrientation('landscape');
                });
        })->download('xlsx');
    }

    function defineState($data){

        $ndata = $data->map(function ($item, $key) {

            $item->state = Taller_Usuario::tallerEstado($item);

            return $item;
        });
        return $ndata;
    }

    function add($input){

    	$rules = [
                'cboTaller' => 'required',
                'txtFecha' => 'required|date|after_or_equal:'. date("Y-m-d"),
                //'txtHora' => 'required|date_format:H:i',
                //'txtDescripcion' => 'required',
                'txtDocente' => 'required',
                'txtIE' => 'required',
                'idUsuario' => 'required|numeric',
                'cboDistrito' => 'required'
            ];

            $attributeNames = [
                'cboTaller' => 'Actividad',
                'txtFecha' => 'Fecha',
                'cboDistrito' => 'Distrito',
                'idUsuario' => 'Responsable',
                //'txtDescripcion' => 'Descripción',
                'txtDocente' => 'Docente',
                'txtIE' => 'Institución Educativa'
            ];


        $validator = Validator::make($input, $rules, ['after_or_equal' => 'La fecha debe ser mayor o igual a hoy']);
            $validator->setAttributeNames($attributeNames);
            if ($validator->fails()) {
                $mensaje_error = [];
                $mensajes = $validator->messages();
                foreach ($mensajes->all() as $mensaje) {
                    array_push($mensaje_error, $mensaje);
                }
                return Response([
                        'error' => 1,
                        'messages' => $mensaje_error,
                        'data' => ""
                ],400);

            } else {

                DB::beginTransaction();

                try{

                    $Taller_Usuario = new Taller_Usuario();

                    $Taller_Usuario->id_act_operativa  	= $input['cboTaller'];
                    $Taller_Usuario->id_usuario     	= $input['idUsuario'];
                    $Taller_Usuario->fecha          	= $input['txtFecha'];
                    //$Taller_Usuario->descripcion    	= $input['txtDescripcion'];
                    $Taller_Usuario->publicada      	= 0;
                    $Taller_Usuario->reprogramada   	= 0;
                    $Taller_Usuario->estado         	= 1;
                    $Taller_Usuario->id_distrito    	= $input['cboDistrito'];
                    $Taller_Usuario->docente         	= $input['txtDocente'];;
                    $Taller_Usuario->ie         		= $input['txtIE'];

                    $Taller_Usuario->save();

                    $Taller_Usuario->codigo_taller      = "ETP". sprintf("%06d",$Taller_Usuario->id);

                    $Taller_Usuario->save();

                } catch(Exception $e){
                    DB::rollback();
                    return Response('Error al Guardar',500);
                }

                DB::commit();

                return Response('Se Agregó la programación de la actividad',200);
            }
    }

    function show($id){
    	$Taller = Taller_Usuario::select([
                'poi_taller_usuario.id',
                DB::raw('to_char(poi_taller_usuario.fecha, \'DD-MM-YYYY\') as fecha'),
                'poi_taller_usuario.id_usuario',
                'poi_taller_usuario.descripcion',
                //'poi_taller_usuario.publicada',
                'poi_taller_usuario.created_at',
                'poi_taller_usuario.reprogramada',
                'poi_taller_usuario.docente',
                'poi_taller_usuario.ie',
                'peru_distrito_.nom_prov',
                'peru_distrito_.nom_dist',
                'cadena_funcional_programatica.funcion',
                'cadena_funcional_programatica.cat_presupuestal',
                'cadena_funcional_programatica.act_presupuestal',
                'cadena_funcional_programatica.producto',
                'poi_actividad_operativa.nombre',
                'poi_actividad_operativa.um',
                //'poi_actividad_operativa.resp_institucional',
                'poi_taller_usuario.resp_institucional',
                //'poi_actividad_operativa.resp_operativo'
                DB::raw('( CASE WHEN cadena_funcional_programatica.act_presupuestal ilike \'%polidocente%\' THEN \'Soporte\'
                            WHEN cadena_funcional_programatica.act_presupuestal ilike  \'%multigrado%\' THEN \'Multigrado\'
                            ELSE \'\'
                        END ) as intervencion')
            ])
            ->join('poi_actividad_operativa', 'poi_actividad_operativa.id','=','poi_taller_usuario.id_act_operativa')
            ->join('cadena_funcional_programatica','cadena_funcional_programatica.id','=','poi_actividad_operativa.id_cadena')
            ->join('peru_distrito_', 'peru_distrito_.gid','=','poi_taller_usuario.id_distrito')
            ->where('poi_taller_usuario.id',$id)
            ->where('poi_taller_usuario.estado',1)->get();

        $Reprogramacion = Taller_Usuario_Reprogramacion::select([
                            'id',
                            'idtaller',
                            'accion',
                            'observacion',
                            'docente_antes',
                            'docente_despues',
                            'fecha_antes',
                            'fecha_despues',
                            'lugar_antes',
                            'lugar_despues',
                            DB::raw(' (select nom_dist from peru_distrito_ where gid = id_distrito_antes ) as nom_distrito_antes' ),
                            DB::raw(' (select nom_dist from peru_distrito_ where gid = id_distrito_despues ) as nom_distrito_despues' ),
                            'dni_antes',
                            'dni_despues',
                            'created_at',
                            'updated_at'
                        ])
                        ->where('idtaller', '=', $id)
                        ->where('accion', 'like' , 'Reprogramar')
                        ->get();

        /*
         || \' \' ||
                        ( CASE WHEN cadena_funcional_programatica.grupo_funcional ilike \'%primari%\' THEN \'Primaria\'
                            WHEN cadena_funcional_programatica.act_presupuestal ilike  \'%secundaria%\' THEN \'Secundaria\'
                            ELSE \'\'
                        END )
        */

        $Responsable = Usuario::find($Taller[0]->id_usuario);

        $Taller = $this->defineState($Taller);

        //dd($Taller[0]->resp_institucional);
        try{
            $RespInstitucional = Usuario::where('usuario.dni', trim(explode('/',$Taller[0]->resp_institucional)[0]) )->first();
        } catch(Exception $ex){
            $RespInstitucional = "";
        }

        return view($this->controlador.'.educacion.show')->with([
                'Taller' => $Taller[0],
                'Responsable' => $Responsable,
                'ResponsableInstitucional' => $RespInstitucional,
                'Reprogramacion' => $Reprogramacion
            ])->render();
    }

    function edit($id){

        $Taller = DB::table('vw_poi_taller_usuario_educacion_detail')
                    ->where('id',$id)->first();

        $Reprogramacion = Taller_Usuario_Reprogramacion::select([
                                'id',
                                'idtaller',
                                'accion',
                                'observacion',
                                'docente_antes',
                                'docente_despues',
                                'fecha_antes',
                                'fecha_despues',
                                'lugar_antes',
                                'lugar_despues',
                                DB::raw(' (select nom_dist from peru_distrito_ where gid = id_distrito_antes ) as nom_distrito_antes' ),
                                DB::raw(' (select nom_dist from peru_distrito_ where gid = id_distrito_despues ) as nom_distrito_despues' ),
                                'dni_antes',
                                'dni_despues',
                                'created_at',
                                'updated_at'
                            ])
                            ->where('idtaller', '=', $id)
                            ->where('accion', 'like' , 'Reprogramar')
                            ->get();

        $Distritos = DB::table('peru_distrito_')
                    ->select([
                      'gid',
                      'nom_dist',
                      'cod_dist',
                      DB::raw("nom_dist || ' - ' || upper(nom_prov)  as formated_nom_dist")
                    ])->get();

        $Distritos = $Distritos->map(function ($item, $key) use($Taller) {
          if ( $item->cod_dist == $Taller->cod_dist  ){
            $item->selected = 'selected';
          } else {
            $item->selected = '';
          }

          return $item;
        });

        return view($this->controlador.'.educacion.edit')->with(
            [
                'Taller' => $Taller,
                'Distritos'=> $Distritos, 
                'Reprogramacion' => $Reprogramacion 
            ])->render();
    }

    function reprogramar($input){
        $rules = [
            'txtFecha' => 'required|date|date_format:d-m-Y',
            'txtDni' => 'required|max:9|string',
            'txtDocente' => 'required|max:100|string',
            'txtIe' => 'required|max:150|string',
            'ddlDistrito' => 'required',
            'txtRazon' => 'required|string|max:250'
        ];

        $attributeNames = [
            'txtFecha' => 'Fecha',
            'txtDni' => 'Dni',
            'txtIe' => 'Lugar',
            'txtDocente' => 'Docente',
            'ddlDistrito' => 'Distrito',
            'txtRazon' => 'Razón'
        ];

        $validator = Validator::make($input, $rules);
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            $mensaje_error = [];
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                array_push($mensaje_error, $mensaje);
            }
            return Response([
                    'error' => 1,
                    'messages' => $mensaje_error,
                    'data' => ""
            ],400);

        } else {

            $Taller_Usuario = Taller_Usuario::find($input['id']);
            $changes  = 0;
            if( $input['txtFecha'] != DateTime::createFromFormat('Y-m-d', $Taller_Usuario->fecha)->format('d-m-Y') ){
                $changes++;
            }

            if( $input['txtDni'] != $Taller_Usuario->dni_docente ){
                $changes++;
            }

            if( $input['txtDocente'] != $Taller_Usuario->docente ){
                $changes++;
            }

            if( $input['txtIe'] != $Taller_Usuario->ie ){
                $changes++;
            }

            if( $input['ddlDistrito'] != $Taller_Usuario->id_distrito ){
                $changes++;
            }
            if ( $changes == 0 ) {
                return Response([
                    'error' => 1,
                    'messages' => ['Al menos debe hacer un cambio'],
                    'data' => ""
                ],400);
            }

            DB::beginTransaction();

            try{

                $Taller_Usuario_Old = Taller_Usuario::find($input['id']);
                $Taller_Usuario = Taller_Usuario::find($input['id']);

                if ( $Taller_Usuario->reprogramada == 3 ) {
                    return Response([
                        'error' => 1,
                        'messages' => ['Ya no se puede reprogramar la actividad'],
                        'data' => ""
                    ],400);
                }

                $Taller_Usuario->fecha = $input['txtFecha'];
                $Taller_Usuario->dni_docente = $input['txtDni'];
                $Taller_Usuario->docente = $input['txtDocente'];
                $Taller_Usuario->ie = $input['txtIe'];
                $Taller_Usuario->id_distrito = $input['ddlDistrito'];
                $Taller_Usuario->reprogramada = ( (int)$Taller_Usuario->reprogramada + 1 );

                $Taller_Usuario->save();
                
                $Taller_Usuario_Reprogramacion = new Taller_Usuario_Reprogramacion();

                $Taller_Usuario_Reprogramacion->idtaller = $Taller_Usuario->id;
                $Taller_Usuario_Reprogramacion->accion = 'Reprogramar';
                $Taller_Usuario_Reprogramacion->observacion = $input['txtRazon'];
                $Taller_Usuario_Reprogramacion->docente_antes = $Taller_Usuario_Old->docente;
                $Taller_Usuario_Reprogramacion->docente_despues = $input['txtDocente'];
                $Taller_Usuario_Reprogramacion->fecha_antes = $Taller_Usuario_Old->fecha;
                $Taller_Usuario_Reprogramacion->fecha_despues = $input['txtFecha'];
                $Taller_Usuario_Reprogramacion->lugar_antes = $Taller_Usuario_Old->ie;
                $Taller_Usuario_Reprogramacion->lugar_despues = $input['txtIe'];
                $Taller_Usuario_Reprogramacion->id_distrito_antes = $Taller_Usuario_Old->id_distrito;
                $Taller_Usuario_Reprogramacion->id_distrito_despues = $input['ddlDistrito'];
                $Taller_Usuario_Reprogramacion->dni_antes = $Taller_Usuario_Old->dni_docente;
                $Taller_Usuario_Reprogramacion->dni_despues = $input['txtDni'];

                $Taller_Usuario_Reprogramacion->save();

            } catch(Exception $e){
                DB::rollback();
                return Response('Error al Guardar',500);
            }

            DB::commit();

            return Response('Se Actualizó la programación',200);
        }
    }



    //================ REPORTES ===========================

    function resumenxActividadOperativaFilter( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "dependencia.sigla like '$ugel' and ";
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $ugel =  $this->uarr[$input['ugel']];
                $ugel = "dependencia.sigla like '$ugel' and ";
            }
        }


        $Taller = ActividadOperativa::select([
             "cadena_funcional_programatica.funcion",
             "cadena_funcional_programatica.act_presupuestal",
             "cadena_funcional_programatica.cat_presupuestal",
             "cadena_funcional_programatica.producto",
             "poi_actividad_operativa.nombre",
             DB::raw("( SELECT count(DISTINCT poi_taller_img.id_poi_taller_usuario)
              FROM poi_taller_img
              JOIN poi_taller_usuario ON poi_taller_usuario.id = poi_taller_img.id_poi_taller_usuario
              inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
              inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
              inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
              WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id AND poi_taller_img.estado = '1'::bpchar and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date)
             ) AS completas"),
           DB::raw("( SELECT count(poi_taller_usuario.id)
              FROM poi_taller_usuario
              inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
              inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
              inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
              WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date)
            ) AS programadas"),
           DB::raw("( CASE
              WHEN (
                ( SELECT count(poi_taller_usuario.id)
                    FROM poi_taller_usuario
                  inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
                  inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
                  inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
                  WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date) )
                ) <> 0
              THEN (
                    ((SELECT count(DISTINCT poi_taller_img.id_poi_taller_usuario)
                           FROM poi_taller_img
                      JOIN poi_taller_usuario ON poi_taller_usuario.id = poi_taller_img.id_poi_taller_usuario
                      inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
                      inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
                      inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
                     WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id AND poi_taller_img.estado = '1'::bpchar and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date) ))::double precision
                    /
                   (( SELECT count(poi_taller_usuario.id)
                       FROM poi_taller_usuario
                      inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
                      inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
                      inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
                      WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date) ))::double precision * 100::double precision)::numeric(3,0)
              ELSE 0::numeric
              END
            ) AS percent")])
        ->join("cadena_funcional_programatica","cadena_funcional_programatica.id", "=", "poi_actividad_operativa.id_cadena")
        ->whereRaw("cadena_funcional_programatica.grupo_funcional::text ~~* '%educacion%'::text")
        ->orderByRaw("
            ( CASE
              WHEN (
                ( SELECT count(poi_taller_usuario.id)
                    FROM poi_taller_usuario
                  inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
                  inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
                  inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
                  WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date) )
                ) <> 0
              THEN (
                    ((SELECT count(DISTINCT poi_taller_img.id_poi_taller_usuario)
                           FROM poi_taller_img
                      JOIN poi_taller_usuario ON poi_taller_usuario.id = poi_taller_img.id_poi_taller_usuario
                      inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
                      inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
                      inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
                     WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id AND poi_taller_img.estado = '1'::bpchar and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date) ))::double precision
                    /
                   (( SELECT count(poi_taller_usuario.id)
                       FROM poi_taller_usuario
                      inner join usuario on poi_taller_usuario.id_usuario = usuario.idusuario
                      inner join usuario_dependencia on usuario_dependencia.idusuario = usuario.idusuario
                      inner join dependencia on dependencia.iddependencia = usuario_dependencia.iddependencia
                      WHERE $ugel poi_taller_usuario.id_act_operativa = poi_actividad_operativa.id and ( poi_taller_usuario.fecha, poi_taller_usuario.fecha ) overlaps ('$fechai'::date,'$fechaf'::date) ))::double precision * 100::double precision)::numeric(3,0)
              ELSE 0::numeric
              END
            ) DESC;");

        $Taller = $Taller->get();

        $recordsTotal = $Taller->count();
        $recordsFiltered = $Taller->count();

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    //----------- 90

    function resumenxAcompFilter_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $Taller = DB::table("vw_poi_taller_usuario_detail AS vv")->select([
                "vv.id_usuario",
                "vv.nombre_usuario",
                "vv.activo",
                "vv.ejecutora",
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where  vd.ejecutora=vv.ejecutora and vd.state='passed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario),0)as passed"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario),0)  as complete"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='programmed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario),0)  as programmed"),
                DB::raw("COALESCE((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora
                and (vd.state='passed' or vd.state='complete' or vd.state='programmed')
                and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf'
                and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario),0)  as total"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='passed' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_passed"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and cargo ilike 'ACOMPAÑANTE'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_complete")
                ])
                ->where("vv.cargo","ilike",'ACOMPAÑANTE')->where("vv.fecha",">=","'$fechai'")->where("vv.fecha","<=","'$fechaf'")

                ->groupBy("vv.id_usuario", "vv.nombre_usuario","vv.ejecutora","vv.activo")
                ->orderBy("porcen_complete", "desc");

        $recordsTotal = count($Taller->get());

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

    }

    function resumenxEspecFilter_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $Taller = DB::table("vw_poi_taller_usuario_detail AS vv")->select([
                "vv.id_usuario",
                "vv.nombre_usuario",
                "vv.activo",
                "vv.ejecutora",
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where  vd.ejecutora=vv.ejecutora and vd.state='passed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario),0)as passed"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario),0)  as complete"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='programmed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario),0)  as programmed"),
                DB::raw("COALESCE((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora
                and (vd.state='passed' or vd.state='complete' or vd.state='programmed')
                and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf'
                and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario),0)  as total"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='passed' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_passed"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and cargo ilike 'ESPECIALISTA'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_complete")
                ])
                ->where("vv.cargo","ilike",'ESPECIALISTA')->where("vv.fecha",">=","'$fechai'")->where("vv.fecha","<=","'$fechaf'")

                ->groupBy("vv.id_usuario", "vv.nombre_usuario","vv.ejecutora","vv.activo")
                ->orderBy("porcen_complete", "desc");


        $recordsTotal = count($Taller->get());

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

    }

    function resumenxDmFilter_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $Taller = DB::table("vw_poi_taller_usuario_detail AS vv")->select([
                "vv.id_usuario",
                "vv.nombre_usuario",
                "vv.activo",
                "vv.ejecutora",
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where  vd.ejecutora=vv.ejecutora and vd.state='passed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike '%ALMAC%'
                group by vd.id_usuario),0)as passed"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike '%ALMAC%'
                group by vd.id_usuario),0)  as complete"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='programmed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and cargo ilike '%ALMAC%'
                group by vd.id_usuario),0)  as programmed"),
                DB::raw("COALESCE((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora
                and (vd.state='passed' or vd.state='complete' or vd.state='programmed')
                and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf'
                and cargo ilike '%ALMAC%'
                group by vd.id_usuario),0)  as total"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='passed' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and cargo ilike '%ALMAC%'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and cargo ilike '%ALMAC%'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_passed"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and cargo ilike '%ALMAC%'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and cargo ilike '%ALMAC%'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_complete")
                ])
                ->where("vv.cargo","ilike",'%ALMAC%')->where("vv.fecha",">=","'$fechai'")->where("vv.fecha","<=","'$fechaf'")

                ->groupBy("vv.id_usuario", "vv.nombre_usuario","vv.ejecutora","vv.activo")
                ->orderBy("porcen_complete", "desc");

        $recordsTotal = count($Taller->get());

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

    }

    function resumenxDia_90( $input ){

        $fecha = DateTime::createFromFormat('d-m-Y', $input["fecha"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_educacion as vte")->select([
            DB::raw("(select (apellidos || ', ' ||nombres) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as director"),
            DB::raw("(select (celular) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as celdirector"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as gestor"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as celgestor"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as agp"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as celagp"),
            "activ_operativa",
            "vte.fecha",
            "ejecutora",
            "nom_dist",
            "nombre_usuario",
            DB::raw("us.celular as celacomp"),
            DB::raw("CASE WHEN state='programmed' THEN 'INCOMPLETO'
                 WHEN state='passed' THEN 'INCOMPLETO'
                 WHEN state='complete' THEN 'COMPLETO'
            end as estado")
            ])
            ->join("usuario as us", "vte.id_usuario","=","us.idusuario")
            ->where("vte.cargo","ilike",'ACOMPAÑANTE')->where("vte.fecha","=",$fecha)
            ->orderByRaw("9 ,11, 13 asc");

        $recordsTotal = count($Taller->get());

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function resumenEspecxDia_90( $input ){

        $fecha = DateTime::createFromFormat('d-m-Y', $input["fecha"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_educacion as vte")->select([
            DB::raw("(select (apellidos || ', ' ||nombres) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as director"),
            DB::raw("(select (celular) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as celdirector"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as gestor"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as celgestor"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as agp"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as celagp"),
            "activ_operativa",
            "vte.fecha",
            "ejecutora",
            "nom_dist",
            "nombre_usuario",
            DB::raw("us.celular as celacomp"),
            DB::raw("CASE WHEN state='programmed' THEN 'INCOMPLETO'
                 WHEN state='passed' THEN 'INCOMPLETO'
                 WHEN state='complete' THEN 'COMPLETO'
            end as estado")
            ])
            ->join("usuario as us", "vte.id_usuario","=","us.idusuario")
             ->where("vte.cargo","ilike",'ESPECIALISTA')->where("vte.fecha","=",$fecha)
            ->orderByRaw("9 ,11, 13 asc");

        $recordsTotal = count($Taller->get());

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

    }

    function resumenDmxDia_90( $input ){

        $fecha = DateTime::createFromFormat('d-m-Y', $input["fecha"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_educacion as vte")->select([
            DB::raw("(select (apellidos || ', ' ||nombres) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as director"),
            DB::raw("(select (celular) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as celdirector"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as gestor"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as celgestor"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as agp"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as celagp"),
            "activ_operativa",
            "vte.fecha",
            "ejecutora",
            "nom_dist",
            "nombre_usuario",
            DB::raw("us.celular as celacomp"),
            DB::raw("CASE WHEN state='programmed' THEN 'INCOMPLETO'
                 WHEN state='passed' THEN 'INCOMPLETO'
                 WHEN state='complete' THEN 'COMPLETO'
            end as estado")
            ])
            ->join("usuario as us", "vte.id_usuario","=","us.idusuario")
            ->where("vte.cargo","ilike",'%almac%')->where("vte.fecha","=",$fecha)
            ->orderByRaw("9 ,11, 13 asc");

        $recordsTotal = count($Taller->get());

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        //dd($Taller->get()->toArray());

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];

    }

    function resumenxUgel_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and u.activo='1' and ptud.cargo ilike 'ACOMPA%' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");



        //$recordsTotal = count($Taller);

        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];

    }

    function resumenEspecxUgel_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and ptud.intervencion like 'PP-090'and ptud.cargo ilike 'ESPECIAL%' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");

        //$recordsTotal = count($Taller);
        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];

    }

    function resumenDmxUgel_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and ptud.cargo ilike '%ALMAC%' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");

        //$recordsTotal = count($Taller);

        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];

    }

    function resumenxUgelDia_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_detail as vv")->select([
                "ejecutora","fecha",
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where vd.state='passed' and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha) and vd.cargo ilike 'ACOMPAÑANTE'
                group by vd.ejecutora),0)as passed"),
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where vd.state='complete' and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha) and vd.cargo ilike 'ACOMPAÑANTE'
                group by vd.ejecutora),0)  as complete"),
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where (vd.state='complete' or vd.state ='passed')
                and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha)
                and cargo ilike 'ACOMPAÑANTE'
                group by vd.ejecutora),0)  as total")])
                ->where("vv.cargo","ilike",'ACOMPAÑANTE')->where( "fecha",">=","$fechai")->where("fecha","<=","$fechaf")
                ->groupBy("ejecutora","fecha")
                ->orderByRaw("ejecutora desc,fecha asc");


         $recordsTotal = count($Taller);


          if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $recordsFiltered = count($Taller);

        //dd($Taller->get()->toArray());

        return [
            'data' => $Taller->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function resumenEspecxUgelDia_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_detail as vv")->select([
                "ejecutora","fecha",
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where vd.state='passed' and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha) and vd.cargo like 'ESPECIALISTA'
                group by vd.ejecutora),0)as passed"),
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where vd.state='complete' and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha) and vd.cargo like 'ESPECIALISTA'
                group by vd.ejecutora),0)  as complete"),
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where (vd.state='complete' or vd.state ='passed')
                and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha)
                and vd.cargo like 'ESPECIALISTA'
                group by vd.ejecutora),0)  as total")])
                ->where("vv.cargo","like",'ESPECIALISTA')->where( "fecha",">=","$fechai")->where("fecha","<=","$fechaf")
                ->groupBy("ejecutora","fecha")
                ->orderByRaw("ejecutora desc,fecha asc");

        $recordsTotal = count($Taller);


        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function resumenDmxUgelDia_90( $input ){

        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_detail as vv")->select([
                "ejecutora","fecha",
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where vd.state='passed' and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha) and vd.cargo like 'RESPONSABLE DE ALMACEN'
                group by vd.ejecutora),0)as passed"),
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where vd.state='complete' and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha) and vd.cargo like 'RESPONSABLE DE ALMACEN'
                group by vd.ejecutora),0)  as complete"),
                DB::raw("COALESCE((select count(distinct(id)) from vw_poi_taller_usuario_detail vd
                where (vd.state='complete' or vd.state ='passed')
                and vd.ejecutora=vv.ejecutora and (fecha=vv.fecha)
                and vd.cargo like 'RESPONSABLE DE ALMACEN'
                group by vd.ejecutora),0)  as total")])
                ->where("vv.cargo","like",'RESPONSABLE DE ALMACEN')
                ->where( "fecha",">=","$fechai")
                ->where("fecha","<=","$fechaf")
                ->groupBy("ejecutora","fecha")
                ->orderByRaw("ejecutora desc,fecha asc");


        $recordsTotal = count($Taller->get());

        if( $input["nivel"] != '0' and !empty($input["nivel"]) ){
            $Taller = $Taller->where("grupo_funcional", "like", $input["nivel"]);
        }

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller =  $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }
    //--------- 90 #end

    //--------- 068
    function activ_op_personal_068( $input ){


    }

    function activ_op_ugel_068( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $act_op = "";
        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $act_op = "and ptud.activ_operativa like '".$input['act_op']."'";
        }

        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and ptud.intervencion like 'PP-068' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                $act_op
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];
    }

    function det_avan_persona_068( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-068'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $Taller = DB::table("vw_poi_taller_usuario_detail AS vv")->select([
                "vv.id_usuario",
                "vv.nombre_usuario",
                "vv.activo",
                "vv.ejecutora",
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where  vd.ejecutora=vv.ejecutora and vd.state='passed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-068'
                group by vd.id_usuario),0)as passed"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-068'
                group by vd.id_usuario),0)  as complete"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='programmed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-068'
                group by vd.id_usuario),0)  as programmed"),
                DB::raw("COALESCE((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora
                and (vd.state='passed' or vd.state='complete' or vd.state='programmed')
                and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf'
                and intervencion like 'PP-068'
                group by vd.id_usuario),0)  as total"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='passed' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and intervencion like 'PP-068'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and intervencion like 'PP-068'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_passed"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and intervencion like 'PP-068'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and intervencion like 'PP-068'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_complete")
                ])
                ->where("vv.intervencion","ilike",'PP-068')
                ->where("vv.fecha",">=","'$fechai'")
                ->where("vv.fecha","<=","'$fechaf'")

                ->groupBy("vv.id_usuario", "vv.nombre_usuario","vv.ejecutora","vv.activo")
                ->orderBy("porcen_complete", "desc");

        $recordsTotal = count($Taller->get());

        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $Taller = $Taller->where("vv.activ_operativa","like", $input["act_op"] );
        }

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function taller_x_dia_068( $input ){
        $fecha = DateTime::createFromFormat('d-m-Y', $input["fecha"])->format('Y-m-d');
        //$fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-068'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_educacion as vte")->select([
            DB::raw("(select (apellidos || ', ' ||nombres) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as director"),
            DB::raw("(select (celular) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as celdirector"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as gestor"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as celgestor"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as agp"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as celagp"),
            "activ_operativa",
            "vte.fecha",
            "ejecutora",
            "nom_dist",
            "nombre_usuario",
            DB::raw("us.celular as celacomp"),
            DB::raw("CASE WHEN state='programmed' THEN 'INCOMPLETO'
                 WHEN state='passed' THEN 'INCOMPLETO'
                 WHEN state='complete' THEN 'COMPLETO'
            end as estado")
            ])
            ->join("usuario as us", "vte.id_usuario","=","us.idusuario")
            ->where("vte.intervencion","like",'PP-068')
            ->where("vte.fecha","=",$fecha)
            ->orderByRaw("9 ,11, 13 asc");

        $recordsTotal = count($Taller->get());

        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $Taller = $Taller->where("vte.activ_operativa","like", $input["act_op"] );
        }

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        //dd($Taller->get()->toArray());

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function taller_x_ugel_068( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $act_op = "";
        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $act_op = "and ptud.activ_operativa like '".$input["act_op"]."'";
        }

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-068'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' $act_op and ptud.intervencion like 'PP-068' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");



        //$recordsTotal = count($Taller);

        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];
    }
    //------ 068 #end

    //--------- 106
    function activ_op_personal_106( $input ){

    }

    function activ_op_ugel_106( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $act_op = "and ptud.activ_operativa like '".$input["act_op"]."'";
        }

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-106'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and ptud.intervencion like 'PP-106' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                $act_op
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");
        //$recordsTotal = count($Taller);

        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];
    }

    function det_avan_persona_106( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-106'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $Taller = DB::table("vw_poi_taller_usuario_detail AS vv")->select([
                "vv.id_usuario",
                "vv.nombre_usuario",
                "vv.activo",
                "vv.ejecutora",
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where  vd.ejecutora=vv.ejecutora and vd.state='passed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-106'
                group by vd.id_usuario),0)as passed"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-106'
                group by vd.id_usuario),0)  as complete"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='programmed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-106'
                group by vd.id_usuario),0)  as programmed"),
                DB::raw("COALESCE((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora
                and (vd.state='passed' or vd.state='complete' or vd.state='programmed')
                and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf'
                and intervencion like 'PP-106'
                group by vd.id_usuario),0)  as total"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='passed' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and intervencion like 'PP-106'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and intervencion like 'PP-106'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_passed"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and intervencion like 'PP-106'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and intervencion like 'PP-106'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_complete")
                ])
                ->where("vv.intervencion","ilike",'PP-106')
                ->where("vv.fecha",">=","'$fechai'")
                ->where("vv.fecha","<=","'$fechaf'")
                ->groupBy("vv.id_usuario", "vv.nombre_usuario","vv.ejecutora","vv.activo")
                ->orderBy("porcen_complete", "desc");

        $recordsTotal = count($Taller->get());

        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $Taller = $Taller->where("activ_operativa","like", $input["act_op"] );
        }

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function taller_x_dia_106( $input ){
        $fecha = DateTime::createFromFormat('d-m-Y', $input["fecha"])->format('Y-m-d');
        //$fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');



        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-106'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_educacion as vte")->select([
            DB::raw("(select (apellidos || ', ' ||nombres) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as director"),
            DB::raw("(select (celular) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as celdirector"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as gestor"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as celgestor"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as agp"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as celagp"),
            "activ_operativa",
            "vte.fecha",
            "ejecutora",
            "nom_dist",
            "nombre_usuario",
            DB::raw("us.celular as celacomp"),
            DB::raw("CASE WHEN state='programmed' THEN 'INCOMPLETO'
                 WHEN state='passed' THEN 'INCOMPLETO'
                 WHEN state='complete' THEN 'COMPLETO'
            end as estado")
            ])
            ->join("usuario as us", "vte.id_usuario","=","us.idusuario")
            ->where("vte.intervencion","like",'PP-106')->where("vte.fecha","=",$fecha)
            ->orderByRaw("9 ,11, 13 asc");

        $recordsTotal = count($Taller->get());

        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $Taller = $Taller->where("activ_operativa","like", $input["act_op"] );
        }

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        //dd($Taller->get()->toArray());

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function taller_x_ugel_106( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $act_op = "";
        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $act_op = "and ptud.activ_operativa like '".$input['act_op']."'";
        }

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-106'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and ptud.intervencion like 'PP-106' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                $act_op
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");



        //$recordsTotal = count($Taller);

        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];
    }
    //------ 106 #end

    //--------- 051
    function activ_op_personal_051( $input ){

    }

    function activ_op_ugel_051( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $act_op = "";
        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $act_op = "and ptud.activ_operativa like '".$input['act_op']."'";
        }

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-051'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and ptud.intervencion like 'PP-051' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                $act_op
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");



        //$recordsTotal = count($Taller);

        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];
    }

    function det_avan_persona_051( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-051'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );


        $Taller = DB::table("vw_poi_taller_usuario_detail AS vv")->select([
                "vv.id_usuario",
                "vv.nombre_usuario",
                "vv.activo",
                "vv.ejecutora",
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where  vd.ejecutora=vv.ejecutora and vd.state='passed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-051'
                group by vd.id_usuario),0)as passed"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-051'
                group by vd.id_usuario),0)  as complete"),
                DB::raw("COALESCE((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='programmed'
                and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf')
                and intervencion like 'PP-051'
                group by vd.id_usuario),0)  as programmed"),
                DB::raw("COALESCE((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora
                and (vd.state='passed' or vd.state='complete' or vd.state='programmed')
                and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf'
                and intervencion like 'PP-051'
                group by vd.id_usuario),0)  as total"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='passed' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and intervencion like 'PP-051'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and intervencion like 'PP-051'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_passed"),
                DB::raw("COALESCE((((select count(vd.id_usuario) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and vd.state='complete' and vd.id_usuario=vv.id_usuario
                and (vd.fecha>='$fechai' and vd.fecha<='$fechaf') and intervencion like 'PP-051'
                group by vd.id_usuario)::double precision / ((select count(vd.id) from vw_poi_taller_usuario_detail vd
                where vd.ejecutora=vv.ejecutora and (vd.state='passed' or vd.state='complete' or vd.state='programmed') and vd.id_usuario=vv.id_usuario
                and vd.fecha>='$fechai' and vd.fecha<='$fechaf' and intervencion like 'PP-051'
                group by vd.id_usuario))*100)::numeric(3,0)),0) as porcen_complete")
                ])
                ->where("vv.intervencion","ilike",'PP-051')->where("vv.fecha",">=","'$fechai'")->where("vv.fecha","<=","'$fechaf'")

                ->groupBy("vv.id_usuario", "vv.nombre_usuario","vv.ejecutora","vv.activo")
                ->orderBy("porcen_complete", "desc");

        $recordsTotal = count($Taller->get());

        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $Taller = $Taller->where("activ_operativa","like", $input["act_op"] );
        }

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function taller_x_dia_051( $input ){
        $fecha = DateTime::createFromFormat('d-m-Y', $input["fecha"])->format('Y-m-d');
        //$fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-051'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $Taller = DB::table("vw_poi_taller_usuario_educacion as vte")->select([
            DB::raw("(select (apellidos || ', ' ||nombres) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as director"),
            DB::raw("(select (celular) from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='DIR') as celdirector"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as gestor"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='GESTOR') as celgestor"),
            DB::raw("(select (apellidos || ', ' ||nombres)as director from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as agp"),
            DB::raw("(select celular from usuario u
            inner join usuario_dependencia ud on u.idusuario=ud.idusuario
            inner join dependencia d on ud.iddependencia=d.iddependencia
            where  d.sigla=vte.ejecutora and ud.idusuario<>15 and u.intervencion='AGP') as celagp"),
            "activ_operativa",
            "vte.fecha",
            "ejecutora",
            "nom_dist",
            "nombre_usuario",
            DB::raw("us.celular as celacomp"),
            DB::raw("CASE WHEN state='programmed' THEN 'INCOMPLETO'
                 WHEN state='passed' THEN 'INCOMPLETO'
                 WHEN state='complete' THEN 'COMPLETO'
            end as estado")
            ])
            ->join("usuario as us", "vte.id_usuario","=","us.idusuario")
            ->where("vte.intervencion","like",'PP-051')->where("vte.fecha","=",$fecha)
            ->orderByRaw("9 ,11, 13 asc");

        $recordsTotal = count($Taller->get());

        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $Taller = $Taller->where("activ_operativa","like", $input["act_op"] );
        }

        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $Taller = $Taller->where("ejecutora","ilike",$ugel);
        }

        if ( $isAdmin ){
            if ( isset($input['ugel']) && !empty($input['ugel']) && $input['ugel'] != 0 ){
                $Taller = $Taller->where("ejecutora","ilike",$this->uarr[$input['ugel']]);
            }
        }

        $Taller = $Taller->get();
        $recordsFiltered = count($Taller);

        //dd($Taller->get()->toArray());

        return [
            'data' => $Taller,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ];
    }

    function taller_x_ugel_051( $input ){
        $fechai = DateTime::createFromFormat('d-m-Y', $input["inicio"])->format('Y-m-d');
        $fechaf = DateTime::createFromFormat('d-m-Y', $input["fin"])->format('Y-m-d');

        $isAdmin = (Auth::user()->hasRole('adminpoi') or Auth::user()->hasRole('admin') or Auth::user()->hasRole('edu_coordinador_regional_poi') or Auth::user()->hasRole('pp-051'));

        $isGesDirRCI = ( Auth::user()->hasRole('edu_gestor_poi') or Auth::user()->hasRole('edu_rci_poi') );

        $isEspecialista = ( Auth::user()->hasRole('edu_especialista_poi') );

        $act_op = "";
        if( $input["act_op"] != '0' and !empty($input["act_op"]) ){
            $act_op = "and ptud.activ_operativa like '".$input['act_op']."'";
        }

        $ugel = "";
        if ( !$isAdmin ){
            $ugel = Auth::user()->unidad()->pluck('sigla')->first();
            $ugel = "and ejecutora like '$ugel'";
        }

        $Taller = DB::select("
                        select
                        nom_ejecutora,
                        passed,
                        complete,
                        programmed,
                        total,
                        ((passed/total)*100)::numeric(4,1) as p_passed,
                        ((programmed/total)*100)::numeric(4,1) as  p_programmed,
                        ((complete/total)*100)::numeric(4,1) as  p_complete
                    from (
                        select nom_ejecutora, sum(passed) as passed ,
                               sum(complete) as complete,
                               sum(programmed) as programmed,
                               sum(total) as total from
                               (select
                                   (CASE WHEN ejecutora like 'UGEL 08' THEN 'UGEL 08 - CAÑETE'
                                     WHEN ejecutora like 'UGEL 09' THEN 'UGEL 09 - HUAURA'
                                     WHEN ejecutora like 'UGEL 10' THEN 'UGEL 10 - HUARAL'
                                     WHEN ejecutora like 'UGEL 11' THEN 'UGEL 11 - CAJATAMBO'
                                     WHEN ejecutora like 'UGEL 12' THEN 'UGEL 12 - CANTA'
                                     WHEN ejecutora like 'UGEL 13' THEN 'UGEL 13 - YAUYOS'
                                     WHEN ejecutora like 'UGEL 14' THEN 'UGEL 14 - OYON'
                                     WHEN ejecutora like 'UGEL 15' THEN 'UGEL 15 - HUAUROCHIRI'
                                     WHEN ejecutora like 'UGEL 16' THEN 'UGEL 16 - BARRANCA'
                                            ELSE 'other'
                                       end) as nom_ejecutora,
                                   coalesce((case when ptud.state='passed' then count(distinct(id)) end),0) as passed,
                                   coalesce((case when ptud.state='complete' then count(distinct(id)) end),0) as complete,
                                   coalesce((case when ptud.state='programmed' then count(distinct(id)) end),0) as programmed,
                                   count(distinct(id)) as total
                                from vw_poi_taller_usuario_detail ptud
                                inner join usuario u on ptud.id_usuario=u.idusuario
                                where u.estado='1' and ptud.intervencion like 'PP-051' and (ptud.fecha>='$fechai' and ptud.fecha<='$fechaf')
                                $ugel
                                $act_op
                                group by nom_ejecutora,ptud.state)
                                as temp_ugel
                         group by nom_ejecutora
                         order by 1 desc) as temp_resumen
                    group by nom_ejecutora,passed,complete,programmed, total
                    order by p_complete desc;
            ");



        //$recordsTotal = count($Taller);

        //$recordsFiltered = count($Taller);

        return [
            'data' => $Taller,
            'recordsTotal' => 1,
            'recordsFiltered' => 1
        ];
    }
    //------ 051 #end


}
