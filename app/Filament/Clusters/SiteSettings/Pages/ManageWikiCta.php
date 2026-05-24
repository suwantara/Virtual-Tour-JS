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

class ManageWikiCta extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-wiki-cta';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $navigationLabel = 'Wiki CTA';

    protected static ?string $title = 'Wiki CTA';

    protected static ?int $navigationSort = 6;

    public function mount(): void
    {
        $this->form->fill([
            'wiki_cta_label' => SiteSetting::get('wiki_cta.label'),
            'wiki_cta_title' => SiteSetting::get('wiki_cta.title'),
            'wiki_cta_title_accent' => SiteSetting::get('wiki_cta.title_accent'),
            'wiki_cta_description' => SiteSetting::get('wiki_cta.description'),
            'wiki_cta_categories' => SiteSetting::getJson('wiki_cta.categories'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('wiki_cta_label')
                    ->label('Label Kategori')
                    ->placeholder('Ensiklopedia Digital')
                    ->maxLength(255),

                TextInput::make('wiki_cta_title')
                    ->label('Judul')
                    ->placeholder('Wiki')
                    ->maxLength(255),

                TextInput::make('wiki_cta_title_accent')
                    ->label('Judul Aksen (warna amber)')
                    ->placeholder('Pura Desa Tambawu')
                    ->maxLength(255),

                Textarea::make('wiki_cta_description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),

                Repeater::make('wiki_cta_categories')
                    ->label('Kategori')
                    ->schema([
                        TextInput::make('label')->label('Nama Kategori')->required()->maxLength(100),
                    ])
                    ->addActionLabel('Tambah Kategori')
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('wiki_cta.label', $state['wiki_cta_label'] ?? null);
        SiteSetting::set('wiki_cta.title', $state['wiki_cta_title'] ?? null);
        SiteSetting::set('wiki_cta.title_accent', $state['wiki_cta_title_accent'] ?? null);
        SiteSetting::set('wiki_cta.description', $state['wiki_cta_description'] ?? null);
        SiteSetting::setJson('wiki_cta.categories', array_values($state['wiki_cta_categories'] ?? []));

        $this->notifySaved();
    }
}
