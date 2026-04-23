<?php

namespace sayhuite\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiMefController extends Controller
{
    public function ssi($codigo)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://ofi5.mef.gob.pe/inviertews/Dashboard/traeDetInvSSI', [
            'form_params' => [
                'id' => $codigo,
                'tipo' => 'SIAF',
            ],
            'verify' => false
        ]);
        return json_decode($response->getBody(), true);
    }

    public function f12b($codigo)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://ofi5.mef.gob.pe/inviertews/Dashboard/traeInformF12B_CU', [
            'form_params' => [
                'id' => $codigo,
            ],
            'verify' => false
        ]);
        return json_decode($response->getBody(), true);
    }

    public function pmi($codigo)
    {
        $client = new Client();
        $response = $client->request('POST', 'http://ofi5.mef.gob.pe/invierte/Pmi/traeListaCarteraSector', [
            'form_params' => [
                'txtCodigoUnico' => $codigo,
                'ddlSector' => '',
            ],
            'verify' => false
        ]);
        return json_decode($response->getBody(), true);
    }

    public function formato08($codigo)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://ofi5.mef.gob.pe/invierte/ejecucion/verFichaEjecucion/'.$codigo, [
            'verify' => false
        ]);

        return $response->getBody();
    }
}




