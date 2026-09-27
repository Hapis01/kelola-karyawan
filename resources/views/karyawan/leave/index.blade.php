@extends('karyawan.layout')

@section('content')

<div class="page-header mb-4">
    <div class="row align-items-center g-2">
        <div class="col">
            <h3 class="fw-bold mb-0">Pengajuan Cuti</h3>
        </div>
        <div class="col-auto">
            <a href="{{ route('karyawan.leave.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i><span class="d-none d-sm-inline">Ajukan Cuti</span><span class="d-sm-none">Ajukan</span>
            </a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="animation: slideDown 0.5s ease;">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="animation: slideDown 0.5s ease;">
        <i class="fas fa-times-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Leave Balance Cards with Animations -->
<div class="row g-3 mb-4">
    <!-- Card 1: Sisa Cuti Tahunan -->
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card border-light shadow-sm" style="animation: slideUp 0.5s ease; border-left: 4px solid #28a745;">
            <div class="card-body text-center py-3">
                <div style="font-size: 1.8rem; color: #28a745; margin-bottom: 0.5rem;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h6 class="text-muted mb-2" style="font-size: 0.9rem;">Cuti Tahunan Tersisa</h6>
                <h3 class="fw-bold text-success mb-0">{{ $annualLeaveRemaining }}</h3>
                <small class="text-muted">dari 12 hari</small>
            </div>
        </div>
    </div>

    <!-- Card 2: Cuti Dalam Proses -->
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card border-light shadow-sm" style="animation: slideUp 0.6s ease; border-left: 4px solid #ffc107;">
            <div class="card-body text-center py-3">
                <div style="font-size: 1.8rem; color: #ffc107; margin-bottom: 0.5rem;">
                    <i class="fas fa-clock"></i>
                </div>
                <h6 class="text-muted mb-2" style="font-size: 0.9rem;">Cuti Dalam Proses</h6>
                <h3 class="fw-bold text-warning mb-0">{{ $pending_count }}</h3>
                <small class="text-muted">menunggu persetujuan</small>
            </div>
        </div>
    </div>

    <!-- Card 3: Cuti Disetujui -->
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card border-light shadow-sm" style="animation: slideUp 0.7s ease; border-left: 4px solid #17a2b8;">
            <div class="card-body text-center py-3">
                <div style="font-size: 1.8rem; color: #17a2b8; margin-bottom: 0.5rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h6 class="text-muted mb-2" style="font-size: 0.9rem;">Cuti Disetujui</h6>
                <h3 class="fw-bold text-info mb-0">{{ $approved_count }}</h3>
                <small class="text-muted">tahun {{ date('Y') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="table-container mb-4" style="animation: slideUp 0.8s ease;">
    <form method="GET" action="{{ route('karyawan.leave.index') }}" class="row g-2">
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="leave_type" class="form-select form-select-sm">
                <option value="">Semua Tipe</option>
                <option value="annual" {{ request('leave_type') === 'annual' ? 'selected' : '' }}>Cuti Tahunan</option>
                <option value="sick" {{ request('leave_type') === 'sick' ? 'selected' : '' }}>Cuti Sakit</option>
                <option value="personal" {{ request('leave_type') === 'personal' ? 'selected' : '' }}>Cuti Pribadi</option>
                <option value="other" {{ request('leave_type') === 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                <i class="fas fa-search me-1"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Leave List -->
<div class="table-container">
    @if ($leaves->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Tipe Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr class="align-middle" style="animation: fadeIn 0.5s ease;">
                            <td class="fw-bold">
                                @switch($leave->leave_type)
                                    @case('annual')
                                        <span class="badge bg-info">
                                            <i class="fas fa-calendar me-1"></i>Cuti Tahunan
                                        </span>
                                        @break
                                    @case('sick')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-hospital me-1"></i>Cuti Sakit
                                        </span>
                                        @break
                                    @case('personal')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-user me-1"></i>Cuti Pribadi
                                        </span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-tag me-1"></i>{{ ucfirst($leave->leave_type) }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</small>
                            </td>
                            <td><strong>{{ $leave->days_count }} hari</strong></td>
                            <td>
                                @if ($leave->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-hourglass-half me-1"></i>Menunggu
                                    </span>
                                @elseif($leave->status === 'approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @elseif($leave->status === 'rejected')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-ban me-1"></i>Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('karyawan.leave.show', $leave->id) }}"
                                       class="btn btn-outline-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($leave->status === 'pending')
                                        <a href="{{ route('karyawan.leave.edit', $leave->id) }}"
                                           class="btn btn-outline-secondary btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                onclick="cancelLeave({{ $leave->id }})" title="Batalkan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @elseif($leave->status === 'approved')
                                        <button type="button" class="btn btn-outline-warning btn-sm"
                                                onclick="cancelLeave({{ $leave->id }})" title="Batalkan">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $leaves->links() }}
        </div>
    @else
        <div class="text-center py-5" style="animation: fadeIn 0.6s ease;">
            <i class="fas fa-calendar-check text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Belum ada pengajuan cuti</p>
            <a href="{{ route('karyawan.leave.create') }}" class="btn btn-primary btn-sm mt-2">
                <i class="fas fa-plus me-2"></i>Ajukan Cuti Pertama
            </a>
        </div>
    @endif
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Batalkan Cuti
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Apakah Anda yakin ingin membatalkan pengajuan cuti ini?</p>
                <p class="text-muted small mb-0">
                    <i class="fas fa-info-circle me-1"></i>Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="cancelForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-warning btn-sm text-dark fw-bold">
                        <i class="fas fa-ban me-1"></i>Batalkan Cuti
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function cancelLeave(leaveId) {
    const cancelModal = new bootstrap.Modal(document.getElementById('cancelModal'));
    const cancelForm = document.getElementById('cancelForm');
    cancelForm.action = `/karyawan/leave/${leaveId}/cancel`;
    cancelModal.show();
}
</script>

@push('styles')
<style>
    /* Slide Up Animation */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Slide Down Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Fade In Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Table Row Hover Effect */
    .table tbody tr {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Card Hover Effect */
    .card {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .card:hover {
        border-color: #007bff !important;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15) !important;
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Button Hover Effects */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            margin-bottom: 1rem;
        }

        .btn-group-sm {
            width: 100%;
        }
    }
</style>
@endpush

@endsection
