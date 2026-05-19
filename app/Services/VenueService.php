<?php

namespace App\Services;

use App\Models\Venue;
use App\Repositories\Contracts\VenueRepositoryInterface;
use Illuminate\Support\Collection;

class VenueService
{
    public function __construct(
        private VenueRepositoryInterface $venues,
    ) {}

    public function getPublished(): Collection
    {
        return $this->venues->allPublished();
    }

    public function findBySlug(string $slug): ?Venue
    {
        return $this->venues->findBySlug($slug);
    }
}
