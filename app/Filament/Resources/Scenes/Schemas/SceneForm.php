<?php

namespace App\Filament\Resources\Scenes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SceneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Scene')
                    ->schema([
                        Select::make('venue_id')
                            ->label('Venue')
                            ->relationship('venue', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        TextInput::make('name')
                            ->label('Nama Scene')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(2),
                    ]),

                Section::make('Foto 360°')
                    ->description('Upload file baru, atau isi path jika foto sudah ada di R2.')
                    ->schema([
                        FileUpload::make('image_upload')
                            ->label('Upload File Baru ke R2')
                            ->disk('r2')
                            ->directory('scenes')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(51200)
                            ->helperText('Format JPG/PNG/WebP equirectangular. Maks. 50MB. Otomatis mengisi Path R2 di bawah.')
                            ->dehydrated(false)
                            ->live()
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $state ? $set('image_path', $state) : null),

                        TextInput::make('image_path')
                            ->label('Path R2')
                            ->placeholder('scenes/nama-file.jpg')
                            ->helperText('Diisi otomatis saat upload. Atau tulis manual jika file sudah ada di R2 (contoh: scenes/gedong-agung.jpg).')
                            ->maxLength(2048),
                    ]),

                Section::make('Pengaturan Kamera')
                    ->description('Posisi awal kamera saat scene dibuka.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('initial_yaw')
                            ->label('Yaw (°)')
                            ->numeric()
                            ->default(0)
                            ->minValue(-180)
                            ->maxValue(180)
                            ->step(0.1),

                        TextInput::make('initial_pitch')
                            ->label('Pitch (°)')
                            ->numeric()
                            ->default(0)
                            ->minValue(-90)
                            ->maxValue(90)
                            ->step(0.1),

                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Tampilkan Scene')
                            ->default(true),
                    ]),
            ]);
    }
}
