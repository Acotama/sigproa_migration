<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class PipTotalPrioriEstado extends Model
{
  	protected $table = 'grli_pip_total_priori_estado';

  	protected $protected = ['id'];

  	protected $fillable = [
  							'idproyecto',
							'etapa',
							'sub_etapa',
							'est_situ',
							'fecha_act',
							'estado',
							'obs'
						  ];
}
