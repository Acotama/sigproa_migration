<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_anu_cred extends Model
{
    protected $table = "tb_detalle_anu_cred";
    protected $primaryKey = 'id_detalle';

    protected $fillable = [
        'id_anulacion',
        'id_credito',
        'id_documento',
        'grupo',
    ];

    protected $guarded = [
      'id_detalle',
    ];

    public $timestamps = false;
}
