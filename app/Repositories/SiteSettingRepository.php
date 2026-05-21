<?php

namespace App\Repositories;

use App\Models\SiteSetting;
use App\Repositories\Contracts\SiteSettingRepositoryInterface;

class SiteSettingRepository implements SiteSettingRepositoryInterface
{
    public function get(string $key, ?string $default = null): ?string
    {
        return SiteSetting::get($key, $default);
    }

    /** @param array<mixed> $default */
    public function getJson(string $key, array $default = []): array
    {
        return SiteSetting::getJson($key, $default);
    }
}
