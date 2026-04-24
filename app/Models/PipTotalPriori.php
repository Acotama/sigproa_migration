<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;
// use Sofa\Eloquence\Eloquence;
// use Sofa\Eloquence\Mutable;
// use Sofa\Eloquence\Mappable;
use DateTime;
use DB;
use sayhuite\Models\PipTotalPrioriImage;

class PipTotalPriori extends Model {

    // use \OwenIt\Auditing\Auditable;
    // use Eloquence;
    // use Mappable, Mutable;

    protected $searchableColumns = [
        'nom_proyec' => 20
    ];

    public static $auditCustomMessage = '{user.apellidos}, {user.nombre} {auditable_reg.nom_proyec} {elapsed_time}';

    /*public static $auditCustomFields = [
        'title'  => 'The title was defined as "{new.title||getNewTitle}"',
        'ip_address' => 'Registered from the address {ip_address}',
        'publish_date' => [
            'created' => 'Publication date: {new.publish_date}',
            'deleted' => 'Post removed from {new.publish_date}'
        ]
    ];*/

    protected $table = 'grli_pip_total_priori';
    protected $primaryKey = 'id';

    protected $fillable = [
        'etapa',
        'sub_etapa',
        'situa_pro',
        'f_etapsub',
        'f_adjudica',
        'm_ejec',
        'nro_contrato',
        'f_i_obra',
        'f_f_obra',
        't_ejec_dia',
        'cant_meta',
        'meta_actual',
        'a_fisico',
        'f_afisico',
        'a_financ',
        'tdr_pdf',
        'f_tdr',
        'a_tdr',
        'perfil_pdf',
        'f_perfil',
        'a_perfil',
        'exptec_pdf',
        'f_exptec',
        'a_exptec',
        'ejec_pdf',
        'f_ejec',
        'a_ejec',
        'liquid_pdf',
        'f_liquid',
        'a_liquid',
        'transf_pdf',
        'f_transf',
        'a_transf',
        'cierre_pdf',
        'f_cierre',
        'a_cierre',
        'b_progres',
        'latitud',
        'longitud',
        'anio_ini_pry',
        'anio_pic',
        'mpp_pic',
        'macr_pic',
        'nacuerdo_pic',
        'mpia_pic',
        'estado_pic',
        'ffoto_antes',
        'ffoto_durante',
        'ffoto_despues',
        'tipo_pry',
        'idusuario',
        'ult_anio_ejec_pry',
        'fech_reinico_obra',
        'nuev_fech_termino',
        'estado_antiguedad_pry',
        'tipo_ejec',
        'ger_direc',
        'nom_cp',
        'prioridad',
        'inaugurado',
        'f_inaugurado',
        'ult_anio_ejec_pry_financ',
        'obs',
        'cod_prov',
        'nom_prov',
        'cod_dist',
        'nom_dist'
    ];

    protected $guarded = [
        'id',
        'nom_proyec',
        'est_pry',
        'cod_snip',
        'cod_unif',
        'cod_dpto',
        'nom_dpto',
        'cod_prov',
        'nom_prov',
        'cod_dist',
        'nom_dist',
        'u_formul',
        'u_ejec',
        'sector',
        'progr',
        'sub_progr',
        'm_pip',
        'm_viab',
        'm_exptec',
        'm_pim',
        'm_pim_acu',
        'm_deveng',
        'm_deveng_a',
        'f_deveng_a',
        'ubigeo',
        'fuente'
    ];

