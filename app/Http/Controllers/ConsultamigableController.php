<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ConsultamigableController extends Controller
{
    public function inicio(Request $request){
        return View('consulta_amigable');
    }
    
}
