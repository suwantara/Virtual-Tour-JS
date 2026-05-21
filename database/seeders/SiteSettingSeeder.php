<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'social.github' => null,
            'social.instagram' => null,
            'social.youtube' => null,
            'social.tiktok' => null,
            'tim.dosen_name' => null,
            'tim.dosen_nip' => null,
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
