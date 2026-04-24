<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{

    protected $table = 'grli_pip_cronograma';
    protected $primaryKey = 'id';

    protected $fillable = [
      'data'
    ];

    protected $guarded = [
    	'id'
    ];

    public $timestamps = false;

}
