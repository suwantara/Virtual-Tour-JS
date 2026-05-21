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
}
