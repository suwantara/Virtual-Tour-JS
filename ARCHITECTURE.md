# ARCHITECTURE.md — Digital Heritage Virtual Tour

> Dokumen ini adalah panduan arsitektur utama untuk proyek **Virtual Tour Digital Heritage**
> berbasis Laravel + Filament. Claude Code wajib membaca dan mengikuti konvensi ini
> sebelum menulis, memodifikasi, atau me-review kode apa pun dalam proyek ini.

---

## 1. Ringkasan Proyek

| Atribut        | Detail                                              |
|----------------|-----------------------------------------------------|
| **Nama**       | Virtual Tour Digital Heritage                       |
| **Platform**   | Web (Laravel Monolith)                              |
| **Tujuan**     | Menyajikan tur virtual 360° warisan budaya digital  |
| **Skala**      | UAS — Tim kecil (1–3 orang), single-server          |
| **Arsitektur** | Modular Monolith + Service Layer + Repository Pattern |

---

## 2. Pola Arsitektur

### 2.1 Prinsip Utama

```
1. THIN CONTROLLER  — Controller hanya menerima request & mendelegasikan ke Service
2. FAT SERVICE      — Seluruh business logic ada di Service Layer
3. REPOSITORY       — Akses database hanya melalui Repository, tidak langsung dari Service/Controller
4. ISOLATED STORAGE — Semua interaksi dengan R2 hanya melalui StorageService
5. NO LOGIC IN VIEW — Blade/Livewire view tidak boleh berisi kalkulasi atau query DB
```

### 2.2 Diagram Layer

```
┌─────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                        │
│  Controller · Livewire Components · Filament Resources       │
│  Blade Views · API Resources · Form Requests                 │
└──────────────────────┬──────────────────────────────────────┘
                       │ calls
┌──────────────────────▼──────────────────────────────────────┐
│                    APPLICATION LAYER                         │
│  VenueService · SceneService · StorageService                │
│  (Jobs, Events jika diperlukan)                              │
└──────────┬───────────────────────────┬───────────────────────┘
           │ uses                      │ uses
┌──────────▼──────────┐   ┌───────────▼───────────────────────┐
│   DOMAIN LAYER      │   │       INFRASTRUCTURE LAYER         │
│  Models (Eloquent)  │   │  Repositories · StorageService     │
│  Venue · Scene      │   │  R2 / Cloudflare · External APIs   │
│  Hotspot            │   │  Cache · Queue                     │
└─────────────────────┘   └────────────────────────────────────┘
```

---

## 3. Struktur Direktori

```
app/
├── Http/
│   └── Controllers/
│       └── Controller.php          # Base controller (no business logic here)
│
├── Livewire/
│   └── TourViewer.php              # Viewer 360° utama — inject SceneService & StorageService
│
├── Services/                       # ⭐ BUSINESS LOGIC — tulis di sini
│   ├── StorageService.php          # Abstraksi R2 upload/URL/delete
│   ├── SceneService.php            # Build scene data untuk viewer
│   └── VenueService.php            # Orchestrate venue operations
│
├── Repositories/                   # ⭐ DATABASE ACCESS — tulis di sini
│   ├── Contracts/
│   │   ├── VenueRepositoryInterface.php
│   │   └── SceneRepositoryInterface.php
│   ├── VenueRepository.php
│   ├── SceneRepository.php
│   └── HotspotRepository.php
│
├── Models/
│   ├── Venue.php                   # fillable, casts, relationships ONLY
│   ├── Scene.php
│   └── Hotspot.php
│
├── Filament/
│   └── Resources/
│       ├── Venues/
│       │   ├── VenueResource.php
│       │   ├── Pages/
│       │   ├── Schemas/
│       │   └── Tables/
│       ├── Scenes/
│       │   ├── SceneResource.php
│       │   ├── Pages/
│       │   ├── Schemas/
│       │   └── Tables/
│       └── Hotspots/
│           ├── HotspotResource.php
│           ├── Pages/
│           └── Schemas/
│
└── Providers/
    └── AppServiceProvider.php      # Bind Repository interfaces ke implementasi

resources/
├── views/
│   ├── livewire/
│   │   └── tour-viewer.blade.php
│   └── welcome.blade.php
└── js/
    └── app.js

database/
├── migrations/
└── seeders/
```

---

## 4. Model & Database Schema

### 4.1 Entity Relationship

```
Venue (1) ──────── (N) Scene (1) ──────── (N) Hotspot
   │                      │
   │                      └── image_path (R2 key)
   └── thumbnail_path (R2 key)
   └── logo_path (R2 key)
```

