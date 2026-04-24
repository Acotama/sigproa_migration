<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model {

    protected $table = 'peru_distrito_';
    protected $primaryKey = 'gid';
    protected $fillable = ['gid, nom_dist, nom_prov ,cod_dist, cod_prov, cod_dpto'];

}
