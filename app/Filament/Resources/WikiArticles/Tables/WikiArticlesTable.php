<?php

namespace App\Filament\Resources\WikiArticles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WikiArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(60),

                TextColumn::make('wikiCategory.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable()
                    ->color(Color::Gray),

                ToggleColumn::make('is_published')
                    ->label('Publik')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('wiki_category_id')
                    ->label('Kategori')
                    ->relationship('wikiCategory', 'name'),

                SelectFilter::make('is_published')
                    ->label('Status')
                    ->options([
                        '1' => 'Publik',
                        '0' => 'Draft',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->with('wikiCategory')->orderBy('wiki_category_id')->orderBy('order'));
    }
}
