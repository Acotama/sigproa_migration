<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model {

    protected $table = 'dependencia';
    protected $primaryKey = 'iddependencia';
    protected $fillable = ['iddependencia', 'denom', 'sigla', 'estado','sector','idprovincia'];

    public function getDependencia(){
        return $this->denom;
    }
}
