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
- **Role-based access** — Tiga role: Admin (full access), Editor (konten), Viewer (public)
- **Wiki Ensiklopedia** — Artikel digital tentang sejarah, pelinggih, ritual, tokoh, dan glosarium adat Bali
- **Cloudflare R2** — Penyimpanan foto 360° dengan zero egress cost

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13 + PHP 8.4 |
| Frontend reaktif | Livewire 4 + Flux UI v2 |
| Styling | Tailwind CSS v4 |
| Viewer 360° | Pannellum 2.5.7 |
| Admin panel | Filament v5 |
| Auth | Laravel Fortify |
| Object storage | Cloudflare R2 (S3-compatible) |
| Database | PostgreSQL (production) / SQLite (development) |
| Containerisasi | Docker + Supervisor (nginx + php-fpm) |

---

## Arsitektur

Aplikasi mengikuti pola **Modular Monolith** dengan tiga layer utama: Presentation, Application (Service), dan Infrastructure (Repository). Detail lengkap ada di [`ARCHITECTURE.md`](./ARCHITECTURE.md).

### Diagram Layer

```
┌─────────────────────────────────────────────────────────────────┐
│                      PRESENTATION LAYER                          │
│   Livewire (TourViewer) · Filament Resources · Blade Views       │
└────────────────────────────┬────────────────────────────────────┘
                             │ memanggil
┌────────────────────────────▼────────────────────────────────────┐
│                      APPLICATION LAYER                           │
│    VenueService · SceneService · HotspotService · StorageService │
└──────────────┬──────────────────────────────┬───────────────────┘
               │ menggunakan                  │ menggunakan
┌──────────────▼──────────┐   ┌──────────────▼──────────────────┐
│      DOMAIN LAYER        │   │       INFRASTRUCTURE LAYER       │
│  Venue · Scene · Hotspot │   │  VenueRepository · SceneRepo    │
│  User · UserRole (Enum)  │   │  HotspotRepository              │
│  (Eloquent Models)       │   │  StorageService ──► Cloudflare  │
└──────────────────────────┘   └─────────────────────────────────┘
```

### Diagram Struktur Direktori

```
app/
├── Enums/
│   ├── UserRole.php                  # Admin · Editor · Viewer
│   └── WikiCategory.php              # Sejarah · Pelinggih · Ritual · Tokoh · Glosarium · Info
│
├── Filament/
│   └── Resources/
│       ├── Users/                    # User management (Admin only)
│       │   ├── UserResource.php
│       │   ├── Pages/
│       │   ├── Schemas/
│       │   └── Tables/
│       ├── Venues/                   # Kelola venue & branding
│       │   ├── VenueResource.php
│       │   ├── Pages/
│       │   ├── Schemas/
│       │   └── Tables/
│       ├── Scenes/                   # Kelola scene & foto 360°
│       │   ├── SceneResource.php
│       │   ├── Pages/
│       │   ├── Schemas/
│       │   └── Tables/
│       ├── Hotspots/                 # Kelola hotspot interaktif
│       │   ├── HotspotResource.php
│       │   ├── Pages/
│       │   └── Schemas/
│       └── WikiArticles/             # Kelola artikel wiki ensiklopedia
│           ├── WikiArticleResource.php
│           ├── Pages/
│           ├── Schemas/
│           └── Tables/
│
├── Http/
│   └── Controllers/
│       ├── WelcomeController.php     # Halaman utama publik
│       └── WikiController.php        # Wiki index & show
│
├── Livewire/
│   └── TourViewer.php                # Komponen viewer publik 360°
│
├── Models/
│   ├── User.php                      # fillable, casts, relationships
│   ├── Venue.php
│   ├── Scene.php
│   ├── Hotspot.php
│   └── WikiArticle.php               # slug, title, category, excerpt, content, order
│
├── Repositories/
│   ├── Contracts/
│   │   ├── VenueRepositoryInterface.php
│   │   ├── SceneRepositoryInterface.php
│   │   └── WikiArticleRepositoryInterface.php
│   ├── VenueRepository.php           # Semua query Venue
│   ├── SceneRepository.php           # Semua query Scene
│   ├── HotspotRepository.php         # Semua query Hotspot
│   └── WikiArticleRepository.php     # Semua query WikiArticle
│
└── Services/
    ├── StorageService.php            # Satu-satunya akses ke R2
    ├── VenueService.php              # Logika bisnis Venue
    ├── SceneService.php              # Build data untuk Pannellum
    ├── HotspotService.php            # Logika bisnis Hotspot
    └── WikiService.php               # Grouping & lookup artikel wiki

resources/
├── css/app.css                       # Tailwind CSS v4
├── js/app.js                         # Alpine.js + Livewire
└── views/
    ├── livewire/
    │   └── tour-viewer.blade.php    # UI viewer + Pannellum init
    ├── wiki/
    │   ├── index.blade.php          # Daftar artikel wiki per kategori
    │   └── show.blade.php           # Detail artikel wiki (light mode)
    └── welcome.blade.php            # Halaman daftar venue + Wiki CTA

database/
├── migrations/                       # Schema evolution
│   └── ..._create_wiki_articles_table.php
└── seeders/
    ├── DatabaseSeeder.php            # Seed admin user default
    └── WikiArticleSeeder.php         # 11 artikel awal wiki

docker/
├── nginx/railway.conf               # Nginx config (Railway)
├── php/
│   ├── php-production.ini
│   └── zz-railway.conf              # php-fpm pool override
├── supervisor/supervisord.conf      # nginx + php-fpm (single container)
└── entrypoint.sh                    # Bootstrap: migrate, seed, cache
```

