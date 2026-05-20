<?php

namespace App\Repositories\Contracts;

use App\Models\Venue;
use Illuminate\Support\Collection;

interface VenueRepositoryInterface
{
    public function allPublished(): Collection;

    public function findById(int $id): ?Venue;

    public function findBySlug(string $slug): ?Venue;

    public function save(array $data): Venue;

    public function update(Venue $venue, array $data): Venue;

    public function delete(Venue $venue): void;

    public function totalCount(): int;

    public function publishedCount(): int;

    public function totalViewCount(): int;
}
