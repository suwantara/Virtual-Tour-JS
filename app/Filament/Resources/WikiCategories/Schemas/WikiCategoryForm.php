<?php

namespace App\Filament\Resources\WikiCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class WikiCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Set $set, ?string $old) {
                                if ($old === null || Str::slug((string) $old) === '') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly identifier, otomatis dari nama.'),

                        TextInput::make('icon')
                            ->label('Ikon (Heroicon)')
                            ->placeholder('heroicon-o-tag')
                            ->maxLength(100)
                            ->helperText('Nama komponen Heroicon, contoh: heroicon-o-book-open')
                            ->columnSpanFull(),

                        TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Kategori dengan angka terkecil ditampilkan pertama.'),
                    ]),
            ]);
    }
}
