<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {

    protected $table = 'peru_provincia';
    protected $primaryKey = 'gid';
    protected $fillable = ['gid, nom_prov, cod_prov, cod_dpto'];

}
