<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function replies(): HasMany
    {
        return $this->hasMany(MessageReply::class)->latest();
    }
}
