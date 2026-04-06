<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'label', 'type', 'description'];

    /**
     * Get a setting value by key, with optional fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        // Cache plain arrays only — never Eloquent objects (causes unserialize failures)
        $cached = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            $setting = static::where('key', $key)->first();
            if ($setting === null) {
                return null;
            }
            return ['value' => $setting->value, 'type' => $setting->type];
        });

        if ($cached === null) {
            return $default;
        }

        if ($cached['type'] === 'boolean') {
            return filter_var($cached['value'], FILTER_VALIDATE_BOOLEAN);
        }

        return $cached['value'] ?? $default;
    }

    /**
     * Set a setting value and clear cache.
     */
    public static function set(string $key, mixed $value): void
    {
        static::where('key', $key)->update(['value' => $value]);
        Cache::forget("setting_{$key}");
    }
}