> **Catatan Penamaan:** Model utama adalah `Venue` (bukan `Tour`), sesuai nama tabel di database.

---

## 5. Service Layer — Kontrak & Tanggung Jawab

### 5.1 `StorageService`

**Tanggung jawab:** Satu-satunya kelas yang boleh berinteraksi dengan Cloudflare R2.

```php
// Upload file, kembalikan R2 object key (bukan URL)
public function upload(UploadedFile $file, string $folder): string

// Generate URL untuk ditampilkan ke browser (proxy di local, R2 URL di production)
public function getUrl(string $path): string

// Hapus object dari R2
public function delete(string $path): void

// Ganti file (delete lama, upload baru), kembalikan key baru
public function replace(string $oldPath, UploadedFile $newFile, string $folder): string
```

> ⚠️ **ATURAN KERAS:** Tidak ada kelas lain yang boleh memanggil
> `Storage::disk('r2')` secara langsung. Selalu gunakan `StorageService`.
>
> Pengecualian: route `r2.proxy` di `routes/web.php` (proxy local dev) boleh mengakses
> `Storage::disk('r2')` langsung karena ini adalah infrastruktur routing, bukan business logic.

### 5.2 `SceneService`

**Tanggung jawab:** Build scene data untuk viewer dan mengelola scene.

```php
// Kembalikan scenes dalam format yang diharapkan viewer & Alpine.js
public function getScenesForViewer(Venue $venue): Collection
// Output per scene:
// [
//   'id'            => int,
//   'name'          => string,
//   'image_path'    => string|null,  // resolved URL dari StorageService
//   'initial_yaw'   => float,
//   'initial_pitch' => float,
//   'hotspots'      => [...],
// ]
```

### 5.3 `VenueService`

**Tanggung jawab:** Orchestrate operasi level Venue.

```php
public function getPublished(): Collection
public function findBySlug(string $slug): ?Venue
```

---

## 6. Repository Layer — Kontrak

### 6.1 `VenueRepository`

```php
public function allPublished(): Collection
public function findById(int $id): ?Venue
public function findBySlug(string $slug): ?Venue
public function save(array $data): Venue
public function update(Venue $venue, array $data): Venue
public function delete(Venue $venue): void
```

### 6.2 `SceneRepository`

```php
public function getByVenue(int $venueId): Collection   // published only, ordered by `order` ASC
public function findById(int $id): ?Scene
public function save(array $data): Scene
public function update(Scene $scene, array $data): Scene
public function delete(Scene $scene): void
public function updateOrder(array $orderedIds): void   // bulk update `order`
```

### 6.3 `HotspotRepository`

```php
public function getByScene(int $sceneId): Collection
public function findById(int $id): ?Hotspot
public function save(array $data): Hotspot
public function update(Hotspot $hotspot, array $data): Hotspot
public function delete(Hotspot $hotspot): void
```

> **Aturan Repository:** Query Eloquent hanya boleh ada di Repository.
> Service tidak boleh memanggil `Venue::where(...)` secara langsung.

---

## 7. Livewire Components

### 7.1 `TourViewer`

Komponen utama yang merender viewer Pannellum.

```
State  : $venue (Venue model)
Mount  : abort_unless($venue->is_published, 404)
Render : inject SceneService & StorageService — tidak ada query DB di sini
View   : passes $scenes (Collection), $primaryColor, $logoUrl ke blade
```

---

## 8. Filament Admin Panel

### 8.1 Resources

| Resource           | Model   | Fitur Khusus                                 |
|--------------------|---------|----------------------------------------------|
| `VenueResource`    | Venue   | Upload thumbnail/logo → R2, toggle publish   |
| `SceneResource`    | Scene   | Upload 360° image → R2, set order & camera   |
| `HotspotResource`  | Hotspot | Input pitch/yaw, pilih target scene          |

### 8.2 Aturan Filament

```
✅ Filament FileUpload dengan disk('r2') diperbolehkan untuk upload file
✅ Filament Resources BOLEH memanggil Service Layer untuk operasi kompleks
❌ Jangan query DB langsung di dalam Resource form/table — gunakan Repository
❌ Jangan hapus/replace file R2 langsung dari Resource — gunakan StorageService
```

---

## 9. Alur Data: Visitor Akses Halaman Tour

