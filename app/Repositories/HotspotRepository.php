<?php

namespace App\Repositories;

use App\Models\Hotspot;
use App\Repositories\Contracts\HotspotRepositoryInterface;
use Illuminate\Support\Collection;

class HotspotRepository implements HotspotRepositoryInterface
{
    public function getByScene(int $sceneId): Collection
    {
        return Hotspot::where('scene_id', $sceneId)->get();
    }

    public function findById(int $id): ?Hotspot
    {
        return Hotspot::find($id);
    }

    public function save(array $data): Hotspot
    {
        return Hotspot::create($data);
    }

    public function update(Hotspot $hotspot, array $data): Hotspot
    {
        $hotspot->update($data);

        return $hotspot->fresh();
    }

    public function delete(Hotspot $hotspot): void
    {
        $hotspot->delete();
    }

    public function totalCount(): int
    {
        return Hotspot::count();
    }
}
