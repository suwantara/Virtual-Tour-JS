<?php

namespace App\Filament\Resources\WikiCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WikiCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->color(Color::Gray),

                TextColumn::make('icon')
                    ->label('Ikon')
                    ->color(Color::Gray),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->color(Color::Gray),

                TextColumn::make('articles_count')
                    ->label('Artikel')
                    ->counts('articles')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }
}
