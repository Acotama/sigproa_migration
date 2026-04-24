<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model {

    protected $table = 'acceso';
    protected $primaryKey = 'idacceso';
    protected $fillable = ['idacceso, idusuario, ip, so, navegador, ingreso, salida'];
    public $timestamps = false;
    public static $rules = [
        'idusuario' => 'required|exists:usuario,idUsuario',
        'ip' => 'required',
        'so' => 'required',
        'navegador' => 'required'
    ];

}
