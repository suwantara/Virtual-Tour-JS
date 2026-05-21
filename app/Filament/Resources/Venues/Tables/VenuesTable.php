<?php

namespace App\Filament\Resources\Venues\Tables;

use App\Models\Venue;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class VenuesTable
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
                    ->searchable()
                    ->color(Color::Gray),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color(Color::Violet)
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('scenes_count')
                    ->label('Scene')
                    ->counts('scenes')
                    ->badge()
                    ->color(Color::Blue),

                TextColumn::make('view_count')
                    ->label('Kunjungan')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(Color::Emerald),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_published')->label('Status Publikasi'),
            ])
            ->recordActions([
                Action::make('togglePublish')
                    ->label(fn (Venue $record) => $record->is_published ? 'Unpublish' : 'Publish')
                    ->icon(fn (Venue $record) => $record->is_published ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (Venue $record) => $record->is_published ? Color::Orange : Color::Green)
                    ->action(fn (Venue $record) => $record->update(['is_published' => ! $record->is_published])),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
