<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageKontak extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-kontak';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Kontak & Footer';

    protected static ?string $title = 'Kontak & Footer';

    protected static ?int $navigationSort = 10;

    public function mount(): void
    {
        $this->form->fill([
            'kontak_section_label' => SiteSetting::get('kontak.section_label'),
            'kontak_section_title' => SiteSetting::get('kontak.section_title'),
            'kontak_items' => SiteSetting::getJson('kontak.items'),
            'footer_venue_text' => SiteSetting::get('footer.venue_text'),
            'footer_copyright' => SiteSetting::get('footer.copyright'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kontak_section_label')
                    ->label('Label Section')
                    ->placeholder('Hubungi Kami')
                    ->maxLength(255),

                TextInput::make('kontak_section_title')
                    ->label('Judul Section')
                    ->placeholder('Kontak')
                    ->maxLength(255),

                Repeater::make('kontak_items')
                    ->label('Item Kontak')
                    ->schema([
                        TextInput::make('label')->label('Label')->required()->maxLength(100),
                        TextInput::make('value')->label('Isi')->required()->maxLength(500),
                    ])
                    ->columns(2)
                    ->addActionLabel('Tambah Kontak')
                    ->columnSpanFull(),

                TextInput::make('footer_venue_text')
                    ->label('Teks Footer Kiri')
                    ->maxLength(255),

                TextInput::make('footer_copyright')
                    ->label('Teks Footer Kanan (Copyright)')
                    ->maxLength(255),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('kontak.section_label', $state['kontak_section_label'] ?? null);
        SiteSetting::set('kontak.section_title', $state['kontak_section_title'] ?? null);
        SiteSetting::setJson('kontak.items', array_values($state['kontak_items'] ?? []));
        SiteSetting::set('footer.venue_text', $state['footer_venue_text'] ?? null);
        SiteSetting::set('footer.copyright', $state['footer_copyright'] ?? null);

        $this->notifySaved();
    }
}
