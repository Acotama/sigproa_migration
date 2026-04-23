<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Anulacion extends Model
{
    protected $table = "tb_anulacion";
    protected $primaryKey = 'id_anulacion';

    protected $fillable = [
        'cod_uni',
        'saldo_anulado',
        'n_anulacion',
    ];

    protected $guarded = [
      'id_anulacion',
    ];

    public $timestamps = false;
}
