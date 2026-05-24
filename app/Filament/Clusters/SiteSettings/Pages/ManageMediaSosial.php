<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageMediaSosial extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-media-sosial';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShare;

    protected static ?string $navigationLabel = 'Media Sosial';

    protected static ?string $title = 'Media Sosial';

    protected static ?int $navigationSort = 11;

    public function mount(): void
    {
        $this->form->fill([
            'social_github' => SiteSetting::get('social.github'),
            'social_instagram' => SiteSetting::get('social.instagram'),
            'social_youtube' => SiteSetting::get('social.youtube'),
            'social_tiktok' => SiteSetting::get('social.tiktok'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('social_github')
                    ->label('GitHub')
                    ->placeholder('https://github.com/...')
                    ->url()
                    ->maxLength(2048),

                TextInput::make('social_instagram')
                    ->label('Instagram')
                    ->placeholder('https://instagram.com/...')
                    ->url()
                    ->maxLength(2048),

                TextInput::make('social_youtube')
                    ->label('YouTube')
                    ->placeholder('https://youtube.com/...')
                    ->url()
                    ->maxLength(2048),

                TextInput::make('social_tiktok')
                    ->label('TikTok')
                    ->placeholder('https://tiktok.com/...')
                    ->url()
                    ->maxLength(2048),
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('social.github', $state['social_github'] ?? null);
        SiteSetting::set('social.instagram', $state['social_instagram'] ?? null);
        SiteSetting::set('social.youtube', $state['social_youtube'] ?? null);
        SiteSetting::set('social.tiktok', $state['social_tiktok'] ?? null);

        $this->notifySaved();
    }
}
