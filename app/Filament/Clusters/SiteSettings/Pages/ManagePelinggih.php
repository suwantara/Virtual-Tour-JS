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

class ManagePelinggih extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-pelinggih';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $navigationLabel = 'Pelinggih';

    protected static ?string $title = 'Pelinggih';

    protected static ?int $navigationSort = 5;

    public function mount(): void
    {
        $this->form->fill([
            'pelinggih_section_label' => SiteSetting::get('pelinggih.section_label'),
            'pelinggih_section_title' => SiteSetting::get('pelinggih.section_title'),
            'pelinggih_section_description' => SiteSetting::get('pelinggih.section_description'),
            'pelinggih_items' => SiteSetting::getJson('pelinggih.items'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pelinggih_section_label')
                    ->label('Label Section')
                    ->placeholder('Katalog Digital')
                    ->maxLength(255),

                TextInput::make('pelinggih_section_title')
                    ->label('Judul Section')
                    ->placeholder('Pelinggih Pura')
                    ->maxLength(255),

                Textarea::make('pelinggih_section_description')
                    ->label('Deskripsi Section')
                    ->rows(3)
                    ->columnSpanFull(),

                Repeater::make('pelinggih_items')
                    ->label('Daftar Pelinggih')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Pelinggih')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('fungsi')
                            ->label('Fungsi / Deskripsi')
                            ->rows(3)
                            ->required(),
                    ])
                    ->addActionLabel('Tambah Pelinggih')
                    ->collapsible()
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('pelinggih.section_label', $state['pelinggih_section_label'] ?? null);
        SiteSetting::set('pelinggih.section_title', $state['pelinggih_section_title'] ?? null);
        SiteSetting::set('pelinggih.section_description', $state['pelinggih_section_description'] ?? null);
        SiteSetting::setJson('pelinggih.items', array_values($state['pelinggih_items'] ?? []));

        $this->notifySaved();
    }
}
