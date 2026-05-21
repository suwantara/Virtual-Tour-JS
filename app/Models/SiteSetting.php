<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value'])]
class SiteSetting extends Model
{
    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("site_setting:{$key}", function () use ($key, $default): ?string {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        Cache::forget("site_setting:{$key}");
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /** @param array<mixed> $default */
    public static function getJson(string $key, array $default = []): array
    {
        $value = static::get($key);
        if (! $value) {
            return $default;
        }

        return json_decode($value, true) ?? $default;
    }

    /** @param array<mixed> $value */
    public static function setJson(string $key, array $value): void
    {
        static::set($key, json_encode($value, JSON_UNESCAPED_UNICODE));
    }
}
