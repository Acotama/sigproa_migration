<?php

namespace sayhuite\Http\Controllers;

use sayhuite\Models\Usuario;
use sayhuite\Models\Role;
use sayhuite\Models\Dependencia;
use sayhuite\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use sayhuite\Models\Lista_Usuario;

class UsuarioController extends Controller {

    protected $controlador = "usuario";

    public function filterData(Request $request){

        $input = $request->all();

        mb_internal_encoding('UTF8');
        if (isset($input['id'])) {
            $User = Lista_Usuario::where('poi','=',$input['id']);
              if (isset($input['rol']) || !empty($input['rol'])) {
                $User->where('display_name','=',$input['rol']);
              }
        }else {
          $User = Lista_Usuario::select();
            if (isset($input['rol']) || !empty($input['rol'])) {
              $User->where('display_name','=',$input['rol']);
            }
        }

        $recordsTotal = $User->get()->count();

        if(!empty($input['search']['value'])){
            $ss = '%'. ($input['search']['value']) .'%';
            $User = $User->whereRaw("( COALESCE(nombres, '') || COALESCE(apellidos,'') || COALESCE(username,'') || COALESCE(dni,'') ) ilike ?",$ss);
        }

        $order = $input['order'][0];
        $oColumn = $order['column'];
        $oType   = $order['dir'];

        $recordsFiltered = $User->get()->count();
        if($input['columns'][$oColumn]['name'] != 'accion') {
            $User = $User->orderBy($input['columns'][$oColumn]['name'], "$oType");
        }
        $start   =  $input['start'];
        $length  =  $input['length'];
        $User  = $User->skip($start)->take($length)->get();

        return Response([
            'data' => $User,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered
        ]);
    }

    public function clasificacion_filtro($id)
    {
      if ($id != 2) {
        $rol = Lista_Usuario::select("display_name")->where('poi','=',$id)->distinct()->pluck('display_name','display_name')->toArray();;
      }else {
        $rol = Lista_Usuario::select("display_name")->pluck('display_name','display_name')->toArray();;
      }
      return Response($rol);
    }

