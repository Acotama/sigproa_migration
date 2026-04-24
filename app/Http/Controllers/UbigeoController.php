<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use sayhuite\Models\Distrito;
use DB;
use sayhuite\Models\Usuario;

class UbigeoController extends Controller
{
    public function listDistritoByName(){
    	$input = request()->all();

    	$str = '%' . $input['q'] . '%';


//	    $isAdmin = ($Usuario->hasRole('adminpoi') or $Usuario->hasRole('admin'));


    	$Distritos = Distrito::select(['gid',DB::raw('nom_dist|| \'-\' || nom_prov as distrito')])
    				->where('nom_dist','ilike',$str);

    	/*if( isset($input['u']) ){    		
    		$idUsuario = $input['u'];    		
    		$aUsuario = Usuario::find($idUsuario);

    		if ( $aUsuario->poi == 1 and !$aUsuario->hasRole('adminpoi') ) {
    			$Usuario = Usuario::select('dependencia.denom','usuario.idusuario')
	    						->join('usuario_dependencia','usuario_dependencia.idusuario','=','usuario.idusuario')
	    						->join('dependencia','usuario_dependencia.iddependencia','=','dependencia.iddependencia')
	    						->where('usuario.idusuario', $idUsuario)->first();
	    		
				$provincia = explode('-', $Usuario->denom)[1];				
				

				$Distritos = $Distritos->where('nom_prov', 'ilike', '%'.trim($provincia).'%');
    		}

	    	
    	}*/

    	$Distritos = $Distritos->pluck('distrito','gid')->toArray();

    	return Response($Distritos);
    }
}
