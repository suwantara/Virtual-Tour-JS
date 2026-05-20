<?php

namespace App\Filament\Resources\Scenes\Pages;

use App\Filament\Resources\Scenes\SceneResource;
use Filament\Resources\Pages\CreateRecord;

class CreateScene extends CreateRecord
{
    protected static string $resource = SceneResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['image_upload'])) {
            $data['image_path'] = $data['image_upload'];
        }
        unset($data['image_upload']);

        return $data;
    }
}
