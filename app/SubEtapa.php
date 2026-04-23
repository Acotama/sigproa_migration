<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class SubEtapa extends Model {

    protected $table = 'grli_sub_etapa';
    protected $primaryKey = 'id';
    protected $fillable = ['id, sub_etapa, etapa'];

}
