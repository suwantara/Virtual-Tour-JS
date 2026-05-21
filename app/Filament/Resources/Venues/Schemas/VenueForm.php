<?php

namespace App\Filament\Resources\Venues\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Venue')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Venue')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Set $set, ?string $old) {
                                if ($old === null || Str::slug($old) === '') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly identifier, otomatis dari nama.'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->rows(3),

                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->placeholder('Pilih kategori (opsional)')
                            ->columnSpanFull(),
                    ]),

                Section::make('Media & Status')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('thumbnail_path')
                            ->label('Thumbnail')
                            ->disk('r2')
                            ->directory('venues/thumbnails')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),

                        Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->helperText('Tour bisa dilihat publik jika diaktifkan.'),

                        Select::make('cover_scene_id')
                            ->label('Scene Cover')
                            ->relationship(
                                'coverScene',
                                'name',
                                fn ($query, $record) => $record
                                    ? $query->where('venue_id', $record->id)
                                    : $query->whereRaw('0 = 1'),
                            )
                            ->placeholder('Pilih setelah scene ditambahkan')
                            ->nullable()
                            ->searchable()
                            ->hidden(fn ($record) => $record === null),
                    ]),

                Section::make('Branding')
                    ->description('Kustomisasi tampilan viewer untuk venue ini.')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo Venue')
                            ->disk('r2')
                            ->directory('venues/logos')
                            ->image()
                            ->imageEditor()
                            ->helperText('Tampil di pojok sidebar viewer.'),

                        ColorPicker::make('primary_color')
                            ->label('Warna Utama')
                            ->helperText('Warna aksen sidebar dan tombol aktif.')
                            ->default('#6366f1'),
                    ]),
            ]);
    }
}
