<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageReplyAttachment extends Model
{
    protected $fillable = [
        'message_reply_id',
        'original_name',
        'path',
        'mime_type',
        'size',
    ];

    public function reply(): BelongsTo
    {
        return $this->belongsTo(MessageReply::class, 'message_reply_id');
    }
}
