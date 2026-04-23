<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use sayhuite\ejecucion_financiera;

class CarteraPMIController extends Controller
{
    public function inicio()
    {
      return view('cartera/carterapmi');
    }

    public function datos(Request $request)
    {
      $cartera= DB::select("select * from vw_cartera_pmi");
            
      return Response([
        'data' => $cartera
      ]);
    }
}
