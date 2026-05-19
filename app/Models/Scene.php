<?php

namespace App\Models;

use Database\Factories\SceneFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
