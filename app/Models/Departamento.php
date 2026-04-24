<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model {

    protected $table = 'peru_departamento';
    protected $primaryKey = 'gid';
    protected $fillable = ['gid, nom_dpto, cod_dpto'];

}
