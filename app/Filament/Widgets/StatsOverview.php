<?php

namespace App\Filament\Widgets;

use App\Models\Hotspot;
use App\Models\Scene;
use App\Models\Venue;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Venue', Venue::count())
                ->description(Venue::where('is_published', true)->count().' dipublikasikan')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('Total Scene', Scene::count())
                ->description(Scene::where('is_published', true)->count().' aktif')
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),

            Stat::make('Total Hotspot', Hotspot::count())
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('warning'),

            Stat::make('Total Kunjungan', number_format(Venue::sum('view_count')))
                ->description('Kunjungan tour')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
        ];
    }
}
