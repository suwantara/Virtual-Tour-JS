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
            'tentangSejarahTitle' => $this->settings->get('tentang_pura.sejarah_title', 'Sejarah & Latar Belakang'),
            'tentangParagraphs' => $this->settings->getJson('tentang_pura.paragraphs'),
            'tentangStats' => $this->settings->getJson('tentang_pura.stats'),
            'tourCtaTitle' => $this->settings->get('tour_cta.title', 'Jelajahi Pura'),
            'tourCtaAccent' => $this->settings->get('tour_cta.title_accent', 'dalam 360°'),
            'tourCtaDescription' => $this->settings->get('tour_cta.description', ''),
            'tourCtaFeatures' => $this->settings->getJson('tour_cta.features'),
            'pelinggihItems' => $this->settings->getJson('pelinggih.items'),
            'mangkuName' => $this->settings->get('mangku.name', 'Jro Made Rena Atmaja'),
            'mangkuMeta' => $this->settings->get('mangku.meta', ''),
            'mangkuQuote' => $this->settings->get('mangku.quote', ''),
            'mangkuBio' => $this->settings->get('mangku.bio', ''),
            'nandikaDescription' => $this->settings->get('nandika.description', ''),
            'nandikaTags' => $this->settings->getJson('nandika.tags'),
            'timMembers' => $this->resolveTimMembers(),
            'dosenName' => $this->settings->get('tim.dosen_name'),
            'dosenNip' => $this->settings->get('tim.dosen_nip'),
            'kontakItems' => $this->settings->getJson('kontak.items'),
            'footerVenue' => $this->settings->get('footer.venue_text', 'Pura Desa Adat Tambawu · Denpasar, Bali'),
            'footerCopy' => $this->settings->get('footer.copyright', 'Nandika PBL 2025 · Kelompok 2 · Hak Cipta Dilindungi'),
            'socials' => $this->buildSocials(),
            'siteDescription' => $heroSubtitle,
            'siteUrl' => url('/'),
            'pageTitle' => 'Virtual Tour — '.$heroTitleMain.' '.$heroTitleSub,
        ];
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
