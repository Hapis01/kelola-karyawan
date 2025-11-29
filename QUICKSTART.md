# 📋 INSTALASI CEPAT - Quick Start Guide

Panduan singkat untuk setup project **Kelola Karyawan** dalam 5 menit.

## ⚡ Quick Steps

### 1. Clone & Install

```bash
git clone https://github.com/username/kelola-karyawan.git
cd kelola-karyawan
composer install
npm install
```

### 2. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup

```bash
# Buat database
mysql -u root -e "CREATE DATABASE kelola_karyawan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Jalankan migrations
php artisan migrate

# (Optional) Seed data
php artisan db:seed
```

### 4. Run Application

**Terminal 1:**

```bash
php artisan serve
```

**Terminal 2:**

```bash
npm run dev
```

### 5. Access

Buka browser: **http://localhost:8000**

---

## 🔧 Konfigurasi .env Penting

```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kelola_karyawan
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📊 Versi Software

| Tool     | Version | Command              |
| -------- | ------- | -------------------- |
| PHP      | 8.2+    | `php --version`      |
| MySQL    | 8.0+    | `mysql --version`    |
| Node.js  | 18+     | `node --version`     |
| Composer | 2.5+    | `composer --version` |

---

## 🐛 Common Issues

| Error                | Solution                       |
| -------------------- | ------------------------------ |
| DB Connection Failed | Cek `.env` DB\_\* settings     |
| npm not found        | Install Node.js                |
| Artisan key error    | Run `php artisan key:generate` |
| Assets broken        | Run `npm run build`            |

---

📖 Lihat **README.md** untuk dokumentasi lengkap!
