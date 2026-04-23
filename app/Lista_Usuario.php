<?php

namespace sayhuite;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Lista_Usuario extends Authenticatable {

    //use Notifiable;
    use EntrustUserTrait;


    protected $dontKeepAuditOf = ['_token'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lista_usuario';
    protected $primaryKey = 'idusuario';
    protected $fillable = [
        'idusuario',    
        'poi',
        'display_name',
        'denom',
        'username',
        'apellidos',
        'nombres',
        'activo',
        'dni'
    ];

    protected $appends = array('apeNom');
    protected $guarded = ['idusuario'];

    public function getApeNomAttribute() {
        return $this->apellidos . ', ' . $this->nombres;
    }

    public function getUnApeNomAttribute() {
    $ap = explode(' ',$this->apellidos);
    $un = $ap[0];
    $nm = explode(' ', $this->nombres);
    $nom = $nm[0];
    return $nom . ' ' . $un;
    }



}
