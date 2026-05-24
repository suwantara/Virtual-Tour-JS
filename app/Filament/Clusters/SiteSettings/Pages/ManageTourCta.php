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

class ManageTourCta extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-tour-cta';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static ?string $navigationLabel = 'Virtual Tour CTA';

    protected static ?string $title = 'Virtual Tour CTA';

    protected static ?int $navigationSort = 4;

    public function mount(): void
    {
        $this->form->fill([
            'tour_cta_section_label' => SiteSetting::get('tour_cta.section_label'),
            'tour_cta_title' => SiteSetting::get('tour_cta.title'),
            'tour_cta_title_accent' => SiteSetting::get('tour_cta.title_accent'),
            'tour_cta_description' => SiteSetting::get('tour_cta.description'),
            'tour_cta_features' => SiteSetting::getJson('tour_cta.features'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tour_cta_section_label')
                    ->label('Label Section')
                    ->placeholder('Eksplorasi Digital')
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('tour_cta_title')
                    ->label('Judul')
                    ->placeholder('Jelajahi Pura')
                    ->maxLength(255),

                TextInput::make('tour_cta_title_accent')
                    ->label('Judul Aksen (warna amber)')
                    ->placeholder('dalam 360°')
                    ->maxLength(255),

                Textarea::make('tour_cta_description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->columnSpanFull(),

                Repeater::make('tour_cta_features')
                    ->label('Fitur / Tag')
                    ->schema([
                        TextInput::make('label')->label('Teks Fitur')->required()->maxLength(100),
                    ])
                    ->addActionLabel('Tambah Fitur')
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('tour_cta.section_label', $state['tour_cta_section_label'] ?? null);
        SiteSetting::set('tour_cta.title', $state['tour_cta_title'] ?? null);
        SiteSetting::set('tour_cta.title_accent', $state['tour_cta_title_accent'] ?? null);
        SiteSetting::set('tour_cta.description', $state['tour_cta_description'] ?? null);
        SiteSetting::setJson('tour_cta.features', array_values($state['tour_cta_features'] ?? []));

        $this->notifySaved();
    }
}
