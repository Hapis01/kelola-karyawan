@extends('admin.layout')

@section('content')

<h3 class="fw-bold mb-3">Daftar Karyawan</h3>
<p class="mb-4">Berikut adalah daftar detail karyawan PT PASIFIK ENERGI TRANS.</p>

<!-- Statistik Cards -->
<div class="row g-2 mb-4">
    <div class="col-lg-3 col-md-6 col-12">
        <div class="dashboard-card card-hover fade-in-up">
            <div class="fw-bold text-muted small">Total Karyawan</div>
            <h2 class="fw-bold text-primary mt-2">{{ $total }}</h2>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <div class="dashboard-card card-hover fade-in-up" style="animation-delay: 0.1s;">
            <div class="fw-bold text-muted small">Total Aktif</div>
            <h2 class="fw-bold text-success mt-2">{{ $aktif }}</h2>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <div class="dashboard-card card-hover fade-in-up" style="animation-delay: 0.2s;">
            <div class="fw-bold text-muted small">Total Divisi</div>
            <h2 class="fw-bold text-info mt-2">{{ $totalDivisi }}</h2>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <div class="dashboard-card card-hover fade-in-up" style="animation-delay: 0.3s;">
            <div class="fw-bold text-muted small">Total Non-Aktif</div>
            <h2 class="fw-bold text-warning mt-2">{{ $nonAktif }}</h2>
        </div>
    </div>
</div>

<!-- Tombol Tambah -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
    <button class="btn btn-primary btn-add fade-in-up" style="animation-delay: 0.4s;" data-bs-toggle="modal" data-bs-target="#addKaryawanModal">
        <i class="fas fa-plus me-2"></i>Tambah Karyawan
    </button>
    
    <div class="text-muted small">
        Menampilkan {{ $karyawans->count() }} dari {{ $karyawans->total() }} hasil
    </div>
</div>

