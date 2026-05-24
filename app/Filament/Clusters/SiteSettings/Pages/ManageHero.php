<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageHero extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-hero';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Hero';

    protected static ?string $title = 'Hero';

    protected static ?int $navigationSort = 2;

    public function mount(): void
    {
        $this->form->fill([
            'hero_badge_text' => SiteSetting::get('hero.badge_text'),
            'hero_kaligrafi' => SiteSetting::get('hero.kaligrafi'),
            'hero_title_main' => SiteSetting::get('hero.title_main'),
            'hero_title_sub' => SiteSetting::get('hero.title_sub'),
            'hero_subtitle' => SiteSetting::get('hero.subtitle'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hero_badge_text')
                    ->label('Teks Badge')
                    ->placeholder('Digital Heritage · PBL 2025')
                    ->maxLength(255),

                TextInput::make('hero_kaligrafi')
                    ->label('Teks Kaligrafi')
                    ->placeholder('Tri Kahyangan · Desa Adat Tambawu')
                    ->maxLength(255),

                TextInput::make('hero_title_main')
                    ->label('Judul Utama')
                    ->placeholder('Pura Desa')
                    ->maxLength(255),

                TextInput::make('hero_title_sub')
                    ->label('Judul Kedua')
                    ->placeholder('Adat Tambawu')
                    ->maxLength(255),

                Textarea::make('hero_subtitle')
                    ->label('Subtitle / Deskripsi Hero')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('hero.badge_text', $state['hero_badge_text'] ?? null);
        SiteSetting::set('hero.kaligrafi', $state['hero_kaligrafi'] ?? null);
        SiteSetting::set('hero.title_main', $state['hero_title_main'] ?? null);
        SiteSetting::set('hero.title_sub', $state['hero_title_sub'] ?? null);
        SiteSetting::set('hero.subtitle', $state['hero_subtitle'] ?? null);

        $this->notifySaved();
    }
}
