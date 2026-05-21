<?php

namespace App\Repositories\Contracts;

use App\Models\Hotspot;
use Illuminate\Support\Collection;

interface HotspotRepositoryInterface
{
    public function getByScene(int $sceneId): Collection;

    public function findById(int $id): ?Hotspot;

    public function save(array $data): Hotspot;

    public function update(Hotspot $hotspot, array $data): Hotspot;

    public function delete(Hotspot $hotspot): void;

    public function totalCount(): int;
}