    public $timestamps = false;
    public static $rules = [
        /*'cod_unif' => 'integer',
        'cod_snip' => 'nullable|integer',
        'nom_proyec' => 'string',
        'cod_dpto' => 'required|integer',
        'cod_prov' => 'required|integer',
        'cod_dist' => 'required|integer',
        'nom_cp' => 'nullable|string',
        'u_formul' => 'nullable|string',
        'u_ejec' => 'nullable|string',
        'ger_direc' => 'required|string',
        'sector' => 'string',
        'progr' => 'nullable|string',
        'sub_progr' => 'nullable|string',
        'm_pip' => '',
        'm_viab' => 'nullable',
        'm_exptec' => 'nullable',*/
        'etapa' => 'string',
        'sub_etapa' => 'string',
        'est_pry' => 'nullable|string',
        'situa_pro' => 'nullable|string',
        'f_etapsub' => 'nullable|date',
        /*'m_pim' => 'nullable',
        'm_pim_acu' => 'nullable',
        'm_deveng' => 'nullable',
        'f_deveng_a' => 'nullable|date',
        'f_adjudica' => '',
        'm_ejec' => 'nullable|string',*/
        'nro_contrato' => 'nullable|string',
        'f_i_obra' => 'nullable|date',
        'f_f_obra' => 'nullable',
        't_ejec_dia' => 'nullable|integer',
        'cant_meta' => 'nullable',
        'meta_actual' => 'nullable',
        'a_fisico' => 'nullable|numeric',
        'f_afisico' => 'nullable|date',
        'a_financ' => 'nullable',
        'tdr_pdf' => 'nullable|string',
        'f_tdr' => 'nullable|date',
        'a_tdr' => 'nullable|numeric',
        'perfil_pdf' => 'nullable|string',
        'f_perfil' => 'nullable|date',
        'a_perfil' => 'nullable|numeric',
        'exptec_pdf' => 'nullable|string',
        'f_exptec' => 'nullable|date',
        'a_exptec' => 'nullable|numeric',
        'ejec_pdf' => 'nullable|string',
        //'f_ejec' => 'nullable|date',
        //'a_ejec' => 'required|numeric',
        'liquid_pdf' => 'nullable|string',
        'f_liquid' => 'nullable|date',
        'a_liquid' => 'nullable|numeric',
        'transf_pdf' => 'nullable|string',
        'f_transf' => 'nullable|date',
        'a_transf' => 'nullable|numeric',
        'b_progres' => 'nullable|numeric',
        'latitud' => 'nullable|numeric',
        'longitud' => 'nullable|numeric',
        'ubigeo' => 'nullable',
        'anio_pic' => 'nullable|string',
        'mpp_pic' => 'nullable',
        'macr_pic' => 'nullable',
        'nacuerdo_pic' => 'nullable|string',
        'mpia_pic' => 'nullable',
        'estado_pic' => 'nullable|string',
        'ffoto_antes' => 'nullable|date',
        'ffoto_durante' => 'nullable|date',
        'ffoto_despues' => 'nullable|date',
        'tipo_pry' => 'nullable|string',
        'fuente' => 'nullable|string',
        'anio_ini_pry' => 'required|integer',
        'idusuario' => 'required|integer',
        'ult_anio_ejec_pry' => 'nullable',
        'fech_reinico_obra' => 'nullable',
        'nuev_fech_termino' => 'nullable',
        'estado_antiguedad_pry' => 'nullable',
        'tipo_ejec' => 'nullable',
        '
        f_inaugurado' => 'nullable|date'
    ];

    /*public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }*/

