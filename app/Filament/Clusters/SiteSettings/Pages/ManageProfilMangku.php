<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageProfilMangku extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-profil-mangku';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Profil Mangku';

    protected static ?string $title = 'Profil Mangku';

    protected static ?int $navigationSort = 7;

    public function mount(): void
    {
        $this->form->fill([
            'mangku_section_label' => SiteSetting::get('mangku.section_label'),
            'mangku_avatar_badge' => SiteSetting::get('mangku.avatar_badge'),
            'mangku_avatar' => SiteSetting::get('mangku.avatar'),
            'mangku_name' => SiteSetting::get('mangku.name'),
            'mangku_meta' => SiteSetting::get('mangku.meta'),
            'mangku_quote' => SiteSetting::get('mangku.quote'),
            'mangku_bio' => SiteSetting::get('mangku.bio'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('mangku_section_label')
                    ->label('Label Section')
                    ->placeholder('Pengempon Pura')
                    ->maxLength(255),

                TextInput::make('mangku_avatar_badge')
                    ->label('Teks Badge Avatar')
                    ->placeholder('Jro Mangku Desa')
                    ->maxLength(100),

                FileUpload::make('mangku_avatar')
                    ->label('Foto Avatar')
                    ->disk('r2')
                    ->directory('mangku/avatar')
                    ->image()
                    ->maxSize(2048)
                    ->helperText('JPG/PNG, maks. 2MB. Menggantikan placeholder lingkaran.')
                    ->deletable()
                    ->columnSpanFull(),

                TextInput::make('mangku_name')
                    ->label('Nama Lengkap')
                    ->maxLength(255),

                TextInput::make('mangku_meta')
                    ->label('Keterangan Singkat')
                    ->placeholder('Lahir 1951 · Mangku Desa sejak 1993')
                    ->maxLength(255),

                Textarea::make('mangku_quote')
                    ->label('Kutipan')
                    ->rows(3)
                    ->columnSpanFull(),

                Textarea::make('mangku_bio')
                    ->label('Biografi Singkat')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('mangku.section_label', $state['mangku_section_label'] ?? null);
        SiteSetting::set('mangku.avatar_badge', $state['mangku_avatar_badge'] ?? null);
        SiteSetting::set('mangku.avatar', $state['mangku_avatar'] ?? null);
        SiteSetting::set('mangku.name', $state['mangku_name'] ?? null);
        SiteSetting::set('mangku.meta', $state['mangku_meta'] ?? null);
        SiteSetting::set('mangku.quote', $state['mangku_quote'] ?? null);
        SiteSetting::set('mangku.bio', $state['mangku_bio'] ?? null);

        $this->notifySaved();
    }
}
