<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
	use \OwenIt\Auditing\Auditable;
	protected $table = 'poi_taller';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nombre', 'estado'];
}
