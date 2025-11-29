# 🔧 ENVIRONMENT SETUP GUIDE

Panduan lengkap setup environment untuk mengembangkan Kelola Karyawan.

## Daftar Isi

-   [Instalasi Software](#instalasi-software)
-   [Konfigurasi Environment](#konfigurasi-environment)
-   [Database Setup](#database-setup)
-   [Verifikasi Installation](#verifikasi-installation)
-   [Troubleshooting](#troubleshooting)

---

## 💻 Instalasi Software

### 1. PHP 8.2+ (Standalone atau XAMPP)

#### **Option A: XAMPP (Recommended untuk Beginners)**

1. Download XAMPP 8.2.12 dari [apachefriends.org](https://www.apachefriends.org/download.html)
2. Install dengan lokasi default: `C:\xampp`
3. Jalankan `xampp-control.exe`
4. Klik "Start" untuk Apache dan MySQL

**Verification**:

```bash
php --version
# Output: PHP 8.2.12 (or higher)
```

#### **Option B: PHP Standalone**

1. Download PHP 8.2+ dari [php.net](https://www.php.net/downloads.php)
2. Extract ke folder (misal: `C:\php`)
3. Tambahkan ke PATH (Environment Variables)
4. Install extensions yang diperlukan

**Verification**:

```bash
php --version
```

---

### 2. MySQL 8.0.13+ (included in XAMPP)

Jika menggunakan XAMPP, MySQL sudah included.

#### **Standalone MySQL Installation**

1. Download dari [mysql.com](https://dev.mysql.com/downloads/mysql/)
2. Install community server
3. Setup root password saat instalasi
4. Tambahkan `bin` folder ke PATH

**Verification**:

```bash
mysql --version
# Output: mysql Ver 8.0.x
```

---

### 3. Composer (PHP Package Manager)

1. Download installer dari [getcomposer.org](https://getcomposer.org/download/)
2. Jalankan installer
3. Pilih opsi "Install for all users"
4. Ketika diminta, select PHP executable yang sudah diinstall

**Verification**:

```bash
composer --version
# Output: Composer version 2.5.x
```

---

### 4. Node.js 18+ (termasuk npm)

1. Download LTS version dari [nodejs.org](https://nodejs.org/)
2. Jalankan installer dengan default settings
3. Pastikan "Add to PATH" tercentang
4. Klik Install

**Verification**:

```bash
node --version
# Output: v18.x.x

npm --version
# Output: x.x.x
```

---

### 5. Git (Version Control)

1. Download dari [git-scm.com](https://git-scm.com/download/win)
2. Jalankan installer dengan default settings
3. Selesai instalasi

**Verification**:

```bash
git --version
# Output: git version 2.x.x
```

---

### 6. Text Editor / IDE

**Recommended Options**:

#### **VS Code** (Lightweight & Popular)

-   Download dari [code.visualstudio.com](https://code.visualstudio.com)
-   Install extensions:
    -   PHP Intelephense
    -   Laravel Blade Snippets
    -   Prettier
    -   ES7+ React/Redux snippets

#### **PhpStorm** (Full-featured IDE)

-   Download dari [jetbrains.com](https://www.jetbrains.com/phpstorm/)
-   Berbayar tapi ada free trial 30 hari
-   Intellisense lebih baik

#### **Sublime Text** (Fast & Lightweight)

-   Download dari [sublimetext.com](https://www.sublimetext.com)
-   Install Package Control untuk extensions

---

## ⚙️ Konfigurasi Environment

### Step 1: Clone Repository

```bash
# Pilih folder untuk project
cd C:\Users\YourName\Documents

# Clone dari GitHub
git clone https://github.com/username/kelola-karyawan.git

# Masuk ke folder project
cd kelola-karyawan
```

### Step 2: Install PHP Dependencies

```bash
# Jalankan Composer
composer install

# Output yang diharapkan:
# Installing dependencies from lock file
# ...
# Installing 150 packages
# Done in 2m 34s
```

⏱️ First time install: 2-5 menit (tergantung kecepatan internet)

### Step 3: Install Node.js Dependencies

```bash
# Jalankan npm
npm install

# Output yang diharapkan:
# added 500 packages in 30s
```

⏱️ Estimasi waktu: 1-3 menit

### Step 4: Setup .env File

```bash
# Copy template
cp .env.example .env
```

**Edit `.env` file** dengan text editor:

```env
# === APPLICATION ===
APP_NAME="Kelola Karyawan"
APP_ENV=local
APP_KEY=                          # Will be generated in next step
APP_DEBUG=true
APP_URL=http://localhost:8000

# === LOGGING ===
LOG_CHANNEL=stack
LOG_LEVEL=debug

# === DATABASE ===
DB_CONNECTION=mysql
DB_HOST=127.0.0.1                # Localhost
DB_PORT=3306                      # Default MySQL port
DB_DATABASE=kelola_karyawan       # Database name
DB_USERNAME=root                  # MySQL username (XAMPP default: root)
DB_PASSWORD=                       # MySQL password (XAMPP default: empty)

# === CACHE ===
CACHE_DRIVER=file
CACHE_STORE=file

# === SESSION ===
SESSION_DRIVER=file
SESSION_LIFETIME=120

# === QUEUE ===
QUEUE_CONNECTION=sync

# === MAIL ===
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Penjelasan Konfigurasi Database**:

| Setting     | Default XAMPP   | Penjelasan                            |
| ----------- | --------------- | ------------------------------------- |
| DB_HOST     | 127.0.0.1       | Alamat server database (localhost)    |
| DB_PORT     | 3306            | Port MySQL (standard)                 |
| DB_DATABASE | kelola_karyawan | Nama database yang akan dibuat        |
| DB_USERNAME | root            | Username MySQL XAMPP                  |
| DB_PASSWORD | (kosong)        | Password MySQL XAMPP (default kosong) |

### Step 5: Generate Application Key

```bash
php artisan key:generate

# Output:
# Application key set successfully.
```

Perintah ini auto-generate dan mengisi `APP_KEY` di `.env`.

### Step 6: Buat Database

#### **Method 1: phpMyAdmin (GUI)**

1. Buka http://localhost/phpmyadmin
2. Login (username: `root`, password: kosong)
3. Klik menu "Databases"
4. Input: `kelola_karyawan`
5. Collation: `utf8mb4_unicode_ci`
6. Klik "Create"

#### **Method 2: MySQL CLI**

```bash
# Open MySQL client
mysql -u root -p

# Enter password (leave blank for XAMPP default)

# Create database
CREATE DATABASE kelola_karyawan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Verify
SHOW DATABASES;

# Exit
exit
```

### Step 7: Jalankan Migrations

```bash
php artisan migrate

# Output:
# Migrating: 2025_11_25_000000_create_users_table
# Migrated:  2025_11_25_000000_create_users_table
# Migrating: 2025_11_25_000001_create_cache_table
# Migrated:  2025_11_25_000001_create_cache_table
# Migrating: 2025_11_25_030249_create_karyawans_table
# Migrated:  2025_11_25_030249_create_karyawans_table
```

Ini akan membuat semua tabel yang diperlukan.

### Step 8: (Optional) Seed Data

```bash
php artisan db:seed

# Output:
# Seeding: Database\Seeders\DatabaseSeeder
# Seeded:  Database\Seeders\DatabaseSeeder
```

Ini akan mengisi data dummy untuk testing.

---

## 🗄️ Database Setup - Detail

### Database Connection Test

```bash
# Test dari command line
php artisan tinker

# Di dalam tinker (PHP REPL)
>>> DB::connection()->getPdo();
// Output: PDOConnection object (jika berhasil)
// Error: jika gagal connect
```

### Check Created Tables

```bash
# Di MySQL client
mysql> USE kelola_karyawan;
mysql> SHOW TABLES;

# Expected output:
# | Tables in kelola_karyawan |
# |---------------------------|
# | cache                      |
# | cache_locks                |
# | divisis                    |
# | failed_jobs                |
# | jobs                       |
# | job_batches                |
# | karyawans                  |
# | migrations                 |
# | password_reset_tokens      |
# | sessions                   |
# | users                      |
```

### Verify Table Structure

```bash
# Lihat struktur table karyawans
mysql> DESCRIBE karyawans;

# Expected columns:
# | Field         | Type                              |
# |---------------|-----------------------------------|
# | id            | bigint unsigned                   |
# | nama          | varchar(255)                      |
# | nik           | varchar(20)                       |
# | foto          | varchar(255)                      |
# | alamat        | longtext                          |
# | no_telepon    | varchar(20)                       |
# | tempat_lahir  | varchar(100)                      |
# | tanggal_lahir | date                              |
# | pendidikan    | varchar(50)                       |
# | jenis_kelamin | enum('Laki-laki','Perempuan')    |
# | divisi_id     | bigint unsigned                   |
# | posisi        | varchar(100)                      |
# | gaji          | bigint                            |
# | status        | varchar(50)                       |
# | keterangan    | longtext                          |
# | created_at    | timestamp                         |
# | updated_at    | timestamp                         |
# | deleted_at    | timestamp                         |
```

---

## ✅ Verifikasi Installation

### Check All Requirements

```bash
# Create verification script: check-requirements.php
php -v                    # Check PHP version (need 8.2+)
php -m | grep mysqli      # Check mysqli extension
php -m | grep pdo_mysql   # Check PDO MySQL extension
composer --version        # Check Composer
node --version            # Check Node.js
npm --version             # Check npm
git --version             # Check Git
```

### Test Application

**Terminal 1: Jalankan Server**

```bash
php artisan serve

# Output:
# INFO  Server running on [http://127.0.0.1:8000].
# Press Ctrl+C to stop the server
```

**Terminal 2: Jalankan Vite**

```bash
npm run dev

# Output:
#   VITE v5.0.0  ready in 250 ms
#
#   ➜  Local:   http://localhost:5173/
#   ➜  press h to show help
```

**Browser: Akses Aplikasi**

```
http://localhost:8000
```

### Checklist Verifikasi

```
✅ PHP versi 8.2+
✅ MySQL running dan dapat diakses
✅ Database kelola_karyawan tersedia
✅ Semua migrations sudah dijalankan
✅ Composer dependencies terinstall
✅ npm packages terinstall
✅ .env file sudah ter-setup
✅ APP_KEY sudah di-generate
✅ Aplikasi dapat diakses di http://localhost:8000
✅ Assets loading dengan benar (Vite running)
✅ Database connection works
```

---

## 🛠️ Troubleshooting

### Error: "PHP not found"

**Solusi**:

1. Pastikan PHP sudah terinstall
2. Tambahkan PHP ke PATH:
    - Windows: Control Panel → System → Environment Variables
    - Cari PATH, edit, tambahkan: `C:\xampp\php` (atau lokasi PHP Anda)
3. Restart Command Prompt

### Error: "Composer not found"

**Solusi**:

1. Download installer dari getcomposer.org
2. Jalankan installer
3. Pada prompt "PHP executable", pilih php.exe Anda

### Error: "npm not found"

**Solusi**:

1. Install Node.js dari nodejs.org
2. Restart terminal
3. Verify: `npm --version`

### Error: "SQLSTATE connection refused"

**Solusi**:

1. Pastikan MySQL running (cek XAMPP Control Panel)
2. Verifikasi credentials di `.env`:
    - DB_HOST: 127.0.0.1
    - DB_PORT: 3306
    - DB_USERNAME: root
    - DB_PASSWORD: (kosong untuk XAMPP)
3. Create database: `CREATE DATABASE kelola_karyawan;`

### Error: "Column not found in karyawans"

**Solusi**:

```bash
php artisan migrate:fresh
php artisan db:seed
```

### Very Slow npm install

**Solusi**:

```bash
# Gunakan npm cache buster
npm cache clean --force

# Atau gunakan yarn
npm install -g yarn
yarn install
```

---

## 🚀 Development Workflow

### Startup Checklist

```bash
# 1. Navigate to project
cd C:\xampp\htdocs\kelola-karyawan

# 2. Ensure MySQL running (XAMPP Control Panel)

# 3. Start Laravel server (Terminal 1)
php artisan serve

# 4. Start Vite development (Terminal 2)
npm run dev

# 5. Open browser
# http://localhost:8000
```

### Daily Development

```bash
# Make changes to files
# Vite auto-watches CSS/JS changes
# Laravel auto-reloads routes

# Test database changes
php artisan migrate

# Run seeders
php artisan db:seed

# Check logs
php artisan log:tail

# Run tests (jika ada)
php artisan test
```

### Before Deployment

```bash
# Build assets
npm run build

# Run migrations on production
php artisan migrate --force

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📚 Helpful Commands

```bash
# Laravel Commands
php artisan list                  # List all commands
php artisan migrate               # Run migrations
php artisan migrate:fresh         # Reset & re-migrate
php artisan db:seed              # Run seeders
php artisan tinker               # Interactive PHP shell
php artisan serve                # Start dev server
php artisan route:list           # List all routes

# Composer Commands
composer install                  # Install dependencies
composer update                   # Update dependencies
composer dump-autoload           # Rebuild autoloader

# npm Commands
npm install                      # Install packages
npm run dev                       # Start Vite dev server
npm run build                    # Build for production
npm list                         # List installed packages
```

---

**Last Updated**: 30 November 2025
**Environment Version**: 1.0
