<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageNavbar extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-navbar';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3;

    protected static ?string $navigationLabel = 'Navbar';

    protected static ?string $title = 'Navbar';

    protected static ?int $navigationSort = 1;

    public function mount(): void
    {
        $this->form->fill([
            'navbar_site_name_top' => SiteSetting::get('navbar.site_name_top'),
            'navbar_site_name_bottom' => SiteSetting::get('navbar.site_name_bottom'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('navbar_site_name_top')
                    ->label('Nama Situs Baris Atas')
                    ->placeholder('Pura Desa')
                    ->maxLength(100),

                TextInput::make('navbar_site_name_bottom')
                    ->label('Nama Situs Baris Bawah')
                    ->placeholder('Tambawu')
                    ->maxLength(100),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('navbar.site_name_top', $state['navbar_site_name_top'] ?? null);
        SiteSetting::set('navbar.site_name_bottom', $state['navbar_site_name_bottom'] ?? null);

        $this->notifySaved();
    }
}
