<?php

namespace App\Filament\Resources\Scenes;

use App\Filament\Resources\Scenes\Pages\CreateScene;
use App\Filament\Resources\Scenes\Pages\EditScene;
use App\Filament\Resources\Scenes\Pages\ListScenes;
use App\Filament\Resources\Scenes\Schemas\SceneForm;
use App\Filament\Resources\Scenes\Tables\ScenesTable;
use App\Models\Scene;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SceneResource extends Resource
{
    protected static ?string $model = Scene::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static \UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Scene';

    protected static ?string $pluralModelLabel = 'Scenes';

    public static function form(Schema $schema): Schema
    {
        return SceneForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScenesTable::configure($table);
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
            'index' => ListScenes::route('/'),
            'create' => CreateScene::route('/create'),
            'edit' => EditScene::route('/{record}/edit'),
        ];
    }
}
