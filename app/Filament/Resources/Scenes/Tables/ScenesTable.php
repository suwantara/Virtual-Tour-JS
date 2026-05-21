<?php

namespace App\Filament\Resources\Scenes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ScenesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('venue.name')
                    ->label('Venue')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Scene')
                    ->description(fn ($record) => $record->local_name)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->badge()
                    ->color(Color::Gray),

                TextColumn::make('hotspots_count')
                    ->label('Hotspot')
                    ->counts('hotspots')
                    ->badge()
                    ->color(Color::Amber),

                IconColumn::make('is_published')
                    ->label('Tampil')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('venue')
                    ->relationship('venue', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_published')->label('Status Tampil'),
            ])
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
