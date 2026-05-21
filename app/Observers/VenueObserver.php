<?php

namespace App\Observers;

use App\Models\Venue;
use App\Services\StorageService;

class VenueObserver
{
    /**
     * Delete scenes via Eloquent before the DB cascade fires,
     * so SceneObserver can clean up each scene's R2 file.
     */
    public function deleting(Venue $venue): void
    {
        $venue->scenes->each->delete();
    }

    public function deleted(Venue $venue): void
    {
        $storage = app(StorageService::class);

        if ($venue->thumbnail_path) {
            $storage->delete($venue->thumbnail_path);
        }

        if ($venue->logo_path) {
            $storage->delete($venue->logo_path);
        }
    }
}
