<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;
use sayhuite\Models\PipTotalPriori;

class ObrasEstado extends Model
{

    public static $auditCustomMessage = '{user.apellidos}, {user.nombre} {auditable_reg.nom_proyec} {elapsed_time}';

    /*public static $auditCustomFields = [
        'title'  => 'The title was defined as "{new.title||getNewTitle}"',
        'ip_address' => 'Registered from the address {ip_address}',
        'publish_date' => [
            'created' => 'Publication date: {new.publish_date}',
            'deleted' => 'Post removed from {new.publish_date}'
        ]
    ];*/

    protected $table = 'grli_obra_estado';
    protected $primaryKey = 'id';

    protected $fillable = [
                            'idobra',
                            'fecha_act',
                            'etapa',
                            'sub_etapa',
                            'est_situ',
                            'a_fisico',
              'estado',
              'obs',
              'tipo_obs'
                        ];

    protected $guarded = ['id'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });

        /*self::created(function($model){
            $Obra = Obras::find($model->idobra);
            PiptotalPriori::updateMasterTB($Obra->idproyecto);
        });

        self::updating(function($model){
            // ... code here
        });

        self::updated(function($model){
            $Obra = Obras::find($model->idobra);
            PiptotalPriori::updateMasterTB($Obra->idproyecto);
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });*/
    }



}
