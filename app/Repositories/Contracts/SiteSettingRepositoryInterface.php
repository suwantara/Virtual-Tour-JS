<?php

namespace App\Repositories\Contracts;

interface SiteSettingRepositoryInterface
{
    public function get(string $key, ?string $default = null): ?string;

    /** @param array<mixed> $default */
    public function getJson(string $key, array $default = []): array;
}
