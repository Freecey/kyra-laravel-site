<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'published_at',
        'featured_media_id',
        'author_id',
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class, 'blog_post_id')->latest();
    }

    public function featuredMedia(): BelongsTo
    {
        return $this->belongsTo(PostMedia::class, 'featured_media_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->orderByDesc('published_at');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function getFeaturedImageUrl(): ?string
    {
        if ($this->featuredMedia) {
            return Storage::disk('public')->url($this->featuredMedia->path);
        }
        return null;
    }

    /**
     * Replace [media:ID] tags in content with <img> HTML.
     */
    public function renderContent(): string
    {
        $mediaMap = $this->media->keyBy('id');

        return preg_replace_callback('/\[media:(\d+)\]/', function (array $matches) use ($mediaMap) {
            $id = (int) $matches[1];
            /** @var PostMedia|null $item */
            $item = $mediaMap->get($id);
            if (!$item) {
                return '';
            }
            $url = Storage::disk('public')->url($item->path);
            $alt = e($item->alt ?? $item->filename);
            return '<img src="' . e($url) . '" alt="' . $alt . '" loading="lazy" class="blog-media">';
        }, $this->content ?? '');
    }

    /**
     * Auto-generate a unique slug from a title.
     */
    public static function generateSlug(string $title, ?int $exceptId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
