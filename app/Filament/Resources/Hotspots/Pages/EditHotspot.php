<?php

namespace App\Filament\Resources\Hotspots\Pages;

use App\Filament\Resources\Hotspots\HotspotResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHotspot extends EditRecord
{
    protected static string $resource = HotspotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
