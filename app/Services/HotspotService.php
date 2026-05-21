<?php

namespace App\Services;

use App\Repositories\Contracts\HotspotRepositoryInterface;

class HotspotService
{
    public function __construct(
        private HotspotRepositoryInterface $hotspots,
    ) {}

    public function totalCount(): int
    {
        return $this->hotspots->totalCount();
    }
}
