# Kelola Karyawan

Aplikasi manajemen karyawan berbasis Laravel untuk mengelola data SDM, alur pengajuan karyawan, dan laporan operasional. Proyek ini menyediakan portal web berbasis peran, REST API dengan Laravel Sanctum, serta aplikasi Flutter yang berada di dalam repository yang sama.

## Fitur utama

### Portal admin

- Dashboard ringkasan data karyawan.
- Kelola data karyawan, divisi, dan akun pengguna.
- Riwayat data karyawan dan notifikasi internal.
- Tinjau, setujui, atau tolak pengajuan cuti.
- Tinjau, setujui, tolak, dan unduh berkas sertifikat pelatihan.
- Tinjau pengajuan pembaruan profil karyawan.
- Buat, pratinjau, dan streaming laporan karyawan dalam format PDF.

### Portal karyawan

- Dashboard dan profil pribadi.
- Unduh kartu identitas karyawan dalam PDF.
- Ajukan, ubah, lihat, dan batalkan pengajuan cuti.
- Ajukan, ubah, lihat, dan hapus data pelatihan beserta berkas sertifikat.
- Ajukan pembaruan profil dan lihat riwayatnya.

### API dan mobile client

- REST API dengan autentikasi token Laravel Sanctum.
- Endpoint untuk autentikasi, profil, karyawan, cuti, dan pelatihan.
- Client Flutter tersedia pada folder `flutter_app` sebagai fondasi aplikasi mobile.

## Arsitektur singkat

```text
Browser / Flutter client
        |
        v
Laravel 11 application
  |- Web routes dan Blade views
  |- REST API (`/api`) + Sanctum
  |- Role middleware: admin dan karyawan
  |- Eloquent models + migrations
  |- MySQL/SQLite
  `- DomPDF untuk laporan dan ID card
```

## Stack

| Komponen | Teknologi |
| --- | --- |
| Backend | PHP 8.2+, Laravel 11 |
| Autentikasi API | Laravel Sanctum |
| Database | MySQL atau SQLite |
| UI web | Blade, Vite 5 |
| PDF | barryvdh/laravel-dompdf |
| Mobile | Flutter (Dart 3+) |

## Prasyarat

- PHP 8.2 atau lebih baru dengan ekstensi yang dibutuhkan Laravel.
- Composer 2.
- Node.js dan npm untuk asset Vite.
- MySQL 8+ atau SQLite.
- Flutter SDK (opsional, hanya untuk menjalankan aplikasi mobile).

## Instalasi aplikasi web dan API

1. Clone repository dan masuk ke folder proyek.

   ```bash
   git clone https://github.com/Hapis01/kelola-karyawan.git
   cd kelola-karyawan
   ```

2. Instal dependensi backend dan frontend.

   ```bash
   composer install
   npm install
   ```

3. Buat konfigurasi lokal dan application key.

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Atur koneksi database pada `.env`.

   Contoh MySQL lokal:

   ```dotenv
   APP_NAME="Kelola Karyawan"
   APP_URL=http://127.0.0.1:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kelola_karyawan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Alternatif SQLite: gunakan `DB_CONNECTION=sqlite`, buat file `database/database.sqlite`, lalu pastikan variabel database lain sesuai kebutuhan lingkungan Anda.

5. Jalankan migrasi dan data contoh.

   ```bash
   php artisan migrate --seed
   ```

   Data seeder hanya untuk pengembangan lokal. Ganti atau hapus data contoh sebelum deployment.

6. Buat symbolic link untuk file yang tersimpan pada disk publik dan bangun asset frontend.

   ```bash
   php artisan storage:link
   npm run build
   ```

7. Jalankan aplikasi.

   ```bash
   php artisan serve
   ```

   Buka `http://127.0.0.1:8000`. Saat pengembangan frontend, jalankan `npm run dev` pada terminal lain.

## Menjalankan Flutter client

Client mobile berada pada `flutter_app`.

```bash
cd flutter_app
flutter pub get
flutter run
```

