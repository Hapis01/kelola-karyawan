@extends('karyawan.layout')

@section('content')

<h3 class="fw-bold mb-3">Profil Saya</h3>
<p class="mb-4">Berikut adalah detail lengkap profil dan data pribadi karyawan Anda.</p>

<!-- Profile Cards -->
<div class="row g-2">
    <!-- Left Column - Foto dan Info Dasar -->
    <div class="col-lg-4 col-12">
        <div class="table-container">
            <div style="text-align: center;">
                @if($karyawan->foto)
                    <img src="{{ asset('storage/karyawan/' . $karyawan->foto) }}" alt="{{ $karyawan->nama }}" 
                         style="width: 100%; max-width: 300px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                @else
                    <div style="width: 100%; max-width: 300px; height: 300px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 80px; font-weight: bold; margin: 0 auto 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        {{ substr($karyawan->nama, 0, 1) }}
                    </div>
                @endif
                
                <h4 class="fw-bold mb-2">{{ $karyawan->nama }}</h4>
                <p class="text-muted">{{ $karyawan->nik }}</p>
                <p class="text-muted mb-4">{{ $karyawan->posisi }}</p>

                <a href="{{ route('karyawan.id-card', ['id' => $karyawan->id]) }}" target="_blank" class="btn btn-primary w-100">
                    <i class="fas fa-download me-2"></i>Cetak Kartu
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column - Data Lengkap -->
    <div class="col-lg-8 col-12">
        <!-- Informasi Pekerjaan -->
        <div class="table-container">
            <h5 class="fw-bold mb-3"><i class="fas fa-briefcase text-primary me-2"></i>Informasi Pekerjaan</h5>
            
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold" style="width: 30%;">Nama Lengkap</td>
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

        <!-- Informasi Pribadi -->
        <div class="table-container">
            <h5 class="fw-bold mb-3"><i class="fas fa-user text-info me-2"></i>Informasi Pribadi</h5>
            
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold" style="width: 30%;">Jenis Kelamin</td>
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
    </div>
</div>

@endsection

@push('styles')
<style>
    .table-container {
        background: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0px 3px 10px rgba(0,0,0,0.15);
    }

    .table-container h5 {
        color: #2c3e50;
    }

    .table th {
        background-color: #2c3e50 !important;
        color: white;
    }

    .table td {
        padding: 12px 15px;
        border-color: #f1f1f1;
    }

    .table-borderless td {
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

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .row.g-2 {
            gap: 0.75rem !important;
        }

        .table-container {
            margin-bottom: 15px;
            padding: 15px;
        }
    }

    @media (max-width: 768px) {
        .row.g-2 {
            gap: 0.5rem !important;
        }

        .table-container {
            margin-bottom: 12px;
            padding: 12px;
        }

        .table-container h5 {
            font-size: 1rem;
        }

        .table-responsive {
            font-size: 0.85rem;
        }

        .table-borderless td {
            padding: 0.5rem;
        }

        .btn {
            padding: 8px 12px;
            font-size: 0.9rem;
        }

        h3 {
            font-size: 1.3rem;
        }

        p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .table-container {
            padding: 10px;
            margin-bottom: 10px;
        }

        .table-container h5 {
            font-size: 0.95rem;
        }

        .table-responsive {
            font-size: 0.75rem;
        }

        .table-borderless td {
            padding: 0.4rem;
        }

        .btn {
            padding: 6px 10px;
            font-size: 0.85rem;
        }

        h3 {
            font-size: 1.1rem;
        }

        .badge {
            font-size: 0.7rem;
        }

        img {
            max-width: 250px !important;
        }
    }
</style>
@endpush
