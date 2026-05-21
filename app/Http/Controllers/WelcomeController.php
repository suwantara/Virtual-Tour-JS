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
            ['venues' => $this->venues->getPublished()],
        ));
    }
}
