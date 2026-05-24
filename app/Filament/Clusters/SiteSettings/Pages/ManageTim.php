<?php

namespace App\Filament\Clusters\SiteSettings\Pages;

use App\Filament\Clusters\SiteSettings\SiteSettingPage;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageTim extends SiteSettingPage
{
    protected string $view = 'filament.clusters.site-settings.pages.manage-tim';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Tim Nandika';

    protected static ?string $title = 'Tim Nandika';

    protected static ?int $navigationSort = 9;

    public function mount(): void
    {
        $this->form->fill([
            'tim_section_label' => SiteSetting::get('tim.section_label'),
            'tim_section_title' => SiteSetting::get('tim.section_title'),
            'tim_section_description' => SiteSetting::get('tim.section_description'),
            'tim_members' => SiteSetting::getJson('tim.members'),
            'tim_dosen_photo' => SiteSetting::get('tim.dosen_photo'),
            'tim_dosen_label' => SiteSetting::get('tim.dosen_label'),
            'tim_dosen_name' => SiteSetting::get('tim.dosen_name'),
            'tim_dosen_nip' => SiteSetting::get('tim.dosen_nip'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->columns(2)
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::set('tim.section_label', $state['tim_section_label'] ?? null);
        SiteSetting::set('tim.section_title', $state['tim_section_title'] ?? null);
        SiteSetting::set('tim.section_description', $state['tim_section_description'] ?? null);
        SiteSetting::setJson('tim.members', array_values($state['tim_members'] ?? []));
        SiteSetting::set('tim.dosen_photo', $state['tim_dosen_photo'] ?? null);
        SiteSetting::set('tim.dosen_label', $state['tim_dosen_label'] ?? null);
        SiteSetting::set('tim.dosen_name', $state['tim_dosen_name'] ?? null);
        SiteSetting::set('tim.dosen_nip', $state['tim_dosen_nip'] ?? null);

        $this->notifySaved();
    }
}
