@extends('admin.layout')

@section('content')

<div class="page-header mb-4">
    <div class="row align-items-center g-2">
        <div class="col">
            <h3 class="fw-bold mb-0">Manajemen Pengajuan Cuti</h3>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.leave.statistics') }}" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar me-2"></i><span class="d-none d-sm-inline">Statistik</span><span class="d-sm-none">Stats</span>
            </a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="table-container mb-4">
    <form method="GET" action="{{ route('admin.leave.index') }}" class="row g-2">
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="leave_type" class="form-select form-select-sm">
                <option value="">Semua Tipe</option>
                <option value="annual" {{ request('leave_type') === 'annual' ? 'selected' : '' }}>Tahunan</option>
                <option value="sick" {{ request('leave_type') === 'sick' ? 'selected' : '' }}>Sakit</option>
                <option value="personal" {{ request('leave_type') === 'personal' ? 'selected' : '' }}>Pribadi</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="nik" class="form-control form-control-sm"
                   placeholder="NIK/Nama..." value="{{ request('nik') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="year" class="form-control form-control-sm"
                   placeholder="Tahun" value="{{ request('year', date('Y')) }}" min="2020" max="2099">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                <i class="fas fa-search me-1"></i>Filter
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.leave.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-redo me-1"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <!-- Menunggu Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-warning" style="animation: slideUp 0.5s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Menunggu Persetujuan</div>
                <div class="stat-card-value">{{ $pending_count }}</div>
            </div>
        </div>
    </div>

    <!-- Disetujui Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-success" style="animation: slideUp 0.6s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Disetujui</div>
                <div class="stat-card-value">{{ $approved_count }}</div>
            </div>
        </div>
    </div>

    <!-- Ditolak Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-danger" style="animation: slideUp 0.7s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Ditolak</div>
                <div class="stat-card-value">{{ $rejected_count }}</div>
            </div>
        </div>
    </div>

    <!-- Total Card -->
    <div class="col-lg-3 col-md-6 col-12">
        <div class="stat-card stat-card-primary" style="animation: slideUp 0.8s ease;">
            <div class="stat-card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Pengajuan</div>
                <div class="stat-card-value">{{ $leaves->total() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Leave List -->
<div class="table-container">
    @if ($leaves->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
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
                        <tr class="align-middle">
                            <td class="fw-bold">{{ $leave->nik }}</td>
                            <td>{{ $leave->karyawan->nama }}</td>
                            <td>
                                @switch($leave->leave_type)
                                    @case('annual')
                                        <span class="badge bg-info">Tahunan</span>
                                        @break
                                    @case('sick')
                                        <span class="badge bg-danger">Sakit</span>
                                        @break
                                    @case('personal')
                                        <span class="badge bg-warning text-dark">Pribadi</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($leave->leave_type) }}</span>
                                @endswitch
                            </td>
                            <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                            <td><strong>{{ $leave->days_count }}</strong></td>
                            <td>
                                @if ($leave->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($leave->status === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($leave->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.leave.show', $leave->id) }}"
                                       class="btn btn-outline-primary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($leave->status === 'pending')
                                        <button type="button" class="btn btn-outline-success"
                                                onclick="approveLeave({{ $leave->id }})" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger"
                                                onclick="rejectLeave({{ $leave->id }})" title="Tolak">
                                            <i class="fas fa-times"></i>
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
        <div class="text-center py-5">
            <i class="fas fa-calendar-check text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Tidak ada pengajuan cuti</p>
        </div>
    @endif
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Setujui Cuti</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menyetujui cuti ini?</p>
                    <div class="mb-3">
                        <label for="approve_notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="approve_notes" name="admin_notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tolak Cuti</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda ingin menolak cuti ini?</p>
                    <div class="mb-3">
                        <label for="reject_notes" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reject_notes" name="admin_notes" rows="3" required></textarea>
                        <small class="text-muted">Minimal 10 karakter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveLeave(leaveId) {
    document.getElementById('approveForm').action = `/admin/leave/${leaveId}/approve`;
    new bootstrap.Modal(document.getElementById('approveModal')).show();
}

function rejectLeave(leaveId) {
    document.getElementById('rejectForm').action = `/admin/leave/${leaveId}/reject`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

@push('styles')
<style>
    /* Slide Up Animation untuk Statistics Cards */
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

    /* Fade In Animation untuk Table */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Pulse Animation untuk Badges */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    /* Slide In dari Kanan untuk Modal */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Table row hover effect */
    .table tbody tr {
        animation: fadeIn 0.5s ease;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Status Badge Styling */
    .badge {
        animation: fadeIn 0.5s ease;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* Modal Animation */
    .modal.fade .modal-dialog {
        animation: slideInRight 0.3s ease;
    }

    /* Button Hover Effects */
    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Card Border Effects */
    .card {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        border-color: #007bff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }

    /* Text Color Animations */
    .text-warning {
        animation: pulse 2s ease-in-out infinite;
    }

    /* Filter Section Animation */
    .filter-section {
        animation: slideUp 0.6s ease;
    }

    /* Pagination Animation */
    .pagination {
        animation: fadeIn 0.5s ease;
    }

    /* Responsive untuk Mobile */
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
    }
</style>
@endpush

@endsection
