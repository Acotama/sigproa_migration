<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $table = "tb_credito";
    protected $primaryKey = 'id_credito';

    protected $fillable = [
        'cod_uni',
        'credito',
        'n_credito',
        'saldo_balance',
        'saldo_balance_informacion',
    ];

    protected $guarded = [
      'id_credito',
    ];

    public $timestamps = false;
}
