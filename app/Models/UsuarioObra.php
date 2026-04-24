<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioObra extends Model
{    
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grli_pip_usuario_obra';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idusuario',
        'idobra',        
        'estado'
    ];    
}
