<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class GoreController extends Controller
{
    public function goreejecutivo()
    {
      return view('gore/goreejecutivoagenda/goreejecutivo');
    }

    public function goreejecutivocargar(Request $request)
    {
      $input=$request->all();
      if (!empty($input['hoja'])) {
        return view('gore/goreejecutivo/hojas/'.$input['hoja'])->with(
            [
                'hoja'  => $input['hoja']
            ]

        )->render();
      }
    }

    public function goreejecutivoagenda()
    {
      return view('gore/goreejecutivoagenda/goreejecutivo');
    }

    public function goreejecutivoagendacargar(Request $request)
    {
      $input=$request->all();
      if (!empty($input['hoja'])) {
        return view('gore/goreejecutivoagenda/hojas/'.$input['hoja'])->with(
            [
                'hoja'  => $input['hoja']
            ]

        )->render();
      }
    }

    public function ver_trans_asig_nacional(Request $request)
    {
      $trans_asig_nacional= DB::select("select * from trans_asig_nacional");
      return Response([
        'gob_reg' => $trans_asig_nacional
      ]);
    }
}
