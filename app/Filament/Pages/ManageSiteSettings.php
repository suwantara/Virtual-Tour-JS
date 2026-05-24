<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
            // Hero
            'hero_badge_text' => SiteSetting::get('hero.badge_text'),
            'hero_kaligrafi' => SiteSetting::get('hero.kaligrafi'),
            'hero_title_main' => SiteSetting::get('hero.title_main'),
            'hero_title_sub' => SiteSetting::get('hero.title_sub'),
            'hero_subtitle' => SiteSetting::get('hero.subtitle'),

            // Tentang Pura
            'tentang_sejarah_title' => SiteSetting::get('tentang_pura.sejarah_title'),
            'tentang_paragraphs' => SiteSetting::getJson('tentang_pura.paragraphs'),
            'tentang_stats' => SiteSetting::getJson('tentang_pura.stats'),

            // Virtual Tour CTA
            'tour_cta_title' => SiteSetting::get('tour_cta.title'),
            'tour_cta_title_accent' => SiteSetting::get('tour_cta.title_accent'),
            'tour_cta_description' => SiteSetting::get('tour_cta.description'),
            'tour_cta_features' => SiteSetting::getJson('tour_cta.features'),

            // Pelinggih
            'pelinggih_items' => SiteSetting::getJson('pelinggih.items'),

            // Profil Mangku
            'mangku_avatar' => SiteSetting::get('mangku.avatar'),
            'mangku_name' => SiteSetting::get('mangku.name'),
            'mangku_meta' => SiteSetting::get('mangku.meta'),
            'mangku_quote' => SiteSetting::get('mangku.quote'),
            'mangku_bio' => SiteSetting::get('mangku.bio'),

            // Tentang Nandika
            'nandika_description' => SiteSetting::get('nandika.description'),
            'nandika_tags' => SiteSetting::getJson('nandika.tags'),

            // Tim
            'tim_members' => SiteSetting::getJson('tim.members'),
            'tim_dosen_photo' => SiteSetting::get('tim.dosen_photo'),
            'tim_dosen_name' => SiteSetting::get('tim.dosen_name'),
            'tim_dosen_nip' => SiteSetting::get('tim.dosen_nip'),

            // Kontak & Footer
            'kontak_items' => SiteSetting::getJson('kontak.items'),
            'footer_venue_text' => SiteSetting::get('footer.venue_text'),
            'footer_copyright' => SiteSetting::get('footer.copyright'),

            // Media Sosial
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

                Section::make('Hero')
                    ->description('Konten bagian pertama halaman utama.')
                    ->collapsible()
                    ->schema([
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
                    ->columns(2),

                Section::make('Tentang Pura')
                    ->description('Konten bagian sejarah dan statistik pura.')
                    ->collapsible()
                    ->schema([
                        TextInput::make('tentang_sejarah_title')
                            ->label('Judul Sejarah')
                            ->placeholder('Sejarah & Latar Belakang')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Repeater::make('tentang_paragraphs')
                            ->label('Paragraf Sejarah')
                            ->schema([
                                Textarea::make('text')
                                    ->label('Paragraf')
                                    ->rows(3)
                                    ->helperText('Boleh menggunakan HTML seperti <strong>teks</strong>.')
                                    ->required(),
                            ])
                            ->addActionLabel('Tambah Paragraf')
                            ->collapsible()
                            ->columnSpanFull(),

                        Repeater::make('tentang_stats')
                            ->label('Statistik / Fakta')
                            ->schema([
                                TextInput::make('value')->label('Nilai')->required()->maxLength(100),
                                TextInput::make('label')->label('Label')->required()->maxLength(100),
                                TextInput::make('desc')->label('Deskripsi')->maxLength(255),
                            ])
                            ->columns(3)
                            ->addActionLabel('Tambah Statistik')
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Virtual Tour CTA')
                    ->description('Konten bagian ajakan eksplorasi virtual tour.')
                    ->collapsible()
                    ->schema([
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
                    ->columns(2),

                Section::make('Pelinggih')
                    ->description('Daftar pelinggih yang ditampilkan di halaman utama.')
                    ->collapsible()
                    ->schema([
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
                    ]),

                Section::make('Profil Mangku')
                    ->description('Informasi Jro Mangku Desa.')
                    ->collapsible()
                    ->schema([
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
                    ->columns(2),

                Section::make('Tentang Nandika')
                    ->description('Deskripsi proyek Nandika dan tag-nya.')
                    ->collapsible()
                    ->schema([
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
                    ]),

                Section::make('Tim Nandika')
                    ->description('Daftar anggota tim dan dosen pembimbing.')
                    ->collapsible()
                    ->schema([
                        Repeater::make('tim_members')
                            ->label('Anggota Tim')
                            ->schema([
                                FileUpload::make('photo_path')
                                    ->label('Foto Profil')
                                    ->disk('r2')
                                    ->directory('members/avatars')
                                    ->image()
                                    ->maxSize(2048)
                                    ->helperText('JPG/PNG, maks. 2MB. Jika diisi, menggantikan tampilan inisial.')
                                    ->deletable()
                                    ->columnSpanFull(),
                                TextInput::make('nama')->label('Nama Lengkap')->required()->maxLength(255),
                                TextInput::make('nim')->label('NIM')->maxLength(50),
                                TextInput::make('peran')->label('Peran')->maxLength(100),
                                TextInput::make('inisial')->label('Inisial Avatar')->maxLength(5),
                                Select::make('bg')
                                    ->label('Warna Avatar (fallback)')
                                    ->options([
                                        'bg-rose-900' => 'Merah Tua',
                                        'bg-rose-800' => 'Merah',
                                        'bg-amber-900' => 'Amber Tua',
                                        'bg-amber-800' => 'Amber',
                                        'bg-stone-600' => 'Abu-abu',
                                        'bg-indigo-800' => 'Indigo',
                                    ])
                                    ->default('bg-stone-600'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Tambah Anggota')
                            ->collapsible()
                            ->columnSpanFull(),

                        FileUpload::make('tim_dosen_photo')
                            ->label('Foto Dosen Pembimbing')
                            ->disk('r2')
                            ->directory('dosen/avatar')
                            ->image()
                            ->maxSize(2048)
                            ->helperText('JPG/PNG, maks. 2MB. Menggantikan ikon akademik.')
                            ->deletable()
                            ->columnSpanFull(),

                        TextInput::make('tim_dosen_name')
                            ->label('Nama Dosen Pembimbing')
                            ->placeholder('Nama lengkap beserta gelar')
                            ->maxLength(255),

                        TextInput::make('tim_dosen_nip')
                            ->label('NIP Dosen')
                            ->placeholder('contoh: 198501012010121001')
                            ->maxLength(50),
                    ])
                    ->columns(2),

                Section::make('Kontak & Footer')
                    ->description('Informasi kontak dan teks footer.')
                    ->collapsible()
                    ->schema([
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
                    ->columns(2),

                Section::make('Media Sosial')
                    ->description('URL akun media sosial proyek Nandika.')
                    ->collapsible()
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

        // Hero
        SiteSetting::set('hero.badge_text', $state['hero_badge_text'] ?? null);
        SiteSetting::set('hero.kaligrafi', $state['hero_kaligrafi'] ?? null);
        SiteSetting::set('hero.title_main', $state['hero_title_main'] ?? null);
        SiteSetting::set('hero.title_sub', $state['hero_title_sub'] ?? null);
        SiteSetting::set('hero.subtitle', $state['hero_subtitle'] ?? null);

        // Tentang Pura
        SiteSetting::set('tentang_pura.sejarah_title', $state['tentang_sejarah_title'] ?? null);
        SiteSetting::setJson('tentang_pura.paragraphs', array_values($state['tentang_paragraphs'] ?? []));
        SiteSetting::setJson('tentang_pura.stats', array_values($state['tentang_stats'] ?? []));

        // Virtual Tour CTA
        SiteSetting::set('tour_cta.title', $state['tour_cta_title'] ?? null);
        SiteSetting::set('tour_cta.title_accent', $state['tour_cta_title_accent'] ?? null);
        SiteSetting::set('tour_cta.description', $state['tour_cta_description'] ?? null);
        SiteSetting::setJson('tour_cta.features', array_values($state['tour_cta_features'] ?? []));

        // Pelinggih
        SiteSetting::setJson('pelinggih.items', array_values($state['pelinggih_items'] ?? []));

        // Profil Mangku
        SiteSetting::set('mangku.avatar', $state['mangku_avatar'] ?? null);
        SiteSetting::set('mangku.name', $state['mangku_name'] ?? null);
        SiteSetting::set('mangku.meta', $state['mangku_meta'] ?? null);
        SiteSetting::set('mangku.quote', $state['mangku_quote'] ?? null);
        SiteSetting::set('mangku.bio', $state['mangku_bio'] ?? null);

        // Tentang Nandika
        SiteSetting::set('nandika.description', $state['nandika_description'] ?? null);
        SiteSetting::setJson('nandika.tags', array_values($state['nandika_tags'] ?? []));

        // Tim
        SiteSetting::setJson('tim.members', array_values($state['tim_members'] ?? []));
        SiteSetting::set('tim.dosen_photo', $state['tim_dosen_photo'] ?? null);
        SiteSetting::set('tim.dosen_name', $state['tim_dosen_name'] ?? null);
        SiteSetting::set('tim.dosen_nip', $state['tim_dosen_nip'] ?? null);

        // Kontak & Footer
        SiteSetting::setJson('kontak.items', array_values($state['kontak_items'] ?? []));
        SiteSetting::set('footer.venue_text', $state['footer_venue_text'] ?? null);
        SiteSetting::set('footer.copyright', $state['footer_copyright'] ?? null);

        // Media Sosial
        SiteSetting::set('social.github', $state['social_github'] ?? null);
        SiteSetting::set('social.instagram', $state['social_instagram'] ?? null);
        SiteSetting::set('social.youtube', $state['social_youtube'] ?? null);
        SiteSetting::set('social.tiktok', $state['social_tiktok'] ?? null);

        Notification::make()
            ->title('Pengaturan berhasil disimpan.')
            ->success()
            ->send();
    }
}
