# 🔍 FILTER & SORTING DOCUMENTATION

Dokumentasi lengkap tentang sistem filtering dan sorting di Kelola Karyawan.

## Daftar Isi

1. [Filter Features](#filter-features)
2. [Sorting Options](#sorting-options)
3. [Implementation](#implementation)
4. [Examples](#examples)
5. [Mobile Support](#mobile-support)

---

## 🎯 Filter Features

### Available Filters

#### 1. Huruf Awal (A-Z)

**Purpose**: Filter nama karyawan berdasarkan huruf pertama

**Type**: Dropdown Select (26 options: A-Z)

**Backend Logic**:

```php
// File: app/Http/Controllers/Admin/DashboardController.php
if ($request->filled('huruf_awal')) {
    $huruf = strtoupper($request->huruf_awal);
    $query->whereRaw('UPPER(LEFT(nama, 1)) = ?', [$huruf]);
}
```

**SQL Query**:

```sql
WHERE UPPER(LEFT(nama, 1)) = 'A'
```

**Example**:

-   Pilih "A" → tampilkan: Andi, Agus, Ahmad, Adi
-   Pilih "B" → tampilkan: Budi, Bambang, Bayu

**UI Implementation**:

```html
<select name="huruf_awal" class="form-select">
    <option value="">Semua Nama</option>
    <option value="A">A</option>
    <option value="B">B</option>
    ...
    <option value="Z">Z</option>
</select>
```

---

#### 2. NIK (Nomor Induk Karyawan)

**Purpose**: Search karyawan berdasarkan NIK

**Type**: Text Input (partial match)

**Backend Logic**:

```php
if ($request->filled('nik')) {
    $query->where('nik', 'like', "%{$request->nik}%");
}
```

**SQL Query**:

```sql
WHERE nik LIKE '%1234%'
```

**Example**:

-   Input "1234" → tampilkan NIK: 1234567, 123456, 9999123456
-   Bersifat partial match (flexible search)

**UI Implementation**:

```html
<input type="text" name="nik" class="form-control" placeholder="NIK" />
```

---

#### 3. Divisi

**Purpose**: Filter berdasarkan divisi/departemen

**Type**: Dropdown Select (populated from database)

**Backend Logic**:

```php
if ($request->filled('divisi')) {
    $query->whereHas('divisi', function ($div) use ($request) {
        $div->where('nama', 'like', "%{$request->divisi}%");
    });
}
```

**SQL Query**:

```sql
WHERE divisi_id = 5 -- (example)
```

**Available Divisi**:

-   IT / Teknologi Informasi
-   HR / Human Resources
-   Finance / Keuangan
-   Marketing / Pemasaran
-   Operations / Operasional

**UI Implementation**:

```html
<select name="divisi" class="form-select">
    <option value="">Semua Divisi</option>
    @foreach($divisis as $divisi)
    <option value="{{ $divisi->nama }}">{{ $divisi->nama }}</option>
    @endforeach
</select>
```

---

#### 4. Jenis Kelamin

**Purpose**: Filter berdasarkan jenis kelamin

**Type**: Dropdown Select (2 options)

**Backend Logic**:

```php
if ($request->filled('jenis_kelamin')) {
    $query->where('jenis_kelamin', $request->jenis_kelamin);
}
```

**SQL Query**:

```sql
WHERE jenis_kelamin = 'Laki-laki'
```

**Options**:

-   Laki-laki
-   Perempuan

**UI Implementation**:

```html
<select name="jenis_kelamin" class="form-select">
    <option value="">Semua Jenis Kelamin</option>
    <option value="Laki-laki">Laki-laki</option>
    <option value="Perempuan">Perempuan</option>
</select>
```

---

#### 5. Status

**Purpose**: Filter berdasarkan status kepegawaian

**Type**: Dropdown Select (2 options)

**Backend Logic**:

```php
if ($request->filled('status')) {
    $statusFilter = strtolower($request->status);
    if (str_contains($statusFilter, 'non') || str_contains($statusFilter, 'tidak')) {
        $query->whereRaw("LOWER(status) LIKE ? OR LOWER(status) LIKE ?", ['%non%', '%tidak%']);
    } else {
        $query->whereRaw('LOWER(status) = ?', [$statusFilter]);
    }
}
```

**SQL Query**:

```sql
WHERE LOWER(status) = 'aktif'
```

**Options**:

-   Aktif (karyawan sedang bekerja)
-   Non-Aktif (sudah berhenti/resign)

**UI Implementation**:

```html
<select name="status" class="form-select">
    <option value="">Semua Status</option>
    <option value="Aktif">Aktif</option>
    <option value="Non-Aktif">Non-Aktif</option>
</select>
```

---

#### 6. Gaji Range (NEW!)

**Purpose**: Filter berdasarkan range gaji dengan preset options

**Type**: Dropdown Select (4 preset ranges)

**Backend Logic**:

```php
if ($request->filled('gaji_range')) {
    $range = $request->gaji_range;

    if ($range === '1-5000000') {
        $query->whereBetween('gaji', [1, 5000000]);
    } elseif ($range === '5000000-10000000') {
        $query->whereBetween('gaji', [5000000, 10000000]);
    } elseif ($range === '10000000-15000000') {
        $query->whereBetween('gaji', [10000000, 15000000]);
    } elseif ($range === '15000000+') {
        $query->where('gaji', '>=', 15000000);
    }
}
```

**SQL Queries**:

```sql
-- 1-5 Juta
WHERE gaji BETWEEN 1 AND 5000000

-- 5-10 Juta
WHERE gaji BETWEEN 5000000 AND 10000000

-- 10-15 Juta
WHERE gaji BETWEEN 10000000 AND 15000000

-- > 15 Juta
WHERE gaji >= 15000000
```

**Preset Options**:
| Label | Value | Range |
|-------|-------|-------|
| 1 - 5 Juta | `1-5000000` | Rp 1.000.000 - Rp 5.000.000 |
| 5 - 10 Juta | `5000000-10000000` | Rp 5.000.000 - Rp 10.000.000 |
| 10 - 15 Juta | `10000000-15000000` | Rp 10.000.000 - Rp 15.000.000 |
| Lebih dari 15 Juta | `15000000+` | ≥ Rp 15.000.000 |

**UI Implementation**:

```html
<select name="gaji_range" class="form-select">
    <option value="">Semua Gaji</option>
    <option value="1-5000000">1 - 5 Juta</option>
    <option value="5000000-10000000">5 - 10 Juta</option>
    <option value="10000000-15000000">10 - 15 Juta</option>
    <option value="15000000+">Lebih dari 15 Juta</option>
</select>
```

---

## 📊 Sorting Options

**Available Sort Fields**:
| Field | Value | Database Column |
|-------|-------|-----------------|
| Nama | `nama` | `karyawans.nama` |
| NIK | `nik` | `karyawans.nik` |
| Gaji | `gaji` | `karyawans.gaji` |
| Divisi | `divisi` | `divisis.nama` (relation) |
| Tanggal | `created_at` | `karyawans.created_at` |

**Sort Directions**:
| Direction | Value | Behavior |
|-----------|-------|----------|
| Menaik | `asc` | A→Z, 0→9, Terbaru (paling baru di akhir) |
| Menurun | `desc` | Z→A, 9→0, Terlama (paling baru di awal) |

**Backend Logic**:

```php
$sortBy = $request->input('sort_by', 'id');
$sortDir = $request->input('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

$karyawans = $query->orderBy($sortBy, $sortDir)
    ->paginate($perPage)
    ->withQueryString();
```

**UI Implementation**:

```html
<!-- Sort By -->
<select name="sort_by" class="form-select">
    <option value="nama" selected>Urutkan: Nama</option>
    <option value="nik">Urutkan: NIK</option>
    <option value="gaji">Urutkan: Gaji</option>
    <option value="divisi">Urutkan: Divisi</option>
    <option value="created_at">Urutkan: Tanggal</option>
</select>

<!-- Sort Direction -->
<select name="sort_dir" class="form-select">
    <option value="desc" selected>Menurun</option>
    <option value="asc">Menaik</option>
</select>
```

---

## 🔗 Implementation

### Complete Filter Form Structure

**File**: `resources/views/admin/dashboard.blade.php`

```html
<form method="GET" class="mb-4">
    <!-- Filter Row 1: Basic Filters (4 columns) -->
    <div class="row g-2 mb-3">
        <!-- Huruf Awal (A-Z) -->
        <div class="col-md-6 col-lg-2">
            <select name="huruf_awal" class="form-select">
                <option value="">Huruf Awal</option>
                @for ($i = 0; $i < 26; $i++)
                    <option value="{{ chr(65 + $i) }}" {{ request('huruf_awal') == chr(65 + $i) ? 'selected' : '' }}>
                        {{ chr(65 + $i) }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- NIK -->
        <div class="col-md-6 col-lg-2">
            <input type="text" name="nik" value="{{ request('nik') }}" class="form-control" placeholder="NIK">
        </div>

        <!-- Divisi -->
        <div class="col-md-6 col-lg-2">
            <select name="divisi" class="form-select">
                <option value="">Divisi</option>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->nama }}" {{ request('divisi') == $divisi->nama ? 'selected' : '' }}>
                        {{ $divisi->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Jenis Kelamin -->
        <div class="col-md-6 col-lg-2">
            <select name="jenis_kelamin" class="form-select">
                <option value="">Jenis Kelamin</option>
                <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
    </div>

    <!-- Filter Row 2: Advanced Filters (6 columns) -->
    <div class="row g-2 mb-3">
        <!-- Status -->
        <div class="col-md-6 col-lg-2">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Non-Aktif" {{ request('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
        </div>

        <!-- Gaji Range -->
        <div class="col-md-6 col-lg-2">
            <select name="gaji_range" class="form-select">
                <option value="">Semua Gaji</option>
                <option value="1-5000000" {{ request('gaji_range') == '1-5000000' ? 'selected' : '' }}>1 - 5 Juta</option>
                <option value="5000000-10000000" {{ request('gaji_range') == '5000000-10000000' ? 'selected' : '' }}>5 - 10 Juta</option>
                <option value="10000000-15000000" {{ request('gaji_range') == '10000000-15000000' ? 'selected' : '' }}>10 - 15 Juta</option>
                <option value="15000000+" {{ request('gaji_range') == '15000000+' ? 'selected' : '' }}>Lebih dari 15 Juta</option>
            </select>
        </div>

        <!-- Per Page -->
        <div class="col-md-6 col-lg-2">
            <select name="per_page" class="form-select">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / halaman</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / halaman</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / halaman</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / halaman</option>
            </select>
        </div>

        <!-- Sort By -->
        <div class="col-md-6 col-lg-2">
            <select name="sort_by" class="form-select">
                <option value="nama" {{ request('sort_by', 'nama') == 'nama' ? 'selected' : '' }}>Urutkan: Nama</option>
                <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>Urutkan: NIK</option>
                <option value="gaji" {{ request('sort_by') == 'gaji' ? 'selected' : '' }}>Urutkan: Gaji</option>
                <option value="divisi" {{ request('sort_by') == 'divisi' ? 'selected' : '' }}>Urutkan: Divisi</option>
                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Urutkan: Tanggal</option>
            </select>
        </div>

        <!-- Sort Direction -->
        <div class="col-md-6 col-lg-2">
            <select name="sort_dir" class="form-select">
                <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>Menurun</option>
                <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Menaik</option>
            </select>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row g-2">
        <div class="col-6 col-md-3 col-lg-2">
            <button class="btn btn-primary w-100">
                <i class="fas fa-filter me-1"></i><span class="d-none d-md-inline">Terapkan</span>
            </button>
        </div>

        <div class="col-6 col-md-3 col-lg-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-refresh me-1"></i><span class="d-none d-md-inline">Reset</span>
            </a>
        </div>
    </div>
</form>
```

### Backend Controller Logic

**File**: `app/Http/Controllers/Admin/DashboardController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::with('divisi')->whereNull('deleted_at');

        // Filter: Huruf Awal (A-Z)
        if ($request->filled('huruf_awal')) {
            $huruf = strtoupper($request->huruf_awal);
            $query->whereRaw('UPPER(LEFT(nama, 1)) = ?', [$huruf]);
        }

        // Filter: NIK
        if ($request->filled('nik')) {
            $query->where('nik', 'like', "%{$request->nik}%");
        }

        // Filter: Divisi
        if ($request->filled('divisi')) {
            $query->whereHas('divisi', function ($div) use ($request) {
                $div->where('nama', 'like', "%{$request->divisi}%");
            });
        }

        // Filter: Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter: Status
        if ($request->filled('status')) {
            $statusFilter = strtolower($request->status);
            if (str_contains($statusFilter, 'non') || str_contains($statusFilter, 'tidak')) {
                $query->whereRaw("LOWER(status) LIKE ? OR LOWER(status) LIKE ?", ['%non%', '%tidak%']);
            } else {
                $query->whereRaw('LOWER(status) = ?', [$statusFilter]);
            }
        }

        // Filter: Gaji Range
        if ($request->filled('gaji_range')) {
            $range = $request->gaji_range;

            if ($range === '1-5000000') {
                $query->whereBetween('gaji', [1, 5000000]);
            } elseif ($range === '5000000-10000000') {
                $query->whereBetween('gaji', [5000000, 10000000]);
            } elseif ($range === '10000000-15000000') {
                $query->whereBetween('gaji', [10000000, 15000000]);
            } elseif ($range === '15000000+') {
                $query->where('gaji', '>=', 15000000);
            }
        }

        // Sorting & Pagination
        $perPage = (int) $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $karyawans = $query->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        // Statistics
        $total = Karyawan::count();
        $aktif = Karyawan::where('status', 'Aktif')->count();
        $nonAktif = Karyawan::where('status', 'Non-Aktif')->count();

        return view('admin.dashboard', [
            'karyawans' => $karyawans,
            'divisis' => Divisi::all(),
            'total' => $total,
            'aktif' => $aktif,
            'nonAktif' => $nonAktif,
        ]);
    }
}
```

---

## 💡 Examples

### Example 1: Filter Nama A & Divisi IT

```
URL: /admin/dashboard?huruf_awal=A&divisi=IT
Result: Semua karyawan di divisi IT yang nama dimulai dengan A
```

### Example 2: Filter Gaji Range 5-10 Juta & Status Aktif

```
URL: /admin/dashboard?gaji_range=5000000-10000000&status=Aktif
Result: Semua karyawan aktif dengan gaji 5-10 juta, diurutkan by nama (default)
```

### Example 3: Filter NIK & Sort by Gaji Ascending

```
URL: /admin/dashboard?nik=1234&sort_by=gaji&sort_dir=asc&per_page=25
Result: 25 karyawan dengan NIK mengandung '1234', diurutkan gaji terendah ke tertinggi
```

### Example 4: Multiple Filters Combined

```
URL: /admin/dashboard?huruf_awal=B&divisi=HR&jenis_kelamin=Perempuan&status=Aktif&gaji_range=10000000-15000000&sort_by=nama&sort_dir=asc&per_page=50

Result: 50 karyawan dengan kriteria:
- Nama dimulai dengan B
- Divisi HR
- Jenis kelamin Perempuan
- Status Aktif
- Gaji 10-15 Juta
- Diurutkan nama A→Z
```

---

## 📱 Mobile Support

### Responsive Grid Layout

```css
/* Mobile (<576px) */
.col-md-6 {
    width: 50%;
} /* 2 kolom */

/* Tablet (576px) */
@media (min-width: 576px) {
    .col-md-6 {
        width: 50%;
    }
}

/* Medium (768px) */
@media (min-width: 768px) {
    .col-lg-2 {
        width: 16.67%;
    } /* 6 kolom */
}
```

### Mobile Filter Layout

**< 576px**:

-   Row 1: Huruf Awal (col-12)
-   Row 2: NIK (col-12)
-   Row 3: Divisi (col-12)
-   Row 4: JK (col-12)
-   Row 5: Status (col-12)
-   Row 6: Gaji (col-12)

**576px - 768px**:

-   Row 1: Huruf Awal, NIK (col-6)
-   Row 2: Divisi, JK (col-6)
-   Row 3: Status, Gaji (col-6)

**≥ 768px**:

-   Row 1: Huruf Awal, NIK, Divisi, JK (col-lg-3)
-   Row 2: Status, Gaji Range, Per Page, Sort By, Sort Dir (col-lg-2)

---

## 🎯 Best Practices

1. **Always include `withQueryString()`** di paginate untuk preserve filter state
2. **Use LIKE queries** untuk partial match pada text fields
3. **Use BETWEEN** untuk range queries
4. **Validate input** pada backend sebelum query
5. **Test kombinasi filters** untuk edge cases
6. **Monitor query performance** dengan database indexes

---

**Last Updated**: 30 November 2025
**Documentation Version**: 1.0
