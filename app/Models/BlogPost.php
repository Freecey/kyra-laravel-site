<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        return $this->featuredMedia?->getUrl();
    }

    /**
     * Replace [media:ID] tags in content with <img> HTML, then render Markdown.
     */
    public function renderContent(): string
    {
        $mediaMap = $this->media->keyBy('id');

        // 1. Substitute [media:ID] shortcodes with img tags
        $html = preg_replace_callback('/\[media:(\d+)\]/', function (array $matches) use ($mediaMap) {
            $id = (int) $matches[1];
            /** @var PostMedia|null $item */
            $item = $mediaMap->get($id);
            if (!$item) {
                return '';
            }
            $url = e($item->getUrl());
            $alt = e($item->alt ?? $item->filename);
            return '<img src="' . $url . '" alt="' . $alt . '" loading="lazy" class="blog-media">';
        }, $this->content ?? '');

        // 2. Convert Markdown to HTML
        $converter = new \League\CommonMark\CommonMarkConverter([
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter->convert($html)->getContent();
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
