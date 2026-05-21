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

    public function findBySlugForApi(string $slug): ?Venue
    {
        $venue = $this->venues->findBySlug($slug);

        if (! $venue || ! $venue->is_published) {
            return null;
        }

        $venue->loadMissing([
            'category',
            'scenes' => fn ($q) => $q->where('is_published', true)->orderBy('order'),
            'scenes.hotspots',
        ]);

        return $venue;
    }

    public function totalCount(): int
    {
        return $this->venues->totalCount();
    }

    public function publishedCount(): int
    {
        return $this->venues->publishedCount();
    }

    public function totalViewCount(): int
    {
        return $this->venues->totalViewCount();
    }
}
