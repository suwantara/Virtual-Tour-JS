<?php

use App\Models\SiteSetting;
use App\Services\SiteSettingService;
use App\Services\StorageService;

use function Pest\Laravel\get;

beforeEach(function (): void {
    SiteSetting::firstOrCreate(['key' => 'hero.title_main'], ['value' => 'Pura Desa']);
    SiteSetting::firstOrCreate(['key' => 'hero.title_sub'], ['value' => 'Adat Tambawu']);
    SiteSetting::firstOrCreate(['key' => 'hero.subtitle'], ['value' => 'Jelajahi warisan budaya']);
});

test('homepage returns 200 and renders hero title', function (): void {
    get(route('home'))
        ->assertOk()
        ->assertSee('Pura Desa')
        ->assertSee('Adat Tambawu');
});

test('homepage uses correct page title meta', function (): void {
    get(route('home'))
        ->assertOk()
        ->assertSee('Virtual Tour — Pura Desa Adat Tambawu');
});

test('SiteSettingService getWelcomePageData returns required keys', function (): void {
    $storageMock = Mockery::mock(StorageService::class);
    $storageMock->shouldReceive('getUrl')->andReturn('https://example.com/photo.jpg');

    $service = app(SiteSettingService::class, ['storage' => $storageMock]);
    $data = $service->getWelcomePageData();

    expect($data)
        ->toHaveKeys([
            'heroTitleMain', 'heroTitleSub', 'heroSubtitle',
            'heroBadge', 'heroKaligrafi',
            'tentangSejarahTitle', 'tentangParagraphs', 'tentangStats',
            'tourCtaTitle', 'tourCtaAccent', 'tourCtaDescription', 'tourCtaFeatures',
            'pelinggihItems',
            'mangkuName', 'mangkuMeta', 'mangkuQuote', 'mangkuBio',
            'nandikaDescription', 'nandikaTags',
            'timMembers', 'dosenName', 'dosenNip',
            'kontakItems', 'footerVenue', 'footerCopy',
            'socials', 'siteDescription', 'siteUrl', 'pageTitle',
        ]);
});

test('SiteSettingService pageTitle is composed from hero title settings', function (): void {
    $service = app(SiteSettingService::class);
    $data = $service->getWelcomePageData();

    expect($data['pageTitle'])->toBe('Virtual Tour — Pura Desa Adat Tambawu');
});
