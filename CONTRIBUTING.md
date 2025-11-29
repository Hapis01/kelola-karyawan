# 🤝 CONTRIBUTING GUIDE

Terima kasih karena tertarik berkontribusi pada Kelola Karyawan! Panduan ini menjelaskan cara berkontribusi.

---

## 📋 Daftar Isi

-   [Code of Conduct](#code-of-conduct)
-   [Cara Berkontribusi](#cara-berkontribusi)
-   [Development Setup](#development-setup)
-   [Git Workflow](#git-workflow)
-   [Code Standards](#code-standards)
-   [Pull Request Process](#pull-request-process)
-   [Bug Report](#bug-report)
-   [Feature Request](#feature-request)

---

## 📜 Code of Conduct

### Komitmen Kami

Kami berkomitmen menciptakan komunitas yang welcoming dan inklusif. Semua contributor diharapkan untuk:

-   🤝 Menunjukkan respect kepada semua orang
-   📝 Accept constructive criticism
-   🎯 Fokus pada yang terbaik untuk komunitas
-   ⚠️ Menunjukkan empati kepada anggota komunitas lain

### Perilaku yang Tidak Dapat Diterima

-   Harassment atau discrimination
-   Personal attacks
-   Trolling
-   Spam
-   Konten yang inappropriate atau offensive

---

## 🚀 Cara Berkontribusi

### Kontribusi Dapat Berupa

1. **Bug Fixes** - Memperbaiki bug yang ada
2. **Features** - Menambah fitur baru
3. **Documentation** - Memperbaiki atau menambah dokumentasi
4. **Tests** - Menambah test coverage
5. **Refactoring** - Meningkatkan code quality
6. **Translations** - Menerjemahkan ke bahasa lain

---

## 💻 Development Setup

### Prerequisite

Pastikan sudah memiliki:

-   PHP 8.2+
-   Composer
-   Node.js 18+
-   Git
-   MySQL 8.0+

### Setup Steps

```bash
# 1. Fork repository di GitHub
# Klik tombol "Fork" di https://github.com/username/kelola-karyawan

# 2. Clone repository Anda
git clone https://github.com/YOUR_USERNAME/kelola-karyawan.git
cd kelola-karyawan

# 3. Add upstream remote (original repository)
git remote add upstream https://github.com/username/kelola-karyawan.git

# 4. Install dependencies
composer install
npm install

# 5. Setup environment
cp .env.example .env
php artisan key:generate

# 6. Setup database
# Create database: CREATE DATABASE kelola_karyawan_dev;
php artisan migrate
php artisan db:seed

# 7. Start development servers
php artisan serve        # Terminal 1
npm run dev             # Terminal 2
```

---

## 🔀 Git Workflow

### Step-by-Step Contribution

#### **Step 1: Buat Branch Baru**

```bash
# Update local main branch
git fetch upstream
git checkout main
git pull upstream main

# Buat branch feature dengan naming convention
git checkout -b feature/nama-fitur

# Contoh nama branch yang baik:
# feature/add-export-excel
# feature/improve-filter-ui
# fix/filter-gaji-bug
# docs/update-readme
```

**Branch Naming Convention**:

```
feature/deskripsi        # Fitur baru
fix/deskripsi           # Bug fix
docs/deskripsi          # Documentation
refactor/deskripsi      # Code refactor
test/deskripsi          # Test improvement
chore/deskripsi         # Maintenance tasks
```

#### **Step 2: Buat Perubahan**

```bash
# Edit file, tambah fitur, etc.
# Pastikan mengikuti code standards (lihat section Code Standards)

# Cek file yang berubah
git status

# Stage changes
git add .

# Atau add file tertentu
git add app/Models/Karyawan.php
```

#### **Step 3: Commit dengan Pesan yang Jelas**

```bash
git commit -m "feat: add gaji range filter functionality"

# Atau lebih detail
git commit -m "feat: add gaji range filter

- Add gaji_range dropdown with 4 presets
- Implement whereBetween query logic
- Add responsive layout for mobile
- Tested on Chrome, Firefox, Safari"
```

**Commit Message Convention**:

```
feat:     untuk fitur baru
fix:      untuk bug fixes
docs:     untuk dokumentasi changes
style:    untuk code style changes (formatting, missing semicolons, dll)
refactor: untuk code refactoring tanpa menambah fitur
test:     untuk test cases
chore:    untuk dependency updates, config changes, dll
```

**Commit Message Best Practices**:

-   ✅ Gunakan imperative mood ("add" bukan "added")
-   ✅ Tidak ada periode di akhir subject line
-   ✅ Subject line max 50 karakter
-   ✅ Jelaskan WHAT dan WHY, bukan HOW
-   ✅ Reference issues/PRs jika ada: `Closes #123`

#### **Step 4: Push ke Fork Anda**

```bash
git push origin feature/nama-fitur
```

#### **Step 5: Buat Pull Request**

1. Kunjungi https://github.com/YOUR_USERNAME/kelola-karyawan
2. Klik tombol "Compare & pull request"
3. Verifikasi branch Anda dipilih
4. Isi PR title dan description
5. Klik "Create Pull Request"

---

## 📝 Code Standards

### PHP Code Standards (PSR-12)

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // ✅ Good: Proper formatting, clear method names
    public function index(Request $request)
    {
        // Use type hints
        $query = Karyawan::query();

        // Proper indentation (4 spaces)
        if ($request->filled('huruf_awal')) {
            $query->whereRaw('UPPER(LEFT(nama, 1)) = ?',
                [strtoupper($request->huruf_awal)]
            );
        }

        return view('admin.dashboard', [
            'karyawans' => $query->paginate(),
        ]);
    }

    // ✅ Good: Descriptive method name, one responsibility
    private function filterByHuruf(string $huruf): Builder
    {
        return $this->query->whereRaw(
            'UPPER(LEFT(nama, 1)) = ?',
            [strtoupper($huruf)]
        );
    }
}
```

**Laravel/PHP Standards**:

-   4 spaces indentation (bukan tabs)
-   Camelcase untuk method dan variable names
-   PascalCase untuk class names
-   Use type hints (PHP 7.0+)
-   Follow PSR-12 standard

**❌ AVOID**:

```php
// Bad: No type hints
public function process($data) { }

// Bad: Unclear variable names
$x = $request->input('q');
$result = do_something($x);

// Bad: Multiple responsibilities
public function processAndEmail($data) { }

// Bad: No spacing
if($condition){$result=calculate();}
```

### Blade Template Standards

```blade
{{-- ✅ GOOD --}}
<div class="row g-2 mb-3">
    @forelse($karyawans as $karyawan)
        <div class="col-md-6 col-lg-3">
            <h5 class="fw-bold">{{ $karyawan->nama }}</h5>
            <p class="text-muted">{{ $karyawan->posisi }}</p>
        </div>
    @empty
        <div class="col-12">
            <p class="text-center text-muted">No data available</p>
        </div>
    @endforelse
</div>

{{-- ✅ GOOD: Use @if for clarity --}}
@if(auth()->user()->isAdmin())
    <button class="btn btn-danger">Delete</button>
@endif

{{-- ❌ BAD: Complex logic in view --}}
@if($user->role == 'admin' && $user->status == 'active' && $user->posts->count() > 0)
    {{-- Too much logic --}}
@endif
```

### JavaScript/CSS Standards

```javascript
// ✅ GOOD
const toggleSidebar = () => {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
    localStorage.setItem("sidebarActive", sidebar.classList.contains("active"));
};

document.addEventListener("DOMContentLoaded", () => {
    setupEventListeners();
    restoreSidebarState();
});

// ✅ GOOD: Use modern ES6+
const filters = new Map();
filters.set("huruf_awal", request.huruf_awal);
filters.set("divisi", request.divisi);

// ❌ BAD: var keyword (outdated)
var x = document.getElementById("sidebar");

// ❌ BAD: Unclear variable names
let a = "test";
function b(c) {
    return c.length;
}
```

```css
/* ✅ GOOD: Mobile-first approach */
.sidebar {
    position: fixed;
    left: -250px;
    transition: left 0.3s ease;
}

.sidebar.active {
    left: 0;
}

@media (min-width: 768px) {
    .sidebar {
        position: static;
        left: auto;
    }
}

/* ❌ BAD: Magic numbers, no comments */
.sidebar {
    left: -250px;
    transition: 0.3s;
}
```

---

## 📤 Pull Request Process

### PR Description Template

```markdown
## Description

Jelaskan secara singkat apa yang diubah dan mengapa.

## Type of Change

-   [ ] Bug fix (non-breaking change yang memperbaiki issue)
-   [ ] New feature (non-breaking change yang add functionality)
-   [ ] Breaking change (change yang cause existing functionality tidak bekerja)
-   [ ] Documentation update

## Related Issue

Closes #(issue number)

## How Has This Been Tested?

Jelaskan langkah testing:

-   [ ] Test A: ...
-   [ ] Test B: ...
-   [ ] Test di mobile
-   [ ] Test di desktop

## Screenshots (jika applicable)

Paste screenshots dari perubahan UI

## Checklist

-   [ ] Code follows style guidelines
-   [ ] Self-review sebelum submit
-   [ ] Comments added untuk kode yang kompleks
-   [ ] Documentation updated
-   [ ] No new warnings
-   [ ] Added tests yang membuktikan fix effective
-   [ ] Passing tests locally
```

### Review Process

1. **Code Review**: Tim akan review code Anda
2. **Feedback**: Jika ada feedback, please respond
3. **Approval**: Setelah approve, akan di-merge

### After Approval

```bash
# Sync fork dengan upstream
git fetch upstream
git rebase upstream/main

# Push final changes
git push origin feature/nama-fitur
```

---

## 🐛 Bug Report

### Sebelum Report Bug

1. ✅ Pastikan ini bug, bukan feature request
2. ✅ Cek apakah bug sudah dilaporkan di Issues
3. ✅ Update ke versi terbaru (mungkin sudah fixed)
4. ✅ Cek troubleshooting section di README

### Format Bug Report

**Title**: Gunakan format: `[BUG] Deskripsi singkat`

**Description**:

```markdown
## Bug Description

Jelaskan bug secara singkat dan jelas.

## Steps to Reproduce

1. Step 1
2. Step 2
3. Step 3

## Expected Behavior

Apa yang seharusnya terjadi?

## Actual Behavior

Apa yang terjadi sebenarnya?

## Environment

-   OS: Windows 10 / MacOS / Linux
-   PHP Version: 8.2.x
-   Laravel Version: 11.x
-   Node Version: 18.x
-   Browser: Chrome 120 / Firefox 121

## Error Message

Paste full error message atau screenshot

## Additional Context

Informasi tambahan yang relevan
```

### Contoh Bug Report yang Baik

```markdown
## [BUG] Filter gaji tidak bekerja di mobile

## Description

Ketika menggunakan filter gaji range di mobile, dropdown tidak berfungsi dengan benar.

## Steps to Reproduce

1. Akses admin dashboard di mobile (< 576px)
2. Scroll ke filter section
3. Klik dropdown "Gaji Range"
4. Pilih salah satu range (misal "5-10 Juta")
5. Klik "Terapkan"

## Expected

Filter seharusnya applied dan tabel diupdate dengan data sesuai range

## Actual

Dropdown tertutup tapi filter tidak applied, tabel tetap menampilkan semua data

## Environment

-   OS: Windows 10
-   Phone: iPhone 12 Safari
-   Filter works fine di desktop Chrome

## Screenshot

[image showing the issue]
```

---

## 💡 Feature Request

### Format Feature Request

**Title**: `[FEATURE] Deskripsi fitur`

**Description**:

```markdown
## Feature Description

Jelaskan fitur yang ingin ditambahkan.

## Motivation

Mengapa fitur ini diperlukan? Apa masalah yang akan diselesaikan?

## Implementation Idea

Bagaimana cara mengimplementasikan fitur ini? (optional)

## Example Use Case

Berikan contoh konkret bagaimana fitur ini akan digunakan.

## Additional Context

Informasi tambahan, reference, atau screenshot
```

### Contoh Feature Request yang Baik

```markdown
## [FEATURE] Export karyawan ke Excel

## Description

Tambahkan fitur untuk export data karyawan ke file Excel dengan semua filter yang diterapkan.

## Motivation

User sering membutuhkan export data untuk analisis lebih lanjut di spreadsheet.
Sekarang hanya bisa export manual per row di PDF.

## Implementation Idea

-   Tambah tombol "Export to Excel" di dashboard
-   Gunakan library PhpSpreadsheet
-   Respect semua filter yang sedang diterapkan
-   Include header dengan timestamp

## Use Case

Admin ingin export semua karyawan divisi IT yang aktif ke Excel untuk presentasi.

## Additional Context

Lihat contoh di aplikasi HR lain: [link]
```

---

## 📖 Documentation Guidelines

Saat menambah dokumentasi baru:

1. **File Placement**:

    - Feature docs: `docs/features/nama-fitur.md`
    - Setup docs: Root level (README.md, SETUP.md)
    - API docs: `docs/api/`

2. **Format**:

    - Gunakan markdown dengan standard structure
    - Include code examples
    - Add table of contents untuk doc panjang
    - Update main README jika relevan

3. **Code Examples**:

    ````markdown
    ### Contoh Penggunaan

    ```php
    // Kode Anda di sini
    $karyawan = Karyawan::where('divisi', 'IT')->get();
    ```
    ````

    ```

    ```

---

## ❓ FAQ

**Q: Berapa lama approval PR?**
A: Biasanya 2-3 hari kerja, tergantung kompleksitas.

**Q: Apakah perlu membuat issue sebelum PR?**
A: Untuk bug: tidak perlu (langsung buat PR). Untuk fitur besar: sebaiknya discuss dulu.

**Q: Apa jika tidak setuju dengan feedback?**
A: Discuss secara konstruktif. Kami terbuka pada berbagai perspektif.

**Q: Apakah perlu rebase atau merge?**
A: Kami prefer rebase untuk history yang clean.

---

## 🎯 Getting Help

-   📖 Baca dokumentasi: README.md, ENVIRONMENT_SETUP.md
-   🔍 Search existing issues
-   💬 Comment di issue yang relevan
-   📧 Email ke: developer@example.com

---

## 🙏 Terima Kasih!

Terima kasih telah meluangkan waktu berkontribusi pada Kelola Karyawan!
Kontribusi Anda sangat dihargai dan membantu membuat project ini lebih baik.

**Happy coding!** 🚀

---

**Last Updated**: 30 November 2025
**Version**: 1.0
