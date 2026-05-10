<?php

namespace App\Filament\Resources\Hotspots\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HotspotsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scene.venue.name')
                    ->label('Venue')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('scene.name')
                    ->label('Scene')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('label')
                    ->label('Label')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'scene_link' => Color::Blue,
                        'info' => Color::Amber,
                        'url' => Color::Green,
                        'media' => Color::Purple,
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'scene_link' => 'Navigasi',
                        'info' => 'Info',
                        'url' => 'Link',
                        'media' => 'Media',
                        default => $state,
                    }),

                TextColumn::make('pitch')
                    ->label('Pitch')
                    ->numeric(1)
                    ->suffix('°'),

                TextColumn::make('yaw')
                    ->label('Yaw')
                    ->numeric(1)
                    ->suffix('°'),
            ])
            ->filters([
                SelectFilter::make('scene')
                    ->relationship('scene', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'scene_link' => 'Navigasi',
                        'info' => 'Info',
                        'url' => 'Link',
                        'media' => 'Media',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
