<?php

namespace App\Filament\Resources\WikiArticles\Pages;

use App\Filament\Resources\WikiArticles\WikiArticleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWikiArticle extends EditRecord
{
    protected static string $resource = WikiArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
