<?php

namespace App\Filament\Resources\WikiCategories;

use App\Filament\Resources\WikiCategories\Pages\CreateWikiCategory;
use App\Filament\Resources\WikiCategories\Pages\EditWikiCategory;
use App\Filament\Resources\WikiCategories\Pages\ListWikiCategories;
use App\Filament\Resources\WikiCategories\Schemas\WikiCategoryForm;
use App\Filament\Resources\WikiCategories\Tables\WikiCategoriesTable;
use App\Models\WikiCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WikiCategoryResource extends Resource
{
    protected static ?string $model = WikiCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Kategori Wiki';

    protected static ?string $pluralModelLabel = 'Kategori Wiki';

    public static function form(Schema $schema): Schema
    {
        return WikiCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WikiCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWikiCategories::route('/'),
            'create' => CreateWikiCategory::route('/create'),
            'edit' => EditWikiCategory::route('/{record}/edit'),
        ];
    }
}
