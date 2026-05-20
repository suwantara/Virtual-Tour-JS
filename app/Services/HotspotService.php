<?php

namespace App\Services;

use App\Repositories\HotspotRepository;

class HotspotService
{
    public function __construct(
        private HotspotRepository $hotspots,
    ) {}

    public function totalCount(): int
    {
        return $this->hotspots->totalCount();
    }
}
