<?php

namespace App\Filament\Widgets;

use App\Services\HotspotService;
use App\Services\SceneService;
use App\Services\VenueService;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $venues = app(VenueService::class);
        $scenes = app(SceneService::class);
        $hotspots = app(HotspotService::class);

        return [
            Stat::make('Total Venue', $venues->totalCount())
                ->description($venues->publishedCount().' dipublikasikan')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('Total Scene', $scenes->totalCount())
                ->description($scenes->publishedCount().' aktif')
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),

            Stat::make('Total Hotspot', $hotspots->totalCount())
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('warning'),

            Stat::make('Total Kunjungan', number_format($venues->totalViewCount()))
                ->description('Kunjungan tour')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
        ];
    }
}
