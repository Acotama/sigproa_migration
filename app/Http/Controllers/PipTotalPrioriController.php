<?php

namespace sayhuite\Http\Controllers;

use Intervention\Image\Facades\Image;
use sayhuite\PipTotalPriori;
use sayhuite\Procompite;
use sayhuite\Departamento;
use sayhuite\Dependencia;
use sayhuite\Provincia;
use sayhuite\Distrito;
use sayhuite\SubEtapa;
use sayhuite\EstAntig;
use sayhuite\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use sayhuite\InfFinanciera;
use DB;
use PDF;
use File;
use sayhuite\Logic\Image\ImageRepository;
use sayhuite\Logic\Tools\Tools;
use sayhuite\Logic\Pdf\PdfRepository;
use sayhuite\audits;
use sayhuite\Obras;
use sayhuite\ObrasEstado;
use sayhuite\PipTotalPrioriEstado;
use sayhuite\PipTotalPrioriImage;
use sayhuite\ContratacionesPS;

class PipTotalPrioriController extends Controller {

    protected $controlador = 'piptotalpriori';
    protected $num = 10;

    protected $searchAlias = [
        'eq' => '=',
        'cn' => 'like',
        'nc' => '<>'
    ];

    public function index(Request $request){
      $input = $request->all();
      return View::make($this->controlador . '.index',
      [ 'accion' => isset($input['accion'])?$input['accion']:null,
        'id' => isset($input['id'])?$input['id']:null,
        'tipopry' => isset($input['tipopry'])?$input['tipopry']:null]);
    }

