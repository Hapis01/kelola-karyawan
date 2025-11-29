@extends('admin.layout')

@section('content')

<h3 class="fw-bold mb-3">History Karyawan</h3>
<p class="mb-4">Riwayat lengkap semua perubahan data karyawan termasuk penambahan, perubahan, dan penghapusan.</p>

<!-- Filter Section -->
<div class="card filter-card mb-4 fade-in-up">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.history') }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search nama karyawan...">
                </div>

                <div class="col-md-2">
                    <input type="text" name="karyawan_nama" value="{{ request('karyawan_nama') }}" class="form-control" placeholder="Filter Nama">
                </div>

                <div class="col-md-2">
                    <select name="action" class="form-select">
                        <option value="">Semua Aksi</option>
                        <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Penambahan</option>
                        <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Perubahan</option>
                        <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Penghapusan</option>
                    </select>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-12 d-flex gap-2 flex-wrap">
                    <div class="me-2">
                        <select name="per_page" class="form-select">
                            <option value="10" {{ request('per_page',10) == 10 ? 'selected' : '' }}>10 / halaman</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / halaman</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / halaman</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / halaman</option>
                        </select>
                    </div>

                    <div class="me-2">
                        <select name="sort_by" class="form-select">
                            <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Urutkan: ID</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Urutkan: Tanggal</option>
                            <option value="karyawan_nama" {{ request('sort_by') == 'karyawan_nama' ? 'selected' : '' }}>Urutkan: Nama</option>
                        </select>
                    </div>

                    <div class="me-2">
                        <select name="sort_dir" class="form-select">
                            <option value="desc" {{ request('sort_dir','desc') == 'desc' ? 'selected' : '' }}>Menurun</option>
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Menaik</option>
                        </select>
                    </div>

                    <div class="me-2">
                        <button class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i>Terapkan
                        </button>
                    </div>

                    <div>
                        <a href="{{ route('admin.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- History Table -->
