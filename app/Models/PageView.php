<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'path',
        'route_name',
        'user_role',
        'ip_hash',
        'viewed_on',
        'device_type',
        'referer_host',
        'session_hash',
    ];

    protected $casts = [
        'viewed_on' => 'date',
    ];
}
