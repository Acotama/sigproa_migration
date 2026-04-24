<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class ObraEstadoImg extends Model
{
    protected $table = 'grli_obra_estado_img';
    protected $primaryKey = 'id';

    protected $fillable = [    						
							'id_grli_obra_estado',
							'url',
							'nombre',
							'created_at',
							'updated_at',
							'metadata',
							'imghash',
							'estado'
						];

    protected $guarded = ['id'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
