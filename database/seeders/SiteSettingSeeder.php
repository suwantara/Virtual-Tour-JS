<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $strings = [
            'social.github' => null,
            'social.instagram' => null,
            'social.youtube' => null,
            'social.tiktok' => null,
            'tim.dosen_name' => null,
            'tim.dosen_nip' => null,

            'hero.badge_text' => 'Digital Heritage · Digital Archive · PBL 2025',
            'hero.kaligrafi' => 'Tri Kahyangan · Desa Adat Tambawu',
            'hero.title_main' => 'Pura Desa',
            'hero.title_sub' => 'Adat Tambawu',
            'hero.subtitle' => 'Jelajahi warisan budaya Desa Adat Tambawu, Denpasar melalui Virtual Tour 360° interaktif. Setiap sudut pura tersimpan dalam arsip digital yang awet dan berkelanjutan.',

            'tentang_pura.sejarah_title' => 'Sejarah & Latar Belakang',

            'mangku.name' => 'Jro Made Rena Atmaja',
            'mangku.meta' => 'Lahir 1951 · Mangku Desa sejak 1993',
            'mangku.quote' => 'Menjadi Mangku itu tidak mengenal istilah pensiun. Jika seseorang sudah terpilih menjadi Mangku di Khayangan Tiga, ia melakukan kewajibannya dengan tulus ikhlas hingga akhir hayat.',
            'mangku.bio' => 'Beliau telah mengabdi sebagai Jro Mangku Desa selama lebih dari tiga dekade, bahkan sejak masih aktif berdinas di pemerintahan. Peran Mangku Desa bersifat permanen dan hanya dapat diwakilkan oleh Mangku pembantu (pengayah) dalam kondisi tertentu.',

            'nandika.description' => 'Website ini merupakan luaran dari mata kuliah Project Based Learning (PBL) program studi Rekam Medis & Informasi Kesehatan — Kelompok 2. Proyek Nandika berfokus pada pengalih-mediaan warisan budaya lokal ke dalam arsip digital yang awet dan berkelanjutan, dengan menyerahkan seluruh aset digital kepada pihak Desa Adat Tambawu.',

            'tour_cta.title' => 'Jelajahi Pura',
            'tour_cta.title_accent' => 'dalam 360°',
            'tour_cta.description' => 'Memanfaatkan teknologi fotografi panorama sferis, setiap sudut Pura Desa Adat Tambawu kini dapat dijelajahi secara interaktif. Pindah antar bangunan, klik hotspot untuk membaca keterangan, dan rasakan keagungan pura dari mana saja.',

            'footer.venue_text' => 'Pura Desa Adat Tambawu · Denpasar, Bali',
            'footer.copyright' => 'Nandika PBL 2025 · Kelompok 2 · Hak Cipta Dilindungi',
        ];

        foreach ($strings as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        $jsons = [
            'tentang_pura.paragraphs' => [
                ['text' => 'Pura Desa Adat Tambawu merupakan salah satu elemen penting dalam sistem <strong class="text-stone-900">Tri Kahyangan</strong> yang menjadi landasan kehidupan spiritual masyarakat Desa Adat Tambawu, Kota Denpasar. Sebagai tempat pemujaan <strong class="text-stone-900">Dewa Brahma</strong>, pura ini berperan sebagai pusat pelaksanaan ritual bersama dan perekat identitas budaya komunitas adat setempat.'],
                ['text' => 'Berdasarkan penuturan Jro Mangku Desa, berdirinya Pura Desa Adat Tambawu tidak diketahui secara pasti. Desa Adat Tambawu termasuk dalam <strong class="text-stone-900">desa tua</strong> yang merupakan gabungan antardesa di kawasan Penatih, sehingga disebut Penatih Kidul (Selatan).'],
                ['text' => 'Catatan kecil yang tersimpan menyebutkan adanya penataan pelinggih pada <strong class="text-stone-900">dekade 1940-an</strong> atas perintah raja, ketika struktur pura mulai berkembang dari satu pelinggih menjadi tatanan yang lebih lengkap seperti saat ini.'],
                ['text' => 'Piodalan utama atau <strong class="text-stone-900">Pujawali</strong> dilaksanakan pada <strong class="text-stone-900">Saniscara Kliwon Kuningan</strong> (Hari Raya Kuningan).'],
            ],

            'tentang_pura.stats' => [
                ['value' => '13',       'label' => 'Pelinggih',             'desc' => 'Bangunan suci dalam kompleks pura'],
                ['value' => 'Kuningan', 'label' => 'Hari Pujawali',         'desc' => 'Saniscara Kliwon Kuningan'],
                ['value' => '1993',     'label' => 'Mangku Desa Bertugas',  'desc' => 'Jro Made Rena Atmaja · hingga saat ini'],
                ['value' => 'Desa Tua', 'label' => 'Status Desa Adat',      'desc' => 'Salah satu desa adat tertua di Penatih'],
            ],

            'tour_cta.features' => [
                ['label' => 'Foto 360° Spherical'],
                ['label' => '13 Titik Hotspot'],
                ['label' => 'Legenda Pelinggih'],
                ['label' => 'Akses Publik'],
            ],

            'pelinggih.items' => [
                ['nama' => 'Gedong Agung',         'fungsi' => 'Tempat linggih Ida Bhatara Pura Desa dengan berbagai pratimanya. Diumpamakan sebagai rumah yang besar, suci, dan merupakan pusat pelinggih.'],
                ['nama' => 'Bale Agung',            'fungsi' => 'Tempat berstananya Ida Bhatara. Setiap ada upacara, di sinilah para Sesuhunan berada. Pusat dari segala proses upacara.'],
                ['nama' => 'Ratu Anglurah Agung',   'fungsi' => 'Tempat Ida dalam menjaga pura. Semua yang masuk ke pura harus melewati beliau — bagaikan ajudan pribadi yang menyambut dan melindungi.'],
                ['nama' => 'Pelinggih Dewi Sedana', 'fungsi' => 'Tempat pemujaan kepada Dewi Kesuburan dalam menunjang dan melimpahkan berkah kehidupan bagi masyarakat adat.'],
                ['nama' => 'Bale Paruman',          'fungsi' => 'Tempat para pendamping (pengabih) yang dikenal dengan premas berkumpul ketika proses upacara berlangsung.'],
                ['nama' => 'Begawan Penyarikan',    'fungsi' => 'Tempat berstananya Ida dalam mengatur dan mencatat kehidupan bermasyarakat. Dipohon restu untuk kelancaran setiap kegiatan.'],
            ],

            'nandika.tags' => [
                ['label' => 'Virtual Tour 360°'],
                ['label' => 'Metadata Dublin Core'],
                ['label' => 'Arsip Digital'],
                ['label' => 'Kontribusi Sosial'],
            ],

            'tim.members' => [
                ['nama' => 'Dewa Gede Kertayoga',          'nim' => '2403020101', 'peran' => 'Project Manager',     'inisial' => 'DGK', 'bg' => 'bg-rose-900'],
                ['nama' => 'I Gusti Ayu Linda Intan Dewi', 'nim' => '2403020103', 'peran' => 'Data Acquisition',    'inisial' => 'LI',  'bg' => 'bg-amber-800'],
                ['nama' => 'I Made Rai Gangga Putra',      'nim' => '2403020105', 'peran' => 'Metadata Specialist', 'inisial' => 'RG',  'bg' => 'bg-stone-600'],
                ['nama' => 'I Wayan Suwantara Putra',      'nim' => '2403020111', 'peran' => 'Digital Curator',     'inisial' => 'SW',  'bg' => 'bg-rose-800'],
                ['nama' => 'I Made Bagus Weda Semara',     'nim' => '2403020114', 'peran' => 'Public Relations',    'inisial' => 'BW',  'bg' => 'bg-amber-900'],
            ],

            'kontak.items' => [
                ['label' => 'Lokasi',   'value' => 'Desa Adat Tambawu, Penatih, Denpasar Timur, Bali'],
                ['label' => 'Piodalan', 'value' => 'Saniscara Kliwon Kuningan (Hari Raya Kuningan)'],
                ['label' => 'Proyek',   'value' => 'PBL Nandika · Kelompok 2 · 2025'],
            ],
        ];

        foreach ($jsons as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => json_encode($value, JSON_UNESCAPED_UNICODE)]);
        }
    }
}
