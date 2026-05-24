<?php

namespace App\Http\Controllers;

use App\Services\SiteSettingService;
use App\Services\VenueService;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __construct(
        private SiteSettingService $siteSettings,
        private VenueService $venues,
    ) {}

    public function __invoke(): View
    {
        return view('welcome', array_merge(
            $this->siteSettings->getWelcomePageData(),
            [
                'venues' => $this->venues->getPublished(),
                'virtualTourDots' => $this->computeCircleDots([0, 60, 120, 180, 240, 300], 120),
                'wikiOrbitDots' => $this->computeCircleDots([0, 72, 144, 216, 288], 108),
            ],
        ));
    }

    /**
     * @param  int[]  $degrees
     * @return array<int, array{top: float, left: float}>
     */
    private function computeCircleDots(array $degrees, float $radius): array
    {
        return array_map(
            fn (int $deg): array => [
                'top' => round(sin(deg2rad($deg)) * $radius, 2),
                'left' => round(cos(deg2rad($deg)) * $radius, 2),
            ],
            $degrees,
        );
    }
}
