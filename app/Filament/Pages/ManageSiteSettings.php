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
            // Navbar
            'navbar_site_name_top' => SiteSetting::get('navbar.site_name_top'),
            'navbar_site_name_bottom' => SiteSetting::get('navbar.site_name_bottom'),

            // Hero
            'hero_badge_text' => SiteSetting::get('hero.badge_text'),
            'hero_kaligrafi' => SiteSetting::get('hero.kaligrafi'),
            'hero_title_main' => SiteSetting::get('hero.title_main'),
            'hero_title_sub' => SiteSetting::get('hero.title_sub'),
            'hero_subtitle' => SiteSetting::get('hero.subtitle'),

            // Tentang Pura
            'tentang_section_label' => SiteSetting::get('tentang_pura.section_label'),
            'tentang_section_title' => SiteSetting::get('tentang_pura.section_title'),
            'tentang_section_ornament' => SiteSetting::get('tentang_pura.section_ornament'),
            'tentang_sejarah_title' => SiteSetting::get('tentang_pura.sejarah_title'),
            'tentang_paragraphs' => SiteSetting::getJson('tentang_pura.paragraphs'),
            'tentang_stats' => SiteSetting::getJson('tentang_pura.stats'),

            // Virtual Tour CTA
            'tour_cta_section_label' => SiteSetting::get('tour_cta.section_label'),
            'tour_cta_title' => SiteSetting::get('tour_cta.title'),
            'tour_cta_title_accent' => SiteSetting::get('tour_cta.title_accent'),
            'tour_cta_description' => SiteSetting::get('tour_cta.description'),
            'tour_cta_features' => SiteSetting::getJson('tour_cta.features'),

            // Pelinggih
            'pelinggih_section_label' => SiteSetting::get('pelinggih.section_label'),
            'pelinggih_section_title' => SiteSetting::get('pelinggih.section_title'),
            'pelinggih_section_description' => SiteSetting::get('pelinggih.section_description'),
            'pelinggih_items' => SiteSetting::getJson('pelinggih.items'),

            // Wiki CTA
            'wiki_cta_label' => SiteSetting::get('wiki_cta.label'),
            'wiki_cta_title' => SiteSetting::get('wiki_cta.title'),
            'wiki_cta_title_accent' => SiteSetting::get('wiki_cta.title_accent'),
            'wiki_cta_description' => SiteSetting::get('wiki_cta.description'),
            'wiki_cta_categories' => SiteSetting::getJson('wiki_cta.categories'),

            // Profil Mangku
            'mangku_section_label' => SiteSetting::get('mangku.section_label'),
            'mangku_avatar_badge' => SiteSetting::get('mangku.avatar_badge'),
            'mangku_avatar' => SiteSetting::get('mangku.avatar'),
            'mangku_name' => SiteSetting::get('mangku.name'),
            'mangku_meta' => SiteSetting::get('mangku.meta'),
            'mangku_quote' => SiteSetting::get('mangku.quote'),
            'mangku_bio' => SiteSetting::get('mangku.bio'),

            // Tentang Nandika
            'nandika_section_label' => SiteSetting::get('nandika.section_label'),
            'nandika_section_title' => SiteSetting::get('nandika.section_title'),
            'nandika_section_accent' => SiteSetting::get('nandika.section_accent'),
            'nandika_description' => SiteSetting::get('nandika.description'),
            'nandika_tags' => SiteSetting::getJson('nandika.tags'),

            // Tim
            'tim_dosen_label' => SiteSetting::get('tim.dosen_label'),
            'tim_section_label' => SiteSetting::get('tim.section_label'),
            'tim_section_title' => SiteSetting::get('tim.section_title'),
            'tim_section_description' => SiteSetting::get('tim.section_description'),
            'tim_members' => SiteSetting::getJson('tim.members'),
            'tim_dosen_photo' => SiteSetting::get('tim.dosen_photo'),
            'tim_dosen_name' => SiteSetting::get('tim.dosen_name'),
            'tim_dosen_nip' => SiteSetting::get('tim.dosen_nip'),

            // Kontak & Footer
            'kontak_section_label' => SiteSetting::get('kontak.section_label'),
            'kontak_section_title' => SiteSetting::get('kontak.section_title'),
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

                Section::make('Navbar')
                    ->description('Teks logo di navbar (muncul di desktop dan mobile).')
                    ->collapsible()
                    ->schema([
                        TextInput::make('navbar_site_name_top')
                            ->label('Nama Situs Baris Atas')
                            ->placeholder('Pura Desa')
                            ->maxLength(100),

                        TextInput::make('navbar_site_name_bottom')
                            ->label('Nama Situs Baris Bawah')
                            ->placeholder('Tambawu')
                            ->maxLength(100),
                    ])
                    ->columns(2),

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
                        TextInput::make('tentang_section_label')
                            ->label('Label Section')
                            ->placeholder('Warisan Budaya')
                            ->maxLength(255),

                        TextInput::make('tentang_section_title')
                            ->label('Judul Section')
                            ->placeholder('Tentang Pura')
                            ->maxLength(255),

                        TextInput::make('tentang_section_ornament')
                            ->label('Teks Ornamen')
                            ->placeholder('Tri Kahyangan · Dewa Brahma')
                            ->maxLength(255)
                            ->columnSpanFull(),

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
                    ->columns(2),

                Section::make('Pelinggih')
                    ->description('Daftar pelinggih yang ditampilkan di halaman utama.')
                    ->collapsible()
                    ->schema([
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
                    ]),

                Section::make('Wiki CTA')
                    ->description('Konten bagian promosi Wiki di halaman utama.')
                    ->collapsible()
                    ->schema([
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
                    ->columns(2),

                Section::make('Profil Mangku')
                    ->description('Informasi Jro Mangku Desa.')
                    ->collapsible()
                    ->schema([
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
                    ->columns(2),

                Section::make('Tentang Nandika')
                    ->description('Deskripsi proyek Nandika dan tag-nya.')
                    ->collapsible()
                    ->schema([
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
                    ]),

                Section::make('Tim Nandika')
                    ->description('Daftar anggota tim dan dosen pembimbing.')
                    ->collapsible()
                    ->schema([
                        TextInput::make('tim_section_label')
                            ->label('Label Section')
                            ->placeholder('Kelompok 2 · PBL 2025')
                            ->maxLength(255),

                        TextInput::make('tim_section_title')
                            ->label('Judul Section')
                            ->placeholder('Tim Nandika')
                            ->maxLength(255),

                        Textarea::make('tim_section_description')
                            ->label('Deskripsi Section')
                            ->rows(3)
                            ->columnSpanFull(),

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

                        TextInput::make('tim_dosen_label')
                            ->label('Label Kartu Dosen')
                            ->placeholder('Dosen Pembimbing')
                            ->maxLength(100),

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

        // Navbar
        SiteSetting::set('navbar.site_name_top', $state['navbar_site_name_top'] ?? null);
        SiteSetting::set('navbar.site_name_bottom', $state['navbar_site_name_bottom'] ?? null);

        // Hero
        SiteSetting::set('hero.badge_text', $state['hero_badge_text'] ?? null);
        SiteSetting::set('hero.kaligrafi', $state['hero_kaligrafi'] ?? null);
        SiteSetting::set('hero.title_main', $state['hero_title_main'] ?? null);
        SiteSetting::set('hero.title_sub', $state['hero_title_sub'] ?? null);
        SiteSetting::set('hero.subtitle', $state['hero_subtitle'] ?? null);

        // Tentang Pura
        SiteSetting::set('tentang_pura.section_label', $state['tentang_section_label'] ?? null);
        SiteSetting::set('tentang_pura.section_title', $state['tentang_section_title'] ?? null);
        SiteSetting::set('tentang_pura.section_ornament', $state['tentang_section_ornament'] ?? null);
        SiteSetting::set('tentang_pura.sejarah_title', $state['tentang_sejarah_title'] ?? null);
        SiteSetting::setJson('tentang_pura.paragraphs', array_values($state['tentang_paragraphs'] ?? []));
        SiteSetting::setJson('tentang_pura.stats', array_values($state['tentang_stats'] ?? []));

        // Virtual Tour CTA
        SiteSetting::set('tour_cta.section_label', $state['tour_cta_section_label'] ?? null);
        SiteSetting::set('tour_cta.title', $state['tour_cta_title'] ?? null);
        SiteSetting::set('tour_cta.title_accent', $state['tour_cta_title_accent'] ?? null);
        SiteSetting::set('tour_cta.description', $state['tour_cta_description'] ?? null);
        SiteSetting::setJson('tour_cta.features', array_values($state['tour_cta_features'] ?? []));

        // Pelinggih
        SiteSetting::set('pelinggih.section_label', $state['pelinggih_section_label'] ?? null);
        SiteSetting::set('pelinggih.section_title', $state['pelinggih_section_title'] ?? null);
        SiteSetting::set('pelinggih.section_description', $state['pelinggih_section_description'] ?? null);
        SiteSetting::setJson('pelinggih.items', array_values($state['pelinggih_items'] ?? []));

        // Wiki CTA
        SiteSetting::set('wiki_cta.label', $state['wiki_cta_label'] ?? null);
        SiteSetting::set('wiki_cta.title', $state['wiki_cta_title'] ?? null);
        SiteSetting::set('wiki_cta.title_accent', $state['wiki_cta_title_accent'] ?? null);
        SiteSetting::set('wiki_cta.description', $state['wiki_cta_description'] ?? null);
        SiteSetting::setJson('wiki_cta.categories', array_values($state['wiki_cta_categories'] ?? []));

        // Profil Mangku
        SiteSetting::set('mangku.section_label', $state['mangku_section_label'] ?? null);
        SiteSetting::set('mangku.avatar_badge', $state['mangku_avatar_badge'] ?? null);
        SiteSetting::set('mangku.avatar', $state['mangku_avatar'] ?? null);
        SiteSetting::set('mangku.name', $state['mangku_name'] ?? null);
        SiteSetting::set('mangku.meta', $state['mangku_meta'] ?? null);
        SiteSetting::set('mangku.quote', $state['mangku_quote'] ?? null);
        SiteSetting::set('mangku.bio', $state['mangku_bio'] ?? null);

        // Tentang Nandika
        SiteSetting::set('nandika.section_label', $state['nandika_section_label'] ?? null);
        SiteSetting::set('nandika.section_title', $state['nandika_section_title'] ?? null);
        SiteSetting::set('nandika.section_accent', $state['nandika_section_accent'] ?? null);
        SiteSetting::set('nandika.description', $state['nandika_description'] ?? null);
        SiteSetting::setJson('nandika.tags', array_values($state['nandika_tags'] ?? []));

        // Tim
        SiteSetting::set('tim.dosen_label', $state['tim_dosen_label'] ?? null);
        SiteSetting::set('tim.section_label', $state['tim_section_label'] ?? null);
        SiteSetting::set('tim.section_title', $state['tim_section_title'] ?? null);
        SiteSetting::set('tim.section_description', $state['tim_section_description'] ?? null);
        SiteSetting::setJson('tim.members', array_values($state['tim_members'] ?? []));
        SiteSetting::set('tim.dosen_photo', $state['tim_dosen_photo'] ?? null);
        SiteSetting::set('tim.dosen_name', $state['tim_dosen_name'] ?? null);
        SiteSetting::set('tim.dosen_nip', $state['tim_dosen_nip'] ?? null);

        // Kontak & Footer
        SiteSetting::set('kontak.section_label', $state['kontak_section_label'] ?? null);
        SiteSetting::set('kontak.section_title', $state['kontak_section_title'] ?? null);
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
