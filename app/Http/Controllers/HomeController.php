<?php

namespace sayhuite\Http\Controllers;

use sayhuite\Usuario;
use sayhuite\Acceso;
use sayhuite\Dependencia;
use sayhuite\Rol;
use sayhuite\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use DateTime;
use sayhuite\Events\IsOnline;
use Response;
use DB;

class HomeController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      | Route::get('/', 'HomeController@showWelcome');
      |
     */

//  public function showWelcome()
//  {
//      return View::make('hello');
//  }

    public function index() {
        if (Auth::check()) {
            return redirect('/inicio');
        }
        return View::make('security.login');
    }

    public function resumen() {
        return view('resumen');
    }

    public function resumen1() {
        return view('resumen1');
    }

    public function login() {
        return View::make('security.login');
    }

    public function postLogin(Request $request) {
        $rules = [
            'username' => 'required|Exists:usuario,username',
            'password' => 'required'
        ];
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->passes()) {
            $userdata = array(
                'username' => request()->get('username'),
                'password' => request()->get('password'),
                'estado' => 1,
                'activo' => 1,
                'poi' => '0'
            );

            if (Auth::attempt($userdata, request()->get('rememberme', 0))) {
                //GUARDAR EL ACCESO
                $this->registrarAcceso();
                if( Auth::user()->poi == "1" ){
                    //USUARIO NORMAL
                    if( Auth::user()->hasRole('edu_soporte_poi') ){
                        $mUsuario = Usuario::find(Auth::id());

                        $userDependencie = $mUsuario->unidad()->pluck('sector')->first();

                        return redirect('/inicio');
                    }
                }

                // if(Auth::user()->hasRole('contratacion')){
                //     //USUARIO CONTRATACIONES
                //     return redirect('/procedimiento/resumen');
                // }
                return redirect('/inicio');
            }else {
                return redirect('/login')->with('mensaje_error', 'La Contraseña es incorrecta')->withInput();
            }
        } else {
            $rules = ['username' => 'required|Exists:usuario,username'];
            $validator = Validator::make(request()->all(), $rules);
            if ($validator->passes())
                return redirect('/login')->with('mensaje_error', 'La Contraseña no Valida')->withInput();
            else
                return redirect('/login')->with('mensaje_error', 'El Usuario no existe')->withInput();
        }
    }

    public function logOut() {
        Session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function inicio() {

        event(new IsOnline());

        if (Auth::check()) {
            $roles = Auth::user()->roles->first();
            $rol = $roles ? strtoupper($roles->display_name) : 'SIN ROL';
            $roles_acceso_total = ['OPMI', 'PRESUPUESTO', 'ADMINISTRADOR', 'ALTA DIRECCIÓN'];
            $unidad = Auth::user()->unidad->first();
            $uei = $unidad ? $unidad->denom : null;
            $esuei = 1;
            if (in_array($rol, $roles_acceso_total)) {
                $esuei = 0;
            }
            //ADMINISTRADOR
            // dd(Auth::user()->hasRole());
            if( Auth::user()->hasRole('admin') ){
                
             return View::make('principal', compact('esuei', 'uei'));
            }else if (Auth::user()->hasRole('supervisor')) {
              return redirect('/piptotalpriori/ejecucion/obra/evidencia');
            }
            else if( Auth::user()->poi == "1" ){ //POI EDUCACION

                //USUARIO NORMAL
                /*if( Auth::user()->hasRole('usuariopoi') ){
                    $mUsuario = Usuario::find(Auth::id());

                    $userDependencie = $mUsuario->unidad()->pluck('sector')->first();

                    return redirect('/poi/educacion/programacion');
                }*/
                //ESPECIALISTAS | GESTOR LOCAL | RCI
                if( Auth::user()->hasRole('especialista_poi') ){
                    $mUsuario = Usuario::find(Auth::id());
                    $userDependencie = $mUsuario->unidad()->pluck('sector')->first();
                    return redirect('/inicio');
                }
                //ADMIN POI
                if( Auth::user()->hasRole('adminpoi') ){
                   return View::make('principal', compact('esuei', 'uei'));
                }

            }
            //POI SALUD
            else if( Auth::user()->poi == "2" ){
                //USUARIO NORMAL
                if( Auth::user()->hasRole('usuariopoi') ){
                    $mUsuario = Usuario::find(Auth::id());

                    $userDependencie = $mUsuario->unidad()->pluck('sector')->first();

                    return redirect('/inicio');
                }
            }
           return View::make('principal', compact('esuei', 'uei'));
        }
        return View::make('security.login');
    }

    public function perfil() {
        $data = Usuario::find(Auth::user()->idusuario);

        $unidad = Dependencia::where('estado', '=', 1)->pluck('denom', 'iddependencia')->toArray();
        $unidadCombo = [0 => "-- Seleccione una Dependencia --"] + $unidad;

        $rol = Rol::where('estado', '=', 1)->pluck('denom', 'idrol')->toArray();
        $rolCombo = [0 => "-- Seleccione un Rol --"] + $rol;

        return View::make('security.perfil', compact('data', 'unidadCombo', 'rolCombo'));
    }

    public function perfilUpdate($id) {
        $id = Auth::id();
        $validator = Validator::make($data = request()->all(), Usuario::$rulesPerfil);
        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . '<br>';
            }
            return back()->with('mensaje_error', $mensaje_error)->withInput();
        } else {
            /*$data['password'] = Hash::make($data['password_new']);
            unset($data['password_new']);*/

            $User = Usuario::where('idusuario', $id)->first();
            $User->email = $data['email'];
            $User->dni = $data['dni'];
            $User->apellidos = $data['apellidos'];
            $User->nombres = $data['nombres'];
            $User->celular = $data['celular'];
            $User->cargo = $data['cargo'];

            $User->save();

            return redirect('perfil')->with('mensaje_exito', 'Los datos se actualizaron correctamente')->withInput();
        }
    }

    public function password() {
        return View::make('security.password', compact('data'));
    }

    public function passwordUpdate($id) {
        $rules = [
            'password' => 'required',
            'password_new' => 'required',
            'password_confirm' => 'required'
        ];
        $validator = Validator::make($data = request()->all(), $rules);

        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . '. <br>';
            }
            return back()->with('mensaje_error', $mensaje_error)->withInput();
        } else {
            if (Hash::check($data['password'], Auth::user()->password)) {
                if (strlen($data['password_new']) >= 6) {
                    if ($data['password_new'] == $data['password_confirm']) {
                        $data['password'] = Hash::make($data['password_new']);
                        unset($data['password_new']);
                        unset($data['password_confirm']);
                        Usuario::where('idusuario', $id)->update($data);
                        return redirect('password')->with('mensaje_exito', 'Los datos se actualizaron correctamente')->withInput();
                    } else
                        return back()->with('mensaje_error', 'Las contraseñas nuevas no son iguales')->withInput();
                } else
                    return back()->with('mensaje_error', 'La contraseña nueva debe tener al menos 6 dígitos')->withInput();
            } else
                return back()->with('mensaje_error', 'La contraseña anterior no es correcta')->withInput();
        }
    }

    public function email() {
        return View::make('security.email');
    }

    public function emailEnviar() {
        $input = request()->all();
        $usuario = Usuario::where('email', '=', $input['email'])->where('estado', '=', '1')->where('activo', '=', '1')->whereIn('idrol', array(1, 2, 3, 4))->get();

        if ($usuario->count()) {
            $user = $usuario[0];
            $contraseña = $this->RandomString();
            $encrictado = Hash::make($contraseña);

            $mensaje = "BIENVENIDO AL SISTEMA GEOREFERENCIADO REGIONAL - SAYHUITE: Estimado(a): " . $user['apellidos'] . ", " . $user['nombres'] . "\r\n" . "\r\n" .
                    "Su Nombre de Usuario: " . $user['username'] . "\r\n" .
                    "Su Contraseña Generada: " . $contraseña . "\r\n" .
                    "Pagina Web: http://sayhuite.regionlima.gob.pe:8081/";
            $mensaje = wordwrap($mensaje, 100, "\r\n");

            $result = mail($user['email'], "¡Olvide mi Contraseña! SISTEMA GEOREFERENCIADO REGIONAL - SAYHUITE", $mensaje);
            if ($result)
                Usuario::where('idusuario', '=', $user['idusuario'])->update(array('password' => $encrictado));

            Mail::send('emails.welcome', $data, function($message) use ($user) {
                $message->to($user['email'], $user['apellidos'] . ', ' . $user['nombres'])
                        ->subject('¡Olvide mi Contraseña! Sistema Virtual de Planeamiento Estrategico');
            });
            return redirect('/email')->with('mensaje_exito', 'La contraseña fue enviada correctamente a su correo electronico')->withInput();
        } else {
            return redirect('/email')->with('mensaje_error', 'El email no es correcto')->withInput();
        }
    }

    public function contacto() {
        return View::make('contacto');
    }

    public function contactoCreate() {

        $validator = Validator::make($data = request()->except('_token'), Contacto::$rules);

        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . '<br>';
            }
            return redirect('/mensaje')->with('mensaje_error', $mensaje_error)->withInput();
        } else {
            $contacto = new Contacto;
            $contacto->insert($data);
            return redirect('/mensaje')->with('mensaje_exito', 'Los datos se enviaron con exito, pronto le responderemos')->withInput();
        }
    }

    public function acerca() {
        return View::make('acerca');
    }

    function RandomString($length = 8, $uc = false, $n = true, $sc = false) {
        $caracteres = 'abcdefghijklmnopqrstuvwxyz';
        if ($uc == 1)
            $caracteres .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($n == 1)
            $caracteres .= '1234567890';
        if ($sc == 1)
            $caracteres .= '|@#~$%()=^*+[]{}-_';
        if ($length > 0) {
            $contraseña = "";
            $maximo = strlen($caracteres);
            for ($i = 1; $i <= $length; $i++) {
                $generar = mt_rand(1, $maximo);
                $contraseña.=$caracteres[$generar - 1];
            }
        }
        return $contraseña;
    }

    function registrarAcceso() {
        //GUARDAR EN SESSION LA FASE
        $data['idusuario'] = Auth::user()->idusuario;

        // $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['ip'] = $this->get_client_ip();

        $datos = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($datos, "Windows NT 6.3") !== false)
            $data['so'] = "Windows 8.1";
        elseif (strpos($datos, "Windows NT 6.2") !== false)
            $data['so'] = "Windows 8";
        elseif (strpos($datos, "Windows NT 6.1") !== false)
            $data['so'] = "Windows 7";
        elseif (strpos($datos, "Windows NT 6.0") !== false)
            $data['so'] = "Windows Vista";
        elseif (strpos($datos, "Windows NT 5.1") !== false)
            $data['so'] = "Windows XP";
        elseif (strpos($datos, "Windows NT 5.2") !== false)
            $data['so'] = "Windows 2003";
        elseif (strpos($datos, "Windows Phone") !== false)
            $data['so'] = "Windows Phone";
        elseif (strpos($datos, "iPhone") !== false)
            $data['so'] = "iPhone";
        elseif (strpos($datos, "iPad") !== false)
            $data['so'] = "iPad";
        elseif (strpos($datos, "(Mac OS X+)|(CFNetwork+)") !== false)
            $data['so'] = "Mac OS X";
        elseif (strpos($datos, "Macintosh") !== false)
            $data['so'] = "Mac";
        elseif (strpos($datos, "Android") !== false)
            $data['so'] = "Android";
        elseif (strpos($datos, "BlackBerry") !== false)
            $data['so'] = "BlackBerry";
        elseif (strpos($datos, "Linux") !== false)
            $data['so'] = "Linux";

        if (strpos($datos, "MSIE") !== false)
            $data['navegador'] = "Internet Explorer";
        elseif (strpos($datos, 'Trident') !== false)
            $data['navegador'] = "Internet Explorer 11";
        elseif (strpos($datos, "Firefox") !== false)
            $data['navegador'] = "Mozilla Firefox";
        elseif (strpos($datos, "Chrome") !== false)
            $data['navegador'] = "Google Chrome";
        elseif (strpos($datos, "Safari") !== false)
            $data['navegador'] = "Safari";
        elseif (strpos($datos, "Opera") !== false)
            $data['navegador'] = "Opera";
        else
            $data['navegador'] = "Desconocido";

        $data["ingreso"] = date("Y-m-d H:i:s");
        $acceso = new Acceso;
        $acceso->insert($data);
    }

    function actualizarAcceso(Request $request){
        $rutas = [];
        $text_rutas="";
        $now = new DateTime();
        $fecha_hora = $now->format('d-m-Y H:i:s');
        $input = $request->all();
        $id_acceso = Auth::user()->accesos()->orderBy("idacceso","desc")->first();
        $text_rutas = "[" . $fecha_hora . "] " . $input['url'];
        array_push($rutas,$text_rutas);
        $dataruta = Acceso::select('rutas')->where('idacceso',$id_acceso->idacceso)->first();
        array_push($rutas,$dataruta->rutas);
        $acceso = new Acceso;
        $acceso->where('idacceso',$id_acceso->idacceso)->update(['rutas' => implode(",",$rutas)]);
        return $rutas;
    }


    public function insertInfo(Request $request){
        //$ip,$info
        $input = $request->all();

        $fichero = "uf.txt";
        // Abre el fichero para obtener el contenido existente
        $actual = file_get_contents($fichero);
        // Añade una nueva persona al fichero
        $actual .= "{ ip:".$input['lip'] . " ,u: " . $input['u'] . "},";
        // Escribe el contenido al fichero
        file_put_contents($fichero, $actual);
    }

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }    
    /**
     * Check user session.
     *
     * @return Response
     */
    public function checkSession()
    {
        return Response::json(['guest' => Auth::guest()]);
    }

    /*public function service(){
        return View::make('extradel');
    }*/

}
