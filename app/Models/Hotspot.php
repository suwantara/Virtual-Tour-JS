<?php

namespace App\Models;

use Database\Factories\HotspotFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['scene_id', 'type', 'label', 'description', 'pitch', 'yaw', 'target_scene_id', 'url', 'media_url', 'media_type'])]
class Hotspot extends Model
{
    /** @use HasFactory<HotspotFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'pitch' => 'float',
            'yaw' => 'float',
        ];
    }

    /** @return BelongsTo<Scene, $this> */
    public function scene(): BelongsTo
    {
        return $this->belongsTo(Scene::class);
    }

    /** @return BelongsTo<Scene, $this> */
    public function targetScene(): BelongsTo
    {
        return $this->belongsTo(Scene::class, 'target_scene_id');
    }
}
