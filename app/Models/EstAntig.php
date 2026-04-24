<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class EstAntig extends Model {

    protected $table = 'estado_antiguedad_pry';
    protected $primaryKey = 'id';
    protected $fillable = ['id, estado'];

}
