<?php

namespace sayhuite\Logic\Tools;

use Sunra\PhpSimple\HtmlDomParser;

class requestTipoCambio {

 	protected $año;
 	protected $mes;
 	protected $dia; 


 	private $html;	

	function __construct ($año,$mes,$dia){
		$this->año = $año;
		$this->mes = $mes;
		$this->dia = $dia;		
		$this->getHtml();
	}

	public function processHtml(){		
		$dom = HtmlDomParser::str_get_html($this->html);
		$elem = $dom->find('table');

		return $elem;
		
	}

	private function getHtml(){		
		$data = curl_init("http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mes=".$this->mes."&anho=".$this->año);
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		$out = curl_exec($data);
		curl_close($data);

		$this->html = $out;
	}	

	
	
}




	
