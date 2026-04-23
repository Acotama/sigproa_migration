<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function inicio(){
      return View('reporteavance');
    }
}
