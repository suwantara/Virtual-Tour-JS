<?php

namespace App\Filament\Resources\WikiArticles\Pages;

use App\Filament\Resources\WikiArticles\WikiArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWikiArticles extends ListRecords
{
    protected static string $resource = WikiArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
