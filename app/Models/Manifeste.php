<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Manifeste extends Model
{
    protected $fillable = [
        'quote',
        'body',
        'is_pinned',
        'sort_order',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('is_pinned')->orderBy('sort_order')->orderByDesc('id');
    }
}
