<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class ActaSeguimiento extends Model
{
    protected $table = 'acta_acuerdo';
    protected $primaryKey = 'id_acta';
    protected $fillable = [
        'cod_unif',
        'nombre',
        'anio',
        'problematica',
        'agenda',
        'otros_acuerdos',
        'num_acta'
     ];   
    protected $guarded = [        
        'id_acta'
    ];     
    public $timestamps = false;
}
