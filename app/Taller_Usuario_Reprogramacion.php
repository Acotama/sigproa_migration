<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Taller_Usuario_Reprogramacion extends Model
{

    protected $table = 'poi_taller_usuario_reprogramacion';
    protected $primaryKey = 'id';
    protected $fillable = [
                    "idtaller",
                    "accion",
                    "observacion",
                    "docente_antes",
                    "docente_despues",
                    "fecha_antes",
                    "fecha_despues",
                    "lugar_antes",
                    "lugar_despues",
                    "id_distrito_antes",
                    "id_distrito_despues",
                    "dni_antes",
                    "dni_despues",
                    "created_at",
                    "updated_at"
            ];


    protected $guarded = ['id'];

    
}
