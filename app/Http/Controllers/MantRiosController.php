<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;

use sayhuite\Departamento;
use sayhuite\Dependencia;
use sayhuite\Provincia;
use sayhuite\Distrito;
use sayhuite\SubEtapa;
use sayhuite\EstAntig;
use sayhuite\MantRios;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use File;
use sayhuite\Logic\Tools\Tools;
use Validator;
use Illuminate\Support\Facades\DB;

class MantRiosController extends Controller
{
    protected $controlador = 'mantrios';
    protected $num = 10;

    protected $searchAlias = [
        'eq' => '=',
        'cn' => 'like',
        'nc' => '<>'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make($this->controlador . '.index');
    }

    public function filterData(Request $request){
        $input = $request->all();
        $page = $input['page']; // get the requested page
        $limit = $input['rows']; // get how many rows we want to have into the grid
        $sidx = $input['sidx']; // get index row - i.e. user click to sort
        $sord = $input['sord']; // get the direction
        $start = $limit*$page - $limit;

        $MantRios = MantRios::select([
            'id',
            'dep',
            'prov',
            'dist',
            'activ',
            'mf_ficha',
            'mt_ficha',
            'meta_ficha',
            'mf_exp',
            'mt_exp',
            'meta_exp',            
            'mpro',
            'meje',
            'adic',
            'ejecadi',
            'est',
            'anio'
        ]);
        
        $MantRios = $MantRios->orderBy($sidx,$sord )->groupBy(
            'id',
            'dep',
            'prov',
            'dist',
            'activ',
            'mf_ficha',
            'mt_ficha',
            'meta_ficha',
            'mf_exp',
            'mt_exp',
            'meta_exp',            
            'mpro',
            'meje',
            'adic',
            'ejecadi',
            'est',
            'anio'
        );

        //$legend = $this->countEtapa($MantRios->get());

        //FILTER
        if(isset($input['filters']) and !empty($input['filters'])){
            $input['filters'] = json_decode($input['filters'],true);
            switch($input['filters']['groupOp']){
                case 'AND':
                    
                    foreach($input['filters']['rules'] as $rule){
                        $field = $rule['field'];
                        $operation = $rule['op'];
                        $param = strtoupper($rule['data']);

                        switch($operation){
                            case 'eq':
                                $MantRios = $MantRios->where($field,'=',$param);
                                break;
                            case 'cn':
                                $MantRios = $MantRios->where($field,'like','%'.$param.'%');
                                break;
                            case 'nc':
                                $MantRios = $MantRios->where($field,'not like','%'.$param.'%');
                                break;
                        }

                    }

                    break;
            }
        }

        $count  = $MantRios->get()->count();
        $totalpages = ceil($count / $limit);
        $MantRios  = $MantRios->skip($start)->take($limit)->get();

        return Response([
            'rows' => $MantRios->toArray(),
            'page' => $page,
            'total' => $totalpages,
            'records' => $count
            //'legend' => $legend
        ]);

        //filters:{"groupOp":"AND","rules":[{"field":"av_finan","op":"bw","data":"sasdaas"},{"field":"mod_ejec","op":"bw","data":"ddfsdsf"}]}

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
        //
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
