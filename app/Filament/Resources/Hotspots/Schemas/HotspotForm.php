<?php

namespace App\Filament\Resources\Hotspots\Schemas;

use App\Models\Scene;
use App\Services\SceneService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HotspotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lokasi Hotspot')
                    ->columns(2)
                    ->schema([
                        Select::make('scene_id')
                            ->label('Scene')
                            ->relationship('scene', 'name', fn ($query) => $query->with('venue'))
                            ->getOptionLabelFromRecordUsing(fn (Scene $record) => "{$record->venue->name} › {$record->name}")
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),

                        Select::make('type')
                            ->label('Tipe Hotspot')
                            ->options([
                                'scene_link' => 'Navigasi ke Scene Lain',
                                'info' => 'Informasi / Popup',
                                'url' => 'Link Eksternal',
                                'media' => 'Media (Video/Audio/Gambar)',
                            ])
                            ->required()
                            ->live(),
                    ]),

                Section::make('Detail Hotspot')
                    ->columns(2)
                    ->schema([
                        TextInput::make('label')
                            ->label('Label')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->rows(2),
                    ]),

                Section::make('Posisi')
                    ->description('Koordinat sudut pandang dalam scene 360°. Pitch: -90° (bawah) hingga 90° (atas). Yaw: -180° hingga 180°.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('pitch')
                            ->label('Pitch (°)')
                            ->numeric()
                            ->default(0)
                            ->minValue(-90)
                            ->maxValue(90)
                            ->step(0.1)
                            ->helperText('Vertikal: negatif = bawah, positif = atas.'),

                        TextInput::make('yaw')
                            ->label('Yaw (°)')
                            ->numeric()
                            ->default(0)
                            ->minValue(-180)
                            ->maxValue(180)
                            ->step(0.1)
                            ->helperText('Horizontal: 0° = depan, ±180° = belakang.'),
                    ]),

                Section::make('Target Scene')
                    ->visible(fn ($get) => $get('type') === 'scene_link')
                    ->schema([
                        Select::make('target_scene_id')
                            ->label('Scene Tujuan')
                            ->helperText('Hanya menampilkan scene dari venue yang sama.')
                            ->options(function ($get) {
                                $sceneId = $get('scene_id');
                                if (! $sceneId) {
                                    return [];
                                }

                                $service = app(SceneService::class);
                                $venueId = $service->getVenueIdByScene((int) $sceneId);

                                if (! $venueId) {
                                    return [];
                                }

                                return $service->getScenesForVenueSelect($venueId, (int) $sceneId);
                            })
                            ->searchable()
                            ->nullable(),
                    ]),

                Section::make('Link Eksternal')
                    ->visible(fn ($get) => $get('type') === 'url')
                    ->schema([
                        TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->placeholder('https://')
                            ->maxLength(2048),
                    ]),

                Section::make('Media')
                    ->visible(fn ($get) => $get('type') === 'media')
                    ->columns(2)
                    ->schema([
                        TextInput::make('media_url')
                            ->label('URL Media')
                            ->url()
                            ->placeholder('https://')
                            ->maxLength(2048),

                        Select::make('media_type')
                            ->label('Tipe Media')
                            ->options([
                                'video' => 'Video',
                                'audio' => 'Audio',
                                'image' => 'Gambar',
                            ]),
                    ]),
            ]);
    }
}
