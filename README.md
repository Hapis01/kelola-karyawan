<<<<<<< HEAD
# Kelola Karyawan - Employee Management System

<p align="center">
  <strong>Sistem Manajemen Karyawan Responsif dengan Laravel 11</strong>
</p>

---

## 📋 Daftar Isi
- [Tentang Project](#tentang-project)
- [Fitur Utama](#fitur-utama)
- [Requirement Sistem](#requirement-sistem)
- [Instalasi Step by Step](#instalasi-step-by-step)
- [Konfigurasi Database](#konfigurasi-database)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Project](#struktur-project)
- [Fitur Filtering & Sorting](#fitur-filtering--sorting)
- [Responsive Design](#responsive-design)
- [Troubleshooting](#troubleshooting)

---

## 📌 Tentang Project

**Kelola Karyawan** adalah aplikasi web manajemen karyawan yang dibangun dengan Laravel 11. Aplikasi ini dirancang untuk mengelola data karyawan dengan antarmuka yang responsif dan user-friendly, terutama untuk penggunaan mobile.

Fitur utama mencakup:
- ✅ Kelola data karyawan (Tambah, Edit, Hapus, Lihat)
- ✅ Dashboard admin dan karyawan
- ✅ System filtering dan sorting canggih dengan 6 tipe filter
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Export laporan PDF
- ✅ Autentikasi user

---

## ✨ Fitur Utama

### 1. Dashboard Admin
- 📊 Statistik total karyawan, status aktif, status non-aktif
- 📋 Tabel karyawan dengan 13 kolom yang dapat di-filter
- 📱 Sidebar responsive dengan toggle hamburger menu

### 2. Dashboard Karyawan
- 👤 Lihat profil diri sendiri
- 💰 Informasi gaji dan status
- 📅 Tanggal bergabung dan detail lainnya

### 3. Kelola Data Karyawan
**Kolom yang ditampilkan**:
- Foto karyawan
- Nama lengkap
- NIK (Nomor Induk Karyawan)
- Alamat
- No. Telepon
- Tempat Lahir
- Pendidikan terakhir
- Jenis Kelamin
- Divisi/Departemen
- Posisi/Jabatan
- Gaji bulanan
- Status (Aktif/Non-Aktif)
- Tanggal Bergabung

**Filter Canggih** (6 tipe filter yang dapat dikombinasikan):
- 🔤 **Huruf Awal Nama (A-Z)** - Filter nama dari huruf A sampai Z
- 💰 **Gaji dengan Range Presets** - 1-5 Juta, 5-10 Juta, 10-15 Juta, >15 Juta
- 🪪 **NIK** - Pencarian Nomor Induk Karyawan
- 🏢 **Divisi** - Filter berdasarkan departemen
- 👥 **Jenis Kelamin** - Laki-laki atau Perempuan
- ✅ **Status** - Aktif atau Non-Aktif

**Sorting & Pagination**:
- Urutkan: Nama, NIK, Gaji, Divisi, Tanggal (Menaik/Menurun)
- Per halaman: 10, 25, 50, 100 data

### 4. Responsive Design (Mobile First)
- **📱 Mobile (<576px)**: Sidebar collapsible, tampilan 1 kolom
- **📱 Tablet (576-768px)**: 2-3 kolom, sidebar tetap collapsible
- **💻 Laptop (768-1200px)**: 3-4 kolom, sidebar permanent
- **🖥️ Desktop (1200-1400px)**: 5 kolom, data penting
- **🖥️ HD Desktop (≥1400px)**: Semua 13 kolom terlihat sempurna

### 5. Autentikasi Keamanan
- 🔐 Login user dengan validasi
- 🔓 Logout aman
- 👤 Profile management
- 🛡️ Session management

---

## 💻 Requirement Sistem

### ⚙️ Versi Software yang Digunakan

| Software | Versi | Status |
|----------|-------|--------|
| **XAMPP** | 8.2.12 | ✅ Direkomendasikan |
| **PHP** | 8.2+ | ✅ Required |
| **MySQL** | 8.0.13+ | ✅ Required |
| **Node.js** | 18+ | ✅ Required |
| **Laravel** | 11.0 | ✅ Terinstall |
| **Composer** | 2.5+ | ✅ Required |
| **Bootstrap** | 5.3.3 | ✅ Terinstall |
| **Font Awesome** | 6.4.0 | ✅ Terinstall |
| **Vite** | 5.0 | ✅ Build tool |

### ✋ Requirement Minimal

```
✅ PHP >= 8.2 (dengan extensions: mysqli, pdo, curl, json)
✅ Composer >= 2.5 (Package manager PHP)
✅ MySQL >= 8.0.13 (atau MariaDB 10.3+)
✅ Node.js >= 18 (untuk npm/yarn)
✅ Git (untuk clone repository)
```

### 🌐 Browser yang Didukung

| Browser | Versi | Support |
|---------|-------|---------|
| Chrome | 90+ | ✅ Full |
| Firefox | 88+ | ✅ Full |
| Safari | 14+ | ✅ Full |
| Edge | 90+ | ✅ Full |
| Mobile Chrome | Latest | ✅ Full |
| Mobile Safari | Latest | ✅ Full |

---

## 📥 INSTALASI STEP BY STEP

### ⚠️ PRE-REQUISITE

**Pastikan sudah terinstall:**
1. **XAMPP** (atau PHP standalone)
2. **Composer** - Download dari [getcomposer.org](https://getcomposer.org)
3. **Node.js** - Download dari [nodejs.org](https://nodejs.org)
4. **Git** - Download dari [git-scm.com](https://git-scm.com)

**Verifikasi Installation:**
```bash
# Test PHP
php --version
# Output: PHP 8.2.12 (atau versi lebih tinggi)

# Test Composer
composer --version
# Output: Composer version 2.5.x

# Test Node.js
node --version
npm --version
# Output: v18.x.x, npm x.x.x

# Test Git
git --version
# Output: git version 2.x.x
```

---

### 📍 STEP 1: Clone Repository dari GitHub

Buka **Command Prompt / PowerShell** atau **Git Bash** dan jalankan:

```bash
# Navigasi ke folder htdocs (jika menggunakan XAMPP)
cd C:\xampp\htdocs

# Clone repository
git clone https://github.com/username/kelola-karyawan.git

# Masuk ke folder project
cd kelola-karyawan
```

**Atau** download sebagai ZIP dari GitHub dan extract ke folder htdocs.

---

### 📦 STEP 2: Install Dependencies PHP dengan Composer

```bash
# Di dalam folder kelola-karyawan
composer install
```

**Output yang diharapkan:**
```
Generating autoload files
...
✓ Project dependencies installed successfully
```

⏱️ Estimasi waktu: 2-5 menit (tergantung koneksi internet)

---

### 📚 STEP 3: Install Dependencies Node.js/JavaScript

```bash
# Di dalam folder kelola-karyawan (PowerShell/CMD)
npm install
```

**Output yang diharapkan:**
```
added xxx packages
...
✓ Packages installed successfully
```

⏱️ Estimasi waktu: 1-3 menit

---

### ⚙️ STEP 4: Setup Environment Configuration

#### **A. Buat File .env**

```bash
# Copy .env.example menjadi .env
cp .env.example .env
```

Atau di **Windows PowerShell**:
```powershell
Copy-Item .env.example .env
```

#### **B. Edit File .env**

Buka file `.env` dengan text editor (Notepad, VS Code, dll) dan sesuaikan:

```env
APP_NAME="Kelola Karyawan"
APP_ENV=local
APP_KEY=                          # Akan di-generate di step 5
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kelola_karyawan       # UBAH: Nama database yang akan dibuat
DB_USERNAME=root                  # UBAH: Username MySQL (default 'root' di XAMPP)
DB_PASSWORD=                       # UBAH: Password MySQL (kosong untuk XAMPP default)
```

**Penjelasan Konfigurasi:**
- `APP_URL`: URL aplikasi saat berjalan
- `APP_DEBUG=true`: Debug mode (ubah ke `false` di production)
- `DB_HOST`: Lokasi server database
  - `127.0.0.1` = localhost (komputer sendiri)
  - Untuk server hosting: ganti dengan IP/hostname server
- `DB_PORT`: Port MySQL (default 3306)
- `DB_DATABASE`: Nama database yang akan dibuat
- `DB_USERNAME`: Username MySQL
  - XAMPP default: `root` (tanpa password)
  - Hosting biasanya: custom username
- `DB_PASSWORD`: Password MySQL
  - XAMPP default: kosong/blank
  - Hosting: sesuai dengan setting

---

### 🔑 STEP 5: Generate Application Key

```bash
php artisan key:generate
```

**Output yang diharapkan:**
```
Application key set successfully.
```

Perintah ini akan mengisi `APP_KEY` di file `.env` secara otomatis.

---

### 🗄️ STEP 6: Setup & Konfigurasi Database

#### **A. Buat Database MySQL**

Buka **phpMyAdmin** (http://localhost/phpmyadmin) atau command line MySQL:

```sql
CREATE DATABASE kelola_karyawan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Verifikasi di phpMyAdmin:**
1. Buka http://localhost/phpmyadmin
2. Login (default: username `root`, password kosong)
3. Lihat apakah database `kelola_karyawan` sudah terbuat

#### **B. Jalankan Database Migrations**

```bash
# Di folder project
php artisan migrate
```

**Output yang diharapkan:**
```
Migrating: 2025_11_25_061454_create_karyawans_table
Migrated:  2025_11_25_061454_create_karyawans_table
...
Migration batch processed successfully.
```

Perintah ini akan membuat semua tabel yang diperlukan:
- `users` - Data user login
- `karyawans` - Data karyawan
- `divisis` - Data divisi/departemen
- `cache`, `jobs`, dll - Tabel utility Laravel

#### **C. (Optional) Isi Database dengan Sample Data**

```bash
php artisan db:seed
```

Ini akan membuat user dummy dan data karyawan contoh (berguna untuk testing).

---

### 🚀 STEP 7: Jalankan Aplikasi

Buka **2 terminal/command prompt** terpisah:

#### **Terminal 1: Jalankan PHP Development Server**

```bash
php artisan serve
```

**Output yang diharapkan:**
```
INFO  Server running on [http://127.0.0.1:8000].

Press Ctrl+C to stop the server
```

Aplikasi akan berjalan di: **http://localhost:8000**

#### **Terminal 2: Jalankan Vite (untuk live reload CSS/JS)**

```bash
npm run dev
```

**Output yang diharapkan:**
```
  VITE v5.0.0  ready in 250 ms

  ➜  Local:   http://localhost:5173/
  ➜  press h to show help
```

Vite akan mengobservasi perubahan file CSS/JS dan auto-refresh browser.

---

### ✅ STEP 8: Akses Aplikasi

1. Buka browser dan kunjungi: **http://localhost:8000**
2. Anda akan melihat halaman login
3. Login dengan credential (jika sudah di-seed):
   - **Email**: admin@example.com
   - **Password**: password

**Jika berhasil, Anda akan melihat:**
- ✅ Dashboard dengan statistik karyawan
- ✅ Tabel karyawan dengan filter dan sorting
- ✅ Sidebar yang responsive
- ✅ Mobile menu toggle jika di-resize ke ukuran mobile

---

## 🔄 TROUBLESHOOTING INSTALASI

### ❌ "Composer command not found"
**Solusi:**
1. Download Composer dari [getcomposer.org](https://getcomposer.org/download/)
2. Pastikan installer memilih "Add to PATH"
3. Restart terminal/CMD

### ❌ "npm command not found"
**Solusi:**
1. Download Node.js dari [nodejs.org](https://nodejs.org)
2. Pilih LTS version
3. Pastikan "Add to PATH" tercentang saat instalasi
4. Restart terminal/CMD

### ❌ "SQLSTATE[HY000]: General error"
**Solusi:**
1. Pastikan MySQL sedang berjalan
2. Cek konfigurasi DB di `.env` sudah benar
3. Verify database sudah dibuat:
   ```sql
   SHOW DATABASES;
   -- Pastikan kelola_karyawan ada di list
   ```

### ❌ "Class not found: App\Models\Karyawan"
**Solusi:**
```bash
composer dump-autoload
```

### ❌ "No application encryption key has been specified"
**Solusi:**
```bash
php artisan key:generate
```

---

## 🗄️ Konfigurasi Database - Detail Lengkap

### Struktur Database

#### **Tabel: users** (Untuk Login)
```sql
- id (Primary Key)
- name (Nama user)
- email (Email login - UNIQUE)
- password (Password terenkripsi)
- created_at, updated_at
```

#### **Tabel: karyawans** (Data Karyawan)
```sql
- id (Primary Key)
- nama (VARCHAR 255)
- nik (VARCHAR 20, UNIQUE)
- foto (VARCHAR 255, nullable) - Path ke file foto
- alamat (TEXT, nullable)
- no_telepon (VARCHAR 20, nullable)
- tempat_lahir (VARCHAR 100, nullable)
- tanggal_lahir (DATE, nullable)
- pendidikan (VARCHAR 50, nullable)
- jenis_kelamin (ENUM: 'Laki-laki', 'Perempuan', nullable)
- divisi_id (BIGINT, Foreign Key ke divisis)
- posisi (VARCHAR 100, nullable)
- gaji (BIGINT, nullable) - Dalam Rupiah
- status (VARCHAR 50) - Default: 'Aktif'
- keterangan (TEXT, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- deleted_at (TIMESTAMP, nullable) - Soft Delete
```

#### **Tabel: divisis** (Data Divisi/Departemen)
```sql
- id (Primary Key)
- nama (VARCHAR 255)
- created_at, updated_at
```

### Relationships

```
User (1) -----> (M) Karyawan
Divisi (1) ----> (M) Karyawan
```

---

## 🏗️ Struktur Project - File Penting

```
kelola-karyawan/
│
├── 📁 app/
│   ├── 📁 Http/Controllers/
│   │   ├── 📁 Admin/
│   │   │   ├── 🔵 DashboardController.php
│   │   │   │   └── Logic filter, sort, pagination
│   │   │   ├── 🔵 KaryawanController.php
│   │   │   │   └── CRUD karyawan
│   │   │   ├── 🔵 ProfileController.php
│   │   │   └── 🔵 UsersController.php
│   │   └── 📁 Karyawan/
│   │       └── 🔵 DashboardController.php
│   │           └── Dashboard karyawan
│   │
│   └── 📁 Models/
│       ├── 🟡 Karyawan.php
│       │   └── Model untuk tabel karyawans
│       └── 🟡 User.php
│           └── Model untuk tabel users
│
├── 📁 database/
│   ├── 📁 migrations/
│   │   ├── 📄 xxxx_create_users_table.php
│   │   ├── 📄 xxxx_create_karyawans_table.php
│   │   └── 📄 xxxx_create_divisis_table.php
│   │
│   └── 📁 seeders/
│       ├── 📄 DatabaseSeeder.php
│       └── 📄 UserSeeder.php
│
├── 📁 resources/
│   ├── 📁 css/
│   │   └── 📄 app.css (Global styles)
│   │
│   ├── 📁 js/
│   │   ├── 📄 app.js
│   │   └── 📄 bootstrap.js
│   │
│   └── 📁 views/ (Templates Blade)
│       ├── 📁 admin/
│       │   ├── 📄 dashboard.blade.php ⭐ (Main admin dashboard)
│       │   │   └── Filter, tabel, pagination
│       │   ├── 📄 layout.blade.php ⭐ (Sidebar & layout)
│       │   ├── 📄 profile.blade.php
│       │   └── 📁 users/
│       │
│       ├── 📁 karyawan/
│       │   ├── 📄 dashboard.blade.php ⭐ (Karyawan dashboard)
│       │   ├── 📄 layout.blade.php ⭐ (Karyawan sidebar)
│       │   └── 📄 profile.blade.php
│       │
│       ├── 📁 auth/
│       │   └── 📄 login.blade.php (Login page)
│       │
│       └── 📁 layouts/
│           └── 📄 app.blade.php (Base layout)
│
├── 📁 routes/
│   └── 📄 web.php (Semua route definisi)
│
├── 📁 public/
│   ├── 📄 index.php (Entry point)
│   └── 📁 assets/ (Images, uploads, dll)
│
├── 📁 config/
│   ├── 📄 app.php
│   ├── 📄 database.php
│   ├── 📄 auth.php
│   └── 📄 ...
│
├── 📄 .env (⚠️ JANGAN di-commit ke GitHub)
│   └── Konfigurasi database, APP_KEY, dll
│
├── 📄 .env.example (Template .env untuk user baru)
│
├── 📄 composer.json (PHP Dependencies)
│   └── Laravel framework, packages, dll
│
├── 📄 package.json (Node.js Dependencies)
│   └── npm packages untuk development
│
├── 📄 vite.config.js (Vite build configuration)
│
├── 📄 artisan (Laravel command CLI)
│
└── 📄 README.md (Dokumentasi ini)
```

**File Penting untuk Development:**
- ⭐ `resources/views/admin/dashboard.blade.php` - Main dashboard dengan filter
- ⭐ `app/Http/Controllers/Admin/DashboardController.php` - Filter logic
- ⭐ `resources/views/admin/layout.blade.php` - Responsive sidebar
- 📄 `.env` - Environment configuration (jangan di-commit)

---

## 🔍 Fitur Filtering & Sorting - DETAIL

### Filter yang Tersedia

#### **1️⃣ Huruf Awal Nama (A-Z)**
```
Dropdown dengan 26 opsi (A sampai Z)
Contoh: Pilih "A" → tampilkan semua karyawan nama dimulai dengan "A"
- Andi, Agus, Ahmad, dll
```

SQL Backend:
```sql
WHERE UPPER(LEFT(nama, 1)) = 'A'
```

#### **2️⃣ NIK (Nomor Induk Karyawan)**
```
Text input untuk pencarian
Contoh: Ketik "1234" → tampilkan karyawan dengan NIK mengandung "1234"
```

SQL Backend:
```sql
WHERE nik LIKE '%1234%'
```

#### **3️⃣ Divisi/Departemen**
```
Select dropdown dari data divisi di database
Pilihan: IT, HR, Finance, Operations, dll
```

SQL Backend:
```sql
WHERE divisi_id = 5 (misal)
```

#### **4️⃣ Jenis Kelamin**
```
Select dropdown: Laki-laki / Perempuan
```

SQL Backend:
```sql
WHERE jenis_kelamin = 'Laki-laki'
```

#### **5️⃣ Status**
```
Select dropdown: Aktif / Non-Aktif
```

SQL Backend:
```sql
WHERE status = 'Aktif'
```

#### **6️⃣ Gaji Range (BARU)**
```
Select dropdown dengan 4 preset range:
- 1 - 5 Juta (Rp 1.000.000 - Rp 5.000.000)
- 5 - 10 Juta (Rp 5.000.000 - Rp 10.000.000)
- 10 - 15 Juta (Rp 10.000.000 - Rp 15.000.000)
- Lebih dari 15 Juta (≥ Rp 15.000.000)
```

SQL Backend:
```sql
-- Contoh untuk "1 - 5 Juta"
WHERE gaji BETWEEN 1 AND 5000000

-- Contoh untuk "> 15 Juta"
WHERE gaji >= 15000000
```

### Kombinasi Filter

Filters dapat dikombinasikan. Contoh:
```
Huruf: "A" + Divisi: "IT" + Status: "Aktif" + Gaji: "5-10 Juta"
Hasil: Semua karyawan bernama A, di divisi IT, aktif, gaji 5-10 juta
```

### Sorting (Pengurutan)

| Opsi | Deskripsi |
|------|-----------|
| **Nama** | Urutkan berdasarkan nama karyawan (A-Z atau Z-A) |
| **NIK** | Urutkan berdasarkan Nomor Induk Karyawan |
| **Gaji** | Urutkan berdasarkan gaji (terendah ke tertinggi atau sebaliknya) |
| **Divisi** | Urutkan berdasarkan divisi |
| **Tanggal** | Urutkan berdasarkan tanggal bergabung |

**Arah Pengurutan:**
- **Menaik (ASC)**: A→Z, 1→9, Terbaru (paling baru di akhir)
- **Menurun (DESC)**: Z→A, 9→1, Terlama (terbaru di awal)

### Pagination

Pilih berapa data yang ditampilkan per halaman:
- **10** (default)
- **25**
- **50**
- **100**

### Cara Menggunakan Filter di UI

**Step 1:** Pilih filter yang diinginkan di bagian Filter Section
```
[Huruf A-Z dropdown] [NIK input] [Divisi dropdown] [JK dropdown] [Status dropdown] [Gaji Range dropdown]
```

**Step 2:** Klik tombol **"Terapkan"** (icon: filter) untuk apply filter

**Step 3:** Tabel akan di-refresh dengan data yang sesuai filter

**Step 4:** Klik **"Reset"** untuk menghapus semua filter

---

## 📱 Responsive Design - DETAIL

### CSS Breakpoints yang Digunakan

```css
/* Extra small devices (portrait phones) */
/* < 576px */

/* Small devices (landscape phones) */
@media (min-width: 576px) { ... }

/* Medium devices (tablets) */
@media (min-width: 768px) { ... }

/* Large devices (desktops) */
@media (min-width: 992px) { ... }

/* Extra large devices (large desktops) */
@media (min-width: 1200px) { ... }

/* XXL devices (extra large desktops) */
@media (min-width: 1400px) { ... }
```

### Responsive Behavior per Device

#### **📱 Mobile (< 576px)**
```
- Sidebar: Collapsible (hidden by default)
- Hamburger menu: Visible (top-left)
- Table columns: Minimal (Nama + Aksi saja)
- Filter: Stacked 1 kolom
- Grid: 1 kolom untuk cards
```

#### **📱 Tablet (576px - 768px)**
```
- Sidebar: Still collapsible
- Hamburger menu: Visible
- Table columns: Slightly more columns
- Filter: Stacked 2 kolom
- Grid: 2 kolom untuk cards
```

#### **💻 Small Laptop (768px - 992px)**
```
- Sidebar: Permanent (tidak perlu toggle)
- Table columns: Lebih banyak
- Filter: 3 kolom layout
- Padding: Increased untuk content
```

#### **💻 Desktop (992px - 1200px)**
```
- Sidebar: Full permanent
- Table columns: Kebanyakan kolom terlihat
- Filter: 4-6 kolom layout
- Table spacing: Comfortable
```

#### **🖥️ Large Desktop (1200px - 1400px)**
```
- Semua layout optimal
- Filter: Semua filters di 1-2 baris
- Table: Semua kolom terlihat kecuali Alamat (hidden d-xl-none)
```

#### **🖥️ HD Desktop (≥ 1400px)**
```
- Layout: Fully expanded
- Table columns: SEMUA 13 KOLOM TERLIHAT
- Spacing: Maximum
- Font size: 1rem (normal)
```

### Tabel Column Visibility

```
Breakpoint   | Visible Columns
─────────────┼──────────────────────────────
< 992px      | Nama, Aksi
992px-1200px | Nama, NIK, Divisi, Gaji, Status, Aksi
1200px-1400px| (+ Foto, Telepon, JK, Bergabung)
≥ 1400px     | SEMUA (Foto, Nama, NIK, Alamat, Telepon, Tempat Lahir, Pendidikan, JK, Divisi, Posisi, Gaji, Status, Bergabung)
```

### Bootstrap Utility Classes Digunakan

```html
<!-- Hide on small screens -->
<div class="d-none d-lg-table-cell">...</div>

<!-- Hide on medium screens and down -->
<div class="d-md-none">...</div>

<!-- Show only on desktop -->
<div class="d-none d-xl-block">...</div>

<!-- Responsive grid -->
<div class="col-12 col-md-6 col-lg-4 col-xl-3">...</div>

<!-- Responsive font -->
<p class="fs-6 fs-md-5 fs-lg-4">...</p>
```

### Sidebar Mobile Behavior

**HTML Structure:**
```html
<!-- Toggle button (visible on mobile) -->
<button class="toggle-sidebar" id="toggleSidebar">☰</button>

<!-- Sidebar -->
<aside id="sidebar" class="sidebar">
  <!-- Navigation links -->
</aside>

<!-- Overlay (untuk close sidebar saat klik) -->
<div id="sidebarOverlay" class="sidebar-overlay"></div>
```

**CSS Styling:**
```css
/* On mobile */
.sidebar {
  position: fixed;
  left: -250px; /* Hidden by default */
  width: 250px;
  height: 100vh;
  transition: left 0.3s ease; /* Smooth animation */
}

.sidebar.active {
  left: 0; /* Show sidebar */
}

/* On desktop (>= 768px) */
@media (min-width: 768px) {
  .sidebar {
    position: static;
    left: auto;
    width: 250px;
  }
  
  .toggle-sidebar {
    display: none; /* Hide hamburger button */
  }
}
```

**JavaScript Logic:**
```javascript
// Toggle sidebar
toggleBtn.addEventListener('click', () => {
  sidebar.classList.toggle('active');
});

// Close sidebar on link click
sidebarLinks.forEach(link => {
  link.addEventListener('click', () => {
    sidebar.classList.remove('active');
  });
});

// Auto-hide sidebar on resize to desktop
window.addEventListener('resize', () => {
  if (window.innerWidth >= 768) {
    sidebar.classList.remove('active');
  }
});
```

---

## 🛠️ Troubleshooting - Solusi Lengkap

### ❌ Class 'App\Models\Karyawan' not found

**Gejala:**
```
Fatal error: Uncaught ReflectionException: Class "App\Models\Karyawan" does not exist
```

**Penyebab:**
- Autoloader belum di-generate

**Solusi:**
```bash
composer dump-autoload
```

---

### ❌ No application encryption key has been specified

**Gejala:**
```
RuntimeException: No application encryption key has been specified.
```

**Penyebab:**
- APP_KEY belum di-generate

**Solusi:**
```bash
php artisan key:generate
```

---

### ❌ SQLSTATE[HY000]: General error: 1030

**Gejala:**
```
SQLSTATE[HY000]: General error: 1030 Got error 28
```

**Penyebab:**
- MySQL tidak running
- Database tidak terhubung
- Disk penuh

**Solusi:**
1. Pastikan MySQL running:
   ```bash
   # Windows dengan XAMPP
   xampp-control.exe  # Klik "Start" pada MySQL
   
   # Linux dengan command
   sudo service mysql start
   ```

2. Test koneksi database:
   ```bash
   # Buka MySQL client
   mysql -h127.0.0.1 -uroot
   
   # Lihat databases
   SHOW DATABASES;
   ```

3. Buat database jika belum ada:
   ```sql
   CREATE DATABASE kelola_karyawan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

---

### ❌ npm command not found

**Gejala:**
```
'npm' is not recognized as an internal or external command
```

**Penyebab:**
- Node.js belum terinstall
- Node.js tidak di-PATH

**Solusi:**
1. Download Node.js dari [nodejs.org](https://nodejs.org)
2. Install dengan "Add to PATH" option tercentang
3. Restart Command Prompt/PowerShell
4. Verify: `node --version` dan `npm --version`

---

### ❌ composer command not found

**Solusi:**
1. Download Composer dari [getcomposer.org](https://getcomposer.org)
2. Install sebagai global command
3. Restart terminal

---

### ❌ Vite hot reload tidak berfungsi

**Gejala:**
- Changes di CSS/JS tidak auto-refresh

**Solusi:**
```bash
# Pastikan terminal Vite tetap berjalan
npm run dev

# Akses aplikasi melalui Vite dev server
# http://localhost:5173 (atau port yang ditunjukkan)
```

---

### ❌ Assets tidak dimuat (CSS/JS broken)

**Gejala:**
- Layout berantakan, styles tidak terlihat

**Solusi:**
```bash
# Build assets untuk production
npm run build

# Atau rebuild
rm -rf node_modules
npm install
npm run dev
```

---

### ❌ Table tidak menampilkan data

**Gejala:**
- Tabel kosong atau "No data available"

**Solusi:**
1. Verifikasi database connection di `.env`
2. Run migrations: `php artisan migrate`
3. Seed data: `php artisan db:seed`
4. Check browser console (F12) untuk JavaScript errors

---

### ❌ Filter tidak bekerja

**Gejala:**
- Klik Terapkan tapi data tidak berubah

**Solusi:**
1. Check backend controller logic
2. Verify SQL queries di database:
   ```sql
   SELECT * FROM karyawans WHERE nama LIKE 'A%';
   ```
3. Check browser network tab (F12 → Network) apakah request terkirim

---

## 📊 Database Schema - LENGKAP

### Migration Files Location
```
database/
└── migrations/
    ├── 0001_01_01_000000_create_users_table.php
    ├── 0001_01_01_000001_create_cache_table.php
    ├── 0001_01_01_000002_create_jobs_table.php
    └── 2025_11_25_061454_create_karyawans_table.php
```

### Tabel: users

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Indexes
CREATE INDEX idx_users_email ON users(email);
```

### Tabel: karyawans

```sql
CREATE TABLE karyawans (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    
    -- Data Pribadi
    nama VARCHAR(255) NOT NULL,
    nik VARCHAR(20) UNIQUE NOT NULL,
    foto VARCHAR(255) NULL,
    alamat TEXT NULL,
    no_telepon VARCHAR(20) NULL,
    tempat_lahir VARCHAR(100) NULL,
    tanggal_lahir DATE NULL,
    pendidikan VARCHAR(50) NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NULL,
    
    -- Data Pekerjaan
    divisi_id BIGINT UNSIGNED NULL,
    posisi VARCHAR(100) NULL,
    gaji BIGINT NULL,
    status VARCHAR(50) DEFAULT 'Aktif',
    keterangan TEXT NULL,
    
    -- Timestamps
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL, -- Soft delete
    
    -- Foreign Keys
    CONSTRAINT fk_karyawans_divisi FOREIGN KEY (divisi_id) 
        REFERENCES divisis(id) ON DELETE SET NULL
);

-- Indexes untuk performa
CREATE INDEX idx_karyawans_nama ON karyawans(nama);
CREATE INDEX idx_karyawans_nik ON karyawans(nik);
CREATE INDEX idx_karyawans_divisi_id ON karyawans(divisi_id);
CREATE INDEX idx_karyawans_status ON karyawans(status);
CREATE INDEX idx_karyawans_deleted_at ON karyawans(deleted_at);
```

### Tabel: divisis

```sql
CREATE TABLE divisis (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Sample Data
INSERT INTO divisis (nama) VALUES
('IT / Teknologi Informasi'),
('HR / Human Resources'),
('Finance / Keuangan'),
('Marketing / Pemasaran'),
('Operations / Operasional');
```

---

## 🔐 Authentication - Login Details

### Login Flow

```
User → Login Page → Input Email + Password → Backend Validation → Create Session → Redirect to Dashboard
```

### Default Credentials (setelah db:seed)

| Field | Value |
|-------|-------|
| Email | admin@example.com |
| Password | password |

### User Roles

Aplikasi ini mendukung 2 role:
1. **Admin** - Dapat manage semua karyawan
2. **Karyawan** - Hanya bisa lihat profil diri sendiri

### Session Management

- Session timeout: Default 120 menit (konfigurasi di `config/session.php`)
- Logout: Hapus session dan redirect ke login page

---

## 📄 Lisensi

Project ini dilisensikan di bawah **MIT License**.

Anda bebas untuk:
- ✅ Menggunakan untuk tujuan komersial
- ✅ Memodifikasi source code
- ✅ Mendistribusikan ulang
- ✅ Menggunakan secara pribadi

Dengan syarat:
- ⚠️ Sertakan license notice
- ⚠️ Jelaskan perubahan yang dibuat

Lihat file `LICENSE` untuk detail lengkap.

---

## 👨‍💻 Kontribusi

Kami menerima kontribusi dari developer lain!

### Langkah Berkontribusi:

1. **Fork Repository**
   ```bash
   # Klik "Fork" di GitHub
   ```

2. **Clone Repository Anda**
   ```bash
   git clone https://github.com/YOUR_USERNAME/kelola-karyawan.git
   cd kelola-karyawan
   ```

3. **Buat Branch Feature**
   ```bash
   git checkout -b feature/nama-fitur
   # Contoh: feature/add-export-excel
   ```

4. **Buat Perubahan**
   ```bash
   # Edit file, tambah fitur, etc
   ```

5. **Commit Changes**
   ```bash
   git add .
   git commit -m 'Add: deskripsi fitur'
   ```

6. **Push ke Branch**
   ```bash
   git push origin feature/nama-fitur
   ```

7. **Buat Pull Request**
   - Klik "Pull Request" di GitHub
   - Jelaskan perubahan yang dilakukan
   - Tunggu review

### Convention

- **Commit Message**: `Add:`, `Fix:`, `Refactor:`, `Update:`
- **Branch Name**: lowercase, hyphen-separated
- **Code Style**: Follow existing style (PSR-12 untuk PHP)

---

## 📞 Dukungan & Support

Jika memiliki pertanyaan atau menemukan bug:

### 1. Baca Troubleshooting Section
Banyak masalah umum sudah ada solusinya

### 2. Check GitHub Issues
Buka [Issues tab](https://github.com/username/kelola-karyawan/issues) untuk melihat issue yang sudah dilaporkan

### 3. Buat Issue Baru
```
Title: [BUG] atau [FEATURE] + deskripsi singkat
Description:
- Deskripsi detail masalah
- Langkah reproduksi
- Expected vs Actual behavior
- Environment (OS, PHP version, dll)
- Error message/screenshot
```

### 4. Kontak Deve
- **Email**: developer@example.com
- **WhatsApp**: +62 xxx xxxx xxxx

---

## 📚 Referensi & Dokumentasi

### Official Documentation
- [Laravel 11 Docs](https://laravel.com/docs/11.x) - Framework utama
- [Bootstrap 5.3 Docs](https://getbootstrap.com/docs/5.3/) - CSS Framework
- [Font Awesome 6 Icons](https://fontawesome.com/icons) - Icon library
- [Vite Docs](https://vitejs.dev/) - Build tool

### Useful Resources
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Bootstrap Responsive Design](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- [MDN Web Docs](https://developer.mozilla.org/) - JavaScript/CSS reference

### Development Tools
- [VS Code](https://code.visualstudio.com/) - Code editor
- [Postman](https://www.postman.com/) - API testing
- [Navicat](https://www.navicat.com/) - Database management

---

## 🎯 Roadmap Fitur

### ✅ Completed Features
- [x] Dashboard Admin dengan statistik
- [x] Tabel karyawan dengan filtering
- [x] Responsive design mobile-first
- [x] Filter A-Z, NIK, Divisi, JK, Status, Gaji Range
- [x] Sorting & Pagination
- [x] Authentication (Login/Logout)
- [x] Sidebar responsive dengan hamburger menu

### 🔄 In Development
- [ ] Export ke Excel
- [ ] Export ke PDF dengan formatting
- [ ] Advanced analytics dashboard
- [ ] Attendance tracking
- [ ] Salary history

### 📋 Planned Features
- [ ] Mobile app (Flutter/React Native)
- [ ] Real-time notifications
- [ ] Multi-language support (EN/ID)
- [ ] Dark mode
- [ ] API REST untuk 3rd party integration

---

## 📝 Changelog

### Version 1.0.0 (2025-11-30)
- ✨ Initial release
- 🎨 Responsive design implementation
- 🔍 Advanced filtering system
- 📊 Admin dashboard with statistics
- 🔐 Authentication system

---

**Last Updated**: 30 November 2025
**Laravel Version**: 11.0
**Status**: ✅ Production Ready
**Author**: Your Name / Team Name
**Repository**: https://github.com/username/kelola-karyawan
=======
# kelola-karyawan
>>>>>>> b2ad017633037ecfe44db5009d67f55c519ba283
