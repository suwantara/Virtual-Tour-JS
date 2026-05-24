<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageTentangPura extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-tentang-pura';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $navigationLabel = 'Tentang Pura';

    protected static ?string $title = 'Tentang Pura';

    protected static ?int $navigationSort = 3;

    public function mount(): void
    {
        $this->form->fill([
            'tentang_section_label' => SiteSetting::get('tentang_pura.section_label'),
            'tentang_section_title' => SiteSetting::get('tentang_pura.section_title'),
            'tentang_section_ornament' => SiteSetting::get('tentang_pura.section_ornament'),
            'tentang_sejarah_title' => SiteSetting::get('tentang_pura.sejarah_title'),
            'tentang_paragraphs' => SiteSetting::getJson('tentang_pura.paragraphs'),
            'tentang_stats' => SiteSetting::getJson('tentang_pura.stats'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tentang_section_label')
                    ->label('Label Section')
                    ->placeholder('Warisan Budaya')
                    ->maxLength(255),

                TextInput::make('tentang_section_title')
                    ->label('Judul Section')
                    ->placeholder('Tentang Pura')
                    ->maxLength(255),

                TextInput::make('tentang_section_ornament')
                    ->label('Teks Ornamen')
                    ->placeholder('Tri Kahyangan · Dewa Brahma')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('tentang_sejarah_title')
                    ->label('Judul Sejarah')
                    ->placeholder('Sejarah & Latar Belakang')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Repeater::make('tentang_paragraphs')
                    ->label('Paragraf Sejarah')
                    ->schema([
                        Textarea::make('text')
                            ->label('Paragraf')
                            ->rows(3)
                            ->helperText('Boleh menggunakan HTML seperti <strong>teks</strong>.')
                            ->required(),
                    ])
                    ->addActionLabel('Tambah Paragraf')
                    ->collapsible()
                    ->columnSpanFull(),

                Repeater::make('tentang_stats')
                    ->label('Statistik / Fakta')
                    ->schema([
                        TextInput::make('value')->label('Nilai')->required()->maxLength(100),
                        TextInput::make('label')->label('Label')->required()->maxLength(100),
                        TextInput::make('desc')->label('Deskripsi')->maxLength(255),
                    ])
                    ->columns(3)
                    ->addActionLabel('Tambah Statistik')
                    ->collapsible()
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('tentang_pura.section_label', $state['tentang_section_label'] ?? null);
        SiteSetting::set('tentang_pura.section_title', $state['tentang_section_title'] ?? null);
        SiteSetting::set('tentang_pura.section_ornament', $state['tentang_section_ornament'] ?? null);
        SiteSetting::set('tentang_pura.sejarah_title', $state['tentang_sejarah_title'] ?? null);
        SiteSetting::setJson('tentang_pura.paragraphs', array_values($state['tentang_paragraphs'] ?? []));
        SiteSetting::setJson('tentang_pura.stats', array_values($state['tentang_stats'] ?? []));

        $this->notifySaved();
    }
}
