<?php

namespace App\Models;

use App\Observers\VenueObserver;
use Database\Factories\VenueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[ObservedBy(VenueObserver::class)]
#[Fillable(['category_id', 'name', 'slug', 'description', 'thumbnail_path', 'is_published', 'cover_scene_id', 'primary_color', 'logo_path'])]
class Venue extends Model
{
    /** @use HasFactory<VenueFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Venue $venue) {
            if (empty($venue->slug)) {
                $base = Str::slug($venue->name);
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $venue->slug = $slug;
            }
        });
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return HasMany<Scene, $this> */
    public function scenes(): HasMany
    {
        return $this->hasMany(Scene::class)->orderBy('order');
    }

    /** @return BelongsTo<Scene, $this> */
    public function coverScene(): BelongsTo
    {
        return $this->belongsTo(Scene::class, 'cover_scene_id');
    }
}
