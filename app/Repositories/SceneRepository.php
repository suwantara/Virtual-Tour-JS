<?php

namespace App\Repositories;

use App\Models\Scene;
use App\Repositories\Contracts\SceneRepositoryInterface;
use Illuminate\Support\Collection;

class SceneRepository implements SceneRepositoryInterface
{
    public function getByVenue(int $venueId): Collection
    {
        return Scene::where('venue_id', $venueId)
            ->where('is_published', true)
            ->with('hotspots')
            ->orderBy('order')
            ->get();
    }

    public function findById(int $id): ?Scene
    {
        return Scene::find($id);
    }

    public function save(array $data): Scene
    {
        return Scene::create($data);
    }

    public function update(Scene $scene, array $data): Scene
    {
        $scene->update($data);

        return $scene->fresh();
    }

    public function delete(Scene $scene): void
    {
        $scene->delete();
    }

    public function updateOrder(array $orderedIds): void
    {
        foreach ($orderedIds as $order => $id) {
            Scene::where('id', $id)->update(['order' => $order]);
        }
    }

    public function totalCount(): int
    {
        return Scene::count();
    }

    public function publishedCount(): int
    {
        return Scene::where('is_published', true)->count();
    }

    public function getVenueIdByScene(int $sceneId): ?int
    {
        return Scene::where('id', $sceneId)->value('venue_id');
    }

    public function getOptionsForVenue(int $venueId, int $excludeSceneId): Collection
    {
        return Scene::where('venue_id', $venueId)
            ->where('id', '!=', $excludeSceneId)
            ->orderBy('order')
            ->pluck('name', 'id');
    }
}
