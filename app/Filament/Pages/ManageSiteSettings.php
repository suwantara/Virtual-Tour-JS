<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected string $view = 'filament.pages.manage-site-settings';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?int $navigationSort = 10;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'social_github' => SiteSetting::get('social.github'),
            'social_instagram' => SiteSetting::get('social.instagram'),
            'social_youtube' => SiteSetting::get('social.youtube'),
            'social_tiktok' => SiteSetting::get('social.tiktok'),
            'tim_dosen_name' => SiteSetting::get('tim.dosen_name'),
            'tim_dosen_nip' => SiteSetting::get('tim.dosen_nip'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Media Sosial')
                    ->description('URL akun media sosial proyek Nandika.')
                    ->columns(2)
                    ->schema([
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
                    ]),

                Section::make('Tim Nandika')
                    ->description('Informasi dosen pembimbing untuk ditampilkan di halaman utama.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('tim_dosen_name')
                            ->label('Nama Dosen Pembimbing')
                            ->placeholder('Nama lengkap beserta gelar')
                            ->maxLength(255),

                        TextInput::make('tim_dosen_nip')
                            ->label('NIP Dosen')
                            ->placeholder('contoh: 198501012010121001')
                            ->maxLength(50),
                    ]),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make($this->getFormActions())
                            ->alignment($this->getFormActionsAlignment())
                            ->fullWidth($this->hasFullWidthFormActions())
                            ->sticky($this->areFormActionsSticky()),
                    ]),
            ]);
    }

    /** @return array<Action|ActionGroup> */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('social.github', $state['social_github'] ?? null);
        SiteSetting::set('social.instagram', $state['social_instagram'] ?? null);
        SiteSetting::set('social.youtube', $state['social_youtube'] ?? null);
        SiteSetting::set('social.tiktok', $state['social_tiktok'] ?? null);
        SiteSetting::set('tim.dosen_name', $state['tim_dosen_name'] ?? null);
        SiteSetting::set('tim.dosen_nip', $state['tim_dosen_nip'] ?? null);

        Notification::make()
            ->title('Pengaturan berhasil disimpan.')
            ->success()
            ->send();
    }
}
