<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class ActaAcuerdoSeguimiento extends Model
{
    protected $table = 'acta_acuerdo_detalle';
    protected $primaryKey = 'id_acuerdo';
    protected $fillable = [
        'id_acta',
        'acuerdo',
        'entregable',
        'responsable',
        'fecha_entrega',
        'estado'
     ];   
    protected $guarded = [        
        'id_acuerdo'
    ];     
    public $timestamps = false;
}
