# Virtual Tour Pura Desa

Aplikasi virtual tour berbasis web untuk menjelajahi venue/lokasi bersejarah secara interaktif melalui foto panorama 360°. Dibangun untuk keperluan digitalisasi warisan budaya Bali — khususnya Pura Desa.

## Fitur

- **Viewer 360°** — Powered by Pannellum, full-screen, mendukung mouse, keyboard, dan touch
- **Multi-venue & Multi-scene** — Satu aplikasi bisa mengelola banyak lokasi dengan banyak ruang/area
- **Hotspot interaktif** — 4 tipe hotspot: navigasi antar-scene, popup informasi, link eksternal, dan media (video/audio/gambar)
- **Card tooltip** — Hover hotspot menampilkan nama dan deskripsi objek
- **Sidebar navigasi scene** — Daftar ruangan dapat dipilih langsung dari sidebar
- **Coordinate helper** — Alat bantu admin untuk menentukan posisi hotspot secara presisi
- **Branding per venue** — Warna utama dan logo custom untuk setiap lokasi
- **Admin panel** — CRUD lengkap via Filament: venue, scene, hotspot, dan user management
- **Cloudflare R2** — Penyimpanan foto 360° dengan zero egress cost

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13 + PHP 8.4 |
| Frontend reaktif | Livewire 4 + Flux UI v2 |
| Styling | Tailwind CSS v4 |
| Viewer 360° | Pannellum 2.5.6 |
| Admin panel | Filament v5 |
| Auth | Laravel Fortify |
| Object storage | Cloudflare R2 (S3-compatible) |
| Database | PostgreSQL (production) / SQLite (development) |
| Containerisasi | Docker Compose |

## Struktur Hotspot

| Tipe | Perilaku |
|---|---|
| `scene_link` | Navigasi ke scene lain dalam venue yang sama |
| `info` | Buka popup dengan judul + deskripsi |
| `url` | Buka link eksternal di tab baru |
| `media` | Tampilkan video, audio, atau gambar dalam modal |

## Instalasi

### Persyaratan

- PHP 8.3+
- Composer
- Node.js & NPM
- SQLite / PostgreSQL

### Langkah

```bash
# Clone repo
git clone https://github.com/suwantara/virtual-tour-pura-desa.git
cd virtual-tour-pura-desa

# Install dependensi
composer install
npm install

# Konfigurasi environment
cp .env.example .env
php artisan key:generate

# Jalankan migrasi
php artisan migrate

# Build assets
npm run build

# Jalankan server
php artisan serve
```

### Konfigurasi Cloudflare R2

Tambahkan ke `.env`:

```env
CLOUDFLARE_R2_KEY=your_access_key
CLOUDFLARE_R2_SECRET=your_secret_key
CLOUDFLARE_R2_BUCKET=your_bucket_name
CLOUDFLARE_R2_ENDPOINT=https://<account-id>.r2.cloudflarestorage.com
CLOUDFLARE_R2_URL=https://your-custom-domain.com
```

### Buat Admin Pertama

```bash
php artisan make:filament-user
```

Akses admin panel di `/admin`.

## Docker

```bash
# Development
docker compose up -d

# Production (dengan env production)
docker compose -f docker-compose.yml up -d
```

## Routes

| Method | URL | Deskripsi |
|---|---|---|
| `GET` | `/` | Daftar venue publik |
| `GET` | `/tour/{slug}` | Viewer tour per venue |
| `GET` | `/admin` | Filament admin panel |
| `GET` | `/r2/{path}` | Proxy R2 untuk development lokal |

## Screenshot

> _Tambahkan screenshot viewer dan admin panel di sini._

## Lisensi

MIT License — bebas digunakan dan dimodifikasi.
