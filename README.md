# Showroom Mobil API 🚗

RESTful API untuk manajemen data mobil showroom, dibangun dengan **Laravel 12** dan **MySQL**.
Dokumentasi interaktif tersedia via **Scramble** di `/docs/api`.

## 🔗 Link Penting

| Layanan | URL |
|---|---|
| Live API (Clever Cloud) | `https://<app-name>.cleverapps.io/api/mobil` |
| Dokumentasi Scramble | `https://<app-name>.cleverapps.io/docs/api` |
| Dokumentasi Lokal | `http://localhost:8000/docs/api` |

## 📋 Daftar Endpoint

| Method | Endpoint | Deskripsi | Status Sukses |
|---|---|---|---|
| GET | `/api/mobil` | Ambil seluruh daftar mobil | 200 OK |
| GET | `/api/mobil/{id}` | Ambil detail 1 mobil | 200 OK |
| POST | `/api/mobil` | Tambah unit mobil baru | 201 Created |
| PUT/PATCH | `/api/mobil/{id}` | Perbarui data mobil | 200 OK |
| DELETE | `/api/mobil/{id}` | Hapus mobil | 200 OK |

**Bonus fitur (query params pada GET `/api/mobil`):**
- `?search=avanza` — pencarian nama/brand
- `?brand=Toyota` — filter brand
- `?status=tersedia` — filter status (`tersedia`/`sold`)
- `?transmisi=CVT` — filter transmisi

## 🏗️ Struktur Atribut Mobil

| Atribut | Tipe | Keterangan |
|---|---|---|
| `nama` | string | Model mobil (wajib) |
| `brand` | string | Merk (wajib) |
| `harga` | integer | Harga dalam Rupiah (wajib) |
| `tahun` | integer | Tahun rakit, 4 digit (wajib) |
| `transmisi` | enum | `Manual` / `Matic` / `CVT` (wajib) |
| `bahan_bakar` | enum | `Bensin` / `Diesel` / `Hybrid` / `Listrik` (wajib) |
| `status` | enum | `tersedia` / `sold` (wajib) |
| `foto` | string (URL) | URL foto unit (opsional) |

## 📦 Contoh Respon

**GET /api/mobil — 200 OK**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Avanza 1.5 G CVT",
      "brand": "Toyota",
      "harga": 275000000,
      "tahun": 2024,
      "transmisi": "CVT",
      "bahan_bakar": "Bensin",
      "status": "tersedia",
      "foto": "https://images.unsplash.com/photo-1549399542-7e3f8b79c341"
    }
  ],
  "message": "Daftar mobil berhasil diambil"
}
```

**POST /api/mobil — 201 Created**
```json
{
  "data": { "id": 11, "nama": "Innova Zenix Hybrid", "brand": "Toyota", "...": "..." },
  "message": "Data mobil berhasil ditambahkan"
}
```

**Validasi gagal — 422 Unprocessable Content**
```json
{
  "message": "Kolom nama mobil wajib diisi. (and 1 more error)",
  "errors": {
    "nama": ["Kolom nama mobil wajib diisi."],
    "harga": ["Kolom harga harus berupa angka."]
  }
}
```

**Data tidak ditemukan — 404 Not Found**
```json
{ "message": "Data mobil dengan ID tersebut tidak ditemukan", "data": null }
```

## ⚙️ Instalasi Lokal

Prasyarat: PHP 8.2+, Composer, MySQL (Laragon/XAMPP).

```bash
# 1. Clone repository
git clone https://github.com/username/BTNG-Backend-NamaLengkap.git
cd BTNG-Backend-NamaLengkap

# 2. Install dependency
composer install

# 3. Salin file environment
copy .env.example .env      # Windows
# cp .env.example .env      # Linux/Mac

# 4. Generate application key
php artisan key:generate

# 5. Buat database MySQL bernama showroom_mobil, lalu migrate & seed
php artisan migrate --seed

# 6. Jalankan server
php artisan serve
```

API tersedia di `http://localhost:8000/api/mobil`, dokumentasi di `http://localhost:8000/docs/api`.

## 🗄️ Database

- **Lokal:** MySQL (Laragon/XAMPP) — database `showroom_mobil`
- **Cloud:** Clever Cloud MySQL add-on (lihat `.env.example` untuk variabel yang perlu diisi)

Seeder berisi **10 data dummy mobil**. Jalankan ulang kapan saja dengan:

```bash
php artisan db:seed
```

## 🚀 Deployment (Clever Cloud)

1. Buat aplikasi PHP baru di Clever Cloud, tambahkan MySQL add-on.
2. Set environment variables dari kredensial add-on: `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (+ `APP_KEY`, `APP_ENV=production`, `APP_URL`).
3. Jalankan migration sekali: `php artisan migrate --seed --force`.
4. Deploy dari GitHub repository ini.

## 🧰 Teknologi

- Laravel 12 (PHP 8.2+)
- MySQL + Eloquent ORM
- Scramble (`dedoc/scramble`) — dokumentasi OpenAPI interaktif
- Laravel Sanctum (tersedia untuk otentikasi API)
