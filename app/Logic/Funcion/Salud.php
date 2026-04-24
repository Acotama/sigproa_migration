<?php

namespace sayhuite\Logic\Funcion;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
//use sayhuite\Models\Image;
use Mockery\CountValidator\Exception;

use sayhuite\Models\AtencionUsuario;
use Illuminate\Support\Facades\DB;
use Auth;

class Salud
{	

	protected $imageDate = "";
    protected $controlador = 'poi.salud';
    protected $num = 10;

    protected $exifdata = "";

    function __construct(){
        $this->Sector = new Educacion();
    }

    public function index() {        
        return View::make($this->controlador. '.index');
    }

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

        $Atencion = DB::table('poi_salud_paciente')->select([
            'poi_salud_paciente.*',
            DB::raw("poi_salud_paciente.appat_madre || ' ' || poi_salud_paciente.apmat_madre || ', ' || poi_salud_paciente.nombres_madre as nom_madre"),
            DB::raw('EXTRACT( year from  age(poi_salud_paciente.fecha_nac) ) as edad_year'),
            DB::raw('EXTRACT( month from  age(poi_salud_paciente.fecha_nac) ) as edad_month')
            //DB::raw('EXTRACT(year from  age(poi_salud_paciente.fecha_nac) ) * 12 + EXTRACT( month from  age(poi_salud_paciente.fecha_nac) ) as edad_meses')
            ]);

        $recordsTotal = $Atencion->count();

        if(!empty($input['search']['value'])){
            $ss = '%'. ($input['search']['value']) .'%';
            $Atencion = $Atencion->whereRaw("( COALESCE(poi_salud_paciente.nro_doc, '') || COALESCE(appat_madre,'') || COALESCE(apmat_madre,'')  || COALESCE(nro_doc_madre,'') ) ilike ?",$ss);
        }

        $order = $input['order'][0];
        $oColumn = $order['column'];
        $oType   = $order['dir'];

        $recordsFiltered = $Atencion->count();
        if($input['columns'][$oColumn]['name'] != 'accion') {
            $Atencion = $Atencion->orderBy($input['columns'][$oColumn]['name'], "$oType");
        }

        $start   =  $input['start'];
        $length  =  $input['length'];
        $Atencion  = $Atencion->skip($start)->take($length);
        //$Atencion  = $this->defineState($Atencion);
        
        return Response([
            'data' => $Atencion->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ]);
    }

    function intervencionFilter($input){

        $Intervenciones = AtencionUsuario::select([
            'poi_salud_atencion_usuario.*'
        ])->where('poi_salud_atencion_usuario.id_poi_salud_paciente',$input['id'])->get()->toArray();
        
        return [
            'data' => $Intervenciones,
            'recordsTotal' => 0,
            'recordsFiltered' => 0
        ];
    }
}
