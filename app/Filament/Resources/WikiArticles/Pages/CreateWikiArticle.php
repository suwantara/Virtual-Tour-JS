<?php

namespace App\Filament\Resources\WikiArticles\Pages;

use App\Filament\Resources\WikiArticles\WikiArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWikiArticle extends CreateRecord
{
    protected static string $resource = WikiArticleResource::class;
}
