<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class UsuarioObra extends Model
{    
    use \OwenIt\Auditing\Auditable;
    
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