### Alur Request: Visitor Akses Tour

```
Browser GET /tour/{slug}
        │
        ▼
routes/web.php ──► TourViewer (Livewire)
        │
        ▼
TourViewer::mount()
        │  abort_unless(is_published, 404)
        ▼
TourViewer::render()
        │
        ├──► VenueService::findBySlug()
        │         └──► VenueRepository::findBySlug()
        │
        └──► SceneService::getScenesForViewer()
                  ├──► SceneRepository::getByVenue()
                  └──► StorageService::getUrl()
                            ├── [local]      /r2/{path} (proxy)
                            └── [production] R2 public URL

        Alpine.js `tourViewer()` ──► Pannellum.viewer()
```

### Alur Request: Admin Panel

```
Browser GET /admin
        │
        ▼
Filament Panel
        │  canAccessPanel(): role ∈ {Admin, Editor}
        ▼
┌──────────────────────────────┐
│  Pengaturan (Admin only)     │
│    └── Users (CRUD + role)   │
├──────────────────────────────┤
│  Konten (Admin + Editor)     │
│    ├── Venues                │
│    ├── Scenes                │
│    └── Hotspots              │
└──────────────────────────────┘
```

---

## Struktur Hotspot

| Tipe | Perilaku |
|---|---|
| `scene_link` | Navigasi ke scene lain dalam venue yang sama |
| `info` | Buka popup dengan judul + deskripsi |
| `url` | Buka link eksternal di tab baru |
| `media` | Tampilkan video, audio, atau gambar dalam modal |

## Role & Akses

| Role | Akses Panel | Kelola Konten | Kelola User |
|---|---|---|---|
| `admin` | ✅ | ✅ | ✅ |
| `editor` | ✅ | ✅ | ❌ |
| `viewer` | ❌ | ❌ | ❌ |

---

## Instalasi

### Persyaratan

- PHP 8.4+
- Composer
- Node.js & NPM
- PostgreSQL (production) atau SQLite (development)

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

# Jalankan migrasi & seeder
php artisan migrate --seed

# Build assets
npm run build

# Jalankan server
php artisan serve
```

### Konfigurasi Cloudflare R2

Tambahkan ke `.env`:

```env
FILESYSTEM_DISK=r2
CLOUDFLARE_R2_KEY=your_access_key
CLOUDFLARE_R2_SECRET=your_secret_key
CLOUDFLARE_R2_BUCKET=your_bucket_name
CLOUDFLARE_R2_ENDPOINT=https://<account-id>.r2.cloudflarestorage.com
CLOUDFLARE_R2_URL=https://your-custom-domain.com
```

> Di development lokal, gambar otomatis diproxy melalui `/r2/{path}` — tidak perlu R2 aktif.

### Buat Admin Pertama

Seeder otomatis membuat user admin default saat `migrate --seed`:

| Field | Value |
|---|---|
| Email | `admin@virtual-tour.test` |
| Password | `password` |
| Role | `admin` |

Atau buat manual via Filament:

```bash
php artisan make:filament-user
```

Akses admin panel di `/admin`.

---

## Docker (Development)

```bash
docker compose up -d
```

## Deployment (Railway)

Branch `deploy/railway` dikonfigurasi untuk Railway. Build menggunakan Docker multi-stage:

```
base ──► builder (composer + npm build) ──► production ──► railway
                                                            (nginx + php-fpm via supervisor)
```

Entrypoint otomatis menjalankan: `migrate → seed → cache → storage:link → nginx`.

---

## Routes

| Method | URL | Deskripsi |
|---|---|---|
| `GET` | `/` | Daftar venue publik |
| `GET` | `/tour/{slug}` | Viewer tour per venue |
| `GET` | `/wiki` | Daftar artikel wiki ensiklopedia |
| `GET` | `/wiki/{slug}` | Detail artikel wiki |
| `GET` | `/admin` | Filament admin panel |
| `GET` | `/admin/login` | Login admin |
| `GET` | `/r2/{path}` | Proxy R2 (development only) |

---

## Lisensi

MIT License — bebas digunakan dan dimodifikasi.