    public static function infFotograficaEstado($x){

        $lastUpdated = PipTotalPrioriImage::select('fecha')->where('idproyecto', $x->id)->where('estado','1')->orderBy('fecha','desc')->first();
        if ( !$lastUpdated ){
            $fimage = new Datetime();
        } else {

            $fimage = new DateTime( date( 'Y-m-d' , strtotime($lastUpdated->fecha) ) );
        }

        //@return green || yellow || red
        $etapa = !empty($x->etapa) ? $x->etapa : "x";
        $subetapa = !empty($x->sub_etapa) ? $x->sub_etapa : "x";
        $est_antig = !empty($x->estado_antiguedad_pry) ? $x->estado_antiguedad_pry : " x ";
        $situacion = trim(preg_replace('/\s+/', ' ', mb_strtolower(!empty($x->situa_pro) ? $x->situa_pro : "x")));
        $ffotoAntes =  !empty($x->ffoto_antes) ? $x->ffoto_antes : "x";
        $ffotoDurante =  !empty($x->ffoto_durante) ? $x->ffoto_durante : "x";
        $ffotoDespues =  !empty($x->ffoto_despues) ? $x->ffoto_despues : "x";
        $limite_act = date('Y-m-d', strtotime('-40 days'));

        $pExceptions = [174];

        $exceptions = ['PARALIZADO', 'EXPEDIENTE TÉCNICO', 'PERFIL', 'TDR','CIERRE','ARBITRAJE'];

        $rval = 'success';

        $days = 0;

        $today  = new DateTime(date('Y-m-d'));

        $days = $fimage->diff($today)->format("%a");

        if( in_array($etapa,$exceptions) or
            in_array($subetapa,$exceptions) or
            in_array($x->id,$pExceptions) or
            $x->estado_pic == 'NO' or
            strpos($situacion,'paralizado') !== false or
            mb_strpos($est_antig,'SIN MOVIMIENTO') !==false or
            strpos($situacion,'espera de la adjudicacion') !== false /*or
            mb_strpos($situacion,'liquidada') !==false*/ ){
            $rval = 'default';
            return [ $rval, $days ];
        }else {
            if( ($ffotoAntes == 'x') and ($ffotoDurante == 'x') and ($ffotoDespues == 'x') and ($x->a_fisico >= 5.00) ){
                $rval = 'danger';           
                return [ $rval, $days ];
            }else{
                switch($etapa) {
                    case 'CULMINADO':

                        if ($ffotoDespues == 'x' or $ffotoDurante == 'x') {
                            $rval = 'danger';
                        } /*else{
                            if( $x->a_fisico != 0.00 ){
                                $rval = 'success';
                            }
                        }*/
                        break;

                    case 'EN LIQUIDACIÓN':

                        if ($ffotoDespues == 'x' or $ffotoDurante == 'x') {
                            $rval = 'danger';
                        } else{
                            /*if($ffotoDurante == 'x' ){
                                $rval = 'rgba(0, 128, 0, 0.51)';
                            }*/
                        }
                        break;

                    case 'EN TRANSFERENCIA':

                        //dd($etapa);

                        if ($ffotoDespues == 'x' or $ffotoDurante == 'x') {
                            $rval = 'danger';
                        } else{
                            /*if($ffotoDurante == 'x' ){
                                $rval = 'rgba(0, 128, 0, 0.51)';
                            }*/
                        }
                        break;
                    case 'EN EJECUCIÓN':

                        if ($ffotoDurante == 'x' and $x->a_fisico <= 5.00) {
                            $rval = 'default';
                        }

                        if ($ffotoDurante == 'x' and $x->a_fisico >= 5.00) {
                            $rval = 'danger';
                        } else{

                            if($ffotoDurante != 'x' and $x->a_fisico == 100.00){
                                return [ $rval, $days ];
                            }

                            if($ffotoDurante != 'x'){
                                $f_date = DateTime::createFromFormat('d-m-y', $ffotoDurante)->format('Y-m-d');

                                if($f_date < $limite_act){

                                    $rval = 'danger';
                                }
                            }

                        }
                        break;
                    default:
                        $rval = 'danger';
                        break;
                }
            }
        }
        return [ $rval, $days ];
    }