    public function buscacontrato(Request $request) {
        $input=$request->all();
        $contrato= DB::select("select case when contrato_moneda = 'S/.' then contrato_monto::numeric else contrato_monto::numeric*3.4 end as mon_monto,contrato_nro,contrato_fecha::date as contrato_fecha from grli_pip_total_priori_contratos
        where contrato_nro='".$input['n_contrato']."' and idproyecto=".$input['idproyecto']."limit 1");
        return Response([
          'data' => $contrato
        ]);
    }

    public function filterData(Request $request){

        $input = $request->all();
        $page = $input['page']; // get the requested page
        $limit = $input['rows']; // get how many rows we want to have into the grid
        $sidx = $input['sidx']; // get index row - i.e. user click to sort
        $sord = $input['sord']; // get the direction
        $start = $limit * $page - $limit;

        mb_internal_encoding('UTF8');

        $PipTP = PipTotalPriori::select([
            'grli_pip_total_priori.id as id',
            'grli_pip_total_priori.nom_proyec',
            'grli_pip_total_priori.cod_unif',
            'grli_pip_total_priori.cod_snip',
            'grli_pip_total_priori.m_ejec',
            'grli_pip_total_priori.m_pip',
            DB::raw('(grli_pip_total_priori.m_pim_acu - grli_pip_total_priori.m_pim) AS m_financiado'),
            //'grli_pip_total_priori.tipo_pry',
            DB::raw("case when grli_pip_total_priori.tipo_pry = 'NO PIP' then 'IOARR' else grli_pip_total_priori.tipo_pry end as tipo_pry "),
            //DB::raw('(SELECT array_to_string(array_agg(DISTINCT(provincia)), \', \') FROM grli_proyecto_ubicacion where idpi = grli_pip_total_priori.id) AS prov'),
            DB::raw("case when grli_pip_total_priori.nom_prov  is not null  then   grli_pip_total_priori.nom_prov else 'SIN PROVINCIA' end as prov"),
            //DB::raw('(array(select decretos::text from decretoxproyecto INNER JOIN decretos ON decretos.id = decretoxproyecto.iddecreto where decretoxproyecto.idproyecto = grli_pip_total_priori.id )) as decretos'),
            'grli_pip_total_priori.meta_actual',
            'grli_pip_total_priori.progr',
            'grli_pip_total_priori.a_fisico',
            'grli_pip_total_priori.f_afisico',
            'grli_pip_total_priori.a_financ',
            'grli_pip_total_priori.a_financ_a',
            'grli_pip_total_priori.m_pim',
            'grli_pip_total_priori.m_pim_acu',
            'grli_pip_total_priori.m_deveng',
            'grli_pip_total_priori.m_deveng_a',
            'grli_pip_total_priori.f_deveng_a',
            DB::raw('(select SUM(pia::numeric(11,2)) from inf_financiera where inf_financiera.cod_unif::text = grli_pip_total_priori.cod_unif and inf_financiera.anio_financ = grli_pip_total_priori.ult_anio_ejec_pry_financ) as pia'),
            DB::raw('(select SUM(girado::numeric(11,2)) from grli_pip_total_girado where cod_unif = grli_pip_total_priori.cod_unif and anio = grli_pip_total_priori.ult_anio_ejec_pry_financ) as girado'),
            'grli_pip_total_priori.etapa',
            'grli_pip_total_priori.sub_etapa',
            'grli_pip_total_priori.situa_pro',
            'grli_pip_total_priori.f_etapsub',
            'grli_pip_total_priori.ult_anio_ejec_pry_financ',
            'grli_pip_total_priori.anio_pic',
            'grli_pip_total_priori.u_formul',
            DB::raw("case  when grli_pip_total_priori.ger_direc  is not null  then   grli_pip_total_priori.ger_direc else 'SIN U.E.' end as ger_direc"),
            DB::raw("case  when grli_pip_total_priori.estado_pic  is not null  then   grli_pip_total_priori.estado_pic else 'NO' end as estado_pic"),
            'grli_pip_total_priori.prioridad',
            'grli_pip_total_priori.estado_antiguedad_pry',
            'grli_pip_total_priori.completo',
            'ffoto_antes',
            'ffoto_durante',
            'ffoto_despues'
        ]);

            $PipTP = $PipTP->orderBy($sidx,$sord )->groupBy(
            'grli_pip_total_priori.nom_proyec',
            'grli_pip_total_priori.id',
            'grli_pip_total_priori.cod_unif',
            'grli_pip_total_priori.cod_snip',
            'grli_pip_total_priori.m_pip',
            'grli_pip_total_priori.nom_prov',
            'grli_pip_total_priori.m_ejec',
            'grli_pip_total_priori.tipo_pry',
            'grli_pip_total_priori.a_fisico',
            'grli_pip_total_priori.f_afisico',
            'grli_pip_total_priori.a_financ',
            'grli_pip_total_priori.a_financ_a',
            'grli_pip_total_priori.m_pim',
            'grli_pip_total_priori.m_pim_acu',
            'grli_pip_total_priori.m_deveng',
            'grli_pip_total_priori.m_deveng_a',
            'grli_pip_total_priori.f_deveng_a',
            'grli_pip_total_priori.etapa',
            'grli_pip_total_priori.sub_etapa',
            'grli_pip_total_priori.situa_pro',
            'grli_pip_total_priori.f_etapsub',
            'grli_pip_total_priori.ult_anio_ejec_pry_financ',
            'grli_pip_total_priori.anio_pic',
            'grli_pip_total_priori.u_formul',
            'grli_pip_total_priori.ger_direc',
            'grli_pip_total_priori.estado_pic',
            'grli_pip_total_priori.prioridad',
            'grli_pip_total_priori.estado_antiguedad_pry',
            'grli_pip_total_priori.meta_actual',
            'grli_pip_total_priori.progr',
            'grli_pip_total_priori.completo',
            'ffoto_antes',
            'ffoto_durante',
            'ffoto_despues'
            );

        /*if($input['_credito'] == 'true'){
            $CreditoSuplementario = DB::table('decretoxproyecto')->select('idproyecto')->join('decretos', 'decretos.id', '=','decretoxproyecto.iddecreto');
            if($input['_continuidad'] == 'true'){
                $CreditoSuplementario = $CreditoSuplementario->where('tipo', 'like', '%CONTINUIDAD%');
            }

            if($input['_financiamiento'] == 'true'){
                $CreditoSuplementario = $CreditoSuplementario->orWhere('tipo', 'like','%FINANCIAMIENTO%');
            }

            $CreditoSuplementario = $CreditoSuplementario->pluck('idproyecto')->toArray();

            $PipTP = $PipTP->whereIn('id',$CreditoSuplementario);
        }

         if($input['_multianual'] == 'true'){
            $PiMultianuales = DB::table('grli_pip_total_priori_pmultianual_year')->select('idproyecto')->pluck('idproyecto')->toArray();

            $PipTP = $PipTP->whereIn('id',$PiMultianuales);
         }*/

        if(isset($input['filters']) and !empty($input['filters'])){
            $input['filters'] = json_decode($input['filters'],true);
            switch($input['filters']['groupOp']){
                case 'AND':
                    foreach($input['filters']['rules'] as $rule){
                        $field = $rule['field'];
                        $operation = $rule['op'];
                        $param = mb_strtoupper($rule['data']);

                        switch($operation){
                            case 'eq':
                                $PipTP = $PipTP->where($field,'=',$param);
                                break;
                            case 'cn':
                                if($field === 'prov'){
                                    $PipTP = $PipTP->whereRaw('(SELECT array_to_string(array_agg(DISTINCT(provincia)), \', \') FROM grli_proyecto_ubicacion where idpi = grli_pip_total_priori.id) SIMILAR TO \'%'. $param .'%\'');
                                }else{
                                    $PipTP = $PipTP->where($field,'like','%'. $param .'%');
                                }
                                break;
                            case 'nc':
                                $PipTP = $PipTP->where($field,'not like','%'. $param .'%');
                                break;
                        }

                    }

                    break;
                case 'OR':
                    $ss  = mb_strtoupper($input['filters']['rules'][0]['data']);
                    $PipTP->whereRaw("(grli_pip_total_priori.nom_proyec ||' '|| grli_pip_total_priori.cod_unif ||' '|| grli_pip_total_priori.cod_snip ||' '|| grli_pip_total_priori.m_pip ||' '|| grli_pip_total_priori.tipo_pry ||' '|| grli_pip_total_priori.a_fisico ||' '|| grli_pip_total_priori.a_financ ||' '|| grli_pip_total_priori.etapa ||' '|| grli_pip_total_priori.nom_prov) ilike ?",$ss);

                    /*$PipTP->search($ss, [
                        'nom_proyec' => 20
                    ]);*/
                    break;
            }
        }



        $count  = $PipTP->get()->count();
        $legend = $this->countEtapa($PipTP->get());
        $totalpages = ceil($count / $limit);
        $suma  = $this->suma($PipTP->get()->toArray());
        $PipTP  = $PipTP->skip($start)->take($limit)->get();
        $PipTP  = $this->defineState($PipTP);
        $PipTP  = $this->canEdit($PipTP);

        return Response([
            'rows' => $PipTP->toArray(),
            'page' => $page,
            'total' => $totalpages,
            'records' => $count,
            'legend' => $legend,
            'suma' => $suma
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

        $SinGer = PipTotalPriori::where('ger_direc','')
                    ->whereNotIn('cod_unif',['2001707','2000270','2001621'])
                    //->whereRaw('id <= 455 or id > 615')->count(); # MULTIANUAL @WORKAROUND
                    ->where('ult_anio_ejec_pry_financ','2017')->count();

        $resultSet['singerencia'] = $SinGer;

        return $resultSet;
    }

    public function suma($data){

        $arrR = [
            's_pia' => 0.00,
            's_m_pip' => 0.00,
            's_m_pim' => 0.00,
            's_m_pim_acu' => 0.00,
            's_m_deveng' => 0.00,
            's_girado' => 0.00,
            's_m_deveng_a' => 0.00
        ];

        foreach ($data as $key => $value) {
            $arrR['s_pia'] += $value['pia'];
            $arrR['s_m_pip'] += $value['m_pip'];
            $arrR['s_m_pim'] += $value['m_pim'];
            $arrR['s_m_pim_acu'] += $value['m_pim_acu'];
            $arrR['s_m_deveng'] += $value['m_deveng'];
            $arrR['s_girado'] += floatval($value['girado']);
            $arrR['s_m_deveng_a'] += $value['m_deveng_a'];
        }

        return $arrR;
    }

    public function defineState($data){
                
        $ndata = $data->map(function ($item, $key) {
            $item['imgState'] = PipTotalPriori::infFotograficaEstado($item);
            $item['etapaState'] = PipTotalPriori::etapaEstado($item);
            $item['paralizado'] = PipTotalPriori::paralizado($item);

            return $item;
        });
        return $ndata;
    }

    public function canEdit($data){

      $isAdmin = Auth::user()->hasRole('admin');

      //UNIDADES A LAS QUE PERTENECE
      if ($isAdmin) {
          $userDependencies = Dependencia::all()->pluck('denom')->toArray();
          array_push($userDependencies,'');
      } else {
          $userDependencies = Auth::user()->unidad()->pluck('denom')->toArray();
      }

      $ndata = $data->map(function ($item, $key) use ($userDependencies) {

        if(in_array($item['ger_direc'],$userDependencies)){
          $item['canEdit'] = true;
        }else{
          $item['canEdit'] = false;
        }
          return $item;
      });
      return $ndata;
    }

    //combo
    public function combodistrito($id) {
        $data = Distrito::select('cod_dist', 'nom_dist')
                        ->where('cod_prov', '=', $id)->get();

        $combo = '<option value=""> -- Seleccionar -- </option>';
        foreach ($data as $value) {
            $combo = $combo . ' <option value="' . $value['cod_dist'] . '">' . $value['nom_dist'] . '</option>';
        }
        return $combo;
    }

    public function combosubetapa($id) {
        $data = SubEtapa::select('sub_etapa')
                        ->where('etapa', '=', $id)->orderBy('orden','asc')->get();

        $combo = '<option value=""> -- Seleccionar -- </option>';
        foreach ($data as $value) {
          if ($value['sub_etapa']=='PARALIZADO') {
            $combo = $combo . ' <option value="' . $value['sub_etapa'] . '">' . $value['sub_etapa'] . '/SUSPENDIDO</option>';
          }
          else {
            $combo = $combo . ' <option value="' . $value['sub_etapa'] . '">' . $value['sub_etapa'] . '</option>';
          }
        }
        //dd($combo);
        return $combo;
    }


    //Ventana mostar
    public function show(Request $request) {
        $input = $request->all();
        $id = $input['id'];
        $tipopry = $input['tipopry'];
        
        if($input['tipopry'] != 'PROCOMPITE'){
            $PipTP = PipTotalPriori::find($id);
        }else{            
            $PipTP = Procompite::find($id);
        }     

        $Transferencia = DB::select("select nombre,fecha,definicion,monto from decretoxproyecto INNER JOIN decretos ON decretoxproyecto.iddecreto = decretos.id where decretoxproyecto.idproyecto = " . $PipTP->id );

        $infFinanciera = InfFinanciera::where('cod_unif',$PipTP->cod_unif)->orderBy('anio_financ','desc')->get();

        $Contrataciones = DB::select("select *, to_date(REGEXP_REPLACE(contrato_fecha, '\s+$', '') , 'DD/MM/YYYY') as contrato_fecha from grli_pip_total_priori_contratos where idproyecto = ". $PipTP->id . " order by 1 desc;");

        $obras = DB::table('vw_grli_obra_list')->where( 'idproyecto','=',$PipTP->id )->get();

        $year= date("Y");
        $dato=[];
        $avance=[];
        $fuente_financiamiento=[];
        for ($i=0; $i <= 3; $i++) {
          array_push($dato,"monto_".($year + $i));
        }
        //SI EL AÑO ES 2027 CAMBIER EN  BD
        if ($year==2028) {
          return "POR FAVOR AGREGAR COLUMNAS AÑO " .$year+3;
        }
        $cartera= DB::select("select monto_anio_0 as monto_1,monto_anio_1 as monto_2,monto_anio_2 as monto_3,monto_anio_3 as monto_4 from cartera_pmi where fecha_act=(select max(fecha_act) from cartera_pmi) and anio=(select EXTRACT(YEAR FROM now())) and codigo_unico=".$PipTP['cod_unif']);

        $a_ejecutado=DB::Select("select 'EJECUTADO' as fase,cod_unif::numeric,sum(dev_ene::numeric(10,2)) enero ,sum(dev_feb::numeric(10,2)) febrero ,sum(dev_mar::numeric(10,2)) marzo,
              sum(dev_abr::numeric(10,2)) Abril ,sum(dev_may::numeric(10,2)) Mayo ,sum(dev_jun::numeric(10,2)) Junio,
              sum(dev_jul::numeric(10,2)) Julio ,sum(dev_ago::numeric(10,2)) Agosto ,sum(dev_set::numeric(10,2)) Septiembre,
              sum(dev_oct::numeric(10,2)) Octubre ,sum(dev_nov::numeric(10,2)) Noviembre ,sum(dev_dic::numeric(10,2)) Diciembre,
              (sum(dev_ene::numeric(10,2)) + sum(dev_feb::numeric(10,2)) + sum(dev_mar::numeric(10,2)) + sum(dev_abr::numeric(10,2)) + sum(dev_may::numeric(10,2)) + sum(dev_jun::numeric(10,2)) +
              sum(dev_jul::numeric(10,2)) + sum(dev_ago::numeric(10,2)) + sum(dev_set::numeric(10,2)) + sum(dev_oct::numeric(10,2)) + sum(dev_nov::numeric(10,2)) + sum(dev_dic::numeric(10,2))) as total
              from inf_financiera where anio_financ='".$year."' and cod_unif=".$PipTP->cod_unif." group by cod_unif");
        if (empty($a_ejecutado)) {
          $a_ejecutado=DB::Select("select 'EJECUTADO' as fase,0 cod_unif,0 enero ,0 febrero ,0 marzo,0 Abril ,0 Mayo ,0 Junio,0 Julio ,0 Agosto ,0 Septiembre, 0 Octubre ,0 Noviembre ,0 Diciembre,0 total");
        }

        $a_programado=DB::Select("select  'PROGRAMADO' as fase,cod_unif,sum(p_enero) enero, sum(p_febrero) febrero, sum(p_marzo) marzo, sum(p_abril) Abril, sum(p_mayo) Mayo, sum(p_junio) Junio, sum(p_julio) Julio, sum(p_agosto) Agosto, sum(p_setiembre) Septiembre, sum(p_octubre) Octubre, sum(p_noviembre) Noviembre, sum(p_diciembre) Diciembre,
        (case when sum(p_enero) is null then 0 else sum(p_enero) end +
        case when sum(p_febrero) is null then 0 else sum(p_febrero) end +
        case when sum(p_marzo) is null then 0 else sum(p_marzo) end +
        case when sum(p_abril) is null then 0 else sum(p_abril) end +
        case when sum(p_mayo) is null then 0 else sum(p_mayo) end +
        case when sum(p_junio) is null then 0 else sum(p_junio) end +
        case when sum(p_julio) is null then 0 else sum(p_julio) end +
        case when sum(p_agosto) is null then 0 else sum(p_agosto) end +
        case when sum(p_setiembre) is null then 0 else sum(p_setiembre) end +
        case when sum(p_octubre) is null then 0 else sum(p_octubre) end +
        case when sum(p_noviembre) is null then 0 else sum(p_noviembre) end +
        case when sum(p_diciembre) is null then 0 else sum(p_diciembre) end) as total
        from formato12b where fecha_subida=(select max(fecha_subida) from formato12b) and  year =".$year." and cod_unif=".$PipTP->cod_unif." group by cod_unif");
        if (empty($a_programado)) {
          $a_programado=DB::Select("select 'PROGRAMADO' as fase,0 cod_unif,0 enero ,0 febrero ,0 marzo,0 Abril ,0 Mayo ,0 Junio,0 Julio ,0 Agosto ,0 Septiembre, 0 Octubre ,0 Noviembre ,0 Diciembre,0 total");
        }


        $a_actualizado=DB::Select("select 'ACTUALIZADO' as fase,cod_unif,sum(a_enero) enero, sum(a_febrero) febrero, sum(a_marzo) marzo, sum(a_abril) Abril, sum(a_mayo) Mayo, sum(a_junio) Junio, sum(a_julio) Julio, sum(a_agosto) Agosto, sum(a_setiembre) Septiembre, sum(a_octubre) Octubre, sum(a_noviembre) Noviembre, sum(a_diciembre) Diciembre,
        (case when sum(a_enero) is null then 0 else sum(a_enero) end +
        case when sum(a_febrero) is null then 0 else sum(a_febrero) end +
        case when sum(a_marzo) is null then 0 else sum(a_marzo) end +
        case when sum(a_abril) is null then 0 else sum(a_abril) end +
        case when sum(a_mayo) is null then 0 else sum(a_mayo) end +
        case when sum(a_junio) is null then 0 else sum(a_junio) end +
        case when sum(a_julio) is null then 0 else sum(a_julio) end +
        case when sum(a_agosto) is null then 0 else sum(a_agosto) end +
        case when sum(a_setiembre) is null then 0 else sum(a_setiembre) end +
        case when sum(a_octubre) is null then 0 else sum(a_octubre) end +
        case when sum(a_noviembre) is null then 0 else sum(a_noviembre) end +
        case when sum(a_diciembre) is null then 0 else sum(a_diciembre) end) as total
        from formato12b where  fecha_subida=(select max(fecha_subida) from formato12b) and year =".$year." and cod_unif=".$PipTP->cod_unif." group by cod_unif");
        if (empty($a_actualizado)) {
          $a_actualizado=DB::Select("select 'ACTUALIZADO' as fase,0 cod_unif,0 enero ,0 febrero ,0 marzo,0 Abril ,0 Mayo ,0 Junio,0 Julio ,0 Agosto ,0 Septiembre, 0 Octubre ,0 Noviembre ,0 Diciembre,0 total");
        }
        if ($a_programado[0]->total == 0 && $a_actualizado[0]->total == 0 && $a_ejecutado[0]->total == 0) {
          $avance=[];
        }
        else {
          array_push($avance,$a_programado,$a_actualizado,$a_ejecutado);
        }

        $fuente_operaciones=DB::select("select fuente_financiamiento,pim_dia,certificacion_dia,dev_dia,girado_dia from grli_pip_seguimiento_ejecucion_financiera
        where fuente_financiamiento = 'RECURSOS POR OPERACIONES OFICIALES DE CREDITO' and fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera) and cod_unif='".$PipTP->cod_unif."' and anio='".$year."'");
        if (empty($fuente_operaciones)) {
          $fuente_operaciones=DB::select("select 'RECURSOS POR OPERACIONES OFICIALES DE CREDITO' fuente_financiamiento,0 pim_dia,0 certificacion_dia,0 dev_dia,0 girado_dia");
        }

        $fuente_ordinarios=DB::select("select fuente_financiamiento,pim_dia,certificacion_dia,dev_dia,girado_dia from grli_pip_seguimiento_ejecucion_financiera
        where fuente_financiamiento = 'RECURSOS ORDINARIOS' and fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera) and cod_unif='".$PipTP->cod_unif."' and anio='".$year."'");
        if (empty($fuente_ordinarios)) {
          $fuente_ordinarios=DB::select("select 'RECURSOS ORDINARIOS' fuente_financiamiento,0 pim_dia,0 certificacion_dia,0 dev_dia,0 girado_dia");
        }

        $fuente_determinados=DB::select("select fuente_financiamiento,pim_dia,certificacion_dia,dev_dia,girado_dia from grli_pip_seguimiento_ejecucion_financiera
        where fuente_financiamiento = 'RECURSOS DETERMINADOS' and fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera) and cod_unif='".$PipTP->cod_unif."' and anio='".$year."'");
        if (empty($fuente_determinados)) {
          $fuente_determinados=DB::select("select 'RECURSOS DETERMINADOS' fuente_financiamiento,0 pim_dia,0 certificacion_dia,0 dev_dia,0 girado_dia");
        }

        $fuente_donaciones=DB::select("select fuente_financiamiento,pim_dia,certificacion_dia,dev_dia,girado_dia from grli_pip_seguimiento_ejecucion_financiera
        where fuente_financiamiento = 'DONACIONES Y TRANSFERENCIAS' and fecha=(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera) and cod_unif='".$PipTP->cod_unif."' and anio='".$year."'");
        if (empty($fuente_donaciones)) {
          $fuente_donaciones=DB::select("select 'DONACIONES Y TRANSFERENCIAS' fuente_financiamiento,0 pim_dia,0 certificacion_dia,0 dev_dia,0 girado_dia");
        }

        if ($fuente_operaciones[0]->pim_dia == 0 && $fuente_ordinarios[0]->pim_dia == 0 && $fuente_determinados[0]->pim_dia == 0 && $fuente_donaciones[0]->pim_dia == 0) {
          $fuente_financiamiento=[];
        }
        else {
          array_push($fuente_financiamiento,$fuente_operaciones,$fuente_ordinarios,$fuente_determinados,$fuente_donaciones);
        }
        
        $formato_12b= DB::table('formato12b')->select()
        ->where('fecha_subida','=',DB::RAW('(select max(fecha_subida) from formato12b)'))
        ->where('year','=',$year)
        ->where('cod_unif','=',$PipTP->cod_unif)->first();


        $fecha = ContratacionesPS::max('fecha_act');
        $consulta_contrataciones = ContratacionesPS::select(DB::raw("cod_unico,tipo_proceso,nomenclatura,des_proceso,des_item,objeto_contratac,fec_convocatoria,contratacionesps.estado,valor_refer"))
        ->join("grli_pip_total_priori",DB::raw("contratacionesps.cod_unico::text"),"grli_pip_total_priori.cod_unif")
        ->where("fecha_act",$fecha)
        ->where("cod_unico",$PipTP->cod_unif)
        ->orderBy("fec_convocatoria","desc")->get();
                
        $view='piptotalpriori.show';
        if(isset($input['view'])){
            $view='actas.datosproyecto';
        }
        return view($view)->with(
            [
                'data'=>$PipTP,
                'formato12b'=> !empty($formato_12b) ? $formato_12b : null ,
                'InfFinanciera'=>$infFinanciera,
                'Transferencia'=>$Transferencia,
                'Obras'=>$obras,
                'Contrataciones'=>$Contrataciones,
                'Cartera'=>$cartera,
                'Avance'=>$avance,
                'Fuente_financiamiento'=>$fuente_financiamiento,
                'consulta_contrataciones' => $consulta_contrataciones,
                'message'=>'',
                'error'=>'false',
            ]
        )->render();
    }

    //ventana editar
    public function edit($id) {
        $data = PipTotalPriori::find($id);

        if ($data->cod_unif != 'SIN COD.')
        {
            $InfFinanciera = InfFinanciera::where('cod_unif','=',$data->cod_unif)->get()->toArray();
        }
        else {
            $InfFinanciera = InfFinanciera::where('cod_unif','=','123456')->get()->toArray();
        }

        $Transferencia = DB::select("select nombre,fecha,definicion,monto from decretoxproyecto INNER JOIN decretos ON decretoxproyecto.iddecreto = decretos.id where decretoxproyecto.idproyecto = " . $id );

        $Alcance = DB::select("select * from grli_proyecto_ubicacion where idpi = " . $id );

        //$PMultianual = DB::select("select * from grli_pip_total_priori_pmultianual_year my inner join grli_pip_total_priori_pmultianual m ON m.id::int = my.idpmultianual::int where my.idproyecto::int = " . $id );

        $depCombo = Departamento::all()->pluck('nom_dpto', 'cod_dpto');

        $prov = Provincia::where('cod_dpto', '=', '15')->pluck('nom_prov', 'cod_prov')->toArray();
        $provCombo = [0 => "-- Seleccionar --"] + $prov;

        $dist = Distrito::all()->pluck('nom_dist', 'cod_dist')->toArray();
        $disCombo = [0 => "-- Seleccionar --"] + $dist;

        $eta = SubEtapa::orderBy('id','asc')->pluck('etapa', 'etapa')->toArray();
        $etaCombo = [0 => "-- Seleccionar --"] + $eta;

        $Sub_Etapa = [];

        $EtaSubProyecto = DB::table("grli_pip_total_priori_estado")
                            ->select(['etapa','sub_etapa','est_situ','fecha_act','obs'])
                            ->where('idproyecto',$id)
                            ->orderBy('fecha_act','desc')
                            ->first();

        if(isset($EtaSubProyecto->etapa) ) {
            $tmpSub_Etapa  = $this->subetapa($EtaSubProyecto->etapa);

            foreach ($tmpSub_Etapa as $key => $value) {
                if ($value != $EtaSubProyecto->sub_etapa ){
                    $Sub_Etapa += [$key => [ "nombre" => $value, "state" => ""]];
                } else {
                    $Sub_Etapa += [$key => [ "nombre" => $value, "state" => "selected"]];
                }
            }
        }

        $estAntig = EstAntig::all()->pluck('estado', 'estado')->toArray();
        $estAntigCombo = [0 => "-- Seleccionar --"] + $estAntig;

        $Obras = Obras::where('idproyecto','=', $id)->where('estado','1')->get();

        $Alcance = DB::select("select * from grli_proyecto_ubicacion where idpi = " . $id );

        $ejecucionComplete = false;

        /*if ($data->id == 1000){*/
        $form = 'nedit';
        /*} else {
            $form = 'edit';
        }*/

        // dd($data);
        return View::make($this->controlador . '.' . $form, compact(
          'data',
          'depCombo',
          'provCombo',
          'disCombo',
          'etaCombo',
          'Sub_Etapa',
          'estAntigCombo',
          'InfFinanciera',
          //'Transferencia',
          'Alcance',
          'PMultianual',
          //'Estado',
          'UltimoEstado',
          'EtaSubProyecto',
          'Obras',
          'Alcance'
          )
        );
    }

    public function subetapa($id) {
        $Sub_Etapa = SubEtapa::select('sub_etapa')
                    ->where('etapa', '=', $id)->orderBy('id','asc')->pluck('sub_etapa', 'sub_etapa')->toArray();
        //dd($Sub_Etapa);
        $Sub_Etapa = [ 0 => '-- Seleccionar --'] + $Sub_Etapa;

        return $Sub_Etapa;
    }

    //actualizar datos
    public function update($id) {

        $cleanInput = Input::except('_token', 'uid', 'file', 'tipo', 'fecha', 'csrf-token');
        $validator = Validator::make($data = $cleanInput, PipTotalPriori::$rules);

        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . ". <br>";
            }
            return back()->with('mensaje_error', $mensaje_error)->withInput();
        } else {

            $PipTotalPriori = PipTotalPriori::find($id);

            if ( Input::get('etapa') != '' and Input::get('sub_etapa') != '' and Input::get('f_etapsub') != '1969-12-31' ){

                Input::merge(['f_etapsub' => date("Y-m-d",strtotime(Input::get('f_etapsub')))]);
                $PipTotalPrioriEstado = PipTotalPrioriEstado::where('fecha_act',Input::get('f_etapsub'))
                                        ->where('idproyecto', $id)
                                        ->first();

                if ($PipTotalPrioriEstado){

                    $PipTotalPrioriEstado->etapa     =  Input::get('etapa');
                    $PipTotalPrioriEstado->sub_etapa =  Input::get('sub_etapa');
                    $PipTotalPrioriEstado->est_situ  =  Input::get('situa_pro');
                    $PipTotalPrioriEstado->obs       =  Input::get('obs');
                    $PipTotalPrioriEstado->save();

                } else {
                    $PipTotalPrioriEstado = new PipTotalPrioriEstado();

                    $PipTotalPrioriEstado->idproyecto=  Input::get('id');
                    $PipTotalPrioriEstado->etapa     =  Input::get('etapa');
                    $PipTotalPrioriEstado->sub_etapa =  Input::get('sub_etapa');
                    $PipTotalPrioriEstado->est_situ  =  Input::get('situa_pro');
                    $PipTotalPrioriEstado->fecha_act =  Input::get('f_etapsub' );
                    $PipTotalPrioriEstado->obs       =  Input::get('obs');
                    $PipTotalPrioriEstado->save();
                }
            }


            $PipTotalPriori->fill(Input::except('etapa','sub_etapa','situa_pro','f_etapsub','obs'));
            $PipTotalPriori->save();

            PipTotalPriori::updateMasterTB($PipTotalPriori->id);

            return redirect($this->controlador . '/edit/' . $id)->with('mensaje_exito', 'Los datos se actualizaron correctamente');
        }
    }

    public function update_datos_TotalPriori(Request $request){
        $input=$request->all();
        $data_dist = Distrito::select('cod_dist', 'nom_dist')
                        ->where('cod_dist', '=', $input['cod_dist'])->first();
        $data_prov = Distrito::select('cod_prov','nom_prov')
                        ->where('cod_prov', '=', $input['cod_prov'])->first();

            $PipTotalPriori = PipTotalPriori::where('id',$input['d_uid'])
            ->update(
                [
                    'sector' => $input['sector'],
                    'u_ejec' => $input['u_ejec'],
                    'ger_direc' => $input['ger_direc'],
                    'cod_dist' => empty($data_dist->cod_dist)?null:$data_dist->cod_dist,
                    'nom_dist' => empty($data_dist->nom_dist)?null:$data_dist->nom_dist,
                    'cod_prov' => empty($data_prov->cod_prov)?null:$data_prov->cod_prov,
                    'nom_prov' => empty($data_prov->nom_prov)?null:$data_prov->nom_prov,         
                ]
            );
    }

    /*//eliminar datos
    public function destroy($id) {
        $data['estado'] = 0;
        PipTotalPriori::where('id', '=', $id)->update($data);
    }*/

     //DETALLE INVERSION
    public function DetalleInversion() {
        $cod_unif = Input::get('cod_unif');

        $InfFinanciera = InfFinanciera::where('cod_unif','=',$cod_unif)->get()->toArray();
        return Response([
            'message'=> 'Datos Financieros',
            'data' => $InfFinanciera,
            'error' => false
        ],200);
    }

    /*public function getSearchOpt(){
        $param = Input::get('param');
        $allowed = ['ger_direc', 'tipo_pry' , 'ult_anio_ejec_pry', 'etapa'];
        if(in_array($param,$allowed)){
            $Snipp = PipTotalPriori::select($param)->distinct()->orderBy($param,'desc')->get()->toArray();
            return Response([
                'error' => false,
                'message' => '',
                'data' => $Snipp
            ],200);
        }else {
            return Response([
                'error' => true,
                'message' => ':v',
                'data' => ''
            ],403);
        }
    }*/

    public function updateLocationInfo(Request $request){

        $input = $request->all();

        $PipTP = PipTotalPriori::where('cod_unif',$input['uid'])->first();
        $PipTP->fill(['latitud'=> $input['latitud'],'longitud'=>$input['longitud']]);
        $PipTP->save();

        return Response([
            'error' => false,
            'message' => 'Lo datos fueron guardados correctamente',
            'data' => ''
        ],200);
    }

    public function getLocationInfo(Request $request){

        $input = $request->all();
        $data = PipTotalPriori::select('latitud','longitud','cod_dist')->where('cod_unif',$input['uid'])->first();

        return Response([
            'error' => false,
            'message' => '',
            'data' => $data
        ],200);
    }

    public function stateSayhuite(Request $request){
        $input = $request->all();
        $val = '';
        $uid = $input['uid'];
        switch($input['st']){
            case 1:
                $val = 'PRIORIZADO';
                break;
            case 0:
                $val = 'NO';
                break;
            default:
                return Response(['error' => true],500);
        }

        $PipTP = PipTotalPriori::find($uid);

        $PipTP->update(['estado_pic'=>$val]);
    }

    public function codExists(Request $request){
        $input = $request->all();
        $codigo = $input['codigo'];
        $tipo   = $input['tipo'];

        if($codigo != '' and $tipo != '') {
            $id = PipTotalPriori::select('id')->where($tipo, $codigo)->pluck('id')->first();

            if ($id) {
                return Response([
                    'error' => false,
                    'data' => $id,
                    'mesage' => 'Existe'
                ], 200);
            }
        }
        return Response('',500);
    }

    public function selectPi(){
        $PipTP = PipTotalPriori::where('ger_direc','')
                                ->whereNotIn('cod_unif',['2001707','2000270','2001621'])
                                ->where('ult_anio_ejec_pry_financ','2017')
                                //->whereRaw('id <= 455 or id > 615') # MULTIANUAL @WORKAROUND
                                ->get();

        $arrUnidades = Auth::user()->unidad()->pluck('denom')->toArray();

        $etapa = SubEtapa::select('etapa')->distinct()->orderBy('etapa','desc')->get();

        return View($this->controlador .'/selectPi')->with(['data'=>$PipTP,'ger'=>$arrUnidades,'etapa'=>$etapa])->render();
    }

    public function selectPiUpdate(Request $request){
        $input = $request->all();
        $PipTP = PipTotalPriori::where('id',$input['uid'])->first();

        $PipTP->fill(['ger_direc'=> $input['ger'],'etapa'=>$input['etapa'],'sub_etapa'=>$input['subetapa']]);

        $PipTP->save();

        return Response([
            'error' => false,
            'message' => '',
            'data' => ''
        ],200);
    }

    public function wordExport($id){

        $year= date("Y");
        $PipTP = PipTotalPriori::find($id);

        $PipTPFin = InfFinanciera::where('cod_unif','=',$PipTP['cod_unif'])
                    ->where('anio_financ','=',DB::raw('(select EXTRACT(YEAR FROM now())::text)'))
                    ->get();

        $Obras = DB::table('vw_grli_obra_list')
                ->where( 'idproyecto','=',$PipTP['id'] )
                ->where('estado','1')
                ->get();

        $Alcance = DB::table('grli_proyecto_ubicacion')
                    ->where('idpi', $PipTP['id'] )
                    ->get();

        $Contrataciones = DB::table('contratacionesps')
                        ->where('fecha_act', DB::RAW("(select max(fecha_act) from contratacionesps)"))
                        ->where('cod_unico', $PipTP['cod_unif'])
                        ->orderby('fec_convocatoria')
                        ->get();

        $fuente_financiamiento=DB::table("grli_pip_seguimiento_ejecucion_financiera")
            ->select("fuente_financiamiento","pim_dia","certificacion_dia","dev_dia","girado_dia")
            ->whereNotNull("fuente_financiamiento")
            ->where("fecha",DB::raw("(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera)"))
            ->where("cod_unif",$PipTP['cod_unif'])
            ->where("anio",$year)->get();

        $formato_12b= DB::table('formato12b')->select('fecha_actual','ult_est_situal')
            ->where('fecha_subida','=',DB::RAW('(select max(fecha_subida) from formato12b)'))
            ->where('year','=',$year)
            ->where('cod_unif','=',$PipTP['cod_unif'])->first();
        
        $cartera= DB::select("select monto_anio_0 as monto_1,monto_anio_1 as monto_2,monto_anio_2 as monto_3,monto_anio_3 as monto_4 from cartera_pmi where fecha_act=(select max(fecha_act) from cartera_pmi) and anio=(select EXTRACT(YEAR FROM now())) and codigo_unico=".$PipTP['cod_unif']);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection(
            array(
                'marginLeft'   => 1200,
                'marginRight'  => 500,
                'marginTop'    => 400,
                'marginBottom' => 400,
                'headerHeight' => 400,
                'footerHeight' => 400,
            )
        );

        // Creacion del contenido
        $header = $section->addHeader();
         $header->firstPage();
         $header->addImage("images/sys/logo1.gif",array('width' => 130, 'height' => 60, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
         $section->addTextBreak();
         $section->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($PipTP->nom_proyec,array('bold' => true,'size' => 12));
         $section->addTextBreak(2);
         $section->addText("I. Datos Técnicos",array('bold' => true,'size' => 12));
         $section->addTextBreak(2);
         $table = $section->addTable();
         $table->addRow(300);
         $table->addCell(4000)->addText('1. CODIGO SNIP', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->cod_snip);
         $table->addRow(300);
         $table->addCell(4000)->addText('2. CODIGO UNICO DE INVERSIONES', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->cod_unif);
         $table->addRow(300);
         $table->addCell(4000)->addText('3. NOMBRE DEL PROYECTO', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->nom_proyec);
         $table->addRow(300);
         $table->addCell(4000)->addText('4. SECTOR', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->sector);
         $table->addRow(300);
         $table->addCell(4000)->addText('5. PROGRAMA', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->progr);
         $table->addRow(300);
         $table->addCell(4000)->addText('6. SUB PROGRAMA', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->sub_progr);
         $table->addRow(300);
         $beneficiarios=0;
         if ($PipTP->beneficiarios == null) {
           $beneficiarios=0;
         }else {
           $beneficiarios=$PipTP->beneficiarios;
         }
         $table->addCell(4000)->addText('7. BENEFICIARIOS', ['bold'=> true]);
         $table->addCell(6000)->addText($beneficiarios);
         $table->addRow(300);
         $table->addCell(4000)->addText('8. UNIDAD FORMULADORA', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->u_formul);
         $table->addRow(300);
         $table->addCell(4000)->addText('9. UNIDAD EJECUTORA', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->u_ejec);
         $table->addRow(300);
         $table->addCell(4000)->addText('10. GERENCIA/DIRECCIÓN', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->ger_direc);
         $table->addRow(300);
         $table->addCell(4000)->addText('11. DEPARTAMENTO', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->nom_dpto);
         $table->addRow(300);
         $table->addCell(4000)->addText('12. PROVINCIA', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->nom_prov);
         $table->addRow(300);
         $table->addCell(4000)->addText('13. DISTRITO', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->nom_dist);
         $table->addRow(300);
         $table->addCell(4000)->addText('14. CENTRO POBLADO', ['bold'=> true]);
         $table->addCell(6000)->addText($PipTP->nom_cp);
         $table->addRow(300);
         $table->addCell(4000)->addText('15. ALCANCE DEL PROYECTO:', ['bold'=> true]);
         $section->addTextBreak();
         $table = $section->addTable(['borderSize' => 10]);
         $table->addRow();
         $table->addCell(2500)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Departamento', ['bold'=> true]);
         $table->addCell(2500)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Provincia', ['bold'=> true]);
         $table->addCell(2500)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Distrito', ['bold'=> true]);
         $table->addCell(2500)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Centro Poblado', ['bold'=> true]);
         if(count($Alcance) > 0){
           foreach ($Alcance as $key => $value) {
             $table->addRow();
             $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->departamento,['size' => 9]);
             $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->provincia,['size' => 9]);
             $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->distrito,['size' => 9]);
             $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->localidad,['size' => 9]);
           }
         }
         else {
             $table->addRow();
             $table->addCell(10000,['valign' => 'center','gridSpan' => 4])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('No se encontró información',['size' => 9]);
          }
          $section->addTextBreak(2);
          $section->addText("II. Datos Financieros (Actualizados al ".$PipTP->f_deveng_a.")",array('bold' => true,'size' => 12));
          $section->addTextBreak(2);
          $table = $section->addTable();
          $table->addRow(300);
          $table->addCell(4000)->addText('16. MONTO PIP', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_pip,2));
          $table->addRow(300);
          $table->addCell(4000)->addText('17. MONTO VIABLE', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_viab,2));
          $table->addRow(300);
          $table->addCell(4000)->addText('18. EXP. TÉCNICO', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_deveng_a,2));
          $table->addRow(300);
          $table->addCell(4000)->addText('19. DETALLE FINANCIERO:', ['bold'=> true]);
          $section->addTextBreak();
          $table = $section->addTable(['borderSize' => 10]);
          $table->addRow();
          $table->addCell(2800)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Ejecutora', ['bold'=> true,'size' => 7]);
          $table->addCell(700)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Año', ['bold'=> true,'size' => 7]);
          $table->addCell(1466)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('PIA', ['bold'=> true,'size' => 7]);
          $table->addCell(1332)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('PIM', ['bold'=> true,'size' => 7]);
          $table->addCell(1216)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Certificación', ['bold'=> true,'size' => 7]);
          $table->addCell(1216)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Devengado', ['bold'=> true,'size' => 7]);
          $table->addCell(1270)->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Av. Financiero', ['bold'=> true,'size' => 7]);
          if(count($PipTPFin) > 0){
            foreach ($PipTPFin as $key => $value) {
              $table->addRow();
              $table->addCell(2800,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->uni_ejec,['size' => 8]);
              $table->addCell(700,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->anio_financ,['size' => 8]);
              $table->addCell(1466,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT])->addText('S/. '.number_format($value->pia,2),['size' => 8]);
              $table->addCell(1332,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT])->addText('S/. '.number_format($value->pim,2),['size' => 8]);
              $table->addCell(1216,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT])->addText('S/. '.number_format($value->certif,2),['size' => 8]);
              $table->addCell(1216,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT])->addText('S/. '.number_format($value->dev,2),['size' => 8]);
              if (empty($value->pim) or $value->pim==0) {
                $table->addCell(1270,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('0.0 %',['size' => 8]);
              }
              else{
                $table->addCell(1270,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->dev/$value->pim*100,2).' %',['size' => 8]);
              }
            }
          }
          else {
              $table->addRow();
              $table->addCell(10000,['valign' => 'center','gridSpan' => 6])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('No se encontró información',['size' => 9]);
          }
          $section->addTextBreak();
          $table = $section->addTable();
          $table->addRow(300);
          $table->addCell(4000)->addText('20. PIM ACUMULADO GRL', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_pim_acu,2));
          $table->addRow(300);
          $table->addCell(4000)->addText('21. PIM ACUMULADO TOTAL', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_pim_a_todas_ue,2));
          $table->addRow(300);
          $table->addCell(4000)->addText('22. DEVENGADO ACUMULADO GRL', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_deveng_a,2));
          $table->addRow(300);
          $table->addCell(4000)->addText('23. DEVENGADO ACUMULADO TOTAL', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_deveng_a_todas_ue,2));
          $table->addRow(300);
          $table->addCell(4000)->addText('24. % AV. FINANCIERO TOTAL', ['bold'=> true]);
          $table->addCell(6000)->addText(number_format($PipTP->a_financ_a,2).' %');
          $table->addRow(300);
          $table->addCell(4000)->addText('25. MONTO POR DEVENGAR TOTAL', ['bold'=> true]);
          $table->addCell(6000)->addText('S/. '.number_format($PipTP->m_pip - $PipTP->m_deveng_a_todas_ue ,2));
          $section->addTextBreak(2);
          $section->addText("III. Estado Situacional (Actualizado al ".$PipTP->f_etapsub.")",array('bold' => true,'size' => 12));
          $section->addTextBreak(2);
          $table = $section->addTable();
          $table->addRow(300);
          $table->addCell(4000)->addText('26. ESTADO DE PROYECTO', ['bold'=> true]);
          $table->addCell(6000)->addText($PipTP->est_pry);
          $table->addRow(300);
          $table->addCell(4000)->addText('27. TIPO DE PROYECTO', ['bold'=> true]);
          $table->addCell(6000)->addText($PipTP->tipo_pry);
          $table->addRow(300);
          $table->addCell(4000)->addText('28. ETAPA', ['bold'=> true]);
          $table->addCell(6000)->addText($PipTP->etapa);
          $table->addRow(300);
          $table->addCell(4000)->addText('29. SUB ETAPA', ['bold'=> true]);
          $table->addCell(6000)->addText($PipTP->sub_etapa);
          $table->addRow(300);
          $table->addCell(4000)->addText('30. SITUACIÓN', ['bold'=> true]);
          if(!empty($formato_12b->ult_est_situal)){
            $table->addCell(6000)->addText($formato_12b->ult_est_situal);
          }else{
            $table->addCell(6000)->addText($PipTP->situa_pro);
          }
          $section->addTextBreak();
          $section->addText("* Nota: Situación en base al último estado registrado.",array('bold' => true,'italic'=>true,'size' => 7));
          $section->addTextBreak(2);
          $section->addText("IV. Contrataciones",array('bold' => true,'size' => 12));
          $section->addTextBreak();
          $table = $section->addTable(['borderSize' => 10]);
          $table->addRow();
          $table->addCell(3000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('DESCRIPCIÓN DE PROCESO', ['bold'=> true,'size' => 7]);
          $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('TIPO CONTRATACIÓN', ['bold'=> true,'size' => 7]);
          $table->addCell(1050,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('FECHA DE CONVOCATORIA', ['bold'=> true,'size' => 7]);
          $table->addCell(1200,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('ESTADO', ['bold'=> true,'size' => 7]);
          $table->addCell(1250,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('S/. VALOR REFERENCIAL', ['bold'=> true,'size' => 7]);
          $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('TIPO DE PROCESO', ['bold'=> true,'size' => 7]);
          $table->addCell(1500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('NOMENCLATURA', ['bold'=> true,'size' => 7]);
          if(count($Contrataciones) > 0){
            foreach ($Contrataciones as $key => $value) {
              $table->addRow();
              $table->addCell(3000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::JUSTIFY])->addText($value->des_proceso,['size' => 7]);
              $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->objeto_contratac,['size' => 8]);
              $table->addCell(1050,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->fec_convocatoria,['size' => 7]);
              $table->addCell(1200,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->estado,['size' => 8]);
              $table->addCell(1250,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->valor_refer,0,'.',','),['size' => 8]);
              $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->tipo_proceso,['size' => 8]);
              $table->addCell(1500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->nomenclatura,['size' => 8]);
            }
          }
          else {
              $table->addRow();
              $table->addCell(10000,['valign' => 'center','gridSpan' => 6])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('No se encontró información',['size' => 9]);
          }
          $section->addTextBreak(2);
          $section->addText("V. Datos de obra en ejecución",array('bold' => true,'size' => 12));
          $section->addTextBreak();
          $table = $section->addTable(['borderSize' => 10]);
          $table->addRow();
          $table->addCell(2000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Obra/Actividad', ['bold'=> true,'size' => 8]);
          $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Tipo de Ejecución', ['bold'=> true,'size' => 8]);
          $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Etapa - Sub Etapa', ['bold'=> true,'size' => 8]);
          $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Avance Físico', ['bold'=> true,'size' => 8]);
          $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Descripción', ['bold'=> true,'size' => 8]);
          $table->addCell(1500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Observación', ['bold'=> true,'size' => 8]);
          $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('Fecha Actualización', ['bold'=> true,'size' => 7]);
          if(count($Obras) > 0){
            foreach ($Obras as $key => $value) {
              $table->addRow();
              $table->addCell(2000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->nom_proyec . '.' . $value->nom_meta ,['size' => 7]);
              $tipo="";
              switch ($value->tipo) {
                case 'E':
                  $tipo='INTEGRAL';
                  break;
                case 'M':
                  $tipo='META';
                  break;
                case 'S':
                  $tipo='SALDO DE OBRA';
                  break;
              }
              $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($tipo,['size' => 7]);
              $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->etapa .'-'. $value->sub_etapa,['size' => 7]);
              $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->a_fisico,['size' => 7]);
              $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->est_situ,['size' => 7]);
              $table->addCell(1500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText($value->obs,['size' => 7]);
              $table->addCell(1000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT])->addText($value->fecha_act,['size' => 7]);
            }
          }
          else {
              $table->addRow();
              $table->addCell(10000,['valign' => 'center','gridSpan' => 7])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('No se ha registrado ejecución',['size' => 9]);
          }
          $section->addTextBreak();
          $section->addText("* Fuente: SSI-MEF / CONSULTA AMIGABLE-MEF / ".$PipTP->ger_direc,array('bold' => true,'italic'=>true,'size' => 7));
          $section->addTextBreak(2);
          $section->addText("VI. Programación Multianual de inversiones",array('bold' => true,'size' => 12));
          $section->addTextBreak();
          $table = $section->addTable(['borderSize' => 10]);
          $table->addRow();
          $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('AÑO '.$year, ['bold'=> true,'size' => 8]);
          $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('AÑO '.($year+1), ['bold'=> true,'size' => 8]);
          $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('AÑO '.($year+2), ['bold'=> true,'size' => 8]);
          $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('AÑO '.($year+3), ['bold'=> true,'size' => 8]);
          if(count($cartera) > 0){
            foreach ($cartera as $key => $value) {
              $table->addRow();
              $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->monto_1,2),['size' => 7]);
              $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->monto_2,2),['size' => 7]);
              $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->monto_3,2),['size' => 7]);
              $table->addCell(2500,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->monto_4,2),['size' => 7]);
            }
          }
          else {
              $table->addRow();
              $table->addCell(10000,['valign' => 'center','gridSpan' => 7])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('No se encontró información',['size' => 9]);
          }
          $section->addTextBreak();
          $section->addText("* Fuente: Ministerio de Economía y Finanzas",array('bold' => true,'italic'=>true,'size' => 7));
          $section->addTextBreak(2);
          $section->addText("VII. Fuente de Financiamiento ".$year,array('bold' => true,'size' => 12));
          $section->addTextBreak();
          $table = $section->addTable(['borderSize' => 10]);
          $table->addRow();
          $table->addCell(3000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('FUENTE DE FINANCIAMIENTO', ['bold'=> true,'size' => 8]);
          $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('PIM', ['bold'=> true,'size' => 8]);
          $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('CERTIFICADO', ['bold'=> true,'size' => 8]);
          $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('DEVENGADO', ['bold'=> true,'size' => 8]);
          $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('GIRADO', ['bold'=> true,'size' => 8]);
          $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('% AVANCE', ['bold'=> true,'size' => 8]);
          if(count($fuente_financiamiento) > 0){
            foreach ($fuente_financiamiento as $key => $value) {
              $table->addRow();
              $table->addCell(3000,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT])->addText($value->fuente_financiamiento,['size' => 7]);
              $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->pim_dia,2),['size' => 7]);
              $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->certificacion_dia,2),['size' => 7]);
              $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->dev_dia,2),['size' => 7]);
              $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format($value->girado_dia,2),['size' => 7]);
              if($value->pim_dia==0){
                $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format(0,2),['size' => 7]);
              }
              else{
                $table->addCell(1400,['valign' => 'center'])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText(number_format(($value->dev_dia/$value->pim_dia)*100,2),['size' => 7]);
              }
            }
          }
          else {
              $table->addRow();
              $table->addCell(10000,['valign' => 'center','gridSpan' => 7])->addTextRun(['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER])->addText('No se encontró información',['size' => 9]);
          }
        //Fin
       //Guardando
       $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
       try {
         $objWriter->save(storage_path($PipTP->cod_unif.'.docx'));
       } catch (Exception $e) {
       }

       return response()->download(storage_path($PipTP->cod_unif.'.docx'));
    }

    public function pdfExport($id){

        $year= date("Y");
        $PipTP = PipTotalPriori::find($id)->toArray();
        $PipTPFin = InfFinanciera::where('cod_unif','=',$PipTP['cod_unif'])
                    ->where('anio_financ','=',DB::raw('(select EXTRACT(YEAR FROM now())::text)'))
                    ->get()
                    ->toArray();

        $Obras = DB::table('vw_grli_obra_list')
                ->where( 'idproyecto','=',$PipTP['id'] )
                ->where('estado','1')
                ->get();

        $Alcance = DB::table('grli_proyecto_ubicacion')
                    ->where('idpi', $PipTP['id'] )
                    ->get();

        $Contrataciones = DB::table('contratacionesps')
                            ->where('fecha_act', DB::RAW("(select max(fecha_act) from contratacionesps)"))
                            ->where('cod_unico', $PipTP['cod_unif'])
                            ->orderby('fec_convocatoria')
                            ->get();

        $formato_12b= DB::table('formato12b')->select('fecha_actual','ult_est_situal')
            ->where('fecha_subida','=',DB::RAW('(select max(fecha_subida) from formato12b)'))
            ->where('year','=',$year)
            ->where('cod_unif','=',$PipTP['cod_unif'])->first();
        $formato_12b =  !empty($formato_12b) ? $formato_12b->ult_est_situal : null;

        $fuente_financiamiento=DB::table("grli_pip_seguimiento_ejecucion_financiera")
            ->select("fuente_financiamiento","pim_dia","certificacion_dia","dev_dia","girado_dia")
            ->whereNotNull("fuente_financiamiento")
            ->where("fecha",DB::raw("(select max(fecha) from grli_pip_seguimiento_ejecucion_financiera)"))
            ->where("cod_unif",$PipTP['cod_unif'])
            ->where("anio",$year)->get();

        $Cartera= DB::select("select monto_anio_0 as monto_1,monto_anio_1 as monto_2,monto_anio_2 as monto_3,monto_anio_3 as monto_4 from cartera_pmi where fecha_act=(select max(fecha_act) from cartera_pmi) and anio=(select EXTRACT(YEAR FROM now())) and codigo_unico=".$PipTP['cod_unif']);

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true])
            ->loadView('piptotalpriori.pdf', compact('PipTP','PipTPFin','Obras','Alcance','Contrataciones','Cartera','fuente_financiamiento','formato_12b'));

        return $pdf->stream($PipTP['cod_unif'].'.pdf');
    }


    public function imgUpload(ImageRepository $image){
        /*
         * Vars
         */
        $input = Input::all();

        $PipTP = PipTotalPriori::where('cod_unif',$input['uid'])->first();

        //Verificamos que el proyecto tenga varias ejecuciones
        $Ejecucion = Obras::where('idproyecto',$PipTP->id)->where('estado','1')->get();
        if ( count($Ejecucion) == 0 ){
            $idObra = 0;
        } else if ( count($Ejecucion) > 1 ){
            if( !isset($input['idObra']) or empty($input['idObra']) ){
                return response()->json([
                    'error' => true,
                    'message' => 'Seleccione a que Ejecución pertenece la información fotográfica',
                    'code' => 500
                ], 500);
            }
            $idObra = $input['idObra'];
        } else {
            $idObra = $Ejecucion[0]->id;
        }

        $descripcion = $input['descripcion'];
        $uid = $input['uid'];
        $tiempo = $input['tiempo'];
        $tipo = $input['tipo'];

        //$idObra = isset($input['idObra']) ?

        //REFORMAT DATE
        $fecha = date('d-m-y',strtotime($input['fecha']));
        //TMP NAME OF IMAGES
        $tmpName = Tools::generateTmpName();
        $fileName = '';
        $lastNumber = 0;

        //CREATE DIRECTORY
        if(File::exists('images/pip/'.$uid)){
            $files = scandir('images/pip/' . $uid . '/' . strtoupper($tiempo), 1);
            $files = array_diff($files, array('.', '..'));
            natsort($files);

            if(!empty($files)) {
                $t = explode('_', end($files));
                $lastNumber = $t[2];
            }
        }else{
            File::makeDirectory('images/pip/' . $uid);

            File::makeDirectory('images/pip/' . $uid . '/ANTES');
            File::makeDirectory('images/pip/' . $uid . '/DURANTE');
            File::makeDirectory('images/pip/' . $uid . '/DESPUES');
        }

        //VALIDATOR>>>>>>>>>>>>
        foreach ($input['file'] as $key => $file) {
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

                return response()->json([
                    'error' => true,
                    'message' => $validator->messages()->first(),
                    'code' => 400
                ], 400);
            }
        }

        //>>>>>>>>>>>>>>>>>>>>>>

        //UPLOAD IMAGES
        $increment = 1;
        $success = [];
        $tmpPath = 'images/pip/tmp/'.$tmpName.'/';
        File::makeDirectory($tmpPath);
        foreach ($input['file'] as $key => $file) {
            $lastNumber += $increment;
            //extension de imagen
            $extension = $file->getClientOriginalExtension();
            //nombre de la imagen
            $fileName = $uid . '_' . strtoupper($tiempo) . '_' . $lastNumber . '_'. $fecha . '.' . $extension;
            //saving image
            $uploadSuccess = $image->save($file, $tmpPath.$fileName);
            //si falla todo se va ;c
            if(!$uploadSuccess) {
                $image->deleteImg($success,$tmpPath);
                return Response::json([
                    'error' => true,
                    'message' => 'Error del servidor',
                    'code' => 500
                ], 500);
            }
            $success[] = $fileName;
        }

        DB::beginTransaction();
        //SAVE IN DATABASE
        $column = 'ffoto_' . $tiempo;

        try{
            $PipTP->fill(["$column"=>$fecha]);

            $PipTP->save();

        } catch(Exception $ex){
            $image->deleteImg($success,$tmpPath);
            return Response::json([
                'error' => true,
                'message' => 'Error del servidor',
                'code' => 500
            ], 500);
        }

        //MOVE TO PATH IF ALL SUCCEDED
        $destinationPath = 'images/pip/'. $uid . '/' . strtoupper($tiempo) . '/';

        $files = scandir($tmpPath);
        $files = array_diff($files, array('.', '..'));

        $success= [];
        $failed = [];
        foreach ($files as $key => $file) {
            if (copy($tmpPath.$file, $destinationPath.$file)) {
                $success[] = $file;
            } else {
                $failed[] = $file;
            }
        }

        if(empty($success)){
            DB::rollback();
            $image->deleteImg($failed,$destinationPath);
        } elseif(empty($failed)) {
            $image->deleteImg($success,$tmpPath);

            //PipTotalPrioriImage
            foreach ($success as $key => $value) {
                $PipTotalPrioriImage = new PipTotalPrioriImage();
                $PipTotalPrioriImage->url = $destinationPath;
                $PipTotalPrioriImage->nombre = $value;
                $PipTotalPrioriImage->tiempo = strtoupper($tiempo);
                $PipTotalPrioriImage->fecha = $fecha;
                $PipTotalPrioriImage->idproyecto = $PipTP->id;
                $PipTotalPrioriImage->idobra = $idObra;
                $PipTotalPrioriImage->tipo = $tipo;
                $PipTotalPrioriImage->descripcion = $descripcion;
                $PipTotalPrioriImage->save();
            }

            //chmod(rtrim($tmpPath,'/'), 0777);
            rmdir(rtrim($tmpPath,'/'));
            DB::commit();
            return Response([
                'error' => false,
                'code'  => 200,
                'filename' => $fileName
            ], 200);
        } else {
            DB::rollback();
            $image->deleteImg($failed,$destinationPath);
            $image->deleteImg($success,$tmpPath);
            //chmod(rtrim($tmpPath,'/'), 0777);
            rmdir(rtrim($tmpPath,'/'));
        }

        return Response([
            'error' => true,
            'message' => 'Error del servidor',
            'code' => 500
        ], 500);

    }

    public function getServerImages($uid)
    {
        $ANTES   = [];
        $DURANTE = [];
        $DESPUES = [];

        $folders = scandir('images/pip/'.$uid, 1);
        $folders = array_diff($folders, array('.', '..'));

        $PipTp = PipTotalPriori::where('cod_unif',$uid)->first();

        if(!empty($folders)) {
            foreach($folders as $key => $folder){
                $files = scandir('images/pip/'.$uid. '/' . $folder);
                $files = array_diff($files, array('.', '..'));
                if(!empty($files)) {
                    natsort($files);

                    $lastOne = end($files);
                    $arr = Tools::multiexplode(array("_", "."), $lastOne);
                    //$lastDate = $arr[3];

                    foreach ($files as $img) {
                        $arr = Tools::multiexplode(array("_", "."), $img);
                        $tiempo = $arr[1];
                        //dd($PipTp->ffoto_durante);
                        $xvar = "ffoto_".strtolower($tiempo);
                        $lastDate = $PipTp->$xvar;
                        $thisDate = $arr[3];

                        if ($thisDate == $lastDate) {
                            switch ($folder) {
                                case 'ANTES':
                                    array_push($ANTES, [
                                        'original' => $img,
                                        'server' => $img,
                                        'size' => File::size('images/pip/'. $uid .'/ANTES/'. $img),
                                        'url' => '/images/pip/'. $uid .'/ANTES/'. $img,
                                        'fecha' => $lastDate
                                    ]);
                                    break;
                                case 'DURANTE':
                                    array_push($DURANTE, [
                                        'original' => $uid.'/'.$img,
                                        'server' => $uid.'/'.$img,
                                        'size' => File::size('images/pip/'. $uid .'/DURANTE/'. $img),
                                        'url' => '/images/pip/'. $uid .'/DURANTE/'. $img,
                                        'fecha' => $lastDate
                                    ]);
                                    break;
                                case 'DESPUES':
                                    array_push($DESPUES, [
                                        'original' => $uid.'/'.$img,
                                        'server' => $uid.'/'.$img,
                                        'size' => File::size('images/pip/'. $uid .'/DESPUES/'. $img),
                                        'url' => '/images/pip/'. $uid .'/DESPUES/'. $img,
                                        'fecha' => $lastDate
                                    ]);
                                    break;
                            }
                        }
                    }
                }

            }
        }

        //$images = Image::get(['original_name', 'filename']);
        $files = scandir('images/pip/'.$uid, 1);
        $images = array_diff($files, array('.', '..'));
        $imageAnswer = [];


        return response()->json([
            'antes' => $ANTES,
            'durante' => $DURANTE,
            'despues' => $DESPUES
        ]);
    }

    public function getServerImages2($uid){

        $imgObras = DB::table('vw_grli_obra_list')
                    ->where('vw_grli_obra_list.idproyecto', (int)$uid)
                    ->where('vw_grli_obra_list.estado', '1')
                    ->get();

        $imgObras = $imgObras->transform(function($item, $key){
            $item->img = DB::table('grli_pip_total_priori_img')
                                ->select('fecha')
                                ->where('estado','1')
                                ->where('idobra',$item->id)
                                ->distinct('fecha')
                                ->orderBy('fecha','desc')
                                ->get();

                    $item->img->transform(function($subitem, $key) use ($item){
                        $subitem->img = DB::table('grli_pip_total_priori_img')
                                    ->where('estado','1')
                                    ->where('idobra',$item->id)
                                    ->where('fecha',$subitem->fecha)
                                    ->get();

                        return $subitem;
                    });

            return $item;
        });

       $imgPorAsignar = DB::table('grli_pip_total_priori_img')
                            ->select('fecha')
                            ->where('estado','1')
                            ->whereRaw("( (idobra::text is null) or (idobra = 0) )")
                            //->orWhere("idobra",0)
                            ->where('idproyecto',(int)$uid)
                            ->distinct('fecha')
                            ->orderBy('fecha', 'desc')
                            ->get();

                $imgPorAsignar->transform(function($item, $key) use ( $uid ){
                        $item->img = DB::table('grli_pip_total_priori_img')
                                    ->where('estado','1')
                                    ->where('idproyecto',(int)$uid)
                                    ->where('fecha',$item->fecha)
                                    ->get();

                        return $item;
                    });


        return response()->json([
            'imgObras' => $imgObras,
            'imgPorAsignar' => $imgPorAsignar
        ]);

    }

    public function getEditServerImages($idproyecto ,Request $request){
      $input = $request->all();

      $PipTotalPrioriImage = DB::table('grli_pip_total_priori_img')
                            ->where('grli_pip_total_priori_img.estado','1')
                            ->whereRaw('coalesce(grli_pip_total_priori_img.idobra,0) = ' . (int)$input['idobra'] )
                            ->where('grli_pip_total_priori_img.idproyecto', '=', $idproyecto )
                            ->where('grli_pip_total_priori_img.tiempo', 'like', $input['tiempo'] )
                            ->where('grli_pip_total_priori_img.fecha', '=', $input['fecha'] )
                            ->get();

      $PipTotalPriori = PipTotalPriori::where('grli_pip_total_priori.id', '=', (int)$idproyecto )
                        ->select([
                          'grli_pip_total_priori.id',
                          'grli_pip_total_priori.nom_proyec'
                        ])
                        ->first();

      $Obras = DB::table('vw_grli_obra_list')
                ->where('idproyecto', '=', $PipTotalPriori->id)
                ->get();

      return view('piptotalpriori.editImage')
              ->with([
                'PipTotalPrioriImg' => $PipTotalPrioriImage,
                'PipTotalPriori' => $PipTotalPriori,
                'Obras'=> $Obras
              ])
              ->render();
    }

    public function getImagePack($idproyecto, Request $request){
      $input = $request->all();

      $PipTotalPrioriImage = DB::table('grli_pip_total_priori_img')
                            ->where('grli_pip_total_priori_img.estado','1')
                            ->whereRaw('coalesce(grli_pip_total_priori_img.idobra,0) = ' . (int)$input['idobra'] )
                            ->where('grli_pip_total_priori_img.idproyecto', '=', $idproyecto )
                            ->where('grli_pip_total_priori_img.tiempo', 'like', $input['tiempo'] )
                            ->where('grli_pip_total_priori_img.fecha', '=', $input['fecha'] )
                            ->get();

      return Response($PipTotalPrioriImage,200);
    }

    public function updateImage($idproyecto, Request $request){

      $input = $request->all();

      $arr = [
                  'Fecha' => $input['fecha'],
                  'Descripción' => $input['descripcion'],
                  'Tiempo' => $input['tiempo'],
                  'Obra' => @$input['optObra'],
                  'Proyecto' => $idproyecto,
                  'Tipo' => $input['tipo'],
                  'Tiempo Original' => $input['old_tiempo'],
                  'Fecha Original' => $input['old_fecha'],
                  'Obra Original' => $input['old_optObra']
                ];
      $rules = [
                  'Fecha' => 'required|date',
                  'Descripción' => 'string',
                  'Tiempo' => 'required|string',
                  'Obra' => 'required|numeric',
                  'Proyecto' => 'required|numeric',
                  'Tipo' => 'required|string',
                  'Tiempo Original' => 'required|string',
                  'Fecha Original' => 'required|date',
                  'Obra Original' => 'numeric'
                ];

      $validator = Validator::make($arr, $rules);

      if ($validator->fails()){
        $mensaje_error = array();
        $mensajes = $validator->messages();
        //RETORNA ERRORES DE VALIDACION
        return Response($mensajes->all(),400);
      }

      $Proyecto = PipTotalPriori::find((int)$idproyecto);

      $Images = PipTotalPrioriImage::where('estado', '1')
          ->where( 'idproyecto', (int)$idproyecto )
          ->whereRaw( 'coalesce(idobra,0) = ' . (int)$input['old_optObra'] )
          ->where( 'fecha', $input['old_fecha'] )
          ->where( 'tiempo', strtoupper($input['old_tiempo']) )
          ->get();

      DB::beginTransaction();
      foreach ($Images as $key => $value) {

        $url = $value->url . $value->nombre;

        $newUrl = 'images/pip/' . $Proyecto->cod_unif . '/' . strtoupper($input['tiempo']) . '/';
        $extension = explode('.', $value->nombre)[1];
        $newImageName = $Proyecto->cod_unif . '_' . strtoupper($input['tiempo']) . '_' . $value->id . '_' . date('d-m-y',strtotime($input['fecha'])) . '.' . $extension;

        $image = PipTotalPrioriImage::find($value->id);

        $image->url = $newUrl;
        $image->nombre = $newImageName;

        $image->tiempo = strtoupper($input['tiempo']);
        $image->descripcion = $input['descripcion'];
        $image->tipo = $input['tipo'];
        $image->fecha = date('Y-m-d',strtotime($input['fecha']));
        $image->idobra = $input['optObra'];

        $image->save();

        try {
          rename( public_path($url), public_path($newUrl.$newImageName) );
        } catch(Exception $ex){
          DB::rollBack();
          return 'Error';
        }
      }

      $MaxDate = PipTotalPrioriImage::where('idproyecto', (int)$idproyecto)
                    ->where( 'tiempo', strtoupper($input['tiempo']) )
                    ->max('fecha');

      //dd($MaxDate, date('Y-m-d',strtotime($input['fecha'])));

      if ( date('Y-m-d',strtotime($MaxDate)) <= date('Y-m-d',strtotime($input['fecha'])) ){

        $column = 'ffoto_' . strtolower($input['tiempo']);
        $Proyecto->$column  = date('d-m-y',strtotime($input['fecha']));
        $Proyecto->save();

      }

      DB::commit();

    }

    public function deleteImagePack($imageId){

      $PipTotalPrioriImage = PipTotalPrioriImage::find((int)$imageId);
      $PipTotalPrioriImage->estado = '0';
      $PipTotalPrioriImage->save();

      return Response('Fotografía Borrada',200);
    }

    /*
     * PDF file Upload
     */

    public function uploadPdf(Request $request, PdfRepository $pdfRepo){
        //dd($request->all());
        $r = $pdfRepo->upload($request);

        //dd($r);

    }

    /*
     * VER CAMBIOS
     */

    public function getAuditChanges(Request $request)
    {
        $id = $request->get('id');

        $Audit = audits::find($id);

        return Response($Audit,200);
    }

    public function history($id){
        $Proyectos = $this->getHistory($id);
        // return ($Proyectos);
        return View::make($this->controlador . '.history')->with('proyecto',$Proyectos);
    }

    public function exportHistory($id){

        $proyecto = $this->getHistory($id);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('piptotalpriori.historypdf', compact('proyecto'));

        return $pdf->stream('asddsasas.pdf');
    }

    private function getHistory($id){
        $Proyectos  = PipTotalPriori::select([
                        'id',
                        'nom_proyec',
                        'cod_unif',
                        'cod_snip',
                        'a_fisico',
                        'a_financ',
                        'm_pim',
                        'm_deveng',
                        'etapa'
                    ])
                    ->where('id',$id)->get();

        $Proyectos->transform(function ($item, $key) {
            $item['obras'] = Obras::where('idproyecto',$item->id)->where('estado',1)->get();
            $item['obras']->transform(function ($subitem, $key) {
                $subitem['estado'] = ObrasEstado::where('idobra',$subitem->id)
                                        ->join('grli_obra_estado_img','grli_obra_estado_img.id_grli_obra_estado','=','grli_obra_estado.id')
                                        ->where('grli_obra_estado.estado',1)
                                        ->get();
                return $subitem;
            });

            $item['estado_proyecto'] = DB::table('grli_pip_total_priori_estado')
                                        ->where('idproyecto',$item->id)
                                        ->orderBy('fecha_act','desc')->where('estado',1)->get();


            $item['timeline'] = DB::table('vw_timeline_alldates')
            ->orderBy('fecha_estado', 'desc')
            ->where('vw_timeline_alldates.idproyecto',$item->id)
            ->get();

            $item['timeline']->transform(function($sitem, $key){

                $sitem->proyecto_estado = DB::table('grli_pip_total_priori_estado')
                                            ->where('idproyecto',$sitem->idproyecto)
                                            ->where('fecha_act',$sitem->fecha_estado)
                                            ->where('grli_pip_total_priori_estado.estado','1')
                                            ->first();

                $sitem->obra_estado     = DB::table('grli_obra_estado')
                                            ->select([
                                                DB::raw('grli_obra_estado.id as id_estado'),
                                                'grli_obra_estado.*',
                                                'grli_obra.*'
                                            ])
                                            ->join('grli_obra','grli_obra.id','=','grli_obra_estado.idobra')
                                            ->where('grli_obra.idproyecto',$sitem->idproyecto)
                                            ->where('fecha_act',$sitem->fecha_estado)
                                            ->where('grli_obra.estado','1')
                                            ->get();

                $sitem->obra_estado->transform(function($titem, $key){
                    $titem->obra_estado_img = DB::table('grli_obra_estado_img')
                                            ->where('id_grli_obra_estado',$titem->id_estado)
                                            ->where('grli_obra_estado_img.estado','1')
                                            ->get();
                    return $titem;
                });

                $sitem->proyecto_img    = DB::table('grli_pip_total_priori_img')
                                            ->where('idproyecto',$sitem->idproyecto)
                                            ->where('fecha',$sitem->fecha_estado)
                                            ->get();

                return $sitem;
            });



            return $item;
        })->toArray();

        return $Proyectos[0];
    }

    public function historyFinance($id){
        $Proyecto = $this->getHistoryFinance($id);
        return View::make($this->controlador . '.historyFinance')->with($Proyecto);
    }

    public function getHistoryFinance($id){
      $Proyecto  = PipTotalPriori::select([
                      'id',
                      'nom_proyec',
                      'cod_unif',
                      'cod_snip',
                      'a_fisico',
                      'a_financ',
                      'm_pim',
                      'm_deveng',
                      'etapa'
                  ])
                    ->where('id',$id)
                    ->first();

      $HistoryFinance = DB::table('grli_pip_seguimiento_ejecucion_financiera')
                        ->orderBy('fecha', 'desc')
                        ->where('cod_unif', $Proyecto->cod_unif )
                        ->get();

      return [
        'Proyecto' => $Proyecto,
        'HistoryFinance' => $HistoryFinance
      ];
    }

    public function filterEstadoProyecto(Request $request){

      $input = $request->all();
      /*$page = $input['page']; // get the requested page
      $limit = $input['rows']; // get how many rows we want to have into the grid
      $sidx = $input['sidx']; // get index row - i.e. user click to sort
      $sord = $input['sord']; // get the direction
      $start = $limit * $page - $limit;*/

      $EstadoProyecto = DB::table('grli_pip_total_priori_estado')
              ->where('idproyecto', $input['idproyecto'])
              ->where('estado','1')
              ->orderBy('fecha_act','desc');

      return Response([
          'data' => $EstadoProyecto->get(),
          'recordsTotal' => 0,
          'recordsFiltered' => 0
      ]);

    }

    public function deleteEstadoProyecto(Request $request){

      $input = $request->all();
      $idproyecto = (int)$input['id'];

      $PipTotalPrioriEstado = PipTotalPrioriEstado::find($idproyecto);

      $PipTotalPrioriEstado->update(['estado'=>0]);

      PipTotalPriori::updateMasterTB($PipTotalPrioriEstado->idproyecto);

    }

    public function getMetas($id){
      $metas = Obras::where('idproyecto',$id)->where('estado','1')->get();

      return Response(["metas"=>$metas]);
    }

}

