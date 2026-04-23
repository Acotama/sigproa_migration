<?php

namespace sayhuite;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Usuario extends Authenticatable
{

    //use Notifiable;
    use EntrustUserTrait;


    protected $dontKeepAuditOf = ['_token'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    protected $fillable = [
        'username',
        'password',
        'email',
        'dni',
        'apellidos',
        'nombres',
        'cargo',
        'celular',
        'fecha',
        'activo',
        'estado',
        'poi',
        'intervencion'
    ];
    protected $appends = array('apeNom');
    public $timestamps = false;
    public static $rules = [
        'roles' => 'required',
        'username' => 'required',
        'password' => 'required|min:6',
        // 'email' => 'required|email'
    ];

    public static $rules_update = [
        'roles' => 'required',
        'username' => 'required',
        // 'email' => 'required|email'
    ];

    public static $rulesPerfil = [
        //'password' => 'required|min:6',
        // 'email' => 'required|email'
    ];

    protected $guarded = ['idusuario'];

    public static $rulesRegistro = [
        'roles' => 'required',
        'unidades' => 'required',
        'username' => 'required|unique:usuario,username',
        'password' => 'required|min:6',
        // 'dni' => 'required|max:8',
        // 'email' => 'required|email|unique:usuario,email',
        'apellidos' => 'required',
        'nombres' => 'required',
        // 'poi' => 'required'
    ];

    public function getApeNomAttribute()
    {
        return $this->apellidos . ', ' . $this->nombres;
    }

    public function getUnApeNomAttribute()
    {
        $ap = explode(' ', $this->apellidos);
        $un = $ap[0];
        $nm = explode(' ', $this->nombres);
        $nom = $nm[0];
        return $nom . ' ' . $un;
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->_token;
    }

    public function setRememberToken($value)
    {
        $this->_token = $value;
    }

    public function getRememberTokenName()
    {
        return '_token';
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idrol');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'iddependencia');
    }

    public function accesos()
    {
        return $this->hasMany(Acceso::class, 'idusuario');
    }

    public function unidad()
    {
        return $this->belongsToMany('sayhuite\Dependencia', 'usuario_dependencia', 'idusuario', 'iddependencia');
    }
}