    public static function etapaEstado($x){

        //@return green || yellow || red

        mb_internal_encoding('UTF-8');

        $etapa = !empty($x->etapa) ? $x->etapa : " x ";
        $subetapa = !empty($x->sub_etapa) ? $x->sub_etapa : " x ";
        $situacion = trim(preg_replace('/\s+/', ' ', mb_strtolower(!empty($x->situa_pro) ? $x->situa_pro : " x ")));
        $est_antig = !empty($x->estado_antiguedad_pry) ? $x->estado_antiguedad_pry : " x ";
        $f_etapa = $x->f_etapsub;
        $limite_act = date('Y-m-d', strtotime('-30 days'));
        $limite_act_culminados = date('Y-m-d', strtotime('-40 days'));
        $cerca_limite_act = date('Y-m-d', strtotime('-15 days'));
        $ultima_ejec_financ = $x->ult_anio_ejec_pry;
        
        //AÃ±o Actual
        $tYear = date('Y');

        $exceptions = ['EN TRANSFERENCIA', 'EN LIQUIDACIÓN', 'CULMINADO', 'CIERRE'];

        $rval = 'success';

        $days = 0;

        $today = new DateTime(date('Y-m-d'));
        $fetapa = new DateTime($f_etapa);

        $days = $fetapa->diff($today)->format("%a");
        
        //$days = date_diff(date('Y-m-d'),$f_etapa);


        // if($x->estado_pic == 'NO'){
        //     $rval = 'default';

        //     return [ $rval, $days ];
        // }
       
        // in_array($subetapa,$exceptions) or
        if( in_array($etapa,$exceptions) or
            // mb_strpos($situacion,'arbitraje') !==false or
            // mb_strpos($situacion,'paralizado') !==false or
            // mb_strpos($situacion,'ampliacion') !==false or
            // mb_strpos($situacion,'ampliación') !==false or
            // mb_strpos($est_antig,'SIN MOVIMIENTO') !==false or
            $x->estado_antiguedad_pry == 'CERRADO' ) {
            return [ $rval, $days ];
        }
       
        //$f_etapa - $limite_act
        if($f_etapa == null or $f_etapa == '' or $f_etapa < $limite_act){
            switch($etapa){
                case 'EN EJECUCIÓN':
                    if($f_etapa < $limite_act){
                        $rval = 'danger';
                    }
                    break;
                case 'CULMINADO':
                    //if($ultima_ejec_financ == $tYear){
                        if($f_etapa < $limite_act_culminados){
                            $rval = 'danger';
                        }
                    //}
                    break;
                case 'EN TRANSFERENCIA':
                    //if($ultima_ejec_financ == $tYear){
                        if($f_etapa < $limite_act_culminados){
                            $rval = 'danger';
                        }
                    //}
                    break;
                case 'EN LIQUIDACIÓN': 
                    //if($ultima_ejec_financ == $tYear){
                        if($f_etapa < $limite_act_culminados){
                            $rval = 'danger';
                        }
                    //}
                    break;
                default:
                    $rval = 'danger';
                    break;

            }
        }

        /*else if($f_etapa < $cerca_limite_act){
            switch($etapa){
                case 'EJECUCIÓN':
                    $rval = 'rgba(0, 128, 0, 0.51)';
                    break;
                case 'CULMINADO':
                    if($ultima_ejec_financ == $tYear){
                        $rval = 'rgba(0, 128, 0, 0.51)';
                    }
                    break;
                case 'EN TRANSFERENCIA':
                    if($ultima_ejec_financ == $tYear){
                        $rval = 'rgba(0, 128, 0, 0.51)';
                    }
                    break;
                case 'EN LIQUIDACIÓN':
                    if($ultima_ejec_financ == $tYear){
                        $rval = 'rgba(0, 128, 0, 0.51)';
                    }
                    break;
                default:
                    $rval = 'rgba(0, 128, 0, 0.51)';
                    break;
            }
        }*/
        return [ $rval, $days ];

    }

    public static function paralizado($x){

        //@return green || yellow

        $etapa = !empty($x->etapa) ? $x->etapa : " x ";
        $subetapa = !empty($x->sub_etapa) ? $x->sub_etapa : " x ";
        $situacion = !empty($x->situa_pro) ? $x->situa_pro : " x ";

        $exceptions = ['PARALIZADO','ARBITRAJE'];

        $rval = 'success';

        if( in_array($etapa,$exceptions) or in_array($subetapa,$exceptions) or strpos('PARALIZADO',$situacion) == true ){
            $rval = 'rgba(0, 128, 0, 0.51)';
        }

        return $rval;
    }

