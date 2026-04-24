<?php

namespace sayhuite\Models;

use Illuminate\Database\Eloquent\Model;

class Obras extends Model
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


    public static function boot() {
        parent::boot();

        static::saving(function($model){
            foreach ($model->attributes as $key => $value) {
                if($value !== 0) {
                    $model->{$key} = empty($value) ? null : $value;
                }
            }
        });
    }


    protected $table = 'grli_obra';
    protected $primaryKey = 'id';

    protected $fillable = [
            'idproyecto',
      'u_ejec',
            'nro_meta',
            'nom_meta',
            'anio_ejec',
            'mod_ejec',
            'f_adjudicacion',
      'n_contrato',
            'f_contrato',
            'f_inicio',
            'f_termino',
      'res_exp_tec',
            't_ejec_dias',
            'f_reinicio',
            'f_termino_nueva',
            'f_inaug',
      'estado',
      'm_exp_tec',
      'm_ejecucion',
      'm_vreferencial',
      'tipo',
      'meta',
      'm_supervision'
    ];

    protected $guarded = [
            'id'
    ];

    public $timestamps = false;

    public static $rules = [
        //'u_ejec'   => 'required|string',
        'tipo' => 'required',
        'nro_meta' => 'required|numeric',
        'nom_meta' => 'required|string',
        'anio_ejec' => 'nullable',
        'mod_ejec' => 'nullable|string',
        'f_adjudicacion' => 'nullable|date',
        'n_contrato'=> 'nullable|string',
        'f_contrato' => 'nullable|date',
        'f_inicio' => 'nullable|date',
        'f_termino' => 'nullable|date',
        't_ejec_dia' => 'nullable|date',
        'f_reinicio' => 'nullable|date',
        'f_termino_nueva' => 'nullable|date',
        //'f_inaug' => 'nullable|date',

        //Obra Estado
        'fecha_act' => 'required|date',
        'etapa'     => 'required',
        'sub_etapa' => 'required',
        'est_situ'  => 'required',
        'a_fisico'  => 'nullable'
    ];

    public static $rules_NoMeta = [
        //'u_ejec'   => 'required|string',
        'tipo' => 'required',
        'anio_ejec' => 'nullable',
        'mod_ejec' => 'nullable|string',
        'f_adjudicacion' => 'nullable|date',
        'n_contrato'=> 'nullable|string',
        'f_contrato' => 'nullable|date',
        'f_inicio' => 'nullable|date',
        'f_termino' => 'nullable|date',
        't_ejec_dia' => 'nullable|date',
        'f_reinicio' => 'nullable|date',
        'f_termino_nueva' => 'nullable|date',
        'f_inaug' => 'nullable|date',

        //Obra Estado
        'fecha_act' => 'required|date',
        'etapa'     => 'required',
        'sub_etapa' => 'required',
        'est_situ'  => 'required',
        'a_fisico'  => 'nullable'
    ];

    public static $rules_otros = [
        //'u_ejec'   => 'required|string',
        'tipo' => 'required',
        'nom_meta' => 'required|string',
        'anio_ejec' => 'nullable',
        'mod_ejec' => 'nullable|string',
        'f_adjudicacion' => 'nullable|date',
        'n_contrato'=> 'nullable|string',
        'f_contrato' => 'nullable|date',
        'f_inicio' => 'nullable|date',
        'f_termino' => 'nullable|date',
        't_ejec_dia' => 'nullable|date',
        'f_reinicio' => 'nullable|date',
        'f_termino_nueva' => 'nullable|date',
        //'f_inaug' => 'nullable|date',

        //Obra Estado
        'fecha_act' => 'required|date',
        'etapa'     => 'required',
        'sub_etapa' => 'required',
        'est_situ'  => 'required',
        'a_fisico'  => 'nullable'
    ];
}
