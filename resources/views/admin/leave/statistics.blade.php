@extends('admin.layout')

@section('content')

<div class="page-header mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.leave.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali">
            <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
        <h3 class="fw-bold mb-0">Statistik Cuti Karyawan</h3>
    </div>
</div>

<!-- Year Filter -->
<div class="table-container mb-4">
    <form method="GET" action="{{ route('admin.leave.statistics') }}" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label for="year" class="form-label fw-bold">Pilih Tahun</label>
            <input type="number" id="year" name="year" class="form-control"
                   value="{{ $year }}" min="2020" max="2099">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search me-1"></i>Tampilkan
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.leave.statistics') }}" class="btn btn-outline-secondary w-100">
                <i class="fas fa-redo me-1"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Statistics Summary -->
<div class="row g-3 mb-4">
    <!-- Total Karyawan -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-primary" style="animation: slideUp 0.5s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Karyawan</div>
                <div class="stat-card-value">{{ $karyawans->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Karyawan Ambil Cuti -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-info" style="animation: slideUp 0.6s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Ambil Cuti</div>
                <div class="stat-card-value">{{ $karyawans->filter(fn($k) => $k->leaves->count() > 0)->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Total Hari Cuti -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-warning" style="animation: slideUp 0.7s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Hari Cuti</div>
                <div class="stat-card-value">{{ $karyawans->sum(fn($k) => $k->leaves->sum('days_count')) }}</div>
            </div>
        </div>
    </div>

    <!-- Rata-rata Cuti -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-success" style="animation: slideUp 0.8s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
                <div class="stat-card-body">
                <div class="stat-card-label">Rata-rata Cuti</div>
                <div class="stat-card-value">
                    @if($karyawans->filter(fn($k) => $k->leaves->count() > 0)->count() > 0)
                        {{ round($karyawans->sum(fn($k) => $k->leaves->sum('days_count')) / $karyawans->filter(fn($k) => $k->leaves->count() > 0)->count(), 1) }}
                    @else
                        0
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Karyawan Detail Table -->
<div class="table-container">
    <h5 class="fw-bold mb-3">
        <i class="fas fa-list text-primary me-2"></i>Detail Cuti per Karyawan - Tahun {{ $year }}
    </h5>

    @if($karyawans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Divisi</th>
                        <th class="text-center">Jumlah Cuti</th>
                        <th class="text-center">Total Hari</th>
                        <th class="text-center">Tipe Cuti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karyawans as $karyawan)
                        @if($karyawan->leaves->count() > 0)
                            @foreach($karyawan->leaves as $index => $leave)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ $karyawan->leaves->count() }}" class="fw-bold">{{ $karyawan->nik }}</td>
                                        <td rowspan="{{ $karyawan->leaves->count() }}">{{ $karyawan->nama }}</td>
                                        <td rowspan="{{ $karyawan->leaves->count() }}">
                                            <span class="badge bg-primary">{{ $karyawan->divisi->nama ?? '-' }}</span>
                                        </td>
                                        <td rowspan="{{ $karyawan->leaves->count() }}" class="text-center fw-bold">
                                            {{ $karyawan->leaves->count() }}
                                        </td>
                                        <td rowspan="{{ $karyawan->leaves->count() }}" class="text-center fw-bold">
                                            {{ $karyawan->leaves->sum('days_count') }}
                                        </td>
                                    @endif
                                    <td>
                                        @if($leave->leave_type === 'annual')
                                            <span class="badge bg-success">Tahunan</span>
                                        @elseif($leave->leave_type === 'sick')
                                            <span class="badge bg-warning">Sakit</span>
                                        @else
                                            <span class="badge bg-info">Pribadi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach

                    @if($karyawans->filter(fn($k) => $k->leaves->count() === 0)->count() > 0)
                        @foreach($karyawans->filter(fn($k) => $k->leaves->count() === 0) as $karyawan)
                            <tr>
                                <td class="fw-bold">{{ $karyawan->nik }}</td>
                                <td>{{ $karyawan->nama }}</td>
                                <td><span class="badge bg-primary">{{ $karyawan->divisi->nama ?? '-' }}</span></td>
                                <td class="text-center">0</td>
                                <td class="text-center">0</td>
                                <td><span class="badge bg-secondary">Tidak Ada</span></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle me-2"></i>Tidak ada data cuti untuk tahun {{ $year }}
        </div>
    @endif
</div>

@endsection

@push('styles')
<style>
    .stat-card-info .stat-card-icon {
        background: rgba(23, 162, 184, 0.15);
        color: #17a2b8;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }

        .stat-card {
            padding: 12px;
        }

        .stat-card-icon {
            width: 50px !important;
            height: 50px !important;
            font-size: 1.5rem !important;
        }

        .stat-card-value {
            font-size: 1.3rem !important;
        }
    }
</style>
@endpush
