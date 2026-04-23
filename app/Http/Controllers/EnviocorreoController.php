<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use DateTime;
use sayhuite\Mail\MensajeRecibido;
use Illuminate\Support\Facades\Mail;
use DB;

class EnviocorreoController extends Controller
{

    public function GuardarImagen(Request $request){  
        $input=$request->all();
        $now = new DateTime();
        $now = $now->modify('-1 days');

        $image = $input['data'];  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'ReporteDiario'. $now->format('d-m-Y') . '.' . 'png';  
        Storage::disk('images_base64')->put($imageName, base64_decode($image));

        $proyecto_fecha = DB::table("vw_grli_pip_seguimiento_ejecucion_financiera")->max('fecha');
        if($proyecto_fecha == date("Y-m-d")){
            $this->EnvioCorreo($imageName);
        }
    }

    public function EnvioCorreo($nombre){

        $filename = $nombre;
        $file =  Storage::disk('images_base64')->getAdapter()->getPathPrefix().$filename;
        $email=[
            'frankazanero@outlook.com',
            // 'tansoloproyectos@gmail.com',
            // 'cesarmv0604@gmail.com',
            // 'helmerfdc@gmail.com',
            // 'cecilia.manrique.01.cm@gmail.com',
            // 'jomher.luis@hotmail.com',
            // 'jetona76@hotmail.com',
            // 'lolofovida@gmail.com',
        ];
        $message=[
            'name'=> 'Wilder Marcial Morales Sabino',
            'email' => 'wmorales@regionlima.gob.pe',
            'subject' => 'Reporte diario',
            'content' => 'Se le envia el Reporte Diario',
            'archivo' => $file,
            'nombre'  => $filename
        ];  

        Mail::to($email)->send(new MensajeRecibido($message));
        // return 'Mensaje Enviado';
        return Response(['error' => false , 'msg' => 'Mensaje Enviado'],200);
    }
}
