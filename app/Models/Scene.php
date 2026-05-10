<?php

namespace App\Models;

use Database\Factories\SceneFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable(['venue_id', 'name', 'description', 'image_path', 'initial_yaw', 'initial_pitch', 'order', 'is_published'])]
class Scene extends Model
{
    /** @use HasFactory<SceneFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'initial_yaw' => 'float',
            'initial_pitch' => 'float',
            'order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image_path
            ? Storage::disk('r2')->url($this->image_path)
            : null
        );
    }

    /** @return BelongsTo<Venue, $this> */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /** @return HasMany<Hotspot, $this> */
    public function hotspots(): HasMany
    {
        return $this->hasMany(Hotspot::class);
    }

    /** @return HasMany<Hotspot, $this> */
    public function incomingLinks(): HasMany
    {
        return $this->hasMany(Hotspot::class, 'target_scene_id');
    }
}
