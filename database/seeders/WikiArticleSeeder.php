<?php

namespace Database\Seeders;

use App\Models\WikiArticle;
use App\Models\WikiCategory;
use Illuminate\Database\Seeder;

class WikiArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = WikiCategory::pluck('id', 'slug');

        $articles = [

            // ── Sejarah ───────────────────────────────────────────────────
            [
                'slug' => 'sejarah-pura-desa-adat-tambawu',
                'title' => 'Sejarah Pura Desa Adat Tambawu',
                'wiki_category_id' => $categoryIds['sejarah'],
                'excerpt' => 'Pura Desa Adat Tambawu merupakan bagian dari sistem Tri Kahyangan sebagai pusat kehidupan spiritual masyarakat Desa Adat Tambawu, Kota Denpasar.',
                'content' => <<<'HTML'
<p>Pura Desa Adat Tambawu merupakan salah satu elemen penting dalam sistem <strong>Tri Kahyangan</strong> yang menjadi landasan kehidupan spiritual masyarakat Desa Adat Tambawu, Kota Denpasar. Sebagai tempat pemujaan <strong>Dewa Brahma</strong>, pura ini berperan sebagai pusat pelaksanaan ritual bersama dan perekat identitas budaya komunitas adat setempat.</p>
<p>Berdasarkan penuturan Jro Mangku Desa, berdirinya Pura Desa Adat Tambawu tidak diketahui secara pasti. Desa Adat Tambawu termasuk dalam <strong>desa tua</strong> yang merupakan gabungan antardesa di kawasan Penatih, sehingga disebut Penatih Kidul (Selatan).</p>
<p>Catatan kecil yang tersimpan menyebutkan adanya penataan pelinggih pada <strong>dekade 1940-an</strong> atas perintah raja, ketika struktur pura mulai berkembang dari satu pelinggih menjadi tatanan yang lebih lengkap seperti saat ini.</p>
<h2>Tri Kahyangan</h2>
<p>Tri Kahyangan adalah tiga pura utama yang wajib dimiliki setiap desa adat di Bali:</p>
<ul>
<li><strong>Pura Desa (Bale Agung)</strong> — tempat pemujaan Dewa Brahma, sebagai pencipta.</li>
<li><strong>Pura Puseh</strong> — tempat pemujaan Dewa Wisnu, sebagai pemelihara.</li>
<li><strong>Pura Dalem</strong> — tempat pemujaan Dewa Siwa, sebagai pelebur.</li>
</ul>
HTML,
                'order' => 1,
                'is_published' => true,
            ],

            // ── Ritual ────────────────────────────────────────────────────
            [
                'slug' => 'pujawali-dan-hari-piodalan',
                'title' => 'Pujawali dan Hari Piodalan',
                'wiki_category_id' => $categoryIds['ritual'],
                'excerpt' => 'Piodalan utama Pura Desa Adat Tambawu dilaksanakan setiap Saniscara Kliwon Kuningan (Hari Raya Kuningan).',
                'content' => <<<'HTML'
<p><strong>Pujawali</strong> atau <strong>Piodalan</strong> adalah upacara peringatan hari lahir sebuah pura. Setiap pura memiliki hari piodalan berdasarkan perhitungan kalender Bali.</p>
<h2>Hari Piodalan</h2>
<p>Piodalan utama Pura Desa Adat Tambawu jatuh pada <strong>Saniscara Kliwon Kuningan</strong> — Hari Raya Kuningan, salah satu hari suci terpenting dalam kalender Hindu Bali.</p>
<h2>Tentang Hari Raya Kuningan</h2>
<p>Kuningan jatuh setiap 210 hari sekali dalam kalender Pawukon Bali, pada Saniscara (Sabtu) Kliwon wuku Kuningan. Dipercaya sebagai waktu para dewa dan leluhur kembali ke kahyangan setelah turun ke bumi saat Galungan.</p>
<h2>Rangkaian Upacara</h2>
<ul>
<li><strong>Persiapan</strong> — penjor, banten, dan perlengkapan upacara disiapkan krama desa.</li>
<li><strong>Mapepada</strong> — upacara pembersihan dan penyucian area pura.</li>
<li><strong>Piodalan</strong> — persembahyangan bersama di seluruh pelinggih.</li>
<li><strong>Ngaturang Ayah</strong> — krama desa melaksanakan ngayah (bakti sosial).</li>
</ul>
HTML,
                'order' => 1,
                'is_published' => true,
            ],

            // ── Pelinggih ─────────────────────────────────────────────────
            [
                'slug' => 'gedong-agung',
                'title' => 'Gedong Agung',
                'wiki_category_id' => $categoryIds['pelinggih'],
                'excerpt' => 'Pelinggih utama tempat linggih Ida Bhatara Pura Desa. Diumpamakan sebagai rumah besar dan suci, pusat dari seluruh pelinggih.',
                'content' => <<<'HTML'
<p><strong>Gedong Agung</strong> adalah pelinggih utama di Pura Desa Adat Tambawu, tempat linggih <strong>Ida Bhatara Pura Desa</strong> beserta berbagai pratimanya.</p>
<p>Secara filosofis diumpamakan sebagai <em>rumah yang besar dan suci</em> — tempat bersemayamnya kekuatan ilahi tertinggi yang menjaga keselamatan seluruh krama desa.</p>
<h2>Arsitektur</h2>
<p>Gedong Agung dibangun dengan atap bertingkat (meru) yang melambangkan Gunung Meru sebagai pusat alam semesta dalam kosmologi Hindu. Ornamen ukiran batu padas menghiasi seluruh bagian bangunan.</p>
HTML,
                'order' => 1,
                'is_published' => true,
            ],

            [
                'slug' => 'bale-agung',
                'title' => 'Bale Agung',
                'wiki_category_id' => $categoryIds['pelinggih'],
                'excerpt' => 'Tempat berstananya Ida Bhatara saat upacara berlangsung. Pusat dari seluruh proses ritual di pura.',
                'content' => <<<'HTML'
<p><strong>Bale Agung</strong> adalah balai utama tempat para <strong>Sesuhunan</strong> berstana saat upacara dilangsungkan. Setiap ritual besar di pura berpusat di sini.</p>
<h2>Fungsi Ritual</h2>
<ul>
<li>Tempat persembahyangan utama saat Piodalan.</li>
<li>Tempat peletakan banten (sesajen) terbesar.</li>
<li>Tempat Sesuhunan "turun" dan berinteraksi dengan para Pemangku.</li>
</ul>
HTML,
                'order' => 2,
                'is_published' => true,
            ],

            [
                'slug' => 'ratu-anglurah-agung',
                'title' => 'Ratu Anglurah Agung',
                'wiki_category_id' => $categoryIds['pelinggih'],
                'excerpt' => 'Penjaga pura yang harus dilewati setiap orang yang masuk. Bagaikan ajudan pribadi yang menyambut dan melindungi.',
                'content' => <<<'HTML'
<p><strong>Ratu Anglurah Agung</strong> adalah pelinggih penjaga pura — <em>pengawal dan pelindung</em> yang berjaga di gerbang kesakralan.</p>
<p>Semua orang yang memasuki area pura melewati kehadiran Ratu Anglurah Agung sebagai bentuk penghormatan dan permohonan izin sebelum memasuki ruang sakral.</p>
HTML,
                'order' => 3,
                'is_published' => true,
            ],

            [
                'slug' => 'pelinggih-dewi-sedana',
                'title' => 'Pelinggih Dewi Sedana',
                'wiki_category_id' => $categoryIds['pelinggih'],
                'excerpt' => 'Tempat pemujaan Dewi Kesuburan yang memberikan berkah kehidupan bagi masyarakat adat.',
                'content' => <<<'HTML'
<p><strong>Dewi Sedana</strong> adalah manifestasi Tuhan sebagai Dewi Kesuburan dan Kemakmuran. Krama desa memohon berkah kesuburan ladang, kesehatan keluarga, dan kelancaran rezeki di pelinggih ini.</p>
HTML,
                'order' => 4,
                'is_published' => true,
            ],

            [
                'slug' => 'bale-paruman',
                'title' => 'Bale Paruman',
                'wiki_category_id' => $categoryIds['pelinggih'],
                'excerpt' => 'Tempat para pendamping (pengabih) yang dikenal dengan premas berkumpul saat proses upacara.',
                'content' => <<<'HTML'
<p><strong>Bale Paruman</strong> adalah balai pertemuan sakral, difungsikan sebagai tempat berkumpulnya para <strong>pengabih</strong> (pendamping Sesuhunan) yang dikenal sebagai <em>premas</em>. Saat upacara, para premas berkumpul di sini sebelum mendampingi jalannya ritual.</p>
HTML,
                'order' => 5,
                'is_published' => true,
            ],

            [
                'slug' => 'begawan-penyarikan',
                'title' => 'Begawan Penyarikan',
                'wiki_category_id' => $categoryIds['pelinggih'],
                'excerpt' => 'Tempat berstananya Ida dalam mengatur dan mencatat kehidupan bermasyarakat.',
                'content' => <<<'HTML'
<p><strong>Begawan Penyarikan</strong> adalah pelinggih bagi aspek ilahi yang bertugas mengatur dan mencatat kehidupan bermasyarakat. Krama desa memohon restu di sini agar setiap kegiatan berjalan lancar.</p>
<p><em>Penyarikan</em> secara harfiah berarti "sekretaris" atau "pencatat" — dalam konteks spiritual, ini adalah manifestasi yang menyimpan catatan karma setiap warga.</p>
HTML,
                'order' => 6,
                'is_published' => true,
            ],

            // ── Tokoh ─────────────────────────────────────────────────────
            [
                'slug' => 'jro-made-rena-atmaja',
                'title' => 'Jro Made Rena Atmaja — Mangku Desa',
                'wiki_category_id' => $categoryIds['tokoh'],
                'excerpt' => 'Lahir 1951, Jro Made Rena Atmaja menjabat sebagai Mangku Desa Pura Desa Adat Tambawu sejak tahun 1993.',
                'content' => <<<'HTML'
<p><strong>Jro Made Rena Atmaja</strong> lahir tahun 1951 dan mengabdi sebagai <strong>Jro Mangku Desa</strong> sejak 1993 — lebih dari tiga dekade pelayanan tanpa henti, bahkan sejak masih aktif berdinas di pemerintahan.</p>
<blockquote><em>"Menjadi Mangku itu tidak mengenal istilah pensiun. Jika seseorang sudah terpilih menjadi Mangku di Khayangan Tiga, ia melakukan kewajibannya dengan tulus ikhlas hingga akhir hayat."</em></blockquote>
<h2>Peran Mangku Desa</h2>
<p>Mangku Desa adalah pemimpin ritual utama di Pura Desa. Peran ini bersifat <strong>permanen</strong> dan hanya dapat diwakilkan oleh Mangku pengayah dalam kondisi tertentu.</p>
<ul>
<li>Memimpin seluruh upacara Piodalan.</li>
<li>Merawat dan menjaga kesucian seluruh pelinggih.</li>
<li>Memberikan panduan spiritual kepada krama desa.</li>
</ul>
HTML,
                'order' => 1,
                'is_published' => true,
            ],

            // ── Glosarium ─────────────────────────────────────────────────
            [
                'slug' => 'glosarium-istilah-pura-bali',
                'title' => 'Glosarium Istilah Pura & Adat Bali',
                'wiki_category_id' => $categoryIds['glosarium'],
                'excerpt' => 'Kumpulan istilah penting dalam tradisi Hindu Bali yang berkaitan dengan pura, upacara, dan kehidupan adat.',
                'content' => <<<'HTML'
<dl>
<dt><strong>Banten</strong></dt><dd>Sesajen dalam upacara Hindu Bali, dibuat dari berbagai bahan alami.</dd>
<dt><strong>Desa Adat</strong></dt><dd>Komunitas adat tradisional Bali dengan aturan dan lembaga tersendiri berdasarkan hukum adat (awig-awig).</dd>
<dt><strong>Ida Bhatara</strong></dt><dd>Sebutan hormat untuk manifestasi Tuhan atau roh leluhur yang berstana di sebuah pura.</dd>
<dt><strong>Krama Desa</strong></dt><dd>Warga terdaftar sebagai anggota sah desa adat dengan hak dan kewajiban adat.</dd>
<dt><strong>Mangku</strong></dt><dd>Pemimpin spiritual pura, perantara antara manusia dan Tuhan dalam ritual.</dd>
<dt><strong>Meru</strong></dt><dd>Pelinggih berbentuk menara bertingkat (tumpang) melambangkan Gunung Meru.</dd>
<dt><strong>Ngayah</strong></dt><dd>Kerja bhakti sukarela krama desa untuk kepentingan pura atau upacara adat.</dd>
<dt><strong>Pawukon</strong></dt><dd>Kalender Bali berumur 210 hari yang terdiri dari 30 wuku.</dd>
<dt><strong>Pelinggih</strong></dt><dd>Bangunan suci tempat persemayaman manifestasi Tuhan di kompleks pura.</dd>
<dt><strong>Piodalan</strong></dt><dd>Upacara peringatan hari "lahir" sebuah pura, setiap 210 hari sekali.</dd>
<dt><strong>Pratima</strong></dt><dd>Objek sakral sebagai media persemayaman Ida Bhatara.</dd>
<dt><strong>Premas</strong></dt><dd>Para pendamping (pengabih) Sesuhunan yang membantu jalannya upacara.</dd>
<dt><strong>Pujawali</strong></dt><dd>Sinonim dari Piodalan — upacara utama pura pada hari piodalan.</dd>
<dt><strong>Sesuhunan</strong></dt><dd>Manifestasi Ida Bhatara yang "turun" hadir dalam ritual, sering melalui kerauhan (trance).</dd>
<dt><strong>Tri Kahyangan</strong></dt><dd>Tiga pura utama wajib desa adat: Pura Desa, Pura Puseh, dan Pura Dalem.</dd>
</dl>
HTML,
                'order' => 1,
                'is_published' => true,
            ],

            // ── Info ──────────────────────────────────────────────────────
            [
                'slug' => 'informasi-kunjungan',
                'title' => 'Informasi Kunjungan',
                'wiki_category_id' => $categoryIds['info'],
                'excerpt' => 'Panduan bagi pengunjung yang ingin datang langsung ke Pura Desa Adat Tambawu.',
                'content' => <<<'HTML'
<h2>Lokasi</h2>
<p>Pura Desa Adat Tambawu terletak di <strong>Desa Adat Tambawu, Kelurahan Penatih, Kecamatan Denpasar Timur, Kota Denpasar, Bali</strong>.</p>
<h2>Tata Cara Berkunjung</h2>
<ul>
<li>Mengenakan <strong>kamen</strong> (kain) dan <strong>sabuk</strong> (selendang) saat memasuki area pura.</li>
<li>Berpakaian sopan — tidak menggunakan pakaian pendek atau terbuka.</li>
<li>Wanita yang sedang haid tidak diperkenankan memasuki area pura.</li>
<li>Menjaga ketenangan dan tidak membuat keributan.</li>
</ul>
<h2>Hari Piodalan</h2>
<p>Piodalan jatuh pada <strong>Saniscara Kliwon Kuningan</strong>. Pada hari ini pura sangat ramai — pengunjung umum disarankan menghormati jalannya upacara.</p>
HTML,
                'order' => 1,
                'is_published' => true,
            ],
        ];

        foreach ($articles as $data) {
            WikiArticle::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