<div class="card table-card fade-in-up" style="animation-delay: 0.1s;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="80">Aksi</th>
                        <th width="150">Subjek</th>
                        <th>Detail Perubahan</th>
                        <th width="160">Waktu</th>
                        <th width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                    <tr class="table-row-animate" style="animation-delay: {{ ($loop->index * 0.05) }}s;">
                        <td>
                            @if($history->action == 'create')
                                <span class="badge bg-success rounded-pill">
                                    <i class="fas fa-plus me-1"></i>Tambah
                                </span>
                            @elseif($history->action == 'update')
                                <span class="badge bg-warning text-dark rounded-pill">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </span>
                            @else
                                <span class="badge bg-danger rounded-pill">
                                    <i class="fas fa-trash-alt me-1"></i>Hapus
                                </span>
                            @endif
                        </td>
                        <td class="fw-bold">
                            @if($history->type == 'karyawan')
                                <i class="fas fa-id-card me-1 text-primary"></i>{{ $history->karyawan_nama }}
                            @else
                                <i class="fas fa-user-lock me-1 text-info"></i>{{ $history->user_email }}
                            @endif
                        </td>
                        <td>
                            @if($history->action == 'create')
                                @if($history->type == 'karyawan')
                                    <span class="text-success">✓ Karyawan baru ditambahkan ke sistem</span>
                                @else
                                    <span class="text-success">✓ User akun baru ditambahkan ke sistem</span>
                                @endif
                            @elseif($history->action == 'delete')
                                @if($history->type == 'karyawan')
                                    <span class="text-danger">✕ Karyawan dihapus dari sistem</span>
                                @else
                                    <span class="text-danger">✕ User akun dihapus dari sistem</span>
                                @endif
                            @else
                                @php
                                    $changes = [];
                                    if ($history->old_data && $history->new_data) {
                                        foreach ($history->new_data as $key => $newVal) {
                                            if (isset($history->old_data[$key]) && $history->old_data[$key] != $newVal) {
                                                $changes[] = $key;
                                            }
                                        }
                                    }
                                @endphp
                                @if(count($changes) > 0)
                                    <span class="text-warning">⚠ {{ count($changes) }} field diubah</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $history->created_at->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td>
                            @if($history->action == 'update' && ($history->old_data || $history->new_data))
                                <button type="button" class="btn btn-sm btn-info toggle-detail" data-target="detail-{{ $history->id }}" title="Lihat detail perubahan">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            @endif
                        </td>
                    </tr>

                    <!-- Detail Row untuk Update -->
                    @if($history->action == 'update')
                    <tr id="detail-{{ $history->id }}" class="detail-row d-none">
                        <td colspan="5">
                            <div class="detail-content p-4 bg-light">
                                <h6 class="mb-3"><i class="fas fa-list-ul me-2"></i>Detail Perubahan Data</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="200">Field</th>
                                                <th>Nilai Sebelumnya</th>
                                                <th>Nilai Baru</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $fieldLabels = [
                                                    'nama' => 'Nama',
                                                    'nik' => 'NIK',
                                                    'alamat' => 'Alamat',
                                                    'no_telepon' => 'No. Telepon',
                                                    'jenis_kelamin' => 'Jenis Kelamin',
                                                    'tanggal_lahir' => 'Tanggal Lahir',
                                                    'tempat_lahir' => 'Tempat Lahir',
                                                    'pendidikan' => 'Pendidikan',
                                                    'divisi_id' => 'Divisi',
                                                    'posisi' => 'Posisi',
                                                    'gaji' => 'Gaji',
                                                    'status' => 'Status',
                                                    'keterangan' => 'Keterangan',
                                                    'foto' => 'Foto',
                                                ];

                                                $userFieldLabels = [
                                                    'name' => 'Nama User',
                                                    'email' => 'Email',
                                                    'password' => 'Password',
                                                ];

                                                // Helper function untuk format value
                                                $formatValue = function($key, $value) use ($divisis) {
                                                    if ($key === 'divisi_id' && !empty($value)) {
                                                        return isset($divisis[$value]) ? $divisis[$value]->nama : "ID: {$value}";
                                                    }
                                                    if ($key === 'gaji' && !empty($value)) {
                                                        return 'Rp ' . number_format($value, 0, ',', '.');
                                                    }
                                                    if ($key === 'tanggal_lahir' && !empty($value)) {
                                                        return \Carbon\Carbon::parse($value)->format('d/m/Y');
                                                    }
                                                    return $value ?? '-';
                                                };
                                            @endphp
                                            @if($history->type == 'karyawan')
                                                @foreach($fieldLabels as $key => $label)
                                                    @if(isset($history->old_data[$key]) || isset($history->new_data[$key]))
                                                        @php
                                                            $oldVal = $history->old_data[$key] ?? null;
                                                            $newVal = $history->new_data[$key] ?? null;
                                                        @endphp
                                                        @if($oldVal != $newVal)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $label }}</strong>
                                                            </td>
                                                            <td>
                                                                <div class="bg-danger bg-opacity-10 p-2 rounded">
                                                                    <code>{{ $formatValue($key, $oldVal) }}</code>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="bg-success bg-opacity-10 p-2 rounded">
                                                                    <code>{{ $formatValue($key, $newVal) }}</code>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($userFieldLabels as $key => $label)
                                                    @if(isset($history->old_data[$key]) || isset($history->new_data[$key]))
                                                        @php
                                                            $oldVal = $history->old_data[$key] ?? null;
                                                            $newVal = $history->new_data[$key] ?? null;
                                                        @endphp
                                                        @if($oldVal != $newVal)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $label }}</strong>
                                                            </td>
                                                            <td>
                                                                <div class="bg-danger bg-opacity-10 p-2 rounded">
                                                                    <code>{{ $formatValue($key, $oldVal) }}</code>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="bg-success bg-opacity-10 p-2 rounded">
                                                                    <code>{{ $formatValue($key, $newVal) }}</code>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="fas fa-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p class="mt-3 mb-0">Belum ada history</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-4">
    <div>
        <small class="text-muted">Menampilkan {{ $histories->firstItem() ?? 0 }} sampai {{ $histories->lastItem() ?? 0 }} dari {{ $histories->total() }} data</small>
    </div>

    <div>
        {{ $histories->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection

@push('styles')
<style>
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
    
    /* Badge Styles */
    .badge {
        font-size: 0.8em;
        padding: 6px 10px;
        font-weight: 600;
    }
    
    /* Detail Row Styles */
    .detail-row {
        transition: all 0.3s ease;
    }

    .detail-row.d-none {
        display: none !important;
    }

    .detail-content {
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
    }

    .detail-content table th {
        background-color: #e9ecef;
        font-weight: 600;
        border: none;
    }

    .detail-content table td {
        padding: 10px;
        border-color: #dee2e6;
    }

    .detail-content code {
        color: #666;
        font-size: 0.9em;
        word-break: break-all;
    }

    /* Toggle Button Styles */
    .toggle-detail {
        padding: 4px 8px;
        transition: all 0.3s ease;
        border: 1px solid #0d6efd;
        background: white;
        color: #0d6efd;
    }

    .toggle-detail:hover {
        background-color: #0d6efd;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
    }

    .toggle-detail.active i {
        transform: rotate(180deg);
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .table-row {
        animation: fadeIn 0.5s ease-out;
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

    code {
        display: inline-block;
        border-radius: 3px;
    }

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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }

        .detail-content {
            padding: 0.5rem !important;
        }

        .detail-content table {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle detail row visibility
        document.querySelectorAll('.toggle-detail').forEach(btn => {
            btn.addEventListener('click', function() {
                const target = document.getElementById(this.getAttribute('data-target'));
                if (target) {
                    target.classList.toggle('d-none');
                    this.classList.toggle('active');
                    
                    // Update icon rotation
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.style.transform = target.classList.contains('d-none') ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                }
            });
        });
    });
</script>
@endpush