Sebelum dijalankan pada perangkat atau emulator, sesuaikan base URL API pada `flutter_app/lib/services/api_service.dart`. `localhost` di emulator/perangkat merujuk ke perangkat itu sendiri, bukan otomatis ke host Laravel. Gunakan IP LAN mesin pengembang atau alamat emulator yang sesuai.

> Catatan: client Flutter perlu diverifikasi terhadap kontrak endpoint API Laravel sebelum digunakan sebagai aplikasi produksi. Dokumentasi API di bawah mengikuti route Laravel yang saat ini terdaftar.

## Ringkasan API

Semua endpoint API memiliki prefix `/api`. Endpoint dalam tabel terlindungi membutuhkan header berikut:

```http
Authorization: Bearer <token>
Accept: application/json
```

| Metode | Endpoint | Keterangan |
| --- | --- | --- |
| POST | `/api/login` | Login dan memperoleh token Sanctum. |
| POST | `/api/register` | Registrasi pengguna. |
| POST | `/api/logout` | Logout token aktif. |
| POST | `/api/refresh-token` | Memperbarui token. |
| GET / PUT | `/api/profile` | Lihat atau ubah profil. |
| POST | `/api/profile/update-password` | Ubah kata sandi. |
| GET, POST | `/api/karyawan` | Daftar atau buat karyawan. |
| GET, PUT, DELETE | `/api/karyawan/{karyawan}` | Detail, ubah, atau hapus karyawan. |
| GET | `/api/karyawan/search` | Pencarian karyawan. |
| GET, POST | `/api/leaves` | Daftar atau buat pengajuan cuti. |
| GET, PUT, DELETE | `/api/leaves/{leave}` | Detail, ubah, atau hapus cuti. |
| POST | `/api/leaves/{leave}/approve` | Setujui cuti. |
| POST | `/api/leaves/{leave}/reject` | Tolak cuti. |
| GET, POST | `/api/trainings` | Daftar atau buat data pelatihan. |
| GET, PUT, DELETE | `/api/trainings/{training}` | Detail, ubah, atau hapus pelatihan. |
| POST | `/api/trainings/{training}/enroll` | Daftar pelatihan. |
| DELETE | `/api/trainings/{training}/cancel` | Batalkan pendaftaran pelatihan. |

Lihat `routes/api.php` sebagai sumber kebenaran kontrak API. Akses endpoint terproteksi mengharuskan token Sanctum yang valid.

## Struktur proyek

```text
app/
  Http/Controllers/      Controller web dan API
  Models/                Model Eloquent
bootstrap/               Konfigurasi bootstrap Laravel
config/                  Konfigurasi aplikasi dan Sanctum
database/
  migrations/            Skema database
  seeders/               Data pengembangan
flutter_app/             Client Flutter
resources/views/         Blade views portal web
routes/
  web.php                Route portal web
  api.php                Route REST API
tests/                   Test PHPUnit
```

## Pengujian dan pemeriksaan kode

```bash
# Jalankan test Laravel
php artisan test

# Periksa coding style PHP
./vendor/bin/pint --test

# Build asset produksi
npm run build
```

## Keamanan dan deployment

- Jangan pernah commit `.env`, token Sanctum, private key, atau dump database produksi.
- Set `APP_ENV=production` dan `APP_DEBUG=false` saat deployment.
- Gunakan kredensial database unik dan kuat di production.
- Jalankan `php artisan config:cache`, `php artisan route:cache`, dan `php artisan view:cache` hanya setelah konfigurasi production final.
- Pastikan web server hanya mengekspos direktori `public/`.
- Tinjau otorisasi endpoint API sebelum membuka API ke klien publik.

## Kontribusi

1. Buat branch dari `main`.
2. Implementasikan perubahan dalam scope yang jelas.
3. Jalankan test dan build yang relevan.
4. Pastikan tidak ada secret atau artefak build lokal yang ikut di-commit.
5. Kirim pull request dengan ringkasan perubahan dan cara verifikasi.

## Lisensi

Lisensi belum ditetapkan. Jangan menggunakan atau mendistribusikan proyek ini di luar izin pemilik repository sampai file lisensi resmi ditambahkan.
