<?php

namespace sayhuite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use sayhuite\Models\Actividad;
use sayhuite\Models\Usuario;

class ActividadController extends Controller
{
    public function getActividadByUsuario($idusuario = null){

    	if($idusuario){

    		$Usuario = Usuario::find($idusuario);

	    	$isAdmin = ($Usuario->hasRole('adminpoi') or $Usuario->hasRole('admin'));

	        $Actividad = Actividad::select('poi_actividad.codigo','poi_actividad.nombre')
	            ->join('poi_producto', 'poi_producto.id','=','poi_actividad.id_poi_producto')
	            ->join('poi_categoria_presupuestal', 'poi_categoria_presupuestal.id','=','poi_producto.id_poi_categoria_presupuestal')
	            ->join('poi_sector', 'poi_sector.id','=','poi_categoria_presupuestal.id_poi_sector');

	        if(!$isAdmin){
	            $userDependencies = $Usuario->unidad()->pluck('idsector')->toArray();
	            
	            $Actividad->whereIn('poi_sector.id',$userDependencies);
	        }

	        //MODAL DROPDOWN
	        $Actividad = $Actividad->pluck('nombre','codigo')->toArray();

	        return $Actividad;
	    }
    }
}
