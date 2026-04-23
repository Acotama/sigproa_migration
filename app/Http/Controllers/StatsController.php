<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\InfFinanciera;
use sayhuite\procedures\sp_Procedures;
use DB;

class StatsController extends Controller
{

	protected $sp_Procedures;
    // PROCEDURES
    public function __construct(sp_Procedures $sp_Procedures)
    {
      $this->sp_Procedures = $sp_Procedures;
    }
    // FIN PROCEDURES

    public function lineFinanciera(Request $request){

    	$input = $request->all();
    	$year = $input['cboYear'] or '2017';

    	$month = '';

    	$response = $this->financPerYear($year);

    	return Response($response);    	
    }   

    public function financPerYear($year){
    	$Months = [
    				"Enero",
    				"Febrero",
    				"Marzo",
    				"Abril",
    				"Mayo",
    				"Junio",
    				"Julio",
    				"Agosto",
    				"Septiembre",
    				"Octubre",
    				"Noviembre",
    				"Diciembre"
    			];
		$Pim=[];

    	$InfFinancieraDev = DB::table("vw_bi_inf_financiera_2")->select([
			DB::raw("SUM(enero::float) as \"0\""),
			DB::raw("SUM(febrero::float) as \"1\""),
			DB::raw("SUM(marzo::float) as \"2\""),
			DB::raw("SUM(abril::float) as \"3\""),
			DB::raw("SUM(mayo::float) as \"4\""),
			DB::raw("SUM(junio::float) as \"5\""),
			DB::raw("SUM(julio::float) as \"6\""),
			DB::raw("SUM(agosto::float) as \"7\""),
			DB::raw("SUM(septiembre::float) as \"8\""),
			DB::raw("SUM(octubre::float) as \"9\""),
			DB::raw("SUM(noviembre::float) as \"10\""),
			DB::raw("SUM(diciembre::float) as \"11\"")
		])->first();
		
		$InfFinancieraDevArray = collect($InfFinancieraDev)->toArray();

		$response= $this->sp_Procedures->sp_inf_fianciera('EJECUTORA',null,$year);
		foreach ($response as $key => $data) {
			array_push($Pim,$data->pim);
		}

		if (end($Pim) == 0) {
			array_pop($Pim);
		}

		$InfFinancieraDevAcumulada = $this->devAcumulado($InfFinancieraDevArray);

		return [
				"devengado" 		 => $InfFinancieraDevArray,
				"pim" 				 => $Pim,
				"devengadoAcumulado" => $InfFinancieraDevAcumulada
		];
    }

    public function devAcumulado($values){
    	$acumulado = [];
    	$sum = 0;
    	//dd($values);
    	foreach ($values as $key => $value) {    		
    		if($value != 0){
	    		$sum = $sum + $value;
	    		$acumulado[$key] = $sum;
	    	} else {
	    		$acumulado[$key] = 0;
	    	}
    	}

    	return $acumulado;
    }

	public function ranking(Request $request){
		$input = $request->all();
		$ranking;
		if ($input["categoria"] == "PLIEGO") {
			$ranking = DB::table("inf_financiera_rank")->select("cod","gore","pim","deveng","avance")
			->where("fecha",DB::RAW("(select max(fecha) from inf_financiera_rank)"))
			->where("categoria",$input["categoria"])
			->where("anio",$input["anio"])
			->orderby("avance","desc")
			->get();
		}else{
			$ranking = DB::table("inf_financiera_rank")->select(DB::RAW("inf_financiera_rank.cod,inf_financiera_rank.gore,case when inf_financiera_rank.avance is null then 0 else inf_financiera_rank.avance end as avance_regional,
			case when inf_financiera_sector.avance is null then 0 else inf_financiera_sector.avance end as avance_lima"))
			->leftjoin(DB::RAW("(select cod,gore,avance from inf_financiera_rank where fecha=(select max(fecha) from inf_financiera_rank) and categoria='SECTOR-REGIONAL-LIMA') as inf_financiera_sector"),"inf_financiera_rank.cod","inf_financiera_sector.cod")
			->where("fecha",DB::RAW("(select max(fecha) from inf_financiera_rank)"))
			->where("categoria",$input["categoria"])
			->where("anio",$input["anio"])
			->orderby("avance_regional","desc")
			->get();
		}
		return Response($ranking);   	
	}
}