    public static function updateMasterTable($estado, $idproyecto, $orden, $ultimoOrden, $tipo){


        $PipTotalPriori = PipTotalPriori::find($idproyecto);

        //El estado pertenece al proyecto o a la obra?
        switch ($tipo) {
            case 'O':
                // Si la obra es la mas reciente actualizamos la tabla principal
                // Y Si el Proyecto no esta en etapa de cierra
                if ( $orden == $ultimoOrden and $PipTotalPriori->etapa != 'CIERRE' ){

                    $PipTotalPriori->etapa     = $estado['etapa'];
                    $PipTotalPriori->sub_etapa = $estado['sub_etapa'];
                    $PipTotalPriori->situa_pro  = $estado['est_situ'];
                    $PipTotalPriori->obs       = $estado['obs'];
                    $PipTotalPriori->f_etapsub = $estado['fecha_act'];
                }

                // RECALCULAMOS AVANCE FISICO DEL PROYECTO
                $aFisicoObras  = DB::table('vw_grli_obra_list')
                ->select([
                    DB::raw('coalesce(a_fisico,0) as a_fisico' )
                ])
                ->where('idproyecto',$idproyecto)->get()->pluck('a_fisico');

                $SUMA = 0;
                $cant = 0;
                foreach ($aFisicoObras as $key => $value) {
                    $SUMA+= $value;
                    $cant+= 1;
                }

                $PipTotalPriori->a_fisico = $SUMA/$cant;
                $PipTotalPriori->save();

                break;
            case 'P':
                // Si la obra es la mas reciente actualizamos la tabla principal
                // Y Si el Proyecto no esta en etapa de cierra
                if ( $PipTotalPriori->etapa == 'EXPEDIENTE TÉCNICO' or
                     $PipTotalPriori->etapa == 'PERFIL') {
                    $PipTotalPriori->etapa     = $estado['etapa'];
                    $PipTotalPriori->sub_etapa = $estado['sub_etapa'];
                    $PipTotalPriori->est_situ  = $estado['est_situ'];
                    $PipTotalPriori->obs       = $estado['obs'];
                    $PipTotalPriori->fecha_act = $estado['fecha_act'];

                } else if ( $estado['etapa'] == 'CERRADO' ) {
                    $PipTotalPriori->etapa     = $estado['etapa'];
                    $PipTotalPriori->sub_etapa = $estado['sub_etapa'];
                    $PipTotalPriori->est_situ  = $estado['est_situ'];
                    $PipTotalPriori->obs       = $estado['obs'];
                    $PipTotalPriori->fecha_act = $estado['fecha_act'];
                }

                break;
        }


        // EXCEPTIONCES
        // Obtenemos la lista de etapas de obras
        $arrEtapa  = DB::table('vw_grli_obra_w_estado')
                    ->select('etapa')
                    ->where('idproyecto',$idproyecto)
                    ->get()
                    ->pluck('etapa');

        // Excepciones
        // TODO
    }

    public static function computeFisico($idProyecto){

        $ObrasList = DB::table('vw_grli_obra_list')
                    ->select([
                                DB::raw('coalesce(a_fisico,0) as a_fisico')
                            ])
                    ->where( 'idproyecto', '=', $idProyecto )
                    ->where( 'estado', '=', '1' )
                    ->get();
        $_SUMA = 0;
        $_CANT = 0;

        foreach ($ObrasList as $key => $value) {
            $_SUMA += $value->a_fisico;
            $_CANT += 1;
        }
        //dd($_SUMA / $_CANT);
        try {
            return $_SUMA / $_CANT;
        } catch(Exception $ex) {
            return 0.00;
        }
    }

