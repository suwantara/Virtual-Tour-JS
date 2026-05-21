<?php

namespace App\Models;

use App\Observers\SceneObserver;
use Database\Factories\SceneFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(SceneObserver::class)]
#[Fillable(['venue_id', 'name', 'local_name', 'description', 'era', 'ritual_function', 'material', 'image_path', 'audio_path', 'initial_yaw', 'initial_pitch', 'order', 'is_published'])]
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
