<?php

namespace App\Filament\Resources\WikiCategories\Pages;

use App\Filament\Resources\WikiCategories\WikiCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWikiCategory extends CreateRecord
{
    protected static string $resource = WikiCategoryResource::class;
}
