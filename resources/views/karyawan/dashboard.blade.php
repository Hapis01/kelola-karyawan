@extends('karyawan.layout')

@section('content')

<h3 class="fw-bold mb-3">Dashboard Saya</h3>
<p class="mb-4">Selamat datang {{ Auth::user()->name }}. Berikut adalah data profil dan informasi karyawan Anda.</p>

<!-- Statistik Cards -->
<div class="row g-2 mb-4">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="dashboard-card">
            <div class="fw-bold text-muted small">Status</div>
            <h2 class="fw-bold text-{{ $karyawan->status === 'Aktif' ? 'success' : 'danger' }} mt-2">{{ $karyawan->status }}</h2>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="dashboard-card">
            <div class="fw-bold text-muted small">Divisi</div>
            <h2 class="fw-bold text-primary mt-2">{{ $karyawan->divisi->nama }}</h2>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="dashboard-card">
            <div class="fw-bold text-muted small">Posisi</div>
            <h2 class="fw-bold text-info mt-2">{{ $karyawan->posisi }}</h2>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="dashboard-card">
            <div class="fw-bold text-muted small">Gaji Pokok</div>
            <h4 class="fw-bold text-success mt-2">Rp {{ number_format($karyawan->gaji ?? 0, 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="d-grid gap-2 d-md-flex mb-4">
    <a href="{{ route('karyawan.profile') }}" class="btn btn-primary flex-fill flex-md-grow-0">
        <i class="fas fa-user me-2"></i>Lihat Profil
    </a>
    <a href="{{ route('karyawan.id-card', ['id' => $karyawan->id]) }}" target="_blank" class="btn btn-outline-primary flex-fill flex-md-grow-0">
        <i class="fas fa-download me-2"></i>Unduh Kartu
    </a>
</div>

<!-- Info Karyawan Card -->
<div class="table-container">
    <h5 class="fw-bold mb-3"><i class="fas fa-briefcase text-primary me-2"></i>Informasi Pekerjaan</h5>
    
    <div class="table-responsive">
        <table class="table table-sm table-borderless">
            <tbody>
                <tr>
                    <td class="fw-bold" style="width: 35%;">Nama Lengkap</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->nama }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Nomor Induk</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->nik }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Divisi</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td><span class="badge bg-primary">{{ $karyawan->divisi->nama }}</span></td>
                </tr>
                <tr>
                    <td class="fw-bold">Posisi</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->posisi }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Status</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>
                        @if($karyawan->status === 'Aktif')
                            <span class="badge bg-success rounded-pill"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                        @else
                            <span class="badge bg-danger rounded-pill"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold">Gaji Pokok</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td><strong class="text-success">Rp {{ number_format($karyawan->gaji ?? 0, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Info Pribadi Card -->
<div class="table-container">
    <h5 class="fw-bold mb-3"><i class="fas fa-id-card text-info me-2"></i>Informasi Pribadi</h5>
    
    <div class="table-responsive">
        <table class="table table-sm table-borderless">
            <tbody>
                <tr>
                    <td class="fw-bold" style="width: 35%;">Jenis Kelamin</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Alamat</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->alamat }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Email</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td><a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></td>
                </tr>
                <tr>
                    <td class="fw-bold">Bergabung</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->created_at->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">Update</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->updated_at->format('d F Y H:i') }}</td>
                </tr>
                @if($karyawan->keterangan)
                <tr>
                    <td class="fw-bold">Keterangan</td>
                    <td class="d-none d-md-table-cell">:</td>
                    <td>{{ $karyawan->keterangan }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- History Section -->
@if(count($histories) > 0)
<div class="table-container">
    <h5 class="fw-bold mb-3"><i class="fas fa-history text-warning me-2"></i>Riwayat Perubahan</h5>
    
    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                    <th class="d-none d-md-table-cell">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $history)
                <tr>
                    <td class="small">{{ $history->created_at->format('d M Y') }}</td>
                    <td>
                        @if($history->action === 'create')
                            <span class="badge bg-success"><i class="fas fa-plus me-1"></i>Tambah</span>
                        @elseif($history->action === 'update')
                            <span class="badge bg-warning text-dark"><i class="fas fa-edit me-1"></i>Update</span>
                        @else
                            <span class="badge bg-danger"><i class="fas fa-trash me-1"></i>Hapus</span>
                        @endif
                    </td>
                    <td class="d-none d-md-table-cell small">
                        @if($history->action === 'create')
                            Data ditambahkan
                        @elseif($history->action === 'update')
                            Data diperbarui
                        @else
                            Data dihapus
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    .dashboard-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 15px rgba(0,0,0,0.3) !important;
    }

    .table-container {
        margin-bottom: 20px;
    }

    .table-container h5 {
        color: #2c3e50;
    }

    .table th {
        background-color: #2c3e50 !important;
        color: white;
        font-size: 0.9rem;
    }

    .table td {
        vertical-align: middle;
        padding: 0.75rem;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .btn {
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dashboard-card {
            margin-bottom: 10px;
        }

        .table-container {
            margin-bottom: 15px;
        }

        .table th {
            font-size: 0.8rem;
        }

        .table td {
            padding: 0.5rem;
        }

        .badge {
            font-size: 0.75rem;
        }

        .table-responsive {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .row.g-2 {
            gap: 0.5rem !important;
        }

        .dashboard-card {
            padding: 12px;
        }

        .dashboard-card h2 {
            font-size: 1.25rem;
        }

        .dashboard-card h4 {
            font-size: 1rem;
        }

        .table-container {
            padding: 12px;
        }

        .table-responsive {
            font-size: 0.75rem;
        }

        .table th {
            font-size: 0.7rem;
            padding: 0.4rem;
        }

        .table td {
            padding: 0.4rem;
        }

        h5 {
            font-size: 1rem;
        }

        .badge {
            font-size: 0.65rem;
        }
    }
</style>
@endpush
