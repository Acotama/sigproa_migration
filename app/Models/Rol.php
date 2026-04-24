<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model {

    protected $table = 'rol';
    protected $primaryKey = 'idrol';
    protected $fillable = ['idrol, denom, prioridad, estado'];

}
