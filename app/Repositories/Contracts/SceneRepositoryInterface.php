<?php

namespace App\Repositories\Contracts;

use App\Models\Scene;
use Illuminate\Support\Collection;

interface SceneRepositoryInterface
{
    public function getByVenue(int $venueId): Collection;

    public function findById(int $id): ?Scene;

    public function save(array $data): Scene;

    public function update(Scene $scene, array $data): Scene;

    public function delete(Scene $scene): void;

    public function updateOrder(array $orderedIds): void;
}
