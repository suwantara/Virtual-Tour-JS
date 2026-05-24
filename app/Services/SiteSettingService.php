<?php

namespace App\Services;

use App\Repositories\Contracts\SiteSettingRepositoryInterface;

class SiteSettingService
{
    public function __construct(
        private SiteSettingRepositoryInterface $settings,
        private StorageService $storage,
    ) {}

    /** @return array<string, mixed> */
    public function getWelcomePageData(): array
    {
        $heroTitleMain = $this->settings->get('hero.title_main', 'Pura Desa');
        $heroTitleSub = $this->settings->get('hero.title_sub', 'Adat Tambawu');
        $heroSubtitle = $this->settings->get('hero.subtitle', 'Jelajahi warisan budaya Desa Adat Tambawu melalui Virtual Tour 360° interaktif.');

        return [
            'heroBadge' => $this->settings->get('hero.badge_text', 'Digital Heritage · Digital Archive · PBL 2025'),
            'heroKaligrafi' => $this->settings->get('hero.kaligrafi', 'Tri Kahyangan · Desa Adat Tambawu'),
            'heroTitleMain' => $heroTitleMain,
            'heroTitleSub' => $heroTitleSub,
            'heroSubtitle' => $heroSubtitle,
            'tentangSectionLabel' => $this->settings->get('tentang_pura.section_label', 'Warisan Budaya'),
            'tentangSectionTitle' => $this->settings->get('tentang_pura.section_title', 'Tentang Pura'),
            'tentangSectionOrnament' => $this->settings->get('tentang_pura.section_ornament', 'Tri Kahyangan · Dewa Brahma'),
            'tentangSejarahTitle' => $this->settings->get('tentang_pura.sejarah_title', 'Sejarah & Latar Belakang'),
            'tentangParagraphs' => $this->settings->getJson('tentang_pura.paragraphs'),
            'tentangStats' => $this->settings->getJson('tentang_pura.stats'),
            'tourCtaSectionLabel' => $this->settings->get('tour_cta.section_label', 'Eksplorasi Digital'),
            'tourCtaTitle' => $this->settings->get('tour_cta.title', 'Jelajahi Pura'),
            'tourCtaAccent' => $this->settings->get('tour_cta.title_accent', 'dalam 360°'),
            'tourCtaDescription' => $this->settings->get('tour_cta.description', ''),
            'tourCtaFeatures' => $this->settings->getJson('tour_cta.features'),
            'pelinggihSectionLabel' => $this->settings->get('pelinggih.section_label', 'Katalog Digital'),
            'pelinggihSectionTitle' => $this->settings->get('pelinggih.section_title', 'Pelinggih Pura'),
            'pelinggihSectionDescription' => $this->settings->get('pelinggih.section_description', 'Setiap bangunan suci memiliki fungsi dan makna spiritual tersendiri. Berikut pelinggih-pelinggih utama yang dapat dijelajahi dalam virtual tour.'),
            'pelinggihItems' => $this->settings->getJson('pelinggih.items'),
            'wikiCtaLabel' => $this->settings->get('wiki_cta.label', 'Ensiklopedia Digital'),
            'wikiCtaTitle' => $this->settings->get('wiki_cta.title', 'Wiki'),
            'wikiCtaAccent' => $this->settings->get('wiki_cta.title_accent', 'Pura Desa Tambawu'),
            'wikiCtaDescription' => $this->settings->get('wiki_cta.description', 'Dokumentasi lengkap tentang sejarah, pelinggih, ritual, tokoh, dan glosarium istilah adat Bali — semua tersedia dalam satu referensi yang mudah dijelajahi.'),
            'wikiCtaCategories' => $this->buildWikiCategories(),
            'mangkuName' => $this->settings->get('mangku.name', 'Jro Made Rena Atmaja'),
            'mangkuMeta' => $this->settings->get('mangku.meta', ''),
            'mangkuQuote' => $this->settings->get('mangku.quote', ''),
            'mangkuBio' => $this->settings->get('mangku.bio', ''),
            'mangkuAvatarUrl' => $this->resolveStorageUrl($this->settings->get('mangku.avatar')),
            'nandikaSectionLabel' => $this->settings->get('nandika.section_label', 'Project Akademik'),
            'nandikaSectionTitle' => $this->settings->get('nandika.section_title', 'Nandika —'),
            'nandikaSectionAccent' => $this->settings->get('nandika.section_accent', 'Nusantara Digital Archive'),
            'nandikaDescription' => $this->settings->get('nandika.description', ''),
            'nandikaTags' => $this->settings->getJson('nandika.tags'),
            'timSectionLabel' => $this->settings->get('tim.section_label', 'Kelompok 2 · PBL 2025'),
            'timSectionTitle' => $this->settings->get('tim.section_title', 'Tim Nandika'),
            'timSectionDescription' => $this->settings->get('tim.section_description', 'Mahasiswa Program Studi Rekam Medis & Informasi Kesehatan yang mengerjakan proyek digitalisasi warisan budaya Pura Desa Adat Tambawu.'),
            'timMembers' => $this->resolveTimMembers(),
            'dosenName' => $this->settings->get('tim.dosen_name'),
            'dosenNip' => $this->settings->get('tim.dosen_nip'),
            'dosenPhotoUrl' => $this->resolveStorageUrl($this->settings->get('tim.dosen_photo')),
            'kontakSectionLabel' => $this->settings->get('kontak.section_label', 'Hubungi Kami'),
            'kontakSectionTitle' => $this->settings->get('kontak.section_title', 'Kontak'),
            'kontakItems' => $this->settings->getJson('kontak.items'),
            'footerVenue' => $this->settings->get('footer.venue_text', 'Pura Desa Adat Tambawu · Denpasar, Bali'),
            'footerCopy' => $this->settings->get('footer.copyright', 'Nandika PBL 2025 · Kelompok 2 · Hak Cipta Dilindungi'),
            'socials' => $this->buildSocials(),
            'siteDescription' => $heroSubtitle,
            'siteUrl' => url('/'),
            'pageTitle' => 'Virtual Tour — '.$heroTitleMain.' '.$heroTitleSub,
        ];
    }

