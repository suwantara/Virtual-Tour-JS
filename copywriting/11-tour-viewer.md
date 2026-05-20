# Tour Viewer (Halaman /tour/{slug})

## Topbar

| Elemen | Teks |
|---|---|
| Tombol kembali (tanpa logo) | `Kembali` |
| Judul tengah | _(nama venue, dinamis dari DB)_ |
| Tombol coordinate helper | `Koordinat` |

---

## Coordinate Helper (overlay)

| Elemen | Teks |
|---|---|
| Judul card | `Posisi Tengah Kamera` |
| Label baris 1 | `Pitch` |
| Label baris 2 | `Yaw` |
| Tombol salin (default) | `Salin` |
| Tombol salin (setelah klik) | `✓ Tersalin!` |
| Petunjuk | `Arahkan objek ke tengah layar, lalu salin koordinatnya untuk diisi di form hotspot.` |

---

## Viewer — Empty State

```
Belum ada scene untuk ditampilkan.
```

---

## Scene Navigation Strip

| Elemen | Teks |
|---|---|
| Label kiri | `Lokasi` |
| Nama scene aktif | _(nama scene, dinamis)_ |

---

## Hotspot Tooltip (Card)

Setiap hotspot menampilkan kartu kecil saat hover berisi nama dan deskripsi objek.
Baris petunjuk (hint) di bagian bawah kartu bervariasi per tipe:

| Tipe Hotspot | Hint |
|---|---|
| `scene_link` | `Klik untuk pindah scene` |
| `url` | `Klik untuk buka link` |
| `media` | `Klik untuk lihat media` |
| `info` | `Klik untuk detail` |

---

## Modal Hotspot

### Tipe `url`

| Elemen | Teks |
|---|---|
| Tombol buka link | `Buka Link` |

### Tipe `info`

Menampilkan deskripsi teks dari database — tidak ada label statis tambahan.

### Tipe `media`

Menampilkan media (video/audio/gambar) — tidak ada label statis tambahan selain deskripsi.

---

## Tombol Tutup Modal

_(ikon X — tidak ada teks label)_
