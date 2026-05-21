<?php

namespace App\Filament\Resources\WikiArticles\Schemas;

use App\Enums\WikiCategory;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class WikiArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Artikel')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
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
                            ->helperText('URL-friendly identifier, otomatis dari judul.'),

                        Select::make('category')
                            ->label('Kategori')
                            ->options(WikiCategory::class)
                            ->required()
                            ->native(false),

                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Urutan tampil dalam kategori (terkecil = pertama).'),

                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Ditampilkan pada kartu di halaman daftar wiki.'),
                    ]),

                Section::make('Konten')
                    ->schema([
                        RichEditor::make('content')
                            ->label('')
                            ->required()
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'link'],
                                ['h2', 'h3'],
                                ['bulletList', 'orderedList', 'blockquote', 'codeBlock'],
                                ['undo', 'redo'],
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Tampilkan di Wiki')
                            ->default(true),
                    ]),
            ]);
    }
}
