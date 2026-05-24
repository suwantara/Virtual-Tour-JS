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

class ManageNandika extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-nandika';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'Tentang Nandika';

    protected static ?string $title = 'Tentang Nandika';

    protected static ?int $navigationSort = 8;

    public function mount(): void
    {
        $this->form->fill([
            'nandika_section_label' => SiteSetting::get('nandika.section_label'),
            'nandika_section_title' => SiteSetting::get('nandika.section_title'),
            'nandika_section_accent' => SiteSetting::get('nandika.section_accent'),
            'nandika_description' => SiteSetting::get('nandika.description'),
            'nandika_tags' => SiteSetting::getJson('nandika.tags'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nandika_section_label')
                    ->label('Label Section')
                    ->placeholder('Project Akademik')
                    ->maxLength(255),

                TextInput::make('nandika_section_title')
                    ->label('Judul Section')
                    ->placeholder('Nandika —')
                    ->maxLength(255),

                TextInput::make('nandika_section_accent')
                    ->label('Judul Aksen (warna amber)')
                    ->placeholder('Nusantara Digital Archive')
                    ->maxLength(255),

                Textarea::make('nandika_description')
                    ->label('Deskripsi Proyek')
                    ->rows(4)
                    ->columnSpanFull(),

                Repeater::make('nandika_tags')
                    ->label('Tag Proyek')
                    ->schema([
                        TextInput::make('label')->label('Tag')->required()->maxLength(100),
                    ])
                    ->addActionLabel('Tambah Tag')
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('nandika.section_label', $state['nandika_section_label'] ?? null);
        SiteSetting::set('nandika.section_title', $state['nandika_section_title'] ?? null);
        SiteSetting::set('nandika.section_accent', $state['nandika_section_accent'] ?? null);
        SiteSetting::set('nandika.description', $state['nandika_description'] ?? null);
        SiteSetting::setJson('nandika.tags', array_values($state['nandika_tags'] ?? []));

        $this->notifySaved();
    }
}