<!-- Filter Section -->
<div class="card filter-card mb-4 fade-in-up" style="animation-delay: 0.5s;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, nik, alamat, divisi, posisi...">
            </div>

            <!-- Filter Row 1 (Mobile: 2 cols, Desktop: 4 cols) -->
            <div class="row g-2 mb-3">
                <div class="col-md-6 col-lg-2">
                    <select name="huruf_awal" class="form-select">
                        <option value="">Semua Nama (A-Z)</option>
                        <option value="A" {{ request('huruf_awal') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ request('huruf_awal') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ request('huruf_awal') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ request('huruf_awal') == 'D' ? 'selected' : '' }}>D</option>
                        <option value="E" {{ request('huruf_awal') == 'E' ? 'selected' : '' }}>E</option>
                        <option value="F" {{ request('huruf_awal') == 'F' ? 'selected' : '' }}>F</option>
                        <option value="G" {{ request('huruf_awal') == 'G' ? 'selected' : '' }}>G</option>
                        <option value="H" {{ request('huruf_awal') == 'H' ? 'selected' : '' }}>H</option>
                        <option value="I" {{ request('huruf_awal') == 'I' ? 'selected' : '' }}>I</option>
                        <option value="J" {{ request('huruf_awal') == 'J' ? 'selected' : '' }}>J</option>
                        <option value="K" {{ request('huruf_awal') == 'K' ? 'selected' : '' }}>K</option>
                        <option value="L" {{ request('huruf_awal') == 'L' ? 'selected' : '' }}>L</option>
                        <option value="M" {{ request('huruf_awal') == 'M' ? 'selected' : '' }}>M</option>
                        <option value="N" {{ request('huruf_awal') == 'N' ? 'selected' : '' }}>N</option>
                        <option value="O" {{ request('huruf_awal') == 'O' ? 'selected' : '' }}>O</option>
                        <option value="P" {{ request('huruf_awal') == 'P' ? 'selected' : '' }}>P</option>
                        <option value="Q" {{ request('huruf_awal') == 'Q' ? 'selected' : '' }}>Q</option>
                        <option value="R" {{ request('huruf_awal') == 'R' ? 'selected' : '' }}>R</option>
                        <option value="S" {{ request('huruf_awal') == 'S' ? 'selected' : '' }}>S</option>
                        <option value="T" {{ request('huruf_awal') == 'T' ? 'selected' : '' }}>T</option>
                        <option value="U" {{ request('huruf_awal') == 'U' ? 'selected' : '' }}>U</option>
                        <option value="V" {{ request('huruf_awal') == 'V' ? 'selected' : '' }}>V</option>
                        <option value="W" {{ request('huruf_awal') == 'W' ? 'selected' : '' }}>W</option>
                        <option value="X" {{ request('huruf_awal') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="Y" {{ request('huruf_awal') == 'Y' ? 'selected' : '' }}>Y</option>
                        <option value="Z" {{ request('huruf_awal') == 'Z' ? 'selected' : '' }}>Z</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <input type="text" name="nik" value="{{ request('nik') }}" class="form-control" placeholder="Filter NIK">
                </div>

                <div class="col-md-6 col-lg-2">
                    <select name="divisi" class="form-select">
                        <option value="">Semua Divisi</option>
                        @foreach($divisis as $div)
                            <option value="{{ $div->nama }}" {{ request('divisi') == $div->nama ? 'selected' : '' }}>
                                {{ $div->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">Semua JK</option>
                        <option value="Laki-Laki" {{ request('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <!-- Filter Row 2 - Status, Gaji, Per Page -->
            <div class="row g-2 mb-3">
                <div class="col-md-6 col-lg-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ request('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <select name="gaji_range" class="form-select">
                        <option value="">Semua Gaji</option>
                        <option value="1-5000000" {{ request('gaji_range') == '1-5000000' ? 'selected' : '' }}>1 - 5 Juta</option>
                        <option value="5000000-10000000" {{ request('gaji_range') == '5000000-10000000' ? 'selected' : '' }}>5 - 10 Juta</option>
                        <option value="10000000-15000000" {{ request('gaji_range') == '10000000-15000000' ? 'selected' : '' }}>10 - 15 Juta</option>
                        <option value="15000000+" {{ request('gaji_range') == '15000000+' ? 'selected' : '' }}>Lebih dari 15 Juta</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <select name="per_page" class="form-select">
                        <option value="10" {{ request('per_page',10) == 10 ? 'selected' : '' }}>10 / halaman</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / halaman</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / halaman</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / halaman</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <select name="sort_by" class="form-select">
                        <option value="nama" {{ request('sort_by','nama') == 'nama' ? 'selected' : '' }}>Urutkan: Nama</option>
                        <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>Urutkan: NIK</option>
                        <option value="gaji" {{ request('sort_by') == 'gaji' ? 'selected' : '' }}>Urutkan: Gaji</option>
                        <option value="divisi" {{ request('sort_by') == 'divisi' ? 'selected' : '' }}>Urutkan: Divisi</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Urutkan: Tanggal</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-2">
                    <select name="sort_dir" class="form-select">
                        <option value="desc" {{ request('sort_dir','desc') == 'desc' ? 'selected' : '' }}>Menurun</option>
                        <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Menaik</option>
                    </select>
                </div>
            </div>

            <!-- Filter Action Buttons -->
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
    </div>
</div>

<!-- Tabel Karyawan -->
<div class="card table-card fade-in-up" style="animation-delay: 0.6s;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="d-none d-xl-table-cell" width="55">Foto</th>
                        <th>Nama</th>
                        <th class="d-none d-lg-table-cell">NIK</th>
                        <th class="d-none d-xxl-table-cell">Alamat</th>
                        <th class="d-none d-xl-table-cell">Telepon</th>
                        <th class="d-none d-xl-table-cell">Tempat Lahir</th>
                        <th class="d-none d-xl-table-cell">Pendidikan</th>
                        <th class="d-none d-lg-table-cell">JK</th>
                        <th class="d-none d-lg-table-cell">Divisi</th>
                        <th class="d-none d-lg-table-cell">Posisi</th>
                        <th class="d-none d-lg-table-cell">Gaji</th>
                        <th class="d-none d-md-table-cell">Status</th>
                        <th class="d-none d-lg-table-cell">Bergabung</th>
                        <th width="90">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karyawans as $k)
                    <tr class="table-row-animate" style="animation-delay: {{ (0.7 + ($loop->index * 0.05)) }}s;">
                        <td class="d-none d-xl-table-cell">
                            @if($k->foto)
                                <img src="{{ asset('storage/karyawan/' . $k->foto) }}" alt="{{ $k->nama }}" 
                                     class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background-color: #007bff; color: white; font-weight: bold; font-size: 0.85rem;">
                                    {{ substr($k->nama, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">
                            {{ $k->nama }}
                            <br><small class="text-muted d-lg-none">{{ $k->nik }}</small>
                        </td>
                        <td class="d-none d-lg-table-cell small">{{ $k->nik }}</td>
                        <td class="d-none d-xxl-table-cell small">{{ Str::limit($k->alamat, 20) }}</td>
                        <td class="d-none d-xl-table-cell small">{{ $k->no_telepon ?? '-' }}</td>
                        <td class="d-none d-xl-table-cell small">{{ $k->tempat_lahir ?? '-' }}</td>
                        <td class="d-none d-xl-table-cell small">{{ $k->pendidikan ?? '-' }}</td>
                        <td class="d-none d-lg-table-cell small">
                            <span class="badge bg-info">{{ $k->jenis_kelamin }}</span>
                        </td>
                        <td class="d-none d-lg-table-cell small">
                            <span class="badge bg-primary">{{ $k->divisi->nama ?? 'N/A' }}</span>
                        </td>
                        <td class="d-none d-lg-table-cell small">{{ Str::limit($k->posisi, 12) }}</td>
                        <td class="d-none d-lg-table-cell small">
                            <strong class="text-success">Rp {{ number_format($k->gaji ?? 0, 0, ',', '.') }}</strong>
                        </td>
                        <td class="d-none d-md-table-cell small">
                            @if($k->status == 'Aktif')
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="d-none d-lg-table-cell small">{{ $k->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <!-- Edit via Modal -->
                                <button type="button" class="btn btn-sm btn-primary btn-edit-karyawan" 
                                        data-id="{{ $k->id }}" data-bs-toggle="modal" 
                                        data-bs-target="#editKaryawanModal"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Hapus -->
                                <form action="{{ route('admin.karyawan.delete', $k->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-karyawan" 
                                            data-id="{{ $k->id }}"
                                            title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-4">
    <div>
        <small class="text-muted">Menampilkan {{ $karyawans->firstItem() ?? 0 }} sampai {{ $karyawans->lastItem() ?? 0 }} dari {{ $karyawans->total() }} data</small>
    </div>

    <div>
        {{ $karyawans->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modal: Tambah Karyawan -->
<div class="modal fade" id="addKaryawanModal" tabindex="-1" aria-labelledby="addKaryawanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.karyawan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addKaryawanModalLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @include('karyawans.partials.form', ['divisis' => $divisis])
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Karyawan -->
<div class="modal fade" id="editKaryawanModal" tabindex="-1" aria-labelledby="editKaryawanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editKaryawanForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editKaryawanModalLabel">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('karyawans.partials.form', ['divisis' => $divisis])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Dashboard Card Styles */
    .dashboard-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    /* Action Buttons Styles */
    .btn-primary, .btn-danger {
        font-weight: 600;
        border: none;
        border-radius: 6px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 12px rgba(0, 86, 179, 0.3);
        transform: translateY(-2px);
    }

    .btn-danger:hover {
        background-color: #c82333;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        transform: translateY(-2px);
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }

    /* Filter Card */
    .filter-card {
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
    }
    
    /* Table Card */
    .table-card {
        border: none;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    
    /* Table Styles */
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        background-color: #2c3e50;
        color: white;
        border: none;
        padding: 12px 15px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table-row:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-color: #f1f1f1;
    }
    
    /* Button Styles */
    .btn-add {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 123, 255, 0.3);
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }
    
    /* Badge Styles */
    .badge {
        font-size: 0.75em;
        padding: 5px 8px;
    }
    
    /* Pagination Styles */
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        border-radius: 5px;
        margin: 0 3px;
        border: 1px solid #dee2e6;
    }
    
    .page-item.active .page-link {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .dashboard-card {
            padding: 15px;
        }

        .dashboard-card h2 {
            font-size: 1.5rem;
        }

        .table thead th {
            padding: 10px;
            font-size: 0.8rem;
        }

        .table tbody td {
            padding: 10px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-card {
            margin-bottom: 12px;
            padding: 12px;
        }

        .dashboard-card h2 {
            font-size: 1.3rem;
        }

        .btn-add {
            width: 100%;
        }

        .table-responsive {
            font-size: 0.85rem;
        }

        .table thead th {
            padding: 8px;
            font-size: 0.75rem;
        }

        .table tbody td {
            padding: 8px;
            font-size: 0.85rem;
        }

        .btn-sm {
            padding: 0.3rem 0.5rem;
            font-size: 0.75rem;
        }

        .badge {
            font-size: 0.65rem;
        }

        .filter-card .row {
            row-gap: 8px;
        }

        h3 {
            font-size: 1.3rem;
        }

        p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .content {
            padding: 12px;
        }

        .dashboard-card {
            padding: 10px;
        }

        .dashboard-card h2 {
            font-size: 1.1rem;
        }

        .dashboard-card .small {
            font-size: 0.7rem;
        }

        .table-responsive {
            font-size: 0.75rem;
        }

        .table thead th {
            padding: 6px;
            font-size: 0.65rem;
        }

        .table tbody td {
            padding: 6px;
            font-size: 0.75rem;
        }

        .btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
        }

        .btn-sm {
            padding: 0.2rem 0.4rem;
        }

        h3 {
            font-size: 1.1rem;
        }

        .filter-card .card-body {
            padding: 12px;
        }

        .form-control, .form-select {
            font-size: 0.85rem;
        }
    }

    /* Custom breakpoint for xxl (1400px+) - show alamat column */
    @media (min-width: 1400px) {
        .d-xxl-table-cell {
            display: table-cell !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Edit modal logic
    document.addEventListener('DOMContentLoaded', function() {
        const editModalEl = document.getElementById('editKaryawanModal');
        if (!editModalEl) return;
        const editForm = document.getElementById('editKaryawanForm');

        // When clicking edit button, fetch data and fill the form
        document.querySelectorAll('.btn-edit-karyawan').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                // set form action
                editForm.action = `{{ url('/admin/karyawan') }}/${id}/update`;

                fetch(`{{ url('/admin/karyawan') }}/${id}/edit`, { headers: { 'X-Requested-With':'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(data => {
                        if (!data) return;
                        // Fill fields, ensure names match partial form
                        const set = (name, val) => {
                            const el = editForm.querySelector(`[name="${name}"]`);
                            if (!el) return;
                            if (el.tagName === 'SELECT') {
                                el.value = val ?? '';
                            } else {
                                el.value = val ?? '';
                            }
                        };
                        set('nama', data.nama);
                        set('nik', data.nik);
                        set('alamat', data.alamat);
                        set('jenis_kelamin', data.jenis_kelamin);
                        set('divisi_id', data.divisi_id);
                        set('posisi', data.posisi);
                        set('gaji', data.gaji ? parseInt(data.gaji) : '');
                        set('status', data.status);
                        set('keterangan', data.keterangan);
                        set('no_telepon', data.no_telepon);
                        set('tanggal_lahir', data.tanggal_lahir);
                        set('tempat_lahir', data.tempat_lahir);
                        set('pendidikan', data.pendidikan);
                    })
                    .catch(console.error);
            });
        });

        // Reset form when modal hidden
        editModalEl.addEventListener('hidden.bs.modal', function() {
            if (editForm) editForm.reset();
        });

        // Delete button with SweetAlert
        document.querySelectorAll('.btn-delete-karyawan').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                const karyawanName = this.closest('tr').querySelector('td:nth-child(2)')?.textContent?.trim() || 'Karyawan';

                Swal.fire({
                    title: 'Hapus Karyawan?',
                    html: `Anda yakin ingin menghapus <strong>${karyawanName}</strong>?<br><small class="text-muted">Data akan dipindahkan ke history dan tidak dapat dikembalikan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Add animation to table rows on load
        const tableRows = document.querySelectorAll('.table-row-animate');
        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
        });
    });
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes tableRowAnimate {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .table-row-animate {
        opacity: 0;
        animation: tableRowAnimate 0.5s ease-out forwards !important;
    }
</style>
@endpush