    public static function  updateMasterTB($idProyecto) {

        $_ETAPA             = '';
        $_SUBETAPA          = '';
        $_MODALIDADCONTRATO = '';
        $_AVANCEFISICO      = 0.00;
        $_ESTADOSITUACIONAL = '';
        $_FECHA_ACT         = null;

        $Proyecto = PipTotalPriori::find($idProyecto);

        # Si el proyecto esta cerrado entonces se mantiene el estado de CERRADO
        if ( $Proyecto->estado_antiguedad_pry == "CERRADO" ) {

            $ProyectoEstado = PipTotalPrioriEstado::select([
                                    'id',
                                    'etapa',
                                    'sub_etapa',
                                    'est_situ',
                                    'fecha_act'
                                ])
                                ->where('idproyecto','=',$Proyecto->id)
                                ->orderBy('fecha_act', 'desc')
                                ->first();

            if ( count($ProyectoEstado) > 0 ){
                $_ETAPA = $ProyectoEstado->etapa;
                $_SUBETAPA = $ProyectoEstado->sub_etapa;
                $_ESTADOSITUACIONAL = $ProyectoEstado->est_situ;
                $_FECHA_ACT = $ProyectoEstado->fecha_act;

                $Proyecto->etapa = $_ETAPA;
                $Proyecto->sub_etapa = $_SUBETAPA;
                $Proyecto->situa_pro = $_ESTADOSITUACIONAL;
                $Proyecto->f_etapsub = $_FECHA_ACT;

                $Proyecto->save();

                return 0;
            }

        }

        $Obras = Obras::where('idproyecto', '=', $Proyecto->id)->where('grli_obra.estado','=','1')->get();

        # Si no tiene Obras, Buscamos en el estado del proyecto
        if ( count($Obras) == 0 ) {

            $ProyectoEstado = PipTotalPrioriEstado::select([
                                    'id',
                                    'etapa',
                                    'sub_etapa',
                                    'est_situ',
                                    'fecha_act'
                                ])
                                ->where('idproyecto','=',$Proyecto->id)
                                ->orderBy('fecha_act', 'desc')
                                ->first();

            if ( count($ProyectoEstado) > 0 ){
                $_ETAPA = $ProyectoEstado->etapa;
                $_SUBETAPA = $ProyectoEstado->sub_etapa;
                $_ESTADOSITUACIONAL = $ProyectoEstado->est_situ;
                $_FECHA_ACT = $ProyectoEstado->fecha_act;

                $Proyecto->etapa = $_ETAPA;
                $Proyecto->sub_etapa = $_SUBETAPA;
                $Proyecto->situa_pro = $_ESTADOSITUACIONAL;
                $Proyecto->f_etapsub = $_FECHA_ACT;

                $Proyecto->save();
            }
        }
        # Si tiene Obras Buscamos en el estado de la ultima obra en ejecucion
        else {
            // # Ultima Obra agregada
            // $UltimaObra = Obras::select([
            //                         'id',
            //                         'mod_ejec',
            //                         'f_inicio',
            //                         'f_termino',
            //                         't_ejec_dias'
            //                     ])
            //                 ->whereRaw("(idproyecto = " . $Proyecto->id . " and estado = '1')
            //             AND ( SELECT count(*) FROM grli_obra_estado where grli_obra_estado.idobra = grli_obra.id and grli_obra_estado.estado = '1' ) > 0")
            //                 ->orderBy('grli_obra.nro_meta','desc')
            //                 ->first();
            // if ( $UltimaObra ){
            //     # Ultimo Estado Situacional de Obra
                $UltimaObraEstado = Obras::select([
                                                    'fecha_act',
                                                    'etapa',
                                                    'sub_etapa',
                                                    'est_situ',
                                                    'a_fisico',
                                                    'obs'
                                                ])
                                    ->join('grli_obra_estado','grli_obra.id','grli_obra_estado.idobra')
                                    ->where('grli_obra.idproyecto','=',$Proyecto->id)
                                    ->where('grli_obra.estado','=','1')
                                    ->where('grli_obra_estado.estado','=','1')
                                    ->whereRaw("(SELECT count(*) FROM grli_obra_estado where grli_obra_estado.idobra = grli_obra.id and grli_obra_estado.estado = '1') > 0")
                                    ->orderBy('fecha_act','desc')
                                    ->first();

                $_ETAPA             = $UltimaObraEstado->etapa;
                $_SUBETAPA          = $UltimaObraEstado->sub_etapa;
                $_AVANCEFISICO      = $UltimaObraEstado->a_fisico;
                $_ESTADOSITUACIONAL = $UltimaObraEstado->est_situ;
                $_FECHA_ACT         = $UltimaObraEstado->fecha_act;

                $Proyecto->etapa        = $_ETAPA;
                $Proyecto->sub_etapa    = $_SUBETAPA;
                $Proyecto->situa_pro    = $_ESTADOSITUACIONAL;
                $Proyecto->f_etapsub    = $_FECHA_ACT;
                $Proyecto->a_fisico     = $_AVANCEFISICO;

                $Proyecto->save();
            // }
        }
    }

}
