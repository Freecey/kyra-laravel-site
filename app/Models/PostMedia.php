<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PostMedia extends Model
{
    protected $fillable = [
        'blog_post_id',
        'disk',
        'path',
        'filename',
        'mime_type',
        'size',
        'alt',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function post(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function getUrl(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function deleteFile(): void
    {
        Storage::disk($this->disk)->delete($this->path);
    }
}