    private function resolveStorageUrl(?string $path): ?string
    {
        return $path ? $this->storage->getUrl($path) : null;
    }

    /** @return array<int, array<string, mixed>> */
    private function resolveTimMembers(): array
    {
        return collect($this->settings->getJson('tim.members'))
            ->map(fn (array $member): array => array_merge($member, [
                'photo_url' => ! empty($member['photo_path'])
                    ? $this->storage->getUrl($member['photo_path'])
                    : null,
            ]))
            ->all();
    }

    /** @return array<int, array<string, string>> */
    private function buildWikiCategories(): array
    {
        $iconMap = [
            'Sejarah' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
            'Pelinggih' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18',
            'Ritual' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z',
            'Tokoh' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
            'Glosarium' => 'M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802',
        ];

        $defaultIcon = $iconMap['Sejarah'];
        $stored = $this->settings->getJson('wiki_cta.categories');

        if (empty($stored)) {
            return array_map(
                fn (string $label): array => ['label' => $label, 'icon' => $iconMap[$label] ?? $defaultIcon],
                array_keys($iconMap)
            );
        }

        return collect($stored)
            ->map(fn (array $cat): array => [
                'label' => $cat['label'],
                'icon' => $iconMap[$cat['label']] ?? $defaultIcon,
            ])
            ->all();
    }

    /** @return array<int, array<string, string>> */
    private function buildSocials(): array
    {
        return [
            ['href' => $this->settings->get('social.github', '#'),    'icon' => 'fa-brands fa-github',    'label' => 'GitHub'],
            ['href' => $this->settings->get('social.instagram', '#'), 'icon' => 'fa-brands fa-instagram', 'label' => 'Instagram'],
            ['href' => $this->settings->get('social.youtube', '#'),   'icon' => 'fa-brands fa-youtube',   'label' => 'YouTube'],
            ['href' => $this->settings->get('social.tiktok', '#'),    'icon' => 'fa-brands fa-tiktok',    'label' => 'TikTok'],
        ];
    }
}
