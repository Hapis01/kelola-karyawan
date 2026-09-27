@extends('karyawan.layout')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('karyawan.dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <h3 class="fw-bold mb-0">Profil Saya</h3>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Personal Info Card -->
        <div class="card border-light shadow-sm mb-4" style="animation: fadeIn 0.5s ease;">
            <div class="card-header bg-primary text-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-user-circle me-2"></i>Informasi Pribadi
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-3 text-center">
                        <img src="{{ $karyawan->foto ? asset('storage/karyawan/' . $karyawan->foto) : asset('assets/images/default-avatar.png') }}"
                             alt="Foto Profil"
                             style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #10185f;">
                    </div>
                    <div class="col-md-9">
                        <h5 class="fw-bold text-primary mb-2">{{ $karyawan->nama }}</h5>
                        <p class="text-muted mb-1"><strong>NIK:</strong> {{ $karyawan->nik }}</p>
                        <p class="text-muted mb-1"><strong>Posisi:</strong> {{ $karyawan->posisi }}</p>
                        <p class="text-muted"><strong>Divisi:</strong> {{ $karyawan->divisi->nama ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1"><strong>Nama Lengkap</strong></p>
                        <p class="mb-3">{{ $karyawan->nama }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1"><strong>Nomor Telepon</strong></p>
                        <p class="mb-3">{{ $karyawan->no_telepon ?? '-' }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="text-muted small mb-1"><strong>Alamat</strong></p>
                    <p class="mb-3">{{ $karyawan->alamat ?? '-' }}</p>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1"><strong>Tempat Lahir</strong></p>
                        <p class="mb-3">{{ $karyawan->tempat_lahir ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1"><strong>Tanggal Lahir</strong></p>
                        <p class="mb-3">{{ $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->format('d F Y') : '-' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1"><strong>Jenis Kelamin</strong></p>
                        <p class="mb-3">{{ $karyawan->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1"><strong>Pendidikan Terakhir</strong></p>
                        <p class="mb-3">{{ $karyawan->pendidikan ?? '-' }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="text-muted small mb-1"><strong>Jurusan / Program Studi</strong></p>
                    <p class="mb-3">{{ $karyawan->jurusan ?? '-' }}</p>
                </div>

                <div class="alert alert-info alert-dismissible fade show mb-0" role="alert" style="background: linear-gradient(135deg, #e7f3ff 0%, #f0f8ff 100%); border: 1px solid #b3d9ff;">
                    <i class="fas fa-edit me-2" style="color: #0066cc;"></i>
                    <strong style="color: #0066cc;">Untuk mengedit profil Anda,</strong> klik tombol "Edit Profil" di bawah.
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mb-4">
            <a href="{{ route('karyawan.profile.edit') }}" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-edit me-2"></i>Edit Profil
            </a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Work Info Card -->
        <div class="card border-light shadow-sm mb-3" style="animation: fadeIn 0.6s ease;">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-briefcase text-primary me-2"></i>Data Pekerjaan
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <small><strong>NIK:</strong></small><br>
                        <small class="text-muted">{{ $karyawan->nik }}</small>
                    </li>
                    <li class="mb-2">
                        <small><strong>Posisi:</strong></small><br>
                        <small class="text-muted">{{ $karyawan->posisi }}</small>
                    </li>
                    <li class="mb-2">
                        <small><strong>Divisi:</strong></small><br>
                        <small class="text-muted">{{ $karyawan->divisi->nama ?? 'N/A' }}</small>
                    </li>
                    <li class="mb-0">
                        <small><strong>Status:</strong></small><br>
                        <span class="badge {{ $karyawan->status === 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                            {{ $karyawan->status }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Gaji Card -->
        <div class="card border-light shadow-sm mb-3" style="animation: fadeIn 0.7s ease;">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-money-bill text-success me-2"></i>Data Kompensasi
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-1"><strong>Gaji Pokok</strong></p>
                <h5 class="fw-bold text-success mb-0">
                    Rp {{ number_format($karyawan->gaji ?? 0, 0, ',', '.') }}
                </h5>
            </div>
        </div>

        <!-- Change History Link -->
        <div class="card border-light shadow-sm" style="animation: fadeIn 0.8s ease;">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-history text-info me-2"></i>Riwayat Perubahan
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Lihat semua perubahan profil yang telah Anda ajukan dan status persetujuannya.
                </p>
                <a href="{{ route('karyawan.profile.history') }}" class="btn btn-sm btn-info w-100">
                    <i class="fas fa-arrow-right me-1"></i>Lihat Riwayat
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush

@endsection
