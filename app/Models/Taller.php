<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
	protected $table = 'poi_taller';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nombre', 'estado'];
}