```
Visitor GET /tour/{slug}
        │
        ▼
routes/web.php → TourViewer::class (Livewire)
        │
        ▼
TourViewer::mount($venue)
        │ abort_unless is_published
        │
        ▼
TourViewer::render(SceneService, StorageService)
        │
        ▼
SceneService::getScenesForViewer($venue)
        │
        ├──► SceneRepository::getByVenue($venue->id)
        │         → published scenes + hotspots, ordered by `order`
        │
        └──► StorageService::getUrl($scene->image_path)
                   │
                   ├── [local] route('r2.proxy', [...])
                   └── [production] Storage::disk('r2')->url(...)

        Alpine.js `tourViewer()` inisialisasi Pannellum dari scenes array
```

---

## 10. Konfigurasi R2 (Environment)

```php
// config/filesystems.php
'disks' => [
    'r2' => [
        'driver'                  => 's3',
        'key'                     => env('CLOUDFLARE_R2_ACCESS_KEY_ID'),
        'secret'                  => env('CLOUDFLARE_R2_SECRET_ACCESS_KEY'),
        'region'                  => env('CLOUDFLARE_R2_DEFAULT_REGION', 'auto'),
        'bucket'                  => env('CLOUDFLARE_R2_BUCKET'),
        'url'                     => env('CLOUDFLARE_R2_URL'),
        'endpoint'                => env('CLOUDFLARE_R2_URL'),
        'use_path_style_endpoint' => true,
        'throw'                   => true,
    ],
],
```

---

## 11. Konvensi Kode

### 11.1 Penamaan

```
Model       : PascalCase singular          (Venue, Scene, Hotspot)
Service     : PascalCase + "Service"       (VenueService, SceneService, StorageService)
Repository  : PascalCase + "Repository"   (VenueRepository, SceneRepository)
Controller  : PascalCase + "Controller"   (tidak ada saat ini)
Livewire    : PascalCase deskriptif       (TourViewer)
Method      : camelCase, verb-first        (getScenesForViewer, getPublished)
R2 folders  : kebab-case                  (scenes, venues/thumbnails, venues/logos)
```

### 11.2 Return Types

```php
// Service methods WAJIB type-hint return type
public function getScenesForViewer(Venue $venue): Collection
public function getPublished(): Collection

// Repository methods WAJIB nullable untuk single-item
public function findById(int $id): ?Venue
public function findBySlug(string $slug): ?Venue
```

### 11.3 Model Rules

```php
// ✅ BOLEH ada di Model
protected $fillable = [...];
protected $casts    = [...];
public function scenes(): HasMany { ... }       // Relationships
public function venue(): BelongsTo { ... }

// ❌ TIDAK BOLEH ada di Model
public function getViewerConfig() { ... }       // Business logic → ke Service
public function imageUrl(): Attribute { ... }   // Storage logic → ke StorageService
public static function getPublished() { ... }   // Query logic → ke Repository
```

---

## 12. Dependency Injection & Service Binding

```php
// app/Providers/AppServiceProvider.php
public function register(): void
{
    $this->app->bind(VenueRepositoryInterface::class, VenueRepository::class);
    $this->app->bind(SceneRepositoryInterface::class, SceneRepository::class);
    $this->app->singleton(StorageService::class);
}
```

---

## 13. Anti-Pattern yang Harus Dihindari

```
❌ Query DB langsung di Controller, Livewire, Filament Resource, atau Route closure
   → Pindahkan ke Repository, inject via Service

❌ Storage::disk('r2') dipanggil di luar StorageService
   → Selalu via StorageService::upload() / getUrl() / delete()
   → Pengecualian: route r2.proxy (infrastruktur dev)

❌ Computed attribute di Model yang memanggil Storage
   → Pindahkan ke StorageService

❌ Business logic (kalkulasi, validasi domain) di Model
   → Pindahkan ke Service yang sesuai

❌ Menyimpan URL R2 ke database (URL berubah)
   → Selalu simpan PATH/KEY, generate URL saat runtime via StorageService

❌ Hotspot data di-hardcode di frontend JS
   → Ambil dari database via SceneService, render via Livewire
```

---

## 14. Checklist Sebelum Commit

```
□ Tidak ada query DB di luar Repository
□ Storage::disk('r2') tidak dipanggil di luar StorageService
□ Model hanya berisi fillable, casts, dan relationships
□ Semua method Service memiliki return type yang eksplisit
□ URL R2 tidak disimpan ke database (hanya path/key)
□ Livewire render() hanya memanggil Service, tidak ada logic langsung
□ StorageService digunakan untuk semua operasi R2
```

---

*Dokumen ini dikelola secara manual. Update setiap kali ada keputusan arsitektur baru.*
*Versi terakhir: 2026-05-19*
