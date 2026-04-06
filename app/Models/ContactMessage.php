<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'ip_address',
        'is_read',
        'mail_sent',
    ];

    protected $casts = [
        'is_read'   => 'boolean',
        'mail_sent' => 'boolean',
    ];
}
