<?php

namespace App\Repositories;

use App\Models\Venue;
use App\Repositories\Contracts\VenueRepositoryInterface;
use Illuminate\Support\Collection;

class VenueRepository implements VenueRepositoryInterface
{
    public function allPublished(): Collection
    {
        return Venue::where('is_published', true)
            ->with('category')
            ->withCount('scenes')
            ->orderByDesc('created_at')
            ->get();
    }

    public function findById(int $id): ?Venue
    {
        return Venue::find($id);
    }

    public function findBySlug(string $slug): ?Venue
    {
        return Venue::where('slug', $slug)->first();
    }

    public function save(array $data): Venue
    {
        return Venue::create($data);
    }

    public function update(Venue $venue, array $data): Venue
    {
        $venue->update($data);

        return $venue->fresh();
    }

    public function delete(Venue $venue): void
    {
        $venue->delete();
    }

    public function totalCount(): int
    {
        return Venue::count();
    }

    public function publishedCount(): int
    {
        return Venue::where('is_published', true)->count();
    }

    public function totalViewCount(): int
    {
        return (int) Venue::sum('view_count');
    }
}
