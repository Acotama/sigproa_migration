<?php

namespace sayhuite;

use Illuminate\Database\Eloquent\Model;

class audits extends Model
{
    protected $table = 'audits';
    protected $fillable = [
        'type',
        'auditable_id',
        'auditable_type',
        'old',
        'new',
        'user_id',
        'route',
        'ip_address',
        'created_at'
    ];

    protected $guarded = [
        'id'
    ];
}