    public function index() {
      $User = Usuario::select([
          DB::raw("case when    poi='0' and name in ('admin','pp-051','pp-068','pp-090','pp-106') then 'ADMINISTRADOR'
          when  (select count(*) from role_user where role_user.user_id=usuario.idusuario) >1  then 'Varios'
          else display_name  end display_name")
      ])
      ->join('role_user','usuario.idusuario','=','role_user.user_id')
      ->join('roles','role_user.role_id','=','roles.id')
      ->where('estado','=',1)->distinct()->get();

      return View::make($this->controlador . '.index',['user' =>$User]);
    }

    //Ventana crear
    public function create() {

        $unidad = Dependencia::where('estado', '=', 1)->pluck('denom', 'iddependencia')->toArray();
        $roles = Role::pluck('display_name','id');

        return View::make($this->controlador . '.create', compact('unidadCombo', 'roles','unidad'));
    }

    //insertar datos
    public function store() {
        if(count(request()->get('unidades'))<=0){
            return back()->with('mensaje_error', 'Seleccione al menos una gerencia o dirección')->withInput();
        }
        $validator = Validator::make($data = request()->except('_token'), Usuario::$rulesRegistro);

        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . '<br>';
            }
            return back()->with('mensaje_error', $mensaje_error)->withInput();
        } else {
            $data = request()->except('_token','roles','unidades');
            if (strlen($data['password']) >= 6) {
                $data['password'] = Hash::make($data['password']);
                $usuario = new Usuario();

                $usuario->fill($data);
                $usuario->save();
                //$userID = $usuario->insertGetId($data,'idusuario');
                //$user = Usuario::create($data);

                //$user = User::create($loginuserdata);
                //$insertedId = $user->id;

                foreach (request()->get('roles') as $key => $value) {
                    //DB::table('role_user')->insert(['user_id'=>$usuario->id,'role_id'=>$value]);
                    $usuario->attachRole($value);
                }
                foreach (request()->get('unidades') as $key => $value) {
                    //DB::table('usuario_dependencia')->insert(['idusuario'=>$usuario->id,'iddependencia'=>$value]);
                    $usuario->unidad()->attach($value);
                }
                //if ($data['activo'])
                    //$this->correo($data);
                return redirect($this->controlador)->with('mensaje_exito', 'Los datos se guardaron correctamente');
            } else {
                return back()->with('mensaje_error', 'La contraseña debe tener al menos 6 dígitos');
            }
        }
    }

    public function store_actividad() {
        if(count(request()->get('unidades'))<=0){
          return Response(['error'  => true,'msj' => 'Seleccione al menos una gerencia o dirección'],400);
        }
        $validator = Validator::make($data = request()->except('_token'), Usuario::$rulesRegistro);
        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . '<br>';
            }
            return Response(['error'  => true,'msj' => $mensaje_error],400);
        } else {
            $data = request()->except('_token','roles','unidades');
            if (strlen($data['password']) >= 6) {
                $data['password'] = Hash::make($data['password']);
                $usuario = new Usuario();
                $usuario->fill($data);
                $usuario->save();
                foreach (request()->get('roles') as $key => $value) {
                    $usuario->attachRole($value);
                }
                foreach (request()->get('unidades') as $key => $value) {
                    $usuario->unidad()->attach($value);
                }
                return Response(['error' => false,'dni' => $data['dni']],200);
            } else {
                return Response(['error'  => true,'msj' => 'La contraseña debe tener al menos 6 dígitos'],400);
            }
        }
    }

    //ventana mostar
    public function show($id) {

    }

    //ventana editar
    public function edit($id) {
        //$idrol = Auth::user()->idrol;
        /*if ($idrol == 1) {
            $unidad = Dependencia::where('estado', '=', 1)->pluck('denom', 'iddependencia')->toArray();
            $unidadCombo = [0 => "-- Seleccione una Dependencia --"] + $unidad;

            $rol = Rol::where('estado', '=', 1)->pluck('denom', 'idrol')->toArray();
            $rolCombo = [0 => "-- Seleccione un Rol --"] + $rol;
        } elseif ($idrol == 2) {
            $unidad = Dependencia::where('iddependencia', '=', Auth::user()->iddependencia)->pluck('denom', 'iddependencia');
            $unidadCombo = [0 => "-- Seleccione una Dependencia --"] + $unidad;

            $rol = Rol::whereIn('idrol', array(2, 3, 4))->pluck('denom', 'idrol');
            $rolCombo = [0 => "-- Seleccione un Rol --"] + $rol;
        }*/

        $unidad = Dependencia::where('estado', '=', 1)->pluck('denom', 'iddependencia')->toArray();
        //$unidadCombo = [0 => "-- Seleccione una Dependencia --"] + $unidad;
        //dd($unidad);
        $data = Usuario::find($id);
        
        $userUnidad = $data->unidad->pluck('iddependencia')->toArray();
     
        $roles = Role::pluck('display_name','id');
        $userRole = $data->roles->pluck('id','id')->toArray();

        //dd($userRole);

        if ($data['activo']) {
            $data['activado'] = 'btn-success Active';
            $data['desactivado'] = 'btn-default notActive';
        } else {
            $data['activado'] = 'btn-default notActive';
            $data['desactivado'] = 'btn-danger Active';
        }

        return View::make($this->controlador . '.edit', compact('data', 'roles','userRole','unidad','userUnidad'));
    }

    //actualizar datos
    public function update($id) {
        //dd(count(request()->get('roles')));
        if(count(request()->get('unidades'))<=0){
            return back()->with('mensaje_error', 'Seleccione al menos una gerencia o Dirección')->withInput();
        }
        
        $validator = Validator::make($data = request()->except('_token'), Usuario::$rules_update);

        if ($validator->fails()) {
            $mensaje_error = '';
            $mensajes = $validator->messages();
            foreach ($mensajes->all() as $mensaje) {
                $mensaje_error = $mensaje_error . $mensaje . '<br>';
            }
            return back()->with('mensaje_error', $mensaje_error)->withInput();
        } else {

                $user = Usuario::find($id);
                //dd($data);
                $data = request()->except('_token','roles','unidades','password');
                $user->fill(request()->except('password'));
                $user->save();
                //Usuario::where('idusuario', $id)->update($data);
                DB::table('role_user')->where('user_id',$id)->delete();
                foreach (request()->get('roles') as $key => $value) {
                    $user->attachRole($value);
                }

                DB::table('usuario_dependencia')->where('idusuario',$id)->delete();
                foreach (request()->get('unidades') as $key => $val) {
                    $user->unidad()->attach($val);
                }


            //if ($data['activo'] && !$user['activo'])
                    //$this->correo($data);
                return redirect($this->controlador)->with('mensaje_exito', 'Los datos se actualizaron correctamente');
        }
    }

    //eliminar datos
    public function destroy($id) {
        $data['estado'] = 0;
        Usuario::where('idusuario', $id)->update($data);
    }

    private function correo($user) {
        $mensaje = "BIENVENIDO A MIPLAN 2021: " . $user['apellidos'] . ", " . $user['nombres'] . "\r\n" . "\r\n" .
                "Gracias por registrarte. Haz clic en el siguiente enlace para ingresar a su cuenta." . "\r\n" .
                "Su Nombre de Usuario: " . $user['userName'] . "\r\n" .
                "Ingrese a la Pagina Web: www.planregionlima.com/miplan2021" . "\r\n" . "\r\n" .
                "Por favor, guarda este correo. Si no puedes ingresar a tu cuenta en el futuro, este correo nos permitirá ayudarte a restaurar el acceso a tu cuenta. " . "\r\n" .
                "Consultas y sugerencias con el Ing. César Moreno al correo electronico: cesarmv0604@gmail.com";
        $mensaje = wordwrap($mensaje, 100, "\r\n");
        mail($user['email'], "¡Usuario Activado! MIPLAN 2021 - Gobierno Regional de Lima", $mensaje);
    }


    public function getInspectorbyNomOrDNI(Request $request){
        $input = $request->all();

        $param = $input['txtEncargado'];

        $Usuario = Usuario::where("dni",$param)->first();

        return Response(["data" => $Usuario,
                         "found" => $Usuario ? true:false ]);
    }
}
