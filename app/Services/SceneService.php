<?php

namespace App\Services;

use App\Models\Venue;
use App\Repositories\Contracts\SceneRepositoryInterface;
use Illuminate\Support\Collection;

class SceneService
{
    public function __construct(
        private SceneRepositoryInterface $scenes,
        private StorageService $storage,
    ) {}

    /**
     * Returns scenes in the format expected by the tour viewer and Alpine.js.
     */
    public function getScenesForViewer(Venue $venue): Collection
    {
        return $this->scenes->getByVenue($venue->id)
            ->map(fn ($scene) => [
                'id' => $scene->id,
                'name' => $scene->name,
                'image_path' => $scene->image_path
                    ? $this->storage->getUrl($scene->image_path)
                    : null,
                'audio_path' => $scene->audio_path
                    ? $this->storage->getUrl($scene->audio_path)
                    : null,
                'initial_yaw' => $scene->initial_yaw,
                'initial_pitch' => $scene->initial_pitch,
                'hotspots' => $scene->hotspots->map(fn ($hs) => [
                    'id' => $hs->id,
                    'type' => $hs->type,
                    'label' => $hs->label,
                    'description' => $hs->description,
                    'pitch' => $hs->pitch,
                    'yaw' => $hs->yaw,
                    'target_scene_id' => $hs->target_scene_id,
                    'url' => $hs->url,
                    'media_url' => $hs->media_url,
                    'media_type' => $hs->media_type,
                ])->values()->all(),
            ]);
    }

    public function totalCount(): int
    {
        return $this->scenes->totalCount();
    }

    public function publishedCount(): int
    {
        return $this->scenes->publishedCount();
    }

    public function getVenueIdByScene(int $sceneId): ?int
    {
        return $this->scenes->getVenueIdByScene($sceneId);
    }

    public function getScenesForVenueSelect(int $venueId, int $excludeSceneId): Collection
    {
        return $this->scenes->getOptionsForVenue($venueId, $excludeSceneId);
    }
}
