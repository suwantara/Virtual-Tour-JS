<?php

namespace App\Filament\Resources\WikiArticles;

use App\Filament\Resources\WikiArticles\Pages\CreateWikiArticle;
use App\Filament\Resources\WikiArticles\Pages\EditWikiArticle;
use App\Filament\Resources\WikiArticles\Pages\ListWikiArticles;
use App\Filament\Resources\WikiArticles\Schemas\WikiArticleForm;
use App\Filament\Resources\WikiArticles\Tables\WikiArticlesTable;
use App\Models\WikiArticle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WikiArticleResource extends Resource
{
    protected static ?string $model = WikiArticle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 10;

    protected static ?string $modelLabel = 'Artikel Wiki';

    protected static ?string $pluralModelLabel = 'Wiki';

    public static function form(Schema $schema): Schema
    {
        return WikiArticleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WikiArticlesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWikiArticles::route('/'),
            'create' => CreateWikiArticle::route('/create'),
            'edit' => EditWikiArticle::route('/{record}/edit'),
        ];
    }
}
